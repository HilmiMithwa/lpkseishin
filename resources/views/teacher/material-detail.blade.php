@extends('layouts.teacher')

@section('title', 'Detail Materi - LPK Seishin')

@section('content')
@php
    $isPractice = strtolower($material->type) === 'practice';
    $typeBadge = $isPractice ? 'Praktek' : 'Teori';
    $typeColor = $isPractice ? 'bg-orange-100 text-[#d62828] border border-orange-200' : 'bg-red-50 text-[#d62828] border border-red-100';
@endphp
<div class="p-4 sm:p-6 lg:p-10">

    {{-- Breadcrumb & Back --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('teacher.modules.show', $currentModuleId) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-gray-900 tracking-tight">Detail Materi</h1>
        </div>
        <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm font-karla text-gray-500">
            <a href="{{ route('teacher.classes') }}" class="hover:text-[#d62828] transition">Kelas Saya</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('teacher.batch.show', $batchId) }}" class="hover:text-[#d62828] transition">{{ $batchName }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('teacher.subjects.show', $mapelId) }}" class="hover:text-[#d62828] transition">{{ $className }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('teacher.modules.show', $currentModuleId) }}" class="hover:text-[#d62828] transition">Modul {{ $moduleIndex }}</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-[#d62828] font-bold">{{ $material->nama_bahan_ajar }}</span>
        </div>
    </div>

    {{-- Content Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8 items-start">
        
        {{-- Main Area (Content Viewer) --}}
        <div class="lg:col-span-2 space-y-6">
            
            @if($material->video_url)
            {{-- Video Player - Only shown when video_url exists --}}
            <div class="bg-white rounded-[24px] lg:rounded-[32px] border border-gray-100 p-4 sm:p-6 shadow-sm">
                @php
                    // Extract YouTube video ID if applicable
                    $videoId = null;
                    if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([\w-]+)/', $material->video_url, $matches)) {
                        $videoId = $matches[1];
                    }
                @endphp
                @if($videoId)
                <div class="w-full aspect-video rounded-[16px] overflow-hidden">
                    <iframe 
                        src="https://www.youtube.com/embed/{{ $videoId }}" 
                        class="w-full h-full" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
                @else
                <div class="w-full aspect-video rounded-[16px] overflow-hidden bg-black">
                    <video 
                        controls 
                        controlsList="nodownload"
                        class="w-full h-full object-contain"
                        preload="metadata"
                    >
                        <source src="{{ asset($material->video_url) }}" type="video/mp4">
                        Maaf, browser Anda tidak mendukung pemutar video bawaan.
                    </video>
                </div>
                @endif
            </div>
            @endif

            {{-- Description & Material Content --}}
            <div class="bg-white rounded-[24px] lg:rounded-[32px] border border-gray-100 p-6 sm:p-8 shadow-sm space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-[#222222] uppercase tracking-wider mb-4">Deskripsi Materi</h3>
                    <div class="text-sm font-karla text-gray-600 leading-relaxed quill-content">
                        {!! $material->bahan_ajar_description ?? 'Tidak ada deskripsi.' !!}
                    </div>
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
                                <p class="text-[10px] text-gray-500 font-semibold mt-0.5 uppercase">Dokumen</p>
                            </div>
                        </div>
                        <a href="{{ $material->path_file_dokumen_ajar }}" target="_blank" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-xl flex items-center gap-2 hover:bg-gray-100 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Lihat
                        </a>
                    </div>
                </div>
                @endif

                {{-- Objective section if available --}}
                @if($material->objective)
                <div class="pt-6 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-[#222222] uppercase tracking-wider mb-3">Tujuan Pembelajaran</h3>
                    <p class="text-sm font-karla text-gray-600 leading-relaxed">{{ $material->objective }}</p>
                </div>
                @endif

                {{-- Tugas Praktik --}}
                @if($isPractice && isset($tugas) && $tugas)
                <div class="pt-6 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-[#222222] uppercase tracking-wider mb-3">Tugas Praktik</h3>
                    <div class="bg-red-50 border border-red-100 rounded-2xl p-5 mb-4">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            <h4 class="font-bold font-ibm text-gray-900">{{ $tugas->judul_tugas }}</h4>
                        </div>
                        <p class="text-sm font-karla text-gray-600 mb-4">{{ $tugas->deskripsi_tugas }}</p>
                        <div class="flex items-center gap-4 text-xs font-bold font-karla text-gray-500">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Tenggat: {{ \Carbon\Carbon::parse($tugas->waktu_pengumpulan)->format('d M Y, H:i') }}</span>
                            </div>
                        </div>
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
                @if($material->focus_skill || $material->key_points || $material->sensei_note || $material->video_url || $material->video_title)
                <div>
                    <h4 class="text-xs font-bold font-karla text-gray-400 uppercase tracking-wider mb-3">Detail Pembelajaran</h4>
                    <div class="space-y-3">
                        @if($material->video_title)
                        <div class="flex flex-col text-sm font-karla border-b border-gray-50 pb-2">
                            <span class="text-gray-500 text-xs mb-1">Judul Video</span>
                            <span class="font-bold text-gray-900">{{ $material->video_title }}</span>
                        </div>
                        @endif
                        @if($material->focus_skill)
                        <div class="flex flex-col text-sm font-karla border-b border-gray-50 pb-2">
                            <span class="text-gray-500 text-xs mb-1">Fokus Keahlian</span>
                            <span class="font-bold text-gray-900">{{ $material->focus_skill }}</span>
                        </div>
                        @endif
                        @if($material->key_points)
                        <div class="flex flex-col text-sm font-karla border-b border-gray-50 pb-2">
                            <span class="text-gray-500 text-xs mb-1">Poin Penting</span>
                            <span class="font-bold text-gray-900">{{ $material->key_points }}</span>
                        </div>
                        @endif
                        @if($material->sensei_note)
                        <div class="flex flex-col text-sm font-karla pb-2">
                            <span class="text-gray-500 text-xs mb-1">Catatan Sensei</span>
                            <span class="font-bold text-gray-900">{{ $material->sensei_note }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <div class="pt-6 border-t border-gray-100">
                    <h4 class="text-xs font-bold font-karla text-gray-400 uppercase tracking-wider mb-3">Informasi Tambahan</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm font-karla">
                            <span class="text-gray-500">Tipe</span>
                            <span class="font-bold text-gray-900 capitalize">{{ $material->type }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm font-karla">
                            <span class="text-gray-500">Dibuat</span>
                            <span class="font-bold text-gray-900">{{ $material->created_at ? $material->created_at->format('d M Y') : '-' }}</span>
                        </div>
                        @if($material->video_duration)
                        <div class="flex items-center justify-between text-sm font-karla">
                            <span class="text-gray-500">Durasi Video</span>
                            <span class="font-bold text-gray-900">{{ $material->video_duration }}</span>
                        </div>
                        @endif
                        @if($material->ukuran_file_dokumen_ajar)
                        <div class="flex items-center justify-between text-sm font-karla">
                            <span class="text-gray-500">Ukuran File</span>
                            <span class="font-bold text-gray-900">{{ number_format($material->ukuran_file_dokumen_ajar / 1024, 1) }} KB</span>
                        </div>
                        @endif
                        <div class="flex items-center justify-between text-sm font-karla">
                            <span class="text-gray-500">Terakhir Diubah</span>
                            <span class="font-bold text-gray-900">{{ $material->updated_at ? $material->updated_at->diffForHumans() : '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex items-center gap-3">
                    <a href="{{ route('teacher.materials.edit', [$currentModuleId, $material->id_bahan_ajar]) }}" class="flex-1 flex items-center justify-center gap-2 py-3.5 bg-[#d62828] hover:bg-red-700 text-white font-bold font-karla text-sm rounded-xl transition shadow-lg shadow-red-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Materi
                    </a>
                    <button x-data @click="$dispatch('open-delete-item-modal', { id: {{ $material->id_bahan_ajar }}, name: '{{ addslashes($material->nama_bahan_ajar) }}', type: 'Materi' })" class="p-3 bg-white border border-red-200 hover:border-red-500 text-red-500 hover:bg-red-50 rounded-xl transition shadow-sm" title="Hapus Materi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>

    </div>



</div>

<style>
    /* Quill content article styling overrides for Tailwind reset */
    .quill-content h1 { font-size: 1.8em; font-weight: bold; margin-bottom: 0.5em; color: #111; line-height: 1.3; }
    .quill-content h2 { font-size: 1.5em; font-weight: bold; margin-bottom: 0.5em; color: #222; line-height: 1.3; }
    .quill-content h3 { font-size: 1.25em; font-weight: bold; margin-bottom: 0.5em; color: #333; line-height: 1.3; }
    .quill-content p { margin-bottom: 1em; }
    .quill-content ul { list-style-type: disc; padding-left: 1.5em; margin-bottom: 1em; }
    .quill-content ol { list-style-type: decimal; padding-left: 1.5em; margin-bottom: 1em; }
    .quill-content a { color: #d62828; text-decoration: underline; }
    .quill-content blockquote { border-left: 4px solid #e5e7eb; padding-left: 1em; color: #6b7280; font-style: italic; margin-bottom: 1em; }
    .quill-content pre { background-color: #f3f4f6; padding: 1em; border-radius: 0.5rem; overflow-x: auto; font-family: monospace; font-size: 0.875em; margin-bottom: 1em; }
    .quill-content strong { font-weight: 700; color: #111; }
    .quill-content em { font-style: italic; }

    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 20px; }
</style>


@endsection

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
            deleteUrl = itemType === 'Materi' 
                 ? '{{ url('/teacher/modules/' . $currentModuleId . '/materials') }}/' + itemId 
                 : '{{ url('/teacher/modules/' . $currentModuleId . '/tasks') }}/' + itemId;
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
