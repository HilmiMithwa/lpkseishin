@extends('layouts.student')

@section('title', 'Beranda Siswa - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10">
    
    <div class="mb-8">
        <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Beranda</h1>
        <p class="text-sm text-[#666666] font-medium mt-2">Pemantauan Belajar</p>
    </div>

    <!-- Banner -->
    <div class="banner-red rounded-3xl lg:rounded-[32px] p-6 sm:p-8 lg:p-10 mb-8 flex flex-col lg:flex-row items-start lg:items-center justify-between relative gap-6">
        <div class="relative z-10 w-full lg:w-2/3">
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-ibm text-white leading-tight mb-4 tracking-tight">Selamat Datang,<br>{{ Auth::user()->name }}</h2>
            <p class="text-white/90 text-sm sm:text-base font-medium max-w-lg leading-relaxed">Mimpi besar dimulai dari konsistensi kecil. Mari pelajari sesuatu yang baru hari ini!</p>
        </div>
        <div class="relative z-10 bg-white rounded-3xl p-6 sm:p-8 text-center shadow-2xl w-full sm:w-72 flex-shrink-0 lg:mr-4">
            <h3 class="text-4xl sm:text-5xl font-bold font-ibm text-[#222222] tracking-widest mb-2 leading-tight">
                @isset($dailyWord->kanji)
                    {{ $dailyWord->kanji }}
                @else
                    夢語り
                @endisset
            </h3>
            
            <p class="text-sm sm:text-base font-bold font-ibm text-[#222222] mb-1">
                @isset($dailyWord->romaji)
                    {{ $dailyWord->romaji }}
                @else
                    Yumegatari
                @endisset
            </p>

            <div class="text-[10px] sm:text-xs text-[#666666] font-medium leading-relaxed">
                @isset($dailyWord->meaning_en)
                    <span>{{ $dailyWord->meaning_en }}</span>
                @else
                    <span>Speaking of Dreams</span>
                @endisset
                
                @isset($dailyWord->meaning_id)
                    <span class="mx-1">•</span><span>{{ $dailyWord->meaning_id }}</span>
                @else
                    <span class="mx-1">•</span><span>Cerita Mimpi</span>
                @endisset
            </div>
        </div>
    </div>

    <!-- Summary Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-10">
        <!-- Main Course Card -->
        <div class="col-span-1 rounded-3xl overflow-hidden relative group min-h-[280px]">
            <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover absolute inset-0 group-hover:scale-105 transition duration-700">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>
            <div class="relative z-10 p-5 sm:p-6 flex flex-col h-full justify-between">
                <div>
                    <span class="bg-[#d62828] text-white text-[10px] font-bold px-3 py-1.5 rounded-md uppercase tracking-wide shadow-sm">Main Course</span>
                </div>
                <div>
                    <h3 class="text-lg sm:text-xl font-bold font-ibm text-white leading-snug mb-5">{{ $activeBatch->nama_pelatihan ?? 'Batch 5 - Pelatihan LPK Seishin' }}</h3>
                    <button class="w-full bg-[#d62828] hover:bg-red-700 text-white font-bold py-3 sm:py-3.5 rounded-xl text-sm transition shadow-md flex items-center justify-center gap-2">
                        Lanjutkan Pelajaran
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Summary Stats -->
        <div class="col-span-1 lg:col-span-2">
            <div class="flex items-center gap-3 mb-6">
                <div class="bg-white shadow-[0_2px_12px_-4px_rgba(0,0,0,0.08)] rounded-xl w-11 h-11 flex items-center justify-center border border-gray-50/50">
                    <span class="text-[#222222] text-[13px] font-black leading-none">概要</span>
                </div>
                <h3 class="font-bold font-karla text-[#222222] text-lg tracking-tight">Ringkasan</h3>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-5">
                
                <!-- Stat Card 1 -->
                <div class="bg-white border border-gray-100/80 rounded-3xl p-4 sm:p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)] transition flex flex-col justify-center">
                    <div class="flex items-center gap-3 sm:gap-4 mb-3 sm:mb-5">
                        <div class="w-8 sm:w-10 h-8 sm:h-10 rounded-full bg-red-50 text-[#d62828] flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-xl sm:text-[28px] font-bold font-ibm text-[#222222] tracking-tight truncate leading-none mt-1">
                            {{ $completedSubjects ?? 0 }}/{{ $totalSubjects ?? 0 }} <span class="text-xs sm:text-sm text-[#666666] font-karla font-semibold ml-1">Kelas</span>
                        </h4>
                    </div>
                    <p class="text-[10px] sm:text-xs font-bold text-[#666666]">Program Saat Ini</p>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white border border-gray-100/80 rounded-3xl p-4 sm:p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)] transition flex flex-col justify-center">
                    <div class="flex items-center gap-3 sm:gap-4 mb-3 sm:mb-5">
                        <div class="w-8 sm:w-10 h-8 sm:h-10 rounded-full bg-red-50 text-[#d62828] flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <h4 class="text-xl sm:text-[28px] font-bold font-ibm text-[#222222] tracking-tight truncate leading-none mt-1">
                            @isset($averageScore)
                                {{ $averageScore }}
                            @else
                                85.5
                            @endif
                        </h4>
                    </div>
                    <p class="text-[10px] sm:text-xs font-bold text-[#666666]">Skor Rata-rata</p>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white border border-gray-100/80 rounded-3xl p-4 sm:p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)] transition flex flex-col justify-center">
                    <div class="flex items-center gap-3 sm:gap-4 mb-3 sm:mb-5">
                        <div class="w-8 sm:w-10 h-8 sm:h-10 rounded-full bg-red-50 text-[#d62828] flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                        </div>
                        <h4 class="text-xl sm:text-[28px] font-bold font-ibm text-[#222222] tracking-tight truncate leading-none mt-1">
                            @isset($completedTasksCount)
                                {{ $completedTasksCount }}
                            @else
                                23
                            @endif
                        </h4>
                    </div>
                    <p class="text-[10px] sm:text-xs font-bold text-[#666666]">Penyelesaian Tugas</p>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white border border-gray-100/80 rounded-3xl p-4 sm:p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)] transition flex flex-col justify-center">
                    <div class="flex items-center gap-3 sm:gap-4 mb-3 sm:mb-5">
                        <div class="w-8 sm:w-10 h-8 sm:h-10 rounded-full bg-red-50 text-[#d62828] flex items-center justify-center flex-shrink-0 font-bold text-sm sm:text-base font-ibm">あ</div>
                        <h4 class="text-xl sm:text-[28px] font-bold font-ibm text-[#222222] tracking-tight truncate leading-none mt-1">
                            @isset($vocabularyCount)
                                {{ $vocabularyCount }}
                            @else
                                456
                            @endif
                        </h4>
                    </div>
                    <p class="text-[10px] sm:text-xs font-bold text-[#666666]">Penguasaan Kosakata</p>
                </div>

                <!-- Stat Card 5 -->
                <div class="bg-white border border-gray-100/80 rounded-3xl p-4 sm:p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)] transition flex flex-col justify-center">
                    <div class="flex items-center gap-3 sm:gap-4 mb-3 sm:mb-5">
                        <div class="w-8 sm:w-10 h-8 sm:h-10 rounded-full bg-red-50 text-[#d62828] flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <h4 class="text-xl sm:text-[28px] font-bold font-ibm text-[#222222] tracking-tight truncate leading-none mt-1">
                            @isset($upcomingDeadlinesCount)
                                {{ $upcomingDeadlinesCount }} <span class="text-xs sm:text-sm text-[#666666] font-karla font-semibold ml-1">Tugas</span>
                            @else
                                4 <span class="text-xs sm:text-sm text-[#666666] font-karla font-semibold ml-1">Tugas</span>
                            @endif
                        </h4>
                    </div>
                    <p class="text-[10px] sm:text-xs font-bold text-[#666666]">Batas Waktu Mendatang</p>
                </div>

                <!-- Stat Card 6 -->
                <div class="bg-white border border-gray-100/80 rounded-3xl p-4 sm:p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] hover:shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)] transition flex flex-col justify-center">
                    <div class="flex items-center gap-3 sm:gap-4 mb-3 sm:mb-5">
                        <div class="w-8 sm:w-10 h-8 sm:h-10 rounded-full bg-red-50 text-[#d62828] flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 sm:w-5 h-4 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="text-xl sm:text-[28px] font-bold font-ibm text-[#222222] tracking-tight truncate leading-none mt-1">
                            @isset($learningHours)
                                {{ $learningHours }} <span class="text-xs sm:text-sm text-[#666666] font-karla font-semibold ml-1">Jam</span>
                            @else
                                56 <span class="text-xs sm:text-sm text-[#666666] font-karla font-semibold ml-1">Jam</span>
                            @endif
                        </h4>
                    </div>
                    <p class="text-[10px] sm:text-xs font-bold text-[#666666]">Total Jam Belajar</p>
                </div>

            </div>
        </div>
    </div>

    <!-- Current Lesson Section -->
    <div>
        <div class="flex items-center gap-3 mb-6">
            <div class="bg-white shadow-[0_2px_12px_-4px_rgba(0,0,0,0.08)] rounded-xl w-11 h-11 flex items-center justify-center border border-gray-50/50">
                <span class="text-[#222222] text-[13px] font-black leading-none">授業</span>
            </div>
            <h3 class="font-bold font-karla text-[#222222] text-lg tracking-tight">Pelajaran Saat Ini</h3>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @forelse($subjects as $subject)
            <div class="bg-white border border-gray-100/80 rounded-[28px] p-5 sm:p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)] relative flex flex-col justify-between h-full hover:shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)] transition">
                <span class="absolute top-5 right-5 bg-yellow-400 text-white text-[9px] font-bold px-2.5 py-1 rounded-md tracking-wider">Progress</span>
                
                <div>
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-14 h-14 rounded-2xl border border-gray-100 flex items-center justify-center text-[#d62828] font-bold text-lg flex-shrink-0 bg-gray-50/50">
                            あa
                        </div>
                        
                        <div class="w-14 h-14 flex flex-col items-center justify-center border border-gray-100 rounded-2xl flex-shrink-0 bg-gray-50/50">
                            <p class="text-xl font-bold font-ibm text-[#222222] leading-none text-center">
                                @isset($subject->modul_count) 
                                    {{ $subject->modul_count }} 
                                @else 
                                    7 
                                @endif
                            </p>
                            <p class="text-[8px] text-[#666666] font-bold mt-1 uppercase text-center tracking-wide">Modul</p>
                        </div>
                    </div>
                    <h4 class="text-base font-bold font-ibm text-[#222222] mb-2 leading-snug line-clamp-2">{{ $subject->nama_mapel }}</h4>
                    <p class="text-[11px] text-[#666666] leading-relaxed mb-6 line-clamp-3">
                        <!-- Use a generic description if none exists in backend to match design aesthetic -->
                        Program pembelajaran dengan fokus praktik intensif. Mencakup unit kompetensi persiapan hingga ujian akhir evaluasi materi ini.
                    </p>
                </div>

                <div class="flex justify-end mt-auto">
                    <a href="{{ route('subjects.show', $subject->id_mapel) }}" class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl text-[13px] transition flex items-center justify-center gap-2 shadow-sm">
                        Buka Kelas
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-10 bg-gray-50 rounded-[28px] border border-dashed border-gray-200">
                <p class="text-[#666666] font-medium text-sm">Belum ada mata pelajaran yang tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection