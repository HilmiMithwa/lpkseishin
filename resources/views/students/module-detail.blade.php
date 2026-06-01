<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $currentModul->nama_modul ?? 'Detail Modul' }} - LPK Seishin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .banner-red {
            background: linear-gradient(90deg, #DB2A2A 0%, #DB2A2A 50%, #8b1a1a 100%);
            position: relative;
            overflow: hidden;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 20px; }
    </style>
</head>
<body class="bg-[#FFF9F4] text-[#222222] h-screen flex overflow-hidden">

    <button id="mobile-menu-close" class="fixed top-4 right-4 z-40 hidden lg:hidden p-2 bg-[#222222] text-white rounded-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>

    <aside id="sidebar" class="fixed lg:static left-0 top-0 w-64 h-screen lg:h-auto bg-[#FFF9F4] flex flex-col flex-none z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-lg lg:shadow-none">
        <div class="p-6">
            <x-application-logo class="h-14 w-auto" />
        </div>

        <div class="px-4 mt-2 flex-1">
            <p class="text-xs font-bold text-[#444444] mb-3 px-2 tracking-wider">RINGKASAN</p>
            <nav class="space-y-1">
                <a href="{{ route('students.dashboard') }}" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Beranda
                </a>
                <a href="#" class="flex items-center gap-3 bg-[#FFDBDB] text-[#DB2A2A] px-4 py-3 rounded-xl font-bold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Terdaftar
                </a>
                <a href="{{ route('students.tasks') }}" class="flex items-center gap-3 text-[#222222] hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    Tugas Saya
                </a>
                <a href="{{ route('students.vocabulary-mastery') }}" class="flex items-center gap-3 text-[#222222] hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                    Penguasaan Kosakata
                </a>
            </nav>

            <p class="text-xs font-bold text-[#666666] mb-3 px-2 tracking-wider mt-6">SISTEM</p>
            <nav class="space-y-1">
                <a href="{{ route('students.profile') }}" class="flex items-center gap-3 text-[#222222] hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profil
                </a>
                <a href="{{ route('students.payment') }}" class="flex items-center gap-3 text-[#222222] hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Pembayaran
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
                    Keluar
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
                        こんにちわ, 
                        <span class="hidden sm:inline">{{ Auth::user()->name }}! 👋</span>
                        <span class="sm:hidden">{{ substr(Auth::user()->name, 0, 10) }}! 👋</span>
                    </h2>
                    <p id="realtime-clock" class="text-xs text-[#444444] font-medium mt-0.5">Memuat waktu...</p>
                </div>
            </div>
        </header>

        <main class="flex-1 bg-white rounded-t-[20px] lg:rounded-[40px] mr-0 lg:mr-8 mb-0 lg:mb-8 overflow-y-auto shadow-sm custom-scrollbar">
            <div class="p-4 sm:p-6 lg:p-10">
                
                <nav class="text-xs font-bold text-[#444444] mb-6 uppercase tracking-widest">
                    Terdaftar <span class="mx-2">></span> 
                    <a href="{{ route('subjects.show', $subject->id_mapel) }}" class="text-[#444444] hover:text-[#DB2A2A] transition">
                        {{ $subject->nama_mapel ?? '[Data: mapel.nama_mapel]' }}
                    </a> 
                    <span class="mx-2">></span> 
                    <span class="text-[#222222]">{{ $currentModul->nama_modul ?? '[Data: modul.nama_modul]' }}</span>
                </nav>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <div class="lg:col-span-8 space-y-6">
                        
                        <h1 class="text-2xl sm:text-3xl font-black text-[#222222] tracking-tight">
                            {{ $currentModul->nama_modul }}
                        </h1>

                        <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm">
                            <h3 class="text-sm font-bold text-[#222222] mb-3">Deskripsi Modul</h3>
                            <p class="text-xs sm:text-sm text-[#444444] leading-relaxed font-medium">
                                {{ $currentModul->module_description ?? '[Data: modul.deskripsi]' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="space-y-3 flex flex-col">
                                <div class="flex items-center gap-2 border-l-2 border-[#DB2A2A] pl-2">
                                    <h3 class="text-xs font-bold text-[#222222] uppercase tracking-wider">Bahan Ajar</h3>
                                </div>
                                <div class="flex-1 bg-white border border-gray-100 rounded-[24px] p-4 shadow-sm flex flex-col justify-center min-h-[160px]">
                                @forelse($currentModul->materials ?? [] as $material)
                                    <div class="flex items-center justify-between p-3 bg-white border border-gray-50 rounded-2xl shadow-sm mb-3 last:mb-0 gap-3">
                                        <div class="flex items-center gap-3 min-w-0">
                                            
                                            @if(($material->is_complete ?? $material->is_completed ?? 0) == 1)
                                                <div class="w-12 h-12 bg-green-50 rounded-2xl flex items-center justify-center text-[#30CD30] flex-shrink-0">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-12 h-12 bg-[#FFFADD] rounded-2xl flex items-center justify-center text-[#FFA100] flex-shrink-0">
                                                    <svg class="w-6 h-6 animate-[spin_30s_linear_infinite]" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" viewBox="0 0 24 24">
                                                        <path d="M12 3a9 9 0 0 1 0 18" />
                                                        <path d="M12 21a9 9 0 0 1 0-18" stroke-dasharray="1 6.2" />
                                                    </svg>
                                                </div>
                                            @endif
                                            
                                            <div class="min-w-0 text-left">
                                                <p class="text-xs font-bold text-[#222222] truncate">
                                                    {{ $material->nama_bahan_ajar ?? $material->title ?? '[Data: bahan_ajar.nama_bahan_ajar]' }}
                                                </p>
                                                <p class="text-[10px] text-[#444444] font-medium truncate uppercase">
                                                    {{ $material->type ?? 'Teori' }}
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <a href="{{ route('materials.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul, 'id_materi' => $material->id_bahan_ajar ?? $material->id ?? $loop->iteration]) }}" 
                                        class="bg-[#DB2A2A] hover:bg-red-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1 transition flex-shrink-0">
                                            Detail 
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        </a>
                                    </div>
                                @empty
                                    <div class="text-center py-6">
                                        <p class="text-xs font-bold text-[#444444]">[Data: modul.materials]</p>
                                    </div>
                                @endforelse
                                </div>
                            </div>

                            <div class="space-y-3 flex flex-col">
                                <div class="flex items-center gap-2 border-l-2 border-[#DB2A2A] pl-2">
                                    <h3 class="text-xs font-bold text-[#222222] uppercase tracking-wider">Evaluasi</h3>
                                </div>
                                <div class="flex-1 bg-white border border-gray-100 rounded-[24px] p-4 shadow-sm flex flex-col justify-center min-h-[160px]">
                                    @isset($currentModul->evaluation)
                                        <div class="flex items-center justify-between p-3 bg-white border border-gray-50 rounded-2xl shadow-sm gap-3">
                                            <div class="flex items-center gap-3 min-w-0">
                                                    <div class="w-12 h-12 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#DB2A2A] flex-shrink-0">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" viewBox="0 0 24 24">
                                                            <path d="M12 3a9 9 0 0 1 0 18" />
                                                            <path d="M12 21a9 9 0 0 1 0-18" stroke-dasharray="1 6.2" />
                                                        </svg>
                                                    </div>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-bold text-[#222222] truncate">{{ $currentModul->evaluation->title }}</p>
                                                    <p class="text-[10px] text-[#444444] font-medium truncate">
                                                        {{ $currentModul->evaluation->type ?? 'Ujian' }} • {{ $currentModul->evaluation->date }} • {{ $currentModul->evaluation->duration }} Mnt
                                                    </p>
                                                </div>
                                            </div>
                                            <a href="{{ route('evaluations.start', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul, 'id' => $currentModul->evaluation->id]) }}" class="bg-[#DB2A2A] hover:bg-red-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1 transition flex-shrink-0">
                                                Mulai <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-center py-6">
                                            <p class="text-xs font-bold text-[#444444]">[Data: modul.evaluation]</p>
                                        </div>
                                    @endisset
                                </div>
                            </div>

                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center gap-2 border-l-2 border-[#DB2A2A] pl-2">
                                <h3 class="text-xs font-bold text-[#222222] uppercase tracking-wider">Tugas</h3>
                            </div>
                            <div class="bg-white border border-gray-100 rounded-[32px] p-6 shadow-sm">
                                @forelse($currentModul->tasks ?? [] as $task)
                                    @php
                                        $displayStatus = 'Belum Selesai';
                                        if (!empty($task->submission_status)) {
                                            $displayStatus = $task->submission_status === 'terlambat' ? 'Terkirim Terlambat' : 'Selesai';
                                        }
                                    @endphp
                                    
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-5 bg-white border border-gray-100 rounded-[24px] shadow-sm mb-4 last:mb-0 gap-4 relative">
                                        
                                        <div class="flex items-center gap-4 min-w-0">
                                            <div class="w-14 h-14 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#DB2A2A] flex-shrink-0">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6M9 16h4"></path>
                                                </svg>
                                            </div>
                                            
                                            <div class="space-y-1.5 min-w-0 text-left">
                                                <h4 class="text-base font-bold text-[#222222] truncate tracking-tight">
                                                    {{ $task->judul_tugas }}
                                                </h4>
                                                <span class="inline-block bg-[#FFF3CD] text-[#856404] text-[11px] font-bold px-3 py-1 rounded-lg">
                                                    Tenggat: {{ \Carbon\Carbon::parse($task->waktu_pengumpulan)->format('d M Y, H:i') }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex flex-col items-end justify-between sm:h-20 w-full sm:w-auto self-stretch flex-shrink-0 gap-2 text-right">
                                            <span class="text-xs font-semibold text-gray-500 tracking-wide uppercase">
                                                {{ $displayStatus }}
                                            </span>
                                            
                                            <a href="{{ route('tasks.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul, 'id_tugas' => $task->id_tugas]) }}" 
                                                class="bg-[#DB2A2A] hover:bg-red-700 text-white text-xs font-bold py-2.5 px-5 rounded-xl flex items-center gap-2 transition duration-200 shadow-sm w-full sm:w-auto justify-center">
                                                <span>Buka Tugas</span>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                                    <path d="M5 12h14M12 5l7 7-7 7" />
                                                </svg>
                                            </a>
                                        </div> </div> @empty
                                    <div class="text-center py-12 flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-[#FFDBDB] rounded-full flex items-center justify-center text-[#DB2A2A] mb-4 shadow-sm">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1" />
                                                <path d="m9 13 2 2 4-4" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-bold text-[#222222]">Hore! Tidak ada tugas di modul ini.</p>
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
                                    
                                    <a href="{{ route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $modul->id_modul]) }}" 
                                    class="w-full flex items-center justify-between p-3.5 rounded-xl text-sm font-bold transition text-left
                                            {{ $modul->id_modul === $currentModul->id_modul 
                                                ? 'bg-[#DB2A2A] text-white shadow-md' 
                                                : 'bg-white hover:bg-gray-50 text-[#222222] border border-gray-50' }}">
                                        <span>Modul {{ $index + 1 }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
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