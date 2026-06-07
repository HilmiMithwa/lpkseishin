<div class="bg-white/80 backdrop-blur-xl rounded-[24px] border border-gray-100 p-6 shadow-sm hover:shadow-xl hover:border-red-100 transition-all duration-300 flex flex-col h-full group relative">
    <div class="flex items-center justify-between mb-4 relative z-20">
        <div class="flex items-center gap-1.5 text-xs font-bold {{ $task->status_tugas === 'Aktif' ? 'text-red-600 bg-red-50' : 'text-gray-500 bg-gray-50' }} px-2 py-1 rounded-lg shadow-sm">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ $task->status_tugas ?? 'Aktif' }}
        </div>
        
        <!-- Dropdown Menu -->
        <div x-data="{ open: false }" class="relative">
            <button type="button" @click.stop="open = !open" @click.away="open = false" class="p-1.5 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
            </button>
            <div x-show="open" x-transition.opacity.scale.95 style="display: none;" class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-lg border border-gray-100 py-1.5 z-50">
                <button type="button" @click.stop.prevent="openEditModal({{ $task->id_tugas }}, {{ json_encode($task->judul_tugas) }}, {{ json_encode($task->waktu_pengumpulan) }}, {{ json_encode($task->deskripsi_tugas) }}, {{ json_encode($task->modul->mapel->id_batch ?? '') }}, {{ json_encode($task->modul->id_mapel ?? '') }}, {{ json_encode($task->id_modul) }}); open = false;" class="w-full text-left px-4 py-2.5 text-sm font-bold text-gray-700 hover:bg-gray-50 hover:text-[#d62828] flex items-center gap-3 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Edit Tugas
                </button>
                <button type="button" @click.stop.prevent="openDeleteModal({{ $task->id_tugas }}, {{ json_encode($task->judul_tugas) }}); open = false;" class="w-full text-left px-4 py-2.5 text-sm font-bold text-red-600 hover:bg-red-50 flex items-center gap-3 transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus Tugas
                </button>
            </div>
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
            $submittedStudents = $task->submissions->whereIn('status', ['dikirim', 'dinilai', 'terlambat'])->count();
            $totalStudents = \Illuminate\Support\Facades\DB::table('student_list_batch')->where('id_batch', $task->modul->mapel->id_batch)->where('status', 'Active')->count();
            $percentage = $totalStudents > 0 ? ($submittedStudents / $totalStudents) * 100 : 0;
        @endphp
        <div class="flex items-center justify-between text-[10px] font-bold mb-1 mt-3">
            <span class="text-gray-400 uppercase tracking-wider">Terkumpul</span>
            <span class="text-gray-800">{{ $submittedStudents }}/{{ $totalStudents }} Siswa</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
            <div class="bg-green-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ round($percentage) }}%"></div>
        </div>
    </div>
    <a href="{{ route('teacher.assignments.grade', $task->id_tugas) }}" class="w-full mt-auto bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 font-bold py-2.5 rounded-xl text-sm transition-colors duration-300 flex items-center justify-center gap-2 relative z-10 shadow-sm">
        Lihat Detail Tugas
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
    </a>
</div>
