@extends('layouts.teacher')

@section('title', 'Detail Tugas - LPK Seishin')

@section('content')
@php
    $currentModuleId = request()->route('id_modul') ?? 2;
    $currentTaskId = request()->route('id_tugas') ?? 1;
    // Dummy Data
    $batchName = 'Batch 2';
    $className = 'N4 Mastering';
    
    $taskTitle = 'N4 Exercise';
    $dueDate = '8 Mei 2026, 23:59';
    $status = 'Active';

    // Submissions Dummy Data
    $submissions = [
        (object)[
            'no' => 1,
            'id_siswa' => 'SIS-001',
            'name' => 'Ahmad Hidayat',
            'status' => 'Belum Dikumpulkan',
            'submitted_at' => '-',
            'score' => '-'
        ],
        (object)[
            'no' => 2,
            'id_siswa' => 'SIS-002',
            'name' => 'Budi Santoso',
            'status' => 'Menunggu Penilaian',
            'submitted_at' => '8 Mei 2026, 14:30',
            'score' => '-'
        ],
        (object)[
            'no' => 3,
            'id_siswa' => 'SIS-003',
            'name' => 'Citra Lestari',
            'status' => 'Sudah Dinilai',
            'submitted_at' => '7 Mei 2026, 09:15',
            'score' => '85'
        ],
        (object)[
            'no' => 4,
            'id_siswa' => 'SIS-004',
            'name' => 'Deni Pratama',
            'status' => 'Sudah Dinilai',
            'submitted_at' => '7 Mei 2026, 11:20',
            'score' => '90'
        ]
    ];
@endphp

<div class="p-4 sm:p-6 lg:p-10 bg-[#fdfdfc] min-h-screen" x-data="{ showDeleteModal: false, showFilter: false, showReviewPanel: false, reviewData: { id: '', name: '', time: '', score: '' } }">

    {{-- Header Row: Title + Breadcrumb --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('teacher.modules.show', $currentModuleId ?? 2) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-gray-900 tracking-tight">Detail Tugas</h1>
            </div>
            <nav class="flex flex-wrap items-center gap-1.5 text-xs sm:text-sm font-karla">
                <a href="{{ route('teacher.classes') }}" class="text-gray-500 hover:text-gray-700 transition font-medium">Kelas Saya</a>
                <span class="text-gray-400">›</span>
                <a href="{{ route('teacher.batch.show', 2) }}" class="text-gray-500 hover:text-gray-700 transition font-medium">{{ $batchName }}</a>
                <span class="text-gray-400">›</span>
                <a href="{{ route('teacher.subjects.show', 1) }}" class="text-gray-500 hover:text-gray-700 transition font-medium">{{ $className }}</a>
                <span class="text-gray-400">›</span>
                <a href="{{ route('teacher.modules.show', $currentModuleId) }}" class="text-gray-500 hover:text-gray-700 transition font-medium">Modul {{ $currentModuleId }}</a>
                <span class="text-gray-400">›</span>
                <span class="text-[#d62828] font-bold">{{ $taskTitle }}</span>
            </nav>
        </div>
        <div class="flex items-center gap-3">
            <a href="#" class="inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-2.5 px-5 rounded-xl text-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit
            </a>
            <button @click="showDeleteModal = true" class="inline-flex items-center gap-2 bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-5 rounded-xl text-sm transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                Hapus
            </button>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
        
        {{-- Left Column: Task Info (Spans 1/3) --}}
        <div class="xl:col-span-1">
            <h2 class="text-xl sm:text-2xl font-bold font-ibm text-gray-900 mb-6">{{ $taskTitle }}</h2>
            
            <div class="grid grid-cols-3 gap-3 sm:gap-4 mb-6">
                <div class="bg-white border border-gray-100 rounded-xl p-4 flex flex-col justify-center">
                    <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide mb-1">Modul</p>
                    <p class="text-sm font-bold text-gray-900 truncate">{{ $className }}</p>
                </div>
                <div class="bg-white border border-gray-100 rounded-xl p-4 flex flex-col justify-center">
                    <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide mb-1">Status</p>
                    <p class="text-sm font-bold text-gray-900 truncate">{{ $status }}</p>
                </div>
                <div class="bg-white border border-gray-100 rounded-xl p-4 flex flex-col justify-center">
                    <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide mb-1">Tenggat</p>
                    <p class="text-sm font-bold text-gray-900 truncate" title="{{ $dueDate }}">{{ explode(',', $dueDate)[0] }}</p>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-2xl p-6 sm:p-8 shadow-sm">
                <h3 class="text-sm font-bold font-ibm text-gray-900 mb-4">Deskripsi Tugas</h3>
                <div class="prose prose-sm font-karla text-gray-600 prose-p:leading-relaxed prose-a:text-red-500 hover:prose-a:text-red-700 max-w-none">
                    <p>Latihan ini dirancang untuk menguji pemahaman awal kamu mengenai perubahan dari level N5 ke N4, khususnya pada penguasaan 20 Kanji pertama yang telah dibahas dalam materi "Introduction to N4".</p>
                    <p>Kamu diharapkan mampu mengidentifikasi cara baca (Onyomi/Kunyomi) serta menggunakan kanji tersebut dalam kalimat sederhana.</p>
                </div>

                <h3 class="text-sm font-bold font-ibm text-gray-900 mt-8 mb-4">Sumber Daya</h3>
                <a href="#" class="flex items-center justify-between p-4 border border-gray-200 rounded-xl hover:border-red-300 transition group bg-gray-50/50">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 flex items-center justify-center bg-red-100 rounded-lg text-red-600 flex-shrink-0 group-hover:bg-[#d62828] group-hover:text-white transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-sm font-bold font-karla text-gray-900 truncate group-hover:text-[#d62828] transition">Template_N4_Exercise.pdf</p>
                            <p class="text-xs font-semibold text-gray-500">PDF &bull; 1.2 MB</p>
                        </div>
                    </div>
                    <div class="text-[#d62828] bg-white border border-red-200 group-hover:bg-red-50 text-xs font-bold py-2 px-4 rounded-lg flex items-center gap-2 transition flex-shrink-0 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        <span class="hidden sm:inline">Download</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- Right Column: Submissions Table (Spans 2/3 on xl) --}}
        <div class="xl:col-span-2">
            
            <div class="bg-white border border-gray-100 rounded-[24px] h-full flex flex-col shadow-sm">
                <div class="p-6 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                    <h2 class="text-lg font-bold font-ibm text-gray-900">Daftar Pengumpulan Tugas</h2>
                    
                    {{-- Form Filter untuk Backend --}}
                    <form method="GET" action="" class="flex items-center gap-3">
                        {{-- input hidden untuk query param lain jika perlu (contoh: status dll) --}}
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        
                        <div class="relative flex-1 sm:flex-initial">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Siswa..." class="w-full sm:w-60 pl-10 pr-4 py-2.5 text-sm font-medium bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:bg-white focus:border-red-300 focus:ring-2 focus:ring-red-100 transition placeholder:text-gray-400">
                        </div>
                        <div class="relative">
                            <button type="button" @click="showFilter = !showFilter" class="flex items-center gap-2 px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-600 hover:bg-white hover:border-gray-300 transition whitespace-nowrap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                Filter
                            </button>
                            
                            {{-- Dropdown Filter Menu --}}
                            <div x-show="showFilter" @click.away="showFilter = false" x-transition.opacity class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-10" style="display: none;">
                                <div class="px-4 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Status Tugas</div>
                                <a href="?status=" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#d62828] transition">Semua Status</a>
                                <a href="?status=belum" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#d62828] transition">Belum Dikumpulkan</a>
                                <a href="?status=menunggu" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#d62828] transition">Menunggu Penilaian</a>
                                <a href="?status=selesai" class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-red-50 hover:text-[#d62828] transition">Sudah Dinilai</a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-t border-gray-100">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider w-14 border-b border-gray-100">No</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Siswa</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Waktu Kumpul</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Status</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider border-b border-gray-100">Nilai</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-gray-500 uppercase tracking-wider text-right border-b border-gray-100">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($submissions as $sub)
                            <tr class="hover:bg-gray-50/50 transition border-b border-gray-50 last:border-b-0">
                                <td class="px-6 py-6 sm:py-7 text-sm font-semibold text-gray-500">{{ $sub->no }}</td>
                                <td class="px-6 py-6 sm:py-7">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-red-50 text-red-600 flex items-center justify-center text-xs font-bold border border-red-100 flex-shrink-0">
                                            {{ collect(explode(' ', $sub->name))->map(fn($w) => substr($w, 0, 1))->take(2)->join('') }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-900 whitespace-nowrap mb-0.5">{{ $sub->name }}</p>
                                            <p class="text-xs font-semibold text-gray-500">{{ $sub->id_siswa }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 sm:py-7 text-sm font-semibold text-gray-700 whitespace-nowrap">{{ $sub->submitted_at }}</td>
                                <td class="px-6 py-6 sm:py-7">
                                    @if($sub->status === 'Belum Dikumpulkan')
                                        <span class="inline-block px-3 py-1.5 text-[11px] font-bold text-gray-600 bg-gray-100 border border-gray-200 rounded-full whitespace-nowrap">
                                            Belum Kumpul
                                        </span>
                                    @elseif($sub->status === 'Menunggu Penilaian')
                                        <span class="inline-block px-3 py-1.5 text-[11px] font-bold text-[#b45309] bg-[#fffbeb] border border-[#fde68a] rounded-full whitespace-nowrap">
                                            Menunggu Nilai
                                        </span>
                                    @elseif($sub->status === 'Sudah Dinilai')
                                        <span class="inline-block px-3 py-1.5 text-[11px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-full whitespace-nowrap">
                                            Selesai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-6 sm:py-7">
                                    @if($sub->score !== '-')
                                        <span class="text-sm font-bold text-gray-900">{{ $sub->score }}<span class="text-[11px] text-gray-400 font-medium">/100</span></span>
                                    @else
                                        <span class="text-sm font-semibold text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-6 sm:py-7 text-right">
                                    @if($sub->status !== 'Belum Dikumpulkan')
                                    <button @click="reviewData = { id: '{{ $sub->id_siswa }}', name: '{{ $sub->name }}', time: '{{ $sub->submitted_at }}', score: '{{ $sub->score !== '-' ? $sub->score : '' }}' }; showReviewPanel = true" class="inline-flex items-center gap-1 text-xs font-bold text-[#d62828] hover:text-red-800 transition whitespace-nowrap">
                                        Periksa
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </button>
                                    @else
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-gray-300 cursor-not-allowed whitespace-nowrap">
                                        Periksa
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500 text-sm">
                                    Belum ada data pengumpulan tugas.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination Dummy (Prepared for Backend) --}}
                <div class="px-6 sm:px-8 py-6 sm:py-7 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-auto">
                    {{-- Saat integrasi dengan backend, gunakan ini: --}}
                    {{-- {{ $submissions->links() }} --}}
                    
                    {{-- Dummy UI --}}
                    <p class="text-xs font-semibold text-gray-500 text-center sm:text-left">Menampilkan 1 hingga 4 dari 4 siswa</p>
                    <div class="flex items-center justify-center gap-2">
                        <button class="p-1.5 text-gray-400 hover:text-gray-700 transition" disabled>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#d62828] text-white text-xs font-bold shadow-sm">1</button>
                        <button class="p-1.5 text-gray-400 hover:text-gray-700 transition" disabled>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>

            </div>

        </div>

    </div>

    {{-- Modal Hapus Tugas --}}
    <template x-teleport="body">
        <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center px-4">
            <div x-show="showDeleteModal" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            <div x-show="showDeleteModal" @click.outside="showDeleteModal = false" class="relative bg-white rounded-[24px] w-full max-w-sm p-6 shadow-xl" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                <div class="w-16 h-16 rounded-full bg-red-50 text-red-500 flex items-center justify-center mb-5 mx-auto">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <h3 class="text-xl font-bold font-ibm text-gray-900 text-center mb-2">Hapus Tugas Ini?</h3>
                <p class="text-sm text-gray-500 font-karla text-center mb-6">Tugas beserta semua data pengumpulan siswa akan terhapus dan tidak bisa dikembalikan.</p>
                
                {{-- Form Delete Backend --}}
                <form method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="flex gap-3">
                        <button type="button" @click="showDeleteModal = false" class="flex-1 py-3 rounded-xl border border-gray-200 text-gray-700 font-bold font-karla text-sm hover:bg-gray-50 transition">Batal</button>
                        <button type="button" @click="window.location.href='{{ route('teacher.modules.show', $currentModuleId) }}'" class="flex-1 py-3 rounded-xl bg-[#d62828] text-white font-bold font-karla text-sm hover:bg-red-700 transition shadow-sm">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    {{-- Slide-Over Panel Periksa Tugas --}}
    <template x-teleport="body">
        <div x-show="showReviewPanel" style="display: none;" class="fixed inset-0 z-[100] flex justify-end">
            {{-- Backdrop --}}
            <div x-show="showReviewPanel" @click="showReviewPanel = false" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
            
            {{-- Panel --}}
            <div x-show="showReviewPanel" class="relative w-full max-w-[500px] bg-white h-full shadow-2xl flex flex-col" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">
                
                {{-- Header --}}
                <div class="flex items-center justify-between p-6 border-b border-gray-100 flex-shrink-0 bg-white">
                    <div>
                        <h2 class="text-lg font-bold font-ibm text-gray-900">Periksa Tugas</h2>
                        <p class="text-xs font-karla text-gray-500">Berikan Penilaian & Catatan</p>
                    </div>
                    <button @click="showReviewPanel = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                {{-- Content --}}
                <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-8 bg-gray-50/50">
                    
                    {{-- Student Info --}}
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">Informasi Siswa</p>
                        <div class="flex items-center gap-4 bg-white p-4 rounded-[16px] border border-gray-100 shadow-sm">
                            <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center text-sm font-bold border border-red-100 flex-shrink-0" x-text="reviewData.name ? reviewData.name.substring(0,2).toUpperCase() : ''">
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 mb-0.5" x-text="reviewData.name"></h3>
                                <div class="flex items-center gap-2 text-xs font-semibold text-gray-500">
                                    <span x-text="reviewData.id"></span>
                                    <span>&bull;</span>
                                    <span x-text="reviewData.time"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submitted File --}}
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">File Pengumpulan</p>
                        <div class="flex items-center justify-between p-4 bg-white border border-gray-200 hover:border-red-300 rounded-[16px] shadow-sm transition group cursor-pointer">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center bg-red-50 border border-red-100 rounded-xl text-red-500 flex-shrink-0 group-hover:bg-[#d62828] group-hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[13px] font-bold text-gray-900 truncate mb-0.5">Tugas_<span x-text="reviewData.name ? reviewData.name.replace(/\s+/g, '_') : ''"></span>.pdf</p>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">PDF &bull; 2.4 MB</p>
                                </div>
                            </div>
                            <div class="text-gray-400 group-hover:text-[#d62828] transition p-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Grading Form --}}
                    <div>
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">Penilaian</p>
                        <form action="" method="POST" class="flex flex-col gap-5">
                            @csrf
                            {{-- Dummy input for student ID --}}
                            <input type="hidden" name="student_id" :value="reviewData.id">
                            
                            <div class="space-y-1.5">
                                <x-input-label>Nilai (0 - 100)</x-input-label>
                                <x-text-input type="number" name="score" min="0" max="100" x-model="reviewData.score" placeholder="Masukkan nilai..." required />
                            </div>

                            <div class="space-y-1.5">
                                <x-input-label>Catatan / Feedback <span class="text-gray-400 font-normal">(Opsional)</span></x-input-label>
                                <textarea name="feedback" rows="5" placeholder="Tuliskan evaluasi atau masukan untuk siswa..." class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm resize-y shadow-sm"></textarea>
                            </div>
                        </form>
                    </div>

                </div>

                {{-- Footer / Actions --}}
                <div class="p-6 border-t border-gray-100 flex-shrink-0 bg-white flex gap-3">
                    <button type="button" @click="showReviewPanel = false" class="flex-1 py-3.5 bg-gray-50 hover:bg-gray-100 border border-gray-200 text-gray-700 rounded-xl font-bold font-karla text-sm transition">Batal</button>
                    <x-primary-button type="button" @click="showReviewPanel = false" class="flex-1 justify-center gap-2 py-3.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Nilai
                    </x-primary-button>
                </div>
                
            </div>
        </div>
    </template>

</div>
@endsection
