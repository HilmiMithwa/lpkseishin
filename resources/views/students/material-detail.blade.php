@extends('layouts.student')

@section('title', ($material->nama_bahan_ajar ?? 'Detail Bahan Ajar') . ' - LPK Seishin')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
@endpush

@section('content')
@php
    $fileType = strtolower($material->file_type ?? pathinfo($material->nama_dokumen_ajar, PATHINFO_EXTENSION) ?? 'default');
    if (str_contains($fileType, 'data:')) { $fileType = 'default'; }
    
    $fileConfig = match(true) {
        str_contains($fileType, 'pdf') => [
            'bg'   => 'bg-red-50', 
            'text' => 'text-[#d62828]',
            'icon' => '<span class="material-symbols-outlined text-2xl select-none">picture_as_pdf</span>'
        ],
        default => [
            'bg'   => 'bg-gray-50', 'text' => 'text-gray-500',
            'icon' => '<span class="material-symbols-outlined text-2xl select-none">description</span>'
        ]
    };

    $extractedThumbnail = 'https://images.unsplash.com/photo-1528459801416-a9e53bbf4e17?q=80&w=600';
    $videoUrl = $material->video_url ?? '';

    if (!empty($videoUrl)) {
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/', $videoUrl, $matches)) {
            $youtubeId = $matches[1];
            $extractedThumbnail = "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg";
        }
    }
@endphp

<div class="p-4 sm:p-6 lg:p-10 space-y-4">
    
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ (isset($subject) && isset($currentModul)) ? route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul]) : '#' }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight text-left">
                {{ $material->nama_bahan_ajar ?? '[Data: bahan_ajar.nama_bahan_ajar]' }}
            </h1>
        </div>
        <nav class="flex flex-wrap items-center gap-2 text-sm font-medium text-[#666666] text-left">
            <a href="{{ route('students.dashboard') }}" class="hover:text-[#d62828] transition">Terdaftar</a> <span class="mx-1.5 text-gray-300">></span> 
            <a href="{{ isset($subject) ? route('subjects.show', $subject->id_mapel) : '#' }}" class="text-[#444444] hover:text-[#d62828] transition">
                {{ $subject->nama_mapel ?? '[Data: mapel.nama_mapel]' }}
            </a> <span class="mx-1.5 text-gray-300">></span> 
            <a href="{{ (isset($subject) && isset($currentModul)) ? route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul]) : '#' }}" class="text-[#444444] hover:text-[#d62828] transition">
                {{ $currentModul->nama_modul ?? '[Data: modul.nama_modul]' }}
            </a> <span class="mx-1.5 text-gray-300">></span> 
            <span class="text-[#d62828]">{{ $material->nama_bahan_ajar ?? '[Data: bahan_ajar.nama_bahan_ajar]' }}</span>
        </nav>
    </div>

    <div class="w-full bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
            <div class="text-left">
                <h2 class="text-xl font-bold text-[#222222] tracking-wider">{{ $material->nama_bahan_ajar ?? '[Data: bahan_ajar.nama_bahan_ajar]' }}</h2>
                <p class="text-[11px] text-gray-400 font-bold mt-0.5 uppercase">{{ $material->type ?? '[Data: bahan_ajar.type]' }}</p>
            </div>
            
            <div class="flex items-center gap-3 self-stretch sm:self-auto justify-between sm:justify-end">
                @if($material->is_complete ?? false)
                    <button class="px-4 py-2 bg-green-50 text-green-600 text-xs font-bold rounded-xl border border-green-200 cursor-default">Selesai</button>
                    <div class="w-8 h-8 bg-green-50 rounded-full flex items-center justify-center text-green-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                @else
                    <form action="{{ route('materials.complete', $material->id_bahan_ajar ?? 1) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 border border-[#d62828] text-[#d62828] text-xs font-bold rounded-xl hover:bg-red-50 transition duration-200">Tandai Selesai</button>
                    </form>
                    <div class="w-8 h-8 flex items-center justify-center text-gray-300">
                       <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10" stroke-dasharray="4 4" class="animate-[spin_20s_linear_infinite] origin-center" />
                            <path d="M8.5 12.5l2.5 2.5l5-5" stroke-width="3" />
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        @if(!empty($material->video_url))
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
            <div class="lg:col-span-7">
                <div id="video-frame" class="relative w-full aspect-video rounded-[20px] overflow-hidden bg-gray-900 shadow-sm flex items-center justify-center group">
                    
                    <div id="video-preview-layer" class="absolute inset-0 w-full h-full flex items-center justify-center cursor-pointer" onclick="startOnPageVideo()">
                        <img src="{{ $extractedThumbnail }}" class="absolute inset-0 w-full h-full object-cover opacity-100 group-hover:scale-105 transition duration-300" alt="Video Thumbnail">
                        
                        <div class="absolute left-6 top-6 text-white z-10 space-y-1 text-left">
                            <p class="text-base font-black tracking-tight drop-shadow-md">
                                {{ $material->video_badge ?? 'Can Do Japanese' }}
                            </p>
                            <p class="text-xl sm:text-2xl font-black tracking-wide bg-white text-black px-2 py-0.5 inline-block rounded-md shadow-sm">
                                {{ $material->video_title ?? '[Data: bahan_ajar.video_title]' }}
                            </p>
                        </div>

                        <button class="relative z-20 w-14 h-14 bg-[#d62828] rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition duration-200">
                            <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M8 5v14l11-7z"/>
                            </svg>
                        </button>
                    </div>

                    <div id="video-active-layer" class="absolute inset-0 w-full h-full hidden">
                        @if(str_contains($material->video_url ?? '', 'youtube.com') || str_contains($material->video_url ?? '', 'youtu.be'))
                            <iframe id="iframe-player" class="w-full h-full" src="" title="Seishin Video Player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        @else
                            <video id="native-player" class="w-full h-full" controls>
                                <source src="{{ $material->video_url ?? '#' }}" type="video/mp4">
                                Browser Anda tidak mendukung video player ini.
                            </video>
                        @endif
                    </div>

                </div>
            </div>

            <div class="lg:col-span-5 flex flex-col justify-start text-left">
                <div class="flex items-center gap-2 mb-4">
                    <span class="w-1 h-4 bg-[#d62828] rounded-full"></span>
                    <h3 class="text-sm font-bold text-[#222222] uppercase tracking-wider">Video Pembelajaran</h3>
                </div>
                <div class="space-y-3 text-xs">
                    <div class="flex items-start">
                        <span class="w-24 font-bold text-[#222222] flex-shrink-0">Judul Video</span><span class="text-gray-400 mx-2">:</span>
                        <span class="flex-1 font-semibold text-[#444444]">{{ $material->video_title ?? '[Data: bahan_ajar.video_title]' }}</span>
                    </div>
                    <div class="flex items-start">
                        <span class="w-24 font-bold text-[#222222] flex-shrink-0">Durasi</span><span class="text-gray-400 mx-2">:</span>
                        <span class="flex-1 font-semibold text-[#444444]">{{ $material->video_duration ?? '[Data: bahan_ajar.video_duration]' }}</span>
                    </div>
                    <div class="flex items-start">
                        <span class="w-24 font-bold text-[#222222] flex-shrink-0">Fokus Keahlian</span><span class="text-gray-400 mx-2">:</span>
                        <span class="flex-1 font-semibold text-[#444444]">{{ $material->focus_skill ?? '[Data: bahan_ajar.focus_skill]' }}</span>
                    </div>
                    <div class="flex items-start">
                        <span class="w-24 font-bold text-[#222222] flex-shrink-0">Poin Penting</span><span class="text-gray-400 mx-2">:</span>
                        <span class="flex-1 font-semibold text-[#444444]">{{ $material->key_points ?? '[Data: bahan_ajar.key_points]' }}</span>
                    </div>
                    <div class="flex items-start">
                        <span class="w-24 font-bold text-[#222222] flex-shrink-0">Tujuan</span><span class="text-gray-400 mx-2">:</span>
                        <span class="flex-1 font-semibold text-[#444444]">{{ $material->objective ?? '[Data: bahan_ajar.objective]' }}</span>
                    </div>
                    <div class="flex items-start">
                        <span class="w-24 font-bold text-[#222222] flex-shrink-0">Catatan Sensei</span><span class="text-gray-400 mx-2">:</span>
                        <span class="flex-1 font-semibold text-[#444444]">{{ $material->sensei_note ?? '[Data: bahan_ajar.sensei_note]' }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="space-y-4 text-xs text-[#555555] leading-relaxed font-medium mb-6 text-left">
            @if(!empty($material->bahan_ajar_description))
                {!! $material->bahan_ajar_description !!}
            @else
                <p>[Data: bahan_ajar.bahan_ajar_description]</p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
            @endif
        </div>

        @if(!empty($material->nama_dokumen_ajar))
        <div class="space-y-3 mb-6 text-left">
            <h3 class="text-sm font-bold text-[#222222] uppercase tracking-wider">Dokumen</h3>

            <div class="max-w-md flex items-center justify-between p-3.5 bg-white border border-gray-100 rounded-2xl shadow-sm gap-4">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 {{ $fileConfig['bg'] }} {{ $fileConfig['text'] }} rounded-xl flex items-center justify-center flex-shrink-0">
                        {!! $fileConfig['icon'] !!}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-bold text-[#222222] truncate">{{ $material->nama_dokumen_ajar ?? '[Data: material.nama_dokumen_ajar]' }}</p>
                        <p class="text-[10px] text-gray-400 font-semibold mt-0.5 uppercase">{{ $fileType }}</p>
                    </div>
                </div>
                <a href="{{ route('materials.download', $material->id_bahan_ajar) }}" class="px-3 py-1.5 border border-[#d62828] text-[#d62828] text-[11px] font-bold rounded-xl flex items-center gap-1.5 hover:bg-red-50 transition duration-200 flex-shrink-0">
                    <span class="material-symbols-outlined text-2xl select-none">download</span>
                    Unduh
                </a>
            </div>
        </div>
        @endif

        @if(!empty($material->practical_task_title))
        <div class="space-y-3 mb-6 text-left">
            <h3 class="text-sm font-bold text-[#222222] uppercase tracking-wider">Tugas Praktik</h3>
            
            <div class="max-w-xl flex items-center justify-between p-4 bg-white border border-gray-100 rounded-2xl shadow-sm gap-4">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-12 h-12 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#d62828] flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h4"></path>
                        </svg>
                    </div>
                    
                    <div class="min-w-0">
                        <h4 class="text-sm font-bold text-[#222222] truncate tracking-tight">
                            {{ $material->practical_task_title }}
                        </h4>
                        @if(!empty($material->practical_task_due_date))
                        <div class="mt-1.5">
                            <span class="inline-block bg-[#FFF3CD] text-[#856404] text-[10px] font-bold px-2.5 py-0.5 rounded-lg">
                                Tenggat: {{ $material->practical_task_due_date }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col items-end gap-1 flex-shrink-0">
                    @php
                        $isTaskDone = strtolower($material->practical_task_status ?? '') === 'completed';
                    @endphp
                    <span class="text-[10px] font-bold {{ $isTaskDone ? 'text-green-500' : 'text-gray-400' }} uppercase tracking-wide">
                        {{ $isTaskDone ? 'Selesai' : 'Belum Selesai' }}
                    </span>
                    <a href="{{ $material->practical_task_url ?? '#' }}" class="bg-[#d62828] hover:bg-red-700 text-white text-[11px] font-bold py-2 px-4 rounded-xl flex items-center gap-1.5 transition duration-200 shadow-sm">
                        <span>Buka Tugas</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endif

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
            @if(isset($previousMaterialUrl))
                <a href="{{ $previousMaterialUrl }}" class="px-4 py-2 bg-white border border-gray-200 text-[#444444] text-xs font-bold rounded-xl flex items-center gap-1 hover:bg-gray-50 transition duration-200">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg> Sblmnya
                </a>
            @else
                <button class="px-4 py-2 bg-gray-50 text-gray-400 text-xs font-bold rounded-xl flex items-center gap-1 cursor-not-allowed" disabled>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg> Sblmnya
                </button>
            @endif
            
            @if(isset($nextMaterialUrl))
                <a href="{{ $nextMaterialUrl }}" class="px-4 py-2 bg-[#d62828] text-white text-xs font-bold rounded-xl flex items-center gap-1 hover:bg-red-700 transition duration-200 shadow-sm shadow-red-200">
                    Lanjut <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </a>
            @else
                <button class="px-4 py-2 bg-gray-50 text-gray-400 text-xs font-bold rounded-xl flex items-center gap-1 cursor-not-allowed" disabled>
                    Lanjut <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                </button>
            @endif
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    function startOnPageVideo() {
        const previewLayer = document.getElementById('video-preview-layer');
        const activeLayer = document.getElementById('video-active-layer');
        const iframePlayer = document.getElementById('iframe-player');
        const nativePlayer = document.getElementById('native-player');
        
        previewLayer.classList.add('hidden');
        activeLayer.classList.remove('hidden');
        
        let rawUrl = "{{ $material->video_url ?? '' }}";
        
        if (iframePlayer && rawUrl !== "") {
            let embedUrl = rawUrl;
            if (rawUrl.includes('youtube.com/watch?v=')) {
                let videoId = rawUrl.split('v=')[1].split('&')[0];
                embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
            } else if (rawUrl.includes('youtu.be/')) {
                let videoId = rawUrl.split('youtu.be/')[1];
                embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0`;
            }
            
            iframePlayer.src = embedUrl;
        } 
        else if (nativePlayer) {
            nativePlayer.play();
        }
    }
</script>
@endpush