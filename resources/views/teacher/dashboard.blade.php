@extends('layouts.teacher')

@section('title', 'Dashboard Sensei - LPK Seishin')

@section('content')
@php
    // Dummy Data untuk Design
    if (!isset($needReviewCount)) $needReviewCount = 12;
    if (!isset($activeClassesCount)) $activeClassesCount = 3;
    if (!isset($totalStudentsCount)) $totalStudentsCount = 45;
    if (!isset($todayScheduleCount)) $todayScheduleCount = 2;

    if (!isset($teacherSubjects) || (is_countable($teacherSubjects) && count($teacherSubjects) == 0)) {
        $teacherSubjects = [
            (object)[
                'batch' => (object)['nama_batch' => 'Batch 2'],
                'nama_mapel' => 'N4 Mastering',
                'modul_count' => 7,
                'students_count' => 45,
                'id_mapel' => 1
            ],
            (object)[
                'batch' => (object)['nama_batch' => 'Batch 2'],
                'nama_mapel' => 'N5 Mastering',
                'modul_count' => 8,
                'students_count' => 45,
                'id_mapel' => 2
            ]
        ];
    }

    if (!isset($todaySchedules) || (is_countable($todaySchedules) && count($todaySchedules) == 0)) {
        $todaySchedules = [
            (object)[
                'batch' => (object)['nama_batch' => '5'],
                'jam_mulai' => '13.00',
                'jam_selesai' => '15.00'
            ],
            (object)[
                'batch' => (object)['nama_batch' => '4'],
                'jam_mulai' => '10.00',
                'jam_selesai' => '12.00'
            ]
        ];
    }

    if (!isset($pendingTasks) || (is_countable($pendingTasks) && count($pendingTasks) == 0)) {
        $pendingTasks = [
            (object)[
                'student' => (object)['name' => 'Roronoa Z'],
                'batch' => (object)['nama_batch' => 'Batch 4'],
                'modul' => (object)['nama_modul' => 'N5 Mastering: Latihan Dokkai'],
                'submitted_at' => \Carbon\Carbon::now()->subMinutes(10),
                'id_tugas' => 1
            ],
            (object)[
                'student' => (object)['name' => 'Nami'],
                'batch' => (object)['nama_batch' => 'Batch 3'],
                'modul' => (object)['nama_modul' => 'Grammar Drill: Verb Conjugations'],
                'submitted_at' => \Carbon\Carbon::now()->subMinutes(30),
                'id_tugas' => 2
            ],
            (object)[
                'student' => (object)['name' => 'Sanji'],
                'batch' => (object)['nama_batch' => 'Batch 5'],
                'modul' => (object)['nama_modul' => 'Kanji Practice: Intermediate Level'],
                'submitted_at' => \Carbon\Carbon::now()->subHours(1),
                'id_tugas' => 3
            ],
            (object)[
                'student' => (object)['name' => 'Usopp'],
                'batch' => (object)['nama_batch' => 'Batch 2'],
                'modul' => (object)['nama_modul' => 'Vocabulary Expansion: Food Items'],
                'submitted_at' => \Carbon\Carbon::now()->subHours(2),
                'id_tugas' => 4
            ],
            (object)[
                'student' => (object)['name' => 'Tony Tony Chopper'],
                'batch' => (object)['nama_batch' => 'Batch 1'],
                'modul' => (object)['nama_modul' => 'Listening Comprehension: Daily Conversations'],
                'submitted_at' => \Carbon\Carbon::now()->subHours(3),
                'id_tugas' => 5
            ],
            (object)[
                'student' => (object)['name' => 'Nico Robin'],
                'batch' => (object)['nama_batch' => 'Batch 4'],
                'modul' => (object)['nama_modul' => 'Reading Practice: Short Stories'],
                'submitted_at' => \Carbon\Carbon::now()->subHours(5),
                'id_tugas' => 6
            ],
        ];
    }
@endphp
            <div class="p-4 sm:p-6 lg:p-10">

                <div class="mb-6">
                    <h1 class="text-xl sm:text-2xl lg:text-[26px] font-bold font-ibm text-gray-900 tracking-tight">Beranda</h1>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Pemantauan Belajar</p>
                </div>

                {{-- Banner --}}
                <div class="banner-red rounded-3xl lg:rounded-[32px] py-8 sm:py-10 lg:py-12 px-6 sm:px-8 lg:px-10 mb-8 flex flex-col lg:flex-row items-start lg:items-center justify-between relative gap-6">
                    <div class="relative z-10 w-full lg:w-2/3">
                        <h2 class="text-3xl sm:text-4xl lg:text-[42px] font-bold font-ibm text-white leading-normal lg:leading-[52px] mb-3">Welcome Back,<br>{{ Auth::user()->name }} Sensei</h2>
                        <p class="text-white/90 text-xs sm:text-sm font-medium">Berikut adalah ringkasan kelas dan tugas yang perlu<br class="hidden sm:block"> Anda tangani hari ini.</p>
                    </div>
                    <div class="relative z-10 bg-white/10 border border-white/20 rounded-2xl p-5 sm:p-6 text-center shadow-lg w-full sm:w-52 flex-shrink-0">
                        <p id="banner-clock-date" class="text-[10px] sm:text-xs text-white font-bold mb-1">
                            Memuat...
                        </p>
                        <h3 id="banner-clock-time" class="text-4xl sm:text-5xl font-bold text-white tracking-wider leading-tight mb-2">
                            --.--
                        </h3>
                        <div class="mt-2 inline-block bg-white/20 px-3 py-1 rounded-full">
                            <p class="text-[9px] sm:text-[10px] text-white font-bold uppercase tracking-wider">WIB</p>
                        </div>
                    </div>
                </div>

                {{-- Summary Stats --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-8">
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 sm:p-5 shadow-sm flex flex-col">
                        <p class="text-[10px] sm:text-xs font-bold text-gray-800 mb-4">Perlu Diperiksa</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 sm:w-12 h-10 sm:h-12 rounded-[10px] border-none shadow-[0_4px_12px_rgba(214,40,40,0.1)] bg-white flex items-center justify-center text-red-500 flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-none mb-1">
                                    {{ $needReviewCount }}
                                </h4>
                                <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium leading-tight">Tugas menunggu penilaian</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-2xl p-4 sm:p-5 shadow-sm flex flex-col">
                        <p class="text-[10px] sm:text-xs font-bold text-gray-800 mb-4">Kelas Aktif</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 sm:w-12 h-10 sm:h-12 rounded-[10px] border-none shadow-[0_4px_12px_rgba(214,40,40,0.1)] bg-white flex items-center justify-center text-red-500 flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-none mb-1">
                                    {{ $activeClassesCount }}
                                </h4>
                                <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium leading-tight">Angkatan yang sedang berjalan</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-2xl p-4 sm:p-5 shadow-sm flex flex-col">
                        <p class="text-[10px] sm:text-xs font-bold text-gray-800 mb-4">Total Siswa</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 sm:w-12 h-10 sm:h-12 rounded-[10px] border-none shadow-[0_4px_12px_rgba(214,40,40,0.1)] bg-white flex items-center justify-center text-red-500 flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-none mb-1">
                                    {{ $totalStudentsCount }}
                                </h4>
                                <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium leading-tight">Terdaftar di kelas Anda</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-2xl p-4 sm:p-5 shadow-sm flex flex-col">
                        <p class="text-[10px] sm:text-xs font-bold text-gray-800 mb-4">Jadwal Hari Ini</p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 sm:w-12 h-10 sm:h-12 rounded-[10px] border-none shadow-[0_4px_12px_rgba(214,40,40,0.1)] bg-white flex items-center justify-center text-red-500 flex-shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex flex-col justify-center">
                                <h4 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-none mb-1">
                                    {{ $todayScheduleCount }}
                                </h4>
                                <p class="text-[8px] sm:text-[10px] text-gray-500 font-medium leading-tight">Sesi untuk hari ini</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- My Class & Today Schedule --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">

                    {{-- My Class --}}
                    <div class="col-span-1 lg:col-span-2">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <h3 class="font-bold text-gray-800 text-sm">Kelas Saya</h3>
                            </div>
                            <a href="{{ route('teacher.classes') }}" class="text-red-500 text-xs font-bold flex items-center gap-1 hover:text-red-700 transition">
                                Lihat Semua Kelas
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($teacherSubjects as $subject)
                            <div class="bg-white border border-gray-100 rounded-2xl lg:rounded-3xl p-5 sm:p-6 shadow-sm relative flex flex-col gap-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center gap-2">
                                        <div class="w-12 sm:w-14 h-12 sm:h-14 rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-gray-50 bg-white flex items-center justify-center text-[#d62828] font-bold text-lg sm:text-xl flex-shrink-0">
                                            あa
                                        </div>
                                        <div class="w-12 sm:w-14 h-12 sm:h-14 rounded-xl shadow-[0_2px_10px_rgba(0,0,0,0.06)] border border-gray-50 bg-white flex flex-col items-center justify-center flex-shrink-0">
                                            <p class="text-lg sm:text-xl font-bold text-gray-900 leading-none">
                                                {{ $subject->modul_count ?? 0 }}
                                            </p>
                                            <p class="text-[8px] sm:text-[9px] text-gray-500 font-semibold mt-0.5">Module</p>
                                        </div>
                                    </div>
                                    <div class="bg-white border border-gray-100 shadow-sm px-2.5 sm:px-3 py-1 sm:py-1.5 rounded-full">
                                        <span class="text-[10px] md:text-[12px] font-semibold text-gray-500 whitespace-nowrap">{{ $subject->batch->nama_batch ?? 'Batch' }}</span>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 leading-snug line-clamp-2">{{ $subject->nama_mapel ?? 'Mata Pelajaran' }}</h4>
                                    <div class="flex justify-end">
                                        <a href="{{ route('teacher.subjects.show', $subject->id_mapel ?? 0) }}" class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-2 sm:py-2.5 px-5 sm:px-6 rounded-lg text-xs sm:text-sm transition shadow-sm flex items-center justify-center gap-2">
                                            Buka Kelas
                                            <svg class="w-3.5 sm:w-4 h-3.5 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-span-1 sm:col-span-2 text-center py-8 sm:py-10 bg-gray-50 rounded-2xl lg:rounded-3xl border border-dashed border-gray-300">
                                <p class="text-gray-500 italic text-xs sm:text-sm">Belum ada kelas yang tersedia.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- Today Schedule --}}
                    <div class="col-span-1">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <h3 class="font-bold text-gray-800 text-sm">Jadwal Hari Ini</h3>
                        </div>

                        <div class="space-y-3">
                            @forelse($todaySchedules as $schedule)
                            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm flex items-center gap-4">
                                <div class="w-10 sm:w-12 h-10 sm:h-12 border-none shadow-[0_4px_12px_rgba(214,40,40,0.1)] bg-white rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-sm sm:text-base font-bold text-gray-900 leading-snug">
                                        Mengajar di Kelas {{ $schedule->batch->nama_batch ?? 'Batch' }}
                                    </h4>
                                    <p class="text-[10px] sm:text-xs text-gray-500 font-semibold mt-1.5 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $schedule->jam_mulai ?? '00.00' }} - {{ $schedule->jam_selesai ?? '00.00' }}
                                    </p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 sm:py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                <p class="text-gray-500 italic text-xs sm:text-sm">Tidak ada jadwal hari ini.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Pending Task Review --}}
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            <h3 class="font-bold text-gray-800 text-sm">Tugas Menunggu Diperiksa</h3>
                        </div>
                        <a href="#" class="text-red-500 text-xs font-bold flex items-center gap-1 hover:text-red-700 transition">
                            Lihat Semua Tugas
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-2xl lg:rounded-3xl shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="text-left text-[10px] sm:text-xs font-bold text-gray-800 px-4 sm:px-6 py-3 sm:py-4 rounded-tl-xl">Siswa</th>
                                        <th class="text-left text-[10px] sm:text-xs font-bold text-gray-800 px-4 sm:px-6 py-3 sm:py-4">Angkatan</th>
                                        <th class="text-left text-[10px] sm:text-xs font-bold text-gray-800 px-4 sm:px-6 py-3 sm:py-4">Modul Tugas</th>
                                        <th class="text-left text-[10px] sm:text-xs font-bold text-gray-800 px-4 sm:px-6 py-3 sm:py-4 rounded-tr-xl">Dikirim</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($pendingTasks as $task)
                                    <tr class="hover:bg-gray-50/50 transition">
                                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                                            <span class="text-xs sm:text-sm font-semibold text-gray-800">{{ $task->student->name ?? '[Data: task.student.name]' }}</span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                                            <span class="text-xs sm:text-sm text-gray-600">{{ $task->batch->nama_batch ?? '[Data: task.batch.nama_batch]' }}</span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                                            <span class="text-xs sm:text-sm text-gray-600 line-clamp-1">{{ $task->modul->nama_modul ?? '[Data: task.modul.nama_modul]' }}</span>
                                        </td>
                                        <td class="px-4 sm:px-6 py-3 sm:py-4">
                                            <span class="text-xs sm:text-sm text-gray-500">{{ $task->submitted_at ? $task->submitted_at->diffForHumans() : '[Data: submitted_at]' }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-8 sm:py-10 text-gray-500 italic text-xs sm:text-sm">
                                            Tidak ada tugas yang perlu direview.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>



            @push('scripts')
            <script>
                function updateBannerClock() {
                    const now = new Date();
                    
                    const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    const dateString = now.toLocaleDateString('id-ID', optionsDate);
                    
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    const timeString = `${hours}.${minutes}`;
                    
                    const dateEl = document.getElementById('banner-clock-date');
                    const timeEl = document.getElementById('banner-clock-time');
                    
                    if(dateEl) dateEl.innerText = dateString;
                    if(timeEl) timeEl.innerText = timeString;
                }
                
                setInterval(updateBannerClock, 1000);
                updateBannerClock();
            </script>
            @endpush
@endsection