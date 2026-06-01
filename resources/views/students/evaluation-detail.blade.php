<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $evaluation->title }} - LPK Seishin</title>
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
                <a href="{{ route('students.dashboard') }}" class="flex items-center gap-3 text-[#222222] hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
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
            <div class="p-4 sm:p-6 lg:p-10 space-y-6">

                <div class="mb-8">
                <h1 class="text-3xl font-black text-[#222222] tracking-tight">{{ $evaluation->title }}</h1>
                <nav class="text-xs font-bold text-gray-500 uppercase tracking-widest mt-3 flex items-center gap-2">
                    <span>Terdaftar</span> <span>></span>
                    <a href="{{ route('subjects.show', $subject->id_mapel) }}" class="text-[#444444] hover:text-[#DB2A2A] transition">
                        {{ $subject->nama_mapel ?? '[Data: mapel.nama_mapel]' }}
                    </a>  <span>></span>
                    <a href="{{  route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul]) }}" class="text-[#444444] hover:text-[#DB2A2A] transition">
                        {{ $currentModul->nama_modul ?? '[Data: modul.nama_modul]' }}</a>
                 <span>></span>
                    <span class="text-[#DB2A2A]">Evaluasi</span>
                </nav>
            </div>

            <div id="preparation-view" class="space-y-6 block">
                <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm space-y-6">
                    <h2 class="text-lg font-bold text-[#222222]">Persiapan dan Peraturan</h2>
                    
                    <div class="space-y-3">
                        <div class="border-l-2 border-[#DB2A2A] pl-2 py-0.5">
                            <h3 class="text-xs font-bold text-[#222222] uppercase tracking-wider">Detail Ujian</h3>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="border border-gray-100 rounded-2xl p-4 shadow-sm">
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Jumlah Pertanyaan</p>
                                <p class="text-base font-black text-[#222222] mt-1">{{ $evaluation->total_questions }}</p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-4 shadow-sm">
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Durasi</p>
                                <p class="text-base font-black text-[#222222] mt-1">{{ $evaluation->duration }} Menit</p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-4 shadow-sm">
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Tipe</p>
                                <p class="text-base font-black text-[#222222] mt-1">{{ $evaluation->type }}</p>
                            </div>
                            <div class="border border-gray-100 rounded-2xl p-4 shadow-sm">
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Bahasa</p>
                                <p class="text-base font-black text-[#222222] mt-1">{{ $evaluation->language }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 pt-4 border-t border-gray-50">
                        <div class="border-l-2 border-[#DB2A2A] pl-2 py-0.5">
                            <h3 class="text-xs font-bold text-[#222222] uppercase tracking-wider">Daftar Periksa</h3>
                        </div>
                        <ul class="space-y-3 p-5 bg-white border border-gray-100 rounded-2xl shadow-sm text-sm font-bold text-[#222222]">
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Koneksi Internet Stabil</li>
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Gunakan Browser Rekomendasi (Chrome/Edge)</li>
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Pastikan Kamera & Mikrofon Berfungsi (untuk wawancara mendatang)</li>
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Jangan Buka Tab/Jendela Lain</li>
                            <li class="flex items-center gap-3"><svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Penghitung Waktu Akan Berjalan Setelah Anda Mengeklik "Mulai Ujian"</li>
                        </ul>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="button" onclick="initQuiz()" class="bg-[#DB2A2A] hover:bg-red-700 text-white text-sm font-bold py-3 px-6 rounded-xl flex items-center gap-2 shadow-sm transition">
                            Mulai Ujian Sekarang
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
                
                <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm flex items-center justify-between relative overflow-hidden">
                    <div class="space-y-2 z-10">
                        <h2 class="text-lg font-bold text-[#222222]">Sesi Wawancara Simulasi</h2>
                        <p class="text-sm font-medium text-gray-500">Jadwalkan sesi wawancara simulasi Anda setelah menyelesaikan ujian kompetensi tertulis.</p>
                        <button disabled class="mt-4 bg-gray-200 text-gray-400 font-bold py-3 px-6 rounded-xl text-sm cursor-not-allowed">
                            Pilih Jadwal Wawancara (Sesi Penuh)
                        </button>
                    </div>
                    <div class="w-24 h-24 bg-red-50 rounded-2xl flex flex-col overflow-hidden opacity-80 z-0">
                        <div class="h-6 w-full bg-[#DB2A2A] flex justify-around items-center px-2">
                            <div class="w-2 h-4 bg-white rounded-full -mt-4 shadow"></div>
                            <div class="w-2 h-4 bg-white rounded-full -mt-4 shadow"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="quiz-view" class="hidden grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
                
                <div class="xl:col-span-8">
                    <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm flex flex-col min-h-[500px]">
                        
                        <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
                            <h2 id="q-title" class="text-lg font-bold text-[#222222]">Pertanyaan -- dari --</h2>
                            <p id="countdown-timer" class="text-base font-bold text-[#DB2A2A]">Sisa Waktu: --:--</p>
                        </div>

                        <div class="space-y-2 mb-8">
                            <p class="text-sm font-bold text-gray-500">Pilih jawaban yang paling tepat.</p>
                            <p id="q-text" class="text-xl font-bold text-[#222222] leading-loose">
                                Memuat Pertanyaan...
                            </p>
                        </div>

                        <div id="q-options" class="grid grid-cols-1 md:grid-cols-2 gap-4 flex-1">
                            </div>

                        <div class="flex items-center justify-between mt-8 pt-4">
                            <button type="button" onclick="prevQuestion()" id="btn-prev" class="bg-[#FFDBDB] text-[#DB2A2A] hover:bg-red-200 text-sm font-bold py-3 px-6 rounded-xl flex items-center gap-2 transition disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg> Sblmnya
                            </button>
                            <button type="button" onclick="nextQuestion()" id="btn-next" class="bg-[#DB2A2A] hover:bg-red-700 text-white text-sm font-bold py-3 px-6 rounded-xl flex items-center gap-2 shadow-sm transition">
                                <span id="btn-next-text">Lanjut</span> <svg id="btn-next-icon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>

                    </div>
                </div>

                <div class="xl:col-span-4">
                    <div class="bg-white border border-gray-100 rounded-[32px] p-6 shadow-sm sticky top-6">
                        <div id="question-grid" class="grid grid-cols-5 gap-3">
                            Memuat grid...
                        </div>
                    </div>
                </div>

            </div>

        </div></main>
    </div>

    <script>
        const questions = @json($questions);
        const totalQuestions = {{ $evaluation->total_questions }};
        
        let currentIndex = 0; 
        let answers = {}; 

        let countdownInterval;
        let timeRemaining = {{ $evaluation->time_left_seconds ?? ($evaluation->duration * 60) }};

        function initQuiz() {
            document.getElementById('preparation-view').classList.replace('block', 'hidden');
            document.getElementById('quiz-view').classList.replace('hidden', 'grid');
            
            renderQuestion(currentIndex);
            renderGrid();
            
            startTimer();
        }

        function startTimer() {
            const timerDisplay = document.getElementById('countdown-timer');
            
            countdownInterval = setInterval(() => {
                if (timeRemaining <= 0) {
                    clearInterval(countdownInterval);
                    timerDisplay.innerText = "Sisa Waktu: 00:00";
                    autoSubmitTest();
                } else {
                    timeRemaining--;
                    let minutes = Math.floor(timeRemaining / 60);
                    let seconds = timeRemaining % 60;
                    
                    minutes = minutes < 10 ? '0' + minutes : minutes;
                    seconds = seconds < 10 ? '0' + seconds : seconds;
                    
                    timerDisplay.innerText = `Sisa Waktu: ${minutes}:${seconds}`;
                }
            }, 1000); 
        }

        function autoSubmitTest() {
            alert("⏰ Waktu Habis! Ujian Anda telah disubmit secara otomatis.");
            window.location.href = "{{ route('students.dashboard') }}";
        }

        function renderQuestion(index) {
            const q = questions[index];
            document.getElementById('q-title').innerText = `Pertanyaan ${q.number} dari ${totalQuestions}`;
            document.getElementById('q-text').innerHTML = q.text;

            const optionsContainer = document.getElementById('q-options');
            optionsContainer.innerHTML = ''; 

            q.options.forEach(opt => {
                const isChecked = answers[index] === opt.id ? 'checked' : '';
                optionsContainer.innerHTML += `
                    <div class="relative">
                        <input type="radio" name="quiz_answer" id="opt_${opt.id}" class="peer hidden" value="${opt.id}" onchange="saveAnswer(${index}, '${opt.id}')" ${isChecked} />
                        <label for="opt_${opt.id}" class="flex items-center p-5 border border-gray-100 rounded-2xl cursor-pointer transition peer-checked:border-[#DB2A2A] peer-checked:bg-red-50">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 mr-4 flex items-center justify-center peer-checked:border-[#DB2A2A]">
                                <div class="w-2.5 h-2.5 rounded-full bg-[#DB2A2A] hidden peer-checked:block"></div>
                            </div>
                            <span class="text-base font-bold text-[#222222]">${opt.value}</span>
                        </label>
                    </div>
                `;
            });

            document.getElementById('btn-prev').disabled = (index === 0);
            
            if (index === totalQuestions - 1) {
                document.getElementById('btn-next-text').innerText = 'Selesai Ujian';
                document.getElementById('btn-next-icon').classList.add('hidden');
            } else {
                document.getElementById('btn-next-text').innerText = 'Lanjut';
                document.getElementById('btn-next-icon').classList.remove('hidden');
            }
        }

        function saveAnswer(index, optId) {
            answers[index] = optId; 
            renderGrid(); 
        }

        function renderGrid() {
            const grid = document.getElementById('question-grid');
            grid.innerHTML = '';
            
            for(let i = 0; i < totalQuestions; i++) {
                const qNum = i + 1;
                let btnClass = 'bg-white border border-gray-200 text-gray-500 hover:border-[#DB2A2A] hover:text-[#DB2A2A]'; 

                if (i === currentIndex) {
                    btnClass = 'bg-[#FACC15] text-white shadow-md ring-2 ring-[#FACC15] ring-offset-1'; 
                } else if (answers[i]) {
                    btnClass = 'bg-[#DB2A2A] text-white hover:opacity-80'; 
                }
                grid.innerHTML += `<button onclick="goToQuestion(${i})" class="h-10 rounded-lg text-sm font-bold transition ${btnClass}">${qNum}</button>`;
            }
        }

        function nextQuestion() {
            if (currentIndex < totalQuestions - 1) {
                currentIndex++;
                renderQuestion(currentIndex);
                renderGrid();
            } else {
                clearInterval(countdownInterval); 
                alert("Simulasi Ujian Selesai! Jawaban Anda berhasil dikirim.");
                window.location.href = "{{ route('students.dashboard') }}";
            }
        }

        function prevQuestion() {
            if (currentIndex > 0) {
                currentIndex--;
                renderQuestion(currentIndex);
                renderGrid();
            }
        }

        function goToQuestion(index) {
            currentIndex = index;
            renderQuestion(currentIndex);
            renderGrid();
        }

        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenuClose = document.getElementById('mobile-menu-close');
        const sidebar = document.getElementById('sidebar');
        if (mobileMenuBtn && mobileMenuClose && sidebar) {
            mobileMenuBtn.addEventListener('click', () => { sidebar.classList.remove('-translate-x-full'); mobileMenuClose.classList.remove('hidden'); });
            mobileMenuClose.addEventListener('click', () => { sidebar.classList.add('-translate-x-full'); mobileMenuClose.classList.add('hidden'); });
        }

        function updateClock() {
            const clockElement = document.getElementById('realtime-clock');
            if (!clockElement) return;
            const now = new Date();
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateStr = now.toLocaleDateString('id-ID', options); 
            
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            clockElement.innerText = `${dateStr} • ${hours}.${minutes}.${seconds}`;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>