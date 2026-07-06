<?php

namespace App\Notifications;

use App\Models\CarRental;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingNotification extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct(CarRental $booking)
    {
        $this->booking = $booking;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $user = $this->booking->user;
        $car = $this->booking->car;

        $durationType = $this->booking->duration_type == '12' ? '12 Jam' : 'Harian';
        $start = Carbon::parse($this->booking->start_date)->format('d M Y H:i');
        $end = Carbon::parse($this->booking->end_date)->format('d M Y H:i');

        $driverInfo = match ($this->booking->driver_type) {
            'near' => 'Dengan Sopir Jarak Dekat (Rp100.000)',
            'far' => 'Dengan Sopir Jarak Jauh (Rp500.000)',
            default => 'Tanpa Sopir',
        };

        $fuelInfo = $this->booking->with_fuel ? 'Termasuk BBM (Rp100.000)' : 'Tanpa BBM';

        return (new MailMessage)
            ->subject('Booking Baru Masuk')
            ->greeting('Halo Admin,')
            ->line('Ada booking mobil baru dengan detail berikut:')
            ->line('Nama: ' . $user->name)
            ->line('No. HP: ' . $user->phone_number)
            ->line('Mobil: ' . $car->name)
            ->line('Durasi: ' . $durationType)
            ->line('Mulai: ' . $start)
            ->line('Selesai: ' . $end)
            ->line('Sopir: ' . $driverInfo)
            ->line('BBM: ' . $fuelInfo)
            ->line('Total Harga: Rp' . number_format($this->booking->total_price, 0, ',', '.'))
            ->action('Lihat Detail Booking', url('/admin/car_rentals/' . $this->booking->id))
            ->line('Terima kasih.');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
