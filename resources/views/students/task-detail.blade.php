@extends('layouts.student')

@section('title', ($task->judul_tugas ?? 'Task Detail') . ' - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10 min-h-full">
    
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul]) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight text-left">
                {{ $task->judul_tugas ?? 'Latihan N4' }}
            </h1>
        </div>
        <nav class="flex flex-wrap items-center gap-2 text-[13px] font-bold text-[#666666] text-left">
            <a href="{{ route('students.enrolled') }}" class="hover:text-[#d62828] transition">Terdaftar</a> 
            <span class="mx-1 text-gray-300">></span> 
            <a href="{{ route('subjects.show', $subject->id_mapel) }}" class="hover:text-[#d62828] transition">{{ $subject->nama_mapel }}</a> 
            <span class="mx-1 text-gray-300">></span> 
            <a href="{{ route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $currentModul->id_modul]) }}" class="hover:text-[#d62828] transition">{{ $currentModul->nama_modul }}</a> 
            <span class="mx-1 text-gray-300">></span> 
            <span class="text-[#d62828]">{{ $task->judul_tugas }}</span>
        </nav>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- 3 Info Boxes -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-left">
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                    <p class="text-xs font-bold text-[#666666] mb-1.5">Modul</p>
                    <p class="text-[15px] font-black text-[#222222] truncate">{{ $currentModul->nama_modul }}</p>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                    <p class="text-xs font-bold text-[#666666] mb-1.5">Status Tugas</p>
                    <p class="text-[15px] font-black text-[#222222]">
                        {{ $submission && isset($submission->nilai) ? 'Sudah Dinilai' : ($submission ? 'Menunggu Penilaian' : 'Belum Dikirim') }}
                    </p>
                </div>
                <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">
                    <p class="text-xs font-bold text-[#666666] mb-1.5">Tenggat Waktu</p>
                    <p class="text-[15px] font-black text-[#222222]">
                        {{ \Carbon\Carbon::parse($task->waktu_pengumpulan)->format('d M Y, H:i') }}
                    </p>
                </div>
            </div>

            <!-- Task Description -->
            <div class="bg-white border border-gray-100 rounded-[24px] p-6 sm:p-8 shadow-sm">
                <h3 class="text-[15px] font-bold text-[#222222] mb-3">Deskripsi Tugas</h3>
                <div class="text-[13px] text-[#444444] leading-relaxed font-medium mb-6">
                    {!! $task->deskripsi_tugas !!}
                </div>

                <!-- Guidelines Mock (if not present in DB, usually it's in deskripsi_tugas, but added here for design fidelity if needed) -->
                <h3 class="text-[13px] font-bold text-[#222222] mb-3">Panduan:</h3>
                <ul class="list-disc list-outside ml-4 space-y-2 text-[13px] text-[#444444] font-medium mb-8">
                    <li>Unduh Lembar Kerja: Gunakan template PDF yang tersedia di bagian "Resources" di bawah ini.</li>
                    <li>Tulis Tangan: Untuk bagian Kanji, kamu wajib menulis secara tangan untuk melatih stroke order.</li>
                    <li>Format Unggahan: Scan atau foto lembar kerja yang sudah selesai dengan pencahayaan jelas.</li>
                    <li>Sistem Revisi: Jika nilai di bawah 80, kamu diberikan kesempatan revisi setelah mendapat feedback.</li>
                </ul>

                @php
                    $resourceName = !empty($task->resource_file_name) ? $task->resource_file_name : 'Template__N4__Exercise__01.pdf';
                @endphp
                <h3 class="text-[15px] font-bold text-[#222222] mb-4 mt-8">Lampiran Materi</h3>
                <div class="p-4 bg-white border border-gray-100 rounded-2xl flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-4 min-w-0">
                        <!-- Red Box styling exactly like design -->
                        <div class="w-12 h-12 bg-[#ef4444] text-white rounded-xl flex items-center justify-center flex-shrink-0 shadow-sm">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm-1 1.5L18.5 9H13V3.5zM6 20V4h5v7h7v9H6z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-[13px] font-bold text-[#222222] truncate">{{ $resourceName }}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase mt-0.5">PDF</p>
                        </div>
                    </div>
                    <a href="#" class="px-5 py-2.5 bg-white border border-[#d62828] text-[#d62828] hover:bg-red-50 rounded-[10px] font-bold text-[12px] transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh
                    </a>
                </div>
            </div>

        </div>

        <!-- Right Column -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Your Work Card -->
            <div class="p-6 bg-white border border-gray-100 rounded-[28px] shadow-sm relative z-20">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-[14px] font-bold text-[#222222]">Tugas Anda</h3>
                    <span class="text-[10px] font-bold {{ $submission ? 'text-[#F59E0B]' : 'text-[#666666]' }}">
                        {{ $submission ? 'Terkirim' : 'Belum Selesai' }}
                    </span>
                </div>

                @if(!$submission)
                    <form id="multi-upload-form" action="{{ route('tasks.submit', ['id_mapel' => $id_mapel, 'id_modul' => $id_modul, 'id_tugas' => $task->id_tugas]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-5">
                            <textarea name="text_content" id="task-text-input" rows="4" class="w-full p-4 bg-gray-50/30 border border-gray-100 rounded-[16px] text-[13px] font-medium text-[#444444] placeholder-gray-400 focus:outline-none focus:border-[#d62828] focus:bg-white focus:ring-1 focus:ring-[#d62828] resize-none transition custom-scrollbar" placeholder="Tulis jawaban Anda di sini..." oninput="checkInputState()"></textarea>
                        </div>
                        
                        <!-- Multi File & Link Preview -->
                        <div id="file-preview-container" class="mb-5 space-y-3">
                            <div id="file-chips"></div>
                            <div id="link-chips"></div>
                        </div>

                        <div id="upload-controls">
                            <div class="flex items-center justify-center mb-5 relative">
                                <hr class="w-full border-gray-100">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest absolute bg-white px-3">ATAU</span>
                            </div>

                            <!-- Dropdown Trigger -->
                            <div class="relative mb-5" id="dropdown-container">
                                <button type="button" onclick="toggleDropdown(event)" class="w-full h-[46px] bg-white border border-[#d62828] hover:bg-red-50 rounded-[12px] flex items-center justify-center gap-2 text-[13px] font-bold text-[#d62828] transition shadow-sm">
                                    <span class="text-lg font-normal mb-0.5">+</span> Tambah File atau Tautan
                                </button>

                                <!-- Dropdown Menu -->
                                <div id="add-dropdown" class="absolute left-0 bottom-[calc(100%+8px)] w-full bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.12)] border border-gray-100 hidden opacity-0 transform scale-95 transition-all duration-200 z-50 overflow-hidden">
                                    <button type="button" onclick="showInlineLinkInput()" class="w-full px-5 py-3.5 text-left text-[13px] font-bold text-[#444444] hover:bg-gray-50 flex items-center gap-3 transition">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                        Tautan
                                    </button>
                                    <label class="w-full px-5 py-3.5 text-left text-[13px] font-bold text-[#444444] hover:bg-gray-50 flex items-center gap-3 transition cursor-pointer border-t border-gray-50">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                        File
                                        <input type="file" id="actual-file-input" name="task_files[]" class="hidden" multiple onchange="handleFileSelect(this)">
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Inline Link Input (Hidden initially) -->
                            <div id="inline-link-input" class="hidden mb-5 transition-all duration-300 transform">
                                <div class="p-3 bg-white border border-gray-200 rounded-[12px] shadow-[0_4px_12px_-4px_rgba(0,0,0,0.05)] flex flex-col gap-3 relative">
                                    <input type="url" id="temp-link-input" placeholder="https://..." class="w-full bg-gray-50/50 border border-gray-100 rounded-[8px] px-3 py-2.5 text-[13px] text-[#444444] focus:outline-none focus:border-[#d62828] focus:bg-white transition" onkeypress="if(event.key === 'Enter') { event.preventDefault(); confirmLinkInput(); }">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" onclick="cancelLinkInput()" class="px-4 py-1.5 text-[12px] font-bold text-[#666666] hover:bg-gray-100 rounded-lg transition">Batal</button>
                                        <button type="button" onclick="confirmLinkInput()" class="px-4 py-1.5 text-[12px] font-bold text-white bg-[#d62828] hover:bg-red-700 rounded-lg transition shadow-sm">Tambah Tautan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="submit-btn" class="w-full h-[46px] bg-[#d62828] hover:bg-red-700 text-white rounded-[12px] flex items-center justify-center text-[13px] font-bold transition shadow-sm">
                            Tandai Selesai
                        </button>
                    </form>
                @else
                    <!-- Submitted State -->
                    <div class="mb-5">
                        <textarea disabled rows="4" class="w-full p-4 bg-gray-50/80 border border-gray-100 rounded-[16px] text-[13px] font-medium text-gray-500 resize-none">{{ optional($submission)->text_content ?? '' }}</textarea>
                    </div>
                    
                    @if(optional($submission)->file_path)
                        @php
                            $submissionFileUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($submission->file_path);
                        @endphp
                        <div class="mb-5">
                            <div class="p-3 bg-white border border-gray-100 rounded-2xl shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)]">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="text-[12px] font-bold text-[#222222] truncate">{{ basename($submission->file_path) }}</p>
                                        <p class="text-[9px] text-gray-400 font-bold uppercase mt-0.5">PDF</p>
                                    </div>
                                    <a href="{{ route('submissions.download', $submission->id_pengiriman_tugas) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg border border-[#d62828] text-[#d62828] text-[12px] font-bold hover:bg-red-50 transition">
                                        Buka File
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('tasks.cancel', ['id_mapel' => $id_mapel, 'id_modul' => $id_modul, 'id_tugas' => $id_tugas]) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full h-[46px] bg-white border border-[#d62828] text-[#d62828] hover:bg-red-50 rounded-[12px] flex items-center justify-center text-[13px] font-bold transition shadow-sm">
                            Batal Kirim
                        </button>
                    </form>
                @endif
            </div>

            <!-- Score Block -->
            <div class="p-5 bg-white border border-gray-100 rounded-[20px] flex items-center justify-between shadow-sm">
                <h3 class="text-[14px] font-bold text-[#222222]">Nilai</h3>
                <span class="text-[13px] font-bold text-[#666666]">
                    {{ $submission && isset($submission->nilai) ? $submission->nilai . '/100' : 'Menunggu Penilaian' }}
                </span>
            </div>

            <!-- Sensei Feedback Block -->
            <div class="p-6 bg-white border border-gray-100 rounded-[28px] shadow-sm space-y-4">
                <h3 class="text-[14px] font-bold text-[#222222]">Umpan Balik Sensei</h3>
                <div class="flex items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($guru->name ?? 'Sensei') }}&background=f3f4f6&color=444&bold=true" class="w-10 h-10 rounded-full object-cover">
                    <div>
                        <p class="text-[13px] font-bold text-[#222222]">{{ $guru->name ?? 'Sensei' }}</p>
                        <p class="text-[10px] font-medium text-gray-400">Sensei</p>
                    </div>
                </div>
                <div class="w-full p-4 bg-gray-50/80 border border-gray-100 rounded-[16px] text-[13px] font-medium text-gray-500">
                    {{ optional($submission)->feedback ?? 'Belum ada umpan balik' }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const dropdownBtn = document.querySelector('#dropdown-container button');
    const dropdownMenu = document.getElementById('add-dropdown');
    const submitBtn = document.getElementById('submit-btn');
    const filePreviewContainer = document.getElementById('file-preview-container');
    const uploadControls = document.getElementById('upload-controls');
    const fileInput = document.getElementById('actual-file-input');
    const fileChips = document.getElementById('file-chips');
    const linkChips = document.getElementById('link-chips');
    const multiUploadForm = document.getElementById('multi-upload-form');
    
    let accumulatedFiles = new DataTransfer();

    function closeDropdown() {
        dropdownMenu.classList.remove('opacity-100', 'scale-100');
        dropdownMenu.classList.add('opacity-0', 'scale-95');
        setTimeout(() => dropdownMenu.classList.add('hidden'), 200);
    }

    function toggleDropdown(e) {
        e.stopPropagation();
        const isHidden = dropdownMenu.classList.contains('hidden');
        if (isHidden) {
            dropdownMenu.classList.remove('hidden');
            setTimeout(() => {
                dropdownMenu.classList.remove('opacity-0', 'scale-95');
                dropdownMenu.classList.add('opacity-100', 'scale-100');
            }, 10);
        } else {
            closeDropdown();
        }
    }

    document.addEventListener('click', (e) => {
        if (dropdownMenu && !dropdownMenu.classList.contains('hidden') && !e.target.closest('#dropdown-container')) {
            closeDropdown();
        }
    });

    function renderFiles() {
        if(!fileChips) return;
        fileChips.innerHTML = '';
        const files = accumulatedFiles.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const ext = file.name.split('.').pop().toUpperCase();
            fileChips.innerHTML += `
                <div class="p-3 mt-3 bg-white border border-gray-100 rounded-2xl flex items-center justify-between shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)]">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="min-w-0">
                            <p class="text-[12px] font-bold text-[#222222] truncate">${file.name}</p>
                            <p class="text-[9px] text-gray-400 font-bold uppercase mt-0.5">${ext}</p>
                        </div>
                    </div>
                    <button type="button" onclick="removeFile(${i})" class="p-1.5 text-gray-400 hover:bg-red-50 hover:text-[#d62828] rounded-xl transition flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            `;
        }
    }

    function handleFileSelect(input) {
        if (input.files && input.files.length > 0) {
            for(let i = 0; i < input.files.length; i++){
                accumulatedFiles.items.add(input.files[i]);
            }
            input.files = accumulatedFiles.files;
            
            renderFiles();
            checkInputState();
            closeDropdown();
        }
    }

    function removeFile(indexToRemove) {
        const dt = new DataTransfer();
        const files = accumulatedFiles.files;
        for (let i = 0; i < files.length; i++) {
            if (i !== indexToRemove) {
                dt.items.add(files[i]);
            }
        }
        accumulatedFiles = dt;
        fileInput.files = accumulatedFiles.files;
        renderFiles();
        checkInputState();
    }

    function showInlineLinkInput() {
        closeDropdown();
        document.getElementById('dropdown-container').classList.add('hidden');
        const inlineInput = document.getElementById('inline-link-input');
        inlineInput.classList.remove('hidden');
        
        // Timeout to allow display:block before focusing
        setTimeout(() => {
            document.getElementById('temp-link-input').focus();
        }, 50);
    }

    function cancelLinkInput() {
        const tempInput = document.getElementById('temp-link-input');
        if (tempInput) tempInput.value = '';
        
        const inlineInput = document.getElementById('inline-link-input');
        if (inlineInput) inlineInput.classList.add('hidden');
        
        const dropdown = document.getElementById('dropdown-container');
        if (dropdown) dropdown.classList.remove('hidden');
    }

    function confirmLinkInput() {
        try {
            const urlInput = document.getElementById('temp-link-input');
            if (!urlInput) return;
            
            let url = urlInput.value.trim();
            if (url !== "") {
                // Auto-prefix https if missing
                if (!url.startsWith('http://') && !url.startsWith('https://')) {
                    url = 'https://' + url;
                }

                // Strict URL validation (must have a valid domain like .com, .id, etc)
                const urlPattern = /^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/i;
                if (!urlPattern.test(url)) {
                    alert("Format tautan tidak valid! Pastikan menggunakan domain yang benar (contoh: https://google.com).");
                    return; // stop execution
                }

                // Remove existing links
                const existingLinks = document.querySelectorAll('input[name="task_links[]"]');
                existingLinks.forEach(el => {
                    if (el && el.id) {
                        const existingId = el.id.replace('input_', '');
                        removeLink(existingId);
                    }
                });

                const linkId = 'link_' + Date.now();
                
                const linkInput = document.createElement('input');
                linkInput.type = 'hidden';
                linkInput.name = 'task_links[]';
                linkInput.value = url;
                linkInput.id = 'input_' + linkId;
                
                const multiForm = document.getElementById('multi-upload-form');
                if (multiForm) multiForm.appendChild(linkInput);
                
                const chipsContainer = document.getElementById('link-chips');
                if (chipsContainer) {
                    chipsContainer.insertAdjacentHTML('beforeend', `
                        <div class="p-3 mt-3 bg-white border border-gray-100 rounded-2xl flex items-center justify-between shadow-[0_2px_10px_-4px_rgba(0,0,0,0.05)]" id="chip_${linkId}">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="min-w-0">
                                    <p class="text-[12px] font-bold text-[#222222] truncate">${url}</p>
                                    <p class="text-[9px] text-gray-400 font-bold uppercase mt-0.5">TAUTAN</p>
                                </div>
                            </div>
                            <button type="button" onclick="removeLink('${linkId}')" class="p-1.5 text-gray-400 hover:bg-red-50 hover:text-[#d62828] rounded-xl transition flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    `);
                }
                
                checkInputState();
                cancelLinkInput();
            }
        } catch (e) {
            console.error('Error in confirmLinkInput:', e);
            cancelLinkInput();
        }
    }

    function removeLink(linkId) {
        const inputEl = document.getElementById('input_' + linkId);
        if (inputEl) inputEl.remove();
        
        const chipEl = document.getElementById('chip_' + linkId);
        if (chipEl) chipEl.remove();
        
        checkInputState();
    }

    function checkInputState() {
        try {
            const btn = document.getElementById('submit-btn');
            if(!btn) return;
            
            const txt = document.getElementById('task-text-input');
            const hasText = txt && txt.value && txt.value.trim().length > 0;
            
            const fileIn = document.getElementById('actual-file-input');
            const hasFile = fileIn && fileIn.files && fileIn.files.length > 0;
            
            const links = document.querySelectorAll('input[name="task_links[]"]');
            const hasLink = links && links.length > 0;

            if (hasText || hasFile || hasLink) {
                btn.textContent = 'Kirim Tugas';
            } else {
                btn.textContent = 'Tandai Selesai';
            }
        } catch (e) {
            console.error('Error in checkInputState:', e);
        }
    }
</script>
@endpush