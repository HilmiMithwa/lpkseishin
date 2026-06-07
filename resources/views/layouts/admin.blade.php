<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Admin - LPK Seishin')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    
    <style>
        .banner-red {
            background: linear-gradient(90deg, #d62828 0%, #d62828 50%, #8b1a1a 100%);
            position: relative;
            overflow: hidden;
        }
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
            opacity: 0.15;
            z-index: 0;
            pointer-events: none;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 20px; }

        /* Sidebar Minimize Styles */
        #sidebar {
            transition: width 0.3s ease, transform 0.3s ease;
        }
        @media (min-width: 1024px) {
            #sidebar.minimized {
                width: 5.5rem;
            }
            #sidebar.minimized .sidebar-text {
                display: none !important;
            }
            #sidebar.minimized .nav-link {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }
            #sidebar.minimized .nav-link svg {
                margin-left: 0;
                margin-right: 0;
            }
            #sidebar.minimized .user-card {
                padding: 0.5rem;
                background: transparent;
                border-color: transparent;
                box-shadow: none;
                justify-content: center;
            }
            #sidebar.minimized .user-card img {
                margin: 0;
            }
            #sidebar.minimized .logo-wrapper {
                padding: 1.5rem 0;
                display: flex;
                justify-content: center;
            }
            #sidebar.minimized .logo-full {
                display: none;
            }
            #sidebar.minimized .logo-small {
                display: block;
                width: 2.5rem;
                height: 2.5rem;
                object-fit: contain;
            }
            #sidebar.minimized .logout-btn {
                justify-content: center;
                padding-left: 0;
                padding-right: 0;
            }
        }
        .logo-small {
            display: none;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#FFF9F4] font-karla text-[#444444] h-screen flex overflow-hidden">

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-30 hidden lg:hidden transition-opacity opacity-0 duration-300"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed lg:static left-0 top-0 w-64 h-screen lg:h-auto bg-[#FFF9F4] flex flex-col flex-none z-50 transform -translate-x-full lg:translate-x-0 overflow-hidden transition-transform duration-300">
        <div class="p-6 logo-wrapper flex items-center justify-between h-[88px]">
            <div class="flex items-center">
                <div class="logo-full">
                    <x-application-logo class="h-12 w-auto" />
                </div>
                <img src="https://res.cloudinary.com/dz8fs7rp1/image/upload/v1780409565/logo-notext_kywvap.png" class="logo-small" alt="Logo">
            </div>
            
            <button id="mobile-menu-close" class="lg:hidden p-2 text-[#444444] hover:text-[#d62828] bg-white border border-gray-100 shadow-sm rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="px-4 mt-2 flex-1">
            <p class="sidebar-text text-[10px] font-bold text-[#666666] mb-3 px-2 tracking-widest uppercase transition-opacity">RINGKASAN</p>
            <nav class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="nav-link flex items-center gap-3 {{ request()->routeIs('admin.dashboard') ? 'bg-[#FFDBDB] text-[#d62828]' : 'text-[#444444] hover:bg-gray-50 hover:text-[#222222]' }} px-4 py-3 rounded-xl font-bold text-sm transition">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Beranda</span>
                </a>
            </nav>

            <p class="sidebar-text text-[10px] font-bold text-[#666666] mb-3 px-2 tracking-widest mt-6 uppercase transition-opacity">SISTEM</p>
            <nav class="space-y-1">
                <div x-data="{ open: {{ request()->routeIs(['admin.users', 'admin.users.*']) ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open; if(document.getElementById('sidebar').classList.contains('minimized')) document.getElementById('desktop-sidebar-toggle').click()" type="button" class="w-full nav-link flex items-center justify-between {{ request()->routeIs(['admin.users', 'admin.users.*']) ? 'bg-[#FFDBDB] text-[#d62828]' : 'text-[#444444] hover:bg-gray-50 hover:text-[#222222]' }} px-4 py-3 rounded-xl font-{{ request()->routeIs(['admin.users', 'admin.users.*']) ? 'bold' : 'semibold' }} text-sm transition focus:outline-none">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span class="sidebar-text whitespace-nowrap">Manajemen User</span>
                        </div>
                        <svg class="w-4 h-4 sidebar-text transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200" 
                         x-transition:enter-start="opacity-0 -translate-y-2" 
                         x-transition:enter-end="opacity-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-150" 
                         x-transition:leave-start="opacity-100 translate-y-0" 
                         x-transition:leave-end="opacity-0 -translate-y-2" 
                         class="pl-12 pr-4 py-2 space-y-3 sidebar-text" style="display: none;">
                        <a href="{{ route('admin.users') }}?role=siswa" class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13.5px] font-medium {{ (request('role') == 'siswa' || request()->routeIs('admin.users.edit')) ? 'bg-red-50/50 text-[#d62828] font-bold' : 'text-[#666666] hover:bg-gray-50 hover:text-[#d62828]' }} transition-all">
                            <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ (request('role') == 'siswa' || request()->routeIs('admin.users.edit')) ? 'bg-[#d62828]' : 'bg-gray-300' }}"></span>
                            <span>Data Siswa</span>
                        </a>
                        <a href="{{ route('admin.users') }}?role=guru" class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13.5px] font-medium {{ request('role') == 'guru' ? 'bg-red-50/50 text-[#d62828] font-bold' : 'text-[#666666] hover:bg-gray-50 hover:text-[#d62828]' }} transition-all">
                            <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ request('role') == 'guru' ? 'bg-[#d62828]' : 'bg-gray-300' }}"></span>
                            <span>Data Guru</span>
                        </a>
                        <a href="{{ route('admin.users') }}?role=admin" class="flex items-center gap-3 px-3 py-2 rounded-lg text-[13.5px] font-medium {{ request('role') == 'admin' ? 'bg-red-50/50 text-[#d62828] font-bold' : 'text-[#666666] hover:bg-gray-50 hover:text-[#d62828]' }} transition-all">
                            <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ request('role') == 'admin' ? 'bg-[#d62828]' : 'bg-gray-300' }}"></span>
                            <span>Data Admin</span>
                        </a>
                    </div>
                </div>
                
                <a href="{{ route('admin.registrations.index') }}" class="nav-link flex items-center gap-3 {{ request()->routeIs(['admin.registrations.index', 'admin.registrations.*']) ? 'bg-[#FFDBDB] text-[#d62828]' : 'text-[#444444] hover:bg-gray-50 hover:text-[#222222]' }} px-4 py-3 rounded-xl font-{{ request()->routeIs(['admin.registrations.index', 'admin.registrations.*']) ? 'bold' : 'semibold' }} text-sm transition">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Pendaftaran Siswa</span>
                </a>

                <a href="{{ route('admin.batches') }}" class="nav-link flex items-center gap-3 {{ request()->routeIs(['admin.batches', 'admin.batches.*']) ? 'bg-[#FFDBDB] text-[#d62828]' : 'text-[#444444] hover:bg-gray-50 hover:text-[#222222]' }} px-4 py-3 rounded-xl font-{{ request()->routeIs(['admin.batches', 'admin.batches.*']) ? 'bold' : 'semibold' }} text-sm transition">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Manajemen Batch</span>
                </a>

                <a href="{{ route('admin.programs') }}" class="nav-link flex items-center gap-3 {{ request()->routeIs(['admin.programs', 'admin.programs.*']) ? 'bg-[#FFDBDB] text-[#d62828]' : 'text-[#444444] hover:bg-gray-50 hover:text-[#222222]' }} px-4 py-3 rounded-xl font-{{ request()->routeIs(['admin.programs', 'admin.programs.*']) ? 'bold' : 'semibold' }} text-sm transition">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Manajemen Program</span>
                </a>

                <a href="{{ route('admin.payments') }}" class="nav-link flex items-center gap-3 {{ request()->routeIs(['admin.payments', 'admin.payments.*']) ? 'bg-[#FFDBDB] text-[#d62828]' : 'text-[#444444] hover:bg-gray-50 hover:text-[#222222]' }} px-4 py-3 rounded-xl font-{{ request()->routeIs(['admin.payments', 'admin.payments.*']) ? 'bold' : 'semibold' }} text-sm transition">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Manajemen Pembayaran</span>
                </a>

                <a href="{{ route('admin.bank_accounts') }}" class="nav-link flex items-center gap-3 {{ request()->routeIs(['admin.bank_accounts', 'admin.bank_accounts.*']) ? 'bg-[#FFDBDB] text-[#d62828]' : 'text-[#444444] hover:bg-gray-50 hover:text-[#222222]' }} px-4 py-3 rounded-xl font-{{ request()->routeIs(['admin.bank_accounts', 'admin.bank_accounts.*']) ? 'bold' : 'semibold' }} text-sm transition">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Rekening Bank</span>
                </a>

                <a href="{{ route('admin.profile') }}" class="nav-link flex items-center gap-3 {{ request()->routeIs('admin.profile') ? 'bg-[#FFDBDB] text-[#d62828]' : 'text-[#444444] hover:bg-gray-50 hover:text-[#222222]' }} px-4 py-3 rounded-xl font-{{ request()->routeIs('admin.profile') ? 'bold' : 'semibold' }} text-sm transition">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Profil</span>
                </a>
            </nav>
        </div>

        <div class="p-4 border-t border-gray-100/50">
            <div class="user-card bg-white border border-gray-100/50 rounded-2xl p-3 flex items-center gap-3 shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)] mb-3 transition-all duration-300">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=f3f4f6&color=d62828&bold=true" class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                <div class="sidebar-text overflow-hidden">
                    <h4 class="font-bold text-[13px] text-[#222222] truncate">{{ Auth::user()->name ?? 'Admin' }}</h4>
                    <p class="text-[10px] text-[#666666] truncate flex items-center gap-1 mt-0.5">
                        <span class="text-[#d62828] font-bold text-[11px]">@</span> <span class="truncate">{{ Auth::user()->email ?? 'admin@lpkseishin.com' }}</span>
                    </p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn w-full flex items-center gap-2 text-[#d62828] bg-white border border-gray-100 hover:bg-[#FFDBDB] py-2.5 px-4 rounded-xl font-bold text-sm transition shadow-sm">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span class="sidebar-text whitespace-nowrap">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden relative z-10">
        
        <!-- Header -->
        <header class="flex flex-col px-4 lg:px-8 py-4 lg:py-6 bg-transparent gap-4 lg:gap-6">
            
            <!-- Mobile Top Bar (Visible only on mobile) -->
            <div class="flex lg:hidden items-center justify-between w-full">
                <!-- Hamburger -->
                <button id="mobile-menu-btn-inner" class="p-2 bg-white text-[#d62828] rounded-xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.1)] border border-gray-100 hover:bg-gray-50 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <!-- Notifications & Small Profile -->
                <div class="flex items-center gap-3">
                    <!-- Notifications Dropdown -->
                    <div class="relative dropdown-container">
                        <button class="dropdown-btn relative p-2 text-[#444444] hover:text-[#222222] transition rounded-full bg-white shadow-sm border border-gray-100 focus:outline-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute top-0.5 right-0.5 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-[#d62828] text-[8px] font-bold text-white ring-2 ring-white">2</span>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu absolute right-0 top-[calc(100%+0.5rem)] w-72 sm:w-80 bg-white rounded-3xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.12)] border border-gray-100 hidden opacity-0 transform scale-95 transition-all duration-200 origin-top-right z-50 overflow-hidden">
                            <!-- Header -->
                            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                                <h3 class="font-bold text-slate-800">Notifikasi Admin</h3>
                                <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full">2 Baru</span>
                            </div>
                            <!-- Footer -->
                            <div class="px-4 py-3 border-t border-gray-100 bg-white text-center">
                                <a href="#" class="text-[12px] font-bold text-[#d62828] hover:text-red-800 transition">Lihat Semua Notifikasi</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative dropdown-container">
                        <button class="dropdown-btn focus:outline-none flex items-center group">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=f3f4f6&color=d62828&bold=true" class="w-9 h-9 rounded-full border-2 border-white shadow-sm object-cover group-hover:border-red-500/20 transition">
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu absolute right-0 top-[calc(100%+0.5rem)] w-64 bg-white rounded-3xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] border border-gray-100 p-2 hidden opacity-0 transform scale-95 transition-all duration-200 origin-top-right z-50">
                            
                            <!-- Profile Header -->
                            <div class="flex items-center gap-3 px-3 pt-2 pb-3 mb-1">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=f3f4f6&color=d62828&bold=true" class="w-10 h-10 rounded-full border border-gray-100 shadow-sm object-cover flex-shrink-0">
                                <div class="overflow-hidden">
                                    <p class="text-[15px] font-bold text-slate-800 leading-snug truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                                    <p class="text-[13px] font-medium text-slate-500 mt-0.5 truncate">{{ Auth::user()->email ?? 'admin@lpkseishin.com' }}</p>
                                </div>
                            </div>
                            
                            <div class="h-px bg-gray-100 mb-2 mx-2"></div>
                            
                            <!-- Menu Items -->
                            <a href="#" class="flex items-center gap-3.5 px-2 py-2 rounded-2xl hover:bg-gray-50 transition group">
                                <div class="w-10 h-10 rounded-[14px] bg-slate-50 flex items-center justify-center group-hover:bg-white border border-transparent group-hover:border-gray-100 shadow-sm shadow-transparent group-hover:shadow-gray-200/50 transition-all">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <span class="text-[13.5px] font-bold text-slate-700">Pengaturan Profil</span>
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3.5 px-2 py-2 rounded-2xl hover:bg-rose-50/50 transition group">
                                    <div class="w-10 h-10 rounded-[14px] bg-rose-50 flex items-center justify-center group-hover:bg-white border border-transparent group-hover:border-rose-100 shadow-sm shadow-transparent group-hover:shadow-rose-200/50 transition-all">
                                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    </div>
                                    <span class="text-[13.5px] font-bold text-rose-500">Keluar Aplikasi</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header Main Section (Greeting & Desktop Items) -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between w-full gap-4">
                <!-- Left: Greeting -->
                <div class="flex items-center gap-4">
                    <button id="desktop-sidebar-toggle" class="hidden lg:flex p-1.5 text-[#666666] hover:text-[#222222] bg-white border border-gray-200 rounded-lg shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-[#d62828]/20" title="Toggle Sidebar">
                        <svg class="w-5 h-5 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 16.75a3.5 3.5 0 0 1-3.5 3.5h-9.5a3.5 3.5 0 0 1-3.5-3.5v-9.5a3.5 3.5 0 0 1 3.5-3.5h9.5a3.5 3.5 0 0 1 3.5 3.5zm-5.797 3.5V3.75M8.96 14.25L6.75 12m0 0l2.21-2.25M6.75 12h4.7" />
                        </svg>
                    </button>
                    <div>
                        <h2 class="text-xl lg:text-lg font-bold text-[#222222] flex items-center gap-1">
                            こんにちわ, 
                            <span class="hidden sm:inline">{{ Auth::user()->name ?? 'Admin' }}! 👋</span>
                            <span class="sm:hidden">{{ substr(Auth::user()->name ?? 'Admin', 0, 10) }}! 👋</span>
                        </h2>
                        <p id="realtime-clock" class="text-xs text-[#666666] font-medium mt-0.5">Memuat waktu...</p>
                    </div>
                </div>

                <!-- Right: Desktop Notifications & Profile -->
                <div class="hidden lg:flex items-center justify-end gap-5 w-full lg:w-auto">
                    


                    <!-- Notifications Dropdown -->
                    <div class="relative dropdown-container">
                        <button class="dropdown-btn relative p-2 text-[#444444] hover:text-[#222222] transition rounded-full hover:bg-white shadow-sm focus:outline-none border border-transparent hover:border-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute top-1 right-1 flex h-3.5 w-3.5 items-center justify-center rounded-full bg-[#d62828] text-[8px] font-bold text-white ring-2 ring-[#FFF9F4]">2</span>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu absolute right-0 top-[calc(100%+0.5rem)] w-72 sm:w-80 bg-white rounded-3xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.12)] border border-gray-100 hidden opacity-0 transform scale-95 transition-all duration-200 origin-top-right z-50 overflow-hidden">
                            <!-- Header -->
                            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                                <h3 class="font-bold text-slate-800">Notifikasi Admin</h3>
                                <span class="bg-red-100 text-red-700 text-[10px] font-bold px-2 py-0.5 rounded-full">2 Baru</span>
                            </div>
                            <!-- Footer -->
                            <div class="px-4 py-3 border-t border-gray-100 bg-white text-center">
                                <a href="#" class="text-[12px] font-bold text-[#d62828] hover:text-red-800 transition">Lihat Semua Notifikasi</a>
                            </div>
                        </div>
                    </div>

                    <!-- Small Profile -->
                    <div class="relative hidden sm:flex items-center pl-3 border-l border-gray-200 dropdown-container">
                        <button class="dropdown-btn flex items-center gap-3 focus:outline-none group">
                            <span class="text-sm font-bold text-[#222222] group-hover:text-[#d62828] transition">{{ Auth::user()->name ?? 'Admin' }}</span>
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=f3f4f6&color=d62828&bold=true" class="w-9 h-9 rounded-full border-2 border-white shadow-sm object-cover group-hover:border-red-500/20 transition">
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu absolute right-0 top-[calc(100%+0.5rem)] w-64 bg-white rounded-3xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] border border-gray-100 p-2 hidden opacity-0 transform scale-95 transition-all duration-200 origin-top-right z-50">
                            
                            <!-- Profile Header -->
                            <div class="flex items-center gap-3 px-3 pt-2 pb-3 mb-1">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=f3f4f6&color=d62828&bold=true" class="w-10 h-10 rounded-full border border-gray-100 shadow-sm object-cover flex-shrink-0">
                                <div class="overflow-hidden">
                                    <p class="text-[15px] font-bold text-slate-800 leading-snug truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                                    <p class="text-[13px] font-medium text-slate-500 mt-0.5 truncate">{{ Auth::user()->email ?? 'admin@lpkseishin.com' }}</p>
                                </div>
                            </div>
                            
                            <div class="h-px bg-gray-100 mb-2 mx-2"></div>
                            
                            <!-- Menu Items -->
                            <a href="#" class="flex items-center gap-3.5 px-2 py-2 rounded-2xl hover:bg-gray-50 transition group">
                                <div class="w-10 h-10 rounded-[14px] bg-slate-50 flex items-center justify-center group-hover:bg-white border border-transparent group-hover:border-gray-100 shadow-sm shadow-transparent group-hover:shadow-gray-200/50 transition-all">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <span class="text-[13.5px] font-bold text-slate-700">Pengaturan Profil</span>
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3.5 px-2 py-2 rounded-2xl hover:bg-rose-50/50 transition group">
                                    <div class="w-10 h-10 rounded-[14px] bg-rose-50 flex items-center justify-center group-hover:bg-white border border-transparent group-hover:border-rose-100 shadow-sm shadow-transparent group-hover:shadow-rose-200/50 transition-all">
                                        <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    </div>
                                    <span class="text-[13.5px] font-bold text-rose-500">Keluar Aplikasi</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 bg-white rounded-t-[20px] lg:rounded-[40px] lg:mx-8 mb-0 lg:mb-4 overflow-y-auto shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] custom-scrollbar relative">
            @yield('content')
        </main>
    </div>

    <script>
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenuBtnInner = document.getElementById('mobile-menu-btn-inner');
        const mobileMenuClose = document.getElementById('mobile-menu-close');
        const desktopSidebarToggle = document.getElementById('desktop-sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');

        // Desktop Toggle
        if (desktopSidebarToggle) {
            desktopSidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('minimized');
                
                // Rotate icon 180deg
                const icon = desktopSidebarToggle.querySelector('svg');
                icon.classList.toggle('rotate-180');
            });
        }

        const openMenu = () => {
            sidebar.classList.remove('-translate-x-full');
            if (sidebarOverlay) {
                sidebarOverlay.classList.remove('hidden');
                setTimeout(() => sidebarOverlay.classList.remove('opacity-0'), 10);
            }
        };

        const closeMenu = () => {
            sidebar.classList.add('-translate-x-full');
            if (sidebarOverlay) {
                sidebarOverlay.classList.add('opacity-0');
                setTimeout(() => sidebarOverlay.classList.add('hidden'), 300);
            }
        };

        if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openMenu);
        if (mobileMenuBtnInner) mobileMenuBtnInner.addEventListener('click', openMenu);
        if (mobileMenuClose) mobileMenuClose.addEventListener('click', closeMenu);
        if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeMenu);

        // Don't auto-close menu on desktop when clicking links, and only close on anchor tags
        document.querySelectorAll('#sidebar a.nav-link').forEach(link => {
            link.addEventListener('click', () => {
                if(window.innerWidth < 1024) { // Only auto close on mobile
                    closeMenu();
                }
            });
        });

        // Generic Dropdowns (Profile & Notifications)
        document.querySelectorAll('.dropdown-container').forEach(container => {
            const btn = container.querySelector('.dropdown-btn');
            const menu = container.querySelector('.dropdown-menu');
            
            if (btn && menu) {
                btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isHidden = menu.classList.contains('hidden');
                    
                    // Close all other dropdowns first
                    document.querySelectorAll('.dropdown-menu:not(.hidden)').forEach(openMenu => {
                        if (openMenu !== menu) {
                            openMenu.classList.remove('opacity-100', 'scale-100');
                            openMenu.classList.add('opacity-0', 'scale-95');
                            setTimeout(() => openMenu.classList.add('hidden'), 200);
                        }
                    });

                    if (isHidden) {
                        menu.classList.remove('hidden');
                        setTimeout(() => {
                            menu.classList.remove('opacity-0', 'scale-95');
                            menu.classList.add('opacity-100', 'scale-100');
                        }, 10);
                    } else {
                        menu.classList.remove('opacity-100', 'scale-100');
                        menu.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => {
                            menu.classList.add('hidden');
                        }, 200);
                    }
                });
            }
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            document.querySelectorAll('.dropdown-container').forEach(container => {
                const btn = container.querySelector('.dropdown-btn');
                const menu = container.querySelector('.dropdown-menu');
                
                if (btn && menu && !btn.contains(e.target) && !menu.contains(e.target) && !menu.classList.contains('hidden')) {
                    menu.classList.remove('opacity-100', 'scale-100');
                    menu.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => {
                        menu.classList.add('hidden');
                    }, 200);
                }
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
            const clockElement = document.getElementById('realtime-clock');
            if (clockElement) {
                clockElement.innerText = `${dateString} • ${timeString}`;
            }
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
    
    {{-- Global Page Loading Transition --}}
    <div x-data="{ pageLoading: false }"
         @page-loading.window="pageLoading = true"
         @page-loaded.window="pageLoading = false"
         x-show="pageLoading"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[9999] bg-[#FFF9F4]/90 backdrop-blur-md flex flex-col items-center justify-center"
         style="display: none;" x-cloak>
         
         <div class="relative flex items-center justify-center w-24 h-24 mb-4">
             <div class="absolute inset-0 bg-[#d62828]/20 rounded-full animate-ping opacity-75 duration-1000"></div>
             <img src="https://res.cloudinary.com/dz8fs7rp1/image/upload/v1780409565/logo-notext_kywvap.png" class="w-14 h-14 object-contain relative z-10" alt="LPK Seishin">
         </div>
         <h2 class="text-xs font-bold font-ibm text-[#d62828] tracking-[0.2em] uppercase animate-pulse mt-2">Memuat...</h2>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Restore state if returning from history
            window.dispatchEvent(new CustomEvent('page-loaded'));
            
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', (e) => {
                    const href = link.getAttribute('href');
                    const target = link.getAttribute('target');
                    if (href && !href.startsWith('#') && !href.startsWith('javascript:') && target !== '_blank' && !e.ctrlKey && !e.metaKey) {
                        window.dispatchEvent(new CustomEvent('page-loading'));
                    }
                });
            });

            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', (e) => {
                    if(!e.defaultPrevented) {
                        window.dispatchEvent(new CustomEvent('page-loading'));
                    }
                });
            });
            
            window.addEventListener('pageshow', (e) => {
                window.dispatchEvent(new CustomEvent('page-loaded'));
            });
        });
    </script>
    {{-- Global Toast Notification --}}
    <div x-data="{ show: false, message: '' }" 
         @show-toast.window="
            message = $event.detail.message;
            show = true;
            setTimeout(() => show = false, 3000);
         "
         class="fixed bottom-6 right-6 z-[110] flex flex-col gap-2 pointer-events-none"
         style="z-index: 99999;">
        
        <div x-show="show" style="display: none;"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-4"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-2xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 flex items-center p-4 gap-4 border border-gray-100">
             
             <!-- Success Icon -->
             <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-50 flex items-center justify-center">
                 <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                 </svg>
             </div>
             
             <!-- Text -->
             <div class="flex-1">
                 <p class="text-sm font-bold font-ibm text-gray-900" x-text="message"></p>
                 <p class="text-xs font-karla text-gray-500 mt-0.5">Berhasil diproses.</p>
             </div>
             
             <!-- Close -->
             <button @click="show = false" class="text-gray-400 hover:text-gray-500 transition">
                 <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                     <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                 </svg>
             </button>
        </div>
    </div>

    @stack('modals')
    @stack('scripts')
</body>
</html>
