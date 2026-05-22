<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $task->judul_tugas ?? 'Task Detail' }} - LPK Seishin</title>
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

    <aside id="sidebar" class="w-64 h-screen bg-[#FFF9F4] flex flex-col flex-none shadow-none hidden lg:flex">
        <div class="p-6">
            <x-application-logo class="h-14 w-auto" />
        </div>
        <div class="px-4 mt-2 flex-1">
            <p class="text-xs font-bold text-[#444444] mb-3 px-2 tracking-wider">OVERVIEW</p>
            <nav class="space-y-1">
                <a href="{{ route('students.dashboard') }}" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 bg-[#FFDBDB] text-[#DB2A2A] px-4 py-3 rounded-xl font-bold text-sm">
                    Enrolled
                </a>
                <a href="#" class="flex items-center gap-3 text-gray-600 hover:bg-gray-50 px-4 py-3 rounded-xl font-semibold text-sm transition">
                    My Task
                </a>
            </nav>
        </div>
        <div class="p-4">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-5 py-2.5 gap-2 text-[#DB2A2A] bg-white border border-gray-200 hover:bg-red-50 rounded-xl font-bold text-sm transition justify-center">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="px-8 py-6 bg-transparent text-left">
            <h2 class="text-lg font-bold text-[#222222]">こんにちわ, {{ Auth::user()->name }}! 👋</h2>
            <p id="realtime-clock" class="text-xs text-[#444444] font-medium mt-0.5">Memuat waktu...</p>
        </header>

        <main class="flex-1 bg-white rounded-t-[20px] lg:rounded-[40px] mr-0 lg:mr-8 mb-0 lg:mb-8 overflow-y-auto shadow-sm custom-scrollbar">
            <div class="p-6 lg:p-10 space-y-6">
                
                <nav class="text-xs font-bold text-[#444444] uppercase tracking-widest text-left">
                    Enrolled <span class="mx-2">></span> 
                    <a href="{{ route('subjects.show', $subject->id_mapel) }}" class="hover:text-[#DB2A2A] transition">{{ $subject->nama_mapel }}</a> 
                    <span class="mx-2">></span> 
                    <a href="{{ route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul]) }}" class="hover:text-[#DB2A2A] transition">{{ $currentModul->nama_modul }}</a> 
                    <span class="mx-2">></span> 
                    <span class="text-[#DB2A2A]">{{ $task->judul_tugas }}</span>
                </nav>

                <h1 class="text-2xl lg:text-3xl font-black text-[#222222] tracking-tight text-left">
                    {{ $task->judul_tugas }}
                </h1>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Module</p>
                        <p class="text-sm font-black text-[#222222] mt-1 truncate">{{ $currentModul->nama_modul }}</p>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Task Status</p>
                        <p class="text-sm font-black text-[#222222] mt-1">
                            @if(!$submission) 
                                Not yet sent 
                            @else 
                                {{ $submission->status === 'terlambat' ? 'Awaiting Assessment' : ucfirst($submission->status) }} 
                            @endif
                        </p>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Due Date</p>
                        <p class="text-sm font-black text-[#222222] mt-1">
                            {{ \Carbon\Carbon::parse($task->waktu_pengumpulan)->format('d M Y, H:i') }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 text-left">
                    
                    <div class="lg:col-span-8 space-y-6 flex flex-col">
                        <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm space-y-4 flex-1">
                            <h3 class="text-sm font-bold text-[#222222] uppercase tracking-wider">Task Description</h3>
                            <div class="text-sm text-[#444444] leading-relaxed font-medium space-y-3">
                                {!! $task->deskripsi_tugas !!}
                            </div>
                        </div>

                        {{-- AREA RESOURCE DOCUMENT (Hanya muncul kalau field dari DB ada isinya) --}}
                        @if(!empty($task->resource_file_name ?? 'Template__N4__Exercise__01.pdf'))
                        <div class="space-y-3">
                            <h3 class="text-sm font-bold text-[#222222] uppercase tracking-wider">Resource</h3>
                            <div class="max-w-xl flex items-center justify-between p-4 bg-white border border-gray-100 rounded-2xl shadow-sm gap-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-11 h-11 bg-red-50 text-[#DB2A2A] rounded-xl flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs font-bold text-[#222222] truncate">{{ $task->resource_file_name ?? 'Template__N4__Exercise__01.pdf' }}</p>
                                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wide">PDF</p>
                                    </div>
                                </div>
                                <a href="#" class="px-4 py-2 border border-[#DB2A2A] text-[#DB2A2A] text-xs font-bold rounded-xl flex items-center gap-1.5 hover:bg-red-50 transition duration-200 flex-shrink-0 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16v1a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3v-1m-4-4l-4 4V4"/>
                                    </svg>
                                    <span>Download</span>
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="lg:col-span-4 space-y-6">
                        
                        <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-bold text-[#222222]">Your Work</h3>
                                @php
                                    $isLate = $submission && $submission->status === 'terlambat';
                                @endphp
                                <span class="text-[10px] font-bold uppercase tracking-wider {{ $submission ? ($isLate ? 'text-amber-500' : 'text-green-500') : 'text-gray-400' }}">
                                    @if(!$submission) Incompleted @elseif($isLate) Submitted Late @else Submitted @endif
                                </span>
                            </div>

                            @if(!$submission)
                                <form action="{{ route('tasks.submit', ['id_mapel' => $id_mapel, 'id_modul' => $id_modul, 'id_tugas' => $id_tugas]) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <label class="w-full h-12 border-2 border-dashed border-gray-200 hover:border-[#DB2A2A] rounded-xl flex items-center justify-center gap-2 text-xs font-bold text-gray-500 cursor-pointer transition bg-gray-50/50">
                                        <svg class="w-4 h-4 text-[#DB2A2A]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5h10.5a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0016.5 4.5H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25z"/>
                                        </svg>
                                        <span>Upload File</span>
                                        <input type="file" name="task_file" class="hidden">
                                    </label>
                                    <button type="submit" class="w-full bg-[#DB2A2A] hover:bg-red-700 text-white font-bold py-2.5 rounded-xl text-xs shadow-sm transition duration-200">
                                        Mark as Done
                                    </button>
                                </form>
                            @else
                                <div class="space-y-4">
                                    <div class="p-3 bg-gray-50 border border-gray-100 rounded-xl flex items-center gap-2 min-w-0">
                                        <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-xs font-bold text-gray-700 truncate flex-1">
                                            {{ !empty($submission->file_path) ? basename($submission->file_path) : 'Ahmad__N4__Exercise__01.pdf' }}
                                        </p>
                                    </div>
                                    <form action="{{ route('tasks.cancel', ['id_mapel' => $id_mapel, 'id_modul' => $id_modul, 'id_tugas' => $id_tugas]) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-center text-red-500 hover:text-red-700 font-bold text-xs transition py-1 block bg-transparent hover:underline">
                                            Cancel Submit
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>

                        <div class="bg-white border border-gray-100 rounded-[24px] p-4 px-6 shadow-sm flex items-center justify-between">
                            <h3 class="text-sm font-bold text-[#222222]">Score</h3>
                            <span class="text-xs font-bold text-gray-500">
                                @if($submission && isset($submission->nilai) && !is_null($submission->nilai)) 
                                    <span class="text-base font-black text-green-600">{{ $submission->nilai }}</span> / 100 
                                @else 
                                    Awaiting Assessment 
                                @endif
                            </span>
                        </div>

                        <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm space-y-4">
                            <h3 class="text-sm font-bold text-[#222222]">Sensei Feedback</h3>
                            
                            <div class="flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name=Neida+Nurfadillah&background=FFDBDB&color=DB2A2A" class="w-9 h-9 rounded-full flex-shrink-0">
                                <div>
                                    <h4 class="text-xs font-black text-[#222222]">Neida Nurfadillah</h4>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Sensei</p>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 border border-gray-100 rounded-xl p-3.5 text-xs text-gray-500 font-medium min-h-[60px] flex items-center justify-center text-center">
                                @if($submission && !empty($submission->text_content))
                                    {{ $submission->text_content }}
                                @else
                                    Nothing yet here
                                @endif
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </main>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateString = now.toLocaleDateString('id-ID', optionsDate);
            
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            document.getElementById('realtime-clock').innerText = `${dateString} • ${hours}.${minutes}.${seconds}`;
        }
        setInterval(updateClock, 1000); 
        updateClock();
    </script>
</body>
</html>