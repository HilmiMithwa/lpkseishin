@extends('layouts.teacher')

@section('title', ($classData->nama_mapel ?? 'Kelas') . ' - LPK Seishin')

@section('content')
@php
    // Dummy Data — Class Detail
    if (!isset($classData)) {
        $classData = (object)[
            'id_mapel' => request()->route('id_mapel') ?? 1,
            'nama_mapel' => 'N4 Mastering',
            'deskripsi' => 'Program lanjutan 2 bulan (264 JP) dengan fokus praktik. Mencakup 7 unit kompetensi bahasa Jepang hingga persiapan ujian level N4.',
            'batch' => (object)['id_batch' => 2, 'nama_batch' => 'Batch 2'],
            'certification_target' => 'JLPT N4',
            'total_duration' => '264 JP',
            'schedule' => 'Senin - Jumat',
            'pass_requirement' => 'Min. Skor 80',
        ];
    }

    if (!isset($announcements) || (is_countable($announcements) && count($announcements) == 0)) {
        $announcements = [
            'Simulasi Ujian 1: Senin Depan (12 Mei)',
            'Simulasi Ujian 1: Senin Depan (12 Mei)',
            'Simulasi Ujian 1: Senin Depan (12 Mei)',
            'Simulasi Ujian 1: Senin Depan (12 Mei)',
            'Simulasi Ujian 1: Senin Depan (12 Mei)',
        ];
    }

    if (!isset($modules) || (is_countable($modules) && count($modules) == 0)) {
        $modules = [
            (object)[
                'id_modul' => 1,
                'nama_modul' => 'Introduction to N4 & Kanji N4',
                'kode_modul' => 'SCB-JP-N4-01',
                'teori_jp' => 10,
                'praktik_jp' => 20,
                'note' => '(from syllabus)',
            ],
            (object)[
                'id_modul' => 2,
                'nama_modul' => 'Module 2: Vocabulary & Reading (Kotoba & Dokkai)',
                'kode_modul' => 'SCB-JP-N4-02',
                'teori_jp' => 8,
                'praktik_jp' => 22,
                'note' => '',
            ],
            (object)[
                'id_modul' => 3,
                'nama_modul' => 'Module 3: Grammar & Listening (Bunpou & Choukai)',
                'kode_modul' => 'SCB-JP-N4-03',
                'teori_jp' => 22,
                'praktik_jp' => 48,
                'note' => '',
            ],
            (object)[
                'id_modul' => 4,
                'nama_modul' => 'Module 4: Practice & Simulation',
                'kode_modul' => 'SCB-JP-N4-07',
                'teori_jp' => 8,
                'praktik_jp' => 22,
                'note' => '',
            ],
            (object)[
                'id_modul' => 5,
                'nama_modul' => 'Module 5: Daily Conversation & Workplace Ethics (Kaiwa N4)',
                'kode_modul' => 'SCB-JP-N4-05',
                'teori_jp' => 10,
                'praktik_jp' => 34,
                'note' => '',
            ],
            (object)[
                'id_modul' => 6,
                'nama_modul' => 'Module 6: Final Competency Test & Mock Interview',
                'kode_modul' => '',
                'teori_jp' => 0,
                'praktik_jp' => 0,
                'note' => 'Evaluasi Komprehensif | Teori & Praktik Terintegrasi',
            ],
        ];
    }
@endphp

<div class="p-4 sm:p-6 lg:p-10" x-data>

    {{-- Top Header Row: Title & Edit Button --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8 mb-6 lg:mb-8">
        {{-- Left: Title & Breadcrumbs (Spans 3/4) --}}
        <div class="lg:col-span-3">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('teacher.batch.show', $classData->batch->id_batch ?? 2) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-gray-900 tracking-tight">{{ $classData->nama_mapel }}</h1>
            </div>
            <nav class="flex flex-wrap items-center gap-1.5 text-xs sm:text-sm font-karla">
                <a href="{{ route('teacher.classes') }}" class="text-gray-500 hover:text-gray-700 font-medium transition">Kelas Saya</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('teacher.batch.show', $classData->batch->id_batch ?? 2) }}" class="text-gray-500 hover:text-gray-700 font-medium transition">{{ $classData->batch->nama_batch ?? 'Batch 2' }}</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#d62828] font-semibold">{{ $classData->nama_mapel }}</span>
            </nav>
        </div>
        
        {{-- Right: Edit Button (Spans 1/4) --}}
        <div class="lg:col-span-1 flex sm:justify-end items-start mt-2 sm:mt-0 lg:mt-1">
            <button @click="$dispatch('open-edit-modal')" class="inline-flex items-center gap-2 bg-[#d62828] hover:bg-red-700 text-white font-bold font-karla py-2.5 px-5 rounded-lg text-xs sm:text-sm transition shadow-sm">
                Edit Kelas
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </button>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8">
        
        {{-- Left Main Column (Spans 3/4) --}}
        <div class="lg:col-span-3 flex flex-col gap-6 lg:gap-8">
            
            {{-- Info Section: Banner & Targets --}}
            <div class="grid grid-cols-1 lg:grid-cols-9 gap-4 sm:gap-5">
                
                {{-- Column 1/3: Class Banner Card --}}
                <div class="lg:col-span-4 banner-red rounded-2xl lg:rounded-3xl p-6 sm:p-7 relative overflow-hidden flex flex-col justify-between min-h-[220px]">
                    <div class="relative z-10">
                        {{-- Icon --}}
                        <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-lg mb-5">
                            あa
                        </div>
                        {{-- Title --}}
                        <h2 class="text-2xl sm:text-3xl font-bold font-ibm text-white leading-tight mb-3">{{ $classData->nama_mapel }}</h2>
                        {{-- Description --}}
                        <p class="text-white/85 text-xs sm:text-sm font-karla font-medium leading-relaxed">{{ $classData->deskripsi }}</p>
                    </div>
                </div>

                {{-- Column 2/3 & 3/3: Targets & Qualifications --}}
                <div class="lg:col-span-5 bg-white border border-gray-100 rounded-2xl lg:rounded-3xl p-5 sm:p-6 lg:p-7 shadow-sm">
                    <h3 class="text-sm sm:text-base font-bold font-ibm text-gray-900 mb-6">Target dan Kualifikasi</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-5">
                        {{-- Certification Target --}}
                        <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="8" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"/>
                                    <circle cx="12" cy="12" r="4" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 12l5 -5m0 0v3m0 -3h-3" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[11px] sm:text-xs text-gray-500 font-karla font-medium leading-tight mb-1">Target Sertifikasi</p>
                                <p class="text-sm sm:text-base font-bold font-ibm text-gray-900 leading-none">{{ $classData->certification_target ?? 'JLPT N4' }}</p>
                            </div>
                        </div>

                        {{-- Total Duration --}}
                        <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[11px] sm:text-xs text-gray-500 font-karla font-medium leading-tight mb-1">Total Durasi</p>
                                <p class="text-sm sm:text-base font-bold font-ibm text-gray-900 leading-none">{{ $classData->total_duration ?? '264 JP' }}</p>
                            </div>
                        </div>

                        {{-- Schedule --}}
                        <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6" />
                                    <circle cx="16" cy="16" r="5" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 14v2l1.5 1.5" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[11px] sm:text-xs text-gray-500 font-karla font-medium leading-tight mb-1">Jadwal</p>
                                <p class="text-sm sm:text-base font-bold font-ibm text-gray-900 leading-none">{{ $classData->schedule ?? 'Senin - Jumat' }}</p>
                            </div>
                        </div>

                        {{-- Pass Requirement --}}
                        <div class="flex items-center gap-4 bg-white border border-gray-100 rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow">
                            <div class="w-12 h-12 rounded-2xl bg-red-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 6h8M6 6h12a1 1 0 011 1v2a3 3 0 01-3 3h-1m-6 4v4m-3 0h6m-1-4a4 4 0 01-4-4V7M5 6v2a3 3 0 003 3h1" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[11px] sm:text-xs text-gray-500 font-karla font-medium leading-tight mb-1">Syarat Kelulusan</p>
                                <p class="text-sm sm:text-base font-bold font-ibm text-gray-900 leading-none">{{ $classData->pass_requirement ?? 'Min. Skor 80' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Modules Section --}}
            <div>
                {{-- Modules Header --}}
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-base sm:text-lg font-bold font-ibm text-gray-900">Modul</h3>
                    <button @click="$dispatch('open-add-module-modal')" class="inline-flex items-center gap-1.5 bg-[#d62828] hover:bg-red-700 text-white font-bold font-karla py-2 px-4 rounded-lg text-xs sm:text-sm transition shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah
                    </button>
                </div>

                {{-- Module List --}}
                <div class="space-y-3">
                    @forelse($modules as $module)
                    <div x-data="{ isDeleted: false }" x-show="!isDeleted" x-transition.opacity x-on:module-deleted.window="if ($event.detail.id === {{ $module->id_modul }}) isDeleted = true" class="bg-white border border-gray-100 rounded-2xl px-5 py-4 shadow-sm hover:shadow-md transition-all duration-200 flex items-center justify-between gap-4">
                        {{-- Left: Icon + Info --}}
                        <div class="flex items-center gap-4 flex-1 min-w-0">
                            {{-- Module Icon --}}
                            <div class="w-11 h-11 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                                <span class="text-[#d62828] font-bold font-ibm text-sm">あa</span>
                            </div>

                            {{-- Module Info --}}
                            <div class="min-w-0">
                                <h4 class="text-sm sm:text-base font-bold font-karla text-gray-900 leading-snug truncate">{{ $module->nama_modul }}</h4>
                                <p class="text-[11px] sm:text-xs font-karla font-medium text-gray-500 mt-0.5 truncate">
                                    @if(!empty($module->kode_modul))
                                        {{ $module->kode_modul }} | Teori ({{ $module->teori_jp }} JP) & Praktik ({{ $module->praktik_jp }} JP) {{ $module->note }}
                                    @else
                                        {{ $module->note }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- Right: Actions --}}
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <a href="{{ route('teacher.modules.show', $module->id_modul) }}" class="inline-flex items-center gap-1.5 bg-[#d62828] hover:bg-red-700 text-white font-bold font-karla py-1.5 px-4 rounded-lg text-xs transition shadow-sm">
                                Lihat
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                            <button @click="$dispatch('open-delete-module-modal', { id: {{ $module->id_modul }}, name: '{{ addslashes($module->nama_modul) }}' })" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus Modul">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        <p class="text-gray-500 italic text-xs sm:text-sm font-karla">Belum ada modul di kelas ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- Right Side Column (Spans 1/4) --}}
        <div class="lg:col-span-1 flex flex-col gap-6 lg:gap-8">
            
            {{-- Column 3: Announcements --}}
            <div x-data="{ isAdding: false, isLoading: false, newAnnouncement: '', addedAnnouncements: [] }" class="bg-white border border-gray-100 rounded-2xl lg:rounded-3xl p-5 sm:p-6 shadow-sm flex flex-col">
                <h3 class="text-sm sm:text-base font-bold font-ibm text-gray-900 mb-4">Pengumuman</h3>
                
                <div class="space-y-3 flex-1">
                    @foreach($announcements as $announcement)
                    <p class="text-[11px] sm:text-xs font-karla font-medium text-gray-600 leading-snug border-b border-gray-100 pb-2.5 last:border-0">{{ $announcement }}</p>
                    @endforeach
                    
                    {{-- Dynamically Added Announcements --}}
                    <template x-for="(announcement, index) in addedAnnouncements" :key="index">
                        <p class="text-[11px] sm:text-xs font-karla font-medium text-gray-600 leading-snug border-b border-gray-100 pb-2.5 last:border-0" x-text="announcement"></p>
                    </template>
                </div>

                {{-- Add Button --}}
                <button x-show="!isAdding" @click="isAdding = true; $nextTick(() => $refs.announcementInput.focus())" class="mt-4 text-[#d62828] text-[11px] sm:text-xs font-bold font-karla flex items-center justify-center gap-1.5 hover:text-red-700 transition w-full py-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Pengumuman
                </button>

                {{-- Inline Add Form --}}
                <div x-show="isAdding" style="display: none;" x-transition class="mt-4 flex flex-col gap-2">
                    <textarea x-ref="announcementInput" x-model="newAnnouncement" rows="2" placeholder="Tulis pengumuman baru..." class="w-full text-xs font-karla p-2.5 rounded-lg border border-gray-200 focus:border-red-500 focus:ring-1 focus:ring-red-200 outline-none resize-none transition bg-gray-50"></textarea>
                    
                    <div class="flex items-center gap-2 justify-end mt-1">
                        <button @click="isAdding = false; newAnnouncement = ''" :disabled="isLoading" class="px-3 py-1.5 rounded-md text-[11px] font-bold font-karla text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition disabled:opacity-50">
                            Batal
                        </button>
                        <button @click="
                            if(!newAnnouncement.trim()) return;
                            isLoading = true;
                            setTimeout(() => {
                                addedAnnouncements.push(newAnnouncement);
                                newAnnouncement = '';
                                isAdding = false;
                                isLoading = false;
                                $dispatch('show-toast', { message: 'Pengumuman ditambahkan!' });
                            }, 600);
                        " :disabled="isLoading || !newAnnouncement.trim()" class="px-3 py-1.5 rounded-md bg-[#d62828] text-white text-[11px] font-bold font-karla hover:bg-red-700 transition flex items-center gap-1.5 disabled:opacity-60 disabled:cursor-not-allowed">
                            <svg x-show="isLoading" class="animate-spin h-3 w-3 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span x-text="isLoading ? 'Menyimpan...' : 'Simpan'"></span>
                        </button>
                    </div>
                </div>
            </div>
            
        </div>

    </div>

</div>

@push('modals')
    {{-- Modal Edit Class --}}
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-edit-modal.window="open = true"
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
                         <h3 class="text-xl sm:text-2xl font-bold font-ibm text-gray-900" id="modal-title">Edit Kelas</h3>
                         <span class="px-3 py-1 rounded-full bg-gray-200 text-xs font-bold font-karla text-gray-700">Ditambahkan ke: {{ $classData->batch->nama_batch ?? 'Batch 2' }}</span>
                     </div>

                     <!-- Form Grid -->
                     <form @submit.prevent="
                         isLoading = true;
                         setTimeout(() => {
                             isLoading = false;
                             open = false;
                             $dispatch('show-toast', { message: 'Perubahan kelas berhasil disimpan!' });
                         }, 800);
                     " x-data="{ isLoading: false }">
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                             
                             <!-- Left Column -->
                             <div class="space-y-6">
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Nama Kelas:</label>
                                     <input type="text" required value="{{ $classData->nama_mapel }}" placeholder="cth., N4 Mastering - Kelas A" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                                 </div>
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Deskripsi:</label>
                                     <textarea required placeholder="Tulis deskripsi singkat...." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm resize-y min-h-[120px]">{{ $classData->deskripsi }}</textarea>
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
                                             <option value="" disabled>Pilih Target Sertifikasi</option>
                                             <option value="JLPT N4" {{ $classData->certification_target == 'JLPT N4' ? 'selected' : '' }}>JLPT N4</option>
                                             <option value="JLPT N5" {{ $classData->certification_target == 'JLPT N5' ? 'selected' : '' }}>JLPT N5</option>
                                             <option value="JFT-Basic A2" {{ $classData->certification_target == 'JFT-Basic A2' ? 'selected' : '' }}>JFT-Basic A2</option>
                                         </select>
                                         <svg class="w-4 h-4 text-gray-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                     </div>
                                 </div>
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Total Durasi (JP):</label>
                                     <input type="text" required value="{{ preg_replace('/[^0-9]/', '', $classData->total_duration) }}" placeholder="cth., 264" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                                 </div>
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Jadwal:</label>
                                     <input type="text" required value="{{ $classData->schedule }}" placeholder="cth., Senin - Jumat" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                                 </div>
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Nilai Kelulusan Minimum:</label>
                                     <input type="text" required value="{{ preg_replace('/[^0-9]/', '', $classData->pass_requirement) }}" placeholder="cth., 80" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
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
                                 <span x-text="isLoading ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                             </button>
                         </div>
                     </form>
                 </div>
            </div>
        </div>
    </div>
@endpush

@push('modals')
    {{-- Modal Add New Module --}}
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-add-module-modal.window="open = true"
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
                 class="relative transform overflow-hidden rounded-[32px] bg-white text-left shadow-xl transition-all w-full max-w-2xl border border-gray-100">
                 
                 <!-- Close Button -->
                 <button @click="open = false" class="absolute top-6 right-6 p-2 rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                 </button>

                 <!-- Content -->
                 <div class="p-6 sm:p-8 lg:p-10" x-data="{ selectedIcon: 2, sequential: false }">
                     <div class="mb-8">
                         <h3 class="text-xl sm:text-2xl font-bold font-ibm text-gray-900" id="modal-title">Tambah Modul Baru</h3>
                     </div>

                     <!-- Form Grid (Single Column) -->
                     <form class="space-y-6">
                         
                         <div>
                             <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Judul Modul:</label>
                             <input type="text" placeholder="cth., Module 2: Vocabulary &amp; Reading (Kotoba &amp; Dokkai)" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                         </div>

                         <div>
                             <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Alokasi Durasi (JP):</label>
                             <input type="text" placeholder="cth., 22" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                         </div>

                         <div>
                             <div class="mb-3">
                                 <label class="block text-sm font-bold font-karla text-gray-700">Pilih Ikon Modul:</label>
                                 <p class="text-xs font-karla text-gray-500 mt-1">Pilih ikon yang paling sesuai untuk ditampilkan pada daftar modul siswa.</p>
                             </div>
                             
                             <div class="flex items-center gap-4">
                                 {{-- Icon 1: Language --}}
                                 <button type="button" @click="selectedIcon = 1" :class="selectedIcon === 1 ? 'border-[#d62828] bg-red-50' : 'border-gray-200 hover:border-red-200'" class="w-14 h-14 rounded-2xl border-2 flex items-center justify-center transition-colors text-[#d62828]">
                                     <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" /></svg>
                                 </button>
                                 {{-- Icon 2: Book --}}
                                 <button type="button" @click="selectedIcon = 2" :class="selectedIcon === 2 ? 'border-[#d62828] bg-red-50' : 'border-gray-200 hover:border-red-200'" class="w-14 h-14 rounded-2xl border-2 flex items-center justify-center transition-colors text-[#d62828]">
                                     <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                 </button>
                                 {{-- Icon 3: Puzzle --}}
                                 <button type="button" @click="selectedIcon = 3" :class="selectedIcon === 3 ? 'border-[#d62828] bg-red-50' : 'border-gray-200 hover:border-red-200'" class="w-14 h-14 rounded-2xl border-2 flex items-center justify-center transition-colors text-[#d62828]">
                                     <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a1.5 1.5 0 01-1.5 1.5H9c-.443 0-.792-.35-.792-.792 0-.214-.078-.415-.224-.555C7.755 6 7.424 6 7.125 6c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401h0a1.5 1.5 0 011.5 1.5v2.625c0 .443-.35.792-.792.792-.214 0-.415.078-.555.224C10 16.245 10 16.576 10 16.875c0 1.036 1.007 1.875 2.25 1.875s2.25-.84 2.25-1.875c0-.369-.128-.713-.349-1.003-.215-.283-.401-.604-.401-.959v0a1.5 1.5 0 011.5-1.5h2.625c.443 0 .792.35.792.792 0 .214.078.415.224.555.229.229.56.229.859.229 1.036 0 1.875-1.007 1.875-2.25s-.84-2.25-1.875-2.25c-.369 0-.713.128-1.003.349-.283.215-.604.401-.959.401h0a1.5 1.5 0 01-1.5-1.5V6.087z" /></svg>
                                 </button>
                                 {{-- Icon 4: Clipboard --}}
                                 <button type="button" @click="selectedIcon = 4" :class="selectedIcon === 4 ? 'border-[#d62828] bg-red-50' : 'border-gray-200 hover:border-red-200'" class="w-14 h-14 rounded-2xl border-2 flex items-center justify-center transition-colors text-[#d62828]">
                                     <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" /></svg>
                                 </button>
                             </div>
                         </div>

                         <div>
                             <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Deskripsi Modul:</label>
                             <textarea rows="4" placeholder="Tulis deskripsi singkat...." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm resize-y min-h-[120px]"></textarea>
                         </div>

                         <div class="flex items-start justify-between gap-4 pt-3 mt-4 border-t border-gray-100">
                             <div>
                                 <label class="block text-sm font-bold font-karla text-gray-700 mb-1">Akses Berurutan</label>
                                 <p class="text-[13px] font-karla text-gray-600 leading-snug">Kunci modul ini (Siswa harus menyelesaikan modul sebelumnya untuk membuka akses).</p>
                             </div>
                             <button type="button" @click="sequential = !sequential" :class="sequential ? 'bg-[#d62828]' : 'bg-gray-200'" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                 <span class="sr-only">Toggle sequential access</span>
                                 <span aria-hidden="true" :class="sequential ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                             </button>
                         </div>

                         <!-- Actions -->
                         <div class="mt-4 flex items-center gap-4 pt-6">
                             <button type="button" @click="open = false" class="px-6 py-3 rounded-xl border border-[#d62828] text-[#d62828] font-bold font-karla hover:bg-red-50 transition w-full sm:w-auto sm:flex-1 text-sm sm:text-base">
                                 Batal
                             </button>
                             <button type="button" @click="open = false" class="px-6 py-3 rounded-xl bg-[#d62828] text-white font-bold font-karla hover:bg-red-700 shadow-sm transition w-full sm:w-auto sm:flex-[2.5] text-sm sm:text-base">
                                 Buat Modul
                             </button>
                         </div>
                     </form>
                 </div>
            </div>
        </div>
    </div>
@endpush

@push('modals')
    {{-- Delete Module Modal --}}
    <div x-data="{ open: false, moduleId: null, moduleName: '', isLoading: false }" 
         x-show="open" 
         x-on:open-delete-module-modal.window="moduleId = $event.detail.id; moduleName = $event.detail.name; open = true;"
         style="display: none;"
         class="fixed inset-0 z-[110] overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
             @click="open = false"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 p-6 sm:p-8">
                 
                 <div class="sm:flex sm:items-start gap-5">
                     <div class="mx-auto flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-full bg-red-50 sm:mx-0 sm:h-12 sm:w-12">
                         <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                         </svg>
                     </div>
                     <div class="mt-4 text-center sm:mt-0 sm:ml-4 sm:text-left">
                         <h3 class="text-xl font-bold font-ibm text-gray-900" id="modal-title">Hapus Modul</h3>
                         <div class="mt-2">
                             <p class="text-sm font-karla text-gray-500 leading-relaxed">Apakah Anda yakin ingin menghapus <span class="font-bold text-gray-700" x-text="moduleName"></span>? Semua data terkait modul ini akan dihapus permanen dan tidak dapat dikembalikan.</p>
                         </div>
                     </div>
                 </div>
                 
                 <div class="mt-8 sm:mt-6 sm:flex sm:flex-row-reverse gap-3">
                     <button type="button" @click="
                         isLoading = true;
                         setTimeout(() => {
                             isLoading = false;
                             open = false;
                             $dispatch('module-deleted', { id: moduleId });
                             $dispatch('show-toast', { message: 'Modul berhasil dihapus' });
                         }, 800);
                     " :disabled="isLoading" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-bold font-karla text-white shadow-sm hover:bg-red-500 sm:w-auto transition items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                         <svg x-show="isLoading" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                         <span x-text="isLoading ? 'Menghapus...' : 'Ya, Hapus'"></span>
                     </button>
                     <button type="button" @click="open = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-bold font-karla text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">Batal</button>
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
         class="fixed bottom-6 right-6 z-[120] flex flex-col gap-2 pointer-events-none">
        
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
             
             <div class="flex-1">
                 <p class="text-sm font-bold font-ibm text-gray-900" x-text="message"></p>
                 <p class="text-xs font-karla text-gray-500 mt-0.5">Sistem telah diperbarui.</p>
             </div>
             
             <button @click="show = false" class="text-gray-400 hover:text-gray-500 transition">
                 <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                     <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                 </svg>
             </button>
        </div>
    </div>
@endpush
@endsection
