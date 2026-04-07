<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SavingsGoal\StoreSavingsGoalRequest;
use App\Http\Requests\SavingsGoal\UpdateSavingsGoalRequest;
use App\Models\MucTieuTietKiem;
use App\Models\KhoanThu;
use App\Models\GiaoDich;
use Illuminate\Support\Facades\Auth;

class SavingsGoalController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $goals = MucTieuTietKiem::where('nguoi_dung_id', $userId)->orderBy('han_chot', 'asc')->paginate(10);

        foreach ($goals as $goal) {
            $goal->phan_tram = $goal->so_tien_muc_tieu > 0 
                ? min(100, round(($goal->so_tien_hien_tai / $goal->so_tien_muc_tieu) * 100, 2))
                : 0;
        }

        // Calculate available balance
        $totalIncome = KhoanThu::where('nguoi_dung_id', $userId)->sum('so_tien');
        $totalExpense = GiaoDich::where('nguoi_dung_id', $userId)->sum('so_tien');
        $totalSavings = MucTieuTietKiem::where('nguoi_dung_id', $userId)->sum('so_tien_hien_tai');
        $availableBalance = $totalIncome - $totalExpense - $totalSavings;

        return view('savings.index', compact('goals', 'availableBalance'));
    }

    public function store(StoreSavingsGoalRequest $request)
    {
        $userId = Auth::id();
        $soTienHienTai = $request->so_tien_hien_tai ?? 0;

        // Check balance if initial amount is provided
        if ($soTienHienTai > 0) {
            $totalIncome = KhoanThu::where('nguoi_dung_id', $userId)->sum('so_tien');
            $totalExpense = GiaoDich::where('nguoi_dung_id', $userId)->sum('so_tien');
            $totalSavings = MucTieuTietKiem::where('nguoi_dung_id', $userId)->sum('so_tien_hien_tai');
            $currentBalance = $totalIncome - $totalExpense - $totalSavings;

            if ($soTienHienTai > $currentBalance) {
                return back()->with('error', 'Số dư không đủ để trích vào tiết kiệm. Vui lòng kiểm tra lại.')->withInput();
            }
        }

        MucTieuTietKiem::create([
            'nguoi_dung_id' => $userId,
            'ten_muc_tieu' => $request->ten_muc_tieu,
            'so_tien_muc_tieu' => $request->so_tien_muc_tieu,
            'so_tien_hien_tai' => $soTienHienTai,
            'han_chot' => $request->han_chot,
            'trang_thai' => 'dang_thuc_hien'
        ]);

        return redirect()->route('savings.index')->with('success', 'Đã thêm mục tiêu tiết kiệm thành công.');
    }

    public function update(UpdateSavingsGoalRequest $request, $id)
    {
        $userId = Auth::id();
        $goal = MucTieuTietKiem::where('id', $id)->where('nguoi_dung_id', $userId)->firstOrFail();
        $soTienThem = $request->so_tien_them;

        // Check balance
        $totalIncome = KhoanThu::where('nguoi_dung_id', $userId)->sum('so_tien');
        $totalExpense = GiaoDich::where('nguoi_dung_id', $userId)->sum('so_tien');
        $totalSavings = MucTieuTietKiem::where('nguoi_dung_id', $userId)->sum('so_tien_hien_tai');
        $currentBalance = $totalIncome - $totalExpense - $totalSavings;

        if ($soTienThem > $currentBalance) {
            return back()->with('error', 'Số tiền nộp vượt quá số dư khả dụng hiện tại.')->withInput();
        }

        $goal->so_tien_hien_tai += $soTienThem;
        
        if ($goal->so_tien_hien_tai >= $goal->so_tien_muc_tieu) {
            $goal->trang_thai = 'hoan_thanh';
        }

        $goal->save();

        return redirect()->route('savings.index')->with('success', 'Đã cập nhật tiến độ mục tiêu.');
    }

    public function destroy($id)
    {
        $goal = MucTieuTietKiem::where('id', $id)->where('nguoi_dung_id', Auth::id())->firstOrFail();
        $goal->delete();

        return redirect()->route('savings.index')->with('success', 'Đã xóa mục tiêu tiết kiệm.');
    }
}
