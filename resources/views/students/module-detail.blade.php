@extends('layouts.student')

@section('title', ($currentModul->nama_modul ?? 'Detail Modul') . ' - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10">
    
    <div class="mb-6">
        <h1 class="text-xl sm:text-2xl lg:text-[28px] font-bold font-ibm text-[#222222] tracking-tight mb-1 text-left">
            {{ $currentModul->nama_modul }}
        </h1>
        <nav class="flex items-center gap-2 text-sm font-medium text-[#666666] text-left">
            <a href="{{ route('students.dashboard') }}" class="hover:text-[#d62828] transition">Terdaftar</a> <span class="mx-1.5 text-gray-300">></span> 
            <a href="{{ route('subjects.show', $subject->id_mapel) }}" class="text-[#444444] hover:text-[#d62828] transition">
                {{ $subject->nama_mapel ?? '[Data: mapel.nama_mapel]' }}
            </a> 
            <span class="mx-1.5 text-gray-300">></span> 
            <span class="text-[#d62828]">{{ $currentModul->nama_modul ?? '[Data: modul.nama_modul]' }}</span>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <div class="lg:col-span-8 space-y-6">

            <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm">
                <h3 class="text-sm font-bold text-[#222222] mb-3">Deskripsi Modul</h3>
                <p class="text-xs sm:text-sm text-[#444444] leading-relaxed font-medium">
                    {{ $currentModul->module_description ?? '[Data: modul.deskripsi]' }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <div class="space-y-3 flex flex-col">
                    <div class="flex items-center gap-2 border-l-2 border-[#d62828] pl-2">
                        <h3 class="text-xs font-bold text-[#222222] uppercase tracking-wider">Bahan Ajar</h3>
                    </div>
                    <div class="flex-1 bg-white border border-gray-100 rounded-[24px] p-4 shadow-sm flex flex-col justify-center min-h-[160px]">
                    @forelse($currentModul->materials ?? [] as $material)
                        <div class="flex items-center justify-between p-3 bg-white border border-gray-50 rounded-2xl shadow-sm mb-3 last:mb-0 gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                
                                @if(($material->is_complete ?? $material->is_completed ?? 0) == 1)
                                    <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-[#30CD30] flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-12 h-12 bg-[#FFFADD] rounded-2xl flex items-center justify-center text-[#FFA100] flex-shrink-0">
                                        <svg class="w-6 h-6 animate-[spin_30s_linear_infinite]" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" viewBox="0 0 24 24">
                                            <path d="M12 3a9 9 0 0 1 0 18" />
                                            <path d="M12 21a9 9 0 0 1 0-18" stroke-dasharray="1 6.2" />
                                        </svg>
                                    </div>
                                @endif
                                
                                <div class="min-w-0 text-left">
                                    <p class="text-xs font-bold text-[#222222] truncate">
                                        {{ $material->nama_bahan_ajar ?? $material->title ?? '[Data: bahan_ajar.nama_bahan_ajar]' }}
                                    </p>
                                    <p class="text-[10px] text-[#444444] font-medium truncate uppercase">
                                        {{ $material->type ?? 'Teori' }}
                                    </p>
                                </div>
                            </div>
                            
                            <a href="{{ route('materials.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul, 'id_materi' => $material->id_bahan_ajar ?? $material->id ?? $loop->iteration]) }}" 
                            class="bg-[#d62828] hover:bg-red-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1 transition flex-shrink-0">
                                Detail 
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <p class="text-xs font-bold text-[#666666]">[Data: modul.materials]</p>
                        </div>
                    @endforelse
                    </div>
                </div>

                <div class="space-y-3 flex flex-col">
                    <div class="flex items-center gap-2 border-l-2 border-[#d62828] pl-2">
                        <h3 class="text-xs font-bold text-[#222222] uppercase tracking-wider">Evaluasi</h3>
                    </div>
                    <div class="flex-1 bg-white border border-gray-100 rounded-[24px] p-4 shadow-sm flex flex-col justify-start min-h-[160px]">
                        @isset($currentModul->evaluation)
                            <div class="flex items-center justify-between p-3 bg-white border border-gray-50 rounded-2xl shadow-sm gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-12 h-12 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#d62828] flex-shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" viewBox="0 0 24 24">
                                                <path d="M12 3a9 9 0 0 1 0 18" />
                                                <path d="M12 21a9 9 0 0 1 0-18" stroke-dasharray="1 6.2" />
                                            </svg>
                                        </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-[#222222] truncate">{{ $currentModul->evaluation->title }}</p>
                                        <p class="text-[10px] text-[#444444] font-medium truncate">
                                            {{ $currentModul->evaluation->type ?? 'Ujian' }} • {{ $currentModul->evaluation->date }} • {{ $currentModul->evaluation->duration }} Mnt
                                        </p>
                                    </div>
                                </div>
                                <a href="{{ route('evaluations.start', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul, 'id' => $currentModul->evaluation->id]) }}" class="bg-[#d62828] hover:bg-red-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1 transition flex-shrink-0">
                                    Mulai <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <p class="text-xs font-bold text-[#666666]">[Data: modul.evaluation]</p>
                            </div>
                        @endisset
                    </div>
                </div>

            </div>

            <div class="space-y-3">
                <div class="flex items-center gap-2 border-l-2 border-[#d62828] pl-2">
                    <h3 class="text-xs font-bold text-[#222222] uppercase tracking-wider">Tugas</h3>
                </div>
                <div class="bg-white border border-gray-100 rounded-[32px] p-6 shadow-sm">
                    @forelse($currentModul->tasks ?? [] as $task)
                        @php
                            $displayStatus = 'Belum Selesai';
                            if (!empty($task->submission_status)) {
                                $displayStatus = $task->submission_status === 'terlambat' ? 'Terkirim Terlambat' : 'Selesai';
                            }
                        @endphp
                        
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-5 bg-white border border-gray-100 rounded-[24px] shadow-sm mb-4 last:mb-0 gap-4 relative">
                            
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-14 h-14 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#d62828] flex-shrink-0">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h4"></path>
                                    </svg>
                                </div>
                                
                                <div class="space-y-1.5 min-w-0 text-left">
                                    <h4 class="text-base font-bold text-[#222222] truncate tracking-tight">
                                        {{ $task->judul_tugas }}
                                    </h4>
                                    <span class="inline-block bg-[#FFF3CD] text-[#856404] text-[11px] font-bold px-3 py-1 rounded-lg">
                                        Tenggat: {{ \Carbon\Carbon::parse($task->waktu_pengumpulan)->format('d M Y, H:i') }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col items-end justify-between sm:h-20 w-full sm:w-auto self-stretch flex-shrink-0 gap-2 text-right">
                                <span class="text-xs font-semibold text-gray-500 tracking-wide uppercase">
                                    {{ $displayStatus }}
                                </span>
                                
                                <a href="{{ route('tasks.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul, 'id_tugas' => $task->id_tugas]) }}" 
                                    class="bg-[#d62828] hover:bg-red-700 text-white text-xs font-bold py-2.5 px-5 rounded-xl flex items-center gap-2 transition duration-200 shadow-sm w-full sm:w-auto justify-center">
                                    <span>Buka Tugas</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div> </div> @empty
                        <div class="text-center py-12 flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-[#FFDBDB] rounded-full flex items-center justify-center text-[#d62828] mb-4 shadow-sm">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                    <rect x="8" y="2" width="8" height="4" rx="1" ry="1" />
                                    <path d="m9 13 2 2 4-4" />
                                </svg>
                            </div>
                            <p class="text-sm font-bold text-[#222222]">Hore! Tidak ada tugas di modul ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="lg:col-span-4">
            <div class="bg-white border border-gray-100 rounded-[32px] p-6 shadow-sm sticky top-6">
                <h3 class="text-sm font-bold text-[#222222] mb-4">Daftar Modul</h3>
                
                <div class="space-y-2">
                    @foreach($subject->modul as $index => $modul)
                        @php
                            $isActive = $modul->id_modul === $currentModul->id_modul;
                        @endphp
                        
                        <a href="{{ route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $modul->id_modul]) }}" 
                        class="w-full flex items-center justify-between p-3.5 rounded-xl text-sm font-bold transition text-left
                                {{ $modul->id_modul === $currentModul->id_modul 
                                    ? 'bg-[#d62828] text-white shadow-md' 
                                    : 'bg-white hover:bg-gray-50 text-[#222222] border border-gray-50' }}">
                            <span>Modul {{ $index + 1 }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>
@endsection