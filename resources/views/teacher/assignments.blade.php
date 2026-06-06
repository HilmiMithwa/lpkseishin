@extends('layouts.teacher')

@section('title', 'Manajemen Tugas - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10" x-data="{ 
    selectedBatch: '',
    selectedClass: '',
    activeTab: 'belum_diperiksa',
    showCreateModal: false
}">

    <!-- Header & Action -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 text-left">
        <div>
            <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Manajemen Tugas</h1>
            <p class="text-sm text-[#666666] font-medium mt-1">Kelola penugasan dan periksa hasil pekerjaan siswa.</p>
        </div>
        <button @click="showCreateModal = true" class="h-fit inline-flex items-center justify-center gap-2 bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-5 rounded-xl text-sm transition shadow-sm whitespace-nowrap self-start sm:self-auto">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Buat Tugas Baru
        </button>
    </div>

    <!-- Filter Section (Select Batch & Class) -->
    <div class="bg-white rounded-[24px] border border-gray-100 p-5 shadow-sm flex flex-col sm:flex-row items-center gap-4 mb-8">
        <div class="flex-1 w-full relative z-20 space-y-1.5">
            <x-input-label>Pilih Batch</x-input-label>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" type="button" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold flex items-center justify-between transition focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] shadow-sm" :class="selectedBatch === '' ? 'text-gray-400' : 'text-[#222222]'">
                    <span x-text="selectedBatch === '' ? 'Pilih Batch...' : selectedBatch"></span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180 text-[#222222]' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden" style="display: none;" x-cloak>
                    <ul class="py-1">
                        {{-- TODO Backend: Looping data batch di sini --}}
                        <li><button type="button" @click="selectedBatch = 'Batch 3'; open = false; selectedClass = ''" class="w-full text-left px-4 py-2.5 text-sm font-semibold hover:bg-red-50 hover:text-[#d62828] transition-colors" :class="selectedBatch === 'Batch 3' ? 'bg-red-50 text-[#d62828]' : 'text-gray-700'">Batch 3</button></li>
                        <li><button type="button" @click="selectedBatch = 'Batch 2'; open = false; selectedClass = ''" class="w-full text-left px-4 py-2.5 text-sm font-semibold hover:bg-red-50 hover:text-[#d62828] transition-colors" :class="selectedBatch === 'Batch 2' ? 'bg-red-50 text-[#d62828]' : 'text-gray-700'">Batch 2</button></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="flex-1 w-full relative z-10 space-y-1.5">
            <x-input-label>Pilih Kelas</x-input-label>
            <div class="relative" x-data="{ open: false }">
                <button @click="if(selectedBatch !== '') open = !open" @click.away="open = false" type="button" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold flex items-center justify-between transition focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] shadow-sm" :class="[selectedClass === '' ? 'text-gray-400' : 'text-[#222222]', selectedBatch === '' ? 'bg-gray-50 border-gray-100 cursor-not-allowed opacity-70' : '']">
                    <span x-text="selectedClass === '' ? 'Pilih Kelas...' : selectedClass"></span>
                    <svg class="w-4 h-4 transition-transform duration-200" :class="[open ? 'rotate-180 text-[#222222]' : 'text-gray-400', selectedBatch === '' ? 'opacity-50' : '']" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="absolute z-50 w-full mt-2 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden" style="display: none;" x-cloak>
                    <ul class="py-1">
                        {{-- TODO Backend: Looping data kelas di sini --}}
                        <li><button type="button" @click="selectedClass = '4 Mastering'; open = false" class="w-full text-left px-4 py-2.5 text-sm font-semibold hover:bg-red-50 hover:text-[#d62828] transition-colors" :class="selectedClass === '4 Mastering' ? 'bg-red-50 text-[#d62828]' : 'text-gray-700'">4 Mastering</button></li>
                        <li><button type="button" @click="selectedClass = '3 Beginner'; open = false" class="w-full text-left px-4 py-2.5 text-sm font-semibold hover:bg-red-50 hover:text-[#d62828] transition-colors" :class="selectedClass === '3 Beginner' ? 'bg-red-50 text-[#d62828]' : 'text-gray-700'">3 Beginner</button></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Empty State Notification -->
    <div x-show="selectedBatch === '' || selectedClass === ''" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="flex flex-col items-center justify-center bg-white rounded-[32px] border border-gray-100 p-12 text-center shadow-sm min-h-[400px]">
        <div class="w-24 h-24 bg-red-50 text-[#d62828] rounded-full flex items-center justify-center mb-6 border-4 border-red-100/50">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Kelas Terpilih</h3>
        <p class="text-sm text-gray-500 max-w-md mx-auto leading-relaxed">Silakan pilih <span class="font-bold text-gray-700">Batch</span> dan <span class="font-bold text-gray-700">Kelas</span> pada menu di atas terlebih dahulu untuk memuat daftar Tugas.</p>
    </div>

    <!-- Main Content (Shows only when selected) -->
    <div x-show="selectedBatch !== '' && selectedClass !== ''" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;" x-cloak>
        
        <!-- Tab Navigation -->
        <div class="flex items-end gap-4 mb-6 border-b border-gray-200 overflow-x-auto custom-scrollbar">
            <button @click="activeTab = 'belum_diperiksa'" :class="activeTab === 'belum_diperiksa' ? 'text-[#d62828] border-[#d62828]' : 'text-gray-500 border-transparent hover:text-gray-800 hover:border-gray-300'" class="whitespace-nowrap px-1 py-3 font-bold text-sm border-b-2 -mb-px transition flex items-center gap-2">
                Belum Diperiksa
                <span class="bg-[#d62828] text-white text-[10px] px-2 py-0.5 rounded-full font-bold">2</span>
            </button>
            <button @click="activeTab = 'aktif'" :class="activeTab === 'aktif' ? 'text-[#d62828] border-[#d62828]' : 'text-gray-500 border-transparent hover:text-gray-800 hover:border-gray-300'" class="whitespace-nowrap px-1 py-3 font-bold text-sm border-b-2 -mb-px transition">
                Aktif berjalan
            </button>
            <button @click="activeTab = 'selesai'" :class="activeTab === 'selesai' ? 'text-[#d62828] border-[#d62828]' : 'text-gray-500 border-transparent hover:text-gray-800 hover:border-gray-300'" class="whitespace-nowrap px-1 py-3 font-bold text-sm border-b-2 -mb-px transition">
                Selesai
            </button>
        </div>

        <!-- Tab 1: Belum Diperiksa -->
        <div x-show="activeTab === 'belum_diperiksa'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <!-- Task Card 1 -->
                <div class="bg-white rounded-[24px] border border-gray-100 p-6 shadow-sm hover:shadow-md transition duration-300 flex flex-col h-full group relative overflow-hidden">
                    
                    <div class="flex items-center justify-end mb-4 relative z-10">
                        <div class="flex items-center gap-1.5 text-xs font-bold text-red-600 bg-red-50 px-2 py-1 rounded-lg">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Jatuh tempo kemarin
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-800 mb-2 leading-snug relative z-10">Tugas Menulis Kanji Bab 4: Kata Sifat</h3>
                    <p class="text-xs font-semibold text-gray-500 mb-5 flex-1 relative z-10">Bab 4 - Modul Dasar</p>
                    
                    <div class="mb-5 relative z-10">
                        <div class="flex items-center justify-between text-xs font-bold mb-1.5">
                            <span class="text-gray-500">Terkumpul</span>
                            <span class="text-gray-800">18/20 Siswa</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-[#d62828] h-1.5 rounded-full" style="width: 90%"></div>
                        </div>
                    </div>
                    
                    <a href="{{ route('teacher.assignments.grade') }}" class="w-full mt-auto bg-red-50 hover:bg-[#d62828] text-[#d62828] hover:text-white border border-red-100 hover:border-[#d62828] font-bold py-2.5 rounded-xl text-sm transition-colors duration-300 flex items-center justify-center gap-2 relative z-10">
                        Periksa 18 Kiriman
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>

                <!-- Task Card 2 -->
                <div class="bg-white rounded-[24px] border border-gray-100 p-6 shadow-sm hover:shadow-md transition duration-300 flex flex-col h-full group relative overflow-hidden">
                    
                    <div class="flex items-center justify-end mb-4 relative z-10">
                        <div class="flex items-center gap-1.5 text-xs font-bold text-gray-500 bg-gray-50 px-2 py-1 rounded-lg">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Tenggat: 4 Jun 2026
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-800 mb-2 leading-snug relative z-10">Rekaman Percakapan Perkenalan Diri (Jikoshoukai)</h3>
                    <p class="text-xs font-semibold text-gray-500 mb-5 flex-1 relative z-10">Bab 2 - Modul Dasar</p>
                    
                    <div class="mb-5 relative z-10">
                        <div class="flex items-center justify-between text-xs font-bold mb-1.5">
                            <span class="text-gray-500">Terkumpul</span>
                            <span class="text-gray-800">20/20 Siswa</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                            <div class="bg-[#d62828] h-1.5 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                    
                    <a href="{{ route('teacher.assignments.grade') }}" class="w-full mt-auto bg-red-50 hover:bg-[#d62828] text-[#d62828] hover:text-white border border-red-100 hover:border-[#d62828] font-bold py-2.5 rounded-xl text-sm transition-colors duration-300 flex items-center justify-center gap-2 relative z-10">
                        Periksa 20 Kiriman
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tab 2: Aktif Berjalan -->
        <div x-show="activeTab === 'aktif'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="bg-white rounded-[32px] border border-gray-100 p-12 text-center shadow-sm flex flex-col items-center justify-center min-h-[300px]">
                <div class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Tidak Ada Tugas Aktif</h3>
                <p class="text-sm text-gray-500 max-w-sm">Semua tugas sudah melewati masa tenggat waktu. Silakan buat tugas baru.</p>
            </div>
        </div>

        <!-- Tab 3: Selesai -->
        <div x-show="activeTab === 'selesai'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <!-- Task Card 3 -->
                <div class="bg-white rounded-[24px] border border-gray-100 p-6 shadow-sm flex flex-col h-full group relative overflow-hidden">
                    <div class="flex items-center justify-end mb-4">
                        <div class="flex items-center gap-1.5 text-[10px] font-bold text-gray-600 bg-gray-100 px-2 py-1 rounded-lg uppercase tracking-wide">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Selesai Dinilai
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-gray-800 mb-2 leading-snug">Latihan Tata Bahasa Partikel Wa, Ga, O</h3>
                    <p class="text-xs font-semibold text-gray-500 mb-5 flex-1">Bab 1 - Modul Dasar</p>
                    
                    <button class="w-full mt-auto bg-white hover:bg-gray-50 text-gray-600 border border-gray-200 font-bold py-2.5 rounded-xl text-sm transition-colors flex items-center justify-center gap-2">
                        Lihat Rekap Nilai
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- Create Task Modal overlay -->
    <template x-teleport="body">
        <div x-show="showCreateModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-6" x-cloak>
            <!-- Backdrop -->
            <div x-show="showCreateModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100 backdrop-blur-sm" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 backdrop-blur-sm" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm" @click="showCreateModal = false"></div>

        <!-- Modal Panel -->
        <div x-show="showCreateModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4 sm:translate-y-0" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4 sm:translate-y-0" class="relative w-full max-w-2xl bg-white rounded-[32px] shadow-2xl overflow-hidden z-10 flex flex-col max-h-full">
            
            <!-- Modal Header -->
            <div class="px-6 py-5 sm:px-8 sm:py-6 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold font-ibm text-[#222222]">Buat Tugas Baru</h3>
                    <p class="text-sm text-gray-500 mt-1">Isi detail tugas untuk diunggah ke kelas.</p>
                </div>
                <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-600 transition p-2 hover:bg-gray-100 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-6 overflow-y-auto custom-scrollbar flex-1 bg-gray-50/30">
                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Judul & Tenggat Waktu -->
                    <div class="space-y-5">
                        <div class="space-y-1.5">
                            <x-input-label>Judul Tugas</x-input-label>
                            <x-text-input type="text" name="title" required placeholder="Misal: Menulis Kanji Bab 5" class="w-full" />
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Tenggat Waktu (Due Date)</x-input-label>
                            <x-text-input type="datetime-local" name="due_date" required class="w-full" />
                        </div>
                    </div>

                    <!-- Target Kelas -->
                    <div class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                        <x-input-label class="mb-3">Terbitkan Untuk Kelas & Modul</x-input-label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <select name="batch_id" x-model="selectedBatch" required class="w-full bg-white border border-gray-200 text-gray-800 rounded-xl px-4 py-3 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-[#d62828] transition-colors">
                                    <option value="">Pilih Batch...</option>
                                    <option value="Batch 3">Batch 3</option>
                                    <option value="Batch 2">Batch 2</option>
                                    <option value="Batch 1">Batch 1</option>
                                </select>
                            </div>
                            <div>
                                <select name="class_id" x-model="selectedClass" required class="w-full bg-white border border-gray-200 text-gray-800 rounded-xl px-4 py-3 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-[#d62828] transition-colors" :disabled="selectedBatch === ''" :class="selectedBatch === '' ? 'opacity-70 cursor-not-allowed' : ''">
                                    <option value="">Pilih Kelas...</option>
                                    <option value="4 Mastering">4 Mastering</option>
                                    <option value="3 Beginner">3 Beginner</option>
                                </select>
                            </div>
                            <div>
                                <select name="module_id" required class="w-full bg-white border border-gray-200 text-gray-800 rounded-xl px-4 py-3 text-sm font-semibold focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-[#d62828] transition-colors" :disabled="selectedClass === ''" :class="selectedClass === '' ? 'opacity-70 cursor-not-allowed' : ''">
                                    <option value="">Pilih Modul...</option>
                                    <option value="Modul 1">Modul 1: Vocabulary</option>
                                    <option value="Modul 2">Modul 2: Grammar</option>
                                    <option value="Modul 3">Modul 3: Kanji</option>
                                </select>
                            </div>
                        </div>
                        <p class="text-[10px] font-medium text-gray-500 mt-3">Tugas ini akan disematkan ke Modul yang dipilih pada kelas target.</p>
                    </div>

                    <!-- Deskripsi -->
                    <div class="space-y-1.5">
                        <x-input-label>Instruksi (Opsional)</x-input-label>
                        <textarea name="instruction" rows="3" placeholder="Tambahkan instruksi pengerjaan jika ada..." class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm shadow-sm"></textarea>
                    </div>

                    <!-- Upload -->
                    <div x-data="{ fileName: null, isDragging: false }" class="space-y-1.5">
                        <x-input-label>Lampiran Soal / Materi (Opsional)</x-input-label>
                        
                        <!-- File Input (Hidden) -->
                        <input type="file" id="assignment_file" name="attachment" class="hidden" 
                               @change="fileName = $event.target.files[0] ? $event.target.files[0].name : null">
                               
                        <!-- Dropzone -->
                        <label for="assignment_file" 
                               @dragover.prevent="isDragging = true" 
                               @dragleave.prevent="isDragging = false"
                               @drop.prevent="isDragging = false; if($event.dataTransfer.files.length > 0) { document.getElementById('assignment_file').files = $event.dataTransfer.files; fileName = $event.dataTransfer.files[0].name; }"
                               class="block border-2 border-dashed rounded-2xl p-6 transition-colors cursor-pointer group"
                               :class="isDragging ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-white hover:border-red-300'">
                            <!-- State: No File -->
                            <div x-show="!fileName" class="text-center">
                                <div class="w-12 h-12 bg-red-50 text-[#d62828] rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                </div>
                                <p class="text-sm font-bold text-gray-700 mb-1">Klik untuk unggah atau seret file ke sini</p>
                                <p class="text-xs text-gray-500 font-medium">PDF, DOCX, JPG, PNG (Maks. 5MB)</p>
                            </div>
                            
                            <!-- State: File Selected -->
                            <div x-show="fileName" style="display: none;" class="flex items-center justify-between bg-white/50 rounded-xl p-2 border border-gray-100">
                                <div class="flex items-center gap-3 overflow-hidden">
                                    <div class="w-10 h-10 bg-red-50 text-[#d62828] rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div class="text-left truncate">
                                        <p class="text-sm font-bold text-gray-800 truncate" x-text="fileName"></p>
                                        <p class="text-xs text-green-600 font-medium mt-0.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            Siap diunggah
                                        </p>
                                    </div>
                                </div>
                                <button type="button" @click.prevent="fileName = null; document.getElementById('assignment_file').value = ''" class="text-red-400 hover:text-[#d62828] p-2 hover:bg-red-50 rounded-full transition-colors flex-shrink-0" title="Hapus file">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </label>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 border-t border-gray-100 bg-white flex justify-end gap-3 rounded-b-[32px] sticky bottom-0 z-20">
                <button @click="showCreateModal = false" type="button" class="px-5 py-2.5 rounded-xl font-bold text-sm text-gray-600 hover:bg-gray-100 transition-colors">
                    Batal
                </button>
                <x-primary-button type="button" x-data="{ loading: false }" @click="loading = true; setTimeout(() => { loading = false; showCreateModal = false; }, 800)" class="px-5 py-2.5 gap-2 shadow-sm">
                    <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    <svg x-show="loading" class="w-4 h-4 animate-spin" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    <span x-text="loading ? 'Menerbitkan...' : 'Terbitkan Tugas'"></span>
                </x-primary-button>
            </div>
            
        </div>
        </div>
    </template>

</div>
@endsection
