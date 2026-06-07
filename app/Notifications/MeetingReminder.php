<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Meeting;

class MeetingReminder extends Notification
{
    use Queueable;

    public $meeting;

    /**
     * Create a new notification instance.
     */
    public function __construct(Meeting $meeting)
    {
        $this->meeting = $meeting;
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
            'type' => 'meeting_reminder',
            'title' => 'Pengingat Video Conference',
            'message' => "Video Conference '{$this->meeting->judul}' akan dimulai dalam 5 menit! Silakan bersiap-siap.",
            'meeting_id' => $this->meeting->id_meeting,
            'mapel_id' => $this->meeting->id_mapel,
            'waktu_mulai' => $this->meeting->waktu_mulai,
        ];
    }
}
