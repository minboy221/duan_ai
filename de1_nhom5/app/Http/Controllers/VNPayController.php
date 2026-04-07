<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\GiaoDich;
use App\Models\KhoanThu;
use App\Models\TongKetTaiChinh;
use App\Models\VNPay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class VNPayController extends Controller
{
    /**
     * Web Demo Index - Show payment method selection
     */
    public function index()
    {
        $danhMucs = DanhMuc::where('nguoi_dung_id', Auth::id())->get();
        return view('vnpay.index', compact('danhMucs'));
    }

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
        $vnp_Config = config('vnpay');

        $startTime = Carbon::now('Asia/Ho_Chi_Minh')->format('YmdHis');
        $expire = Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(15)->format('YmdHis');
        $orderId = 'VNP' . $userId . '_' . time();

        // 1. Save local transaction record
        VNPay::create([
            'nguoi_dung_id' => $userId,
            'ma_don_hang' => $orderId,
            'so_tien' => $request->so_tien,
            'noi_dung' => $request->noi_dung,
            'loai_giao_dich' => $request->loai_giao_dich,
            'trang_thai' => 0, // Pending
            'vnp_create_date' => $startTime,
        ]);

        // 2. Build VNPay Data
        $ipAddress = $request->ip();
        if (!$ipAddress || $ipAddress === '::1' || $ipAddress === '127.0.0.1') {
            $ipAddress = '127.0.0.1';
        }

        $vnp_Data = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_Config['tmn_code'],
            "vnp_Amount" => $request->so_tien * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $startTime,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $ipAddress,
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
        return redirect()->away($vnp_Url);
    }

    /**
     * Handle VNPay Return (Browser callback)
     */
    public function vnpayReturn(Request $request)
    {
        $vnp_Config = config('vnpay');
        $inputData = array();
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        $vnp_SecureHash = $request->vnp_SecureHash;
        unset($inputData['vnp_SecureHashType']);
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

        $secureHash = hash_hmac('sha512', $hashData, $vnp_Config['hash_secret']);
        
        $status = 'error';
        $message = 'Giao dịch không hợp lệ!';
        $orderId = $request->vnp_TxnRef;

        if ($secureHash === $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                $status = 'success';
                $message = 'Thanh toán thành công!';
                $this->processSuccessOrder($orderId, $request->vnp_TransactionNo);
            } else {
                $status = 'error';
                $message = 'Thanh toán thất bại hoặc người dùng đã hủy.';
                VNPay::where('ma_don_hang', $orderId)->where('trang_thai', 0)->update(['trang_thai' => 2]);
            }
        }

        $vnpay = VNPay::where('ma_don_hang', $orderId)->first();

        return view('vnpay.result', [
            'status' => $status,
            'message' => $message,
            'order_id' => $orderId,
            'amount' => $request->vnp_Amount / 100,
            'vnp_id' => $request->vnp_TransactionNo,
            'vnpay' => $vnpay
        ]);
    }

    /**
     * Common logic to process successful payment
     */
    private function processSuccessOrder($orderId, $vnpayTranId)
    {
        $vnpay = VNPay::where('ma_don_hang', $orderId)->first();
        if ($vnpay && $vnpay->trang_thai == 0) {
            try {
                DB::beginTransaction();
                $vnpay->update([
                    'trang_thai' => 1,
                    'ma_giao_dich_vnpay' => $vnpayTranId
                ]);

                $isIncome = ($vnpay->loai_giao_dich == 'thu_nhap');
                $category = DanhMuc::firstOrCreate(
                    [
                        'nguoi_dung_id' => $vnpay->nguoi_dung_id,
                        'ten_danh_muc' => 'Thanh toán VNPay',
                        'loai' => $isIncome ? 'thu' : 'chi'
                    ],
                    ['bieu_tuong' => 'payments']
                );

                if ($isIncome) {
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

                $this->updateFinancialSummary($vnpay);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('VNPay Process Order Error: ' . $e->getMessage());
            }
        }
    }

    private function updateFinancialSummary($vnpay)
    {
        $month = now()->month;
        $year = now()->year;
        $summary = TongKetTaiChinh::firstOrCreate(
            ['nguoi_dung_id' => $vnpay->nguoi_dung_id, 'thang' => $month, 'nam' => $year],
            ['tong_thu' => 0, 'tong_chi' => 0, 'tong_tiet_kiem' => 0, 'so_tien_con_lai' => 0]
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
     * Query Transaction Status (Merchant WebAPI)
     */
    public function queryTransaction(Request $request)
    {
        $vnp_Config = config('vnpay');
        $vnp_TxnRef = $request->order_id;
        $vnp_TransactionDate = $request->trans_date; 
        $vnp_RequestId = (string)time(); 
        $vnp_CreateDate = date('YmdHis');
        $ipAddr = $request->ip();
        if (!$ipAddr || $ipAddr === '::1') $ipAddr = '127.0.0.1';

        $vnp_OrderInfo = "Truy van giao dich: " . $vnp_TxnRef;
        
        // vnp_RequestId|vnp_Version|vnp_Command|vnp_TmnCode|vnp_TxnRef|vnp_TransactionDate|vnp_CreateDate|vnp_IpAddr|vnp_OrderInfo
        $dataHash = $vnp_RequestId . '|2.1.0|querydr|' . $vnp_Config['tmn_code'] . '|' . $vnp_TxnRef . '|' . $vnp_TransactionDate . '|' . $vnp_CreateDate . '|' . $ipAddr . '|' . $vnp_OrderInfo;
        $vnp_SecureHash = hash_hmac('sha512', $dataHash, $vnp_Config['hash_secret']);

        $data = [
            "vnp_RequestId" => $vnp_RequestId,
            "vnp_Version" => "2.1.0",
            "vnp_Command" => "querydr",
            "vnp_TmnCode" => $vnp_Config['tmn_code'],
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_TransactionDate" => $vnp_TransactionDate,
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_IpAddr" => $ipAddr,
            "vnp_SecureHash" => $vnp_SecureHash
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post($vnp_Config['api_url'], $data);
            
            return response()->json($response->json());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
