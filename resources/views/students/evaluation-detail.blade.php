@extends('layouts.student')

@section('title', ($evaluation->title ?? 'Evaluasi') . ' - LPK Seishin')

@push('styles')
<style>
    .banner-red {
        background: linear-gradient(90deg, #d62828 0%, #d62828 50%, #8b1a1a 100%);
        position: relative;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<div class="p-4 sm:p-6 lg:p-10 space-y-6">

    <div class="mb-6">
        <h1 class="text-xl sm:text-2xl lg:text-[28px] font-bold font-ibm text-[#222222] tracking-tight mb-1 text-left">
            {{ $evaluation->title ?? 'Judul Evaluasi' }}
        </h1>
        <nav class="flex items-center gap-2 text-sm font-medium text-[#666666] text-left">
            <a href="{{ route('students.dashboard') }}" class="hover:text-[#d62828] transition">Terdaftar</a> <span class="mx-1.5 text-gray-300">></span> 
            <a href="{{ route('subjects.show', $subject->id_mapel) }}" class="text-[#444444] hover:text-[#d62828] transition">{{ $subject->nama_mapel ?? '[Data: mapel.nama_mapel]' }}</a> 
            <span class="mx-1.5 text-gray-300">></span> 
            <a href="{{ route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul]) }}" class="text-[#444444] hover:text-[#d62828] transition">{{ $currentModul->nama_modul ?? '[Data: modul.nama_modul]' }}</a> 
            <span class="mx-1.5 text-gray-300">></span> 
            <span class="text-[#d62828]">Evaluasi</span>
        </nav>
    </div>

    <div id="preparation-view" class="space-y-6 block">
        <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm space-y-6">
            <h2 class="text-lg font-bold text-[#222222]">Persiapan dan Peraturan</h2>
            
            <div class="space-y-3">
                <div class="border-l-2 border-[#d62828] pl-2 py-0.5">
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
                <div class="border-l-2 border-[#d62828] pl-2 py-0.5">
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
                <x-primary-button type="button" onclick="initQuiz()" class="gap-2 shadow-sm py-3">
                    Mulai Ujian Sekarang
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </x-primary-button>
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
                <div class="h-6 w-full bg-[#d62828] flex justify-around items-center px-2">
                    <div class="w-2 h-4 bg-white rounded-full -mt-4 shadow"></div>
                    <div class="w-2 h-4 bg-white rounded-full -mt-4 shadow"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="quiz-view" class="hidden grid-cols-1 xl:grid-cols-12 gap-8 items-start">
        
        <div class="xl:col-span-8">
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm flex flex-col min-h-[500px]">
                
                <div class="flex items-center justify-between border-b border-gray-100 pb-4 mb-6">
                    <h2 id="q-title" class="text-lg font-bold text-[#222222]">Pertanyaan -- dari --</h2>
                    <p id="countdown-timer" class="text-base font-bold text-[#d62828]">Sisa Waktu: --:--</p>
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
                    <button type="button" onclick="prevQuestion()" id="btn-prev" class="bg-[#FFDBDB] text-[#d62828] hover:bg-red-200 text-sm font-bold py-3 px-6 rounded-xl flex items-center gap-2 transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg> Sblmnya
                    </button>
                    <x-primary-button type="button" onclick="nextQuestion()" id="btn-next" class="gap-2 shadow-sm py-3">
                        <span id="btn-next-text">Lanjut</span> <svg id="btn-next-icon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </x-primary-button>
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

</div>
@endsection

@push('modals')
    <!-- Modal Selesai Ujian -->
    <div id="evaluation-modal" class="fixed inset-0 z-[100] hidden items-center justify-center">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
        <div class="bg-white rounded-[32px] p-8 lg:p-10 shadow-2xl relative z-10 w-[90%] max-w-md text-center transform scale-95 opacity-0 transition-all duration-300" id="evaluation-modal-content">
            
            <div id="modal-icon-container" class="w-20 h-20 mx-auto mb-5 rounded-full flex items-center justify-center shadow-[0_8px_16px_rgba(0,0,0,0.1)]">
                <!-- Icon injected by JS -->
            </div>
            
            <h2 id="modal-title" class="text-2xl font-black text-[#222222] mb-2 tracking-tight">Judul</h2>
            <p id="modal-desc" class="text-sm font-medium text-[#666666] leading-relaxed mb-8">Deskripsi</p>
            
            <form id="eval-submit-form" action="{{ route('evaluations.submit', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul, 'id' => $evaluation->id]) }}" method="POST">
                @csrf
                <div id="hidden-inputs"></div>
                <button type="submit" class="block w-full bg-[#d62828] hover:bg-red-700 text-white font-bold py-3.5 px-6 rounded-xl transition shadow-[0_8px_16px_rgba(214,40,40,0.25)]">
                    Lihat Hasil Skor
                </button>
            </form>
        </div>
    </div>
@endpush

@push('scripts')
<script>
    const questions = @json($questions);
    const totalQuestions = {{ $evaluation->total_questions }};
    
    let currentIndex = 0; 
    let answers = {}; 

    let countdownInterval;
    let timeRemaining = {{ $evaluation->time_left_seconds ?? ($evaluation->duration * 60) }};

    function initQuiz() {
        document.getElementById('preparation-view').classList.replace('block', 'hidden');
        document.getElementById('quiz-view').classList.remove('hidden');
        document.getElementById('quiz-view').classList.add('grid');
        
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
        showModal(
            'timeup', 
            'Waktu Habis!', 
            'Ujian Anda telah disubmit secara otomatis. Mari kita lihat hasilnya.'
        );
    }

    function showModal(type, title, desc) {
        const modal = document.getElementById('evaluation-modal');
        const content = document.getElementById('evaluation-modal-content');
        const iconContainer = document.getElementById('modal-icon-container');
        
        document.getElementById('modal-title').innerText = title;
        document.getElementById('modal-desc').innerText = desc;
        
        if (type === 'timeup') {
            iconContainer.className = "w-20 h-20 mx-auto mb-5 rounded-full flex items-center justify-center shadow-[0_8px_16px_rgba(250,204,21,0.3)] bg-gradient-to-br from-yellow-400 to-yellow-500";
            iconContainer.innerHTML = '<svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        } else {
            iconContainer.className = "w-20 h-20 mx-auto mb-5 rounded-full flex items-center justify-center shadow-[0_8px_16px_rgba(34,197,94,0.3)] bg-gradient-to-br from-green-400 to-green-500";
            iconContainer.innerHTML = '<svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>';
        }
        
        // POPULATE ANSWERS UNTUK FORM SUBMIT
        let hiddenInputs = '';
        questions.forEach((q, idx) => {
            if(answers[idx]) {
                hiddenInputs += `<input type="hidden" name="answers[${q.id_soal}]" value="${answers[idx]}" />`;
            }
        });
        document.getElementById('hidden-inputs').innerHTML = hiddenInputs;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function renderQuestion(index) {
        const q = questions[index];
        document.getElementById('q-title').innerText = `Pertanyaan ${q.number} dari ${totalQuestions}`;
        document.getElementById('q-text').innerHTML = q.text;

        const optionsContainer = document.getElementById('q-options');
        optionsContainer.innerHTML = ''; 

        q.options.forEach(opt => {
            const isChecked = answers[index] === opt.id ? 'checked' : '';
            const isActive = answers[index] === opt.id;
            
            const borderClass = isActive ? 'border-[#d62828] bg-red-50' : 'border-gray-100';
            const circleBorderClass = isActive ? 'border-[#d62828]' : 'border-gray-300';
            const dotDisplayClass = isActive ? 'block' : 'hidden';

            optionsContainer.innerHTML += `
                <div class="relative">
                    <input type="radio" name="quiz_answer" id="opt_${opt.id}" class="hidden" value="${opt.id}" onchange="saveAnswer(${index}, '${opt.id}')" ${isChecked} />
                    <label for="opt_${opt.id}" class="flex items-center p-5 border rounded-2xl cursor-pointer transition ${borderClass} hover:border-[#d62828] hover:bg-red-50">
                        <div class="w-5 h-5 rounded-full border-2 mr-4 flex items-center justify-center ${circleBorderClass}">
                            <div class="w-2.5 h-2.5 rounded-full bg-[#d62828] ${dotDisplayClass}"></div>
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
        renderQuestion(index);
    }

    function renderGrid() {
        const grid = document.getElementById('question-grid');
        grid.innerHTML = '';
        
        for(let i = 0; i < totalQuestions; i++) {
            const qNum = i + 1;
            let btnClass = 'border border-gray-200 text-gray-500 hover:border-[#d62828] hover:text-[#d62828]'; 

            if (i === currentIndex) {
                btnClass = 'bg-[#FACC15] text-white shadow-md ring-2 ring-[#FACC15] ring-offset-1'; 
            } else if (answers[i]) {
                btnClass = 'bg-[#d62828] text-white hover:opacity-80'; 
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
            showModal(
                'success',
                'Ujian Selesai!',
                'Kerja bagus! Jawaban Anda berhasil dikirim. Mari kita lihat skor akhirnya.'
            );
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
</script>
@endpush