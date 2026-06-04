@extends('layouts.student')

@section('title', 'Terdaftar - LPK Seishin')

@php
    // Dummy Data untuk halaman Terdaftar
    $enrolledClasses = [
        (object)[
            'id_mapel' => 1, // ID fiktif untuk link
            'icon' => 'あa',
            'icon_color' => 'text-[#d62828]',
            'module_count' => 7,
            'status' => 'Proses',
            'title' => 'N4 Mastering',
            'description' => 'Program lanjutan 2 bulan (264 JP) dengan fokus praktik. Mencakup 7 unit kompetensi bahasa Jepang hingga persiapan ujian level N4.',
            'button_text' => 'Buka Kelas →',
        ],
        (object)[
            'id_mapel' => 2,
            'icon' => 'あa',
            'icon_color' => 'text-[#d62828]',
            'module_count' => 8,
            'status' => 'Proses',
            'title' => 'N5 Mastering',
            'description' => 'Program intensif 3 bulan (396 JP) dengan fokus praktik. Mencakup 8 unit kompetensi dasar bahasa Jepang hingga persiapan ujian level N5.',
            'button_text' => 'Buka Kelas →',
        ],
        (object)[
            'id_mapel' => 3,
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>',
            'icon_color' => 'text-[#d62828]',
            'module_count' => 1,
            'status' => 'Selesai',
            'title' => 'Pre-Test Nihongo',
            'description' => 'Program intensif 3 bulan (396 JP) dengan fokus praktik. Mencakup 8 unit kompetensi dasar bahasa Jepang hingga persiapan ujian level N5.',
            'button_text' => 'Buka Kelas →',
        ]
    ];
@endphp

@section('content')
<div class="p-4 sm:p-6 lg:p-10">
    
    <div class="mb-8 text-left">
        <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Terdaftar</h1>
        <p class="text-sm text-[#666666] font-medium mt-2">Ruang Belajarmu</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($enrolledClasses as $class)
            <div class="bg-white border border-gray-100 rounded-3xl p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white border border-gray-100 rounded-2xl flex items-center justify-center shadow-sm {{ $class->icon_color }} font-bold text-lg">
                            {!! $class->icon !!}
                        </div>
                        <div class="flex flex-col items-center justify-center bg-white border border-gray-100 rounded-2xl px-3 py-1.5 shadow-sm min-w-[3rem]">
                            <span class="text-lg font-black text-[#222222] leading-none">{{ $class->module_count }}</span>
                            <span class="text-[8px] font-bold text-[#666666] uppercase tracking-widest mt-0.5">Modul</span>
                        </div>
                    </div>
                    
                    @if($class->status === 'Proses')
                        <span class="bg-[#FFB800] text-white text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                            Proses
                        </span>
                    @elseif($class->status === 'Selesai')
                        <span class="bg-[#00C853] text-white text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                            Selesai
                        </span>
                    @endif
                </div>

                <div class="flex-1">
                    <h3 class="text-2xl font-black text-[#222222] mb-3 tracking-tight">{{ $class->title }}</h3>
                    <p class="text-xs font-medium text-[#666666] leading-relaxed mb-6">
                        {{ $class->description }}
                    </p>
                </div>

                <div class="flex justify-end mt-auto pt-4 border-t border-gray-50">
                    <a href="{{ route('subjects.show', $class->id_mapel) }}" class="inline-flex items-center gap-2 bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl text-xs transition shadow-sm group">
                        {{ $class->button_text }}
                        <span class="group-hover:translate-x-1 transition-transform"></span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
