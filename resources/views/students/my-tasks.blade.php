@extends('layouts.student')

@section('title', 'Ruang Tugas Saya - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10 space-y-6" x-data="tasksList()">
    
    <div class="flex items-center justify-between mb-8 relative z-50">
        <div class="text-left">
            <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Tugas Saya</h1>
            <p class="text-sm text-[#666666] font-medium mt-2">Ruang Tugas</p>
        </div>
        
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.away="open = false" class="flex items-center gap-2 bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-xs font-bold text-gray-700 hover:bg-gray-50 transition shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500/20">
                Saring 
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
            </button>

            <!-- Dropdown Menu -->
            <div x-show="open" x-cloak style="display: none;"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden py-2 text-left">
                
                <div class="px-4 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status</div>
                <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer transition">
                    <input type="radio" x-model="filterStatus" value="semua" class="text-[#d62828] focus:ring-[#d62828]">
                    <span class="ml-3 text-sm font-semibold text-gray-700">Semua Tugas</span>
                </label>
                <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer transition">
                    <input type="radio" x-model="filterStatus" value="belum" class="text-[#d62828] focus:ring-[#d62828]">
                    <span class="ml-3 text-sm font-semibold text-gray-700">Belum Selesai</span>
                </label>
                <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer transition">
                    <input type="radio" x-model="filterStatus" value="terkirim" class="text-[#d62828] focus:ring-[#d62828]">
                    <span class="ml-3 text-sm font-semibold text-gray-700">Terkirim</span>
                </label>
                <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer transition">
                    <input type="radio" x-model="filterStatus" value="terlewat" class="text-[#d62828] focus:ring-[#d62828]">
                    <span class="ml-3 text-sm font-semibold text-gray-700">Terlewat</span>
                </label>

                <div class="border-t border-gray-100 my-2"></div>
                
                <div class="px-4 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Urutkan</div>
                <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer transition">
                    <input type="radio" x-model="sortOrder" value="terdekat" class="text-[#d62828] focus:ring-[#d62828]">
                    <span class="ml-3 text-sm font-semibold text-gray-700">Tenggat Terdekat</span>
                </label>
                <label class="flex items-center px-4 py-2.5 hover:bg-gray-50 cursor-pointer transition">
                    <input type="radio" x-model="sortOrder" value="terjauh" class="text-[#d62828] focus:ring-[#d62828]">
                    <span class="ml-3 text-sm font-semibold text-gray-700">Tenggat Terjauh</span>
                </label>
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <template x-for="task in filteredTasks" :key="task.id_tugas">
            <div class="p-4 bg-white border border-gray-100 rounded-[24px] flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm hover:shadow-md transition duration-200">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="w-12 h-12 bg-red-50 text-[#d62828] rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div class="min-w-0 text-left">
                        <h3 class="text-sm lg:text-base font-bold text-[#222222] truncate" x-text="task.judul_tugas"></h3>
                        <div class="inline-block bg-amber-50 rounded-lg px-2.5 py-1 mt-1.5">
                            <p class="text-[10px] font-bold text-amber-600 tracking-wide" x-text="'Tenggat: ' + task.waktu_formatted"></p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between sm:justify-end gap-6 flex-shrink-0">
                    <span class="text-[11px] font-bold uppercase tracking-wider" :class="task.status_class" x-text="task.status_text"></span>

                    <a :href="task.url" class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs shadow-sm transition duration-200 flex items-center gap-1.5">
                        <span>Buka Tugas</span>
                        <svg class="w-3.5 h-3.5 mt-[0.5px]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </template>

        <div x-show="filteredTasks.length === 0" x-cloak style="display: none;" class="p-12 text-center bg-gray-50/50 rounded-[32px] border border-dashed border-gray-200">
            <p class="text-sm font-medium text-gray-400 italic" x-text="rawTasks.length === 0 ? 'Belum ada tugas yang tersedia pada seluruh kelas yang kamu kontrak saat ini.' : 'Tidak ada tugas yang sesuai dengan filter.'"></p>
        </div>
    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('tasksList', () => ({
            filterStatus: 'semua',
            sortOrder: 'terdekat',
            rawTasks: [
                @foreach($tasks as $task)
                    @php
                        $isSubmitted = !is_null($task->id_pengiriman);
                        $isOverdue = \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($task->waktu_pengumpulan));

                        if ($isSubmitted) {
                            $statusCode = 'terkirim';
                            $statusText = 'Terkirim';
                            $statusClass = 'text-green-500';
                        } elseif ($isOverdue) {
                            $statusCode = 'terlewat';
                            $statusText = 'Terlewat';
                            $statusClass = 'text-red-500';
                        } else {
                            $statusCode = 'belum';
                            $statusText = 'Belum Selesai';
                            $statusClass = 'text-gray-400';
                        }
                    @endphp
                    {
                        id_tugas: {{ $task->id_tugas }},
                        judul_tugas: "{{ addslashes($task->judul_tugas) }}",
                        waktu_pengumpulan: "{{ $task->waktu_pengumpulan }}",
                        waktu_formatted: "{{ \Carbon\Carbon::parse($task->waktu_pengumpulan)->translatedFormat('d M Y, H:i') }}",
                        status_code: "{{ $statusCode }}",
                        status_text: "{{ $statusText }}",
                        status_class: "{{ $statusClass }}",
                        url: "{{ route('tasks.show', ['id_mapel' => $task->id_mapel, 'id_modul' => $task->id_modul, 'id_tugas' => $task->id_tugas]) }}"
                    },
                @endforeach
            ],
            get filteredTasks() {
                let result = this.rawTasks;

                if (this.filterStatus !== 'semua') {
                    result = result.filter(t => t.status_code === this.filterStatus);
                }

                result = result.sort((a, b) => {
                    let dateA = new Date(a.waktu_pengumpulan);
                    let dateB = new Date(b.waktu_pengumpulan);
                    return this.sortOrder === 'terdekat' ? dateA - dateB : dateB - dateA;
                });

                return result;
            }
        }));
    });
</script>
@endpush
@endsection