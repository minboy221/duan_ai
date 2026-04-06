<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GiaoDichDinhKy;
use App\Models\DanhMuc;
use Illuminate\Support\Facades\Auth;

class RecurringTransactionController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $recurrings = GiaoDichDinhKy::where('nguoi_dung_id', $userId)
            ->with('danhMuc')
            ->orderBy('ngay_bat_dau', 'desc')
            ->get();
            
        $danhMucs = DanhMuc::where('nguoi_dung_id', $userId)->get();

        return view('recurring.index', compact('recurrings', 'danhMucs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'danh_muc_id' => 'required|exists:danh_muc,id',
            'loai_giao_dich' => 'required|in:thu,chi',
            'so_tien' => 'required|numeric|min:1',
            'chu_ky' => 'required|in:hang_ngay,hang_tuan,hang_thang,hang_nam',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'nullable|date|after:ngay_bat_dau',
        ]);

        GiaoDichDinhKy::create([
            'nguoi_dung_id' => Auth::id(),
            'danh_muc_id' => $request->danh_muc_id,
            'loai_giao_dich' => $request->loai_giao_dich,
            'so_tien' => $request->so_tien,
            'chu_ky' => $request->chu_ky,
            'ngay_bat_dau' => $request->ngay_bat_dau,
            'ngay_ket_thuc' => $request->ngay_ket_thuc,
            'trang_thai' => 'hoat_dong',
        ]);

        return redirect()->route('recurring.index')->with('success', 'Đã thêm giao dịch định kỳ thành công.');
    }

    public function toggle($id)
    {
        $recurring = GiaoDichDinhKy::where('id', $id)->where('nguoi_dung_id', Auth::id())->firstOrFail();
        $recurring->trang_thai = $recurring->trang_thai === 'hoat_dong' ? 'tam_dung' : 'hoat_dong';
        $recurring->save();

        return redirect()->route('recurring.index')->with('success', 'Đã cập nhật trạng thái giao dịch định kỳ.');
    }

    public function destroy($id)
    {
        $recurring = GiaoDichDinhKy::where('id', $id)->where('nguoi_dung_id', Auth::id())->firstOrFail();
        $recurring->delete();

        return redirect()->route('recurring.index')->with('success', 'Đã xóa giao dịch định kỳ.');
    }
}
