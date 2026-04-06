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
        return ['mail'];
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
}
