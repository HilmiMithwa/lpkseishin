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
                                <img src="{{ $sensei->avatar_url }}" onerror="this.onerror=null; this.src='{{ $sensei->fallback_avatar_url }}'" class="w-7 h-7 rounded-full object-cover border border-gray-100" alt="{{ $sensei->name }}">
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
    @php
        $isStudentTabActive = request()->hasAny(['search', 'status', 'page', 'per_page']);
    @endphp
    <div class="mb-6" x-data="{ activeTab: '{{ $isStudentTabActive ? 'student-list' : 'class-list' }}' }">
        
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
            
            {{-- Search & Status Filter (AJAX) --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-5">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full sm:w-auto">
                    {{-- Search Input --}}
                    <div class="relative flex-1 sm:flex-initial w-full sm:w-72">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" id="dt-search" placeholder="Cari Siswa..." class="w-full pl-10 pr-4 py-2.5 text-sm font-medium bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-300 transition placeholder:text-gray-400">
                    </div>
                    
                    {{-- Status Filter --}}
                    <div class="relative w-full sm:w-auto">
                        <select id="dt-status" class="w-full sm:w-auto px-4 py-2.5 bg-white bg-none border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 focus:outline-none focus:border-red-300 focus:ring-2 focus:ring-red-500/20 appearance-none pr-8 cursor-pointer">
                            <option value="all">Semua Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="completed">Completed</option>
                        </select>
                        <svg class="w-3.5 h-3.5 absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            {{-- Student Table --}}
            <div class="bg-white border border-gray-100 rounded-2xl lg:rounded-3xl shadow-sm overflow-hidden p-0">
                <div class="overflow-x-auto w-full">
                    <table id="students-table" class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider w-12 whitespace-nowrap">No</th>
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">ID</th>
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Siswa</th>
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Module Progress</th>
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Average Task</th>
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Evaluation Score</th>
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider whitespace-nowrap">Status</th>
                                <th class="px-4 py-3.5 text-[11px] font-bold text-gray-500 uppercase tracking-wider w-16 whitespace-nowrap text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                        </tbody>
                    </table>
                </div>
                
                {{-- Custom Pagination Footer (Tailwind) --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-white flex flex-col md:flex-row items-center justify-between gap-4 text-sm font-medium text-gray-600">
                    <div id="custom-dt-info" class="w-full md:w-auto text-center md:text-left">
                        Menampilkan 0 - 0 dari 0 data.
                    </div>
                    <div class="flex flex-col sm:flex-row items-center gap-6 w-full md:w-auto">
                        <div class="flex items-center gap-2">
                            <span>Rows per page:</span>
                            <div class="relative">
                                <select id="custom-dt-length" class="pl-3 pr-8 py-1.5 bg-white bg-none border border-gray-200 rounded-lg text-sm font-bold text-gray-700 focus:outline-none focus:border-[#d62828] focus:ring-1 focus:ring-[#d62828]/20 appearance-none cursor-pointer">
                                    <option value="5">5</option>
                                    <option value="10" selected>10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                                <svg class="w-4 h-4 absolute right-2.5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        
                        {{-- Dynamic Pagination Container --}}
                        <div id="custom-dt-pagination" class="flex items-center gap-2">
                            <!-- Rendered by JS -->
                        </div>
                    </div>
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
                                <img src="{{ Auth::user()->avatar_url }}" onerror="this.onerror=null; this.src='{{ Auth::user()->fallback_avatar_url }}'" class="w-8 h-8 rounded-full border border-white shadow-sm" alt="Sensei">
                                <span class="text-sm font-bold font-karla text-gray-900">{{ Auth::user()->name }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div class="space-y-1.5">
                            <x-input-label>Target Sertifikasi:</x-input-label>
                            <div x-data="{ open: false, selected: '' }" class="relative">
                                <input type="hidden" name="target" x-model="selected" required>
                                <div @click="open = !open" 
                                     class="w-full bg-white border rounded-xl px-4 py-3 text-sm font-karla cursor-pointer flex justify-between items-center transition"
                                     :class="open ? 'border-[#d62828] ring-1 ring-[#d62828]' : 'border-gray-200 hover:border-[#d62828]'">
                                    <span class="text-gray-800" x-text="selected ? selected : 'Pilih Target Sertifikasi'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180 text-[#d62828]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                                <div x-show="open" @click.outside="open = false" style="display: none;"
                                     class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-lg max-h-60 overflow-y-auto custom-scrollbar">
                                    <ul class="py-1">
                                        <li>
                                            <div @click="selected = 'JLPT N4'; open = false;" class="w-full text-left px-4 py-2.5 text-sm font-karla cursor-pointer transition-colors" :class="selected === 'JLPT N4' ? 'bg-red-50 text-[#d62828] font-bold' : 'text-gray-700 hover:bg-gray-50 hover:text-[#d62828]'">
                                                JLPT N4
                                            </div>
                                        </li>
                                        <li>
                                            <div @click="selected = 'JLPT N5'; open = false;" class="w-full text-left px-4 py-2.5 text-sm font-karla cursor-pointer transition-colors" :class="selected === 'JLPT N5' ? 'bg-red-50 text-[#d62828] font-bold' : 'text-gray-700 hover:bg-gray-50 hover:text-[#d62828]'">
                                                JLPT N5
                                            </div>
                                        </li>
                                        <li>
                                            <div @click="selected = 'JFT-Basic A2'; open = false;" class="w-full text-left px-4 py-2.5 text-sm font-karla cursor-pointer transition-colors" :class="selected === 'JFT-Basic A2' ? 'bg-red-50 text-[#d62828] font-bold' : 'text-gray-700 hover:bg-gray-50 hover:text-[#d62828]'">
                                                JFT-Basic A2
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
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

    {{-- Student Detail Sidebar --}}
    <div x-data="{ 
            open: false, 
            studentId: '', 
            studentName: '', 
            studentStatus: '',
            isLoading: false
         }"
         @open-student-sidebar.window="
            studentId = $event.detail.id;
            studentName = $event.detail.name;
            studentStatus = $event.detail.status;
            open = true;
         "
         class="fixed inset-0 z-[110] flex justify-end"
         x-show="open"
         style="display: none;"
         aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
         
         <div x-show="open" 
              x-transition:enter="ease-in-out duration-300"
              x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100"
              x-transition:leave="ease-in-out duration-300"
              x-transition:leave-start="opacity-100"
              x-transition:leave-end="opacity-0"
              class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
              @click="if(!isLoading) open = false"></div>

         <div x-show="open" 
              x-transition:enter="transform transition ease-in-out duration-300"
              x-transition:enter-start="translate-x-full"
              x-transition:enter-end="translate-x-0"
              x-transition:leave="transform transition ease-in-out duration-300"
              x-transition:leave-start="translate-x-0"
              x-transition:leave-end="translate-x-full"
              class="relative w-full max-w-md h-full bg-white shadow-2xl flex flex-col pointer-events-auto">
              
              {{-- Sidebar Header --}}
              <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                  <h2 class="text-lg font-bold font-ibm text-gray-900" id="slide-over-title">Detail & Status Siswa</h2>
                  <button type="button" @click="open = false" class="p-2 -mr-2 text-gray-400 hover:text-gray-500 rounded-full hover:bg-gray-100 transition">
                      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                  </button>
              </div>

              {{-- Sidebar Content --}}
              <div class="flex-1 overflow-y-auto px-6 py-6 custom-scrollbar flex flex-col">
                  
                  <div class="flex items-center gap-4 mb-8">
                      <img :src="'https://ui-avatars.com/api/?name=' + encodeURIComponent(studentName) + '&background=f3f4f6&color=d62828&bold=true&size=56'" class="w-14 h-14 rounded-full border-2 border-white shadow-sm" alt="">
                      <div>
                          <h3 class="text-base font-bold font-ibm text-gray-900" x-text="studentName"></h3>
                          <p class="text-xs font-karla text-gray-500 mt-0.5">Siswa LPK Seishin</p>
                      </div>
                  </div>

                  <form :action="'{{ url('/teacher/students') }}/' + studentId + '/status'" method="POST" @submit="isLoading = true" class="flex flex-col flex-1">
                      @csrf
                      @method('PUT')
                      
                      <div class="space-y-2 mb-8">
                          <x-input-label>Ubah Status Siswa:</x-input-label>
                          <div class="relative">
                              <select name="status" x-model="studentStatus" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#d62828] focus:ring-1 focus:ring-[#d62828] outline-none transition font-karla text-sm appearance-none bg-none pr-10 bg-white shadow-sm cursor-pointer font-bold" :class="{ 'text-emerald-600': studentStatus === 'Active', 'text-red-500': studentStatus === 'Inactive', 'text-blue-500': studentStatus === 'Completed' }">
                                  <option value="Active" class="text-gray-900">Active</option>
                                  <option value="Inactive" class="text-gray-900">Inactive</option>
                                  <option value="Completed" class="text-gray-900">Completed</option>
                              </select>
                              <svg class="w-4 h-4 text-gray-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                          </div>
                          <p class="text-[11px] font-karla text-gray-500 mt-1 leading-snug">Mengubah status Inactive akan menangguhkan akses siswa ke modul dan tugas di seluruh kelas dalam batch ini.</p>
                      </div>

                      {{-- Save Button --}}
                      <div class="pt-4 border-t border-gray-100 mt-auto">
                          <x-primary-button type="submit" class="w-full justify-center py-3" x-bind:disabled="isLoading">
                              <svg x-show="isLoading" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" style="display: none;"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                              <span x-text="isLoading ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                          </x-primary-button>
                      </div>
                  </form>
              </div>
         </div>
    </div>
@endpush

</div>

@push('styles')
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        let table = $('#students-table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{{ route('teacher.batch.show', $batch->id_batch) }}",
                data: function (d) {
                    d.status = $('#dt-status').val() || 'all';
                    d.search.value = $('#dt-search').val() || ''; 
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('px-4 py-4 text-sm font-semibold text-gray-500'); } },
                { data: 'id_siswa', name: 'users.id', createdCell: function(td) { $(td).addClass('px-4 py-4 text-sm font-semibold text-gray-700'); } },
                { data: 'name', name: 'users.name', createdCell: function(td) { $(td).addClass('px-4 py-4'); }, render: function(data, type, row) {
                    return `<div class="flex items-center gap-3">
                                <img src="${row.avatar_url}" onerror="this.onerror=null; this.src='${row.fallback_avatar_url}'" class="w-8 h-8 rounded-full object-cover border border-gray-100 flex-shrink-0" alt="${data}">
                                <span class="text-sm font-semibold text-gray-800 whitespace-nowrap">${data}</span>
                            </div>`;
                }},
                { data: 'module_progress', name: 'module_progress', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('px-4 py-4'); }, render: function(data) {
                    return `<div class="flex items-center gap-2.5">
                                <div class="w-20 bg-gray-100 rounded-full h-2 flex-shrink-0">
                                    <div class="bg-gradient-to-r from-[#d62828] to-[#e85d5d] h-2 rounded-full" style="width: ${data}%"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-700 whitespace-nowrap">${data}%</span>
                            </div>`;
                }},
                { data: 'average_task', name: 'average_task', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('px-4 py-4 text-sm font-semibold text-gray-700'); } },
                { data: 'eval_score', name: 'eval_score', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('px-4 py-4 text-sm font-semibold text-gray-700'); } },
                { data: 'status_badge', name: 'status_badge', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('px-4 py-4'); } },
                { data: 'action', name: 'action', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('px-4 py-4 text-center text-gray-400'); } }
            ],
            dom: '<"w-full overflow-x-auto"t>',
            drawCallback: function(settings) {
                var api = this.api();
                var info = api.page.info();
                
                $('#custom-dt-info').html(
                    'Menampilkan ' + (info.recordsDisplay > 0 ? info.start + 1 : 0) + ' - ' + info.end + ' dari ' + info.recordsDisplay + ' data.'
                );
                
                // Custom Pagination rendering
                let paginationHtml = '';
                let currentPage = info.page;
                let totalPages = info.pages;

                if (totalPages > 0) {
                    // Prev Button
                    let prevDisabled = currentPage === 0;
                    let prevClass = prevDisabled 
                        ? 'bg-red-50 text-red-300 cursor-not-allowed opacity-70' 
                        : 'bg-red-50 text-[#d62828] hover:bg-red-100 cursor-pointer';
                        
                    paginationHtml += `<button class="dt-paginate-btn w-9 h-9 flex items-center justify-center rounded-[10px] transition ${prevClass}" data-action="previous" ${prevDisabled ? 'disabled' : ''}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                    </button>`;

                    // Pages
                    let startPage = Math.max(0, currentPage - 1);
                    let endPage = Math.min(totalPages - 1, currentPage + 1);

                    if (currentPage === 0) endPage = Math.min(totalPages - 1, 2);
                    if (currentPage === totalPages - 1) startPage = Math.max(0, totalPages - 3);

                    for (let i = startPage; i <= endPage; i++) {
                        let activeClass = i === currentPage 
                            ? 'bg-[#d62828] text-white shadow-md shadow-red-500/20 border-transparent' 
                            : 'bg-white text-gray-600 border border-transparent hover:bg-gray-50';
                            
                        paginationHtml += `<button class="dt-paginate-btn w-9 h-9 flex items-center justify-center rounded-[10px] text-sm font-semibold transition ${activeClass}" data-action="${i}">
                            ${i + 1}
                        </button>`;
                    }

                    // Next Button
                    let nextDisabled = currentPage === totalPages - 1;
                    let nextClass = nextDisabled 
                        ? 'bg-[#d62828]/50 text-white cursor-not-allowed' 
                        : 'bg-[#d62828] text-white hover:bg-[#b02121] cursor-pointer';
                        
                    paginationHtml += `<button class="dt-paginate-btn w-9 h-9 flex items-center justify-center rounded-[10px] transition ${nextClass}" data-action="next" ${nextDisabled ? 'disabled' : ''}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                    </button>`;
                }

                $('#custom-dt-pagination').html(paginationHtml);
            }
        });

        let searchTimer;
        $('#dt-search').on('keyup', function() { 
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function() {
                table.draw(); 
            }, 300); // Debounce delay 300ms
        });
        $('#dt-status').on('change', function() { table.draw(); });
        
        $('#custom-dt-length').on('change', function() { table.page.len($(this).val()).draw(); });
        
        // Dynamic Pagination Click Event
        $('#custom-dt-pagination').on('click', '.dt-paginate-btn', function() {
            let action = $(this).data('action');
            if (action !== undefined) {
                if (action === 'previous') {
                    table.page('previous').draw('page');
                } else if (action === 'next') {
                    table.page('next').draw('page');
                } else {
                    table.page(parseInt(action)).draw('page');
                }
            }
        });
    });
</script>
@endpush

@endsection
