@extends('layouts.teacher')

@section('title', 'Detail Materi - LPK Seishin')

@section('content')
@php
    // $material is now passed from the controller (Eloquent model)
    $isPractice = strtolower($material->type ?? 'theory') === 'practice' || strtolower($material->type ?? 'theory') === 'praktek';

    // Badge Design
    $typeBadge = $isPractice ? 'Praktek' : 'Teori';
    $typeColor = $isPractice ? 'bg-orange-100 text-[#d62828] border border-orange-200' : 'bg-red-50 text-[#d62828] border border-red-100';

    // Breadcrumb data from module relationship
    $batchName = $module->mapel->batch->nama_batch ?? 'Batch';
    $className = $module->mapel->nama_mapel ?? 'Kelas';
@endphp
<div class="p-4 sm:p-6 lg:p-10">

    {{-- Breadcrumb & Back --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('teacher.modules.show', $currentModuleId ?? 1) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-gray-900 tracking-tight">Detail Materi</h1>
        </div>
        <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm font-karla text-gray-500">
            <a href="{{ route('teacher.classes') }}" class="hover:text-[#d62828] transition">Kelas Saya</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('teacher.batch.show', $module->mapel->id_batch ?? 1) }}" class="hover:text-[#d62828] transition">{{ $batchName }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('teacher.subjects.show', $module->id_mapel ?? 1) }}" class="hover:text-[#d62828] transition">{{ $className }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('teacher.modules.show', $currentModuleId ?? 1) }}" class="hover:text-[#d62828] transition">{{ $module->nama_modul ?? 'Modul ' . $currentModuleId }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#d62828] font-bold">{{ $material->nama_bahan_ajar }}</span>
        </div>
    </div>

    {{-- Content Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">
        
        {{-- Main Area (Content Viewer) --}}
        <div class="lg:col-span-2 space-y-6">
            
            @if(!$isPractice)
            {{-- Video Player --}}
            <div class="bg-white rounded-[24px] lg:rounded-[32px] border border-gray-100 p-4 sm:p-6 shadow-sm">
                <div class="w-full aspect-video bg-gray-900 rounded-[16px] overflow-hidden flex flex-col items-center justify-center text-center relative group">
                    <img src="https://images.unsplash.com/photo-1528459801416-a9e53bbf4e17?q=80&w=800" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition duration-500" alt="Thumbnail">
                    <button class="relative z-10 w-16 h-16 bg-[#d62828] text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition duration-200">
                        <svg class="w-8 h-8 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </button>
                    <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between z-10">
                        <div class="flex items-center gap-2">
                            <button class="text-white hover:text-gray-300"><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg></button>
                            <div class="w-32 h-1 bg-white/30 rounded-full overflow-hidden"><div class="w-1/3 h-full bg-[#d62828]"></div></div>
                            <span class="text-white text-xs font-bold">04:12 / 12:40</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Description & Material Content --}}
            <div class="bg-white rounded-[24px] lg:rounded-[32px] border border-gray-100 p-6 sm:p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-[#222222] uppercase tracking-wider mb-4">Deskripsi Materi</h3>
                    <p class="text-sm font-karla text-gray-600 leading-relaxed">
                        {{ $material->bahan_ajar_description ?? 'Belum ada deskripsi.' }}
                    </p>
                </div>

                {{-- Document --}}
                @if($material->nama_dokumen_ajar)
                <div class="pt-6 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-[#222222] uppercase tracking-wider mb-3">Dokumen Lampiran</h3>
                    <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-2xl gap-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-[#222222] truncate">{{ $material->nama_dokumen_ajar }}</p>
                                <p class="text-[10px] text-gray-500 font-semibold mt-0.5 uppercase">{{ $material->ukuran_file_dokumen_ajar ?? 'Dokumen' }}</p>
                            </div>
                        </div>
                        @if($material->path_file_dokumen_ajar)
                        <a href="{{ asset('storage/' . $material->path_file_dokumen_ajar) }}" target="_blank" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-xl flex items-center gap-2 hover:bg-gray-100 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Lihat
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                @if($isPractice)
                {{-- Practical Task Card --}}
                <div class="pt-6 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-[#222222] uppercase tracking-wider mb-3">Tugas Praktik</h3>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-5 bg-[#fffdfc] border border-red-100 rounded-2xl gap-4 shadow-sm">
                        <div class="flex items-center gap-4 min-w-0">
                            <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-[#d62828] flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h4"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-base font-bold text-[#222222] truncate tracking-tight">N4 Exercise</h4>
                                <div class="mt-1 flex items-center gap-2">
                                    <span class="inline-block bg-[#FFF3CD] text-[#856404] text-[10px] font-bold px-2 py-0.5 rounded-md">Tenggat: 8 Mei 2026, 23:59</span>
                                    <span class="text-[10px] text-gray-500 font-semibold">• Terhubung dengan Tugas Module</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('teacher.tasks.show', ['id_modul' => $currentModuleId ?? 1, 'id_tugas' => 1]) }}" class="px-5 py-2.5 bg-[#d62828] text-white text-xs font-bold rounded-xl flex items-center justify-center gap-2 hover:bg-red-700 transition shadow-md shadow-red-200">
                            Buka Tugas
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Sidebar Area (Material Info) --}}
        <div class="bg-white border border-gray-100 rounded-[24px] lg:rounded-[32px] p-6 sm:p-8 shadow-sm">
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <span class="inline-block px-3 py-1.5 {{ $typeColor }} rounded-lg text-xs font-bold tracking-wide mb-3 shadow-sm">{{ $typeBadge }}</span>
                    <h2 class="text-xl sm:text-2xl font-bold font-ibm text-gray-900 leading-tight">{{ $material->nama_bahan_ajar }}</h2>
                </div>
            </div>

            <div class="space-y-6">
                @if(!$isPractice)
                <div>
                    <h4 class="text-xs font-bold font-karla text-gray-400 uppercase tracking-wider mb-3">Detail Video Pembelajaran</h4>
                    <div class="space-y-3">
                        <div class="flex flex-col text-sm font-karla border-b border-gray-50 pb-2">
                            <span class="text-gray-500 text-xs mb-1">Fokus Keahlian</span>
                            <span class="font-bold text-gray-900">{{ $material->focus_skill ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col text-sm font-karla border-b border-gray-50 pb-2">
                            <span class="text-gray-500 text-xs mb-1">Poin Penting</span>
                            <span class="font-bold text-gray-900">{{ $material->key_points ?? '-' }}</span>
                        </div>
                        <div class="flex flex-col text-sm font-karla pb-2">
                            <span class="text-gray-500 text-xs mb-1">Catatan Sensei</span>
                            <span class="font-bold text-gray-900">{{ $material->sensei_note ?? '-' }}</span>
                        </div>
                    </div>
                </div>
                @endif

                <div class="pt-6 border-t border-gray-100">
                    <h4 class="text-xs font-bold font-karla text-gray-400 uppercase tracking-wider mb-3">Informasi Tambahan</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm font-karla">
                            <span class="text-gray-500">Dibuat</span>
                            <span class="font-bold text-gray-900">{{ $material->created_at ? $material->created_at->translatedFormat('d M Y') : '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm font-karla">
                            <span class="text-gray-500">Ukuran / Durasi</span>
                            <span class="font-bold text-gray-900">{{ $material->video_duration ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm font-karla">
                            <span class="text-gray-500">Terakhir Diubah</span>
                            <span class="font-bold text-gray-900">{{ $material->updated_at ? $material->updated_at->translatedFormat('d M Y') : '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex items-center gap-3">
                    <button x-data @click="$dispatch('open-edit-material-modal')" class="flex-1 flex items-center justify-center gap-2 py-3.5 bg-[#d62828] hover:bg-red-700 text-white font-bold font-karla text-sm rounded-xl transition shadow-lg shadow-red-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Materi
                    </button>
                    <button x-data @click="$dispatch('open-delete-item-modal', { id: {{ $material->id_bahan_ajar }}, name: '{{ addslashes($material->nama_bahan_ajar) }}', type: 'Materi' })" class="p-3 bg-white border border-red-200 hover:border-red-500 text-red-500 hover:bg-red-50 rounded-xl transition shadow-sm" title="Hapus Materi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('modals')
    {{-- Modal Edit Material --}}
    <div x-data="{ open: false, isLoading: false }" 
         x-show="open" 
         @open-edit-material-modal.window="open = true"
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
                 class="relative transform overflow-hidden rounded-[32px] bg-white text-left shadow-xl transition-all w-full max-w-2xl border border-gray-100 max-h-[90vh] overflow-y-auto">
                 
                 <!-- Close Button -->
                 <button @click="open = false" class="absolute top-6 right-6 p-2 rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition z-10">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                 </button>

                 <!-- Content -->
                 <div class="p-6 sm:p-8 lg:p-10">
                     <div class="mb-8">
                         <h3 class="text-xl sm:text-2xl font-bold font-ibm text-gray-900" id="modal-title">Edit Materi</h3>
                         <p class="text-sm font-karla text-gray-500 mt-1">Perbarui informasi materi pembelajaran.</p>
                     </div>

                     <form action="{{ route('teacher.materials.update', ['id_modul' => $currentModuleId, 'id_materi' => $material->id_bahan_ajar]) }}" method="POST" class="space-y-6">
                         @csrf
                         @method('PUT')
                         
                         {{-- Nama Materi --}}
                         <div>
                             <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Judul Materi:</label>
                             <input type="text" name="nama_bahan_ajar" required value="{{ $material->nama_bahan_ajar }}" placeholder="cth., Intro to N4 and Kanji" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                         </div>

                         {{-- Tipe Materi --}}
                         <div>
                             <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Tipe Materi:</label>
                             <select name="type" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                                 <option value="theory" {{ strtolower($material->type) === 'theory' ? 'selected' : '' }}>Teori</option>
                                 <option value="practice" {{ strtolower($material->type) === 'practice' || strtolower($material->type) === 'praktek' ? 'selected' : '' }}>Praktek</option>
                             </select>
                         </div>

                         {{-- Deskripsi --}}
                         <div>
                             <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Deskripsi Materi:</label>
                             <textarea name="bahan_ajar_description" rows="4" placeholder="Tulis deskripsi materi..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm resize-y min-h-[120px]">{{ $material->bahan_ajar_description }}</textarea>
                         </div>

                         {{-- Video Fields --}}
                         <div class="pt-4 border-t border-gray-100">
                             <h4 class="text-sm font-bold font-karla text-gray-700 mb-4">Informasi Video</h4>
                             <div class="space-y-4">
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Judul Video:</label>
                                     <input type="text" name="video_title" value="{{ $material->video_title }}" placeholder="cth., Basic N4 Conversational" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                                 </div>
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">URL Video:</label>
                                     <input type="url" name="video_url" value="{{ $material->video_url }}" placeholder="cth., https://www.youtube.com/watch?v=..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                                 </div>
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Durasi Video:</label>
                                     <input type="text" name="video_duration" value="{{ $material->video_duration }}" placeholder="cth., 12 Menit 40 Detik" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                                 </div>
                             </div>
                         </div>

                         {{-- Detail Pembelajaran --}}
                         <div class="pt-4 border-t border-gray-100">
                             <h4 class="text-sm font-bold font-karla text-gray-700 mb-4">Detail Pembelajaran</h4>
                             <div class="space-y-4">
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Fokus Keahlian:</label>
                                     <input type="text" name="focus_skill" value="{{ $material->focus_skill }}" placeholder="cth., Speaking (Kaiwa)" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                                 </div>
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Poin Penting:</label>
                                     <input type="text" name="key_points" value="{{ $material->key_points }}" placeholder="cth., Jikoshoukai, Etika Ojigi" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm">
                                 </div>
                                 <div>
                                     <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Catatan Sensei:</label>
                                     <textarea name="sensei_note" rows="3" placeholder="Tulis catatan untuk siswa..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm resize-y">{{ $material->sensei_note }}</textarea>
                                 </div>
                             </div>
                         </div>

                         {{-- Tujuan Pembelajaran --}}
                         <div>
                             <label class="block text-sm font-bold font-karla text-gray-700 mb-2">Tujuan Pembelajaran:</label>
                             <textarea name="objective" rows="3" placeholder="Tulis tujuan pembelajaran..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-200 outline-none transition font-karla text-sm resize-y">{{ $material->objective }}</textarea>
                         </div>

                         <!-- Actions -->
                         <div class="mt-4 flex items-center gap-4 pt-6 border-t border-gray-100">
                             <button type="button" @click="open = false" class="px-6 py-3 rounded-xl border border-[#d62828] text-[#d62828] font-bold font-karla hover:bg-red-50 transition w-full sm:w-auto sm:flex-1 text-sm sm:text-base">
                                 Batal
                             </button>
                             <button type="submit" @click="isLoading = true" :disabled="isLoading" class="px-6 py-3 rounded-xl bg-[#d62828] text-white font-bold font-karla hover:bg-red-700 shadow-sm transition w-full sm:w-auto sm:flex-[2.5] text-sm sm:text-base flex items-center justify-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                                 <svg x-show="isLoading" class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                 <span x-text="isLoading ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                             </button>
                         </div>
                     </form>
                 </div>
            </div>
        </div>
    </div>

    {{-- Delete Item Modal --}}
    <div x-data="{ open: false, itemId: null, itemName: '', itemType: '', isLoading: false }" 
         x-show="open" 
         x-on:open-delete-item-modal.window="itemId = $event.detail.id; itemName = $event.detail.name; itemType = $event.detail.type; open = true;"
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
                         <h3 class="text-xl font-bold font-ibm text-gray-900">Hapus <span x-text="itemType"></span></h3>
                         <div class="mt-2">
                             <p class="text-sm font-karla text-gray-500 leading-relaxed">Apakah Anda yakin ingin menghapus <span class="font-bold text-gray-700" x-text="itemName"></span>? Tindakan ini tidak dapat dikembalikan.</p>
                         </div>
                     </div>
                 </div>
                 
                 <div class="mt-8 sm:mt-6 sm:flex sm:flex-row-reverse gap-3">
                     <form id="delete-material-form" action="{{ route('teacher.materials.destroy', ['id_modul' => $currentModuleId, 'id_materi' => $material->id_bahan_ajar]) }}" method="POST">
                         @csrf
                         @method('DELETE')
                         <button type="submit" @click="isLoading = true" :disabled="isLoading" class="inline-flex w-full justify-center rounded-xl bg-red-600 px-5 py-2.5 text-sm font-bold font-karla text-white shadow-sm hover:bg-red-500 sm:w-auto transition items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                             <svg x-show="isLoading" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                             <span x-text="isLoading ? 'Menghapus...' : 'Ya, Hapus'"></span>
                         </button>
                     </form>
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
