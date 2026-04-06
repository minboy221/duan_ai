<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecurringTransactionNotification extends Notification
{
    use Queueable;

    protected $soTien;
    protected $loaiGiaoDich;
    protected $danhMucTen;
    protected $ngayGiaoDich;

    /**
     * @param float  $soTien       Số tiền giao dịch
     * @param string $loaiGiaoDich 'thu' hoặc 'chi'
     * @param string $danhMucTen   Tên danh mục
     * @param string $ngayGiaoDich Ngày thực hiện (d/m/Y)
     */
    public function __construct($soTien, $loaiGiaoDich, $danhMucTen, $ngayGiaoDich)
    {
        $this->soTien = $soTien;
        $this->loaiGiaoDich = $loaiGiaoDich;
        $this->danhMucTen = $danhMucTen;
        $this->ngayGiaoDich = $ngayGiaoDich;
    }

    /**
     * Gửi qua 2 kênh: database (hiển thị web) + mail (email)
     */
    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Nội dung email thông báo
     */
    public function toMail($notifiable): MailMessage
    {
        $loaiText = $this->loaiGiaoDich === 'thu' ? 'Thu nhập' : 'Chi tiêu';
        $soTienFormatted = number_format($this->soTien, 0, ',', '.') . ' VNĐ';

        return (new MailMessage)
            ->subject('🔄 Giao dịch định kỳ đã được tạo - ' . $this->danhMucTen)
            ->view('emails.recurring_transaction', [
                'ho_ten'        => $notifiable->ho_ten,
                'loai'          => $loaiText,
                'danh_muc'      => $this->danhMucTen,
                'so_tien'       => $soTienFormatted,
                'ngay_giao_dich' => $this->ngayGiaoDich,
            ]);
    }

    /**
     * Dữ liệu lưu vào bảng notifications (hiển thị trên web)
     */
    public function toArray($notifiable): array
    {
        $loaiText = $this->loaiGiaoDich === 'thu' ? 'Thu nhập' : 'Chi tiêu';
        $soTienFormatted = number_format($this->soTien, 0, ',', '.');

        return [
            'title'   => 'Giao dịch định kỳ đã được tạo',
            'message' => $loaiText . ' ' . $soTienFormatted . ' VNĐ - ' . $this->danhMucTen . ' vào ngày ' . $this->ngayGiaoDich,
            'type'    => 'recurring_transaction',
            'icon'    => 'event_repeat',
            'action_url' => route('recurring.index'),
        ];
    }
}
