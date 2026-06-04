@extends('layouts.teacher')

@section('title', ($batch->nama_batch ?? 'Batch') . ' - Kelas Saya - LPK Seishin')

@section('content')
@php
    // Dummy Data — Batch detail
    if (!isset($batch)) {
        $batch = (object)[
            'id_batch' => request()->route('id_batch') ?? 2,
            'nama_batch' => 'Batch ' . (request()->route('id_batch') ?? 2),
            'nama_program' => 'Regular Japanese Language Program',
            'target_level' => 'JLPT N5 - N4',
            'deskripsi' => 'Comprehensive program for beginners and intermediate learners.',
            'tanggal_mulai' => '01 Jan 2026',
            'tanggal_selesai' => '31 Dec 2026',
            'durasi' => '12 Months',
            'jadwal' => 'Monday - Friday',
            'total_siswa' => 4,
            'total_kelas' => 2,
            'status' => 'Active',
        ];
    }

    if (!isset($senseis)) {
        $senseis = [
            (object)['name' => 'Ahmad Hidayat', 'avatar' => null],
            (object)['name' => 'Neida Nurfadillah', 'avatar' => null],
        ];
    }

    if (!isset($batchClasses) || (is_countable($batchClasses) && count($batchClasses) == 0)) {
        $batchClasses = [
            (object)[
                'id_mapel' => 1,
                'nama_mapel' => 'N4 Mastering',
                'modul_count' => 7,
                'batch' => (object)['nama_batch' => $batch->nama_batch],
            ],
            (object)[
                'id_mapel' => 2,
                'nama_mapel' => 'N5 Mastering',
                'modul_count' => 8,
                'batch' => (object)['nama_batch' => $batch->nama_batch],
            ],
        ];
    }

    if (!isset($students) || (is_countable($students) && count($students) == 0)) {
        $students = [
            (object)[
                'no' => 1, 'id_siswa' => '012025004', 'name' => 'Ahmad Hidayat',
                'module_progress' => 60, 'avg_task' => 80, 'eval_score' => 90,
                'status' => 'Completed',
            ],
            (object)[
                'no' => 2, 'id_siswa' => '012025005', 'name' => 'Siti Nurhaliza',
                'module_progress' => 56, 'avg_task' => 75, 'eval_score' => 85,
                'status' => 'Active',
            ],
            (object)[
                'no' => 3, 'id_siswa' => '012025006', 'name' => 'Budi Santoso',
                'module_progress' => 52, 'avg_task' => 70, 'eval_score' => 78,
                'status' => 'Inactive',
            ],
            (object)[
                'no' => 4, 'id_siswa' => '012025007', 'name' => 'Dewi Lestari',
                'module_progress' => 64, 'avg_task' => 85, 'eval_score' => 92,
                'status' => 'Active',
            ],
            (object)[
                'no' => 5, 'id_siswa' => '012025008', 'name' => 'Rizky Aditya',
                'module_progress' => 58, 'avg_task' => 78, 'eval_score' => 88,
                'status' => 'Inactive',
            ],
            (object)[
                'no' => 6, 'id_siswa' => '012025009', 'name' => 'Lina Marlina',
                'module_progress' => 54, 'avg_task' => 72, 'eval_score' => 80,
                'status' => 'Active',
            ],
        ];
    }
@endphp

<div class="p-4 sm:p-6 lg:p-10" x-data>

    {{-- Header Row: Title + Breadcrumb + Create Button --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl lg:text-[26px] font-bold font-ibm text-gray-900 tracking-tight mb-1">{{ $batch->nama_batch }}</h1>
            <nav class="flex items-center gap-1.5 text-xs sm:text-sm">
                <a href="{{ route('teacher.classes') }}" class="text-gray-500 hover:text-gray-700 font-medium transition">Kelas Saya</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#d62828] font-semibold">{{ $batch->nama_batch }}</span>
            </nav>
        </div>
        <button @click="$dispatch('open-create-modal')" class="inline-flex items-center gap-2 bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-5 rounded-lg text-xs sm:text-sm transition shadow-sm self-start">
            Buat Kelas Baru
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </button>
    </div>

    {{-- Batch Information Card --}}
    <div class="bg-white border border-gray-100 rounded-2xl lg:rounded-3xl p-5 sm:p-6 lg:p-8 shadow-sm mb-8 relative">
        
        {{-- Card Title + Status --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-base font-ibm sm:text-lg font-bold text-gray-900">Informasi Batch</h2>
            <span class="inline-flex items-center gap-1.5 text-xs font-bold
                @if(($batch->status ?? 'Active') === 'Active') text-emerald-600
                @else text-gray-500 @endif">
                <span class="w-2 h-2 rounded-full 
                    @if(($batch->status ?? 'Active') === 'Active') bg-emerald-500
                    @else bg-gray-400 @endif"></span>
                {{ $batch->status ?? 'Active' }}
            </span>
        </div>

        {{-- 3-Column Info Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
            
            {{-- Overview --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-[#d62828] font-bold text-base">あa</span>
                    <h3 class="text-sm font-bold text-gray-800">Overview</h3>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide">Batch Order</p>
                        <p class="text-sm font-bold text-gray-900">{{ $batch->nama_batch }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide">Program Name</p>
                        <p class="text-sm font-bold text-gray-900">{{ $batch->nama_program ?? 'Regular Japanese Language Program' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide">Target Level</p>
                        <p class="text-sm font-bold text-gray-900">{{ $batch->target_level ?? 'JLPT N5 - N4' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide">Description</p>
                        <p class="text-sm font-medium text-gray-700 leading-relaxed">{{ $batch->deskripsi ?? 'Comprehensive program for beginners and intermediate learners.' }}</p>
                    </div>
                </div>
            </div>

            {{-- Dates & Schedule --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-5 h-5 flex items-center justify-center text-[#d62828]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800">Dates & Schedule</h3>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide">Batch Start Date</p>
                        <p class="text-sm font-bold text-gray-900">{{ $batch->tanggal_mulai ?? '01 Jan 2026' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide">Batch End Date</p>
                        <p class="text-sm font-bold text-gray-900">{{ $batch->tanggal_selesai ?? '31 Dec 2026' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide">Duration</p>
                        <p class="text-sm font-bold text-gray-900">{{ $batch->durasi ?? '12 Months' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide">Schedule</p>
                        <p class="text-sm font-bold text-gray-900">{{ $batch->jadwal ?? 'Monday - Friday' }}</p>
                    </div>
                </div>
            </div>

            {{-- Batch Statistics --}}
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-5 h-5 flex items-center justify-center text-[#d62828]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-800">Batch Statistics</h3>
                </div>
                <div class="space-y-3">
                    <div>
                        <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide">Total Students</p>
                        <p class="text-sm font-bold text-gray-900">{{ $batch->total_siswa ?? 4 }} Students</p>
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide">Assigned Classes</p>
                        <p class="text-sm font-bold text-gray-900">{{ $batch->total_kelas ?? 2 }} Classes</p>
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide">Sensei</p>
                        <div class="space-y-2 mt-1">
                            @foreach($senseis as $sensei)
                            <div class="flex items-center gap-2">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($sensei->name) }}&background=f3f4f6&color=d62828&bold=true&size=32" class="w-7 h-7 rounded-full object-cover border border-gray-100" alt="{{ $sensei->name }}">
                                <span class="text-sm font-semibold text-gray-800">{{ $sensei->name }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Tabs: Class List / Student List --}}
    <div class="mb-6" x-data="{ activeTab: 'class-list' }">
        
        {{-- Tab Headers --}}
        <div class="flex items-center gap-0 border-b border-gray-200 mb-6">
            <button @click="activeTab = 'class-list'" 
                    :class="activeTab === 'class-list' ? 'text-gray-900 border-b-2 border-gray-900' : 'text-gray-500 hover:text-gray-700 border-b-2 border-transparent'"
                    class="px-4 py-3 text-sm font-bold transition">
                Daftar Kelas
            </button>
            <button @click="activeTab = 'student-list'" 
                    :class="activeTab === 'student-list' ? 'text-gray-900 border-b-2 border-gray-900' : 'text-gray-500 hover:text-gray-700 border-b-2 border-transparent'"
                    class="px-4 py-3 text-sm font-bold transition">
                Daftar Siswa
            </button>
        </div>

        {{-- Tab Content: Class List --}}
        <div x-show="activeTab === 'class-list'" x-transition>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($batchClasses as $subject)
                <div class="bg-white border border-gray-100 rounded-2xl lg:rounded-3xl p-5 sm:p-6 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col gap-5">
                    {{-- Top Icons --}}
                    <div class="flex items-start justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-12 sm:w-14 h-12 sm:h-14 rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-gray-50 bg-white flex items-center justify-center text-[#d62828] font-bold text-lg sm:text-xl flex-shrink-0">
                                あa
                            </div>
                            <div class="w-12 sm:w-14 h-12 sm:h-14 rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-gray-50 bg-white flex flex-col items-center justify-center flex-shrink-0">
                                <p class="text-lg sm:text-xl font-bold text-gray-900 leading-none">
                                    {{ $subject->modul_count ?? 0 }}
                                </p>
                                <p class="text-[8px] sm:text-[9px] text-gray-500 font-semibold mt-0.5">Module</p>
                            </div>
                        </div>
                        <div class="bg-white border border-gray-100 shadow-sm px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full">
                            <span class="text-[10px] md:text-[12px] font-semibold text-gray-500 whitespace-nowrap">{{ $subject->batch->nama_batch ?? 'Batch' }}</span>
                        </div>
                    </div>

                    {{-- Class Title --}}
                    <h4 class="text-lg sm:text-xl font-bold text-gray-900 leading-snug line-clamp-2">{{ $subject->nama_mapel ?? 'Mata Pelajaran' }}</h4>

                    {{-- Action --}}
                    <div class="flex justify-end mt-auto">
                        <a href="{{ route('teacher.subjects.show', $subject->id_mapel ?? 0) }}" class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-2 sm:py-2.5 px-5 sm:px-6 rounded-lg text-xs sm:text-sm transition shadow-sm flex items-center justify-center gap-2">
                            Buka Kelas
                            <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-10 bg-gray-50 rounded-2xl lg:rounded-3xl border border-dashed border-gray-300">
                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <p class="text-gray-500 italic text-xs sm:text-sm">Belum ada kelas di batch ini.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Tab Content: Student List --}}
        <div x-show="activeTab === 'student-list'" x-cloak x-transition>
            
            {{-- Search & Status Filter --}}
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 mb-5">
                <div class="relative flex-1 sm:flex-initial">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" id="search-student" placeholder="Cari Siswa..." class="w-full sm:w-72 pl-10 pr-4 py-2.5 text-sm font-medium bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-300 transition placeholder:text-gray-400">
                </div>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                        Status
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 top-full mt-2 w-40 bg-white border border-gray-100 rounded-2xl shadow-lg p-2 z-20">
                        <button class="w-full text-left px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition">Semua</button>
                        <button class="w-full text-left px-3 py-2 text-xs font-semibold text-emerald-600 hover:bg-gray-50 rounded-xl transition">Active</button>
                        <button class="w-full text-left px-3 py-2 text-xs font-semibold text-red-500 hover:bg-gray-50 rounded-xl transition">Inactive</button>
                        <button class="w-full text-left px-3 py-2 text-xs font-semibold text-gray-500 hover:bg-gray-50 rounded-xl transition">Completed</button>
                    </div>
                </div>
            </div>

            {{-- Student Table --}}
            <div class="bg-white border border-gray-100 rounded-2xl lg:rounded-3xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider w-12">No</th>
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Siswa</th>
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Module Progress</th>
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Average Task</th>
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Evaluation Score</th>
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider w-16">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($students as $student)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-4 py-4 text-sm font-semibold text-gray-500">{{ $student->no }}</td>
                                <td class="px-4 py-4 text-sm font-semibold text-gray-700">{{ $student->id_siswa }}</td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($student->name) }}&background=f3f4f6&color=d62828&bold=true&size=32" class="w-8 h-8 rounded-full object-cover border border-gray-100 flex-shrink-0" alt="{{ $student->name }}">
                                        <span class="text-sm font-semibold text-gray-800 whitespace-nowrap">{{ $student->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-20 bg-gray-100 rounded-full h-2 flex-shrink-0">
                                            <div class="bg-gradient-to-r from-[#d62828] to-[#e85d5d] h-2 rounded-full" style="width: {{ $student->module_progress }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-700 whitespace-nowrap">{{ $student->module_progress }}%</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-sm font-semibold text-gray-700">{{ $student->avg_task }}</td>
                                <td class="px-4 py-4 text-sm font-semibold text-gray-700">{{ $student->eval_score }}</td>
                                <td class="px-4 py-4">
                                    @if($student->status === 'Active')
                                        <span class="inline-block px-3 py-1 text-[11px] font-bold text-emerald-600 bg-emerald-50 border border-emerald-200 rounded-full">Active</span>
                                    @elseif($student->status === 'Inactive')
                                        <span class="inline-block px-3 py-1 text-[11px] font-bold text-red-500 bg-red-50 border border-red-200 rounded-full">Inactive</span>
                                    @elseif($student->status === 'Completed')
                                        <span class="inline-block px-3 py-1 text-[11px] font-bold text-emerald-700 bg-emerald-100 border border-emerald-300 rounded-full">Completed</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        </div>

@push('modals')
    {{-- Modal Create New Class --}}
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-create-modal.window="open = true"
         style="display: none;"
         class="fixed inset-0 z-[100] overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <!-- Background overlay -->
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" 
             @click="open = false"></div>

        <!-- Modal panel -->
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-[32px] bg-white text-left shadow-xl transition-all w-full max-w-4xl border border-gray-100">
                 
                 <!-- Close Button -->
                 <button @click="open = false" class="absolute top-6 right-6 p-2 rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                 </button>

                 <!-- Content -->
                 <div class="p-6 sm:p-8 lg:p-10">
                     <div class="flex items-center gap-3 mb-8">
                         <h3 class="text-xl sm:text-2xl font-bold font-ibm text-gray-900" id="modal-title">Tambah Kelas Baru</h3>
                         <span class="px-3 py-1 rounded-full bg-gray-200 text-xs font-bold font-karla text-gray-700">Ditambahkan ke: {{ $batch->nama_batch }}</span>
                     </div>

                     <!-- Form Grid -->
                     <form @submit.prevent="
                         isLoading = true;
                         setTimeout(() => {
                             isLoading = false;
                             open = false;
                             $dispatch('show-toast', { message: 'Kelas berhasil ditambahkan!' });
                         }, 1000);
                     " x-data="{ isLoading: false }">
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                             
                             <!-- Left Column -->
                             <div class="space-y-6">
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Nama Kelas:</label>
                                     <input type="text" required placeholder="cth., N4 Mastering - Kelas A" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                                 </div>
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Deskripsi:</label>
                                     <textarea rows="5" required placeholder="Tulis deskripsi singkat...." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm resize-y min-h-[120px]"></textarea>
                                 </div>
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Mentor Sensei:</label>
                                     <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl">
                                         <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f3f4f6&color=d62828&bold=true" class="w-8 h-8 rounded-full border border-white shadow-sm" alt="Sensei">
                                         <span class="text-sm font-bold font-karla text-gray-900">{{ Auth::user()->name }}</span>
                                     </div>
                                 </div>
                             </div>

                             <!-- Right Column -->
                             <div class="space-y-6">
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Target Sertifikasi:</label>
                                     <div class="relative">
                                         <select required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm appearance-none bg-none pr-10 bg-white">
                                             <option value="" disabled selected>Pilih Target Sertifikasi</option>
                                             <option>JLPT N4</option>
                                             <option>JLPT N5</option>
                                             <option>JFT-Basic A2</option>
                                         </select>
                                         <svg class="w-4 h-4 text-gray-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                     </div>
                                 </div>
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Total Durasi (JP):</label>
                                     <input type="text" required placeholder="cth., 264" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                                 </div>
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Jadwal:</label>
                                     <input type="text" required placeholder="cth., Senin - Jumat" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                                 </div>
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Nilai Kelulusan Minimum:</label>
                                     <input type="text" required placeholder="cth., 80" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                                 </div>
                             </div>

                         </div>

                         <!-- Actions -->
                         <div class="mt-2 flex items-center gap-4 pt-6">
                             <button type="button" @click="open = false" class="px-6 py-3 rounded-xl border border-[#d62828] text-[#d62828] font-bold font-karla hover:bg-red-50 transition w-full sm:w-auto sm:flex-1 text-sm sm:text-base">
                                 Batal
                             </button>
                             <button type="submit" :disabled="isLoading" class="px-6 py-3 rounded-xl bg-[#d62828] text-white font-bold font-karla hover:bg-red-700 shadow-sm transition w-full sm:w-auto sm:flex-[2.5] text-sm sm:text-base flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                                 <svg x-show="isLoading" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                 <span x-text="isLoading ? 'Memproses...' : 'Buat Kelas'"></span>
                             </button>
                         </div>
                     </form>
                 </div>
            </div>
        </div>
    </div>

    {{-- Global Toast Notification --}}
    <div x-data="{ show: false, message: '' }" 
         x-on:show-toast.window="
            message = $event.detail.message;
            show = true;
            setTimeout(() => show = false, 3000);
         "
         class="fixed bottom-6 right-6 z-[110] flex flex-col gap-2 pointer-events-none">
        
        <div x-show="show" style="display: none;"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-4"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-2xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 flex items-center p-4 gap-4 border border-gray-100">
             
             <!-- Success Icon -->
             <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-50 flex items-center justify-center">
                 <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                 </svg>
             </div>
             
             <!-- Text -->
             <div class="flex-1">
                 <p class="text-sm font-bold font-ibm text-gray-900" x-text="message"></p>
                 <p class="text-xs font-karla text-gray-500 mt-0.5">Sistem telah diperbarui.</p>
             </div>
             
             <!-- Close -->
             <button @click="show = false" class="text-gray-400 hover:text-gray-500 transition">
                 <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                     <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                 </svg>
             </button>
        </div>
    </div>
@endpush

</div>
@endsection
