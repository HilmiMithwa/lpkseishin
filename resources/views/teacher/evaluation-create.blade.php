@extends('layouts.teacher')

@section('content')
<div x-data="evaluationForm()" @trigger-submit-evaluasi.window="submitEvaluasi()" class="p-4 sm:p-6 lg:p-10 bg-[#fdfdfc] min-h-screen">
    
    <div class="w-full">
        {{-- Header & Breadcrumb --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('teacher.modules.show', $currentModuleId) }}" @click.prevent="navigateAway('{{ route('teacher.modules.show', $currentModuleId) }}')" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </a>
                    <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-gray-900 tracking-tight">Buat Evaluasi</h1>
                </div>
                <nav class="flex flex-wrap items-center gap-1.5 text-xs sm:text-sm">
                    <a href="{{ route('teacher.classes') }}" @click.prevent="navigateAway('{{ route('teacher.classes') }}')" class="text-gray-500 hover:text-gray-700 font-medium transition">Kelas Saya</a>
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="{{ route('teacher.batch.show', $batchId) }}" @click.prevent="navigateAway('{{ route('teacher.batch.show', $batchId) }}')" class="text-gray-500 hover:text-gray-700 font-medium transition">{{ $batchName }}</a>
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="{{ route('teacher.subjects.show', $mapelId) }}" @click.prevent="navigateAway('{{ route('teacher.subjects.show', $mapelId) }}')" class="text-gray-500 hover:text-gray-700 font-medium transition">{{ $className }}</a>
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="{{ route('teacher.modules.show', $currentModuleId) }}" @click.prevent="navigateAway('{{ route('teacher.modules.show', $currentModuleId) }}')" class="text-gray-500 hover:text-gray-700 font-medium transition">Modul {{ $moduleIndex }}</a>
                    <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-[#d62828] font-semibold">Buat Evaluasi</span>
                </nav>
            </div>
            
            <x-primary-button @click="$dispatch('open-publish-modal')" class="gap-2 shadow-lg shadow-red-200 py-3">
                Terbitkan Evaluasi
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
            </x-primary-button>
        </div>

        {{-- Form Content --}}
        <div class="bg-white border border-gray-100 rounded-[24px] p-8 shadow-sm mb-8">
            {{-- Add Evaluation Detail --}}
            <div class="mb-10">
                <h3 class="text-base font-bold font-ibm text-gray-900 mb-6">Detail Evaluasi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-1.5">
                        <x-input-label>Judul Evaluasi</x-input-label>
                        <x-text-input type="text" x-model="evalTitle" placeholder="Misal: Ujian Akhir Kompetensi" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label>Bahasa</x-input-label>
                        <x-text-input type="text" x-model="language" placeholder="Misal: Bahasa Jepang N4" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label>Durasi (Menit)</x-input-label>
                        <x-text-input type="number" x-model="duration" placeholder="Misal: 120" />
                    </div>
                    <div class="space-y-1.5">
                        <x-input-label>Tipe</x-input-label>
                        <select x-model="evalType" class="w-full px-4 py-2.5 rounded-xl bg-white border border-gray-200 focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm shadow-sm cursor-pointer">
                            <option value="Multiple Choice and Essay">Pilihan Ganda & Esai</option>
                            <option value="Multiple Choice Only">Pilihan Ganda Saja</option>
                            <option value="Essay Only">Esai Saja</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Add Guide --}}
            <div class="mb-10 pt-8 border-t border-gray-50">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-base font-bold font-ibm text-gray-900">Panduan</h3>
                    <button @click="isAddingGuide = !isAddingGuide" class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl text-xs flex items-center transition">
                        Tambah Panduan
                    </button>
                </div>

                <div class="space-y-3 mb-6">
                    <template x-for="(guide, index) in guides" :key="index">
                        <div class="flex items-center gap-3 group">
                            <div class="w-5 h-5 flex-shrink-0 flex items-center justify-center rounded border border-green-500 text-green-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <span class="text-sm font-bold font-karla text-gray-700" x-text="guide"></span>
                            <button @click="removeGuide(index)" class="ml-auto text-gray-300 hover:text-red-500 p-1 rounded transition opacity-50 hover:opacity-100 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </template>
                </div>

                <div x-show="isAddingGuide" x-transition.opacity class="flex gap-3">
                    <x-text-input type="text" x-model="newGuideText" @keydown.enter="addGuide" placeholder="Misal: Pastikan koneksi internet stabil" class="flex-1" />
                    <button @click="isAddingGuide = false; newGuideText = ''" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-xl text-sm transition flex-shrink-0">
                        Batal
                    </button>
                    <x-primary-button @click="addGuide" class="flex-shrink-0 px-8 py-2.5">
                        Simpan
                    </x-primary-button>
                </div>
            </div>
            
            {{-- Questions Sections --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Multiple Choice --}}
                <div x-show="evalType === 'Multiple Choice and Essay' || evalType === 'Multiple Choice Only'" class="p-6 rounded-[24px] border border-gray-100 bg-white">
                    <h3 class="text-base font-bold font-ibm text-gray-900 mb-6">Pilihan Ganda</h3>
                    
                    <div x-show="mcqs.length > 0" class="flex flex-wrap gap-3 mb-6">
                        <template x-for="(mcq, index) in mcqs" :key="index">
                            <button @click="openMcqDrawer(index)" class="w-14 h-14 rounded-xl flex items-center justify-center font-bold text-base transition shadow-sm border"
                                    :class="mcq.isOpen ? 'bg-red-50 text-red-600 border-red-200 shadow-red-100/50' : 'bg-white text-gray-600 border-gray-200 hover:border-red-200 hover:text-red-500 hover:bg-red-50'">
                                <span x-text="index + 1"></span>
                            </button>
                        </template>
                    </div>

                    <button @click="addMcq()" class="w-full py-3.5 px-4 border-2 border-dashed border-red-300 hover:border-[#d62828] hover:bg-red-50 rounded-2xl text-[#d62828] font-bold font-karla text-sm flex items-center justify-center gap-2 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Soal
                    </button>
                </div>
                
                {{-- Essay --}}
                <div x-show="evalType === 'Multiple Choice and Essay' || evalType === 'Essay Only'" class="p-6 rounded-[24px] border border-gray-100 bg-white">
                    <h3 class="text-base font-bold font-ibm text-gray-900 mb-6">Esai</h3>
                    
                    <div x-show="essays.length > 0" class="flex flex-wrap gap-3 mb-6">
                        <template x-for="(essay, index) in essays" :key="index">
                            <button @click="openEssayDrawer(index)" class="w-14 h-14 rounded-xl flex items-center justify-center font-bold text-base transition shadow-sm border"
                                    :class="essay.isOpen ? 'bg-red-50 text-red-600 border-red-200 shadow-red-100/50' : 'bg-white text-gray-600 border-gray-200 hover:border-red-200 hover:text-red-500 hover:bg-red-50'">
                                <span x-text="index + 1"></span>
                            </button>
                        </template>
                    </div>

                    <button @click="addEssay()" class="w-full py-3.5 px-4 border-2 border-dashed border-red-300 hover:border-[#d62828] hover:bg-red-50 rounded-2xl text-[#d62828] font-bold font-karla text-sm flex items-center justify-center gap-2 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Soal
                    </button>
                </div>

            </div>

        </div>
    </div>
    
    {{-- Dark Overlay for Drawers & Toast (Teleported to body) --}}
    <template x-teleport="body">
        <div>
            {{-- Toast Notification --}}
            <div x-show="toast.show" 
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                 class="fixed bottom-6 lg:bottom-10 left-1/2 -translate-x-1/2 z-[200] flex items-center gap-4 px-5 py-4 rounded-2xl shadow-2xl border"
                 :class="toast.type === 'error' ? 'bg-white border-red-100' : 'bg-white border-green-100'" style="display: none;">
                
                <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0"
                     :class="toast.type === 'error' ? 'bg-red-50 text-red-500' : 'bg-green-50 text-green-500'">
                    <svg x-show="toast.type === 'error'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <svg x-show="toast.type === 'success'" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <h4 class="font-bold font-ibm text-gray-900 text-sm" x-text="toast.type === 'error' ? 'Peringatan!' : 'Berhasil!'"></h4>
                    <p class="text-xs font-karla text-gray-500 mt-0.5" x-text="toast.message"></p>
                </div>
            </div>

            <div x-show="mcqDrawerOpen || essayDrawerOpen" style="display: none;" 
         class="fixed inset-0 z-[100] bg-gray-900/20 backdrop-blur-sm transition-opacity"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mcqDrawerOpen = false; essayDrawerOpen = false">
    </div>

    {{-- MCQ Drawer --}}
    <div class="fixed inset-y-0 right-0 z-[101] w-full max-w-[500px] bg-white shadow-2xl transform transition-transform duration-300 ease-in-out flex flex-col"
         :class="mcqDrawerOpen ? 'translate-x-0' : 'translate-x-full'">
        
        <div class="flex items-center justify-between p-6 border-b border-gray-100 flex-shrink-0">
            <div>
                <h2 class="text-lg font-bold font-ibm text-gray-900">Tambah Soal</h2>
                <p class="text-xs font-karla text-gray-500">Pilihan Ganda</p>
            </div>
            <button @click="mcqDrawerOpen = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-6">
            <div class="space-y-4">
                <template x-for="(mcq, index) in mcqs" :key="index">
                    <div class="border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300" 
                         :class="mcq.isOpen ? 'shadow-md border-gray-300' : 'hover:border-gray-300'">
                        
                        {{-- Accordion Header --}}
                        <button @click="mcq.isOpen = !mcq.isOpen" class="w-full flex items-center justify-between p-4 bg-white text-left">
                            <span class="font-bold font-ibm text-gray-900 text-sm" x-text="'Soal ' + (index + 1)"></span>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300" :class="mcq.isOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        {{-- Accordion Body --}}
                        <div x-show="mcq.isOpen" x-collapse>
                            <div class="p-5 pt-2 border-t border-gray-100 bg-white space-y-5">
                                <div class="space-y-1.5">
                                    <x-input-label>Pertanyaan:</x-input-label>
                                    <textarea x-model="mcq.question" rows="4" placeholder="Ketikkan soal di sini..." class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm shadow-sm resize-y"></textarea>
                                    
                                    <div class="mt-3">
                                        <input type="file" multiple :id="'mcq-img-'+index" x-ref="fileInput" class="hidden" accept="image/*" @change="handleFileChange($event, 'mcq', index)">
                                        
                                        <!-- Image Previews -->
                                        <div x-show="mcq.images && mcq.images.length > 0" class="flex flex-wrap gap-3 mb-3">
                                            <template x-for="(img, imgIndex) in mcq.images" :key="imgIndex">
                                                <div class="relative group w-20 h-20 rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                                    <img :src="img.url" class="w-full h-full object-cover">
                                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                                        <button type="button" @click="removeImage('mcq', index, imgIndex)" class="w-7 h-7 bg-white text-red-500 rounded-full flex items-center justify-center hover:scale-110 transition shadow-sm">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="button" @click="document.getElementById('mcq-img-'+index).click()" class="bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 font-bold py-2 px-4 rounded-lg text-[11px] transition shadow-sm flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                <span x-text="(mcq.images && mcq.images.length > 0) ? 'Tambah Gambar Lain' : 'Unggah Gambar (Multiple)'"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1.5">
                                        <div class="flex items-center justify-between">
                                            <x-input-label>Pilihan A:</x-input-label>
                                            <label class="flex items-center gap-1.5 text-[11px] text-green-600 font-bold cursor-pointer hover:bg-green-50 px-2 py-0.5 rounded transition">
                                                <input type="radio" :name="'correct_answer_'+index" value="0" x-model="mcq.correct_answer" class="w-3 h-3 text-green-500 focus:ring-green-500 rounded-full border-gray-300">
                                                Kunci
                                            </label>
                                        </div>
                                        <x-text-input type="text" x-model="mcq.options[0]" placeholder="Opsi A" />
                                    </div>
                                    <div class="space-y-1.5">
                                        <div class="flex items-center justify-between">
                                            <x-input-label>Pilihan B:</x-input-label>
                                            <label class="flex items-center gap-1.5 text-[11px] text-green-600 font-bold cursor-pointer hover:bg-green-50 px-2 py-0.5 rounded transition">
                                                <input type="radio" :name="'correct_answer_'+index" value="1" x-model="mcq.correct_answer" class="w-3 h-3 text-green-500 focus:ring-green-500 rounded-full border-gray-300">
                                                Kunci
                                            </label>
                                        </div>
                                        <x-text-input type="text" x-model="mcq.options[1]" placeholder="Opsi B" />
                                    </div>
                                    <div class="space-y-1.5">
                                        <div class="flex items-center justify-between">
                                            <x-input-label>Pilihan C:</x-input-label>
                                            <label class="flex items-center gap-1.5 text-[11px] text-green-600 font-bold cursor-pointer hover:bg-green-50 px-2 py-0.5 rounded transition">
                                                <input type="radio" :name="'correct_answer_'+index" value="2" x-model="mcq.correct_answer" class="w-3 h-3 text-green-500 focus:ring-green-500 rounded-full border-gray-300">
                                                Kunci
                                            </label>
                                        </div>
                                        <x-text-input type="text" x-model="mcq.options[2]" placeholder="Opsi C" />
                                    </div>
                                    <div class="space-y-1.5">
                                        <div class="flex items-center justify-between">
                                            <x-input-label>Pilihan D:</x-input-label>
                                            <label class="flex items-center gap-1.5 text-[11px] text-green-600 font-bold cursor-pointer hover:bg-green-50 px-2 py-0.5 rounded transition">
                                                <input type="radio" :name="'correct_answer_'+index" value="3" x-model="mcq.correct_answer" class="w-3 h-3 text-green-500 focus:ring-green-500 rounded-full border-gray-300">
                                                Kunci
                                            </label>
                                        </div>
                                        <x-text-input type="text" x-model="mcq.options[3]" placeholder="Opsi D" />
                                    </div>
                                </div>

                                <div class="flex gap-3 pt-4 border-t border-gray-100">
                                    <button @click="deleteMcq(index)" class="flex-1 py-3 bg-gray-50 hover:bg-red-50 border border-gray-200 hover:border-red-200 text-gray-700 hover:text-red-600 rounded-xl font-bold font-karla text-sm flex items-center justify-center gap-2 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                    <x-primary-button @click="saveMcq(index)" class="flex-1 justify-center py-3 shadow-md shadow-red-200">
                                        Simpan
                                    </x-primary-button>
                                </div>
                            </div>
                        </div>

                    </div>
                </template>
            </div>
        </div>

        <div class="p-6 border-t border-gray-100 flex-shrink-0 bg-white">
            <button @click="addMcq()" class="w-full py-3.5 bg-[#d62828] hover:bg-red-700 text-white font-bold font-karla text-sm rounded-xl flex items-center justify-center gap-2 transition shadow-lg shadow-red-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Soal
            </button>
        </div>
    </div>

    {{-- Essay Drawer --}}
    <div class="fixed inset-y-0 right-0 z-[101] w-full max-w-[500px] bg-white shadow-2xl transform transition-transform duration-300 ease-in-out flex flex-col"
         :class="essayDrawerOpen ? 'translate-x-0' : 'translate-x-full'">
        
        <div class="flex items-center justify-between p-6 border-b border-gray-100 flex-shrink-0">
            <div>
                <h2 class="text-lg font-bold font-ibm text-gray-900">Tambah Soal</h2>
                <p class="text-xs font-karla text-gray-500">Esai</p>
            </div>
            <button @click="essayDrawerOpen = false" class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-6">
            <div class="space-y-4">
                <template x-for="(essay, index) in essays" :key="index">
                    <div class="border border-gray-200 rounded-2xl overflow-hidden transition-all duration-300" 
                         :class="essay.isOpen ? 'shadow-md border-gray-300' : 'hover:border-gray-300'">
                        
                        {{-- Accordion Header --}}
                        <button @click="essay.isOpen = !essay.isOpen" class="w-full flex items-center justify-between p-4 bg-white text-left">
                            <span class="font-bold font-ibm text-gray-900 text-sm" x-text="'Soal ' + (index + 1)"></span>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300" :class="essay.isOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        {{-- Accordion Body --}}
                        <div x-show="essay.isOpen" x-collapse>
                            <div class="p-5 pt-2 border-t border-gray-100 bg-white space-y-5">
                                <div class="space-y-1.5">
                                    <x-input-label>Pertanyaan:</x-input-label>
                                    <textarea x-model="essay.question" rows="4" placeholder="Ketikkan soal essay di sini..." class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm shadow-sm resize-y"></textarea>
                                    
                                    <div class="mt-3">
                                        <input type="file" multiple :id="'essay-img-'+index" x-ref="fileInput" class="hidden" accept="image/*" @change="handleFileChange($event, 'essay', index)">
                                        
                                        <!-- Image Previews -->
                                        <div x-show="essay.images && essay.images.length > 0" class="flex flex-wrap gap-3 mb-3">
                                            <template x-for="(img, imgIndex) in essay.images" :key="imgIndex">
                                                <div class="relative group w-20 h-20 rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                                    <img :src="img.url" class="w-full h-full object-cover">
                                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                                        <button type="button" @click="removeImage('essay', index, imgIndex)" class="w-7 h-7 bg-white text-red-500 rounded-full flex items-center justify-center hover:scale-110 transition shadow-sm">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="button" @click="document.getElementById('essay-img-'+index).click()" class="bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 font-bold py-2 px-4 rounded-lg text-[11px] transition shadow-sm flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                <span x-text="(essay.images && essay.images.length > 0) ? 'Tambah Gambar Lain' : 'Unggah Gambar (Multiple)'"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex gap-3 pt-4 border-t border-gray-100">
                                    <button @click="deleteEssay(index)" class="flex-1 py-3 bg-gray-50 hover:bg-red-50 border border-gray-200 hover:border-red-200 text-gray-700 hover:text-red-600 rounded-xl font-bold font-karla text-sm flex items-center justify-center gap-2 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                    <x-primary-button @click="saveEssay(index)" class="flex-1 justify-center py-3 shadow-md shadow-red-200">
                                        Simpan
                                    </x-primary-button>
                                </div>
                            </div>
                        </div>

                    </div>
                </template>
            </div>
        </div>

        <div class="p-6 border-t border-gray-100 flex-shrink-0 bg-white">
            <button @click="addEssay()" class="w-full py-3.5 bg-[#d62828] hover:bg-red-700 text-white font-bold font-karla text-sm rounded-xl flex items-center justify-center gap-2 transition shadow-lg shadow-red-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Soal
            </button>
        </div>
    </div>
        </div>
    </template>

</div>
@endsection

@push('modals')
<div x-data="{ showPublishModal: false }" @open-publish-modal.window="showPublishModal = true">
    <div x-show="showPublishModal" style="display: none;" class="fixed inset-0 z-[110] flex items-center justify-center px-4" >
        <div x-show="showPublishModal" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
        <div x-show="showPublishModal" @click.outside="showPublishModal = false" class="relative bg-white rounded-[24px] w-full max-w-sm p-6 shadow-xl" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            <div class="w-16 h-16 rounded-full bg-red-50 text-red-500 flex items-center justify-center mb-5 mx-auto">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h3 class="text-xl font-bold font-ibm text-gray-900 text-center mb-2">Terbitkan Evaluasi?</h3>
            <p class="text-sm text-gray-500 font-karla text-center mb-6">Evaluasi ini akan langsung tersedia untuk semua siswa di kelas.</p>
            <div class="flex gap-3">
                <button @click="showPublishModal = false" class="flex-1 py-3 rounded-xl border border-gray-200 text-gray-700 font-bold font-karla text-sm hover:bg-gray-50 transition">Batal</button>
                <x-primary-button @click="$dispatch('trigger-submit-evaluasi'); showPublishModal = false" class="flex-1 justify-center py-3">Terbitkan</x-primary-button>
            </div>
        </div>

        </div>
    </div>
</div>

<div x-data="{ showLeaveModal: false, targetUrl: '' }" @open-leave-modal.window="showLeaveModal = true; targetUrl = $event.detail.url">
    <div x-show="showLeaveModal" style="display: none;" class="fixed inset-0 z-[110] flex items-center justify-center px-4">
        <div x-show="showLeaveModal" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
        <div x-show="showLeaveModal" @click.outside="showLeaveModal = false" class="relative bg-white rounded-[24px] w-full max-w-sm p-6 shadow-xl" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            <div class="w-16 h-16 rounded-full bg-orange-50 text-orange-500 flex items-center justify-center mb-5 mx-auto">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-xl font-bold font-ibm text-gray-900 text-center mb-2">Yakin untuk kembali?</h3>
            <p class="text-sm text-gray-500 font-karla text-center mb-6">Progress yang belum Anda simpan tidak akan tersimpan.</p>
            <div class="flex gap-3">
                <button @click="showLeaveModal = false" class="flex-1 py-3 rounded-xl border border-gray-200 text-gray-700 font-bold font-karla text-sm hover:bg-gray-50 transition">Batal</button>
                <x-primary-button @click="window.isCustomLeaving = true; window.dispatchEvent(new CustomEvent('page-loading')); window.location.href = targetUrl" class="flex-1 justify-center py-3 !bg-orange-500 hover:!bg-orange-600 shadow-orange-200">Tinggalkan</x-primary-button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('evaluationForm', () => ({
            evalTitle: '',
            language: '',
            duration: '',
            evalType: 'Multiple Choice and Essay',
            guides: [
                'Koneksi internet stabil',
                'Gunakan browser yang disarankan (Chrome/Edge)',
                'Pastikan Kamera & Mikrofon berfungsi',
                'Jangan membuka Tab/Jendela Lain',
                'Waktu akan berjalan saat Anda menekan "Mulai Ujian"'
            ],
            isAddingGuide: false,
            newGuideText: '',
            
            mcqs: [],
            essays: [],
            
            mcqDrawerOpen: false,
            essayDrawerOpen: false,
            
            toast: {
                show: false,
                message: '',
                type: 'success'
            },

            isLeaving: false,
            
            navigateAway(url) {
                if (this.isDirty() && !this.isSubmitting) {
                    window.dispatchEvent(new CustomEvent('page-loaded')); // Force hide loader if it accidentally showed up
                    window.dispatchEvent(new CustomEvent('open-leave-modal', { detail: { url: url } }));
                } else {
                    window.dispatchEvent(new CustomEvent('page-loading'));
                    window.location.href = url;
                }
            },
            
            init() {
                // Listen specifically for the tinggalkan event from the modal
                window.addEventListener('open-leave-modal', () => {
                    this.isLeaving = true;
                });
                // Wait, if user cancels the modal, isLeaving stays true! 
                // That's bad. Let's just track it natively using a window variable or similar, or just inside evaluationForm.
                // Actually, the easiest way to prevent double modal is removing the window beforeunload listener OR simply relying on isSubmitting.
                
                window.addEventListener('beforeunload', (e) => {
                    // We can check if page-loading is active maybe? No.
                    // Instead, we just let the native beforeunload do its thing ONLY if we didn't trigger a custom navigation.
                    if (this.isDirty() && !this.isSubmitting && !window.isCustomLeaving) {
                        e.preventDefault();
                        e.returnValue = '';
                    }
                });
            },
            
            isDirty() {
                return this.evalTitle.trim() !== '' || 
                       this.language.trim() !== '' || 
                       this.duration !== '' || 
                       this.mcqs.length > 0 || 
                       this.essays.length > 0 ||
                       this.guides.length !== 5;
            },

            showToast(message, type = 'success') {
                this.toast.message = message;
                this.toast.type = type;
                this.toast.show = true;
                setTimeout(() => {
                    this.toast.show = false;
                }, 4000);
            },
            
            addGuide() {
                if(this.newGuideText.trim()) {
                    this.guides.push(this.newGuideText.trim());
                    this.newGuideText = '';
                    this.isAddingGuide = false;
                }
            },
            removeGuide(index) {
                this.guides.splice(index, 1);
            },
            
            openMcqDrawer(index) {
                this.mcqs[index].isOpen = true;
                this.mcqDrawerOpen = true;
            },
            addMcq() {
                const incompleteIndex = this.mcqs.findIndex(m => !m.question || !m.options[0] || !m.options[1] || !m.options[2] || !m.options[3]);
                if (incompleteIndex !== -1) {
                    this.showToast('Harap lengkapi Soal ' + (incompleteIndex + 1) + ' terlebih dahulu (pertanyaan dan semua opsi)!', 'error');
                    this.mcqs[incompleteIndex].isOpen = true;
                    this.mcqDrawerOpen = true;
                    return;
                }
                
                this.mcqs.push({
                    question: '',
                    options: ['', '', '', ''],
                    correct_answer: null,
                    images: [],
                    isOpen: true
                });
                this.mcqDrawerOpen = true;
            },
            deleteMcq(index) {
                this.mcqs.splice(index, 1);
                if (this.mcqs.length === 0) {
                    this.mcqDrawerOpen = false;
                }
            },
            
            openEssayDrawer(index) {
                this.essays[index].isOpen = true;
                this.essayDrawerOpen = true;
            },
            addEssay() {
                const incompleteIndex = this.essays.findIndex(e => !e.question);
                if (incompleteIndex !== -1) {
                    this.showToast('Harap lengkapi Soal ' + (incompleteIndex + 1) + ' terlebih dahulu!', 'error');
                    this.essays[incompleteIndex].isOpen = true;
                    this.essayDrawerOpen = true;
                    return;
                }
                
                this.essays.push({
                    question: '',
                    images: [],
                    isOpen: true
                });
                this.essayDrawerOpen = true;
            },
            deleteEssay(index) {
                this.essays.splice(index, 1);
                if (this.essays.length === 0) {
                    this.essayDrawerOpen = false;
                }
            },

            saveMcq(index) {
                const mcq = this.mcqs[index];
                if (!mcq.question || !mcq.options[0] || !mcq.options[1] || !mcq.options[2] || !mcq.options[3]) {
                    this.showToast('Harap lengkapi pertanyaan dan semua opsi!', 'error');
                    return;
                }
                if (mcq.correct_answer === null) {
                    this.showToast('Harap pilih kunci jawaban!', 'error');
                    return;
                }
                mcq.isOpen = false;
            },
            saveEssay(index) {
                const essay = this.essays[index];
                if (!essay.question) {
                    this.showToast('Harap isi pertanyaan!', 'error');
                    return;
                }
                essay.isOpen = false;
            },
            
            handleFileChange(e, type, index) {
                const item = type === 'mcq' ? this.mcqs[index] : this.essays[index];
                Array.from(e.target.files).forEach(file => {
                    item.images.push({
                        file: file,
                        url: URL.createObjectURL(file)
                    });
                });
                e.target.value = '';
            },
            removeImage(type, itemIndex, imgIndex) {
                const item = type === 'mcq' ? this.mcqs[itemIndex] : this.essays[itemIndex];
                item.images.splice(imgIndex, 1);
            },
            
            isSubmitting: false,
            submitEvaluasi() {
                // Validation
                if (!this.evalTitle.trim()) {
                    this.showToast('Judul evaluasi tidak boleh kosong', 'error');
                    return;
                }

                // Validation for MCQs
                if (this.evalType !== 'Essay Only') {
                    if (this.mcqs.length === 0) {
                        this.showToast('Tipe evaluasi ini membutuhkan minimal 1 Soal Pilihan Ganda', 'error');
                        return;
                    }
                    const incompleteMcq = this.mcqs.findIndex(m => !m.question.trim() || !m.options[0].trim() || !m.options[1].trim() || !m.options[2].trim() || !m.options[3].trim());
                    if (incompleteMcq !== -1) {
                        this.showToast('Harap lengkapi pertanyaan dan semua opsi untuk Soal Pilihan Ganda ' + (incompleteMcq + 1), 'error');
                        this.mcqDrawerOpen = true;
                        this.mcqs[incompleteMcq].isOpen = true;
                        return;
                    }
                    const noAnswerMcq = this.mcqs.findIndex(m => m.correct_answer === null);
                    if (noAnswerMcq !== -1) {
                        this.showToast('Harap pilih kunci jawaban untuk Soal Pilihan Ganda ' + (noAnswerMcq + 1), 'error');
                        this.mcqDrawerOpen = true;
                        this.mcqs[noAnswerMcq].isOpen = true;
                        return;
                    }
                }

                // Validation for Essays
                if (this.evalType !== 'Multiple Choice Only') {
                    if (this.essays.length === 0) {
                        this.showToast('Tipe evaluasi ini membutuhkan minimal 1 Soal Esai', 'error');
                        return;
                    }
                    const incompleteEssay = this.essays.findIndex(e => !e.question.trim());
                    if (incompleteEssay !== -1) {
                        this.showToast('Harap isi pertanyaan untuk Soal Esai ' + (incompleteEssay + 1), 'error');
                        this.essayDrawerOpen = true;
                        this.essays[incompleteEssay].isOpen = true;
                        return;
                    }
                }

                this.isSubmitting = true;
                
                let formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('judul', this.evalTitle);
                formData.append('bahasa', this.language);
                formData.append('durasi_menit', this.duration);
                formData.append('tipe', this.evalType);
                formData.append('panduan', JSON.stringify(this.guides));
                formData.append('mcqs', JSON.stringify(this.mcqs));
                formData.append('essays', JSON.stringify(this.essays));

                // Append images from the objects
                this.mcqs.forEach((mcq, index) => {
                    if (mcq.images && mcq.images.length > 0) {
                        mcq.images.forEach(img => {
                            formData.append(`mcq_images[${index}][]`, img.file);
                        });
                    }
                });

                this.essays.forEach((essay, index) => {
                    if (essay.images && essay.images.length > 0) {
                        essay.images.forEach(img => {
                            formData.append(`essay_images[${index}][]`, img.file);
                        });
                    }
                });

                fetch('{{ route('teacher.evaluations.store', $currentModuleId ?? 2) }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.isCustomLeaving = true;
                        window.location.href = '{{ route('teacher.modules.show', $currentModuleId) }}?success=evaluation_created';
                    } else {
                        this.isSubmitting = false;
                        this.showToast(data.message || 'Gagal menyimpan evaluasi', 'error');
                    }
                })
                .catch(error => {
                    this.isSubmitting = false;
                    this.showToast('Terjadi kesalahan jaringan', 'error');
                    console.error(error);
                });
            }
        }));
    });
</script>
@endpush
