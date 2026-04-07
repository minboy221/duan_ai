<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Transaction\StoreExpenseRequest;
use App\Http\Requests\Transaction\StoreIncomeRequest;
use App\Notifications\BudgetExceededNotification;
use App\Models\NganSach;
use App\Models\GiaoDich;
use App\Models\KhoanThu;
use App\Models\DanhMuc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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

        $transactionsCollection = $expenses->concat($incomes)->sort(function ($a, $b) {
            if ($a->date === $b->date) {
                return $b->id <=> $a->id;
            }
            return $b->date <=> $a->date;
        })->values();
        
        // Manual pagination for the combined collection
        $currentPage = Paginator::resolveCurrentPage('page');
        $perPage = 10;
        $currentItems = $transactionsCollection->slice(($currentPage - 1) * $perPage, $perPage)->all();

        $transactions = new LengthAwarePaginator(
            $currentItems,
            $transactionsCollection->count(),
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath(), 'query' => $request->query()]
        );
        
        $danhMucs = DanhMuc::where('nguoi_dung_id', $userId)->get();

        if ($danhMucs->isEmpty()) {
            $defaultCategories = [
                ['ten_danh_muc' => 'Lương', 'loai' => 'thu', 'bieu_tuong' => 'payments'],
                ['ten_danh_muc' => 'Kinh doanh', 'loai' => 'thu', 'bieu_tuong' => 'storefront'],
                ['ten_danh_muc' => 'Thưởng', 'loai' => 'thu', 'bieu_tuong' => 'card_giftcard'],
                ['ten_danh_muc' => 'Ăn uống', 'loai' => 'chi', 'bieu_tuong' => 'restaurant'],
                ['ten_danh_muc' => 'Di chuyển', 'loai' => 'chi', 'bieu_tuong' => 'directions_car'],
                ['ten_danh_muc' => 'Mua sắm', 'loai' => 'chi', 'bieu_tuong' => 'shopping_bag'],
                ['ten_danh_muc' => 'Hoá đơn', 'loai' => 'chi', 'bieu_tuong' => 'receipt_long'],
                ['ten_danh_muc' => 'Giải trí', 'loai' => 'chi', 'bieu_tuong' => 'sports_esports'],
                ['ten_danh_muc' => 'Y tế', 'loai' => 'chi', 'bieu_tuong' => 'medical_services'],
            ];

            foreach ($defaultCategories as $cat) {
                DanhMuc::create(array_merge($cat, ['nguoi_dung_id' => $userId]));
            }

            $danhMucs = DanhMuc::where('nguoi_dung_id', $userId)->get();
        }

        return view('transactions.index', compact('transactions', 'month', 'danhMucs', 'query'));
    }

    public function storeExpense(StoreExpenseRequest $request)
    {

        $expense = GiaoDich::create([
            'nguoi_dung_id' => Auth::id(),
            'danh_muc_id' => $request->danh_muc_id,
            'so_tien' => $request->so_tien,
            'ngay_giao_dich' => $request->ngay_giao_dich,
            'ghi_chu' => $request->ghi_chu,
        ]);

        // Kiểm tra vượt ngân sách
        $ngayGiaoDich = \Carbon\Carbon::parse($request->ngay_giao_dich);
        $thang = $ngayGiaoDich->month;
        $nam = $ngayGiaoDich->year;

        $nganSach = NganSach::where('nguoi_dung_id', Auth::id())
            ->where('danh_muc_id', $request->danh_muc_id)
            ->where('thang', $thang)
            ->where('nam', $nam)
            ->first();

        if ($nganSach) {
            $tongDaChi = GiaoDich::where('nguoi_dung_id', Auth::id())
                ->where('danh_muc_id', $request->danh_muc_id)
                ->whereMonth('ngay_giao_dich', $thang)
                ->whereYear('ngay_giao_dich', $nam)
                ->sum('so_tien');

            if ($tongDaChi > $nganSach->so_tien_han_muc) {
                $user = Auth::user();
                $user->notify(new BudgetExceededNotification(
                    $nganSach->danhMuc->ten_danh_muc,
                    $tongDaChi,
                    $nganSach->so_tien_han_muc
                ));
            }
        }

        return redirect()->route('transactions.index')->with('success', 'Đã thêm khoản chi thành công.');
    }

    public function storeIncome(StoreIncomeRequest $request)
    {

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

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\TransactionsExport, 'LichSuGiaoDich.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ], [
            'file.required' => 'Vui lòng chọn file Excel để nhập.',
            'file.mimes' => 'Chỉ chấp nhận file định dạng xlsx, xls, hoặc csv.'
        ]);

        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\TransactionsImport, $request->file('file'));
            return redirect()->route('transactions.index')->with('success', 'Đã nhập dữ liệu thành công.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Lỗi import Excel: ' . $e->getMessage());
            return redirect()->route('transactions.index')->with('error', 'Có lỗi xảy ra khi nhập file, vui lòng kiểm tra lại định dạng chuẩn.');
        }
    }
}
