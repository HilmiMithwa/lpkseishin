<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sensei - LPK Seishin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Karla', sans-serif; }
        
        /* Gradasi dari merah utama ke merah gelap di sisi kanan */
        .banner-red {
            background: linear-gradient(90deg, #d62828 0%, #d62828 50%, #8b1a1a 100%);
            position: relative;
            overflow: hidden;
        }

        /* Peta Jepang menggunakan pseudo-element */
        .banner-red::before {
            content: '';
            position: absolute;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            width: 65%;
            height: 160%;
            background-image: url("<! asset('img/japanMap.svg') >");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: left center;
            opacity: 0.35; /* Mengatur transparansi peta */
            z-index: 0;
            pointer-events: none;
        }

        /* Mempercantik Scrollbar pada konten utama */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 20px; }
    </style>
</head>
<body class="bg-[#FFF9F4] text-gray-800 h-screen flex overflow-hidden">

    {{-- Mobile Menu Button --}}
    {{-- <button id="mobile-menu-btn" class="fixed top-4 left-4 z-50 lg:hidden p-2 bg-red-600 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
    </button> --}}

    {{-- Mobile Menu Close Button --}}
    <button id="mobile-menu-close" class="fixed top-4 right-4 z-40 hidden lg:hidden p-2 bg-gray-800 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>

    <aside id="sidebar" class="fixed lg:static left-0 top-0 w-64 h-screen lg:h-auto bg-[#FFF9F4] flex flex-col flex-none z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-lg lg:shadow-none">
        <div class="p-6">
            <x-application-logo class="h-14 w-auto" />
        </div>

        <div class="px-4 mt-2 flex-1">
            <p class="text-xs font-bold text-gray-400 mb-3 px-2 tracking-wider">OVERVIEW</p>
            <nav class="space-y-1">
                <a href="#" class="flex items-center gap-3 bg-red-100/50 text-red-600 px-4 py-3 rounded-xl font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Mapel & RPS
                </a>
                <a href="#" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Tugas & Penelitian
                </a>
                <a href="#" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                    Daftar Siswa
                </a>
                <a href="#" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                    Profile
                </a>
            </nav>
        </div>

        {{-- User Profile --}}
        <div class="p-4">
            <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm mb-3">
                <img src="https://ui-avatars.com/api/?name=<! urlencode(Auth::user()->name) >&background=f3f4f6&color=ef4444" class="w-10 h-10 rounded-full">
                <div class="overflow-hidden">
                    <h4 class="font-bold text-[13px] text-gray-900 truncate"><! Auth::user()->name ></h4>
                    <p class="text-[10px] text-gray-500 truncate"><! $enrollment->level ?? '[Data: enrollment.level]' ></p>
                    <p class="text-[10px] text-gray-500 truncate flex items-center gap-1">
                        <span class="text-red-500 font-bold text-[11px]">@</span> <! Auth::user()->email ?? '[Data: user.email]' >
                    </p>
                </div>
            </div>
            <form method="POST" action="<! route('logout') >">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 text-red-600 bg-white border border-gray-200 hover:bg-red-50 py-2.5 rounded-xl font-bold text-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
         <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center px-4 lg:px-8 py-4 lg:py-6 bg-transparent gap-4">
        
            <div class="flex items-center gap-4"> 
                <button id="mobile-menu-btn" class="lg:hidden p-2 bg-red-600 text-white rounded-xl shadow-md hover:bg-red-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                {{-- Greetings --}}
                <div class="pt-1">
                    <h2 class="text-base lg:text-lg font-bold text-gray-900 flex items-center gap-1">
                        こんにちわ, 
                        <span class="hidden sm:inline">{{ Auth::user()->name }}! 👋</span>
                        <span class="sm:hidden">{{ substr(Auth::user()->name, 0, 10) }}! 👋</span>
                    </h2>
                    <p id="realtime-clock" class="text-xs text-gray-500 font-medium mt-0.5">Memuat waktu...</p>
                </div>
            </div>

            <div class="flex items-center gap-2 lg:gap-6 w-full lg:w-auto justify-end">
                </div>
        </header>
        <main class="flex-1 bg-white rounded-t-[20px] lg:rounded-[40px] mr-0 lg:mr-8 mb-0 lg:mb-8 overflow-y-auto shadow-sm custom-scrollbar">
            <div class="p-4 sm:p-6 lg:p-10">

                <div class="mb-6">
                    <h1 class="text-xl sm:text-2xl lg:text-[26px] font-black text-gray-900 tracking-tight">Dashboard</h1>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Study Monitoring</p>
                </div>
                <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-2xl lg:rounded-3xl p-4 sm:p-6 lg:p-8 flex flex-col lg:flex-row items-start lg:items-center justify-between relative gap-4">
                    <div class="relative z-10 w-full lg:w-2/3">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight mb-3">Welcome Back,<br><! Auth::user()->name ></h2>
                        <p class="text-white/90 text-xs sm:text-sm font-medium">Big dreams start with small consistency. Let's learn something<br>new today!</p>
                    </div>
                    <div class="relative z-10 bg-white rounded-2xl p-4 sm:p-6 text-center shadow-lg w-full sm:w-64 flex-shrink-0">
                        <h3 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-widest mb-1 leading-tight">
                            @isset($dailyWord->kanji)
                                {{ $dailyWord->kanji }}
                            @else
                                <span class="text-xs text-gray-400 font-medium">[Data: dailyWord.kanji]</span>
                            @endisset
                        </h3>

                        <p class="text-xs sm:text-sm font-bold text-gray-800">
                            @isset($dailyWord->romaji)
                                {{ $dailyWord->romaji }}
                            @else
                                <span class="text-[9px] text-gray-400 font-medium">[Data: dailyWord.romaji]</span>
                            @endisset
                        </p>
                        <div class="text-[9px] sm:text-[10px] text-gray-500 mt-2 font-medium leading-relaxed">
                            @isset($dailyWord->meaning_en)
                                {{ $dailyWord->meaning_en }}
                            @else
                                <span class="text-[8px] text-gray-400 block">[Data: dailyWord.meaning_en]</span>
                            @endisset

                            @isset($dailyWord->meaning_id)
                                {{ $dailyWord->meaning_id }}
                            @else
                                <span class="text-[8px] text-gray-400 block">[Data: dailyWord.meaning_id]</span>
                            @endisset
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 py-4">

                    {{-- Card 1: Total Siswa Aktif --}}
                    <div class="bg-white border border-rose-200 rounded-2xl px-4 py-4 flex items-start justify-between gap-2">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Total Siswa Aktif</p>
                            <p class="text-2xl font-semibold text-gray-800">{{--<! $totalSiswa >--}}13</p>
                        </div>
                        <div class="w-9 h-9 flex-shrink-0 rounded-lg bg-rose-50 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="#be123c">
                                <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
                            </svg>
                        </div>
                    </div>
                
                    {{-- Card 2: Tugas Perlu Dinilai --}}
                    <div class="bg-white border border-rose-200 rounded-2xl px-4 py-4 flex items-start justify-between gap-2">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tugas Perlu Dinilai</p>
                            <p class="text-2xl font-semibold text-gray-800">{{--<! $TugasDinilai >--}}13</p>
                        </div>
                        <div class="w-9 h-9 flex-shrink-0 rounded-lg bg-rose-50 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="#be123c">
                            <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-2 14-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                        </svg>
                        </div>
                    </div>
                
                    {{-- Card 3: Rata-Rata Skor --}}
                    <div class="bg-white border border-rose-200 rounded-2xl px-4 py-4 flex items-start justify-between gap-2">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Rata - Rata Skor</p>
                            <p class="text-2xl font-semibold text-gray-800">{{--<! number_format($rataRataSkor, 1) >--}}13</p>
                        </div>
                        <div class="w-9 h-9 flex-shrink-0 rounded-lg bg-rose-50 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="#be123c">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        </div>
                    </div>
                
                    {{--Card 4: Jadwal Terdekat--}} 
                    <div class="bg-white border border-rose-200 rounded-2xl px-4 py-4 flex items-start justify-between gap-2">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Jadwal Terdekat</p>
                            <p class="text-sm font-semibold text-gray-800">{{--<! $jadwalNama >--}}JLPT N3 Prep</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{--<! $jadwalLokasi >--}}Ruang A, 14.30</p>
                        </div>
                        <div class="w-9 h-9 flex-shrink-0 rounded-lg bg-rose-50 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="#be123c">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    {{-- ===== KIRI: Tugas Menunggu Penilaian ===== --}}
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-base font-semibold text-gray-800">Tugas Menunggu Penilaian</h2>
                            <a href="<! route('tugas.index') >" class="text-sm text-red-600 hover:underline">Lihat Semua</a>
                        </div>
                    
                        <div class="flex flex-col gap-3">
                            {{--@foreach ($tugasMenunggu as $tugas)--}}
                            <div class="bg-white border border-gray-200 rounded-xl px-4 py-3 flex items-center gap-3">
                                {{-- Avatar --}}
                                <img src="<! $tugas->siswa->foto ?? asset('images/default-avatar.png') >"
                                     alt="<! $tugas->siswa->nama >"
                                     class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                            
                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate"><! $tugas->siswa->nama ></p>
                                    <p class="text-xs text-gray-500 truncate"><! $tugas->judul ></p>
                                </div>
                            
                                {{-- Waktu --}}
                                <div class="text-right flex-shrink-0 mr-2">
                                    <p class="text-xs text-gray-400">Dikirim</p>
                                    <p class="text-sm font-semibold text-gray-800">
                                        <! \Carbon\Carbon::parse($tugas->dikirim_at)->format('H.i') >
                                    </p>
                                </div>
                            
                                {{-- Tombol --}}
                                <a href="<! route('tugas.nilai', $tugas->id) >"
                                   class="flex-shrink-0 bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-4 py-2 rounded-lg transition-colors whitespace-nowrap">
                                    Nilai Sekarang
                                </a>
                            </div>
                            {{--@endforeach==}}
                        </div>
                    </div>
                
                    {{-- ===== KANAN: Jadwal Hari Ini ===== --}}
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-base font-semibold text-gray-800">Jadwal Hari Ini</h2>
                            <span class="text-xs text-red-600 bg-red-50 px-2 py-1 rounded-md">
                                <! \Carbon\Carbon::today()->translatedFormat('d F') >
                            </span>
                        </div>
                    
                        {{-- Timeline --}}
                        <div class="relative pl-6">
                            {{-- Garis vertikal --}}
                            <div class="absolute left-[7px] top-3 bottom-3 w-0.5 bg-rose-200"></div>
                        
                            <div class="flex flex-col gap-3">
                                {{--@foreach ($jadwalHariIni as $jadwal)--}}
                                <div class="relative">
                                    {{-- Dot --}}
                                    {{--@if ($jadwal->status === 'berlangsung')--}}
                                        <div class="absolute -left-[19px] top-3 w-3.5 h-3.5 rounded-full bg-red-600 ring-2 ring-white ring-offset-1 ring-offset-red-600"></div>
                                    {{--@else--}}
                                        <div class="absolute -left-[19px] top-3 w-3.5 h-3.5 rounded-full bg-rose-300 ring-2 ring-white"></div>
                                    {{--@endif--}}
                                
                                    {{-- Card --}}
                                    <div class="bg-white border border-gray-200 rounded-xl px-4 py-3">
                                        {{-- Badge status --}}
                                        {{--@if ($jadwal->status === 'berlangsung')--}}
                                            <span class="text-[10px] font-bold uppercase tracking-wide bg-red-50 text-red-600 px-2 py-0.5 rounded">
                                                Sedang Berlangsung
                                            </span>
                                        {{--@else--}}
                                            <span class="text-[10px] font-bold uppercase tracking-wide bg-yellow-50 text-yellow-700 px-2 py-0.5 rounded">
                                                Akan Datang
                                            </span>
                                        {{--@endif--}}
                                        
                                        <p class="text-sm font-bold text-gray-800 mt-2 mb-1.5"><! $jadwal->nama ></p>
                                        
                                        <div class="flex items-center gap-1.5 text-xs text-gray-500 mb-1">
                                            <svg class="w-3 h-3 fill-gray-400 flex-shrink-0" viewBox="0 0 24 24">
                                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm.5 5v5.25l4.5 2.67-.75 1.23L11 13V7h1.5z"/>
                                            </svg>
                                            <! $jadwal->jam_mulai > - <! $jadwal->jam_selesai >
                                        </div>
                                    
                                        <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                            <svg class="w-3 h-3 fill-gray-400 flex-shrink-0" viewBox="0 0 24 24">
                                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                            </svg>
                                            <! $jadwal->ruangan >
                                        </div>
                                    </div>
                                </div>
                                {{--@endforeach--}}
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </main>
    </div>
</body>
</html>