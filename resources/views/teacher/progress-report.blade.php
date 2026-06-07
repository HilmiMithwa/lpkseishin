@extends('layouts.teacher')

@section('title', 'Laporan Perkembangan - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10" x-data="{ 
    searchQuery: '',
    filterStatus: 'Semua Status',
    selectedBatch: '{{ $selectedBatchName }}',
    selectedClass: '{{ $selectedClassName }}',
    detailOpen: false, 
    studentId: '', 
    studentName: '', 
    studentAvatar: '',
    week1Open: false,
    week2Open: false,
    week3Open: false,
    uts1Open: false,
    quiz1Open: false,
    showAddWeekly: false,
    weeklyFormTitle: 'Draf - Minggu Baru',
    showAddEvaluation: false,
    evalFormTitle: 'Draf - Evaluasi Baru',
    editEvalTipe: '',
    editEvalObj: null,
    editEvalJawaban: [],
    showDeleteConfirm: false,
    deleteTargetName: '',
    deleteTargetUrl: '#',
    overallAverage: 0,
    predikat: '',
    radarScores: [0, 0, 0, 0, 0, 0],
    weeklyLogs: [],
    evaluations: [],
    editWeeklyId: null,
    editEvalId: null,
    onlineEvals: [],
    onlineSubmissions: [],
    selectedOnlineEval: '',
    loadingSubmissions: false,
    
    init() {
        this.$watch('currentTab', val => {
            if (val === 'ujian') {
                this.fetchOnlineEvals();
            }
        });
    },
    fetchOnlineEvals() {
        if (!'{{ $selectedClassId }}') return;
        fetch(`/teacher/progress-report/online-evaluations/{{ $selectedClassId }}`)
            .then(res => res.json())
            .then(data => {
                this.onlineEvals = data;
            });
    },
    fetchOnlineSubmissions() {
        if (!this.selectedOnlineEval || !'{{ $selectedClassId }}') return;
        this.loadingSubmissions = true;
        fetch(`/teacher/progress-report/online-submissions/{{ $selectedClassId }}?eval_name=` + encodeURIComponent(this.selectedOnlineEval))
            .then(res => res.json())
            .then(data => {
                this.onlineSubmissions = data.map(sub => {
                    let jwb = [];
                    try { jwb = JSON.parse(sub.jawaban_siswa); } catch(e){}
                    sub.jawaban_parsed = jwb || [];
                    return sub;
                });
                this.loadingSubmissions = false;
            });
    },
    saveInlineScore(id_catatan, formElement) {
        let formData = new FormData(formElement);
        formData.append('_method', 'PUT');
        formData.append('id_mapel', '{{ $selectedClassId }}');
        // We need to keep tipe_ujian as Online so the controller knows
        
        let url = '/teacher/progress-report/evaluation-log/' + id_catatan;
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        }).then(async (res) => {
            if (res.ok) {
                // Show success feedback
                const btn = formElement.querySelector('button[type=submit]');
                const origText = btn.innerHTML;
                btn.innerHTML = 'Tersimpan!';
                btn.classList.add('bg-green-500');
                btn.classList.remove('bg-[#d62828]');
                setTimeout(() => {
                    btn.innerHTML = origText;
                    btn.classList.remove('bg-green-500');
                    btn.classList.add('bg-[#d62828]');
                }, 2000);
            } else {
                alert('Gagal menyimpan nilai.');
            }
        });
    },
    openStudentDetail(userId) {
        this.studentId = userId;
        this.editWeeklyId = null;
        this.editEvalId = null;
        fetch(`/teacher/progress-report/student/${userId}/mapel/{{ $selectedClassId }}`)
            .then(res => res.json())
            .then(data => {
                this.studentName = data.studentName;
                this.studentAvatar = data.studentAvatar;
                this.overallAverage = data.overallAverage;
                this.predikat = data.predikat;
                this.radarScores = data.radarScores;
                this.weeklyLogs = data.weeklyLogs;
                this.evaluations = data.evaluations;
                this.detailOpen = true;
            });
    },
    saveWeeklyLog(e) {
        let formData = new FormData(e.target);
        formData.append('id_user', this.studentId);
        formData.append('id_mapel', '{{ $selectedClassId }}');
        
        let url = '/teacher/progress-report/weekly-log';
        if (this.editWeeklyId) {
            url = '/teacher/progress-report/weekly-log/' + this.editWeeklyId;
            formData.append('_method', 'PUT');
        }
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        }).then(async (res) => {
            if (res.ok) {
                this.openStudentDetail(this.studentId);
                this.showAddWeekly = false;
                this.editWeeklyId = null;
                e.target.reset();
            } else {
                let err = await res.json();
                console.error(err);
                alert('Gagal menyimpan. Coba periksa input Anda.');
            }
        });
    },
    saveEvaluationLog(e) {
        let formData = new FormData(e.target);
        formData.append('id_user', this.studentId);
        formData.append('id_mapel', '{{ $selectedClassId }}');
        
        let url = '/teacher/progress-report/evaluation-log';
        if (this.editEvalId) {
            url = '/teacher/progress-report/evaluation-log/' + this.editEvalId;
            formData.append('_method', 'PUT');
        }
        
        fetch(url, {
            method: 'POST',
            body: formData,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        }).then(async (res) => {
            if (res.ok) {
                this.openStudentDetail(this.studentId);
                this.showAddEvaluation = false;
                this.editEvalId = null;
                e.target.reset();
            } else {
                let err = await res.json();
                console.error(err);
                alert('Gagal menyimpan. Coba periksa input Anda.');
            }
        });
    },
    openEditWeekly(log) {
        this.editWeeklyId = log.id_catatan_mingguan;
        this.weeklyFormTitle = 'Edit Catatan Mingguan (Minggu ' + log.minggu_ke + ')';
        this.showAddWeekly = true;
        
        // Use nextTick to ensure form is rendered
        this.$nextTick(() => {
            const form = document.getElementById('weeklyForm');
            if(form) {
                form.elements['minggu_ke'].value = log.minggu_ke;
                form.elements['score_word'].value = log.score_word;
                form.elements['score_kotoba'].value = log.score_kotoba;
                form.elements['score_bunpou'].value = log.score_bunpou;
                form.elements['score_kanji'].value = log.score_kanji;
                form.elements['score_choukai'].value = log.score_choukai;
                form.elements['score_kaiwa'].value = log.score_kaiwa;
            }
        });
        this.$refs.offcanvasBody.scrollTo({ top: 0, behavior: 'smooth' });
    },
    openEditEval(evalLog) {
        this.editEvalId = evalLog.id_catatan_evaluasi;
        this.evalFormTitle = evalLog.tipe_ujian && evalLog.tipe_ujian.toLowerCase() === 'online' 
            ? 'Informasi Ujian (' + evalLog.nama_evaluasi + ')' 
            : 'Edit Catatan Evaluasi (' + evalLog.nama_evaluasi + ')';
        this.editEvalTipe = evalLog.tipe_ujian;
        this.editEvalObj = evalLog;
        
        let jawabanParsed = [];
        if (evalLog.jawaban_siswa) {
            try {
                jawabanParsed = typeof evalLog.jawaban_siswa === 'string' ? JSON.parse(evalLog.jawaban_siswa) : evalLog.jawaban_siswa;
            } catch(e) {}
        }
        this.editEvalJawaban = jawabanParsed;
        
        this.showAddEvaluation = true;
        
        this.$nextTick(() => {
            const form = document.getElementById('evalForm');
            if(form) {
                form.elements['nama_evaluasi'].value = evalLog.nama_evaluasi;
                form.elements['tipe_ujian'].value = evalLog.tipe_ujian;
                form.elements['skor'].value = evalLog.skor;
            }
        });
        this.$refs.offcanvasBody.scrollTo({ top: 0, behavior: 'smooth' });
    },
    deleteLog(id, type) {
        const url = type === 'weekly' ? `/teacher/progress-report/weekly-log/${id}` : `/teacher/progress-report/evaluation-log/${id}`;
        fetch(url, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
        }).then(() => {
            if (type === 'evaluation_online') {
                this.fetchOnlineSubmissions();
            } else if (this.studentId) {
                this.openStudentDetail(this.studentId);
            }
            this.showDeleteConfirm = false;
        });
    },
    triggerDeleteModal(id, type, name) {
        this.deleteId = id;
        this.deleteType = type;
        this.deleteTargetName = name;
        this.showDeleteConfirm = true;
    }
}">

    <div class="mb-8 text-left">
        <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Penilaian Siswa</h1>
        <p class="text-sm text-[#666666] font-medium mt-1">Penilaian dan Laporan Perkembangan Siswa</p>
    </div>

    <!-- 4 Top Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <!-- Select Batch & Class -->
        <div class="lg:col-span-2 bg-white rounded-[24px] border border-gray-100 p-5 shadow-sm flex flex-col sm:flex-row items-center gap-4">
            <div class="flex-1 w-full space-y-1.5">
                <x-input-label>Pilih Batch</x-input-label>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @click.away="open = false" type="button" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold flex items-center justify-between transition focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] shadow-sm" :class="selectedBatch === '' ? 'text-gray-400' : 'text-[#222222]'">
                        <span x-text="selectedBatch === '' ? 'Pilih Batch...' : selectedBatch"></span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180 text-[#222222]' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden" style="display: none;" x-cloak>
                        <ul class="py-1">
                            @foreach($batches as $batch)
                            <li>
                                <a href="{{ route('teacher.progress-report', ['batch_id' => $batch->id_batch]) }}" class="block w-full text-left px-4 py-2.5 text-sm font-semibold hover:bg-red-50 hover:text-[#d62828] transition-colors {{ $selectedBatchId == $batch->id_batch ? 'bg-red-50 text-[#d62828]' : 'text-gray-700' }}">
                                    {{ $batch->nama }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="flex-1 w-full space-y-1.5">
                <x-input-label>Pilih Kelas</x-input-label>
                <div class="relative" x-data="{ open: false }">
                    <button @click="if(selectedBatch !== '') open = !open" @click.away="open = false" type="button" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold flex items-center justify-between transition focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] shadow-sm" :class="[selectedClass === '' ? 'text-gray-400' : 'text-[#222222]', selectedBatch === '' ? 'bg-gray-50 border-gray-100 cursor-not-allowed opacity-70' : '']">
                        <span x-text="selectedClass === '' ? 'Pilih Kelas...' : selectedClass"></span>
                        <svg class="w-4 h-4 transition-transform duration-200" :class="[open ? 'rotate-180 text-gray-800' : 'text-gray-400', selectedBatch === '' ? 'opacity-50' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden" style="display: none;" x-cloak>
                        <ul class="py-1">
                            @foreach($classes as $cls)
                            <li>
                                <a href="{{ route('teacher.progress-report', ['batch_id' => $selectedBatchId, 'class_id' => $cls->id_mapel]) }}" class="block w-full text-left px-4 py-2.5 text-sm font-semibold hover:bg-red-50 hover:text-[#d62828] transition-colors {{ $selectedClassId == $cls->id_mapel ? 'bg-red-50 text-[#d62828]' : 'text-gray-700' }}">
                                    {{ $cls->nama_mapel }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Class Average -->
        <div class="bg-white rounded-[24px] border border-gray-100 p-6 shadow-sm flex flex-col justify-center text-center sm:text-left transition-all duration-300" :class="selectedBatch !== '' && selectedClass !== '' ? '' : 'bg-gray-50/50 opacity-70 grayscale'">
            <p class="text-[11px] font-bold text-gray-500 mb-2 tracking-wider">RATA-RATA KELAS</p>
            <div class="flex items-baseline justify-center sm:justify-start gap-1">
                <h2 class="text-3xl font-bold tracking-tight" :class="selectedBatch !== '' && selectedClass !== '' ? 'text-gray-800' : 'text-gray-400'" x-text="selectedBatch !== '' && selectedClass !== '' ? '{{ $avgClass }}' : '-'">{{ $avgClass }}</h2>
                <span class="text-sm font-bold text-gray-400" x-show="selectedBatch !== '' && selectedClass !== ''" x-transition.opacity>/100</span>
            </div>
        </div>

        <!-- Avg Progress -->
        <div class="bg-white rounded-[24px] border border-gray-100 p-6 shadow-sm flex flex-col justify-center text-center sm:text-left transition-all duration-300" :class="selectedBatch !== '' && selectedClass !== '' ? '' : 'bg-gray-50/50 opacity-70 grayscale'">
            <p class="text-[11px] font-bold text-gray-500 mb-2 tracking-wider">RATA-RATA PROGRESS</p>
            <h2 class="text-3xl font-bold tracking-tight" :class="selectedBatch !== '' && selectedClass !== '' ? 'text-gray-800' : 'text-gray-400'" x-text="selectedBatch !== '' && selectedClass !== '' ? '{{ $avgProgress }}%' : '-'">{{ $avgProgress }}%</h2>
        </div>

        <!-- Warning Student -->
        <div class="bg-white rounded-[24px] border border-gray-100 p-6 shadow-sm flex flex-col justify-center text-center sm:text-left transition-all duration-300" :class="selectedBatch !== '' && selectedClass !== '' ? '' : 'bg-gray-50/50 opacity-70 grayscale'">
            <p class="text-[11px] font-bold text-gray-500 mb-2 tracking-wider">SISWA PERINGATAN</p>
            <h2 class="text-3xl font-bold tracking-tight" :class="selectedBatch !== '' && selectedClass !== '' ? 'text-[#d62828]' : 'text-gray-400'" x-text="selectedBatch !== '' && selectedClass !== '' ? '{{ $warningCount }}' : '-'">{{ $warningCount }}</h2>
        </div>
    </div>
    <!-- Empty State Notification -->
    <div x-show="selectedBatch === '' || selectedClass === ''" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="flex flex-col items-center justify-center bg-white rounded-[32px] border border-gray-100 p-12 text-center shadow-sm min-h-[400px]">
        <div class="w-24 h-24 bg-red-50 text-[#d62828] rounded-full flex items-center justify-center mb-6 border-4 border-red-100/50">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Data Terpilih</h3>
        <p class="text-sm text-gray-500 max-w-md mx-auto leading-relaxed">Silakan pilih <span class="font-bold text-gray-700">Batch</span> dan <span class="font-bold text-gray-700">Kelas</span> pada menu di atas terlebih dahulu untuk memuat data Laporan Perkembangan siswa.</p>
    </div>

    <!-- Tabs Navigation -->
    <div x-show="selectedBatch !== '' && selectedClass !== ''" x-transition.opacity.duration.300ms style="display: none;" class="flex border-b border-gray-200 mb-6 overflow-x-auto no-scrollbar" x-cloak>
        <button @click="currentTab = 'perkembangan'" :class="currentTab === 'perkembangan' ? 'border-[#d62828] text-[#d62828] font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-semibold'" class="whitespace-nowrap py-4 px-6 border-b-2 text-sm transition-colors duration-200 outline-none">
            Perkembangan Harian
        </button>
        <button @click="currentTab = 'ujian'" :class="currentTab === 'ujian' ? 'border-[#d62828] text-[#d62828] font-bold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 font-semibold'" class="whitespace-nowrap py-4 px-6 border-b-2 text-sm transition-colors duration-200 outline-none">
            Penilaian Ujian
        </button>
    </div>

    <!-- Tab 1: Perkembangan Harian -->
    <div x-show="selectedBatch !== '' && selectedClass !== '' && currentTab === 'perkembangan'" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-6 lg:p-8" style="display: none;" x-cloak>
        
        <!-- Toolbar -->
        <div class="flex flex-col sm:flex-row items-center gap-3 mb-6">
            <div class="relative w-full sm:w-80">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" x-model="searchQuery" placeholder="Cari Siswa..." class="w-full pl-10 pr-4 py-2.5 text-sm font-medium bg-white border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-300 transition">
            </div>
            
            <div class="relative w-full sm:w-auto" x-data="{ openFilter: false, statusFilter: 'Status' }">
                <button @click="openFilter = !openFilter" @click.away="openFilter = false" type="button" class="w-full sm:w-auto min-w-[130px] bg-white border border-gray-200 hover:border-[#d62828] rounded-full px-5 py-2.5 text-sm font-bold flex items-center justify-between transition shadow-sm" :class="statusFilter === 'Status' ? 'text-gray-600' : 'text-[#d62828]'">
                    <span x-text="statusFilter"></span>
                    <svg class="w-4 h-4 ml-3 transition-transform duration-200" :class="openFilter ? 'rotate-180 text-[#d62828]' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div class="relative w-full sm:w-auto" x-data="{ openFilter: false, statusFilter: 'Semua Status' }">
                    <input type="hidden" id="dt-status" value="all">
                    <button @click="openFilter = !openFilter" @click.away="openFilter = false" type="button" class="w-full sm:w-auto min-w-[140px] bg-white border border-gray-200 hover:border-[#d62828] rounded-full px-5 py-2.5 text-sm font-bold flex items-center justify-between transition shadow-sm" :class="statusFilter === 'Semua Status' ? 'text-gray-600' : 'text-[#d62828]'">
                        <span x-text="statusFilter"></span>
                        <svg class="w-4 h-4 ml-3 transition-transform duration-200" :class="openFilter ? 'rotate-180 text-[#d62828]' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    
                    <div x-show="openFilter" style="display: none;"
                         class="absolute right-0 sm:left-0 z-50 w-full min-w-[140px] mt-2 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden" 
                         x-transition:enter="transition ease-out duration-100" 
                         x-transition:enter-start="opacity-0 -translate-y-2" 
                         x-transition:enter-end="opacity-100 translate-y-0" 
                         x-transition:leave="transition ease-in duration-75" 
                         x-transition:leave-start="opacity-100 translate-y-0" 
                         x-transition:leave-end="opacity-0 -translate-y-2">
                        <ul class="py-1">
                            <li><button type="button" @click="statusFilter = 'Semua Status'; openFilter = false; $('#dt-status').val('all').trigger('change')" class="w-full text-left px-4 py-2.5 text-sm font-semibold transition-colors hover:bg-gray-50 text-gray-700" :class="statusFilter === 'Semua Status' ? 'bg-gray-50' : ''">Semua Status</button></li>
                            <li><button type="button" @click="statusFilter = 'Aktif'; openFilter = false; $('#dt-status').val('Aktif').trigger('change')" class="w-full text-left px-4 py-2.5 text-sm font-semibold transition-colors hover:bg-green-50 text-green-600" :class="statusFilter === 'Aktif' ? 'bg-green-50' : ''">Aktif</button></li>
                            <li><button type="button" @click="statusFilter = 'Tidak Aktif'; openFilter = false; $('#dt-status').val('Tidak Aktif').trigger('change')" class="w-full text-left px-4 py-2.5 text-sm font-semibold transition-colors hover:bg-red-50 text-red-600" :class="statusFilter === 'Tidak Aktif' ? 'bg-red-50' : ''">Tidak Aktif</button></li>
                            <li><button type="button" @click="statusFilter = 'Selesai'; openFilter = false; $('#dt-status').val('Selesai').trigger('change')" class="w-full text-left px-4 py-2.5 text-sm font-semibold transition-colors hover:bg-gray-100 text-gray-800" :class="statusFilter === 'Selesai' ? 'bg-gray-100' : ''">Selesai</button></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <span class="text-sm font-semibold text-gray-500 whitespace-nowrap">Tampilkan:</span>
                <select id="custom-dt-length" class="bg-white border border-gray-200 text-gray-700 text-sm font-bold rounded-lg focus:ring-[#d62828] focus:border-[#d62828] block p-2 transition shadow-sm">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto min-h-[400px]">
            <table id="progress-table" class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/50">
                        <th class="py-4 px-4 text-[11px] font-bold text-gray-600 uppercase tracking-wider rounded-tl-xl">No</th>
                        <th class="py-4 px-4 text-[11px] font-bold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="py-4 px-4 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Siswa</th>
                        <th class="py-4 px-4 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Progress Modul</th>
                        <th class="py-4 px-4 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Rata-rata Tugas</th>
                        <th class="py-4 px-4 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Nilai Evaluasi</th>
                        <th class="py-4 px-4 text-[11px] font-bold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-4 text-[11px] font-bold text-gray-600 uppercase tracking-wider text-center rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($students as $index => $student)
                    <tr x-show="(searchQuery === '' || '{{ strtolower($student->name) }}'.includes(searchQuery.toLowerCase())) && (filterStatus === 'Semua Status' || '{{ $student->status }}' === filterStatus)" class="hover:bg-gray-50/50 transition">
                        <td class="py-4 px-4 text-sm font-semibold text-gray-600">{{ $index + 1 }}</td>
                        <td class="py-4 px-4 text-sm font-semibold text-gray-600">{{ $student->id }}</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $student->avatar }}" alt="{{ $student->name }}" class="w-8 h-8 rounded-full object-cover">
                                <span class="text-sm font-bold text-gray-800">{{ $student->name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-24 h-2 bg-red-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#d62828] rounded-full" style="width: {{ $student->progress_modul }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-600 w-8">{{ $student->progress_modul }}%</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-sm font-bold text-gray-600">{{ $student->rata_rata_tugas }}</td>
                        <td class="py-4 px-4 text-sm font-bold text-gray-600">{{ $student->nilai_evaluasi }}</td>
                        <td class="py-4 px-4">
                            @if($student->status == 'Selesai')
                            <span class="inline-flex px-3 py-1 bg-gray-200 text-gray-700 rounded-lg text-[10px] font-bold tracking-wide uppercase">{{ $student->status }}</span>
                            @elseif($student->status == 'Aktif')
                            <span class="inline-flex px-3 py-1 bg-green-100 text-green-700 rounded-lg text-[10px] font-bold tracking-wide uppercase">{{ $student->status }}</span>
                            @else
                            <span class="inline-flex px-3 py-1 bg-red-100 text-red-700 rounded-lg text-[10px] font-bold tracking-wide uppercase">{{ $student->status }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center">
                            <button @click="openStudentDetail({{ $student->user_id }})" class="w-8 h-8 inline-flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="py-8 text-center text-gray-500 text-sm">Belum ada data siswa untuk kelas ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div id="custom-dt-info" class="text-sm font-semibold text-gray-500 text-center sm:text-left">
                <!-- DataTables Info -->
            </div>
            <div id="custom-dt-pagination" class="flex items-center gap-1.5 overflow-x-auto pb-2 sm:pb-0">
                <!-- DataTables Pagination Buttons -->
            </div>
        </div>
    </div>

    <!-- Tab 2: Penilaian Ujian -->
    <div x-show="selectedBatch !== '' && selectedClass !== '' && currentTab === 'ujian'" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" style="display: none;" x-cloak>
        <div class="bg-white border border-gray-100 rounded-[32px] p-6 sm:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] relative mb-6">
            <h2 class="text-xl font-bold text-gray-800 mb-6">Penilaian Ujian Online</h2>
            
            @if(empty($selectedClassId))
                <div class="p-6 bg-red-50 border border-red-100 rounded-2xl text-center">
                    <p class="text-red-600 font-bold">Silakan pilih Batch dan Kelas terlebih dahulu.</p>
                </div>
            @else
                <div class="mb-8 relative z-20">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Nama Ujian</label>
                    <div class="relative w-full max-w-md" x-data="{ open: false }">
                        <button type="button" @click="open = !open" @click.away="open = false" class="w-full bg-white border border-gray-200 text-gray-800 text-sm rounded-xl focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-[#d62828] flex items-center justify-between p-3.5 font-semibold transition shadow-sm cursor-pointer hover:border-[#d62828]">
                            <span x-text="selectedOnlineEval || '-- Pilih Ujian --'" :class="selectedOnlineEval ? 'text-gray-800' : 'text-gray-400'"></span>
                            <svg class="w-5 h-5 transition-transform duration-200" :class="open ? 'rotate-180 text-[#d62828]' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="absolute z-10 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] overflow-hidden" style="display: none;" x-cloak>
                            <ul class="py-2 max-h-60 overflow-auto custom-scrollbar">
                                <li>
                                    <button type="button" @click="selectedOnlineEval = ''; fetchOnlineSubmissions(); open = false" class="w-full text-left px-4 py-2.5 text-sm font-semibold transition" :class="selectedOnlineEval === '' ? 'bg-red-50 text-[#d62828]' : 'text-gray-500 hover:bg-gray-50'">-- Pilih Ujian --</button>
                                </li>
                                <template x-for="eval in onlineEvals" :key="eval">
                                    <li>
                                        <button type="button" @click="selectedOnlineEval = eval; fetchOnlineSubmissions(); open = false" class="w-full text-left px-4 py-2.5 text-sm font-bold transition" :class="selectedOnlineEval === eval ? 'bg-red-50 text-[#d62828]' : 'text-gray-700 hover:bg-gray-50'" x-text="eval"></button>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Loading State -->
                <div x-show="loadingSubmissions" class="text-center py-10">
                    <svg class="animate-spin h-8 w-8 text-[#d62828] mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <p class="mt-3 text-sm text-gray-500 font-semibold">Memuat jawaban siswa...</p>
                </div>

                <!-- Submissions List -->
                <div x-show="!loadingSubmissions && selectedOnlineEval !== ''">
                    <template x-if="onlineSubmissions.length === 0">
                        <div class="p-10 bg-gray-50 border border-gray-100 rounded-2xl text-center">
                            <p class="text-gray-500 font-bold">Belum ada siswa yang mengerjakan ujian ini.</p>
                        </div>
                    </template>
                    
                    <div class="space-y-6">
                        <template x-for="sub in onlineSubmissions" :key="sub.id_catatan_evaluasi">
                            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm transition-all duration-200" x-data="{ open: false, get essayAnswers() { return sub.jawaban_parsed ? sub.jawaban_parsed.filter(j => j.tipe === 'essay') : []; } }" :class="open ? 'ring-1 ring-red-100' : ''">
                                
                                <!-- Accordion Header -->
                                <button type="button" @click="open = !open" class="w-full px-6 py-4 bg-white hover:bg-gray-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 transition outline-none text-left">
                                    <div class="flex items-center gap-4 w-full">
                                        <div class="w-6 h-6 rounded flex items-center justify-center transition-all duration-300 shrink-0" :class="open ? 'rotate-90 bg-red-50 text-[#d62828]' : 'bg-gray-50 text-gray-400'">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-red-50 text-[#d62828] rounded-full flex items-center justify-center font-black text-sm border border-red-100 shrink-0" x-text="sub.student_name.substring(0,2).toUpperCase()"></div>
                                            <div>
                                                <h3 class="font-bold text-[#222222] text-sm" x-text="sub.student_name"></h3>
                                                <p class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider mt-0.5">Disubmit: <span x-text="new Date(sub.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit'})"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="shrink-0 flex items-center gap-4 w-full sm:w-auto mt-2 sm:mt-0 pl-10 sm:pl-0">
                                        <span class="text-xs font-bold text-gray-500">Skor: <span class="text-lg font-black text-[#d62828] ml-1" x-text="sub.skor"></span></span>
                                    </div>
                                </button>
                                
                                <!-- Accordion Body -->
                                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                                    <div class="border-t border-gray-100">
                                        
                                        <div class="p-6">
                                            <!-- Skor Tersimpan -->
                                            <div class="mb-8 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-12 h-12 bg-red-50 text-[#d62828] rounded-2xl flex items-center justify-center shrink-0">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="text-base font-bold text-gray-800 mb-0.5">Skor Saat Ini</h4>
                                                        <p class="text-xs text-gray-500 font-medium">Kalkulasi otomatis pilihan ganda atau nilai yang terakhir disimpan.</p>
                                                    </div>
                                                </div>
                                                <div class="text-center sm:text-right w-full sm:w-auto">
                                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-0.5">Total Poin</span>
                                                    <span class="text-3xl font-black text-[#d62828]" x-text="sub.skor"></span>
                                                </div>
                                            </div>

                                            <!-- Only Show Essay -->
                                            <template x-if="essayAnswers.length > 0">
                                                <div class="mb-2">
                                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-5">Jawaban Essay Siswa</h4>
                                                    <div class="space-y-6">
                                                        <template x-for="(jwb, idx) in essayAnswers" :key="idx">
                                                            <div class="pb-6 border-b border-gray-100 last:border-0 last:pb-0">
                                                                <p class="text-sm font-bold text-gray-800 mb-3 leading-relaxed" x-html="(idx+1) + '. ' + jwb.pertanyaan"></p>
                                                                <div class="pl-4 border-l-[3px] border-[#d62828] py-1">
                                                                    <div class="mb-2"><span class="text-[10px] font-black px-2 py-0.5 rounded-md uppercase tracking-wider bg-red-50 text-[#d62828]">Essay</span></div>
                                                                    <p class="text-sm font-medium text-gray-600 leading-relaxed whitespace-pre-wrap" x-text="jwb.jawaban || 'Tidak dijawab'"></p>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            <!-- Message if No Essay -->
                                            <template x-if="essayAnswers.length === 0">
                                                <div class="mb-2 bg-gray-50 rounded-2xl p-6 text-center border border-gray-100">
                                                    <div class="w-12 h-12 bg-white text-gray-400 rounded-full flex items-center justify-center shrink-0 mx-auto shadow-sm mb-3">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </div>
                                                    <h4 class="text-sm font-bold text-gray-800 mb-1">Pilihan Ganda Saja</h4>
                                                    <p class="text-xs text-gray-500 font-medium max-w-md mx-auto">Ujian ini telah dinilai otomatis secara keseluruhan karena tidak memiliki soal essay. Verifikasi ulang tidak diwajibkan.</p>
                                                </div>
                                            </template>
                                        </div>
                                        
                                        <!-- Edit Score Form (Footer) -->
                                        <div class="bg-gray-50 px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-5 border-t border-gray-100">
                                            <div class="w-full sm:w-auto text-center sm:text-left">
                                                <h4 class="text-sm font-bold text-gray-800">Verifikasi Skor Akhir</h4>
                                                <p class="text-xs font-semibold text-gray-500 mt-0.5">Berikan penyesuaian bobot nilai essay jika diperlukan.</p>
                                            </div>
                                            <div class="flex items-center gap-3 w-full sm:w-auto shrink-0 justify-center sm:justify-end">
                                                <button type="button" @click="$dispatch('open-delete', { id: sub.id_catatan_evaluasi, type: 'evaluation_online', name: 'Hasil Ujian ' + sub.student_name })" class="text-gray-500 hover:text-red-600 bg-white border border-gray-200 hover:border-red-200 hover:bg-red-50 px-4 py-3 rounded-xl text-sm font-bold transition-colors outline-none shadow-sm flex items-center gap-2" title="Hapus Ujian Siswa">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    <span class="hidden sm:inline">Hapus</span>
                                                </button>
                                                <form @submit.prevent="saveInlineScore(sub.id_catatan_evaluasi, $el)" class="flex items-center gap-3">
                                                    <input type="hidden" name="tipe_ujian" value="Online">
                                                    <input type="number" name="skor" :value="sub.skor" min="0" max="100" class="w-20 sm:w-24 bg-white border border-gray-200 text-gray-800 text-lg rounded-xl focus:ring-2 focus:ring-red-100 focus:border-[#d62828] block p-2.5 font-black text-center shadow-sm" required>
                                                    <button type="submit" class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-3 px-6 rounded-xl text-sm transition shadow-sm whitespace-nowrap">Simpan Nilai</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Off-canvas Section (Teleported) -->
    <template x-teleport="body">
        <div>
            <!-- Off-canvas Overlay -->
            <div x-show="detailOpen" class="fixed inset-0 bg-gray-900/30 backdrop-blur-sm z-[100]" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;" x-cloak></div>

            <!-- Off-canvas Panel -->
            <div x-show="detailOpen" @click.away="detailOpen = false" class="fixed top-0 right-0 h-screen w-full sm:w-[460px] bg-white z-[110] shadow-2xl flex flex-col border-l border-gray-100" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" style="display: none;" x-cloak>
        
        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
            <div class="flex items-center gap-4">
                <img :src="studentAvatar" class="w-12 h-12 rounded-full object-cover shadow-sm border border-gray-100">
                <div>
                    <h3 class="font-bold text-gray-900 text-base" x-text="studentName"></h3>
                    <p class="text-[11px] text-gray-500 font-bold mt-0.5 tracking-wider uppercase">Level N5</p>
                </div>
            </div>
            <button @click="detailOpen = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

            <!-- Offcanvas Body -->
            <div x-ref="offcanvasBody" class="flex-1 overflow-y-auto custom-scrollbar p-6 space-y-8 bg-[#fafafa]">
            
            <!-- Student Summary -->
            <section>
                <h4 class="text-sm font-bold text-gray-800 mb-1">Ringkasan Siswa</h4>
                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">Kelas: N4 Mastering</p>
                
                <div class="bg-white border border-gray-100 rounded-[20px] p-5 shadow-sm flex items-center justify-between gap-4">
                    <div class="flex-1">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Rata-rata Nilai:</p>
                        <div class="flex items-baseline gap-1 mb-4">
                            <h2 class="text-3xl font-bold text-gray-800 tracking-tight" x-text="overallAverage"></h2>
                            <span class="text-[11px] font-bold text-gray-400">/100</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Predikat:</span>
                            <span class="inline-flex px-2 py-0.5 bg-green-100 text-green-700 rounded-md text-[10px] font-bold tracking-wide uppercase" x-text="predikat"></span>
                        </div>
                    </div>
                    
                    <!-- SVG Radar Chart Interaktif -->
                    <div class="w-32 h-32 relative flex items-center justify-center shrink-0 mr-6" x-data="{
                        labels: ['Word', 'Kotoba', 'Bunpou', 'Kanji', 'Choukai', 'Kaiwa'],
                        getPoints() {
                            return radarScores.map((score, i) => {
                                const angle = (Math.PI / 2) - (2 * Math.PI * i / 6);
                                const r = (score / 100) * 40;
                                return `${50 + r * Math.cos(angle)},${50 - r * Math.sin(angle)}`;
                            }).join(' ');
                        },
                        getPoint(score, i) {
                            const angle = (Math.PI / 2) - (2 * Math.PI * i / 6);
                            const r = (score / 100) * 40;
                            return { x: 50 + r * Math.cos(angle), y: 50 - r * Math.sin(angle) };
                        }
                    }">
                        <svg viewBox="0 0 100 100" class="w-full h-full overflow-visible">
                            <!-- Background Web Hexagon -->
                            <polygon points="50,10 84.64,30 84.64,70 50,90 15.36,70 15.36,30" fill="none" stroke="#e5e7eb" stroke-width="1"/>
                            <polygon points="50,23.3 73.09,36.6 73.09,63.3 50,76.6 26.9,63.3 26.9,36.6" fill="none" stroke="#e5e7eb" stroke-width="1"/>
                            <polygon points="50,36.6 61.5,43.3 61.5,56.6 50,63.3 38.5,56.6 38.5,43.3" fill="none" stroke="#e5e7eb" stroke-width="1"/>
                            <!-- Axes -->
                            <line x1="50" y1="50" x2="50" y2="10" stroke="#e5e7eb" stroke-width="1"/>
                            <line x1="50" y1="50" x2="84.64" y2="30" stroke="#e5e7eb" stroke-width="1"/>
                            <line x1="50" y1="50" x2="84.64" y2="70" stroke="#e5e7eb" stroke-width="1"/>
                            <line x1="50" y1="50" x2="50" y2="90" stroke="#e5e7eb" stroke-width="1"/>
                            <line x1="50" y1="50" x2="15.36" y2="70" stroke="#e5e7eb" stroke-width="1"/>
                            <line x1="50" y1="50" x2="15.36" y2="30" stroke="#e5e7eb" stroke-width="1"/>
                            
                            <!-- Dynamic Data Polygon -->
                            <polygon :points="getPoints()" fill="rgba(214, 40, 40, 0.2)" stroke="#d62828" stroke-width="1.5" class="transition-all duration-300"/>
                            
                            <!-- Interactive Points (Visible) -->
                            <circle :cx="getPoint(radarScores[0], 0).x" :cy="getPoint(radarScores[0], 0).y" :r="activePoint === 0 ? 4 : 2" :fill="activePoint === 0 ? '#fff' : '#d62828'" :stroke="activePoint === 0 ? '#d62828' : 'none'" stroke-width="1.5" class="transition-all duration-300 pointer-events-none" />
                            <circle :cx="getPoint(radarScores[1], 1).x" :cy="getPoint(radarScores[1], 1).y" :r="activePoint === 1 ? 4 : 2" :fill="activePoint === 1 ? '#fff' : '#d62828'" :stroke="activePoint === 1 ? '#d62828' : 'none'" stroke-width="1.5" class="transition-all duration-300 pointer-events-none" />
                            <circle :cx="getPoint(radarScores[2], 2).x" :cy="getPoint(radarScores[2], 2).y" :r="activePoint === 2 ? 4 : 2" :fill="activePoint === 2 ? '#fff' : '#d62828'" :stroke="activePoint === 2 ? '#d62828' : 'none'" stroke-width="1.5" class="transition-all duration-300 pointer-events-none" />
                            <circle :cx="getPoint(radarScores[3], 3).x" :cy="getPoint(radarScores[3], 3).y" :r="activePoint === 3 ? 4 : 2" :fill="activePoint === 3 ? '#fff' : '#d62828'" :stroke="activePoint === 3 ? '#d62828' : 'none'" stroke-width="1.5" class="transition-all duration-300 pointer-events-none" />
                            <circle :cx="getPoint(radarScores[4], 4).x" :cy="getPoint(radarScores[4], 4).y" :r="activePoint === 4 ? 4 : 2" :fill="activePoint === 4 ? '#fff' : '#d62828'" :stroke="activePoint === 4 ? '#d62828' : 'none'" stroke-width="1.5" class="transition-all duration-300 pointer-events-none" />
                            <circle :cx="getPoint(radarScores[5], 5).x" :cy="getPoint(radarScores[5], 5).y" :r="activePoint === 5 ? 4 : 2" :fill="activePoint === 5 ? '#fff' : '#d62828'" :stroke="activePoint === 5 ? '#d62828' : 'none'" stroke-width="1.5" class="transition-all duration-300 pointer-events-none" />
                            
                            <!-- Hitboxes (Invisible, larger area for smooth hover) -->
                            <circle :cx="getPoint(radarScores[0], 0).x" :cy="getPoint(radarScores[0], 0).y" r="10" fill="transparent" class="cursor-pointer" @mouseenter="activePoint = 0" @mouseleave="activePoint = null" />
                            <circle :cx="getPoint(radarScores[1], 1).x" :cy="getPoint(radarScores[1], 1).y" r="10" fill="transparent" class="cursor-pointer" @mouseenter="activePoint = 1" @mouseleave="activePoint = null" />
                            <circle :cx="getPoint(radarScores[2], 2).x" :cy="getPoint(radarScores[2], 2).y" r="10" fill="transparent" class="cursor-pointer" @mouseenter="activePoint = 2" @mouseleave="activePoint = null" />
                            <circle :cx="getPoint(radarScores[3], 3).x" :cy="getPoint(radarScores[3], 3).y" r="10" fill="transparent" class="cursor-pointer" @mouseenter="activePoint = 3" @mouseleave="activePoint = null" />
                            <circle :cx="getPoint(radarScores[4], 4).x" :cy="getPoint(radarScores[4], 4).y" r="10" fill="transparent" class="cursor-pointer" @mouseenter="activePoint = 4" @mouseleave="activePoint = null" />
                            <circle :cx="getPoint(radarScores[5], 5).x" :cy="getPoint(radarScores[5], 5).y" r="10" fill="transparent" class="cursor-pointer" @mouseenter="activePoint = 5" @mouseleave="activePoint = null" />
                            
                            <!-- Labels -->
                            <text x="50" y="3" font-size="7" text-anchor="middle" font-weight="bold" :fill="activePoint === 0 ? '#d62828' : '#6b7280'" class="transition-colors">Word</text>
                            <text x="91" y="30" font-size="7" text-anchor="start" font-weight="bold" :fill="activePoint === 1 ? '#d62828' : '#6b7280'" class="transition-colors">Kotoba</text>
                            <text x="91" y="74" font-size="7" text-anchor="start" font-weight="bold" :fill="activePoint === 2 ? '#d62828' : '#6b7280'" class="transition-colors">Bunpou</text>
                            <text x="50" y="100" font-size="7" text-anchor="middle" font-weight="bold" :fill="activePoint === 3 ? '#d62828' : '#6b7280'" class="transition-colors">Kanji</text>
                            <text x="9" y="74" font-size="7" text-anchor="end" font-weight="bold" :fill="activePoint === 4 ? '#d62828' : '#6b7280'" class="transition-colors">Choukai</text>
                            <text x="9" y="30" font-size="7" text-anchor="end" font-weight="bold" :fill="activePoint === 5 ? '#d62828' : '#6b7280'" class="transition-colors">Kaiwa</text>
                        </svg>
                        
                        <div x-show="activePoint !== null" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90" class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white/95 backdrop-blur-sm border border-red-100 shadow-md rounded-lg px-2 py-1 pointer-events-none z-10" style="display: none;">
                            <p class="text-[9px] font-bold text-gray-500 uppercase tracking-wider text-center" x-text="activePoint !== null ? labels[activePoint] : ''"></p>
                            <p class="text-sm font-bold text-[#d62828] text-center leading-none mt-0.5" x-text="activePoint !== null ? radarScores[activePoint] : ''"></p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Weekly Log -->
            <section>
                <h4 class="text-sm font-bold text-gray-800 mb-3">Catatan Mingguan</h4>
                <button @click="showAddWeekly = true; weeklyFormTitle = 'Draf - Minggu Baru'; editWeeklyId = null; document.getElementById('weeklyForm').reset();" x-show="!showAddWeekly" class="w-full py-3 bg-[#d62828] text-white rounded-xl text-xs font-bold shadow-sm hover:bg-red-700 transition flex justify-center items-center gap-2 mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Catatan Mingguan
                </button>
                
                <!-- Add Weekly Form Draft -->
                <form id="weeklyForm" action="#" method="POST" @submit.prevent="saveWeeklyLog" x-show="showAddWeekly" x-transition class="bg-white border border-red-100 rounded-2xl p-5 shadow-sm mb-4" style="display: none;">
                    @csrf
                    <h5 class="text-xs font-bold text-gray-800 mb-4" x-text="weeklyFormTitle"></h5>
                    <div class="space-y-1.5 mb-4">
                        <x-input-label>Minggu Ke (Week)</x-input-label>
                        <x-text-input type="number" name="minggu_ke" placeholder="mis. 1" class="w-full" required />
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div class="space-y-1.5">
                            <x-input-label>Word</x-input-label>
                            <x-text-input type="number" name="score_word" placeholder="1-100" class="w-full" min="0" max="100" required />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Kotoba</x-input-label>
                            <x-text-input type="number" name="score_kotoba" placeholder="1-100" class="w-full" min="0" max="100" required />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Bunpou</x-input-label>
                            <x-text-input type="number" name="score_bunpou" placeholder="1-100" class="w-full" min="0" max="100" required />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Kanji</x-input-label>
                            <x-text-input type="number" name="score_kanji" placeholder="1-100" class="w-full" min="0" max="100" required />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Choukai</x-input-label>
                            <x-text-input type="number" name="score_choukai" placeholder="1-100" class="w-full" min="0" max="100" required />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Kaiwa</x-input-label>
                            <x-text-input type="number" name="score_kaiwa" placeholder="1-100" class="w-full" min="0" max="100" required />
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" @click="showAddWeekly = false" class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-bold transition">Batal</button>
                        <button type="submit" class="flex-1 py-2.5 bg-[#d62828] hover:bg-red-700 text-white rounded-xl text-xs font-bold shadow-sm transition">Simpan</button>
                    </div>
                </form>

                <!-- Accordions -->
                <div class="space-y-3">
                    <template x-for="(log, index) in weeklyLogs" :key="log.id_catatan_mingguan">
                        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm transition-all duration-200" x-data="{ open: false }" :class="open ? 'ring-1 ring-red-100' : ''">
                            <button @click="open = !open" class="w-full px-5 py-4 flex items-center justify-between bg-white hover:bg-gray-50 transition outline-none">
                                <div class="flex items-center gap-3">
                                    <div class="w-6 h-6 rounded flex items-center justify-center transition-all duration-300" :class="open ? 'rotate-90 bg-red-50 text-red-500' : 'bg-gray-50 text-gray-400'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                    <span class="font-bold text-sm text-gray-800" x-text="'Minggu ' + log.minggu_ke"></span>
                                </div>
                                <span class="text-xs font-bold text-gray-500">Rata-rata: <span class="text-gray-800" x-text="Math.round((log.score_word + log.score_kotoba + log.score_bunpou + log.score_kanji + log.score_choukai + log.score_kaiwa) / 6)"></span></span>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                                <div class="px-5 pb-5 pt-2 border-t border-gray-50">
                                    <div class="grid grid-cols-6 gap-2 mb-5">
                                        <div class="text-center"><p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Word</p><p class="text-sm font-bold text-gray-800 mt-1" x-text="log.score_word"></p></div>
                                        <div class="text-center"><p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Kotoba</p><p class="text-sm font-bold text-gray-800 mt-1" x-text="log.score_kotoba"></p></div>
                                        <div class="text-center"><p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Bunpou</p><p class="text-sm font-bold text-gray-800 mt-1" x-text="log.score_bunpou"></p></div>
                                        <div class="text-center"><p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Kanji</p><p class="text-sm font-bold text-gray-800 mt-1" x-text="log.score_kanji"></p></div>
                                        <div class="text-center"><p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Choukai</p><p class="text-sm font-bold text-gray-800 mt-1" x-text="log.score_choukai"></p></div>
                                        <div class="text-center"><p class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Kaiwa</p><p class="text-sm font-bold text-gray-800 mt-1" x-text="log.score_kaiwa"></p></div>
                                    </div>
                                    <div class="flex justify-between items-center pt-3 border-t border-gray-50">
                                        <span class="text-[10px] font-semibold text-gray-400" x-text="'Diperbarui: ' + new Date(log.updated_at).toLocaleDateString()"></span>
                                        <div class="flex gap-4">
                                            <button type="button" @click="openEditWeekly(log)" class="text-[11px] font-bold text-yellow-600 hover:text-yellow-700 flex items-center gap-1.5 transition"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit</button>
                                            <button type="button" @click="showDeleteConfirm = true; deleteTargetName = 'Catatan Mingguan (Minggu ' + log.minggu_ke + ')'; deleteId = log.id_catatan_mingguan; deleteType = 'weekly'" class="text-[11px] font-bold text-red-500 hover:text-red-600 flex items-center gap-1.5 transition"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </section>

            <!-- Evaluation Log -->
            <section>
                <h4 class="text-sm font-bold text-gray-800 mb-3">Catatan Evaluasi</h4>
                <button @click="showAddEvaluation = true; evalFormTitle = 'Draf - Evaluasi Baru'; editEvalId = null; editEvalTipe = ''; editEvalJawaban = []; document.getElementById('evalForm').reset();" x-show="!showAddEvaluation" class="w-full py-3 bg-[#d62828] text-white rounded-xl text-xs font-bold shadow-sm hover:bg-red-700 transition flex justify-center items-center gap-2 mb-4">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Catatan Evaluasi
                </button>
                
                <!-- Add Evaluation Form Draft -->
                <form id="evalForm" action="#" method="POST" @submit.prevent="saveEvaluationLog" x-show="showAddEvaluation" x-transition class="bg-white border border-red-100 rounded-2xl p-5 shadow-sm mb-4" style="display: none;">
                    @csrf
                    <h5 class="text-xs font-bold text-gray-800 mb-4" x-text="evalFormTitle"></h5>
                    
                    <!-- Informasi Ujian Online Section (View Only) -->
                    <div x-show="editEvalTipe && editEvalTipe.toLowerCase() === 'online'" class="mb-5 space-y-4" style="display: none;">
                        <div class="bg-red-50/50 border border-red-100 rounded-xl p-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Status</p>
                                    <div class="inline-flex items-center gap-1.5 bg-red-100 text-[#d62828] px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Telah Dinilai
                                    </div>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Skor Akhir</p>
                                    <p class="text-3xl font-black text-[#d62828]" x-text="editEvalObj ? editEvalObj.skor : '-'"></p>
                                </div>
                                <div class="col-span-2 pt-3 border-t border-red-100/50">
                                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Disubmit Pada</p>
                                    <p class="text-sm font-bold text-gray-800" x-text="editEvalObj ? new Date(editEvalObj.created_at).toLocaleString('id-ID', {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute:'2-digit'}) : '-'"></p>
                                </div>
                                <div class="col-span-2 pt-3 border-t border-red-100/50">
                                    <p class="text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Diperbarui Pada</p>
                                    <p class="text-sm font-bold text-gray-800" x-text="editEvalObj ? new Date(editEvalObj.updated_at).toLocaleString('id-ID', {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute:'2-digit'}) : '-'"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1.5 mb-4" x-show="!editEvalTipe || editEvalTipe.toLowerCase() !== 'online'">
                        <x-input-label>Nama Evaluasi</x-input-label>
                        <x-text-input type="text" name="nama_evaluasi" placeholder="mis. UTS 2" class="w-full" />
                    </div>
                    
                    <input type="hidden" name="tipe_ujian" x-bind:value="editEvalTipe || 'Offline'">
                    
                    <div class="space-y-1.5 mb-5" x-show="!editEvalTipe || editEvalTipe.toLowerCase() !== 'online'">
                        <x-input-label>Skor</x-input-label>
                        <x-text-input type="number" name="skor" placeholder="1-100" class="w-full" required />
                    </div>
                    <div class="flex gap-2">
                        <button type="button" @click="showAddEvaluation = false" class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl text-xs font-bold transition" x-text="(!editEvalTipe || editEvalTipe.toLowerCase() !== 'online') ? 'Batal' : 'Tutup'"></button>
                        <button type="submit" x-show="!editEvalTipe || editEvalTipe.toLowerCase() !== 'online'" class="flex-1 py-2.5 bg-[#d62828] hover:bg-red-700 text-white rounded-xl text-xs font-bold shadow-sm transition">Simpan</button>
                    </div>
                </form>

                <!-- Evaluation Accordions -->
                <div class="space-y-3 pb-10">
                    <template x-for="(eval, index) in evaluations" :key="eval.id_catatan_evaluasi">
                        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm transition-all duration-200" x-data="{ open: false }" :class="open ? 'ring-1 ring-red-100' : ''">
                            <button @click="open = !open" class="w-full px-5 py-4 flex items-center justify-between bg-white hover:bg-gray-50 transition outline-none">
                                <div class="flex items-center gap-3">
                                    <div class="w-6 h-6 rounded flex items-center justify-center transition-all duration-300" :class="open ? 'rotate-90 bg-red-50 text-red-500' : 'bg-gray-50 text-gray-400'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-bold text-sm text-gray-800" x-text="eval.nama_evaluasi"></span>
                                        <span class="px-2 py-0.5 bg-orange-50 text-orange-600 rounded text-[9px] font-bold tracking-wide uppercase border border-orange-100" x-text="eval.tipe_ujian || 'Offline'"></span>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-gray-500">Skor: <span class="text-gray-800" x-text="eval.skor"></span></span>
                            </button>
                            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                                <div class="px-5 pb-5 pt-2 border-t border-gray-50">
                                    <div class="mb-4">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Tipe Ujian</p>
                                        <p class="text-sm font-bold text-gray-800" x-text="eval.tipe_ujian || 'Ujian Reguler'"></p>
                                    </div>
                                    <div class="flex justify-between items-center pt-3 border-t border-gray-50">
                                        <span class="text-[10px] font-semibold text-gray-400" x-text="'Diperbarui: ' + new Date(eval.updated_at).toLocaleDateString()"></span>
                                        <div class="flex gap-4">
                                            <template x-if="!eval.tipe_ujian || eval.tipe_ujian.toLowerCase() !== 'online'">
                                                <button type="button" @click="openEditEval(eval)" class="text-[11px] font-bold text-yellow-600 hover:text-yellow-700 flex items-center gap-1.5 transition"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit</button>
                                            </template>
                                            <template x-if="eval.tipe_ujian && eval.tipe_ujian.toLowerCase() === 'online'">
                                                <button type="button" @click="openEditEval(eval)" class="text-[11px] font-bold text-[#d62828] hover:text-red-700 flex items-center gap-1.5 transition"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg> Lihat</button>
                                            </template>
                                            <button type="button" x-show="!eval.tipe_ujian || eval.tipe_ujian.toLowerCase() !== 'online'" @click="showDeleteConfirm = true; deleteTargetName = 'Catatan Evaluasi (' + eval.nama_evaluasi + ')'; deleteId = eval.id_catatan_evaluasi; deleteType = 'evaluation'" class="text-[11px] font-bold text-red-500 hover:text-red-600 flex items-center gap-1.5 transition"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg> Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </section>

        </div>

        <!-- Custom Delete Confirmation Modal -->
        <div x-show="showDeleteConfirm" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-[200] flex items-center justify-center p-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="display: none;" x-cloak>
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden" @click.away="showDeleteConfirm = false" x-show="showDeleteConfirm" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                <div class="p-6 text-center">
                    <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-red-100">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Hapus Catatan?</h3>
                    <p class="text-sm text-gray-500 mb-6">Yakin ingin menghapus <span class="font-bold text-gray-800" x-text="deleteTargetName"></span>? Tindakan ini tidak dapat dibatalkan.</p>
                    <div class="flex gap-3">
                        <button @click="showDeleteConfirm = false" type="button" class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl text-sm font-bold transition outline-none focus:ring-2 focus:ring-gray-200">Batal</button>
                        <button type="button" @click="deleteLog(deleteId, deleteType)" class="w-full flex-1 py-2.5 bg-[#d62828] hover:bg-red-700 text-white rounded-xl text-sm font-bold shadow-sm transition outline-none focus:ring-2 focus:ring-red-500/50">Ya, Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </template>
</div>
@endsection

@push('styles')
<style>
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        display: none;
    }
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        let table = null;

        @if($selectedBatchId && $selectedClassId)
        table = $('#progress-table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: "{!! route('teacher.progress-report', ['batch_id' => $selectedBatchId, 'class_id' => $selectedClassId]) !!}",
                data: function (d) {
                    d.status = $('#dt-status').val() || 'all';
                    d.search.value = $('#dt-search').val() || ''; 
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('py-4 px-4 text-sm font-semibold text-gray-600'); } },
                { data: 'formatted_id', name: 'users.id', createdCell: function(td) { $(td).addClass('py-4 px-4 text-sm font-semibold text-gray-600'); } },
                { data: 'name', name: 'users.name', createdCell: function(td) { $(td).addClass('py-4 px-4'); }, render: function(data, type, row) {
                    return `<div class="flex items-center gap-3">
                                <img src="${row.avatar_url}" alt="${data}" class="w-8 h-8 rounded-full object-cover">
                                <span class="text-sm font-bold text-gray-800">${data}</span>
                            </div>`;
                }},
                { data: 'progress_modul', name: 'progress_modul', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('py-4 px-4'); }, render: function(data) {
                    return `<div class="flex items-center gap-3">
                                <div class="w-24 h-2 bg-red-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#d62828] rounded-full" style="width: ${data}%"></div>
                                </div>
                                <span class="text-xs font-bold text-gray-600 w-8">${data}%</span>
                            </div>`;
                }},
                { data: 'rata_rata_tugas', name: 'rata_rata_tugas', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('py-4 px-4 text-sm font-bold text-gray-600'); } },
                { data: 'nilai_evaluasi', name: 'nilai_evaluasi', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('py-4 px-4 text-sm font-bold text-gray-600'); } },
                { data: 'status_badge', name: 'status_badge', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('py-4 px-4'); } },
                { data: 'action', name: 'action', orderable: false, searchable: false, createdCell: function(td) { $(td).addClass('py-4 px-4 text-center'); } }
            ],
            dom: '<"w-full overflow-x-auto"t>',
            drawCallback: function(settings) {
                var api = this.api();
                var info = api.page.info();
                
                $('#custom-dt-info').html(
                    'Menampilkan ' + (info.recordsDisplay > 0 ? info.start + 1 : 0) + ' - ' + info.end + ' dari ' + info.recordsDisplay + ' data.'
                );
                
                let paginationHtml = '';
                let currentPage = info.page;
                let totalPages = info.pages;

                if (totalPages > 0) {
                    let prevDisabled = currentPage === 0;
                    let prevClass = prevDisabled 
                        ? 'bg-red-50 text-red-300 cursor-not-allowed opacity-70' 
                        : 'bg-red-50 text-[#d62828] hover:bg-red-100 cursor-pointer';
                        
                    paginationHtml += `<button class="dt-paginate-btn w-9 h-9 flex items-center justify-center rounded-xl transition shadow-sm ${prevClass}" data-action="previous" ${prevDisabled ? 'disabled' : ''}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                    </button>`;

                    let startPage = Math.max(0, currentPage - 1);
                    let endPage = Math.min(totalPages - 1, currentPage + 1);

                    if (currentPage === 0) endPage = Math.min(totalPages - 1, 2);
                    if (currentPage === totalPages - 1) startPage = Math.max(0, totalPages - 3);

                    for (let i = startPage; i <= endPage; i++) {
                        let activeClass = i === currentPage 
                            ? 'bg-[#d62828] text-white shadow-sm hover:bg-red-700' 
                            : 'bg-white border border-gray-200 text-gray-600 font-bold hover:bg-gray-50';
                            
                        paginationHtml += `<button class="dt-paginate-btn w-9 h-9 flex items-center justify-center rounded-xl text-sm transition shadow-sm ${activeClass}" data-action="${i}">
                            ${i + 1}
                        </button>`;
                    }

                    let nextDisabled = currentPage === totalPages - 1;
                    let nextClass = nextDisabled 
                        ? 'bg-[#d62828]/50 text-white cursor-not-allowed' 
                        : 'bg-[#d62828] text-white hover:bg-red-700 cursor-pointer';
                        
                    paginationHtml += `<button class="dt-paginate-btn w-9 h-9 flex items-center justify-center rounded-xl transition shadow-sm ${nextClass}" data-action="next" ${nextDisabled ? 'disabled' : ''}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                    </button>`;
                }

                $('#custom-dt-pagination').html(paginationHtml);
            }
        });

        $('#dt-search').on('keyup', function() { table.draw(); });
        $('#dt-status').on('change', function() { table.draw(); });
        $('#custom-dt-length').on('change', function() { table.page.len($(this).val()).draw(); });
        
        $('#custom-dt-pagination').on('click', '.dt-paginate-btn', function() {
            let action = $(this).data('action');
            if (action !== undefined) {
                if (action === 'previous') {
                    table.page('previous').draw('page');
                } else if (action === 'next') {
                    table.page('next').draw('page');
                } else {
                    table.page(action).draw('page');
                }
            }
        });
        @endif
    });
</script>
@endpush
