@extends('layouts.teacher')

@section('content')
<div x-data="evaluationForm()" class="min-h-screen bg-[#fffdfc]">
    
    <div class="px-6 py-8 mx-auto max-w-7xl">
        {{-- Header & Breadcrumb --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold font-ibm text-gray-900 mb-2">Buat Evaluasi</h1>
                <div class="flex items-center gap-2 text-sm font-karla text-gray-500">
                    <a href="{{ route('teacher.classes') }}" class="hover:text-red-500 transition">Kelas Saya</a>
                    <span>›</span>
                    <a href="{{ route('teacher.batch.show', 2) }}" class="hover:text-red-500 transition">Batch 2</a>
                    <span>›</span>
                    <a href="{{ route('teacher.subjects.show', 1) }}" class="hover:text-red-500 transition">N4 Mastering</a>
                    <span>›</span>
                    <a href="{{ route('teacher.modules.show', $currentModuleId ?? 2) }}" class="hover:text-red-500 transition">Modul 2</a>
                    <span>›</span>
                    <span class="text-red-500 font-bold">Buat Evaluasi</span>
                </div>
            </div>
            
            <button @click="$dispatch('open-publish-modal')" class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-3 px-6 rounded-xl text-sm flex items-center gap-2 transition shadow-lg shadow-red-200">
                Terbitkan Evaluasi
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
            </button>
        </div>

        {{-- Form Content --}}
        <div class="bg-white border border-gray-100 rounded-[24px] p-8 shadow-sm mb-8">
            {{-- Add Evaluation Detail --}}
            <div class="mb-10">
                <h3 class="text-base font-bold font-ibm text-gray-900 mb-6">Detail Evaluasi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold font-karla text-gray-700 mb-2">Judul Evaluasi</label>
                        <input type="text" x-model="evalTitle" placeholder="Misal: Ujian Akhir Kompetensi" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold font-karla text-gray-700 mb-2">Bahasa</label>
                        <input type="text" x-model="language" placeholder="Misal: Bahasa Jepang N4" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold font-karla text-gray-700 mb-2">Durasi (Menit)</label>
                        <input type="number" x-model="duration" placeholder="Misal: 120" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold font-karla text-gray-700 mb-2">Tipe</label>
                        <select x-model="evalType" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla bg-white outline-none transition cursor-pointer">
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
                    <input type="text" x-model="newGuideText" @keydown.enter="addGuide" placeholder="Misal: Pastikan koneksi internet stabil" class="flex-1 px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla outline-none transition">
                    <button @click="isAddingGuide = false; newGuideText = ''" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded-xl text-sm transition flex-shrink-0">
                        Batal
                    </button>
                    <button @click="addGuide" class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-3 px-8 rounded-xl text-sm transition flex-shrink-0">
                        Simpan
                    </button>
                </div>
            </div>
            
            {{-- Questions Sections --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                {{-- Multiple Choice --}}
                <div x-show="evalType === 'Multiple Choice and Essay' || evalType === 'Multiple Choice Only'" class="p-6 rounded-[24px] border border-gray-100 bg-white">
                    <h3 class="text-base font-bold font-ibm text-gray-900 mb-6">Pilihan Ganda</h3>
                    
                    <div x-show="mcqs.length > 0" class="flex flex-wrap gap-3 mb-6">
                        <template x-for="(mcq, index) in mcqs" :key="index">
                            <button @click="openMcqDrawer(index)" class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition"
                                    :class="activeMcqIndex === index ? 'bg-red-50 text-red-500 border-2 border-red-200' : 'text-red-500 hover:bg-red-50 border border-transparent'">
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
                            <button @click="openEssayDrawer(index)" class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition"
                                    :class="activeEssayIndex === index ? 'bg-red-50 text-red-500 border-2 border-red-200' : 'text-red-500 hover:bg-red-50 border border-transparent'">
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
                         :class="activeMcqIndex === index ? 'shadow-md border-gray-300' : 'hover:border-gray-300'">
                        
                        {{-- Accordion Header --}}
                        <button @click="activeMcqIndex = index" class="w-full flex items-center justify-between p-4 bg-white text-left">
                            <span class="font-bold font-ibm text-gray-900 text-sm" x-text="'Soal ' + (index + 1)"></span>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300" :class="activeMcqIndex === index ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        {{-- Accordion Body --}}
                        <div x-show="activeMcqIndex === index" x-collapse>
                            <div class="p-5 pt-2 border-t border-gray-100 bg-white space-y-5">
                                <div>
                                    <label class="block text-[11px] font-bold font-karla text-gray-500 mb-2">Pertanyaan:</label>
                                    <textarea x-model="mcq.question" rows="4" placeholder="Ketikkan soal di sini..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla resize-y outline-none transition"></textarea>
                                    
                                    <div class="mt-3" x-data="imageUploader()">
                                        <input type="file" multiple :name="'mcq_images['+index+'][]'" :id="'mcq-img-'+index" x-ref="fileInput" class="hidden" accept="image/*" @change="handleFileChange">
                                        
                                        <!-- Image Previews -->
                                        <div x-show="images.length > 0" class="flex flex-wrap gap-3 mb-3">
                                            <template x-for="(img, imgIndex) in images" :key="imgIndex">
                                                <div class="relative group w-20 h-20 rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                                    <img :src="img.url" class="w-full h-full object-cover">
                                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                                        <button type="button" @click="removeImage(imgIndex, $refs.fileInput)" class="w-7 h-7 bg-white text-red-500 rounded-full flex items-center justify-center hover:scale-110 transition shadow-sm">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="button" @click="$refs.fileInput.click()" class="bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 font-bold py-2 px-4 rounded-lg text-[11px] transition shadow-sm flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                <span x-text="images.length > 0 ? 'Tambah Gambar Lain' : 'Unggah Gambar (Multiple)'"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[11px] font-bold font-karla text-gray-500 mb-1.5">Pilihan A:</label>
                                        <input type="text" x-model="mcq.options[0]" placeholder="Opsi A" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla outline-none transition">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold font-karla text-gray-500 mb-1.5">Pilihan B:</label>
                                        <input type="text" x-model="mcq.options[1]" placeholder="Opsi B" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla outline-none transition">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold font-karla text-gray-500 mb-1.5">Pilihan C:</label>
                                        <input type="text" x-model="mcq.options[2]" placeholder="Opsi C" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla outline-none transition">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold font-karla text-gray-500 mb-1.5">Pilihan D:</label>
                                        <input type="text" x-model="mcq.options[3]" placeholder="Opsi D" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla outline-none transition">
                                    </div>
                                </div>

                                <div class="flex gap-3 pt-4 border-t border-gray-100">
                                    <button @click="deleteMcq(index)" class="flex-1 py-3 bg-gray-50 hover:bg-red-50 border border-gray-200 hover:border-red-200 text-gray-700 hover:text-red-600 rounded-xl font-bold font-karla text-sm flex items-center justify-center gap-2 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                    <button @click="mcqDrawerOpen = false" class="flex-1 py-3 bg-[#d62828] hover:bg-red-700 text-white rounded-xl font-bold font-karla text-sm transition shadow-md shadow-red-200">
                                        Simpan
                                    </button>
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
                         :class="activeEssayIndex === index ? 'shadow-md border-gray-300' : 'hover:border-gray-300'">
                        
                        {{-- Accordion Header --}}
                        <button @click="activeEssayIndex = index" class="w-full flex items-center justify-between p-4 bg-white text-left">
                            <span class="font-bold font-ibm text-gray-900 text-sm" x-text="'Soal ' + (index + 1)"></span>
                            <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-300" :class="activeEssayIndex === index ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        {{-- Accordion Body --}}
                        <div x-show="activeEssayIndex === index" x-collapse>
                            <div class="p-5 pt-2 border-t border-gray-100 bg-white space-y-5">
                                <div>
                                    <label class="block text-[11px] font-bold font-karla text-gray-500 mb-2">Pertanyaan:</label>
                                    <textarea x-model="essay.question" rows="4" placeholder="Tuliskan soal esai di sini..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla resize-y outline-none transition"></textarea>
                                    
                                    <div class="mt-3" x-data="imageUploader()">
                                        <input type="file" multiple :name="'essay_images['+index+'][]'" :id="'essay-img-'+index" x-ref="fileInput" class="hidden" accept="image/*" @change="handleFileChange">
                                        
                                        <!-- Image Previews -->
                                        <div x-show="images.length > 0" class="flex flex-wrap gap-3 mb-3">
                                            <template x-for="(img, imgIndex) in images" :key="imgIndex">
                                                <div class="relative group w-20 h-20 rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                                                    <img :src="img.url" class="w-full h-full object-cover">
                                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                                        <button type="button" @click="removeImage(imgIndex, $refs.fileInput)" class="w-7 h-7 bg-white text-red-500 rounded-full flex items-center justify-center hover:scale-110 transition shadow-sm">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="button" @click="$refs.fileInput.click()" class="bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200 font-bold py-2 px-4 rounded-lg text-[11px] transition shadow-sm flex items-center gap-2">
                                                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                <span x-text="images.length > 0 ? 'Tambah Gambar Lain' : 'Unggah Gambar (Multiple)'"></span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="flex gap-3 pt-4 border-t border-gray-100">
                                    <button @click="deleteEssay(index)" class="flex-1 py-3 bg-gray-50 hover:bg-red-50 border border-gray-200 hover:border-red-200 text-gray-700 hover:text-red-600 rounded-xl font-bold font-karla text-sm flex items-center justify-center gap-2 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                    <button @click="essayDrawerOpen = false" class="flex-1 py-3 bg-[#d62828] hover:bg-red-700 text-white rounded-xl font-bold font-karla text-sm transition shadow-md shadow-red-200">
                                        Simpan
                                    </button>
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
                <button @click="window.location.href='{{ route('teacher.modules.show', $currentModuleId ?? 2) }}'" class="flex-1 py-3 rounded-xl bg-[#d62828] text-white font-bold font-karla text-sm hover:bg-red-700 transition">Terbitkan</button>
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
            activeMcqIndex: 0,
            activeEssayIndex: 0,
            
            toast: {
                show: false,
                message: '',
                type: 'error'
            },
            
            showToast(message, type = 'error') {
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
                this.activeMcqIndex = index;
                this.mcqDrawerOpen = true;
            },
            addMcq() {
                const incompleteIndex = this.mcqs.findIndex(m => !m.question || !m.options[0] || !m.options[1] || !m.options[2] || !m.options[3]);
                if (incompleteIndex !== -1) {
                    this.showToast('Harap lengkapi Soal ' + (incompleteIndex + 1) + ' terlebih dahulu (pertanyaan dan semua opsi)!', 'error');
                    this.activeMcqIndex = incompleteIndex;
                    this.mcqDrawerOpen = true;
                    return;
                }
                
                this.mcqs.push({
                    question: '',
                    options: ['', '', '', '']
                });
                this.activeMcqIndex = this.mcqs.length - 1;
                this.mcqDrawerOpen = true;
            },
            deleteMcq(index) {
                this.mcqs.splice(index, 1);
                if (this.mcqs.length === 0) {
                    this.mcqDrawerOpen = false;
                } else if (this.activeMcqIndex >= this.mcqs.length) {
                    this.activeMcqIndex = this.mcqs.length - 1;
                }
            },
            
            openEssayDrawer(index) {
                this.activeEssayIndex = index;
                this.essayDrawerOpen = true;
            },
            addEssay() {
                const incompleteIndex = this.essays.findIndex(e => !e.question);
                if (incompleteIndex !== -1) {
                    this.showToast('Harap lengkapi Soal ' + (incompleteIndex + 1) + ' terlebih dahulu!', 'error');
                    this.activeEssayIndex = incompleteIndex;
                    this.essayDrawerOpen = true;
                    return;
                }
                
                this.essays.push({
                    question: ''
                });
                this.activeEssayIndex = this.essays.length - 1;
                this.essayDrawerOpen = true;
            },
            deleteEssay(index) {
                this.essays.splice(index, 1);
                if (this.essays.length === 0) {
                    this.essayDrawerOpen = false;
                } else if (this.activeEssayIndex >= this.essays.length) {
                    this.activeEssayIndex = this.essays.length - 1;
                }
            }
        }));

        Alpine.data('imageUploader', () => ({
            images: [],
            handleFileChange(e) {
                const dt = new DataTransfer();
                
                // Keep existing images
                this.images.forEach(img => dt.items.add(img.file));
                
                // Add new images
                Array.from(e.target.files).forEach(file => {
                    dt.items.add(file);
                    this.images.push({
                        file: file,
                        name: file.name,
                        url: URL.createObjectURL(file)
                    });
                });
                
                // Update input
                e.target.files = dt.files;
            },
            removeImage(index, fileInput) {
                this.images.splice(index, 1);
                const dt = new DataTransfer();
                this.images.forEach(img => dt.items.add(img.file));
                fileInput.files = dt.files;
            }
        }));
    });
</script>
@endpush
