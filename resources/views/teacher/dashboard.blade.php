<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sensei - LPK Seishin</title>
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

        /* Peta Jepang menggunakan pseudo-element */
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
            opacity: 0.35;
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

    <!-- Mobile Menu Close Button -->
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
                    My Classes
                </a>
                <a href="#" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Task Review
                </a>
                <a href="#" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                    Vocabulary Database
                </a>
                <a href="#" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Progress Report
                </a>
            </nav>

            <p class="text-xs font-bold text-gray-400 mb-3 px-2 tracking-wider mt-6">SYSTEM</p>
            <nav class="space-y-1">
                <a href="#" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profile
                </a>
            </nav>
        </div>

        {{-- User Profile --}}
        <div class="p-4">
            <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm mb-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f3f4f6&color=ef4444" class="w-10 h-10 rounded-full">
                <div class="overflow-hidden">
                    <h4 class="font-bold text-[13px] text-gray-900 truncate">{{ Auth::user()->name }}</h4>
                    <p class="text-[10px] text-gray-500 truncate">{{ $teacher->level ?? 'Level N2' }}</p>
                    <p class="text-[10px] text-gray-500 truncate flex items-center gap-1">
                        <span class="text-red-500 font-bold text-[11px]">@</span> {{ Auth::user()->email ?? '[Data: user.email]' }}
                    </p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
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

            <div class="flex items-center gap-2 lg:gap-4 w-full lg:w-auto justify-end">
                {{-- Language Switcher --}}
                <div class="flex items-center gap-1 text-sm font-semibold text-gray-700 bg-white border border-gray-200 px-3 py-2 rounded-xl cursor-pointer hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                    <span>EN</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                {{-- Notification --}}
                <div class="relative">
                    <button class="w-9 h-9 flex items-center justify-center bg-white border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition relative">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-[9px] font-bold rounded-full flex items-center justify-center">
                            {{ $notificationCount ?? '0' }}
                        </span>
                    </button>
                </div>

                {{-- User Avatar --}}
                <div class="flex items-center gap-2 bg-white border border-gray-200 rounded-xl px-3 py-1.5 cursor-pointer hover:bg-gray-50 transition">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f3f4f6&color=ef4444" class="w-7 h-7 rounded-full">
                    <span class="text-sm font-semibold text-gray-800 hidden sm:inline">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </header>

        <main class="flex-1 bg-white rounded-t-[20px] lg:rounded-[40px] mr-0 lg:mr-8 mb-0 lg:mb-8 overflow-y-auto shadow-sm custom-scrollbar">
            <div class="p-4 sm:p-6 lg:p-10">

                <div class="mb-6">
                    <h1 class="text-xl sm:text-2xl lg:text-[26px] font-black text-gray-900 tracking-tight">Dashboard</h1>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Study Monitoring</p>
                </div>

                {{-- Banner --}}
                <div class="banner-red rounded-2xl lg:rounded-3xl p-4 sm:p-6 lg:p-8 mb-8 flex flex-col lg:flex-row items-start lg:items-center justify-between relative gap-4">
                    <div class="relative z-10 w-full lg:w-2/3">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight mb-3">Welcome Back,<br>{{ Auth::user()->name }} Sensei</h2>
                        <p class="text-white/90 text-xs sm:text-sm font-medium">Below is a summary of the classes and assignments that need<br class="hidden sm:block"> you to tackle today.</p>
                    </div>
                    <div class="relative z-10 bg-white rounded-2xl p-4 sm:p-6 text-center shadow-lg w-full sm:w-52 flex-shrink-0">
                        <p class="text-[10px] sm:text-xs text-gray-500 font-semibold mb-1">
                            @php
                                $days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                                $months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                                $now = now();
                            @endphp
                            {{ $days[$now->dayOfWeek] }}, {{ $now->day }} {{ $months[$now->month - 1] }} {{ $now->year }}
                        </p>
                        <h3 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-widest leading-tight">
                            {{ $now->format('H.i') }}
                        </h3>
                        <p class="text-[9px] sm:text-[10px] text-gray-400 font-bold mt-1 uppercase tracking-wider">WIB</p>
                    </div>
                </div>

                {{-- Summary Stats --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-8">
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 sm:p-5 shadow-sm">
                        <div class="flex items-center gap-2 sm:gap-3 mb-3">
                            <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-full border border-red-100 flex items-center justify-center text-red-500 flex-shrink-0">
                                <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            <h4 class="text-2xl sm:text-3xl font-black text-gray-900">
                                @isset($needReviewCount)
                                    {{ $needReviewCount }}
                                @else
                                    <span class="text-[12px] text-gray-400">[Data: needReviewCount]</span>
                                @endisset
                            </h4>
                        </div>
                        <p class="text-[9px] sm:text-[11px] font-bold text-gray-500">Need Review</p>
                        <p class="text-[8px] sm:text-[10px] text-gray-400 mt-0.5">Tasks waiting for grading</p>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-2xl p-4 sm:p-5 shadow-sm">
                        <div class="flex items-center gap-2 sm:gap-3 mb-3">
                            <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-full border border-red-100 flex items-center justify-center text-red-500 flex-shrink-0">
                                <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h4 class="text-2xl sm:text-3xl font-black text-gray-900">
                                @isset($activeClassesCount)
                                    {{ $activeClassesCount }}
                                @else
                                    <span class="text-[12px] text-gray-400">[Data: activeClassesCount]</span>
                                @endisset
                            </h4>
                        </div>
                        <p class="text-[9px] sm:text-[11px] font-bold text-gray-500">Active Classes</p>
                        <p class="text-[8px] sm:text-[10px] text-gray-400 mt-0.5">Batches currently running</p>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-2xl p-4 sm:p-5 shadow-sm">
                        <div class="flex items-center gap-2 sm:gap-3 mb-3">
                            <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-full border border-red-100 flex items-center justify-center text-red-500 flex-shrink-0">
                                <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h4 class="text-2xl sm:text-3xl font-black text-gray-900">
                                @isset($totalStudentsCount)
                                    {{ $totalStudentsCount }}
                                @else
                                    <span class="text-[12px] text-gray-400">[Data: totalStudentsCount]</span>
                                @endisset
                            </h4>
                        </div>
                        <p class="text-[9px] sm:text-[11px] font-bold text-gray-500">Total Students</p>
                        <p class="text-[8px] sm:text-[10px] text-gray-400 mt-0.5">Enrolled in your classes</p>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-2xl p-4 sm:p-5 shadow-sm">
                        <div class="flex items-center gap-2 sm:gap-3 mb-3">
                            <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-full border border-red-100 flex items-center justify-center text-red-500 flex-shrink-0">
                                <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <h4 class="text-2xl sm:text-3xl font-black text-gray-900">
                                @isset($todayScheduleCount)
                                    {{ $todayScheduleCount }}
                                @else
                                    <span class="text-[12px] text-gray-400">[Data: todayScheduleCount]</span>
                                @endisset
                            </h4>
                        </div>
                        <p class="text-[9px] sm:text-[11px] font-bold text-gray-500">Today's Schedule</p>
                        <p class="text-[8px] sm:text-[10px] text-gray-400 mt-0.5">Sessions for today</p>
                    </div>
                </div>

                {{-- My Class & Today Schedule --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">

                    {{-- My Class --}}
                    <div class="col-span-1 lg:col-span-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <h3 class="font-bold text-gray-800 text-sm">My Class</h3>
                            </div>
                            <a href="#" class="text-red-500 text-xs font-bold flex items-center gap-1 hover:text-red-700 transition">
                                See All Class
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($teacherSubjects as $subject)
                            <div class="bg-white border border-gray-100 rounded-2xl lg:rounded-3xl p-4 sm:p-5 shadow-sm relative flex flex-col justify-between">
                                <div>
                                    <p class="text-[9px] sm:text-[10px] text-gray-400 font-bold uppercase mb-3">
                                        {{ $subject->batch->nama_batch ?? '[Data: subject.batch.nama_batch]' }}
                                    </p>
                                    <div class="flex items-center gap-3 sm:gap-4 mb-4">
                                        <div class="w-12 sm:w-14 h-12 sm:h-14 rounded-xl border border-gray-200 flex items-center justify-center text-red-600 font-bold text-base sm:text-lg flex-shrink-0">
                                            あa
                                        </div>
                                        <div class="w-12 sm:w-14 h-12 sm:h-14 flex flex-col items-center justify-center border border-gray-200 rounded-xl flex-shrink-0">
                                            <p class="text-lg sm:text-2xl font-black text-gray-900 leading-none text-center">
                                                @isset($subject->modul_count)
                                                    {{ $subject->modul_count }}
                                                @else
                                                    <span class="text-[10px] text-gray-400">[Data: modul_count]</span>
                                                @endisset
                                            </p>
                                            <p class="text-[7px] sm:text-[8px] text-gray-500 font-bold mt-0.5 uppercase text-center">Module</p>
                                        </div>
                                    </div>
                                    <h4 class="text-sm sm:text-base font-black text-gray-900 mb-1.5 leading-snug line-clamp-2">{{ $subject->nama_mapel ?? '[Data: subject.nama_mapel]' }}</h4>
                                    <p class="text-[9px] sm:text-[10px] text-gray-500 font-medium mb-5 line-clamp-1">
                                        {{ $subject->students_count ?? '[Data: students_count]' }} Students
                                    </p>
                                </div>
                                <div class="flex justify-end">
                                    <a href="{{ route('teacher.subjects.show', $subject->id_mapel ?? 0) }}" class="w-full sm:w-auto bg-[#d62828] hover:bg-red-700 text-white font-bold py-2 sm:py-2.5 px-4 sm:px-5 rounded-xl text-xs sm:text-sm transition shadow-md flex items-center justify-center gap-2">
                                        Open Class
                                        <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-1 sm:col-span-2 text-center py-8 sm:py-10 bg-gray-50 rounded-2xl lg:rounded-3xl border border-dashed border-gray-300">
                                <p class="text-gray-500 italic text-xs sm:text-sm">Belum ada kelas yang tersedia.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Today Schedule --}}
                    <div class="col-span-1">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <h3 class="font-bold text-gray-800 text-sm">Today Schedule</h3>
                        </div>

                        <div class="space-y-3">
                            @forelse($todaySchedules as $schedule)
                            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm flex items-start gap-3">
                                <div class="w-8 h-8 bg-red-50 border border-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs sm:text-sm font-black text-gray-900 leading-snug">
                                        Teaching in {{ $schedule->batch->nama_batch ?? '[Data: schedule.batch.nama_batch]' }} Classes
                                    </h4>
                                    <p class="text-[9px] sm:text-[10px] text-gray-500 font-medium mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $schedule->jam_mulai ?? '[Data: jam_mulai]' }} - {{ $schedule->jam_selesai ?? '[Data: jam_selesai]' }}
                                    </p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 sm:py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                <p class="text-gray-500 italic text-xs sm:text-sm">Tidak ada jadwal hari ini.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Pending Task Review --}}
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            <h3 class="font-bold text-gray-800 text-sm">Pending Task Review</h3>
                        </div>
                        <a href="#" class="text-red-500 text-xs font-bold flex items-center gap-1 hover:text-red-700 transition">
                            See All Task
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-2xl lg:rounded-3xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-gray-100">
                                        <th class="text-left text-[10px] sm:text-xs font-bold text-gray-500 px-4 sm:px-6 py-3 sm:py-4">Student</th>
                                        <th class="text-left text-[10px] sm:text-xs font-bold text-gray-500 px-4 sm:px-6 py-3 sm:py-4">Batch</th>
                                        <th class="text-left text-[10px] sm:text-xs font-bold text-gray-500 px-4 sm:px-6 py-3 sm:py-4">Task Module</th>
                                        <th class="text-left text-[10px] sm:text-xs font-bold text-gray-500 px-4 sm:px-6 py-3 sm:py-4">Submitted</th>
                                        <th class="text-left text-[10px] sm:text-xs font-bold text-gray-500 px-4 sm:px-6 py-3 sm:py-4">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($pendingTasks as $task)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                                            <span class="text-xs sm:text-sm font-semibold text-gray-800">{{ $task->student->name ?? '[Data: task.student.name]' }}</span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                                            <span class="text-xs sm:text-sm text-gray-600">{{ $task->batch->nama_batch ?? '[Data: task.batch.nama_batch]' }}</span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                                            <span class="text-xs sm:text-sm text-gray-600 line-clamp-1">{{ $task->modul->nama_modul ?? '[Data: task.modul.nama_modul]' }}</span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                                            <span class="text-xs sm:text-sm text-gray-500">{{ $task->submitted_at ? $task->submitted_at->diffForHumans() : '[Data: submitted_at]' }}</span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                                            <a href="{{ route('teacher.tasks.review', $task->id_tugas ?? 0) }}" class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-1.5 sm:py-2 px-3 sm:px-4 rounded-lg text-[10px] sm:text-xs transition shadow-sm flex items-center gap-1 w-fit">
                                                Review
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-8 sm:py-10 text-gray-500 italic text-xs sm:text-sm">
                                            Tidak ada tugas yang perlu direview.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
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