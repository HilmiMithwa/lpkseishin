<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $task->judul_tugas ?? 'Detail Tugas' }} - LPK Seishin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
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
            <p class="text-xs font-bold text-[#444444] mb-3 px-2 tracking-wider">RINGKASAN</p>
            <nav class="space-y-1">
                <a href="{{ route('students.dashboard') }}" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Beranda
                </a>
                <a href="#" class="flex items-center gap-3 text-[#222222] hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Terdaftar
                </a>
                <a href="{{ route('students.tasks') }}" class="flex items-center gap-3 bg-[#FFDBDB] text-[#DB2A2A] px-4 py-3 rounded-xl font-bold text-sm">
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
            <div class="p-6 lg:p-10 space-y-6">
                
                <nav class="text-xs font-bold text-[#444444] uppercase tracking-widest text-left">
                    Terdaftar <span class="mx-2">></span> 
                    <a href="{{ route('subjects.show', $subject->id_mapel) }}" class="hover:text-[#DB2A2A] transition">{{ $subject->nama_mapel }}</a> 
                    <span class="mx-2">></span> 
                    <a href="{{ route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul]) }}" class="hover:text-[#DB2A2A] transition">{{ $currentModul->nama_modul }}</a> 
                    <span class="mx-2">></span> 
                    <span class="text-[#DB2A2A]">{{ $task->judul_tugas }}</span>
                </nav>

                <h1 class="text-2xl lg:text-3xl font-black text-[#222222] tracking-tight text-left">
                    {{ $task->judul_tugas }}
                </h1>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mt-6">
                    
                    <div class="lg:col-span-8 space-y-6">
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-left">
                            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Modul</p>
                                <p class="text-sm font-black text-[#222222] mt-1 truncate">{{ $currentModul->nama_modul }}</p>
                            </div>
                            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm flex justify-between items-center">
                                <div>
                                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Status Tugas</p>
                                    <p class="text-sm font-black text-[#222222] mt-1" id="task-status-text">
                                        {{ $submission && isset($submission->nilai) ? 'Sudah Dinilai' : ($submission ? 'Menunggu Penilaian' : 'Belum dikirim') }}
                                    </p>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Tenggat Waktu</p>
                                <p class="text-sm font-black text-[#222222] mt-1">
                                    {{ \Carbon\Carbon::parse($task->waktu_pengumpulan)->format('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm space-y-4">
                            <h3 class="text-base font-bold text-[#222222]">Deskripsi Tugas</h3>
                            <div class="text-sm text-[#444444] leading-relaxed font-medium space-y-3">
                                {!! $task->deskripsi_tugas !!}
                            </div>
                        </div>
                        @if(!empty($task->resource_file_name))
                            @php
                                $filePath = 'resources/' . $task->resource_file_name;
                                $exists = Illuminate\Support\Facades\Storage::disk('public')->exists($filePath);
                                
                                $fileSize = '0 KB';
                                if ($exists) {
                                    $bytes = Illuminate\Support\Facades\Storage::disk('public')->size($filePath);
                                    if ($bytes >= 1048576) {
                                        $fileSize = number_format($bytes / 1048576, 1) . ' MB';
                                    } elseif ($bytes >= 1024) {
                                        $fileSize = number_format($bytes / 1024, 0) . ' KB';
                                    } else {
                                        $fileSize = $bytes . ' Bytes';
                                    }
                                }
                                $extension = strtoupper(pathinfo($task->resource_file_name, PATHINFO_EXTENSION));
                            @endphp

                            <div class="space-y-3">
                                <h3 class="text-base font-bold text-[#222222]">Lampiran</h3>
                                <div class="p-4 bg-white border border-gray-100 rounded-[20px] flex items-center justify-between shadow-sm">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-10 h-10 bg-red-50 text-[#DB2A2A] rounded-xl flex items-center justify-center flex-shrink-0 font-bold text-xs uppercase">
                                            {{ $extension }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-bold text-gray-800 truncate">{{ $task->resource_file_name }}</p>
                                            <p class="text-[10px] text-gray-400 font-medium mt-0.5">{{ $fileSize }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($exists)
                                        <a href="{{ asset('storage/' . $filePath) }}" 
                                        download="{{ $task->resource_file_name }}"
                                        class="p-2 bg-gray-50 hover:bg-red-50 rounded-xl group transition flex-shrink-0"
                                        title="Download Resource">
                                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#DB2A2A] transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                        </a>
                                    @else
                                        <span class="text-[10px] text-red-400 font-semibold italic px-2">File tidak ditemukan</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>

                    <div class="lg:col-span-4 space-y-6">
                        
                        <div class="p-6 bg-white border border-gray-100 rounded-[28px] shadow-sm space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xs font-bold text-[#222222]">Tugas Anda</h3>
                                
                                <span class="text-[10px] font-bold uppercase tracking-wider {{ $submission ? 'text-green-500' : 'text-gray-400' }}" id="badge-status-top">
                                    {{ $submission ? 'Terkirim' : 'Belum Selesai' }}
                                </span>
                            </div>

                            <div id="file-list-container" class="space-y-3">
                                @if($submission && $submission->file_path)
                                    <div class="p-3 bg-white border border-gray-100 rounded-xl flex items-center justify-between gap-3 shadow-sm">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <div class="w-9 h-9 bg-red-50 text-[#DB2A2A] rounded-lg flex items-center justify-center flex-shrink-0 font-bold text-[10px]">FILE</div>
                                            <p class="text-xs font-bold text-gray-700 truncate">{{ basename($submission->file_path) }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <form id="multi-upload-form" action="{{ route('tasks.submit', ['id_mapel' => $id_mapel, 'id_modul' => $id_modul, 'id_tugas' => $task->id_tugas]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                
                                @if(!$submission)
                                    <div class="w-full">
                                        <textarea 
                                            name="text_content" 
                                            id="task-text-input" 
                                            rows="4" 
                                            class="w-full p-4 border border-gray-100 rounded-[20px] text-xs font-medium text-gray-700 placeholder-gray-400 focus:outline-none focus:border-[#DB2A2A] focus:ring-1 focus:ring-[#DB2A2A] resize-none bg-white transition custom-scrollbar" 
                                            placeholder="Tulis jawaban Anda di sini..."
                                            oninput="handleTextInputChange()"></textarea>
                                    </div>

                                    <div class="flex items-center justify-center my-1">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">ATAU</span>
                                    </div>

                                    <input type="file" id="task-file-input" name="task_files[]" class="hidden" multiple onchange="renderSelectedFiles(this)">

                                    <label for="task-file-input" class="w-full h-12 border border-[#DB2A2A] hover:bg-red-50/50 rounded-xl flex items-center justify-center gap-2 text-xs font-bold text-[#DB2A2A] cursor-pointer transition bg-white shadow-sm">
                                        <span class="text-sm font-semibold mb-[2px]">+</span>
                                        <span>Tambah File atau Tautan</span>
                                    </label>

                                    <button type="submit" id="main-submit-btn" class="w-full bg-[#DB2A2A] hover:bg-red-700 text-white font-bold py-2.5 rounded-xl text-xs shadow-sm transition duration-200">
                                        Tandai Selesai
                                    </button>
                                @else
                                    @if($submission->text_content)
                                        <div class="w-full">
                                            <div class="w-full p-4 border border-gray-50 rounded-[20px] text-xs font-medium text-gray-700 bg-gray-50/70 select-none text-left italic">
                                                {{ $submission->text_content }}
                                            </div>
                                        </div>
                                    @endif

                                    <button type="button" onclick="document.getElementById('cancel-form').submit()" class="w-full bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-2.5 rounded-xl text-xs shadow-sm transition duration-200">
                                        Batal Kirim
                                    </button>
                                @endif
                            </form>
                        </div>

                        <form id="cancel-form" action="{{ route('tasks.cancel', ['id_mapel' => $id_mapel, 'id_modul' => $id_modul, 'id_tugas' => $task->id_tugas]) }}" method="POST" class="hidden">
                            @csrf
                        </form>

                        <div class="bg-white border border-gray-100 rounded-[24px] p-4 px-6 shadow-sm flex items-center justify-between">
                            <h3 class="text-sm font-bold text-[#222222]">Nilai</h3>
                            <span class="text-xs font-bold text-gray-500">
                                @if($submission && isset($submission->nilai) && !is_null($submission->nilai)) 
                                    <span class="text-base font-black text-green-600">{{ $submission->nilai }}</span> / 100 
                                @else 
                                    Menunggu Penilaian 
                                @endif
                            </span>
                        </div>

                        <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm space-y-4">
                            <h3 class="text-sm font-bold text-[#222222]">Umpan Balik Sensei</h3>
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($guru->name ?? 'Sensei') }}&background=FFDBDB&color=DB2A2A" class="w-9 h-9 rounded-full flex-shrink-0">
                                <div>
                                    <h4 class="text-xs font-black text-[#222222]">{{ $guru->name ?? 'Sensei' }}</h4>
                                    <p class="text-[10px] text-gray-400 font-medium capitalize">Sensei</p>
                                </div>
                            </div>
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3.5 text-xs text-gray-500 font-medium min-h-[60px] flex items-center justify-center text-center">
                                @if($submission && !empty($submission->text_content))
                                    "{{ $submission->text_content }}"
                                @else
                                    Belum ada catatan
                                @endif
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

    if (mobileMenuBtn && mobileMenuClose && sidebar) {
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
    }

    function updateClock() {
        const clockElement = document.getElementById('realtime-clock');
        if (!clockElement) return;

        const now = new Date();
        const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const dateString = now.toLocaleDateString('id-ID', optionsDate);
        
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeString = `${hours}.${minutes}.${seconds}`;

        clockElement.innerText = `${dateString} • ${timeString}`;
    }

    setInterval(updateClock, 1000);
    updateClock();

    let selectedFilesArray = [];

    function handleTextInputChange() {
        const textInput = document.getElementById('task-text-input');
        const mainBtn = document.getElementById('main-submit-btn');
        if (!textInput || !mainBtn) return;

        if (selectedFilesArray.length > 0) {
            mainBtn.innerText = 'Kirim';
            return;
        }

        if (textInput.value.trim().length > 0) {
            mainBtn.innerText = 'Kirim';
        } else {
            mainBtn.innerText = 'Tandai Selesai';
        }
    }

    function renderSelectedFiles(input) {
        const container = document.getElementById('file-list-container');
        const mainBtn = document.getElementById('main-submit-btn');
        if (!container || !mainBtn) return;
        
        for (let i = 0; i < input.files.length; i++) {
            selectedFilesArray.push(input.files[i]);
        }

        container.innerHTML = '';
        selectedFilesArray.forEach((file, index) => {
            const ext = file.name.split('.').pop().toUpperCase();
            container.innerHTML += `
                <div class="p-3 bg-white border border-gray-100 rounded-xl flex items-center justify-between gap-3 shadow-sm">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 bg-red-50 text-[#DB2A2A] rounded-lg flex items-center justify-center flex-shrink-0 font-bold text-[10px]">${ext}</div>
                        <p class="text-xs font-bold text-gray-700 truncate">${file.name}</p>
                    </div>
                    <button type="button" onclick="removeFileFromList(${index})" class="text-gray-400 hover:text-red-500 font-bold text-sm px-1">✕</button>
                </div>
            `;
        });

        const dataTransfer = new DataTransfer();
        selectedFilesArray.forEach(f => dataTransfer.items.add(f));
        document.getElementById('task-file-input').files = dataTransfer.files;

        if (selectedFilesArray.length > 0 || document.getElementById('task-text-input').value.trim().length > 0) {
            mainBtn.innerText = 'Kirim';
        }
    }

    function removeFileFromList(index) {
        const mainBtn = document.getElementById('main-submit-btn');
        selectedFilesArray.splice(index, 1);
        
        const mockInput = { files: selectedFilesArray };
        renderSelectedFiles(mockInput);

        const textInput = document.getElementById('task-text-input');
        const textLength = textInput ? textInput.value.trim().length : 0;

        if (selectedFilesArray.length === 0 && textLength === 0 && mainBtn) {
            mainBtn.innerText = 'Tandai Selesai';
        }
    }
</script>
</body>
</html>