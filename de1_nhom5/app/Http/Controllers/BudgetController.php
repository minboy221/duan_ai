<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Budget\StoreBudgetRequest;
use App\Models\NganSach;
use App\Models\DanhMuc;
use App\Models\GiaoDich;
use Illuminate\Support\Facades\Auth;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $month = $request->input('month', date('n'));
        $year = $request->input('year', date('Y'));

        $budgets = NganSach::where('nguoi_dung_id', $userId)
            ->where('thang', $month)
            ->where('nam', $year)
            ->with('danhMuc')
            ->get();

        foreach ($budgets as $budget) {
            $budget->da_chi_tieu = GiaoDich::where('nguoi_dung_id', $userId)
                ->where('danh_muc_id', $budget->danh_muc_id)
                ->whereMonth('ngay_giao_dich', $month)
                ->whereYear('ngay_giao_dich', $year)
                ->sum('so_tien');
            
            $budget->phan_tram = $budget->so_tien_han_muc > 0 
                ? min(100, round(($budget->da_chi_tieu / $budget->so_tien_han_muc) * 100, 2))
                : 0;
        }

        // Only categories that are type 'chi' or those that the user hasn't created a budget for this month
        $existingBudgetCategories = $budgets->pluck('danh_muc_id')->toArray();
        $danhMucs = DanhMuc::where('nguoi_dung_id', $userId)
            ->where('loai', 'chi')
            ->whereNotIn('id', $existingBudgetCategories)
            ->get();

        return view('budget.index', compact('budgets', 'danhMucs', 'month', 'year'));
    }

    public function store(StoreBudgetRequest $request)
    {

        NganSach::updateOrCreate(
            [
                'nguoi_dung_id' => Auth::id(),
                'danh_muc_id' => $request->danh_muc_id,
                'thang' => $request->thang,
                'nam' => $request->nam,
            ],
            [
                'so_tien_han_muc' => $request->so_tien_han_muc
            ]
        );

        return redirect()->route('ngansach')->with('success', 'Đã lưu ngân sách thành công.');
    }

    public function destroy($id)
    {
        $budget = NganSach::where('id', $id)->where('nguoi_dung_id', Auth::id())->firstOrFail();
        $budget->delete();

        return redirect()->route('ngansach')->with('success', 'Đã xóa ngân sách.');
    }
}
