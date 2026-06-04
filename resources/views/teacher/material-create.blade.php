@extends('layouts.teacher')

@section('title', 'Tambah Materi - LPK Seishin')

@section('content')
@php
    $currentModuleId = request()->route('id_modul') ?? 2;
    // Dummy Data
    $batchName = 'Batch 2';
    $className = 'N4 Mastering';
@endphp

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<style>
    .ql-toolbar.ql-snow {
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem 0.75rem 0 0;
        background-color: #f9fafb;
        padding: 0.75rem;
    }
    .ql-container.ql-snow {
        border: 1px solid #e5e7eb;
        border-top: none;
        border-radius: 0 0 0.75rem 0.75rem;
        font-family: 'Karla', sans-serif;
        font-size: 0.875rem;
    }
    .ql-editor {
        min-height: 200px;
    }
    .ql-editor.ql-blank::before {
        color: #9ca3af;
        font-style: normal;
    }
</style>
@endpush

<div class="p-4 sm:p-6 lg:p-10" x-data="{ 
    materialType: 'Practice',
    showTextEditor: false,
    showVideoUpload: false,
    showTaskForm: false
}">

    {{-- Header Row: Title + Breadcrumb + Publish Button --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('teacher.modules.show', $currentModuleId) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-gray-900 tracking-tight">Tambah Materi</h1>
            </div>
            <nav class="flex flex-wrap items-center gap-1.5 text-xs sm:text-sm">
                <a href="{{ route('teacher.classes') }}" class="text-gray-500 hover:text-gray-700 font-medium transition">Kelas Saya</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('teacher.batch.show', 2) }}" class="text-gray-500 hover:text-gray-700 font-medium transition">{{ $batchName }}</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('teacher.subjects.show', 1) }}" class="text-gray-500 hover:text-gray-700 font-medium transition">{{ $className }}</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('teacher.modules.show', $currentModuleId) }}" class="text-gray-500 hover:text-gray-700 font-medium transition">Modul {{ $currentModuleId }}</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#d62828] font-semibold">Tambah Materi</span>
            </nav>
        </div>
        <button @click="$dispatch('open-publish-modal')" class="inline-flex items-center gap-2 bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-lg text-sm transition shadow-sm self-start">
            Terbitkan Materi
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
        </button>
    </div>

    {{-- Main Content Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 lg:gap-8">
        
        {{-- Left Column (Spans 3/4) --}}
        <div class="lg:col-span-3 flex flex-col gap-6 lg:gap-8">
            
            {{-- Material Content Editor & Video --}}
            <div class="bg-white border border-gray-100 rounded-[24px] p-6 sm:p-8 shadow-sm">
                <input type="text" placeholder="Masukkan judul di sini..." class="w-full text-xl sm:text-2xl font-bold font-ibm text-gray-900 placeholder-gray-400 border-none focus:ring-0 px-0 mb-6 bg-transparent outline-none">
                
                <div class="space-y-6">
                    {{-- Text Editor Toggle & Content --}}
                    <div>
                        <!-- Toggle Button -->
                        <button x-show="!showTextEditor" @click="showTextEditor = true" class="w-full py-3 px-4 border-2 border-dashed border-red-200 hover:border-[#d62828] hover:bg-red-50 rounded-xl text-[#d62828] font-bold font-karla text-sm flex items-center justify-center gap-2 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Teks
                        </button>
                        
                        {{-- Quill Rich Text Editor --}}
                        <div x-show="showTextEditor" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                            <div class="mb-4" wire:ignore>
                                <div id="editor-container"></div>
                                <input type="hidden" name="content" id="material-content">
                            </div>
                            
                            <div class="flex justify-end mt-4 pt-4 border-t border-gray-100">
                                <button @click="showTextEditor = false" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Video Upload/Link Toggle & Content --}}
                    <div>
                        <!-- Toggle Button -->
                        <button x-show="!showVideoUpload" @click="showVideoUpload = true" class="w-full py-3 px-4 border-2 border-dashed border-red-200 hover:border-[#d62828] hover:bg-red-50 rounded-xl text-[#d62828] font-bold font-karla text-sm flex items-center justify-center gap-2 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Video
                        </button>

                        <div x-show="showVideoUpload" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
                                {{-- Left Side: Upload --}}
                                <div class="md:col-span-2" x-data="{ isUploading: false, showFile: false }">
                                    <h4 class="text-xs font-bold font-karla text-gray-700 mb-2">Upload Video</h4>
                                    
                                    <input type="file" name="video_file" x-ref="videoFile" class="hidden" accept="video/mp4,video/x-m4v,video/*" @change="if($refs.videoFile.files.length > 0) { isUploading = true; setTimeout(() => { isUploading = false; showFile = true }, 1500) }">
                                    <div x-show="!showFile" @click="$refs.videoFile.click()" class="border-2 border-dashed border-red-200 rounded-2xl p-6 flex flex-col items-center justify-center text-center hover:bg-red-50 transition cursor-pointer mb-4 min-h-[140px] relative">
                                        <div x-show="!isUploading" class="flex flex-col items-center">
                                            <svg class="w-10 h-10 text-[#d62828] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                            <p class="text-xs font-bold font-karla text-gray-700">Drag & drop files or <span class="text-[#d62828]">Browse</span></p>
                                            <p class="text-[9px] text-gray-400 mt-1">Supported formats: MP4, MKV, MOV, AVI</p>
                                        </div>
                                        <div x-show="isUploading" style="display: none;" class="flex flex-col items-center">
                                            <svg class="animate-spin w-8 h-8 text-[#d62828] mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <p class="text-xs font-bold font-karla text-gray-700">Uploading...</p>
                                        </div>
                                    </div>

                                    <div x-show="showFile" x-transition.opacity style="display: none;" class="flex items-center justify-between p-3 border border-gray-100 rounded-xl bg-gray-50/50 mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 flex items-center justify-center bg-red-50 rounded-lg text-red-500">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <div>
                                                <p class="text-[13px] font-bold font-karla text-gray-900 truncate max-w-[100px]">Video_Materi.mp4</p>
                                                <p class="text-[10px] font-karla text-gray-500 uppercase">MP4</p>
                                            </div>
                                        </div>
                                        <button @click="showFile = false" class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                    
                                    <div x-show="!showFile" class="relative flex items-center py-2 mb-2">
                                        <div class="flex-grow border-t border-gray-200"></div>
                                        <span class="flex-shrink-0 mx-4 text-[10px] font-bold text-gray-400">OR</span>
                                        <div class="flex-grow border-t border-gray-200"></div>
                                    </div>
                                    
                                    <div x-show="!showFile" class="mt-2" x-data="{ linkInput: '' }">
                                        <div class="flex bg-gray-50 border border-gray-200 rounded-xl overflow-hidden focus-within:border-red-500 focus-within:ring-1 focus-within:ring-red-500 transition mb-3">
                                            <input type="text" x-model="linkInput" placeholder="Enter video url..." class="w-full px-4 py-3 bg-transparent border-none focus:ring-0 text-sm font-karla outline-none">
                                        </div>
                                        <button @click="if(linkInput) { isUploading = true; setTimeout(() => { isUploading = false; showFile = true; linkInput = '' }, 500) }" class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-5 rounded-xl text-xs flex items-center gap-2 transition ml-auto">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            Tambah Link
                                        </button>
                                    </div>
                                </div>
                                
                                {{-- Right Side: Form --}}
                                <div class="md:col-span-3 space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold font-karla text-gray-700 mb-1.5">Judul Video</label>
                                        <input type="text" placeholder="cth., N4 Level Conversation - Dialogue" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla outline-none transition">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold font-karla text-gray-700 mb-1.5">Fokus Skill</label>
                                        <input type="text" placeholder="cth., Speaking (Kaiwa)" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla outline-none transition">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold font-karla text-gray-700 mb-1.5">Poin Utama</label>
                                        <input type="text" placeholder="cth., Jikoshoukai, Etika Ojigi" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla outline-none transition">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold font-karla text-gray-700 mb-1.5">Tujuan</label>
                                        <textarea rows="2" placeholder="Siswa mampu memahami informasi penting..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla resize-y outline-none transition"></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold font-karla text-gray-700 mb-1.5">Catatan Sensei</label>
                                        <textarea rows="2" placeholder="Fokuskan perhatian pada pola kalimat..." class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla resize-y outline-none transition"></textarea>
                                    </div>
                                    
                                    <div class="flex justify-end pt-2">
                                        <button @click="showVideoUpload = false" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Practical Task Section --}}
            <div x-show="materialType === 'Practice'" 
                 x-transition:enter="transition ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4" 
                 x-transition:enter-end="opacity-100 translate-y-0" 
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-4"
                 style="display: none;"
                 class="bg-white border border-gray-100 rounded-[24px] p-6 sm:p-8 shadow-sm mb-10">
                <h3 class="text-base font-bold font-ibm text-gray-900 mb-6">Tugas Praktik</h3>
                
                <!-- Toggle Button -->
                <button x-show="!showTaskForm" @click="showTaskForm = true" class="w-full py-3 px-4 border-2 border-dashed border-red-200 hover:border-[#d62828] hover:bg-red-50 rounded-xl text-[#d62828] font-bold font-karla text-sm flex items-center justify-center gap-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Tugas
                </button>

                <div x-show="showTaskForm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-5">
                            <div class="h-full">
                                <label class="block text-xs font-bold font-karla text-gray-700 mb-1.5">Deskripsi Tugas</label>
                                <textarea name="task_description" rows="6" placeholder="Bacalah dokumen PDF terlampir..." class="w-full h-full min-h-[140px] px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla resize-y outline-none transition"></textarea>
                            </div>
                        </div>
                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-bold font-karla text-gray-700 mb-1.5">Batas Waktu</label>
                                <div class="relative">
                                    <svg class="w-4 h-4 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <input type="text" placeholder="DD-MM-YYYY 00:00" class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla outline-none transition">
                                </div>
                            </div>
                            <div x-data="{ isUploading: false, showFile: false }">
                                <label class="block text-xs font-bold font-karla text-gray-700 mb-1.5">File Pendukung</label>
                                <input type="file" name="task_file" x-ref="taskFile" class="hidden" accept=".pdf,.doc,.docx" @change="if($refs.taskFile.files.length > 0) { isUploading = true; setTimeout(() => { isUploading = false; showFile = true }, 1500) }">
                                <button type="button" x-show="!showFile" @click="$refs.taskFile.click()" class="w-full bg-[#d62828] hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl text-sm flex items-center justify-center transition mb-4 relative overflow-hidden">
                                    <div x-show="!isUploading" class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Upload File
                                    </div>
                                    <div x-show="isUploading" style="display: none;" class="flex items-center gap-2">
                                        <svg class="animate-spin w-4 h-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Uploading...
                                    </div>
                                </button>
                                
                                {{-- Example uploaded file --}}
                                <div x-show="showFile" style="display: none;" x-transition.opacity class="flex items-center justify-between p-3 border border-gray-100 rounded-xl bg-gray-50/50">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 flex items-center justify-center bg-red-50 rounded-lg text-red-500">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-[13px] font-bold font-karla text-gray-900">Tugas_Dokkai_Stasiun.pdf</p>
                                            <p class="text-[10px] font-karla text-gray-500 uppercase">PDF</p>
                                        </div>
                                    </div>
                                    <button @click="showFile = false" class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-4 pt-4 border-t border-gray-100">
                        <button @click="showTaskForm = false" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right Column (Spans 1/4) --}}
        <div class="lg:col-span-1">
            <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm sticky top-6">
                <h3 class="text-base font-bold font-ibm text-gray-900 mb-6">Pengaturan Materi</h3>
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold font-karla text-gray-700 mb-2">Tipe</label>
                        <div class="relative">
                            <select x-model="materialType" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-red-500 focus:ring-2 focus:ring-red-100 text-sm font-karla bg-white outline-none transition cursor-pointer appearance-none bg-none">
                                <option value="Theory">Teori</option>
                                <option value="Practice">Praktik</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                    
                    <div x-data="{ isUploading: false, showResource: false }">
                        <label class="block text-xs font-bold font-karla text-gray-700 mb-2">Tambah Sumber Daya</label>
                        <input type="file" name="resource_file" x-ref="resourceFile" class="hidden" accept=".pdf,.doc,.docx,.ppt,.pptx" @change="if($refs.resourceFile.files.length > 0) { isUploading = true; setTimeout(() => { isUploading = false; showResource = true }, 1500) }">
                        <div x-show="!showResource" @click="$refs.resourceFile.click()" class="border-2 border-dashed border-red-200 rounded-2xl p-6 flex flex-col items-center justify-center text-center hover:bg-red-50 transition cursor-pointer mb-4 min-h-[140px] relative">
                            <div x-show="!isUploading" class="flex flex-col items-center">
                                <svg class="w-10 h-10 text-[#d62828] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                <p class="text-xs font-bold font-karla text-gray-700">Drag & drop files or <span class="text-[#d62828]">Browse</span></p>
                                <p class="text-[9px] text-gray-400 mt-1">Supported formats: PDF, DOCX, PPTX</p>
                            </div>
                            <div x-show="isUploading" style="display: none;" class="flex flex-col items-center">
                                <svg class="animate-spin w-8 h-8 text-[#d62828] mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p class="text-xs font-bold font-karla text-gray-700">Uploading...</p>
                            </div>
                        </div>
                        
                        {{-- Example file --}}
                        <div x-show="showResource" style="display: none;" x-transition.opacity class="flex items-center justify-between p-3 border border-gray-100 rounded-xl bg-gray-50/50">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 flex items-center justify-center bg-red-50 rounded-lg text-red-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[13px] font-bold font-karla text-gray-900 truncate max-w-[100px]">Daftar_Kanji_N4.pdf</p>
                                    <p class="text-[10px] font-karla text-gray-500 uppercase">PDF</p>
                                </div>
                            </div>
                            <button @click="showResource = false" class="text-red-500 hover:bg-red-50 p-1.5 rounded-lg transition flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('modals')
<div x-data="{ showPublishModal: false }" @open-publish-modal.window="showPublishModal = true">
    <div x-show="showPublishModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center px-4" >
        <!-- Overlay -->
        <div x-show="showPublishModal" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
        
        <!-- Modal Content -->
        <div x-show="showPublishModal" @click.outside="showPublishModal = false" class="relative bg-white rounded-[24px] w-full max-w-sm p-6 shadow-xl" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
            <div class="w-16 h-16 rounded-full bg-red-50 text-red-500 flex items-center justify-center mb-5 mx-auto">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h3 class="text-xl font-bold font-ibm text-gray-900 text-center mb-2">Terbitkan Materi?</h3>
            <p class="text-sm text-gray-500 font-karla text-center mb-6">Materi ini akan segera tersedia untuk semua siswa di dalam kelas.</p>
            <div class="flex gap-3">
                <button @click="showPublishModal = false" class="flex-1 py-3 rounded-xl border border-gray-200 text-gray-700 font-bold font-karla text-sm hover:bg-gray-50 transition">Batal</button>
                <button @click="window.location.href='{{ route('teacher.modules.show', $currentModuleId) }}'" class="flex-1 py-3 rounded-xl bg-[#d62828] text-white font-bold font-karla text-sm hover:bg-red-700 transition">Terbitkan</button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (document.getElementById('editor-container')) {
            const quill = new Quill('#editor-container', {
                theme: 'snow',
                placeholder: 'Pada sesi ini, kita akan berlatih...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        ['blockquote', 'code-block'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'align': [] }],
                        ['link', 'image', 'video'],
                        ['clean']
                    ]
                }
            });

            // Sync Quill content to hidden input
            quill.on('text-change', function() {
                document.getElementById('material-content').value = quill.root.innerHTML;
            });
        }
    });
</script>
@endpush
