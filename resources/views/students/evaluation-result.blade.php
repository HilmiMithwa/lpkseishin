@extends('layouts.student')

@section('title', 'Hasil Evaluasi - LPK Seishin')

@php
    // Prioritas: 1) dari controller langsung, 2) dari flash session, 3) fallback
    if (!isset($result)) {
        $result = session('evaluation_result');
    }
    
    // Jika tidak ada sama sekali (misal user akses langsung URL)
    if (!$result) {
        $result = (object)[
            'score' => 0,
            'total_questions' => 0,
            'correct' => 0,
            'wrong' => 0,
            'empty' => 0,
            'title' => 'Belum ada evaluasi',
            'module_name' => '-',
            'is_passed' => false
        ];
    }
@endphp

@section('content')
<div class="p-4 sm:p-6 lg:p-10 min-h-full flex flex-col justify-center items-center">
    
    <div class="w-full max-w-3xl">
        <div class="text-center mb-8">
            <h1 class="text-2xl sm:text-3xl lg:text-[32px] font-semibold font-ibm text-[#222222] tracking-tight mb-2">Hasil Evaluasi</h1>
            <p class="text-sm text-[#666666] font-medium">{{ $result->title }} • {{ $result->module_name }}</p>
        </div>

        <div class="bg-white border border-gray-100 rounded-[32px] p-8 lg:p-12 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] text-center relative overflow-hidden">
            
            @if(!isset($result->needs_grading) || !$result->needs_grading)
                <!-- Dekorasi Latar -->
                <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b {{ $result->is_passed ? 'from-green-50 to-transparent' : 'from-red-50 to-transparent' }} opacity-50 pointer-events-none"></div>
                
                <!-- Lingkaran Skor -->
                <div class="relative w-40 h-40 mx-auto mb-8 flex items-center justify-center">
                    <svg class="absolute inset-0 w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                        <!-- Background Circle -->
                        <path class="text-gray-100" stroke-width="3" stroke="currentColor" fill="none"
                            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        <!-- Progress Circle -->
                        <path class="{{ $result->is_passed ? 'text-[#00C853]' : 'text-[#d62828]' }}" stroke-dasharray="{{ $result->score }}, 100" stroke-linecap="round" stroke-width="3" stroke="currentColor" fill="none"
                            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-5xl font-black {{ $result->is_passed ? 'text-[#00C853]' : 'text-[#d62828]' }} tracking-tighter">{{ $result->score }}</span>
                    </div>
                </div>

                <!-- Pesan Kelulusan -->
                <div class="mb-10">
                    @if($result->is_passed)
                        <h2 class="text-2xl font-black text-[#222222] mb-2 tracking-tight">Luar Biasa! 🎉</h2>
                        <p class="text-sm font-medium text-[#666666]">Kerja bagus, kamu berhasil menguasai materi ini dengan sangat baik. Pertahankan terus semangat belajarmu!</p>
                    @else
                        <h2 class="text-2xl font-black text-[#222222] mb-2 tracking-tight">Jangan Menyerah! 💪</h2>
                        <p class="text-sm font-medium text-[#666666]">Skor kamu masih di bawah target. Ayo pelajari kembali materinya dan coba lagi nanti!</p>
                    @endif
                </div>

                <!-- Statistik Detail -->
                <div class="grid grid-cols-3 gap-4 mb-10 max-w-lg mx-auto">
                    <div class="bg-gray-50 border border-gray-100 rounded-2xl py-4 px-2 flex flex-col items-center shadow-sm">
                        <span class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center mb-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </span>
                        <span class="text-2xl font-black text-[#222222]">{{ $result->correct }}</span>
                        <span class="text-[10px] font-bold text-[#666666] uppercase tracking-widest mt-1">Benar</span>
                    </div>
                    <div class="bg-gray-50 border border-gray-100 rounded-2xl py-4 px-2 flex flex-col items-center shadow-sm">
                        <span class="w-8 h-8 rounded-full bg-red-100 text-[#d62828] flex items-center justify-center mb-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </span>
                        <span class="text-2xl font-black text-[#222222]">{{ $result->wrong }}</span>
                        <span class="text-[10px] font-bold text-[#666666] uppercase tracking-widest mt-1">Salah</span>
                    </div>
                    <div class="bg-gray-50 border border-gray-100 rounded-2xl py-4 px-2 flex flex-col items-center shadow-sm">
                        <span class="w-8 h-8 rounded-full bg-gray-200 text-gray-500 flex items-center justify-center mb-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"></path></svg>
                        </span>
                        <span class="text-2xl font-black text-[#222222]">{{ $result->empty }}</span>
                        <span class="text-[10px] font-bold text-[#666666] uppercase tracking-widest mt-1">Kosong</span>
                    </div>
                </div>
            @else
                <!-- Icon Menunggu (Simpler) -->
                <div class="relative w-28 h-28 mx-auto mb-8 flex items-center justify-center">
                    <div class="w-20 h-20 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center border-4 border-blue-100">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Pesan Menunggu -->
                <div class="mb-10 max-w-md mx-auto">
                    <h2 class="text-2xl font-black text-[#222222] mb-3 tracking-tight">Menunggu Penilaian Sensei</h2>
                    <p class="text-sm font-medium text-[#666666] leading-relaxed">Ujian telah disubmit. Jawaban esai Anda sedang dalam proses pemeriksaan manual oleh Sensei. Harap tunggu.</p>
                </div>
            @endif

            <!-- Tombol Aksi -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('students.dashboard') }}" class="bg-white border border-gray-200 text-[#444444] hover:bg-gray-50 hover:border-gray-300 font-bold py-3.5 px-8 rounded-xl text-sm transition shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Kembali ke Beranda
                </a>
                <a href="{{ route('modules.show', ['id_mapel' => $result->id_mapel ?? 0, 'id_modul' => $result->id_modul ?? 0]) }}" class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-3.5 px-8 rounded-xl text-sm transition shadow-sm flex items-center justify-center gap-2">
                    Kembali ke Modul
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
