<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - LPK Seishin</title>
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
<body class="bg-[#fcfaf8] text-gray-800 h-screen flex overflow-hidden">

    <!-- Mobile Menu Button -->
    {{-- <button id="mobile-menu-btn" class="fixed top-4 left-4 z-50 lg:hidden p-2 bg-red-600 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
    </button> --}}

    <!-- Mobile Menu Close Button -->
    <button id="mobile-menu-close" class="fixed top-4 right-4 z-40 hidden lg:hidden p-2 bg-gray-800 text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>

    <aside id="sidebar" class="fixed lg:static left-0 top-0 w-64 h-screen lg:h-auto bg-[#fcfaf8] flex flex-col flex-none z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-lg lg:shadow-none">
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
                    <h4 class="font-bold text-[13px] text-gray-900 truncate">{{ Auth::user()->name }}</h4>
                    <p class="text-[10px] text-gray-500 truncate">Level Pra-N5</p>
                    <p class="text-[10px] text-gray-500 truncate flex items-center gap-1">
                        <span class="text-red-500 font-bold text-[11px]">@</span> {{ Auth::user()->email }}
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
        
        <div class="flex items-center gap-4"> <button id="mobile-menu-btn" class="lg:hidden p-2 bg-red-600 text-white rounded-xl shadow-md hover:bg-red-700 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

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

                <div class="banner-red rounded-2xl lg:rounded-3xl p-4 sm:p-6 lg:p-8 mb-8 flex flex-col lg:flex-row items-start lg:items-center justify-between relative gap-4">
                    <div class="relative z-10 w-full lg:w-2/3">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white leading-tight mb-3">Welcome Back,<br>{{ Auth::user()->name }}</h2>
                        <p class="text-white/90 text-xs sm:text-sm font-medium">Big dreams start with small consistency. Let's learn something<br>new today!</p>
                    </div>
                    <div class="relative z-10 bg-white rounded-2xl p-4 sm:p-6 text-center shadow-lg w-full sm:w-64 flex-shrink-0">
                        <h3 class="text-3xl sm:text-4xl font-black text-gray-900 tracking-widest mb-1">夢語り</h3>
                        <p class="text-xs sm:text-sm font-bold text-gray-800">Yumegatari</p>
                        <p class="text-[9px] sm:text-[10px] text-gray-500 mt-2 font-medium">Speaking of Dreams<br>Cerita Mimpi</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-10">
                    <div class="col-span-1 rounded-2xl lg:rounded-3xl overflow-hidden relative group min-h-[240px] sm:min-h-[260px]">
                        <img src="https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover absolute inset-0 group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>
                        <div class="relative z-10 p-4 sm:p-6 flex flex-col h-full justify-between">
                            <div>
                                <span class="bg-[#d62828] text-white text-[9px] sm:text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-sm">Main Course</span>
                            </div>
                            <div>
                                <h3 class="text-lg sm:text-xl font-bold text-white leading-snug mb-4">Batch 5 - Pelatihan LPK Seishin</h3>
                                <button class="w-full bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm transition shadow-md flex items-center justify-center gap-2">
                                    Continue Lesson
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-1 lg:col-span-2">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="bg-gray-800 text-white text-[9px] sm:text-[10px] font-bold px-2 py-0.5 rounded uppercase">概要</span>
                            <h3 class="font-bold text-gray-800 text-xs sm:text-sm">Summary</h3>
                        </div>
                        <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-4">
                            <div class="bg-white border border-gray-100 rounded-2xl p-3 sm:p-5 shadow-sm">
                                <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                                    <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-full border border-red-100 flex items-center justify-center text-red-500 flex-shrink-0">
                                        <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <h4 class="text-xs sm:text-sm font-black text-gray-900 line-clamp-1">{{ $enrollment->jenis_program ?? 'N/A' }}</h4>
                                </div>
                                <p class="text-[9px] sm:text-[11px] font-bold text-gray-500">Program Saat Ini</p>
                            </div>
                            <div class="bg-white border border-gray-100 rounded-2xl p-3 sm:p-5 shadow-sm">
                                <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                                    <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-full border border-red-100 flex items-center justify-center text-red-500 flex-shrink-0">
                                        <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                    </div>
                                    <h4 class="text-lg sm:text-2xl font-black text-gray-900">85.5</h4>
                                </div>
                                <p class="text-[9px] sm:text-[11px] font-bold text-gray-500">Average Score</p>
                            </div>
                            <div class="bg-white border border-gray-100 rounded-2xl p-3 sm:p-5 shadow-sm">
                                <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                                    <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-full border border-red-100 flex items-center justify-center text-red-500 flex-shrink-0">
                                        <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                    </div>
                                    <h4 class="text-lg sm:text-2xl font-black text-gray-900">23</h4>
                                </div>
                                <p class="text-[9px] sm:text-[11px] font-bold text-gray-500">Assignment Completion</p>
                            </div>
                            <div class="bg-white border border-gray-100 rounded-2xl p-3 sm:p-5 shadow-sm">
                                <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                                    <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-full border border-red-100 flex items-center justify-center text-red-500 flex-shrink-0 font-bold text-sm">あ</div>
                                    <h4 class="text-lg sm:text-2xl font-black text-gray-900">456</h4>
                                </div>
                                <p class="text-[9px] sm:text-[11px] font-bold text-gray-500">Vocabulary Mastery</p>
                            </div>
                            <div class="bg-white border border-gray-100 rounded-2xl p-3 sm:p-5 shadow-sm">
                                <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                                    <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-full border border-red-100 flex items-center justify-center text-red-500 flex-shrink-0">
                                        <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <h4 class="text-lg sm:text-2xl font-black text-gray-900">4 Task</h4>
                                </div>
                                <p class="text-[9px] sm:text-[11px] font-bold text-gray-500">Upcoming Deadlines</p>
                            </div>
                            <div class="bg-white border border-gray-100 rounded-2xl p-3 sm:p-5 shadow-sm">
                                <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                                    <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-full border border-red-100 flex items-center justify-center text-red-500 flex-shrink-0 font-bold text-sm">あ</div>
                                    <h4 class="text-lg sm:text-2xl font-black text-gray-900 line-clamp-1">56 Hours</h4>
                                </div>
                                <p class="text-[9px] sm:text-[11px] font-bold text-gray-500">Total Learning Hours</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="bg-gray-800 text-white text-[9px] sm:text-[10px] font-bold px-2 py-0.5 rounded uppercase">授業</span>
                        <h3 class="font-bold text-gray-800 text-xs sm:text-sm">Current Lesson</h3>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        @forelse($subjects as $subject)
                        <div class="bg-white border border-gray-100 rounded-2xl lg:rounded-3xl p-4 sm:p-5 shadow-sm relative flex flex-col justify-between">
                            <span class="absolute top-4 right-4 bg-yellow-400 text-white text-[8px] sm:text-[10px] font-bold px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-md">Progress</span>
                            
                            <div>
                                <div class="flex items-center gap-3 sm:gap-4 mb-4">
                                    <div class="w-12 sm:w-14 h-12 sm:h-14 rounded-xl border border-gray-200 flex items-center justify-center text-red-600 font-bold text-base sm:text-lg flex-shrink-0">
                                        あa
                                    </div>
                                    
                                    <div class="w-12 sm:w-14 h-12 sm:h-14 flex flex-col items-center justify-center border border-gray-200 rounded-xl flex-shrink-0">
                                        <p class="text-lg sm:text-2xl font-black text-gray-900 leading-none">
                                            {{ $subject->rps?->count() ?? 0 }}
                                        </p>
                                        <p class="text-[7px] sm:text-[8px] text-gray-500 font-bold mt-0.5 uppercase text-center">Module</p>
                                    </div>
                                </div>
                                <h4 class="text-sm sm:text-base font-black text-gray-900 mb-1.5 leading-snug line-clamp-2">{{ $subject->nama_mapel }}</h4>
                                <p class="text-[9px] sm:text-[10px] text-gray-500 font-medium mb-5 line-clamp-1">
                                    Sensei: {{ $subject->guru->name ?? 'Seishin Sensei' }}
                                </p>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('subjects.show', $subject->id_mapel) }}" class="w-full sm:w-auto bg-[#d62828] hover:bg-red-700 text-white font-bold py-2 sm:py-2.5 px-4 sm:px-5 rounded-xl text-xs sm:text-sm transition shadow-md flex items-center justify-center gap-2">
                                    Open Class
                                    <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-8 sm:py-10 bg-gray-50 rounded-2xl lg:rounded-3xl border border-dashed border-gray-300">
                            <p class="text-gray-500 italic text-xs sm:text-sm">Belum ada mata pelajaran yang tersedia.</p>
                        </div>
                        @endforelse
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