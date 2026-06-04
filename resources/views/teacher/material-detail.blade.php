@extends('layouts.teacher')

@section('title', 'Detail Materi - LPK Seishin')

@section('content')
@php
    $id_materi = $id_materi ?? 1;
    
    // Dummy Data emulating dynamic backend behavior
    $material = (object)[
        'id_bahan_ajar' => $id_materi,
        'nama_bahan_ajar' => $id_materi == 1 ? 'Intro to N4 and Kanji' : 'N4 Exercise Practical',
        'type' => $id_materi == 1 ? 'Teori' : 'Praktek',
        'file_type' => $id_materi == 1 ? 'video/mp4' : 'application/pdf',
        'video_url' => $id_materi == 1 ? 'https://www.youtube.com/watch?v=12345' : null,
        'video_title' => 'Basic N4 Conversational',
        'video_duration' => '12 Menit 40 Detik',
        'created_at_formatted' => '5 Mei 2026',
        'updated_at_formatted' => 'Hari ini',
        'description' => 'Materi pengantar untuk level N4. Fokus pada pemahaman dasar kanji yang sering muncul dalam ujian dan kehidupan sehari-hari. Silakan tonton video ini sampai selesai sebelum mengerjakan kuis evaluasi.',
        'attachment_name' => 'Template N4 and Kanji.pdf'
    ];

    $isPractice = strtolower($material->type) === 'praktek';

    // Better Badge Design
    $typeBadge = $isPractice ? 'Praktek' : 'Teori';
    $typeColor = $isPractice ? 'bg-orange-100 text-[#d62828] border border-orange-200' : 'bg-red-50 text-[#d62828] border border-red-100';
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
            <a href="#" class="hover:text-[#d62828] transition">Kelas Saya</a>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span>Batch 2</span>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span>N4 Mastering</span>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('teacher.modules.show', $currentModuleId ?? 1) }}" class="hover:text-[#d62828] transition">Modul {{ $currentModuleId ?? 1 }}</a>
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
                        {{ $material->description }}
                    </p>
                </div>

                {{-- Document --}}
                <div class="pt-6 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-[#222222] uppercase tracking-wider mb-3">Dokumen Lampiran</h3>
                    <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-2xl gap-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 bg-red-100 text-red-600 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-[#222222] truncate">{{ $material->attachment_name }}</p>
                                <p class="text-[10px] text-gray-500 font-semibold mt-0.5 uppercase">PDF Document</p>
                            </div>
                        </div>
                        <a href="#" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 text-xs font-bold rounded-xl flex items-center gap-2 hover:bg-gray-100 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Lihat
                        </a>
                    </div>
                </div>

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
                            <span class="font-bold text-gray-900">Speaking (Kaiwa)</span>
                        </div>
                        <div class="flex flex-col text-sm font-karla border-b border-gray-50 pb-2">
                            <span class="text-gray-500 text-xs mb-1">Poin Penting</span>
                            <span class="font-bold text-gray-900">Jikoshoukai, Etika Ojigi, Penggunaan 'Desu'</span>
                        </div>
                        <div class="flex flex-col text-sm font-karla pb-2">
                            <span class="text-gray-500 text-xs mb-1">Catatan Sensei</span>
                            <span class="font-bold text-gray-900">Praktekkan pengucapan 'Desu' dengan jelas dan tegas.</span>
                        </div>
                    </div>
                </div>
                @endif

                <div class="pt-6 border-t border-gray-100">
                    <h4 class="text-xs font-bold font-karla text-gray-400 uppercase tracking-wider mb-3">Informasi Tambahan</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm font-karla">
                            <span class="text-gray-500">Dibuat</span>
                            <span class="font-bold text-gray-900">{{ $material->created_at_formatted }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm font-karla">
                            <span class="text-gray-500">Ukuran / Durasi</span>
                            <span class="font-bold text-gray-900">{{ $material->video_duration }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm font-karla">
                            <span class="text-gray-500">Terakhir Diubah</span>
                            <span class="font-bold text-gray-900">{{ $material->updated_at_formatted }}</span>
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex items-center gap-3">
                    <button class="flex-1 flex items-center justify-center gap-2 py-3.5 bg-[#d62828] hover:bg-red-700 text-white font-bold font-karla text-sm rounded-xl transition shadow-lg shadow-red-200">
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
