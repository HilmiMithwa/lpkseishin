@extends('layouts.teacher')

@section('title', ($batch->nama_batch ?? 'Batch') . ' - Kelas Saya - LPK Seishin')

@section('content')

<div class="p-4 sm:p-6 lg:p-10" x-data>

    {{-- Header Row: Title + Breadcrumb + Create Button --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('teacher.classes') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-gray-900 tracking-tight">{{ $batch->nama_batch }}</h1>
            </div>
            <x-breadcrumbs :links="[
                'Kelas Saya' => route('teacher.classes'),
                $batch->nama_batch => '#'
            ]" />
        </div>
        <button @click="$dispatch('open-modal', 'create-modal')" class="inline-flex items-center gap-2 bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-5 rounded-lg text-xs sm:text-sm transition shadow-sm self-start">
            Buat Kelas Baru
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        </button>
    </div>

    {{-- Batch Information Card --}}
    <x-card class="mb-8 relative">
        
        {{-- Card Title + Status --}}
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-base font-ibm sm:text-lg font-bold text-gray-900">Informasi Batch</h2>
            <span class="inline-flex items-center gap-1.5 text-xs font-bold {{ ($batch->status ?? 'Active') === 'Active' ? 'text-emerald-600' : 'text-gray-500' }}">
                <span class="w-2 h-2 rounded-full {{ ($batch->status ?? 'Active') === 'Active' ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
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
                        <p class="text-sm font-bold text-gray-900">{{ $batch->total_siswa }} Students</p>
                    </div>
                    <div>
                        <p class="text-[10px] sm:text-[11px] text-gray-500 font-semibold uppercase tracking-wide">Assigned Classes</p>
                        <p class="text-sm font-bold text-gray-900">{{ $batch->total_kelas }} Classes</p>
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
    </x-card>

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
                        <button class="status-filter-btn w-full text-left px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-50 rounded-xl transition" data-status="all">Semua</button>
                        <button class="status-filter-btn w-full text-left px-3 py-2 text-xs font-semibold text-emerald-600 hover:bg-gray-50 rounded-xl transition" data-status="active">Active</button>
                        <button class="status-filter-btn w-full text-left px-3 py-2 text-xs font-semibold text-red-500 hover:bg-gray-50 rounded-xl transition" data-status="inactive">Inactive</button>
                        <button class="status-filter-btn w-full text-left px-3 py-2 text-xs font-semibold text-gray-500 hover:bg-gray-50 rounded-xl transition" data-status="completed">Completed</button>
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
                            <tr class="student-row hover:bg-gray-50/50 transition" 
                                data-name="{{ strtolower($student->name) }}" 
                                data-status="{{ strtolower($student->status) }}">
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
                                        <x-badge type="success">Active</x-badge>
                                    @elseif($student->status === 'Inactive')
                                        <x-badge type="danger">Inactive</x-badge>
                                    @elseif($student->status === 'Completed')
                                        <x-badge type="info">Completed</x-badge>
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
    <x-modal name="create-modal" maxWidth="4xl">
        <div class="p-6 sm:p-8 lg:p-10 relative">
            <!-- Close Button -->
            <button @click="$dispatch('close')" class="absolute top-6 right-6 p-2 rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="flex items-center gap-3 mb-8">
                <h3 class="text-xl sm:text-2xl font-bold font-ibm text-gray-900" id="modal-title">Tambah Kelas Baru</h3>
                <span class="px-3 py-1 rounded-full bg-gray-200 text-xs font-bold font-karla text-gray-700">Ditambahkan ke: {{ $batch->nama_batch }}</span>
            </div>
            <form action="{{ route('teacher.classes.store', $batch->id_batch) }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                     
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div class="space-y-1.5">
                            <x-input-label>Nama Kelas:</x-input-label>
                            <x-text-input type="text" name="nama_mapel" required placeholder="cth., N4 Mastering - Kelas A" class="w-full" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Deskripsi:</x-input-label>
                            <textarea name="deskripsi_mapel" required placeholder="Tulis deskripsi singkat...." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#d62828] focus:ring-1 focus:ring-[#d62828] outline-none transition font-karla text-sm resize-y min-h-[120px] shadow-sm"></textarea>
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Mentor Sensei:</x-input-label>
                            <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 border border-gray-100 rounded-xl">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f3f4f6&color=d62828&bold=true" class="w-8 h-8 rounded-full border border-white shadow-sm" alt="Sensei">
                                <span class="text-sm font-bold font-karla text-gray-900">{{ Auth::user()->name }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div class="space-y-1.5">
                            <x-input-label>Target Sertifikasi:</x-input-label>
                            <div class="relative">
                                <select name="target" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#d62828] focus:ring-1 focus:ring-[#d62828] outline-none transition font-karla text-sm appearance-none bg-none pr-10 bg-white">
                                    <option value="" disabled selected>Pilih Target Sertifikasi</option>
                                    <option value="JLPT N4">JLPT N4</option>
                                    <option value="JLPT N5">JLPT N5</option>
                                    <option value="JFT-Basic A2">JFT-Basic A2</option>
                                </select>
                                <svg class="w-4 h-4 text-gray-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Total Durasi (JP):</x-input-label>
                            <x-text-input type="number" name="jp" required placeholder="cth., 264" class="w-full" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Jadwal:</x-input-label>
                            <x-text-input type="text" name="jadwal" required placeholder="cth., Senin - Jumat" class="w-full" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Nilai Kelulusan Minimum:</x-input-label>
                            <x-text-input type="number" name="min_score" required placeholder="cth., 80" class="w-full" />
                        </div>
                    </div>
                </div>
                <!-- Actions -->
                <div class="mt-2 flex items-center gap-4 pt-6">
                    <x-outline-button type="button" @click="$dispatch('close')" class="w-full sm:w-auto sm:flex-1 text-sm sm:text-base py-3">
                        Batal
                    </x-outline-button>
                    <x-primary-button type="submit" class="w-full sm:w-auto sm:flex-[2.5] justify-center text-sm sm:text-base py-3">
                        Simpan Kelas
                    </x-primary-button>
                </div>
            </form>

        </div>
    </x-modal>

    {{-- Global Toast Notification --}}
    <div x-data="{show: {{ session('success') ? 'true' : 'false' }}, message: '{{ session('success') }}'}" 
        x-init="if(show) { setTimeout(() => show = false, 3000) }"
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
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-student');
        const statusButtons = document.querySelectorAll('.status-filter-btn');
        const studentRows = document.querySelectorAll('.student-row');
        let currentStatus = 'all';
        let currentQuery = '';

        function filterStudents() {
            studentRows.forEach(row => {
                const name = row.dataset.name || '';
                const status = row.dataset.status || '';
                
                const matchesQuery = name.includes(currentQuery);
                const matchesStatus = (currentStatus === 'all') || (status === currentStatus);

                if (matchesQuery && matchesStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Event pencarian
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                currentQuery = this.value.toLowerCase();
                filterStudents();
            });
        }

        // Event filter status
        statusButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                currentStatus = this.dataset.status;
                filterStudents();
            });
        });
    });
</script>
@endpush


@endsection
