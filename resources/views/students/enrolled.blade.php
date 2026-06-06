@extends('layouts.student')

@section('title', 'Terdaftar - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10">
    
    <div class="mb-8 text-left">
        <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Terdaftar</h1>
        <p class="text-sm text-[#666666] font-medium mt-2">Ruang Belajarmu</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($subjects as $class)
            <div class="bg-white border border-gray-100 rounded-3xl p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-lg transition-all duration-300 flex flex-col h-full">
                
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-white border border-gray-100 rounded-2xl flex items-center justify-center shadow-sm {{ $class->icon_color }} font-bold text-lg">
                            {!! $class->icon !!}
                        </div>
                        <div class="flex flex-col items-center justify-center bg-white border border-gray-100 rounded-2xl px-3 py-1.5 shadow-sm min-w-[3rem]">
                            <span class="text-lg font-black text-[#222222] leading-none">{{ $class->modul_count }}</span>
                            <span class="text-[8px] font-bold text-[#666666] uppercase tracking-widest mt-0.5">Modul</span>
                        </div>
                    </div>
                    
                    @if($enrollment->status === 'Proses')
                        <span class="bg-[#FFB800] text-white text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                            Proses
                        </span>
                    @elseif($enrollment->status === 'Selesai')
                        <span class="bg-[#00C853] text-white text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">
                            Selesai
                        </span>
                    @endif
                </div>

                <div class="flex-1">
                    <h3 class="text-2xl font-black text-[#222222] mb-3 tracking-tight">{{ $class->nama_mapel }}</h3>
                    <p class="text-xs font-medium text-[#666666] leading-relaxed mb-6">
                        {{ $class->deskripsi_mapel }}
                    </p>
                </div>

                <div class="flex justify-end mt-auto pt-4 border-t border-gray-50">
                    <a href="{{ route('subjects.show', $class->id_mapel) }}" class="inline-flex items-center gap-2 bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl text-xs transition shadow-sm group">
                        Buka Kelas →
                        <span class="group-hover:translate-x-1 transition-transform"></span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 bg-white border border-gray-100 rounded-3xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
                <p class="text-sm font-semibold text-[#666666]">Kamu belum terdaftar di kelas manapun.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
