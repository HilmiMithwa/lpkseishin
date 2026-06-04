@extends('layouts.student')

@section('title', 'Ruang Tugas Saya - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10 space-y-6">
    
    <div class="flex items-center justify-between mb-8">
        <div class="text-left">
            <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Tugas Saya</h1>
            <p class="text-sm text-[#666666] font-medium mt-2">Ruang Tugas</p>
        </div>
        <button class="flex items-center gap-2 border border-gray-100 rounded-xl px-4 py-2 text-xs font-bold text-[#444444] hover:bg-gray-50 transition shadow-sm">
            Saring 
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
        </button>
    </div>

    <div class="space-y-4">
        @forelse($tasks as $task)
            @php
                $isSubmitted = !is_null($task->id_pengiriman);
                $isOverdue = \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::parse($task->waktu_pengumpulan));

                if ($isSubmitted) {
                    $statusText = 'Terkirim';
                    $statusClass = 'text-green-500';
                } elseif ($isOverdue) {
                    $statusText = 'Terlewat';
                    $statusClass = 'text-red-500';
                } else {
                    $statusText = 'Belum Selesai';
                    $statusClass = 'text-gray-400';
                }
            @endphp

            <div class="p-4 bg-white border border-gray-100 rounded-[24px] flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm hover:shadow-md transition duration-200">
                <div class="flex items-center gap-4 min-w-0">
                    <div class="w-12 h-12 bg-red-50 text-[#d62828] rounded-2xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div class="min-w-0 text-left">
                        <h3 class="text-sm lg:text-base font-bold text-[#222222] truncate">{{ $task->judul_tugas }}</h3>
                        <div class="inline-block bg-amber-50 rounded-lg px-2.5 py-1 mt-1.5">
                            <p class="text-[10px] font-bold text-amber-600 tracking-wide">
                                Tenggat: {{ \Carbon\Carbon::parse($task->waktu_pengumpulan)->translatedFormat('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between sm:justify-end gap-6 flex-shrink-0">
                    <span class="text-[11px] font-bold uppercase tracking-wider {{ $statusClass }}">
                        {{ $statusText }}
                    </span>

                    <a href="{{ route('tasks.show', ['id_mapel' => $task->id_mapel, 'id_modul' => $task->id_modul, 'id_tugas' => $task->id_tugas]) }}" 
                        class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs shadow-sm transition duration-200 flex items-center gap-1.5">
                        <span>Buka Tugas</span>
                        <svg class="w-3.5 h-3.5 mt-[0.5px]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="p-12 text-center bg-gray-50/50 rounded-[32px] border border-dashed border-gray-200">
                <p class="text-sm font-medium text-gray-400 italic">Belum ada tugas yang tersedia pada seluruh kelas yang kamu kontrak saat ini.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection