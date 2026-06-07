@extends('registration.layout')

@section('title', 'Step 3: Dokumen Pendukung - Pendaftaran Siswa LPK Seishin')

@php
    function getPreviewUrl($path) {
        if (!$path) return '';
        if (Str::startsWith($path, ['http://', 'https://'])) return $path;
        try {
            return Storage::disk('public')->exists($path) ? Storage::url($path) : Storage::disk('s3')->url($path);
        } catch (\Exception $e) {
            return '';
        }
    }
@endphp

@section('content')
<div>
    <h2 class="text-xl sm:text-2xl font-bold font-ibm text-[#222222] mb-1">Dokumen Pendukung</h2>
    <p class="text-sm text-[#666666] mb-6">Unggah dokumen-dokumen pendukung Anda (Format: JPG, PNG | Max: 2MB per file)</p>

    <form action="{{ route('registration.store-step3') }}" method="POST" enctype="multipart/form-data" id="step3Form">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- KTP Photo -->
            <div x-data="fileUpload('{{ getPreviewUrl($registration['ktp_photo'] ?? null) }}')">
                <div class="relative p-6 border-2 border-dashed border-gray-300 rounded-2xl hover:border-[#d62828]/50 transition overflow-hidden min-h-[160px] flex items-center justify-center cursor-pointer" 
                     :class="{ '!border-[#d62828] !bg-red-50': isDragging, 'p-0': previewUrl }"
                     @dragover.prevent="isDragging = true"
                     @dragleave.prevent="isDragging = false"
                     @drop.prevent="isDragging = false; handleDrop($event)"
                     @click="$refs.fileInput.click()">
                    
                    <!-- Preview Image -->
                    <template x-if="previewUrl">
                        <div class="absolute inset-0 w-full h-full group">
                            <img :src="previewUrl" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center backdrop-blur-[2px]">
                                <span class="text-white font-bold text-sm bg-black/50 px-4 py-2 rounded-full">Ganti Foto KTP</span>
                            </div>
                        </div>
                    </template>

                    <!-- Default Content -->
                    <template x-if="!previewUrl">
                        <div class="text-center w-full">
                            <div class="mb-3 flex justify-center">
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                            </div>
                            <p class="text-sm font-bold text-[#222222] mb-1">Foto KTP</p>
                            <p class="text-xs text-[#666666]">Klik atau drag & drop untuk mengunggah</p>
                        </div>
                    </template>

                    <input type="file" id="ktp_photo" name="ktp_photo" x-ref="fileInput" @change="handleFileChange($event)" accept="image/jpeg,image/png" class="hidden" {{ isset($registration['ktp_photo']) ? '' : 'required' }}>
                </div>
                <template x-if="errorMsg">
                    <p class="text-red-600 text-xs font-semibold mt-2" x-text="errorMsg"></p>
                </template>
                @error('ktp_photo')
                    <p class="text-red-600 text-xs font-semibold mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Family Card Photo -->
            <div x-data="fileUpload('{{ getPreviewUrl($registration['family_card_photo'] ?? null) }}')">
                <div class="relative p-6 border-2 border-dashed border-gray-300 rounded-2xl hover:border-[#d62828]/50 transition overflow-hidden min-h-[160px] flex items-center justify-center cursor-pointer" 
                     :class="{ '!border-[#d62828] !bg-red-50': isDragging, 'p-0': previewUrl }"
                     @dragover.prevent="isDragging = true"
                     @dragleave.prevent="isDragging = false"
                     @drop.prevent="isDragging = false; handleDrop($event)"
                     @click="$refs.fileInput.click()">
                    
                    <!-- Preview Image -->
                    <template x-if="previewUrl">
                        <div class="absolute inset-0 w-full h-full group">
                            <img :src="previewUrl" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center backdrop-blur-[2px]">
                                <span class="text-white font-bold text-sm bg-black/50 px-4 py-2 rounded-full">Ganti Foto Kartu Keluarga</span>
                            </div>
                        </div>
                    </template>

                    <!-- Default Content -->
                    <template x-if="!previewUrl">
                        <div class="text-center w-full">
                            <div class="mb-3 flex justify-center">
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                            </div>
                            <p class="text-sm font-bold text-[#222222] mb-1">Kartu Keluarga</p>
                            <p class="text-xs text-[#666666]">Klik atau drag & drop untuk mengunggah</p>
                        </div>
                    </template>

                    <input type="file" id="family_card_photo" name="family_card_photo" x-ref="fileInput" @change="handleFileChange($event)" accept="image/jpeg,image/png" class="hidden" {{ isset($registration['family_card_photo']) ? '' : 'required' }}>
                </div>
                <template x-if="errorMsg">
                    <p class="text-red-600 text-xs font-semibold mt-2" x-text="errorMsg"></p>
                </template>
                @error('family_card_photo')
                    <p class="text-red-600 text-xs font-semibold mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Birth Certificate Photo -->
            <div x-data="fileUpload('{{ getPreviewUrl($registration['birth_certificate_photo'] ?? null) }}')">
                <div class="relative p-6 border-2 border-dashed border-gray-300 rounded-2xl hover:border-[#d62828]/50 transition overflow-hidden min-h-[160px] flex items-center justify-center cursor-pointer" 
                     :class="{ '!border-[#d62828] !bg-red-50': isDragging, 'p-0': previewUrl }"
                     @dragover.prevent="isDragging = true"
                     @dragleave.prevent="isDragging = false"
                     @drop.prevent="isDragging = false; handleDrop($event)"
                     @click="$refs.fileInput.click()">
                    
                    <!-- Preview Image -->
                    <template x-if="previewUrl">
                        <div class="absolute inset-0 w-full h-full group">
                            <img :src="previewUrl" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center backdrop-blur-[2px]">
                                <span class="text-white font-bold text-sm bg-black/50 px-4 py-2 rounded-full">Ganti Foto Akte Kelahiran</span>
                            </div>
                        </div>
                    </template>

                    <!-- Default Content -->
                    <template x-if="!previewUrl">
                        <div class="text-center w-full">
                            <div class="mb-3 flex justify-center">
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                            </div>
                            <p class="text-sm font-bold text-[#222222] mb-1">Akte Kelahiran</p>
                            <p class="text-xs text-[#666666]">Klik atau drag & drop untuk mengunggah</p>
                        </div>
                    </template>

                    <input type="file" id="birth_certificate_photo" name="birth_certificate_photo" x-ref="fileInput" @change="handleFileChange($event)" accept="image/jpeg,image/png" class="hidden" {{ isset($registration['birth_certificate_photo']) ? '' : 'required' }}>
                </div>
                <template x-if="errorMsg">
                    <p class="text-red-600 text-xs font-semibold mt-2" x-text="errorMsg"></p>
                </template>
                @error('birth_certificate_photo')
                    <p class="text-red-600 text-xs font-semibold mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Passport Photo -->
            <div x-data="fileUpload('{{ getPreviewUrl($registration['passport_photo'] ?? null) }}')">
                <div class="relative p-6 border-2 border-dashed border-gray-300 rounded-2xl hover:border-[#d62828]/50 transition overflow-hidden min-h-[160px] flex items-center justify-center cursor-pointer" 
                     :class="{ '!border-[#d62828] !bg-red-50': isDragging, 'p-0': previewUrl }"
                     @dragover.prevent="isDragging = true"
                     @dragleave.prevent="isDragging = false"
                     @drop.prevent="isDragging = false; handleDrop($event)"
                     @click="$refs.fileInput.click()">
                    
                    <!-- Preview Image -->
                    <template x-if="previewUrl">
                        <div class="absolute inset-0 w-full h-full group">
                            <img :src="previewUrl" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center backdrop-blur-[2px]">
                                <span class="text-white font-bold text-sm bg-black/50 px-4 py-2 rounded-full">Ganti Pas Foto Terbaru</span>
                            </div>
                        </div>
                    </template>

                    <!-- Default Content -->
                    <template x-if="!previewUrl">
                        <div class="text-center w-full">
                            <div class="mb-3 flex justify-center">
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                            </div>
                            <p class="text-sm font-bold text-[#222222] mb-1">Pas Foto Terbaru</p>
                            <p class="text-xs text-[#666666]">Klik atau drag & drop untuk mengunggah</p>
                            <p class="text-xs text-[#666666] mt-1">(Ukuran 4x6 cm, latar belakang merah)</p>
                        </div>
                    </template>

                    <input type="file" id="passport_photo" name="passport_photo" x-ref="fileInput" @change="handleFileChange($event)" accept="image/jpeg,image/png" class="hidden" {{ isset($registration['passport_photo']) ? '' : 'required' }}>
                </div>
                <template x-if="errorMsg">
                    <p class="text-red-600 text-xs font-semibold mt-2" x-text="errorMsg"></p>
                </template>
                @error('passport_photo')
                    <p class="text-red-600 text-xs font-semibold mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Info Box -->
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
            <div class="flex gap-3">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-900 mb-1">Catatan Penting</p>
                    <ul class="text-xs text-blue-800 space-y-1">
                        <li>• Pastikan semua dokumen jelas dan terbaca</li>
                        <li>• Format file: JPG atau PNG</li>
                        <li>• Ukuran maksimal 2MB per file</li>
                        <li>• Semua dokumen wajib diunggah</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex gap-4 mt-8">
            <a href="{{ route('registration.step2') }}" class="flex-1 px-6 py-3 border-2 border-gray-300 text-[#222222] font-bold rounded-xl hover:bg-gray-50 transition text-center">
                Kembali
            </a>
            <button type="submit" class="flex-1 px-6 py-3 bg-[#d62828] text-white font-bold rounded-xl hover:bg-red-700 transition">
                Lanjut ke Tahap Berikutnya
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('fileUpload', (initialUrl = '') => ({
            previewUrl: initialUrl,
            isDragging: false,
            errorMsg: '',
            
            handleFileChange(e) {
                this.processFile(e.target.files[0]);
            },
            
            handleDrop(e) {
                const file = e.dataTransfer.files[0];
                if (file) {
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    this.$refs.fileInput.files = dataTransfer.files;
                    this.processFile(file);
                }
            },
            
            processFile(file) {
                if (!file) return;
                
                this.errorMsg = '';
                const validTypes = ['image/jpeg', 'image/png'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (!validTypes.includes(file.type)) {
                    this.errorMsg = 'Format file harus JPEG atau PNG';
                    return;
                }
                if (file.size > maxSize) {
                    this.errorMsg = 'Ukuran file terlalu besar (maksimal 2MB)';
                    return;
                }
                
                this.previewUrl = URL.createObjectURL(file);
            }
        }));
    });
</script>
@endsection
