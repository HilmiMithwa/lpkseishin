@php
    // 🌟 FRONTEND STATE: Data Dummy Terpusat (Jangan Hardcode di HTML)
    $userData = (object) [
        'name' => 'Ahmad Hidayat',
        'id_number' => '022025005',
        'batch' => 'Batch 5',
        'level' => 'Pra-N5',
        'email' => 'madd.hdyt@gmail.com',
        'phone' => '+62 0831 9210 3301',
        'dob' => '04 July 2004',
        'education' => 'SMA/SMK',
        'height_weight' => '160 cm / 59 kg',
        'emergency_name' => 'Muria Mardika',
        'emergency_phone' => '+62 0831 9210 3302',
        // Fallback ke UI Avatars jika tidak ada foto
        'avatar_url' => 'https://ui-avatars.com/api/?name=Ahmad+Hidayat&background=f3f4f6&color=DB2A2A&size=200' 
    ];

    // Data Sidebar Fallback
    $userName = Auth::user() ? Auth::user()->name : $userData->name;
    $userLevel = Auth::user() && isset(Auth::user()->level) ? Auth::user()->level : 'Level ' . $userData->level;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - LPK Seishin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #e5e7eb; border-radius: 20px; }
    </style>
</head>
<body class="bg-[#FFF9F4] text-[#444444] h-screen flex overflow-hidden">

    <aside id="sidebar" class="fixed lg:static left-0 top-0 w-64 h-screen lg:h-auto bg-[#FFF9F4] flex flex-col flex-none z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-lg lg:shadow-none">
        <div class="p-6">
            @if(View::exists('components.application-logo'))
                <x-application-logo class="h-14 w-auto" />
            @else
                <div class="text-[#DB2A2A] font-extrabold text-xl tracking-wider">SEISHIN</div>
            @endif
        </div>

        <div class="px-4 mt-2 flex-1">
            <p class="text-xs font-bold text-[#666666] mb-3 px-2 tracking-wider">OVERVIEW</p>
            <nav class="space-y-1 mb-6">
                <a href="{{ route('students.dashboard') }}" class="flex items-center gap-3 text-[#222222] hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 text-[#222222] hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Enrolled
                </a>
                <a href="#" class="flex items-center gap-3 text-[#222222] hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    My Task
                </a>
                <a href="{{ route('students.vocabulary-mastery') }}" class="flex items-center gap-3 text-[#222222] hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                    Vocabulary Mastery
                </a>
            </nav>

            <p class="text-xs font-bold text-[#666666] mb-3 px-2 tracking-wider">SYSTEM</p>
            <nav class="space-y-1">
                <a href="{{ route('students.profile') }}" class="flex items-center gap-3 bg-[#FFDBDB] text-[#DB2A2A] px-4 py-3 rounded-xl font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profile
                </a>
                <a href="#" class="flex items-center gap-3 text-[#222222] hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Setting
                </a>
            </nav>
        </div>

        <div class="p-4">
            <div class="bg-white border border-gray-100 rounded-2xl p-3 flex items-center gap-3 shadow-sm mb-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($userName) }}&background=f3f4f6&color=DB2A2A" class="w-10 h-10 rounded-full">
                <div class="overflow-hidden text-left">
                    <h4 class="font-bold text-[13px] text-[#444444] truncate">{{ $userName }}</h4>
                    <p class="text-[10px] text-[#666666] truncate">{{ $userLevel }}</p>
                </div>
            </div>
            <button class="w-full flex items-center justify-center gap-2 text-[#DB2A2A] bg-white border border-gray-200 hover:bg-[#FFDBDB] py-2.5 rounded-xl font-bold text-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </button>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden relative">
        
        <header class="flex justify-between items-center px-4 lg:px-8 py-4 lg:py-6 bg-transparent">
            <div>
                <h2 class="text-base lg:text-lg font-bold text-[#444444]">こんにちわ, {{ explode(' ', $userName)[0] }}! 👋</h2>
                <p id="realtime-clock" class="text-xs text-[#666666] font-medium mt-0.5">Memuat waktu...</p>
            </div>
            <div class="flex items-center gap-4 hidden sm:flex">
                <button class="text-[#666666] hover:text-[#444444] relative transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute -top-1 -right-1 bg-[#DB2A2A] text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">27</span>
                </button>
                <div class="flex items-center gap-1.5 text-sm font-bold text-[#444444] cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                    EN ▾
                </div>
            </div>
        </header>

        <main class="flex-1 bg-white rounded-t-[20px] lg:rounded-[40px] mr-0 lg:mr-8 mb-0 lg:mb-8 overflow-y-auto shadow-sm custom-scrollbar relative flex flex-col">
            <div class="p-6 lg:p-10">
                
                <div class="mb-8 text-left">
                    <h1 class="text-3xl lg:text-4xl font-black text-[#444444] tracking-tight">Profile</h1>
                    <p class="text-xs lg:text-sm font-bold text-[#666666] mt-2">Manage your personal information and account settings.</p>
                </div>
                <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] mb-6 flex flex-col sm:flex-row items-center sm:items-start gap-6 lg:gap-8 relative">
                    
                    <div class="relative flex-shrink-0 mt-2 sm:mt-0">
                        <img src="{{ $userData->avatar_url }}" alt="Profile Picture" class="w-28 h-28 lg:w-32 lg:h-32 rounded-full object-cover shadow-sm">
                        <button class="absolute top-1 right-1 w-8 h-8 bg-white border border-gray-100 text-[#DB2A2A] rounded-full shadow-sm flex items-center justify-center hover:bg-gray-50 transition transform translate-x-2 -translate-y-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                    </div>

                    <div class="flex-1 text-center sm:text-left space-y-2 lg:pt-2">
                        <h2 class="text-3xl lg:text-[32px] font-black text-[#444444] tracking-tight">{{ $userData->name }}</h2>
                        
                        <div class="text-[15px] font-bold text-[#666666] space-y-1.5 mx-auto sm:mx-0 w-fit sm:w-auto text-left">
                            <div class="flex items-center">
                                <span class="w-14">ID</span>
                                <span class="w-6 text-center">:</span>
                                <span class="text-[#666666]">{{ $userData->id_number }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="w-14">Batch</span>
                                <span class="w-6 text-center">:</span>
                                <span class="text-[#444444]">{{ $userData->batch }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="sm:absolute sm:right-8 sm:top-1/2 sm:-translate-y-1/2 mt-4 sm:mt-0">
                        <span class="bg-[#DB2A2A] text-white text-sm font-bold px-6 py-2.5 rounded-full shadow-sm">
                            Level: {{ $userData->level }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    
                    <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col justify-between">
                        <h3 class="text-lg font-black text-[#444444] mb-6">Personal Details</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-[#666666]">Full Name:</label>
                                <input type="text" value="{{ $userData->name }}" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#444444] focus:outline-none focus:border-[#DB2A2A] transition">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-[#666666]">Email:</label>
                                <input type="email" value="{{ $userData->email }}" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#444444] focus:outline-none focus:border-[#DB2A2A] transition">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-[#666666]">Phone Number:</label>
                                <input type="text" value="{{ $userData->phone }}" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#444444] focus:outline-none focus:border-[#DB2A2A] transition">
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-[#666666]">Date of Birth:</label>
                                <input type="text" value="{{ $userData->dob }}" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#444444] focus:outline-none focus:border-[#DB2A2A] transition">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button class="bg-[#DB2A2A] hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-sm">
                                Save Changes
                            </button>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col">
                        <h3 class="text-lg font-black text-[#444444] mb-6">LPK Requirements</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 flex-1">
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-[#666666]">Education Level:</label>
                                <div class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-2.5 text-sm font-bold text-[#666666] select-none cursor-not-allowed">
                                    {{ $userData->education }}
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-[#666666]">Height / Weight:</label>
                                <div class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-2.5 text-sm font-bold text-[#666666] select-none cursor-not-allowed">
                                    {{ $userData->height_weight }}
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-[#666666]">Emergency Contact Name:</label>
                                <div class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-2.5 text-sm font-bold text-[#666666] select-none cursor-not-allowed">
                                    {{ $userData->emergency_name }}
                                </div>
                            </div>
                            <div class="space-y-1.5">
                                <label class="text-xs font-bold text-[#666666]">Emergency Contact Phone:</label>
                                <div class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-2.5 text-sm font-bold text-[#666666] select-none cursor-not-allowed">
                                    {{ $userData->emergency_phone }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
                    <h3 class="text-lg font-black text-[#444444] mb-6">Change Password</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-5 items-end">
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-[#666666]">Current Password</label>
                            <input type="password" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#444444] focus:outline-none focus:border-[#DB2A2A] transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-[#666666]">New Password</label>
                            <input type="password" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#444444] focus:outline-none focus:border-[#DB2A2A] transition">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-[#666666]">Confirm Password</label>
                            <input type="password" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#444444] focus:outline-none focus:border-[#DB2A2A] transition">
                        </div>
                        <div>
                            <button class="w-full bg-[#DB2A2A] hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-sm">
                                Update Password
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <script>
        function updateClock() {
            const clockElement = document.getElementById('realtime-clock');
            if (!clockElement) return;
            const now = new Date();
            const dateString = now.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
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