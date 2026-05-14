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
<body class="bg-[#fcfaf8] text-gray-800 h-screen flex overflow-hidden">

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
                
                <div class="flex items-center gap-2 text-xs font-bold text-gray-400 mb-6 uppercase tracking-wider">
                    <span>Enrolled</span>
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="3"></path></svg>
                    <span class="text-gray-900">N4 Mastering</span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <div class="lg:col-span-8 space-y-8">
                        
                       <div class="grid grid-cols-1 xl:grid-cols-5 gap-6 mb-8">
    
                    <div class="banner-red xl:col-span-2 rounded-[32px] p-6 sm:p-8 flex flex-col items-center xl:items-start justify-center gap-6 relative overflow-hidden">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-red-600 font-black text-2xl flex-shrink-0 z-10">
                            あa
                        </div>
                        <div class="z-10 text-center xl:text-left">
                            <h1 class="text-2xl sm:text-3xl font-black text-white mb-2">{{ $subject->nama_mapel }}</h1>
                            <p class="text-white/80 text-xs font-medium leading-relaxed">
                                Program lanjutan dengan fokus praktik persiapan ujian level N4.
                            </p>
                        </div>
                    </div>

                    <div class="xl:col-span-3 bg-white border border-gray-100 rounded-[32px] p-6 grid grid-cols-2 gap-4">
                        <div class="bg-gray-50/50 p-4 rounded-2xl flex items-center gap-3">
                            <div class="w-9 h-9 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-gray-400 uppercase">Target</p>
                                <p class="text-xs font-black text-gray-800">JLPT N4</p>
                            </div>
                        </div>
                        <div class="bg-gray-50/50 p-4 rounded-2xl flex items-center gap-3">
                            <div class="w-9 h-9 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-gray-400 uppercase">Duration</p>
                                <p class="text-xs font-black text-gray-800">264 JP</p>
                            </div>
                        </div>
                        <div class="bg-gray-50/50 p-4 rounded-2xl flex items-center gap-3">
                            <div class="w-9 h-9 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-gray-400 uppercase">Schedule</p>
                                <p class="text-xs font-black text-gray-800">Senin - Jumat</p>
                            </div>
                        </div>
                        <div class="bg-gray-50/50 p-4 rounded-2xl flex items-center gap-3">
                            <div class="w-9 h-9 bg-red-100 rounded-xl flex items-center justify-center text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[9px] font-bold text-gray-400 uppercase">Min. Skor</p>
                                <p class="text-xs font-black text-gray-800">80</p>
                            </div>
                        </div>
                    </div>
                </div>

                        <div class="space-y-4">
                            <h3 class="text-xl font-black text-gray-900 mb-6">Syllabus and Modules</h3>
                            
                            <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition space-y-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 font-bold">文</div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-black text-gray-800">Introduction to N4 & Kanji N4</h4>
                                        <p class="text-[11px] font-bold text-gray-400 uppercase">SCB-JP-N4-01 | Teori (10 JP) & Praktik (20 JP)</p>
                                    </div>
                                    <span class="text-xs font-black text-red-600">100%</span>
                                </div>
                                <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-red-600 h-full w-[100%] rounded-full"></div>
                                </div>
                            </div>

                            <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm space-y-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-500 font-bold">書</div>
                                    <div class="flex-1">
                                        <h4 class="text-lg font-black text-gray-800">Module 2: Vocabulary & Reading</h4>
                                        <p class="text-[11px] font-bold text-gray-400 uppercase">SCB-JP-N4-02 | Teori (8 JP) & Praktik (22 JP)</p>
                                    </div>
                                    <span class="text-xs font-black text-red-600">60%</span>
                                </div>
                                <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                                    <div class="bg-red-600 h-full w-[60%] rounded-full"></div>
                                </div>
                            </div>

                            <div class="bg-gray-50 border border-gray-100 rounded-3xl p-6 flex items-center gap-4 opacity-70">
                                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-gray-400"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg></div>
                                <div class="flex-1">
                                    <h4 class="text-lg font-black text-gray-400">Module 4: Practice & Simulation</h4>
                                    <p class="text-[11px] font-bold text-gray-300 uppercase">Locked Content</p>
                                </div>
                                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-4 space-y-8">
                        
                        <div class="bg-white border border-gray-100 rounded-[32px] p-8 text-center shadow-sm">
                            <h3 class="text-sm font-black text-gray-800 mb-6">Overall Class Progress</h3>
                            <div class="relative w-32 h-32 mx-auto mb-6 flex items-center justify-center">
                                <svg class="w-full h-full -rotate-90">
                                    <circle cx="64" cy="64" r="58" stroke="#f3f4f6" stroke-width="12" fill="transparent"></circle>
                                    <circle cx="64" cy="64" r="58" stroke="#d62828" stroke-width="12" fill="transparent" stroke-dasharray="364.4" stroke-dashoffset="182.2"></circle>
                                </svg>
                                <span class="absolute text-2xl font-black text-red-600">50%</span>
                            </div>
                            <div class="flex justify-between text-[11px] font-bold">
                                <div class="text-left text-gray-500"><p>Completed:</p><p class="text-gray-900">4 / 8 Modules</p></div>
                                <div class="text-right text-gray-500"><p>Remaining:</p><p class="text-gray-900">4 Modules</p></div>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-100 rounded-[32px] p-6 shadow-sm">
                            <h3 class="text-sm font-black text-gray-800 mb-4">Mentor Sensei</h3>
                            <div class="bg-red-50 rounded-2xl p-6 text-center mb-4">
                                <div class="w-16 h-16 bg-white rounded-full mx-auto mb-3 flex items-center justify-center text-red-500">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <h4 class="font-black text-gray-900">Neida Nurfadillah</h4>
                                <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest">Level N2</p>
                            </div>
                            <div class="flex gap-2">
                                <button class="flex-1 bg-red-600 text-white py-3 rounded-xl text-xs font-black flex items-center justify-center gap-2">Contact Sensei</button>
                                <button class="w-12 h-12 bg-gray-50 text-gray-500 rounded-xl flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-width="2"></path></svg></button>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-100 rounded-[32px] p-6 shadow-sm">
                            <h3 class="text-sm font-black text-gray-800 mb-4">Announcements</h3>
                            <div class="space-y-3">
                                <div class="p-3 bg-gray-50 rounded-xl text-[10px] font-bold text-gray-700">Mock Test 1: Next Monday (12 May)</div>
                                <div class="p-3 bg-gray-50 rounded-xl text-[10px] font-bold text-gray-700">Mock Test 1: Next Monday (12 May)</div>
                                <div class="p-3 bg-gray-50 rounded-xl text-[10px] font-bold text-gray-700">Mock Test 1: Next Monday (12 May)</div>
                            </div>
                            <button class="w-full text-center text-[10px] font-black text-red-600 mt-4 uppercase">Load More</button>
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