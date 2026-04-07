<?php

namespace App\Imports;

use App\Models\GiaoDich;
use App\Models\KhoanThu;
use App\Models\DanhMuc;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransactionsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $userId = Auth::id();

        foreach ($rows as $row) {
            // Check if required columns are present (using slugified headers)
            // Headings from export are: 'Ngày Giao Dịch', 'Loại Phân Loại', 'Danh Mục', 'Nội Dung / Nguồn Thu', 'Số Tiền (VNĐ)'
            // Maatwebsite Excel converts headers to slug: ngay_giao_dich, loai_phan_loai, danh_muc, noi_dung_nguon_thu, so_tien_vnd
            
            $loaiGiaoDich = $row['loai_phan_loai'] ?? '';
            if (empty($loaiGiaoDich)) {
                // Determine format if uppercase headers
                $loaiGiaoDich = $row['Loại Phân Loại'] ?? '';
            }
            if (empty($loaiGiaoDich)) continue; // Skip invalid rows

            $tenDanhMuc = $row['danh_muc'] ?? ($row['Danh Mục'] ?? 'Khác');
            $noiDung = $row['noi_dung_nguon_thu'] ?? ($row['Nội Dung / Nguồn Thu'] ?? 'Nhập từ Excel');
            $soTien = $row['so_tien_vnd'] ?? ($row['Số Tiền (VNĐ)'] ?? 0);
            
            // Format dates (Excel stores dates as numbers or string)
            $ngayChuan = null;
            $rawDate = $row['ngay_giao_dich'] ?? ($row['Ngày Giao Dịch'] ?? null);
            if ($rawDate) {
                if (is_numeric($rawDate)) {
                    $ngayChuan = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rawDate)->format('Y-m-d');
                } else {
                    try {
                        $ngayChuan = Carbon::createFromFormat('d/m/Y', $rawDate)->format('Y-m-d');
                    } catch (\Exception $e) {
                        try {
                            $ngayChuan = Carbon::parse($rawDate)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $ngayChuan = now()->format('Y-m-d');
                        }
                    }
                }
            } else {
                $ngayChuan = now()->format('Y-m-d');
            }

            // Remove commas from money if any
            $soTien = floatval(preg_replace('/[^\d.]/', '', $soTien));

            $loai = strtolower(trim($loaiGiaoDich));
            $isThuNhap = ($loai === 'thu nhập' || $loai === 'thu nhap' || $loai === 'thu');

            // Find or create Category
            $categoryType = $isThuNhap ? 'thu' : 'chi';
            $category = DanhMuc::firstOrCreate(
                [
                    'nguoi_dung_id' => $userId,
                    'ten_danh_muc'  => $tenDanhMuc,
                    'loai'          => $categoryType
                ],
                [
                    'bieu_tuong' => 'folder'
                ]
            );

            if ($isThuNhap) {
                KhoanThu::create([
                    'nguoi_dung_id' => $userId,
                    'danh_muc_id'   => $category->id,
                    'so_tien'       => $soTien,
                    'ngay_nhan'     => $ngayChuan,
                    'nguon_thu'     => $noiDung,
                    'ghi_chu'       => 'Nhập từ Excel',
                ]);
            } else {
                GiaoDich::create([
                    'nguoi_dung_id'  => $userId,
                    'danh_muc_id'    => $category->id,
                    'so_tien'        => $soTien,
                    'ngay_giao_dich' => $ngayChuan,
                    'ghi_chu'        => $noiDung,
                ]);
            }
        }
    }
}
