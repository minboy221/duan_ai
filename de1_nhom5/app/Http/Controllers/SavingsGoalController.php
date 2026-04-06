<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MucTieuTietKiem;
use Illuminate\Support\Facades\Auth;

class SavingsGoalController extends Controller
{
    public function index()
    {
        $goals = MucTieuTietKiem::where('nguoi_dung_id', Auth::id())->orderBy('han_chot', 'asc')->get();

        foreach ($goals as $goal) {
            $goal->phan_tram = $goal->so_tien_muc_tieu > 0 
                ? min(100, round(($goal->so_tien_hien_tai / $goal->so_tien_muc_tieu) * 100, 2))
                : 0;
        }

        return view('savings.index', compact('goals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_muc_tieu' => 'required|string|max:255',
            'so_tien_muc_tieu' => 'required|numeric|min:1',
            'so_tien_hien_tai' => 'nullable|numeric|min:0',
            'han_chot' => 'required|date',
        ]);

        MucTieuTietKiem::create([
            'nguoi_dung_id' => Auth::id(),
            'ten_muc_tieu' => $request->ten_muc_tieu,
            'so_tien_muc_tieu' => $request->so_tien_muc_tieu,
            'so_tien_hien_tai' => $request->so_tien_hien_tai ?? 0,
            'han_chot' => $request->han_chot,
            'trang_thai' => 'dang_thuc_hien'
        ]);

        return redirect()->route('savings.index')->with('success', 'Đã thêm mục tiêu tiết kiệm thành công.');
    }

    public function update(Request $request, $id)
    {
        $goal = MucTieuTietKiem::where('id', $id)->where('nguoi_dung_id', Auth::id())->firstOrFail();

        $request->validate([
            'so_tien_them' => 'required|numeric|min:0',
        ]);

        $goal->so_tien_hien_tai += $request->so_tien_them;
        
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
