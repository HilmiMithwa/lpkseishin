@php
    // 🌟 INTEGRASI DATA DASHBOARD (Yumegatari System)
    // Mengambil data dari variabel $dailyWord yang dikirim Controller (jika ada)
    // Jika null atau objek kosong, otomatis menggunakan fallback kata 'Yumegatari' agar halaman tidak crash
    
    $dailyKanji = isset($dailyWord->kanji) ? $dailyWord->kanji : '夢語り';
    $dailyRomaji = isset($dailyWord->romaji) ? $dailyWord->romaji : 'Yumegatari';
    $dailyMeaningEn = isset($dailyWord->meaning_en) ? $dailyWord->meaning_en : 'Speak of Dream';
    $dailyMeaningId = isset($dailyWord->meaning_id) ? $dailyWord->meaning_id : 'Cerita Mimpi';
    $dailyFurigana = isset($dailyWord->furigana) ? $dailyWord->furigana : 'ゆめがたり';

    // 2. Angka Statistik Utama
    $statMastered = "456";
    $statLearning = "456";
    $statFavourite = "56";
    $masteredPercentage = 76; 

    // 3. Array List Level Flashcard Module
    $flashcardLevels = [
        (object)['level' => 1, 'total' => 104, 'mastered' => 104, 'status' => 'Completed', 'updated' => '2 Days Ago'],
        (object)['level' => 2, 'total' => 104, 'mastered' => 104, 'status' => 'Completed', 'updated' => '2 Days Ago'],
        (object)['level' => 3, 'total' => 104, 'mastered' => 45,  'status' => 'Progress', 'updated' => '2 Days Ago'],
        (object)['level' => 4, 'total' => 104, 'mastered' => 0,   'status' => 'Progress', 'updated' => '2 Days Ago'],
        (object)['level' => 5, 'total' => 104, 'mastered' => 0,   'status' => 'Progress', 'updated' => '2 Days Ago'],
    ];

    // Data User Keamanan
    $userName = Auth::user() ? Auth::user()->name : 'Siswa Seishin';
    $userLevel = Auth::user() && isset(Auth::user()->level) ? Auth::user()->level : 'Japanese N4';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vocabulary Mastery - LPK Seishin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* 🔴 BANNER GRADIENT COPIED FROM DASHBOARD.BLADE.PHP */
        .banner-red {
            background: linear-gradient(90deg, #d62828 0%, #d62828 50%, #8b1a1a 100%);
            position: relative;
            overflow: hidden;
        }

        /* Peta Jepang background blend option */
        .banner-red::before {
            content: '';
            position: absolute;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            width: 65%;
            height: 160%;
            background-image: url("{{ asset('img/japanMap.svg') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: left center;
            opacity: 0.75;
            z-index: 0;
            pointer-events: none;
        }

        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 20px; }
    </style>
</head>
<body class="bg-[#FFF9F4] text-[#222222] h-screen flex overflow-hidden">

    <button id="mobile-menu-close" class="fixed top-4 right-4 z-50 hidden lg:hidden p-2 bg-gray-800 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>

    <aside id="sidebar" class="fixed lg:static left-0 top-0 w-64 h-screen lg:h-auto bg-[#FFF9F4] flex flex-col flex-none z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-lg lg:shadow-none">
        <div class="p-6">
            <x-application-logo class="h-14 w-auto" />
        </div>

        <div class="px-4 mt-2 flex-1">
            <p class="text-xs font-bold text-[#444444] mb-3 px-2 tracking-wider">OVERVIEW</p>
            <nav class="space-y-1">
                <a href="{{ route('students.dashboard') }}" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Enrolled
                </a>
                <a href="{{ route('students.tasks') }}" class="flex items-center gap-3  text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    My Task
                </a>
                <a href="#" class="flex items-center gap-3 bg-[#FFDBDB] text-[#DB2A2A] px-4 py-3 rounded-xl font-bold text-sm">
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
                <button type="submit" class="w-full flex items-center px-5 py-2.5 gap-2 text-[#DB2A2A] bg-white border border-gray-200 hover:bg-red-50 rounded-xl font-bold text-sm transition justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        
        <header class="flex flex-col lg:flex-row justify-between items-start lg:items-center px-4 lg:px-8 py-4 lg:py-6 bg-transparent gap-4">
            <div class="flex items-center gap-4"> 
                <button id="mobile-menu-btn" class="lg:hidden p-2 bg-[#DB2A2A] text-white rounded-xl shadow-md hover:bg-red-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="pt-1 text-left">
                    <h2 class="text-base lg:text-lg font-bold text-[#222222]">こんにちわ, {{ explode(' ', $userName)[0] }}! 👋</h2>
                    <p id="realtime-clock" class="text-xs text-[#444444] font-medium mt-0.5">Memuat waktu...</p>
                </div>
            </div>
        </header>

        <main class="flex-1 bg-white rounded-t-[20px] lg:rounded-[40px] mr-0 lg:mr-8 mb-0 lg:mb-8 overflow-y-auto shadow-sm custom-scrollbar">
            <div class="p-4 sm:p-6 lg:p-10 space-y-8">
                
                <div class="text-left">
                    <h1 class="text-2xl lg:text-3xl font-black text-[#222222] tracking-tight">Vocabulary Mastery</h1>
                    <p class="text-xs font-bold text-[#666666] uppercase tracking-wider mt-1">Vocabulary Mastery</p>
                </div>

                <div class="w-full banner-red rounded-[32px] p-6 lg:p-10 text-white flex flex-col md:flex-row justify-between items-center relative shadow-sm min-h-[180px]">
                    
                    <div class="space-y-2 z-10 flex flex-col justify-center items-center">
                        <div>
                            <span class="text-sm font-semibold tracking-wide text-white/90 select-none">
                                Words of The Day
                            </span>
                        </div>
                        <div class="pt-0.5 text-center">
                            <p class="text-xs font-medium text-red-200/90 italic tracking-wider">{{ $dailyFurigana ?? "[Data: dailyWord->furigana]" }}</p>
                            
                            <h2 class="text-4xl lg:text-5xl font-black tracking-tight text-white mt-0.5">
                                {{ $dailyKanji }}
                            </h2>
                            
                            <p class="text-sm font-bold text-red-100/90 tracking-wide mt-1">
                                {{ $dailyRomaji }}
                            </p>
                        </div>
                    </div>
<div class="mt-6 md:mt-0 flex flex-col items-end gap-2.5 z-10 w-full md:w-52 flex-shrink-0 animate-[fadeIn_0.2s_ease-out]">
    
    <button class="w-10 h-10 bg-white text-[#666666] hover:text-amber-500 rounded-xl flex items-center justify-center shadow-sm hover:scale-105 transition-all duration-200 text-lg border border-gray-100/50">
        ★
    </button>

    <div class="bg-white rounded-[24px] py-4 px-5 text-center text-gray-800 shadow-sm w-full flex flex-col justify-center items-center min-h-[96px] border border-gray-50 select-none h-auto">
        <p class="text-[9px] font-extrabold text-[#666666] uppercase tracking-widest">Translation</p>
        
        <h3 class="text-sm font-extrabold text-[#222222] mt-1.5 leading-snug tracking-tight max-w-full break-words">
            {{ $dailyMeaningEn }}
        </h3>
        
        <p class="text-xs font-medium text-[#444444] mt-1 max-w-full break-words">
            {{ $dailyMeaningId }}
        </p>
    </div>

</div>
                </div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
    
    <div class="bg-white border border-gray-100 rounded-[28px] p-6 shadow-sm flex items-center justify-between text-left">
        <div class="space-y-1">
            <div class="flex items-center gap-2 mb-1.5">
                <div class="w-5 h-5 rounded-full border border-[#DB2A2A] flex items-center justify-center text-[#DB2A2A]">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <p class="text-[11px] font-bold text-[#444444] capitalize tracking-wide">Mastered</p>
            </div>
            <h2 class="text-3xl font-black text-[#222222] tracking-tight">{{ $statMastered }} Word</h2>
        </div>
        
        <div class="relative w-[70px] h-[70px] flex items-center justify-center flex-shrink-0">
            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                <path class="text-gray-100" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                <path class="text-[#DB2A2A]" stroke-width="3.5" stroke-dasharray="{{ $masteredPercentage }}, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
            </svg>
            <span class="absolute text-xs font-bold text-[#222222]">{{ $masteredPercentage }}%</span>
        </div>
    </div>

    <div class="bg-white border border-gray-100 rounded-[28px] p-6 shadow-sm flex flex-col justify-center text-left">
        <div class="space-y-1">
            <div class="flex items-center gap-2 mb-1.5">
                <div class="w-5 h-5 rounded-full border border-[#DB2A2A] flex items-center justify-center text-[#DB2A2A]">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </div>
                <p class="text-[11px] font-bold text-[#444444] capitalize tracking-wide">Learning</p>
            </div>
            <h2 class="text-3xl font-black text-[#222222] tracking-tight">{{ $statLearning }} Word</h2>
        </div>
    </div>

    <div class="bg-white border border-gray-100 rounded-[28px] p-6 shadow-sm flex items-center justify-between text-left">
        <div class="space-y-1">
            <div class="flex items-center gap-2 mb-1.5">
                <div class="w-5 h-5 rounded-full border border-[#DB2A2A] flex items-center justify-center text-[#DB2A2A]">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </div>
                <p class="text-[11px] font-bold text-[#444444] capitalize tracking-wide">Favourite</p>
            </div>
            <h2 class="text-3xl font-black text-[#222222] tracking-tight">{{ $statFavourite }} Word</h2>
        </div>
        <button class="w-12 h-12 bg-[#DB2A2A] hover:bg-red-700 text-white rounded-full flex items-center justify-center transition shadow-sm hover:-translate-y-0.5 duration-200 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
        </button>
    </div>

</div>

                <div class="space-y-4">
                    <div class="flex items-center gap-2 border-l-2 border-[#DB2A2A] pl-2 text-left">
                        <h3 class="text-xs font-bold text-[#222222] uppercase tracking-wider">Flashcard Module</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($flashcardLevels as $lvl)
                            <div class="bg-white border border-gray-100 rounded-[28px] p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition duration-200 min-h-[220px]">
                                
                                <div class="flex items-start justify-between mb-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-[52px] h-[52px] bg-white border border-gray-100 rounded-2xl flex items-center justify-center text-[#DB2A2A] font-medium text-2xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] select-none">
                                            あa
                                        </div>
                                        <h3 class="text-[28px] font-black text-[#222222] tracking-tight">Level {{ $lvl->level }}</h3>
                                    </div>
                                    
                                    <span class="text-[11px] font-bold capitalize px-3 py-1.5 rounded-lg {{ $lvl->status === 'Completed' ? 'bg-[#22c55e] text-white' : 'bg-[#eab308] text-white' }}">
                                        {{ $lvl->status }}
                                    </span>
                                </div>

                                <div class="space-y-2.5 text-[13px] tracking-wide mb-6">
                                    <div class="flex items-center">
                                        <span class="w-24 text-gray-500 font-medium">Total Word</span>
                                        <span class="w-4 text-gray-800 font-bold">:</span>
                                        <span class="text-gray-700 font-bold">{{ $lvl->total }} Word</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-24 text-gray-500 font-medium">Mastered</span>
                                        <span class="w-4 text-gray-800 font-bold">:</span>
                                        <span class="text-gray-700 font-bold">{{ $lvl->mastered }} Word</span>
                                    </div>
                                    <div class="flex items-center">
                                        <span class="w-24 text-gray-500 font-medium">Updated</span>
                                        <span class="w-4 text-gray-800 font-bold">:</span>
                                        <span class="text-gray-700 font-bold">{{ $lvl->updated }}</span>
                                    </div>
                                </div>

                                <div class="flex justify-end mt-auto">
                                    <button class="bg-[#DB2A2A] hover:bg-red-700 text-white font-bold py-2.5 px-5 rounded-xl text-sm shadow-sm transition duration-200 flex items-center gap-2" onclick="window.location.href='{{ route('students.vocabulary-level', ['id' => $lvl->level]) }}'">
                                        Open Flashcard
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                                
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        // Sidebar Mobile Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenuClose = document.getElementById('mobile-menu-close');
        const sidebar = document.getElementById('sidebar');

        if (mobileMenuBtn && mobileMenuClose && sidebar) {
            mobileMenuBtn.addEventListener('click', () => { sidebar.classList.remove('-translate-x-full'); mobileMenuClose.classList.remove('hidden'); });
            mobileMenuClose.addEventListener('click', () => { sidebar.classList.add('-translate-x-full'); mobileMenuClose.classList.add('hidden'); });
        }

        // Realtime Clock Function
        function updateClock() {
            const clockElement = document.getElementById('realtime-clock');
            if (!clockElement) return;
            const now = new Date();
            const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateString = now.toLocaleDateString('id-ID', optionsDate);
            
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            clockElement.innerText = `${dateString} • ${hours}.${minutes}.${seconds}`;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>