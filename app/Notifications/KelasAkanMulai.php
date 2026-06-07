<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Batch;

class KelasAkanMulai extends Notification
{
    use Queueable;

    public $batch;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Batch $batch, $message)
    {
        $this->batch = $batch;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'kelas_akan_mulai',
            'title' => 'Pengingat Kelas',
            'message' => $this->message,
            'batch_id' => $this->batch->id_batch,
            'batch_name' => $this->batch->nama,
            'jam_mulai' => $this->batch->jam_mulai,
        ];
    }
}
