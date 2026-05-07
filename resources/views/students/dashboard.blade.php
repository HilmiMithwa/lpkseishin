<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - LPK Seishin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased text-gray-900 bg-[#fdfaf6]">

<div class="min-h-screen flex flex-col">
    <div class="md:hidden bg-white border-b border-gray-200 p-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
            <button id="hamburger" class="p-2 text-gray-700 hover:text-red-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            <div class="flex items-center gap-3">
                <x-application-logo class="h-10 w-auto" />
            </div>
        </div>
        <div class="flex items-center gap-2">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f3f4f6&color=ef4444" alt="Avatar" class="w-8 h-8 rounded-full">
        </div>
    </div>

    <div class="flex flex-1 relative">

        <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900/50 z-40 hidden md:hidden transition-opacity opacity-0 pointer-events-none"></div>

        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 h-screen bg-white flex flex-col shrink-0 border-r border-gray-200 transform -translate-x-full transition-transform duration-300 md:translate-x-0 md:static md:h-auto md:min-h-screen md:flex">
            
            <div class="flex-none p-6 pb-4 border-b border-gray-100 relative flex flex-col items-center justify-center">
                <button id="close-sidebar" class="absolute top-4 right-4 md:hidden p-2 text-gray-400 hover:text-red-600 transition rounded-full hover:bg-red-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

            <div class="flex-none p-6 flex justify-center">
                <a href="/">
                    <x-application-logo class="h-16" />
                </a>
            </div>
            </div>

            <div class="flex-none">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-red-600 font-bold text-lg text-center">Dashboard Siswa</h2>
                </div>

                <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full border-2 border-red-500 overflow-hidden flex-shrink-0">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=f3f4f6&color=ef4444" alt="Avatar" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-gray-900">{{ Auth::user()->name }}</h3>
                        <p class="text-xs text-gray-600">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-4 custom-scrollbar">
                <p class="text-xs font-bold text-gray-400 mb-4 px-2 uppercase tracking-wide">Menu Utama</p>
                <nav class="space-y-1">
                    <a href="#" class="flex items-center gap-3 bg-red-50 text-red-600 px-4 py-3 rounded-xl font-bold text-sm transition">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Daftar Mata Pelajaran
                    </a>
                    <a href="#" class="flex items-center gap-3 text-gray-700 hover:bg-gray-50 px-4 py-3 rounded-xl font-medium text-sm transition">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Transkrip Nilai
                    </a>
                    <a href="#" class="flex items-center gap-3 text-gray-700 hover:bg-gray-50 px-4 py-3 rounded-xl font-medium text-sm transition">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Kalender Akademik
                    </a>
                </nav>
            </div>

            <div class="flex-none p-4 border-t border-gray-100 bg-white">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" 
                    onclick="event.preventDefault(); this.closest('form').submit();" 
                    class="flex items-center gap-3 text-red-600 hover:bg-red-50 px-4 py-3 rounded-xl font-bold text-sm transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Keluar Dashboard
                    </a>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-4 md:p-10 bg-[#fdfaf6] w-full">
            <div class="max-w-5xl mx-auto">
                <div class="mb-6 md:mb-8">
                    <h1 class="text-2xl md:text-[28px] font-bold text-gray-900 mb-1">Daftar Mata Pelajaran</h1>
                    <p class="text-red-600 font-semibold text-sm">Tahun Pelajaran 2026/2027</p>
                </div>
                <div class="space-y-4">
                    @forelse($subjects as $subject)
                    <div class="bg-white border border-gray-200 rounded-2xl p-4 flex flex-col md:flex-row md:items-center justify-between shadow-sm hover:border-red-200 transition gap-4">
                        
                        <div class="flex flex-col md:flex-row md:items-center flex-1 gap-2 md:gap-4">
                            <div class="text-red-600 font-bold w-full md:w-28 shrink-0 text-xs md:text-sm">
                                {{ $subject->code }}
                            </div>
                            
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900 text-sm md:text-[15px]">{{ $subject->title }}</h3>
                                <p class="text-gray-500 text-xs mt-0.5">Sensei: {{ $subject->sensei ?? 'Belum ada guru' }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 md:gap-4 shrink-0 border-t border-gray-100 md:border-none pt-3 md:pt-0 mt-1 md:mt-0">
                            <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-md text-xs font-bold">{{ $subject->jp }}</span>
                            
                            <span class="{{ $subject->status == 'Aktif' ? 'bg-[#bbf7d0] text-green-700' : 'bg-gray-200 text-gray-600' }} px-3 py-1 rounded-md text-xs font-bold">
                                {{ $subject->status }}
                            </span>

                            <a href="{{ route('subjects.show', $subject->slug ?? '#') }}" class="text-red-600 font-bold text-sm flex items-center gap-1 hover:text-red-800 ml-auto md:ml-2 group">
                                Lihat Modul
                                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 bg-white rounded-2xl border border-dashed border-gray-300">
                        <p class="text-gray-500 italic">Belum ada mata pelajaran yang tersedia untuk kelas ini.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <footer class="bg-[#2b2e33] text-gray-300 py-8 md:py-12 px-4 md:px-10">
        <div class="max-w-7xl mx-auto border-t border-gray-600 mt-8 pt-4 flex flex-col md:flex-row justify-between items-center text-xs text-center md:text-left gap-2">
            <p>Copyright @2026 LPK Seishin Cakrabuana | Developed by AC Digimar</p>
        </div>
    </footer>
</div>

<script>
    const hamburgerBtn = document.getElementById('hamburger');
    const closeSidebarBtn = document.getElementById('close-sidebar');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
        overlay.classList.toggle('opacity-0');
        overlay.classList.toggle('pointer-events-none');

        // Mencegah body di belakang ikut scroll saat sidebar buka (khusus mobile)
        if (!sidebar.classList.contains('-translate-x-full')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
    }

    // Event Listeners
    hamburgerBtn.addEventListener('click', toggleSidebar);
    closeSidebarBtn.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar); // Klik area gelap otomatis nutup
</script>

</body>
</html>