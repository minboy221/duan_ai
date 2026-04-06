<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BudgetExceededNotification extends Notification
{
    use Queueable;

    protected $danhMucTen;
    protected $daChiTieu;
    protected $hanMuc;

    public function __construct($danhMucTen, $daChiTieu, $hanMuc)
    {
        $this->danhMucTen = $danhMucTen;
        $this->daChiTieu = $daChiTieu;
        $this->hanMuc = $hanMuc;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('⚠️ Cảnh báo: Vượt ngân sách tháng - ' . $this->danhMucTen)
            ->view('emails.budget_exceeded', [
                'ho_ten' => $notifiable->ho_ten,
                'danh_muc' => $this->danhMucTen,
                'da_chi_tieu' => $this->daChiTieu,
                'han_muc' => $this->hanMuc,
                'ngay' => now()->format('d/m/Y'),
            ]);
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Vượt ngân sách: ' . $this->danhMucTen,
            'message' => 'Bạn đã chi tiêu ' . number_format($this->daChiTieu, 0, ',', '.') . ' VNĐ, vượt hạn mức ' . number_format($this->hanMuc, 0, ',', '.') . ' VNĐ của tháng này.',
            'type' => 'budget_exceeded',
            'icon' => 'warning',
            'action_url' => route('ngansach'),
        ];
    }
}
