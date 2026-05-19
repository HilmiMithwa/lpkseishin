<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Detail - LPK Seishin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Gradasi dari merah utama ke merah gelap di sisi kanan */
        .banner-red {
            background: linear-gradient(90deg, #d62828 0%, #d62828 50%, #8b1a1a 100%);
            position: relative;
            overflow: hidden;
        }
        
        /* Mempercantik Scrollbar pada konten utama */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 20px; }
    </style>
</head>
<body class="bg-[#FFF9F4] text-[#222222] h-screen flex overflow-hidden">

    <button id="mobile-menu-close" class="fixed top-4 right-4 z-40 hidden lg:hidden p-2 bg-gray-800 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>

    <aside id="sidebar" class="fixed lg:static left-0 top-0 w-64 h-screen lg:h-auto bg-[#FFF9F4] flex flex-col flex-none z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-lg lg:shadow-none">
        <div class="p-6">
            <x-application-logo class="h-14 w-auto" />
        </div>

        <div class="px-4 mt-2 flex-1">
            <p class="text-xs font-bold text-[#444444] mb-3 px-2 tracking-wider">OVERVIEW</p>
            <nav class="space-y-1">
                <a href="#" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 bg-[#FFDBDB] text-[#DB2A2A] px-4 py-3 rounded-xl font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Enrolled
                </a>
                <a href="#" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    My Task
                </a>
                <a href="#" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                    Vocabulary Mastery
                </a>
            </nav>
        </div>

        <div class="p-4">
            <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm mb-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f3f4f6&color=ef4444" class="w-10 h-10 rounded-full">
                <div class="overflow-hidden">
                    <h4 class="font-bold text-[13px] text-[#222222] truncate">{{ Auth::user()->name }}</h4>
                    <p class="text-[10px] text-[#444444] truncate">{{ Auth::user()->level ?? '[Data: user.level]'}}</p>
                    <p class="text-[10px] text-[#444444] truncate flex items-center gap-1">
                        <span class="text-[#DB2A2A] font-bold text-[11px]">@</span> {{ Auth::user()->email }}
                    </p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-2 text-[#DB2A2A] bg-white border border-gray-200 hover:bg-red-50 px-5 py-2.5 rounded-xl font-bold text-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        
    <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center px-4 lg:px-8 py-4 lg:py-6 bg-transparent gap-4">
        
        <div class="flex items-center gap-4"> <button id="mobile-menu-btn" class="lg:hidden p-2 bg-[#DB2A2A] text-white rounded-xl shadow-md hover:bg-red-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <div class="pt-1">
                <h2 class="text-base lg:text-lg font-bold text-[#222222] flex items-center gap-1">
                    こんにちわ, 
                    <span class="hidden sm:inline">{{ Auth::user()->name }}! 👋</span>
                    <span class="sm:hidden">{{ substr(Auth::user()->name, 0, 10) }}! 👋</span>
                </h2>
                <p id="realtime-clock" class="text-xs text-[#444444] font-medium mt-0.5">Memuat waktu...</p>
            </div>
        </div>

        <div class="flex items-center gap-2 lg:gap-6 w-full lg:w-auto justify-end">
            </div>
    </header>

        <main class="flex-1 bg-white rounded-t-[20px] lg:rounded-[40px] mr-0 lg:mr-8 mb-0 lg:mb-8 overflow-y-auto shadow-sm custom-scrollbar">
            <div class="p-4 sm:p-6 lg:p-10">
                
                <nav class="text-xs font-bold text-[#444444] mb-6 uppercase tracking-widest">
                    ENROLLED <span class="mx-2">></span> 
                    <span class="text-[#222222]">
                        {{ $subject->nama_mapel ?? '[Data: mapel.nama_mapel]' }}
                    </span>
                </nav>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <div class="lg:col-span-8 space-y-8">
                        
                       <div class="grid grid-cols-1 xl:grid-cols-5 gap-6 mb-8">
    
                    <div class="banner-red xl:col-span-2 rounded-[32px] p-6 sm:p-8 flex flex-col items-center xl:items-start justify-center gap-6 relative overflow-hidden">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-[#DB2A2A] font-black text-2xl flex-shrink-0 z-10">
                            あa
                        </div>
                        <div class="z-10 text-center xl:text-left">
                            <h1 class="text-2xl sm:text-3xl font-black text-white mb-2">{{ $subject->nama_mapel }}</h1>
                            <p class="text-white/80 text-xs font-medium leading-relaxed">
                                Program lanjutan dengan fokus praktik persiapan ujian level N4.
                            </p>
                        </div>
                    </div>

                    <div class="xl:col-span-3 bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                        
                        <h3 class="text-lg font-bold text-[#222222] mb-6">Targets and Qualifications</h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            
                            <div class="bg-white p-4 rounded-[24px] border border-gray-50 shadow-sm flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#DB2A2A] flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <circle cx="12" cy="12" r="6"></circle>
                                        <circle cx="12" cy="12" r="2"></circle>
                                        <path d="M14.5 9.5 21 3M21 3h-4M21 3v4"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] text-[#444444] font-bold uppercase tracking-wider truncate">Certification Target</p>
                                    <p class="font-bold text-[#222222] truncate">{{ $subject->target ?? '[Data: mapel.target]' }}</p>
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded-[24px] border border-gray-50 shadow-sm flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#DB2A2A] flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12 6 12 12 16 14"></polyline>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] text-[#444444] font-bold uppercase tracking-wider truncate">Total Duration</p>
                                    <p class="font-bold text-[#222222] truncate">{{ $subject->jp ?? '[Data: mapel.jp]' }} JP</p>
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded-[24px] border border-gray-50 shadow-sm flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#DB2A2A] flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M12 21H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4.5"></path>
                                        <path d="M16 3v4M8 3v4M3 11h18"></path>
                                        <circle cx="18" cy="18" r="4"></circle>
                                        <path d="M18 16v2h2"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] text-[#444444] font-bold uppercase tracking-wider truncate">Schedule</p>
                                    <p class="font-bold text-[#222222] truncate">{{ $subject->jadwal ?? '[Data: mapel.jadwal]' }}</p>
                                </div>
                            </div>

                            <div class="bg-white p-4 rounded-[24px] border border-gray-50 shadow-sm flex items-center gap-4">
                                <div class="w-12 h-12 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#DB2A2A] flex-shrink-0">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                        <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                        <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                                        <path d="M12 15v3m-3 3h6"></path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] text-[#444444] font-bold uppercase tracking-wider">Pass Requirement</p>
                                    <p class="font-bold text-[#222222] truncate">
                                        Min. Skor {{ $subject->min_score ?? '[Data: min_score]' }}
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                        <div class="space-y-4">
                            <h3 class="text-xl font-black text-[#222222] mb-6">Syllabus and Modules</h3>
                            
                            <div class="space-y-4">
                                @forelse($subject->modul as $modul)
                                    @php
                                        // Logika otomatis mendeteksi tipe modul berdasarkan kata kunci di namanya
                                        $namaModulKecil = strtolower($modul->nama_modul);
                                        
                                        if (str_contains($namaModulKecil, 'intro') || str_contains($namaModulKecil, 'kanji')) {
                                            $tipeModul = 'intro';
                                        } elseif (str_contains($namaModulKecil, 'practice') || str_contains($namaModulKecil, 'simulation') || str_contains($namaModulKecil, 'test')) {
                                            $tipeModul = 'test';
                                        } else {
                                            $tipeModul = 'materi'; // Default menggunakan icon buku
                                        }
                                    @endphp

                                    <a href="{{ route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $modul->id_modul]) }}" 
                                    class="block bg-white border border-gray-100 p-5 rounded-[24px] shadow-sm hover:border-red-200 hover:shadow-md transition duration-200 cursor-pointer">                                        
                                        <div class="flex gap-4 items-start mb-4">
                                            
                                            <div class="w-12 h-12 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#DB2A2A] flex-shrink-0">
                                                @if($tipeModul === 'intro')
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                                        <path d="m5 8 6 6M4 14h14M2 4h12M7 2v2M19 11l3.5 7.5M19 11l-3.5 7.5M16.5 16h5M11 5c0 3.5-2.5 7.5-6 9" />
                                                    </svg>
                                                @elseif($tipeModul === 'test')
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                                        <rect x="3" y="4" width="11" height="16" rx="2" />
                                                        <path d="M7 8h3M7 12h3M7 16h2" />
                                                        <path d="M18 4l1 1-5 11h-2v-2l5-10z" />
                                                    </svg>
                                                @else
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            
                                            <div class="min-w-0 flex-1">
                                                <h4 class="text-sm font-bold text-[#222222] leading-snug">
                                                    {{ $modul->nama_modul }}
                                                </h4>
                                                <p class="text-[11px] text-[#444444] mt-1 font-semibold tracking-wide">
                                                    {{ $modul->kode_modul ?? '[DATA: MODUL.KODE]' }} | 
                                                    Teori ({{ $modul->jp_teori ?? '[MODUL.JP_TEORI]' }} JP) & Praktik ({{ $modul->jp_praktik ?? '[MODUL.JP_PRAKTIK]' }} JP)
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3 text-[11px] font-bold">
                                            <span class="text-[#444444] font-semibold">Progress</span>
                                            <div class="flex-1 bg-[#FFDBDB] h-2 rounded-full overflow-hidden">
                                                <div class="bg-[#DB2A2A] h-2 rounded-full transition-all" 
                                                    style="width: {{ $modul->progress ?? '50' }}%">
                                                </div>
                                            </div>
                                            <span class="text-[#222222] font-black">
                                                @isset($modul->progress)
                                                    {{ $modul->progress }}%
                                                @else
                                                    <span class="text-[10px] text-[#DB2A2A] font-bold">[Data: %]</span>
                                                @endisset
                                            </span>
                                        </div>

                                    </a>
                                @empty
                                    <p class="text-[#444444] italic text-sm text-center py-10">Belum ada modul untuk kelas ini.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-4 space-y-8">
                        
                    <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                        <h3 class="text-lg font-bold text-[#222222] mb-6">Overall Class Progress</h3>
                        
                        <div class="flex items-center gap-6">
                            <div class="relative w-28 h-28 flex-shrink-0 flex items-center justify-center">
                                <svg class="w-full h-full -rotate-90">
                                    <circle cx="56" cy="56" r="50" stroke="#FFDBDB" stroke-width="10" fill="transparent"></circle>
                                    <circle cx="56" cy="56" r="50" stroke="#DB2A2A" stroke-width="10" fill="transparent" 
                                        stroke-dasharray="314.15" 
                                        stroke-dashoffset="{{ isset($overallProgress) ? (314.15 - (314.15 * $overallProgress / 100)) : 157 }}">
                                    </circle>
                                </svg>

                                <span class="absolute text-2xl font-black text-[#DB2A2A]">
                                    @isset($overallProgress)
                                        {{ $overallProgress }}%
                                    @else
                                        <span class="text-[10px] text-[#444444] font-medium">[Data: overallProgress]</span>
                                    @endisset
                                </span>
                            </div>

                            <div class="space-y-3">
                                <div class="leading-tight">
                                    <p class="text-[11px] font-semibold text-[#444444]">Completed:</p>
                                    <p class="text-sm font-bold text-[#222222]">
                                        {{ $completedModulesCount ?? '[Data: completedModulesCount]' }} / {{ $subject->modul_count ?? '[Data: modul_count]' }} Modules
                                    </p>
                                </div>
                                <div class="leading-tight">
                                    <p class="text-[11px] font-semibold text-[#444444]">Remaining:</p>
                                    <p class="text-sm font-bold text-[#222222]">
                                        {{ $remainingModulesCount ?? '[Data: remainingModulesCount]' }} Modules
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-[32px] p-6 text-center shadow-sm">
                        <h3 class="text-lg font-bold text-[#222222] mb-6 text-left">Mentor Sensei</h3>
                        
                        <div class="bg-[#FFDBDB] rounded-2xl p-6 mb-4 flex items-center justify-center">
                            <svg class="w-24 h-24 text-[#DB2A2A]" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M3.5 3.5h16.5a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-11" />
                                <path d="M13.5 9h4" />
                                
                                <circle cx="5.5" cy="7.5" r="2.5" />
                                <path d="M3.0 21v-9h4v9" />
                                <path d="M7.5 13h4.5" />
                                <path d="M3.5 16h3.0" />
                            </svg>
                        </div>

                        <h4 class="font-bold text-[#222222] text-base sm:text-lg leading-snug">
                            {{ $subject->guru->name ?? '[Data: guru.name]' }}
                        </h4>
                        
                        <p class="text-xs text-[#444444] font-medium mt-0.5 mb-5">
                            @isset($subject->guru->level)
                                Level {{ $subject->guru->level }}
                            @else
                                Level [DATA: GURU.LEVEL]
                            @endisset
                        </p>

                        <div class="flex gap-2">
                            <a href="{{ isset($subject->guru->no_wa) ? 'https://wa.me/' . $subject->guru->no_wa : '#[Data: guru.no_wa]' }}" 
                            target="_blank" 
                            class="flex-1 bg-[#DB2A2A] hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl text-xs transition flex items-center justify-center gap-2 shadow-sm">
                                <span>Contact Sensei</span>
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.588-5.946 0-6.556 5.332-11.888 11.888-11.888 3.176 0 6.161 1.237 8.404 3.48s3.481 5.229 3.481 8.405c0 6.555-5.332 11.89-11.888 11.89-2.014 0-3.991-.511-5.741-1.482l-6.243 1.636zm6.323-3.61c1.558.924 3.125 1.411 4.757 1.411 5.424 0 9.841-4.415 9.841-9.84 0-5.424-4.417-9.84-9.841-9.84-5.424 0-9.84 4.416-9.84 9.84 0 2.001.602 3.864 1.741 5.437l-1.011 3.693 3.791-1.127zm10.741-7.07c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.966-.941 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                            </a>

                            <a href="mailto:{{ $subject->guru->email ?? '#[Data: guru.email]' }}" 
                            class="bg-[#FFDBDB] text-[#DB2A2A] p-3 rounded-xl hover:bg-red-100 transition flex items-center justify-center shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                        <h3 class="text-lg font-bold text-[#222222] mb-6 text-left">Announcements</h3>
                        
                        <div class="space-y-0">
                            @forelse($subject->announcements ?? [] as $announcement)
                                <div class="py-3.5 border-b border-gray-100 last:border-0">
                                    <p class="text-xs sm:text-sm font-medium text-[#222222] hover:text-[#DB2A2A] transition cursor-pointer">
                                        {{ $announcement->title }} <span class="text-[#444444] font-normal">({{ $announcement->date_formatted ?? '[Data: date]' }})</span>
                                    </p>
                                </div>
                            @empty
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="py-3.5 border-b border-gray-100 last:border-0">
                                        <p class="text-xs sm:text-sm font-medium text-[#444444]">
                                            [DATA: ANNOUNCEMENT.TITLE] <span class="text-gray-300 font-normal">([Data: date])</span>
                                        </p>
                                    </div>
                                @endfor
                            @endforelse
                        </div>

                        <div class="flex justify-end mt-4">
                            <button class="text-xs font-bold text-[#DB2A2A] hover:underline transition tracking-wide">
                                Load More
                            </button>
                        </div>
                    </div>
                    </div>
                </div>

            </div>
        </main>
    </div>
    <script>
        // Mobile menu toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenuClose = document.getElementById('mobile-menu-close');
        const sidebar = document.getElementById('sidebar');

        mobileMenuBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            mobileMenuClose.classList.remove('hidden');
        });

        mobileMenuClose.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            mobileMenuClose.classList.add('hidden');
        });

        // Close sidebar when clicking on a link
        document.querySelectorAll('#sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                mobileMenuClose.classList.add('hidden');
            });
        });

        function updateClock() {
            const now = new Date();
            
            // Format disesuaikan ke Locale Indonesia (id-ID)
            const optionsDate = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            
            const dateString = now.toLocaleDateString('id-ID', optionsDate);
            
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}.${minutes}.${seconds}`;

            document.getElementById('realtime-clock').innerText = `${dateString} • ${timeString}`;
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>