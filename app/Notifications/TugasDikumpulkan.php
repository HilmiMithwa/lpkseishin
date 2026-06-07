<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Tugas;

class TugasDikumpulkan extends Notification
{
    use Queueable;

    public $student;
    public $tugas;
    public $modul;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $student, Tugas $tugas)
    {
        $this->student = $student;
        $this->tugas = $tugas;
        $this->modul = $tugas->modul;
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
            'type' => 'tugas_dikumpulkan',
            'title' => 'Tugas Baru Dikumpulkan',
            'message' => $this->student->name . ' telah mengumpulkan ' . $this->tugas->judul_tugas . ' pada ' . ($this->modul->judul ?? 'Modul'),
            'student_id' => $this->student->id,
            'student_name' => $this->student->name,
            'tugas_id' => $this->tugas->id_tugas,
            'modul_id' => $this->modul->id_modul ?? null,
            'mapel_id' => $this->modul->id_mapel ?? null,
        ];
    }
}
