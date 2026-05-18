<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $material->title ?? '[Data: material.title]' }} - LPK Seishin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
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
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="pt-1">
                    <h2 class="text-base lg:text-lg font-bold text-[#222222] flex items-center gap-1">
                        こんにchわ, 
                        <span class="hidden sm:inline">{{ Auth::user()->name }}! 👋</span>
                        <span class="sm:hidden">{{ substr(Auth::user()->name, 0, 10) }}! 👋</span>
                    </h2>
                    <p id="realtime-clock" class="text-xs text-[#444444] font-medium mt-0.5">Memuat waktu...</p>
                </div>
            </div>
        </header>

        <main class="flex-1 bg-white rounded-t-[20px] lg:rounded-[40px] mr-0 lg:mr-8 mb-0 lg:mb-8 overflow-y-auto shadow-sm custom-scrollbar">
            <div class="p-4 sm:p-6 lg:p-10 space-y-4">
                
                <nav class="text-xs font-bold text-[#444444] uppercase tracking-widest flex items-center flex-wrap gap-1">
                    <span>Enrolled</span> 
                    <span class="mx-1.5 text-gray-300">></span> 
                    <a href="{{ isset($subject) ? route('subjects.show', $subject->id_mapel) : '#' }}" class="text-[#444444] hover:text-[#DB2A2A] transition">
                        {{ $subject->nama_mapel ?? '[Data: mapel.nama_mapel]' }}
                    </a> 
                    <span class="mx-1.5 text-gray-300">></span> 
                    <a href="{{ (isset($subject) && isset($currentModul)) ? route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul]) : '#' }}" class="text-[#444444] hover:text-[#DB2A2A] transition">
                        {{ $currentModul->nama_modul ?? '[Data: modul.nama_modul]' }}
                    </a>
                    <span class="mx-1.5 text-gray-300">></span> 
                    <span class="text-[#DB2A2A]">{{ $material->title ?? '[Data: material.title]' }}</span>
                </nav>

                <h1 class="text-2xl sm:text-3xl font-black text-[#222222] tracking-tight text-left">
                    {{ $material->page_title ?? '[Data: material.page_title]' }}
                </h1>

                <div class="w-full bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm">
                    
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                        <div class="text-left">
                            <h2 class="text-base font-extrabold text-[#222222]">{{ $material->title ?? '[Data: material.title]' }}</h2>
                            <p class="text-[11px] text-gray-400 font-bold mt-0.5">{{ $material->reading_duration ?? '[Data: material.reading_duration]' }}</p>
                        </div>
                        
                        <div class="flex items-center gap-3 self-stretch sm:self-auto justify-between sm:justify-end">
                            @if($material->is_completed ?? false)
                                <button class="px-4 py-2 bg-green-50 text-green-600 text-xs font-bold rounded-xl border border-green-200 cursor-default">
                                    Completed
                                </button>
                                <div class="w-8 h-8 bg-green-50 rounded-full flex items-center justify-center text-green-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            @else
                                <form action="{{ route('materials.complete', $material->id ?? 1) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 border border-[#DB2A2A] text-[#DB2A2A] text-xs font-bold rounded-xl hover:bg-red-50 transition duration-200">
                                        Mark as Complete
                                    </button>
                                </form>
                                <div class="w-8 h-8 flex items-center justify-center text-gray-300">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-dasharray="4 4" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="10"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
                        
                        <div class="lg:col-span-7">
                            <div class="relative w-full aspect-video rounded-[20px] overflow-hidden bg-gray-900 shadow-sm flex items-center justify-center group cursor-pointer">
                                <img src="{{ $material->thumbnail_url ?? 'https://images.unsplash.com/photo-1528459801416-a9e53bbf4e17?q=80&w=600' }}" 
                                     class="absolute inset-0 w-full h-full object-cover opacity-60 filter grayscale group-hover:scale-105 transition duration-300" 
                                     alt="Video Thumbnail">
                                
                                <div class="absolute left-6 top-6 text-white z-10 space-y-1 text-left">
                                    <p class="text-base font-black tracking-tight drop-shadow-md">{{ $material->video_badge ?? '[Data: material.video_badge]' }}</p>
                                    <p class="text-xl sm:text-2xl font-black tracking-wide bg-white text-black px-2 py-0.5 inline-block rounded-md shadow-sm">
                                        {{ $material->video_overlay_title ?? '[Data: material.video_overlay_title]' }}
                                    </p>
                                    <p class="text-xs font-bold opacity-90 flex items-center gap-1 mt-2">
                                        <span class="inline-block w-4 h-4 border border-white rounded-md text-center text-[10px] font-bold">✓</span> 
                                        {{ $material->video_category ?? '[Data: material.video_category]' }}
                                    </p>
                                </div>

                                <a href="{{ $material->video_url ?? '#' }}" target="_blank" class="relative z-20 w-14 h-14 bg-[#DB2A2A] rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition duration-200">
                                    <svg class="w-6 h-6 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="lg:col-span-5 flex flex-col justify-start text-left">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="w-1 h-4 bg-[#DB2A2A] rounded-full"></span>
                                <h3 class="text-sm font-extrabold text-[#222222]">Learning Videos</h3>
                            </div>
                            
                            <div class="space-y-3 text-xs">
                                <div class="flex items-start">
                                    <span class="w-24 font-bold text-gray-500 flex-shrink-0">Video Title</span>
                                    <span class="text-gray-400 mx-2">:</span>
                                    <span class="flex-1 font-semibold text-[#444444]">{{ $material->video_title ?? '[Data: material.video_title]' }}</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="w-24 font-bold text-gray-500 flex-shrink-0">Duration</span>
                                    <span class="text-gray-400 mx-2">:</span>
                                    <span class="flex-1 font-semibold text-[#444444]">{{ $material->video_duration ?? '[Data: material.video_duration]' }}</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="w-24 font-bold text-gray-500 flex-shrink-0">Focus Skill</span>
                                    <span class="text-gray-400 mx-2">:</span>
                                    <span class="flex-1 font-semibold text-[#444444]">{{ $material->focus_skill ?? '[Data: material.focus_skill]' }}</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="w-24 font-bold text-gray-500 flex-shrink-0">Key Points</span>
                                    <span class="text-gray-400 mx-2">:</span>
                                    <span class="flex-1 font-semibold text-[#444444]">{{ $material->key_points ?? '[Data: material.key_points]' }}</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="w-24 font-bold text-gray-500 flex-shrink-0">Objective</span>
                                    <span class="text-gray-400 mx-2">:</span>
                                    <span class="flex-1 font-semibold text-[#444444]">{{ $material->objective ?? '[Data: material.objective]' }}</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="w-24 font-bold text-gray-500 flex-shrink-0">Sensei's Note</span>
                                    <span class="text-gray-400 mx-2">:</span>
                                    <span class="flex-1 font-semibold text-[#444444]">{{ $material->sensei_note ?? '[Data: material.sensei_note]' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 text-xs text-[#555555] leading-relaxed font-medium mb-6 text-left">
                        @if(isset($material->content))
                            {!! $material->content !!}
                        @else
                            <p>[Data: material.content]</p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                        @endif
                    </div>

                    <div class="space-y-3 mb-6 text-left">
                        <h3 class="text-xs font-extrabold text-[#222222]">Document</h3>
                        
                        <div class="max-w-md flex items-center justify-between p-3.5 bg-white border border-gray-100 rounded-2xl shadow-sm gap-4">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-10 h-10 bg-red-50 text-[#DB2A2A] rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 6c.55 0 1 .45 1 1v4c0 .55-.45 1-1 1s-1-.45-1-1v-4c0-.55.45-1 1-1z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-[#222222] truncate">{{ $material->file_name ?? '[Data: material.file_name]' }}</p>
                                    <p class="text-[10px] text-gray-400 font-semibold mt-0.5">{{ $material->file_type ?? '[Data: material.file_type]' }}</p>
                                </div>
                            </div>
                            
                            <a href="{{ $material->file_path ?? '#' }}" download class="px-3 py-1.5 border border-[#DB2A2A] text-[#DB2A2A] text-[11px] font-bold rounded-xl flex items-center gap-1.5 hover:bg-red-50 transition duration-200 flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16v1a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-1m-4-4l-4 4V4"/>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-50">
                        @if(isset($previousMaterialUrl))
                            <a href="{{ $previousMaterialUrl }}" class="px-4 py-2 bg-white border border-gray-200 text-[#444444] text-xs font-bold rounded-xl flex items-center gap-1 hover:bg-gray-50 transition duration-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Prev
                            </a>
                        @else
                            <button class="px-4 py-2 bg-gray-50 text-gray-400 text-xs font-bold rounded-xl flex items-center gap-1 cursor-not-allowed" disabled>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                                Prev
                            </button>
                        @endif
                        
                        @if(isset($nextMaterialUrl))
                            <a href="{{ $nextMaterialUrl }}" class="px-4 py-2 bg-[#DB2A2A] text-white text-xs font-bold rounded-xl flex items-center gap-1 hover:bg-red-700 transition duration-200 shadow-sm shadow-red-200">
                                Next
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @else
                            <button class="px-4 py-2 bg-gray-50 text-gray-400 text-xs font-bold rounded-xl flex items-center gap-1 cursor-not-allowed" disabled>
                                Next
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        @endif
                    </div>

                </div>

            </div>
        </main>
    </div>

    <script>
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

        document.querySelectorAll('#sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                sidebar.classList.add('-translate-x-full');
                mobileMenuClose.classList.add('hidden');
            });
        });

        function updateClock() {
            const now = new Date();
            const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
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