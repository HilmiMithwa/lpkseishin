@extends('layouts.teacher')

@section('title', isset($task) ? 'Edit Tugas - LPK Seishin' : 'Tambah Tugas - LPK Seishin')

@section('content')
@php
    $currentModuleId = $modul->id_modul;
    $batchName = $modul->mapel->batch->nama_batch ?? 'Batch';
    $className = $modul->mapel->nama_mapel ?? 'Kelas';
@endphp

<div class="p-4 sm:p-6 lg:p-10 bg-[#fdfdfc] min-h-screen" x-data="{}">

    <form id="taskForm" action="{{ isset($task) ? route('teacher.tasks.update', ['id_modul' => $currentModuleId, 'id_tugas' => $task->id_tugas]) : route('teacher.tasks.store', $currentModuleId) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($task))
            @method('PUT')
        @endif
        
        {{-- Header Row: Title + Breadcrumb + Publish Button --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
            <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('teacher.modules.show', $currentModuleId) }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-gray-900 tracking-tight">{{ isset($task) ? 'Edit Tugas' : 'Tambah Tugas' }}</h1>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm font-karla">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <nav class="flex flex-wrap items-center gap-1.5 text-xs sm:text-sm font-karla">
                <a href="{{ route('teacher.classes') }}" class="text-gray-500 hover:text-gray-700 font-medium transition">Kelas Saya</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('teacher.batch.show', $batchId) }}" class="text-gray-500 hover:text-gray-700 font-medium transition">{{ $batchName }}</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('teacher.subjects.show', $mapelId) }}" class="text-gray-500 hover:text-gray-700 font-medium transition">{{ $className }}</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <a href="{{ route('teacher.modules.show', $currentModuleId) }}" class="text-gray-500 hover:text-gray-700 font-medium transition">Modul {{ $moduleIndex }}</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#d62828] font-bold">{{ isset($task) ? 'Edit Tugas' : 'Tambah Tugas' }}</span>
            </nav>
            </div>
            <div class="flex items-center gap-3 self-start">
                <a href="{{ route('teacher.modules.show', $currentModuleId) }}" class="hidden sm:inline-flex items-center gap-2 bg-white border border-gray-200 hover:bg-gray-50 text-gray-600 font-bold py-2.5 px-5 rounded-xl text-sm transition">
                    Batal
                </a>
                <x-primary-button type="button" @click="if(document.getElementById('taskForm').checkValidity()) { $dispatch('open-publish-modal') } else { document.getElementById('taskForm').reportValidity() }" class="gap-2">
                    {{ isset($task) ? 'Simpan Perubahan' : 'Terbitkan Tugas' }}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                </x-primary-button>
            </div>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
            
            {{-- Left Column: Main Content (Spans 2/3) --}}
            <div class="xl:col-span-2">
                <div class="bg-white border border-gray-100 rounded-[24px] p-6 lg:p-8 shadow-sm flex flex-col gap-6">
                    
                    {{-- Title Input --}}
                    <div class="space-y-1.5">
                        <x-input-label>Judul Tugas</x-input-label>
                        <x-text-input type="text" name="title" value="{{ old('title', $task->judul_tugas ?? '') }}" placeholder="Masukkan judul tugas..." required />
                    </div>
                    
                    <div class="h-px bg-gray-100 w-full"></div>

                    {{-- Description Textarea --}}
                    <div class="space-y-1.5">
                        <x-input-label>Deskripsi Tugas</x-input-label>
                        <textarea name="content" rows="10" required placeholder="Tuliskan instruksi atau deskripsi lengkap tugas di sini..." class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm resize-y shadow-sm">{{ old('content', $task->deskripsi_tugas ?? '') }}</textarea>
                    </div>

                </div>
            </div>

            {{-- Right Column: Settings & Attachments (Spans 1/3) --}}
            <div class="xl:col-span-1">
                <div class="bg-white border border-gray-100 rounded-[24px] p-6 shadow-sm sticky top-6">
                    <h3 class="text-base font-bold font-ibm text-gray-900 mb-6">Pengaturan Tugas</h3>
                    
                    <div class="space-y-6">
                        
                        {{-- Deadline --}}
                        <div class="space-y-1.5">
                            <x-input-label>Tenggat Waktu</x-input-label>
                            <div class="relative">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <input type="datetime-local" name="deadline" value="{{ old('deadline', isset($task) && $task->waktu_pengumpulan ? \Carbon\Carbon::parse($task->waktu_pengumpulan)->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-2.5 pl-10 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm shadow-sm">
                            </div>
                        </div>

                        <div class="h-px bg-gray-100 w-full"></div>

                        {{-- Attachments --}}
                        <div class="space-y-1.5" x-data="{ isUploading: false, showResource: {{ isset($task) && $task->file_path_tugas ? 'true' : 'false' }}, fileName: '{{ isset($task) && $task->file_path_tugas ? addslashes(basename($task->file_path_tugas)) : '' }}', removeResource: false }">
                            <x-input-label>Tambah Sumber Daya</x-input-label>
                            <input type="file" name="resource_file" x-ref="resourceFile" class="hidden" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.png" @change="if($refs.resourceFile.files.length > 0) { fileName = $refs.resourceFile.files[0].name; isUploading = true; removeResource = false; setTimeout(() => { isUploading = false; showResource = true }, 1500) }">
                            <input type="hidden" name="remove_resource" :value="removeResource ? '1' : '0'">
                            
                            {{-- Dropzone Area --}}
                            <div x-show="!showResource" @click="$refs.resourceFile.click()" class="border-2 border-dashed border-red-200 bg-white hover:bg-red-50 hover:border-red-300 rounded-[20px] p-8 flex flex-col items-center justify-center text-center transition cursor-pointer min-h-[160px]">
                                <div x-show="!isUploading" class="flex flex-col items-center">
                                    <svg class="w-8 h-8 text-[#d62828] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    <p class="text-[13px] font-bold font-karla text-gray-800 mb-1">Drag & drop files or <span class="text-[#d62828]">Browse</span></p>
                                    <p class="text-[10px] font-medium text-gray-400">Supported formats: PDF, DOCX, PPTX, JPG, PNG</p>
                                </div>
                                <div x-show="isUploading" style="display: none;" class="flex flex-col items-center">
                                    <svg class="animate-spin w-8 h-8 text-[#d62828] mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <p class="text-sm font-bold text-gray-700">Mengunggah...</p>
                                </div>
                            </div>
                            
                            {{-- Uploaded File Preview --}}
                            <div x-show="showResource" style="display: none;" x-transition>
                                <div class="flex items-center justify-between p-4 border border-red-100 rounded-xl bg-white mt-2">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 flex items-center justify-center bg-white border border-red-100 rounded-[10px] text-red-500 flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <div class="overflow-hidden">
                                            <p class="text-[13px] font-bold text-gray-900 truncate mb-0.5" x-text="fileName"></p>
                                        </div>
                                    </div>
                                    <button type="button" @click="$refs.resourceFile.value = ''; showResource = false; fileName = ''; removeResource = true" class="text-gray-400 hover:text-red-500 p-2 rounded-lg hover:bg-gray-50 transition flex-shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </form>

    {{-- Publish Modal --}}
    <template x-teleport="body">
        <div x-data="{ showPublishModal: false, isSubmitting: false }" @open-publish-modal.window="showPublishModal = true">
            <div x-show="showPublishModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center px-4" >
                <div x-show="showPublishModal" class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>
                <div x-show="showPublishModal" @click.outside="if(!isSubmitting) showPublishModal = false" class="relative bg-white rounded-[24px] w-full max-w-sm p-6 shadow-xl" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                    <div class="w-16 h-16 rounded-full bg-red-50 text-red-500 flex items-center justify-center mb-5 mx-auto">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold font-ibm text-gray-900 text-center mb-2">{{ isset($task) ? 'Simpan Perubahan?' : 'Terbitkan Tugas?' }}</h3>
                    <p class="text-sm text-gray-500 font-karla text-center mb-6">{{ isset($task) ? 'Tugas akan diperbarui dengan informasi terbaru.' : 'Tugas ini akan langsung terlihat oleh semua siswa di kelas.' }}</p>
                    <div class="flex gap-3">
                        <button type="button" @click="showPublishModal = false" :disabled="isSubmitting" class="flex-1 py-3 rounded-xl border border-gray-200 text-gray-700 font-bold font-karla text-sm hover:bg-gray-50 transition disabled:opacity-50">Batal</button>
                        <button type="button" @click="isSubmitting = true; document.getElementById('taskForm').submit()" :disabled="isSubmitting" class="flex-1 py-3 rounded-xl bg-[#d62828] text-white font-bold font-karla text-sm hover:bg-red-700 transition disabled:opacity-50 flex items-center justify-center gap-2">
                            <span x-show="!isSubmitting">{{ isset($task) ? 'Simpan' : 'Terbitkan' }}</span>
                            <span x-show="isSubmitting" style="display: none;" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Proses...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>

</div>
@endsection
