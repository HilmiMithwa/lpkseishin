@extends('layouts.teacher')

@section('title', 'Modul ' . (request()->route('id_modul') ?? 2) . ': Vocabulary & Reading - LPK Seishin')

@section('content')
{{-- Dummy data removed, variables injected from ModulController --}}

<div class="p-4 sm:p-6 lg:p-10">

    {{-- Header Row: Title + Breadcrumb + Edit Button --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('teacher.subjects.show', 1) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-gray-900 tracking-tight">{{ $moduleTitle }}</h1>
            </div>
            <nav class="flex flex-wrap items-center gap-1.5 text-xs sm:text-sm">
                <a href="{{ route('teacher.classes') }}" class="text-gray-500 hover:text-gray-700 font-medium transition">Kelas Saya</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('teacher.batch.show', 2) }}" class="text-gray-500 hover:text-gray-700 font-medium transition">{{ $batchName }}</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('teacher.subjects.show', 1) }}" class="text-gray-500 hover:text-gray-700 font-medium transition">{{ $className }}</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#d62828] font-semibold">Modul {{ $currentModuleId }}</span>
            </nav>
        </div>
        <div class="flex items-center gap-2 sm:gap-3 self-start">
            <button x-data @click="$dispatch('open-delete-module-modal', { id: {{ $modul->id_modul }}, name: '{{ addslashes($modul->nama_modul) }}' })" class="inline-flex items-center gap-2 bg-white border border-red-200 hover:bg-red-50 text-[#d62828] font-bold font-karla py-2.5 px-5 rounded-lg text-xs sm:text-sm transition shadow-sm">
                Hapus Modul
            </button>
            <button x-data @click="$dispatch('open-edit-module-modal')" class="inline-flex items-center gap-2 bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-5 rounded-lg text-xs sm:text-sm transition shadow-sm">
                Edit Modul
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            </button>
        </div>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8">
        
        {{-- Left Column (Spans 3/4) --}}
        <div class="lg:col-span-3 flex flex-col gap-6 lg:gap-8">
            <div class="bg-white border border-gray-100 rounded-2xl lg:rounded-3xl p-5 sm:p-8 shadow-sm">
                
                {{-- Module Description --}}
                <div class="mb-8">
                    <h3 class="text-base sm:text-lg font-bold font-ibm text-gray-900 mb-3">Deskripsi Modul</h3>
                    <p class="text-sm font-karla text-gray-600 leading-relaxed">
                        {{ $modul->module_description ?? 'Belum ada deskripsi untuk modul ini.' }}
                    </p>
                </div>

                {{-- Grid for Materials and Evaluation --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 mb-8">
                    {{-- Teaching Materials --}}
                    <div>
                        <h3 class="text-base sm:text-lg font-bold font-ibm text-gray-900 mb-4">Materi Pembelajaran</h3>
                        <div class="space-y-3">
                            @forelse($materials as $material)
                            <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm hover:shadow-md transition flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3">
                                    @if($material->status == 'completed')
                                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    @else
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </div>
                                    @endif
                                    <div>
                                        <h4 class="text-sm font-bold font-karla text-gray-900">{{ $material->nama_bahan_ajar }}</h4>
                                        <p class="text-[11px] font-karla text-gray-500 mt-0.5 capitalize">{{ $material->type }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('teacher.materials.show', ['id_modul' => $currentModuleId, 'id_materi' => $material->id_bahan_ajar]) }}" class="inline-flex items-center gap-1.5 bg-[#d62828] hover:bg-red-700 text-white font-bold font-karla py-1.5 px-3 rounded-lg text-xs transition shadow-sm">
                                        Lihat
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <button x-data @click="$dispatch('open-delete-item-modal', { id: {{ $material->id_bahan_ajar }}, name: '{{ addslashes($material->nama_bahan_ajar) }}', type: 'Materi' })" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                            @empty
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-6 flex items-center justify-center text-center">
                                <p class="text-sm font-karla font-bold text-gray-500">Belum ada materi di sini!!</p>
                            </div>
                            @endforelse

                            <a href="{{ route('teacher.materials.create', $currentModuleId) }}" class="w-full py-3 px-4 border-2 border-dashed border-red-200 hover:border-[#d62828] hover:bg-red-50 rounded-xl text-[#d62828] font-bold font-karla text-sm flex items-center justify-center gap-2 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah
                            </a>
                        </div>
                    </div>

                    {{-- Evaluation --}}
                    <div>
                        <h3 class="text-base sm:text-lg font-bold font-ibm text-gray-900 mb-4">Evaluasi</h3>
                        <div class="space-y-3">
                            @forelse($evaluations as $evaluation)
                            <div class="bg-white border border-gray-100 rounded-xl p-4 flex items-center justify-between group hover:border-red-100 transition shadow-sm">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-10 h-10 rounded-lg bg-red-50 text-[#d62828] flex items-center justify-center shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-sm font-bold font-ibm text-gray-900 truncate" title="{{ $evaluation->judul }}">{{ $evaluation->judul }}</h4>
                                        <p class="text-[11px] font-karla text-gray-500 flex items-center gap-2">
                                            <span>{{ $evaluation->tipe }}</span>
                                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                            <span>{{ $evaluation->durasi_menit }} Menit</span>
                                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                            @php
                                                $visibleCount = $evaluation->questions->filter(function($q) use ($evaluation) {
                                                    if ($evaluation->tipe === 'Multiple Choice Only' && $q->tipe_soal === 'essay') return false;
                                                    if ($evaluation->tipe === 'Essay Only' && $q->tipe_soal === 'mcq') return false;
                                                    return true;
                                                })->count();
                                            @endphp
                                            <span class="text-green-600 font-bold">{{ $visibleCount }} Soal</span>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="flex gap-2 shrink-0 pl-4">
                                    <a href="{{ route('teacher.evaluations.show', ['id_modul' => $currentModuleId, 'id' => $evaluation->id_evaluasi]) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#d62828] text-white rounded-lg text-xs font-bold font-karla hover:bg-red-700 transition shadow-sm">
                                        Lihat
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <button x-data @click="$dispatch('open-delete-item-modal', { id: {{ $evaluation->id_evaluasi }}, name: '{{ addslashes($evaluation->judul) }}', type: 'Evaluasi' })" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                            @empty
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-6 flex items-center justify-center text-center">
                                <p class="text-sm font-karla font-bold text-gray-500">Belum ada evaluasi di sini!!</p>
                            </div>
                            @endforelse

                            <a href="{{ route('teacher.evaluations.create', $currentModuleId) }}" class="w-full py-3 px-4 border-2 border-dashed border-red-200 hover:border-[#d62828] hover:bg-red-50 rounded-xl text-[#d62828] font-bold font-karla text-sm flex items-center justify-center gap-2 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Tambah
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Tasks --}}
                <div>
                    <h3 class="text-base sm:text-lg font-bold font-ibm text-gray-900 mb-4">Tugas</h3>
                    <div class="space-y-3">
                        @forelse($tasks as $task)
                        <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm hover:shadow-md transition flex items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold font-karla text-gray-900">{{ $task->judul_tugas }}</h4>
                                    <span class="inline-block px-2.5 py-0.5 rounded-md bg-yellow-50 text-yellow-700 text-[10px] sm:text-[11px] font-bold font-karla mt-1">Due: {{ $task->waktu_pengumpulan ? \Carbon\Carbon::parse($task->waktu_pengumpulan)->translatedFormat('d M Y, H:i') : '-' }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <a href="{{ route('teacher.tasks.show', ['id_modul' => $currentModuleId, 'id_tugas' => $task->id_tugas]) }}" class="inline-flex items-center gap-1.5 bg-[#d62828] hover:bg-red-700 text-white font-bold font-karla py-1.5 px-3 rounded-lg text-xs transition shadow-sm">
                                    Lihat
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                                <button x-data @click="$dispatch('open-delete-item-modal', { id: {{ $task->id_tugas }}, name: '{{ addslashes($task->judul_tugas) }}', type: 'Tugas' })" class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-6 flex items-center justify-center text-center">
                            <p class="text-sm font-karla font-bold text-gray-500">Belum ada tugas di sini!!</p>
                        </div>
                        @endforelse

                        <a href="{{ route('teacher.tasks.create', $currentModuleId) }}" class="w-full py-3 px-4 border-2 border-dashed border-red-200 hover:border-[#d62828] hover:bg-red-50 rounded-xl text-[#d62828] font-bold font-karla text-sm flex items-center justify-center gap-2 transition mt-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah
                        </a>
                    </div>
                </div>

            </div>
        </div>

        {{-- Right Column (Spans 1/4) --}}
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-100 rounded-2xl lg:rounded-3xl p-5 shadow-sm sticky top-6">
                <h3 class="text-sm sm:text-base font-bold font-ibm text-gray-900 mb-4">Daftar Modul</h3>
                
                <div class="space-y-2">
                    @foreach($modules as $m)
                    @if($m->id_modul == $currentModuleId)
                    <div class="w-full px-4 py-3 rounded-xl bg-[#d62828] text-white font-bold font-karla text-sm shadow-md flex items-center justify-between">
                        Modul {{ $m->id_modul }}: {{ $m->nama_modul }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                    @else
                    <a href="{{ route('teacher.modules.show', $m->id_modul) }}" class="w-full px-4 py-3 rounded-xl bg-white border border-gray-100 hover:border-red-200 hover:shadow-sm text-gray-700 hover:text-[#d62828] font-bold font-karla text-sm flex items-center justify-between transition-all">
                        Modul {{ $m->id_modul }}: {{ $m->nama_modul }}
                    </a>
                    @endif
                    @endforeach

                    <button x-data @click="$dispatch('open-add-module-modal')" class="w-full mt-2 py-3 px-4 border-2 border-dashed border-red-200 hover:border-[#d62828] hover:bg-red-50 rounded-xl text-[#d62828] font-bold font-karla text-sm flex items-center justify-center gap-2 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Modul Baru
                    </button>
                </div>
            </div>
        </div>

    </div>



</div>
@endsection

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
                 <div class="p-6 sm:p-8 lg:p-10" x-data="{ selectedIcon: 2, sequential: false, isLoading: false }">
                     <div class="mb-8">
                         <h3 class="text-xl sm:text-2xl font-bold font-ibm text-gray-900" id="modal-title">Tambah Modul Baru</h3>
                     </div>

                     <!-- Form Grid (Single Column) -->
                     <form action="{{ route('teacher.modules.store') }}" method="POST" class="space-y-6" @submit="isLoading = true">
                         @csrf
                         <input type="hidden" name="id_mapel" value="{{ $modul->id_mapel ?? 1 }}">
                         <input type="hidden" name="icon_type" x-model="selectedIcon">
                         <input type="hidden" name="is_sequential" x-bind:value="sequential ? 1 : 0">
                         
                         <div class="space-y-1.5">
                             <x-input-label>Judul Modul:</x-input-label>
                             <x-text-input type="text" name="nama_modul" required placeholder="cth., Module 2: Vocabulary &amp; Reading (Kotoba &amp; Dokkai)" class="w-full" />
                         </div>

                         <div class="space-y-1.5">
                             <x-input-label>Alokasi Durasi (JP):</x-input-label>
                             <x-text-input type="number" name="jp" required placeholder="cth., 22" class="w-full" />
                         </div>

                         <div>
                             <div class="mb-3">
                                 <x-input-label>Pilih Ikon Modul:</x-input-label>
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

                         <div class="space-y-1.5">
                             <x-input-label>Deskripsi Modul:</x-input-label>
                             <textarea name="module_description" rows="4" placeholder="Tulis deskripsi singkat...." class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm resize-y min-h-[120px] shadow-sm"></textarea>
                         </div>

                         <div class="flex items-start justify-between gap-4 pt-3 mt-4 border-t border-gray-100">
                             <div>
                                 <x-input-label class="mb-1">Akses Berurutan</x-input-label>
                                 <p class="text-[13px] font-karla text-gray-600 leading-snug">Kunci modul ini (Siswa harus menyelesaikan modul sebelumnya untuk membuka akses).</p>
                             </div>
                             <button type="button" @click="sequential = !sequential" :class="sequential ? 'bg-[#d62828]' : 'bg-gray-200'" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none">
                                 <span class="sr-only">Toggle sequential access</span>
                                 <span aria-hidden="true" :class="sequential ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                             </button>
                         </div>

                         <!-- Actions -->
                         <div class="mt-4 flex items-center gap-4 pt-6 border-t border-gray-100">
                             <button type="button" @click="open = false" x-bind:disabled="isLoading" class="px-6 py-3 rounded-xl border border-[#d62828] text-[#d62828] font-bold font-karla hover:bg-red-50 transition w-full sm:w-auto sm:flex-1 text-sm sm:text-base disabled:opacity-50">
                                 Batal
                             </button>
                             <x-primary-button type="submit" x-bind:disabled="isLoading" class="w-full sm:w-auto sm:flex-[2.5] justify-center text-sm sm:text-base py-3 disabled:opacity-70 disabled:cursor-not-allowed">
                                 <svg x-show="isLoading" style="display: none;" class="animate-spin h-4 w-4 text-white mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                 <span x-text="isLoading ? 'Memproses...' : 'Buat Modul'"></span>
                             </x-primary-button>
                         </div>
                     </form>
                 </div>
            </div>
        </div>
    </div>
@endpush

@push('modals')
    {{-- Modal Edit Module --}}
    <div x-data="{ open: false, isLoading: false }" 
         x-show="open" 
         @open-edit-module-modal.window="open = true"
         style="display: none;"
         class="fixed inset-0 z-[100] overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div x-show="open" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" 
             @click="open = false"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-[32px] bg-white text-left shadow-xl transition-all w-full max-w-2xl border border-gray-100">
                 
                 <button @click="open = false" class="absolute top-6 right-6 p-2 rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                 </button>

                 <div class="p-6 sm:p-8 lg:p-10" x-data="{ selectedIcon: 2, sequential: false }">
                     <div class="mb-8">
                         <h3 class="text-xl sm:text-2xl font-bold font-ibm text-gray-900">Edit Modul</h3>
                     </div>

                     <form class="space-y-6">
                         <div class="space-y-1.5">
                             <x-input-label>Judul Modul:</x-input-label>
                             <x-text-input type="text" value="{{ $moduleTitle }}" />
                         </div>

                         <div class="space-y-1.5">
                             <x-input-label>Alokasi Durasi (JP):</x-input-label>
                             <x-text-input type="text" value="16" />
                         </div>

                         <div>
                             <div class="mb-3">
                                 <x-input-label>Pilih Ikon Modul:</x-input-label>
                             </div>
                             <div class="flex items-center gap-4">
                                 <button type="button" @click="selectedIcon = 1" :class="selectedIcon === 1 ? 'border-[#d62828] bg-red-50' : 'border-gray-200 hover:border-red-200'" class="w-14 h-14 rounded-2xl border-2 flex items-center justify-center transition-colors text-[#d62828]">
                                     <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" /></svg>
                                 </button>
                                 <button type="button" @click="selectedIcon = 2" :class="selectedIcon === 2 ? 'border-[#d62828] bg-red-50' : 'border-gray-200 hover:border-red-200'" class="w-14 h-14 rounded-2xl border-2 flex items-center justify-center transition-colors text-[#d62828]">
                                     <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                 </button>
                                 <button type="button" @click="selectedIcon = 3" :class="selectedIcon === 3 ? 'border-[#d62828] bg-red-50' : 'border-gray-200 hover:border-red-200'" class="w-14 h-14 rounded-2xl border-2 flex items-center justify-center transition-colors text-[#d62828]">
                                     <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a1.5 1.5 0 01-1.5 1.5H9c-.443 0-.792-.35-.792-.792 0-.214-.078-.415-.224-.555C7.755 6 7.424 6 7.125 6c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401h0a1.5 1.5 0 011.5 1.5v2.625c0 .443-.35.792-.792.792-.214 0-.415.078-.555.224C10 16.245 10 16.576 10 16.875c0 1.036 1.007 1.875 2.25 1.875s2.25-.84 2.25-1.875c0-.369-.128-.713-.349-1.003-.215-.283-.401-.604-.401-.959v0a1.5 1.5 0 011.5-1.5h2.625c.443 0 .792.35.792.792 0 .214.078.415.224.555.229.229.56.229.859.229 1.036 0 1.875-1.007 1.875-2.25s-.84-2.25-1.875-2.25c-.369 0-.713.128-1.003.349-.283.215-.604.401-.959.401h0a1.5 1.5 0 01-1.5-1.5V6.087z" /></svg>
                                 </button>
                                 <button type="button" @click="selectedIcon = 4" :class="selectedIcon === 4 ? 'border-[#d62828] bg-red-50' : 'border-gray-200 hover:border-red-200'" class="w-14 h-14 rounded-2xl border-2 flex items-center justify-center transition-colors text-[#d62828]">
                                     <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" /></svg>
                                 </button>
                             </div>
                         </div>

                         <div class="space-y-1.5">
                             <x-input-label>Deskripsi Modul:</x-input-label>
                             <textarea rows="4" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm resize-y min-h-[120px] shadow-sm">Modul ini dirancang untuk memperkuat penguasaan kosakata (Kotoba) esensial dan kemampuan pemahaman bacaan (Dokkai) level N4.</textarea>
                         </div>

                         <div class="mt-4 flex items-center gap-4 pt-6 border-t border-gray-100">
                             <button type="button" @click="open = false" class="px-6 py-3 rounded-xl border border-[#d62828] text-[#d62828] font-bold font-karla hover:bg-red-50 transition w-full sm:w-auto sm:flex-1 text-sm sm:text-base">
                                 Batal
                             </button>
                             <x-primary-button type="button" @click="
                                 isLoading = true;
                                 setTimeout(() => {
                                     isLoading = false;
                                     open = false;
                                     $dispatch('show-toast', { message: 'Modul berhasil diperbarui' });
                                 }, 800);
                             " x-bind:disabled="isLoading" class="w-full sm:w-auto sm:flex-[2.5] justify-center gap-2 text-sm sm:text-base py-3">
                                 <svg x-show="isLoading" class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                 <span x-text="isLoading ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                             </x-primary-button>
                         </div>
                     </form>
                 </div>
            </div>
        </div>
    </div>

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
                         fetch(`/teacher/subjects/modules/${moduleId}`, {
                             method: 'DELETE',
                             headers: {
                                 'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                 'Accept': 'application/json'
                             }
                         })
                         .then(response => response.json())
                         .then(data => {
                             if (data.success) {
                                 window.location.href = '{{ route('teacher.subjects.show', $modul->id_mapel ?? 1) }}?success=modul_deleted';
                             } else {
                                 isLoading = false;
                                 alert(data.message || 'Gagal menghapus modul');
                             }
                         })
                         .catch(error => {
                             isLoading = false;
                             alert('Terjadi kesalahan jaringan.');
                             console.error('Error:', error);
                         });
                     " :disabled="isLoading" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-bold font-karla text-white shadow-sm hover:bg-red-500 sm:w-auto transition items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                         <svg x-show="isLoading" style="display: none;" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                         <span x-text="isLoading ? 'Menghapus...' : 'Ya, Hapus'"></span>
                     </button>
                     <button type="button" @click="open = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-bold font-karla text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">Batal</button>
                 </div>
            </div>
        </div>
    </div>

    @push('modals')
    {{-- Delete Item Modal --}}
    <div x-data="{ 
            open: false, 
            itemId: null, 
            itemName: '', 
            itemType: '', 
            isLoading: false,
            deleteUrl: ''
         }" 
         x-show="open" 
         x-on:open-delete-item-modal.window="
            itemId = $event.detail.id; 
            itemName = $event.detail.name; 
            itemType = $event.detail.type; 
            if (itemType === 'Materi') {
                deleteUrl = '{{ url('/teacher/modules/' . $currentModuleId . '/materials') }}/' + itemId;
            } else if (itemType === 'Tugas') {
                deleteUrl = '{{ url('/teacher/modules/' . $currentModuleId . '/tasks') }}/' + itemId;
            } else if (itemType === 'Evaluasi') {
                deleteUrl = '{{ url('/teacher/modules/' . $currentModuleId . '/evaluations') }}/' + itemId;
            }
            open = true;
         "
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
                         <h3 class="text-xl font-bold font-ibm text-gray-900" id="modal-title">Hapus <span x-text="itemType"></span></h3>
                         <div class="mt-2">
                             <p class="text-sm font-karla text-gray-500 leading-relaxed">Apakah Anda yakin ingin menghapus <span class="font-bold text-gray-700" x-text="itemName"></span>? Tindakan ini tidak dapat dikembalikan.</p>
                         </div>
                     </div>
                 </div>
                 
                 <div class="mt-8 sm:mt-6 sm:flex sm:flex-row-reverse gap-3">
                     <form :action="deleteUrl" method="POST" class="m-0" @submit="isLoading = true">
                         @csrf
                         @method('DELETE')
                         <button type="submit" :disabled="isLoading" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-bold font-karla text-white shadow-sm hover:bg-red-500 sm:w-auto transition items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                             <svg x-show="isLoading" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                             <span x-text="isLoading ? 'Menghapus...' : 'Ya, Hapus'"></span>
                         </button>
                     </form>
                     <button type="button" @click="open = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-bold font-karla text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition">Batal</button>
                 </div>
            </div>
        </div>
    </div>
    @endpush

    {{-- Global Toast Notification --}}
    <div x-data="{ show: false, message: '' }" 
         x-init="
            @if(session('success'))
                message = '{{ session('success') }}';
                show = true;
                setTimeout(() => show = false, 3000);
            @elseif(request()->query('success') === 'evaluation_created')
                message = 'Evaluasi berhasil ditambahkan!';
                show = true;
                setTimeout(() => show = false, 3000);
                
                const url = new URL(window.location);
                url.searchParams.delete('success');
                window.history.replaceState({}, '', url);
            @endif
         "
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
