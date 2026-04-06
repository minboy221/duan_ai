<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RecurringTransaction\StoreRecurringRequest;
use App\Models\GiaoDichDinhKy;
use App\Models\DanhMuc;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RecurringTransactionController extends Controller
{
    /**
     * Hiển thị trang danh sách giao dịch định kỳ
     */
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

    /**
     * Tạo mới giao dịch định kỳ
     * - Tính ngay_chay_tiep_theo dựa trên ngay_bat_dau
     */
    public function store(StoreRecurringRequest $request)
    {
        $ngayBatDau = Carbon::parse($request->ngay_bat_dau);

        // Nếu ngay_bat_dau là hôm nay hoặc trong quá khứ → chạy ngay hôm nay
        // Nếu ngay_bat_dau trong tương lai → chạy vào ngày đó
        $ngayChayTiepTheo = $ngayBatDau->isPast() || $ngayBatDau->isToday()
            ? now()->toDateString()
            : $ngayBatDau->toDateString();

        GiaoDichDinhKy::create([
            'nguoi_dung_id'       => Auth::id(),
            'danh_muc_id'         => $request->danh_muc_id,
            'loai_giao_dich'      => $request->loai_giao_dich,
            'so_tien'             => $request->so_tien,
            'chu_ky'              => $request->chu_ky,
            'ngay_bat_dau'        => $request->ngay_bat_dau,
            'ngay_ket_thuc'       => $request->ngay_ket_thuc,
            'trang_thai'          => 'hoat_dong',
            'ngay_chay_tiep_theo' => $ngayChayTiepTheo,
        ]);

        return redirect()->route('recurring.index')->with('success', 'Đã thêm giao dịch định kỳ thành công! Hệ thống sẽ tự động tạo khi đến hạn.');
    }

    /**
     * Bật/tắt trạng thái (hoat_dong ↔ tam_dung)
     */
    public function toggle($id)
    {
        $recurring = GiaoDichDinhKy::where('id', $id)
            ->where('nguoi_dung_id', Auth::id())
            ->firstOrFail();

        $recurring->trang_thai = $recurring->trang_thai === 'hoat_dong' ? 'tam_dung' : 'hoat_dong';
        $recurring->save();

        $statusText = $recurring->trang_thai === 'hoat_dong' ? 'kích hoạt' : 'tạm dừng';
        return redirect()->route('recurring.index')->with('success', "Đã {$statusText} giao dịch định kỳ.");
    }

    /**
     * Xóa giao dịch định kỳ
     */
    public function destroy($id)
    {
        $recurring = GiaoDichDinhKy::where('id', $id)
            ->where('nguoi_dung_id', Auth::id())
            ->firstOrFail();

        $recurring->delete();

        return redirect()->route('recurring.index')->with('success', 'Đã xóa giao dịch định kỳ.');
    }
}
