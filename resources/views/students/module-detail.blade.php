@extends('layouts.student')

@section('title', ($currentModul->nama_modul ?? 'Detail Modul') . ' - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10">
    
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('subjects.show', $subject->id_mapel) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight text-left">
                {{ $currentModul->nama_modul }}
            </h1>
        </div>
        <nav class="flex flex-wrap items-center gap-2 text-sm font-medium text-[#666666] text-left">
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
                
                <div class="space-y-4">
                    <h3 class="text-base sm:text-lg font-bold font-ibm text-[#222222]">Bahan Ajar</h3>
                    <div class="space-y-3">
                    @forelse($currentModul->materials ?? [] as $material)
                        <div class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-xl shadow-sm gap-4 transition hover:border-red-200 hover:shadow-md">
                            <div class="flex items-center gap-3 min-w-0">
                                
                                @if(($material->is_complete ?? $material->is_completed ?? 0) == 1)
                                    <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center text-[#30CD30] flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-500 flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </div>
                                @endif
                                
                                <div class="min-w-0 text-left">
                                    <p class="text-sm font-bold font-karla text-[#222222] truncate">
                                        {{ $material->nama_bahan_ajar ?? $material->title ?? '[Data: bahan_ajar.nama_bahan_ajar]' }}
                                    </p>
                                    <p class="text-[11px] font-karla text-[#666666] mt-0.5 capitalize truncate">
                                        {{ $material->type ?? 'Teori' }}
                                    </p>
                                </div>
                            </div>
                            
                            <a href="{{ route('materials.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul, 'id_materi' => $material->id_bahan_ajar ?? $material->id ?? $loop->iteration]) }}" 
                            class="bg-[#d62828] hover:bg-red-700 text-white text-xs font-bold font-karla px-3 py-1.5 rounded-lg flex items-center gap-1.5 transition shadow-sm flex-shrink-0">
                                Lihat 
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </a>
                        </div>
                    @empty
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-6 flex items-center justify-center text-center">
                            <p class="text-sm font-bold font-karla text-gray-500">Belum ada materi di sini!!</p>
                        </div>
                    @endforelse
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-base sm:text-lg font-bold font-ibm text-[#222222]">Evaluasi</h3>
                    <div class="space-y-3">
                        @forelse($currentModul->evaluasis ?? [] as $evaluation)
                            <div class="flex items-center justify-between p-4 bg-white border border-gray-100 rounded-xl shadow-sm gap-4 transition hover:border-red-200 hover:shadow-md">
                                <div class="flex items-center gap-3 min-w-0">
                                    @if(($evaluation->is_complete ?? false))
                                        <div class="w-10 h-10 bg-green-50 rounded-lg flex items-center justify-center text-[#30CD30] flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="w-10 h-10 bg-red-50 rounded-lg flex items-center justify-center text-[#d62828] flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <h4 class="text-sm font-bold font-ibm text-gray-900 truncate" title="{{ $evaluation->judul }}">{{ $evaluation->judul }}</h4>
                                        <p class="text-[11px] font-karla text-gray-500 flex items-center gap-2">
                                            <span>{{ $evaluation->tipe ?? 'Ujian' }}</span>
                                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                            <span>{{ $evaluation->durasi_menit }} Menit</span>
                                        </p>
                                    </div>
                                </div>
                                @if(($evaluation->is_complete ?? false))
                                    <span class="bg-green-100 text-green-700 text-xs font-bold font-karla px-3 py-1.5 rounded-lg flex items-center gap-1.5 shadow-sm flex-shrink-0">
                                        Selesai
                                    </span>
                                @else
                                    <a href="{{ route('evaluations.start', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul, 'id' => $evaluation->id_evaluasi]) }}" class="bg-[#d62828] hover:bg-red-700 text-white text-xs font-bold font-karla px-3 py-1.5 rounded-lg flex items-center gap-1.5 transition shadow-sm flex-shrink-0">
                                        Mulai <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                @endif
                            </div>
                        @empty
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-6 flex items-center justify-center text-center">
                                <p class="text-sm font-bold font-karla text-gray-500">Belum ada evaluasi di sini!!</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            <div class="space-y-4">
                <h3 class="text-base sm:text-lg font-bold font-ibm text-[#222222]">Tugas</h3>
                <div class="space-y-3">
                    @forelse($currentModul->tasks ?? [] as $task)
                        @php
                            $displayStatus = 'Belum Selesai';
                            if (!empty($task->submission_status)) {
                                $displayStatus = $task->submission_status === 'terlambat' ? 'Terkirim Terlambat' : 'Selesai';
                            }
                        @endphp
                        
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-5 bg-white border border-gray-100 rounded-xl shadow-sm gap-4 transition hover:border-red-200 hover:shadow-md">
                            
                            <div class="flex items-center gap-4 min-w-0">
                                <div class="w-12 h-12 bg-[#FFDBDB] rounded-lg flex items-center justify-center text-[#d62828] flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h4"></path>
                                    </svg>
                                </div>
                                
                                <div class="space-y-1 min-w-0 text-left">
                                    <h4 class="text-sm font-bold font-ibm text-gray-900 truncate" title="{{ $task->judul_tugas }}">
                                        {{ $task->judul_tugas }}
                                    </h4>
                                    <span class="inline-block bg-[#FFF3CD] text-[#856404] text-[10px] font-bold px-2.5 py-0.5 rounded-lg mt-1">
                                        Tenggat: {{ $task->waktu_pengumpulan ? \Carbon\Carbon::parse($task->waktu_pengumpulan)->format('d M Y, H:i') : 'Tidak ada tenggat' }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col items-end justify-center w-full sm:w-auto flex-shrink-0 gap-2 text-right">
                                <span class="text-[10px] font-bold {{ $displayStatus == 'Selesai' ? 'text-green-600' : 'text-gray-500' }} tracking-wide uppercase">
                                    {{ $displayStatus }}
                                </span>
                                
                                <a href="{{ route('tasks.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul, 'id_tugas' => $task->id_tugas]) }}" 
                                    class="bg-[#d62828] hover:bg-red-700 text-white text-xs font-bold font-karla py-2 px-4 rounded-lg flex items-center justify-center gap-1.5 transition shadow-sm w-full sm:w-auto">
                                    <span>Buka Tugas</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M5 12h14M12 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-8 flex flex-col items-center justify-center text-center">
                            <p class="text-sm font-bold font-karla text-gray-500">Belum ada tugas di sini!!</p>
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
                        
                        @if($modul->is_locked)
                            <div class="w-full flex items-center justify-between p-3.5 rounded-xl text-sm font-bold text-left bg-gray-50/50 border border-gray-100 opacity-60 cursor-not-allowed grayscale-[50%]">
                                <span class="text-gray-500">Modul {{ $index + 1 }}</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                        @else
                            <a href="{{ route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $modul->id_modul]) }}" 
                            class="w-full flex items-center justify-between p-3.5 rounded-xl text-sm font-bold transition text-left
                                    {{ $isActive 
                                        ? 'bg-[#d62828] text-white shadow-md' 
                                        : 'bg-white hover:border-red-200 hover:shadow-sm text-[#222222] border border-gray-50' }}">
                                <span>Modul {{ $index + 1 }}</span>
                                @if($isActive)
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                @endif
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

    </div>

</div>
@endsection