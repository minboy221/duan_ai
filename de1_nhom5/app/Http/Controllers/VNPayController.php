<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\GiaoDich;
use App\Models\KhoanThu;
use App\Models\TongKetTaiChinh;
use App\Models\VNPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VNPayController extends Controller
{
    /**
     * Create VNPay Payment URL
     */
    public function createPayment(Request $request)
    {
        $request->validate([
            'so_tien' => 'required|numeric|min:1000',
            'noi_dung' => 'required|string|max:255',
            'loai_giao_dich' => 'required|in:thu_nhap,chi_tieu',
        ]);

        $userId = Auth::id();
        // VNPay requires time in GMT+7 (Asia/Ho_Chi_Minh)
        $startTime = \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->format('YmdHis');
        $expire = \Carbon\Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(15)->format('YmdHis');
        $orderId = 'VNP' . $userId . '_' . time();

        // 1. Create VNPay Transaction record
        VNPay::create([
            'nguoi_dung_id' => $userId,
            'ma_don_hang' => $orderId,
            'so_tien' => $request->so_tien,
            'noi_dung' => $request->noi_dung,
            'loai_giao_dich' => $request->loai_giao_dich,
            'trang_thai' => 0, // Pending
        ]);

        // 2. Prepare VNPay parameters
        $vnp_Config = config('vnpay');
        $vnp_Data = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_Config['tmn_code'],
            "vnp_Amount" => $request->so_tien * 100, // Amount in cents
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $startTime,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $request->ip(),
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => $request->noi_dung,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Config['return_url'],
            "vnp_TxnRef" => $orderId,
            "vnp_ExpireDate" => $expire,
        ];

        if ($request->filled('bank_code')) {
            $vnp_Data['vnp_BankCode'] = $request->bank_code;
        }

        ksort($vnp_Data);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($vnp_Data as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Config['url'] . "?" . $query;
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_Config['hash_secret']);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'success',
                'payment_url' => $vnp_Url,
                'order_id' => $orderId
            ]);
        }

        return redirect()->away($vnp_Url);
    }

    /**
     * Handle VNPay IPN (Instant Payment Notification)
     */
    public function vnpayIPN(Request $request)
    {
        $vnp_Config = config('vnpay');
        $vnp_HashSecret = $vnp_Config['hash_secret'];
        $inputData = $request->all();
        $vnp_SecureHash = $request->vnp_SecureHash;
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        
        if ($secureHash !== $vnp_SecureHash) {
            return response()->json(["RspCode" => "97", "Message" => "Invalid Signature"]);
        }

        $orderId = $request->vnp_TxnRef;
        $vnpayTranId = $request->vnp_TransactionNo;
        $vnp_ResponseCode = $request->vnp_ResponseCode;
        $vnp_Amount = $request->vnp_Amount / 100;

        $vnpay = VNPay::where('ma_don_hang', $orderId)->first();

        if (!$vnpay) {
            return response()->json(["RspCode" => "01", "Message" => "Order Not Found"]);
        }

        if ($vnpay->so_tien != $vnp_Amount) {
            return response()->json(["RspCode" => "04", "Message" => "Invalid Amount"]);
        }

        if ($vnpay->trang_thai != 0) {
            return response()->json(["RspCode" => "02", "Message" => "Order already confirmed"]);
        }

        try {
            DB::beginTransaction();

            if ($vnp_ResponseCode == '00') {
                $vnpay->update([
                    'trang_thai' => 1,
                    'ma_giao_dich_vnpay' => $vnpayTranId
                ]);

                // 3. Sync with Ledger (KhoanThu or GiaoDich)
                $categoryName = 'Giao dịch VNPay';
                $category = DanhMuc::firstOrCreate(
                    [
                        'nguoi_dung_id' => $vnpay->nguoi_dung_id,
                        'ten_danh_muc' => $categoryName,
                        'loai' => ($vnpay->loai_giao_dich == 'thu_nhap') ? 'thu' : 'chi'
                    ],
                    ['biu_tuong' => 'payments']
                );

                if ($vnpay->loai_giao_dich == 'thu_nhap') {
                    KhoanThu::create([
                        'nguoi_dung_id' => $vnpay->nguoi_dung_id,
                        'danh_muc_id' => $category->id,
                        'so_tien' => $vnpay->so_tien,
                        'nguon_thu' => 'VNPay: ' . $vnpay->noi_dung,
                        'ngay_nhan' => now(),
                        'ghi_chu' => 'Mã đơn: ' . $orderId,
                    ]);
                } else {
                    GiaoDich::create([
                        'nguoi_dung_id' => $vnpay->nguoi_dung_id,
                        'danh_muc_id' => $category->id,
                        'so_tien' => $vnpay->so_tien,
                        'ghi_chu' => 'VNPay: ' . $vnpay->noi_dung . ' (Mã đơn: ' . $orderId . ')',
                        'ngay_giao_dich' => now(),
                    ]);
                }

                // 4. Update TongKetTaiChinh
                $this->updateFinancialSummary($vnpay);

            } else {
                $vnpay->update(['trang_thai' => 2]);
            }

            DB::commit();
            return response()->json(["RspCode" => "00", "Message" => "Confirm Success"]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('VNPay IPN Error: ' . $e->getMessage());
            return response()->json(["RspCode" => "99", "Message" => "Internal Error"]);
        }
    }

    private function updateFinancialSummary($vnpay)
    {
        $month = now()->month;
        $year = now()->year;

        $summary = TongKetTaiChinh::firstOrCreate(
            [
                'nguoi_dung_id' => $vnpay->nguoi_dung_id,
                'thang' => $month,
                'nam' => $year,
            ],
            [
                'tong_thu' => 0,
                'tong_chi' => 0,
                'tong_tiet_kiem' => 0,
                'so_tien_con_lai' => 0,
            ]
        );

        if ($vnpay->loai_giao_dich == 'thu_nhap') {
            $summary->increment('tong_thu', $vnpay->so_tien);
            $summary->increment('so_tien_con_lai', $vnpay->so_tien);
        } else {
            $summary->increment('tong_chi', $vnpay->so_tien);
            $summary->decrement('so_tien_con_lai', $vnpay->so_tien);
        }
    }

    /**
     * Web Demo Index
     */
    public function index()
    {
        $danhMucs = DanhMuc::where('nguoi_dung_id', Auth::id())->get();
        return view('vnpay.index', compact('danhMucs'));
    }

    /**
     * Web Return Handler
     */
    public function vnpayReturn(Request $request)
    {
        $vnp_Config = config('vnpay');
        $vnp_HashSecret = $vnp_Config['hash_secret'];
        $inputData = $request->all();
        $vnp_SecureHash = $request->vnp_SecureHash;
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $status = 'error';
        $message = 'Giao dịch không hợp lệ!';

        if ($secureHash === $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                $status = 'success';
                $message = 'Thanh toán thành công!';

                // Update database if not already updated by IPN
                $vnpay = VNPay::where('ma_don_hang', $request->vnp_TxnRef)->first();
                if ($vnpay && $vnpay->trang_thai == 0) {
                    try {
                        DB::beginTransaction();
                        $vnpay->update([
                            'trang_thai' => 1,
                            'ma_giao_dich_vnpay' => $request->vnp_TransactionNo
                        ]);

                        $categoryName = 'Giao dịch VNPay';
                        $category = DanhMuc::firstOrCreate(
                            [
                                'nguoi_dung_id' => $vnpay->nguoi_dung_id,
                                'ten_danh_muc' => $categoryName,
                                'loai' => ($vnpay->loai_giao_dich == 'thu_nhap') ? 'thu' : 'chi'
                            ],
                            ['biu_tuong' => 'payments']
                        );

                        if ($vnpay->loai_giao_dich == 'thu_nhap') {
                            KhoanThu::create([
                                'nguoi_dung_id' => $vnpay->nguoi_dung_id,
                                'danh_muc_id' => $category->id,
                                'so_tien' => $vnpay->so_tien,
                                'nguon_thu' => 'VNPay: ' . $vnpay->noi_dung,
                                'ngay_nhan' => now(),
                                'ghi_chu' => 'Mã đơn: ' . $request->vnp_TxnRef,
                            ]);
                        } else {
                            GiaoDich::create([
                                'nguoi_dung_id' => $vnpay->nguoi_dung_id,
                                'danh_muc_id' => $category->id,
                                'so_tien' => $vnpay->so_tien,
                                'ghi_chu' => 'VNPay: ' . $vnpay->noi_dung . ' (Mã đơn: ' . $request->vnp_TxnRef . ')',
                                'ngay_giao_dich' => now(),
                            ]);
                        }

                        $this->updateFinancialSummary($vnpay);
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::error('VNPay Return processing error: ' . $e->getMessage());
                    }
                }

            } else {
                $status = 'error';
                $message = 'Thanh toán thất bại hoặc đã bị hủy.';
                $vnpay = VNPay::where('ma_don_hang', $request->vnp_TxnRef)->first();
                if ($vnpay && $vnpay->trang_thai == 0) {
                    $vnpay->update(['trang_thai' => 2]);
                }
            }
        }

        return view('vnpay.result', [
            'status' => $status,
            'message' => $message,
            'order_id' => $request->vnp_TxnRef,
            'amount' => $request->vnp_Amount / 100,
            'vnp_id' => $request->vnp_TransactionNo
        ]);
    }
}
