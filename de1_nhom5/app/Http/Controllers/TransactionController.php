<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GiaoDich;
use App\Models\KhoanThu;
use App\Models\DanhMuc;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $query = $request->input('search');
        $month = $request->input('month', date('Y-m'));

        // Query Expenses
        $expensesQuery = GiaoDich::where('nguoi_dung_id', $userId)
            ->whereMonth('ngay_giao_dich', date('m', strtotime($month)))
            ->whereYear('ngay_giao_dich', date('Y', strtotime($month)))
            ->with('danhMuc');

        // Query Incomes
        $incomesQuery = KhoanThu::where('nguoi_dung_id', $userId)
            ->whereMonth('ngay_nhan', date('m', strtotime($month)))
            ->whereYear('ngay_nhan', date('Y', strtotime($month)))
            ->with('danhMuc');

        if ($query) {
            $expensesQuery->where('ghi_chu', 'LIKE', '%' . $query . '%');
            $incomesQuery->where(function($q) use ($query) {
                $q->where('nguon_thu', 'LIKE', '%' . $query . '%')
                  ->orWhere('ghi_chu', 'LIKE', '%' . $query . '%');
            });
        }

        $expenses = $expensesQuery->get()->map(function ($item) {
            $item->type = 'chi';
            $item->date = $item->ngay_giao_dich;
            $item->title = $item->ghi_chu ?: 'Chi tiêu';
            return $item;
        });

        $incomes = $incomesQuery->get()->map(function ($item) {
            $item->type = 'thu';
            $item->date = $item->ngay_nhan;
            $item->title = $item->nguon_thu ?: ($item->ghi_chu ?: 'Thu nhập');
            return $item;
        });

        $transactions = $expenses->concat($incomes)->sortByDesc('date')->values();
        
        $danhMucs = DanhMuc::where('nguoi_dung_id', $userId)->get();

        if ($danhMucs->isEmpty()) {
            $defaultCategories = [
                ['ten_danh_muc' => 'Lương', 'loai' => 'thu', 'biu_tuong' => 'payments'],
                ['ten_danh_muc' => 'Kinh doanh', 'loai' => 'thu', 'biu_tuong' => 'storefront'],
                ['ten_danh_muc' => 'Thưởng', 'loai' => 'thu', 'biu_tuong' => 'card_giftcard'],
                ['ten_danh_muc' => 'Ăn uống', 'loai' => 'chi', 'biu_tuong' => 'restaurant'],
                ['ten_danh_muc' => 'Di chuyển', 'loai' => 'chi', 'biu_tuong' => 'directions_car'],
                ['ten_danh_muc' => 'Mua sắm', 'loai' => 'chi', 'biu_tuong' => 'shopping_bag'],
                ['ten_danh_muc' => 'Hoá đơn', 'loai' => 'chi', 'biu_tuong' => 'receipt_long'],
                ['ten_danh_muc' => 'Giải trí', 'loai' => 'chi', 'biu_tuong' => 'sports_esports'],
                ['ten_danh_muc' => 'Y tế', 'loai' => 'chi', 'biu_tuong' => 'medical_services'],
            ];

            foreach ($defaultCategories as $cat) {
                DanhMuc::create(array_merge($cat, ['nguoi_dung_id' => $userId]));
            }

            $danhMucs = DanhMuc::where('nguoi_dung_id', $userId)->get();
        }

        return view('transactions.index', compact('transactions', 'month', 'danhMucs', 'query'));
    }

    public function storeExpense(Request $request)
    {
        $request->validate([
            'danh_muc_id' => 'required|exists:danh_muc,id',
            'so_tien' => 'required|numeric|min:0',
            'ngay_giao_dich' => 'required|date',
            'ghi_chu' => 'nullable|string',
        ]);

        GiaoDich::create([
            'nguoi_dung_id' => Auth::id(),
            'danh_muc_id' => $request->danh_muc_id,
            'so_tien' => $request->so_tien,
            'ngay_giao_dich' => $request->ngay_giao_dich,
            'ghi_chu' => $request->ghi_chu,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Đã thêm khoản chi thành công.');
    }

    public function storeIncome(Request $request)
    {
        $request->validate([
            'danh_muc_id' => 'required|exists:danh_muc,id',
            'so_tien' => 'required|numeric|min:0',
            'ngay_nhan' => 'required|date',
            'nguon_thu' => 'required|string',
            'ghi_chu' => 'nullable|string',
        ]);

        KhoanThu::create([
            'nguoi_dung_id' => Auth::id(),
            'danh_muc_id' => $request->danh_muc_id,
            'so_tien' => $request->so_tien,
            'ngay_nhan' => $request->ngay_nhan,
            'nguon_thu' => $request->nguon_thu,
            'ghi_chu' => $request->ghi_chu,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Đã thêm khoản thu thành công.');
    }
}
