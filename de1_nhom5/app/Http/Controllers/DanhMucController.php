<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMuc;
use Illuminate\Support\Facades\Auth;

class DanhMucController extends Controller
{
    public function index()
    {
        $danhMucs = DanhMuc::where('nguoi_dung_id', Auth::id())
            ->orderBy('loai', 'asc')
            ->orderBy('ten_danh_muc', 'asc')
            ->get();

        return view('danhmuc.index', compact('danhMucs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_danh_muc' => 'required|string|max:255',
            'loai' => 'required|in:thu,chi',
            'biu_tuong' => 'required|string|max:50',
        ]);

        DanhMuc::create([
            'nguoi_dung_id' => Auth::id(),
            'ten_danh_muc' => $request->ten_danh_muc,
            'loai' => $request->loai,
            'biu_tuong' => $request->biu_tuong,
        ]);

        return redirect()->route('danhmuc.index')->with('success', 'Đã thêm danh mục mới thành công.');
    }

    public function destroy($id)
    {
        $danhMuc = DanhMuc::where('id', $id)->where('nguoi_dung_id', Auth::id())->firstOrFail();
        
        // Check if there are associated transactions, budgets, etc.
        // For simplicity, we just delete or use cascade in DB.
        $danhMuc->delete();

        return redirect()->route('danhmuc.index')->with('success', 'Đã xóa danh mục.');
    }
}
