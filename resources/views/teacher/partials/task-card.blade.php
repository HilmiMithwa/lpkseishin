<div class="bg-white rounded-[24px] border border-gray-100 p-6 shadow-sm hover:shadow-md transition duration-300 flex flex-col h-full group relative overflow-hidden">
    <div class="flex items-center justify-end mb-4 relative z-10">
        <div class="flex items-center gap-1.5 text-xs font-bold {{ $task->status_tugas === 'Aktif' ? 'text-red-600 bg-red-50' : 'text-gray-500 bg-gray-50' }} px-2 py-1 rounded-lg">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ $task->status_tugas ?? 'Aktif' }}
        </div>
    </div>
    <h3 class="text-lg font-bold text-gray-800 mb-2 leading-snug relative z-10">{{ $task->judul_tugas }}</h3>
    <p class="text-xs font-semibold text-gray-500 mb-5 flex-1 relative z-10">{{ $task->modul->nama_modul ?? 'Modul tidak tersedia' }}</p>
    <div class="mb-5 relative z-10">
        <div class="flex items-center justify-between text-xs font-bold mb-1.5">
            <span class="text-gray-500">Tenggat</span>
            <span class="text-gray-800">{{ $task->waktu_pengumpulan ? \Carbon\Carbon::parse($task->waktu_pengumpulan)->translatedFormat('d M Y') : '-' }}</span>
        </div>
        @php
            $percentage = 0;
            if ($task->waktu_pengumpulan) {
                $end = \Carbon\Carbon::parse($task->waktu_pengumpulan)->timestamp;
                $now = \Carbon\Carbon::now()->timestamp;
                
                if ($now >= $end) {
                    $percentage = 100;
                } elseif ($task->created_at) {
                    $start = \Carbon\Carbon::parse($task->created_at)->timestamp;
                    if ($end > $start && $now > $start) {
                        $percentage = (($now - $start) / ($end - $start)) * 100;
                    }
                }
                $percentage = max(0, min(100, $percentage));
            }
        @endphp
        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
            <div class="bg-[#d62828] h-1.5 rounded-full transition-all duration-500" style="width: {{ round($percentage) }}%"></div>
        </div>
    </div>
    <a href="{{ route('teacher.assignments.grade', $task->id_tugas) }}" class="w-full mt-auto bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 font-bold py-2.5 rounded-xl text-sm transition-colors duration-300 flex items-center justify-center gap-2 relative z-10 shadow-sm">
        Lihat Detail Tugas
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
    </a>
</div>
