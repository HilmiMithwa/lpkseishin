@extends('registration.layout')

@section('title', 'Step 4: Pembayaran - Pendaftaran Siswa LPK Seishin')

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
    <h2 class="text-xl sm:text-2xl font-bold font-ibm text-[#222222] mb-1">Pembayaran Komitmen</h2>
    <p class="text-sm text-[#666666] mb-6">Selesaikan pembayaran komitmen pendaftaran Anda</p>

    <form action="{{ route('registration.store-step4') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <!-- Payment Info -->
        <div class="bg-red-50 border border-red-200 rounded-2xl p-6 mb-8">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-bold text-[#222222] mb-2">Nominal Pembayaran</h3>
                    <p class="text-3xl font-bold font-ibm text-[#d62828]">Rp 100.000</p>
                    <p class="text-xs text-[#666666] mt-1">Biaya komitmen pendaftaran LPK Seishin</p>
                </div>
            </div>
        </div>

        <!-- QR Code Section -->
        <div class="bg-white border border-gray-200 rounded-2xl p-8 mb-8 text-center">
            <h3 class="text-base font-bold text-[#222222] mb-4">Scan QR Code untuk Melakukan Pembayaran</h3>
            <div class="flex justify-center mb-6">
                <div class="bg-gray-100 w-56 h-56 rounded-xl flex items-center justify-center border-2 border-dashed border-gray-300">
                    <!-- QR Code akan ditampilkan di sini -->
                    <div class="text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <p class="text-sm text-[#666666]">QR Code akan tampil di sini</p>
                    </div>
                </div>
            </div>
            <p class="text-xs text-[#666666]">Gunakan aplikasi e-wallet atau banking Anda untuk scan QR Code</p>
        </div>

        <!-- Payment Method Info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-xs font-bold text-blue-900">Metode Pembayaran</p>
                </div>
                <p class="text-xs text-blue-800">QRIS (tersedia di semua e-wallet dan mobile banking)</p>
            </div>

            <div class="p-4 bg-green-50 border border-green-200 rounded-xl">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-xs font-bold text-green-900">Waktu Pembayaran</p>
                </div>
                <p class="text-xs text-green-800">Pembayaran instant, langsung terverifikasi</p>
            </div>
        </div>

        <!-- Upload Proof Section -->
        <div class="mb-8">
            <h3 class="text-base font-bold font-ibm text-[#222222] mb-4 pb-3 border-b border-gray-200">Bukti Pembayaran</h3>
            
            <div x-data="fileUpload('{{ getPreviewUrl($registration['payment_proof'] ?? null) }}')">
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
                                <span class="text-white font-bold text-sm bg-black/50 px-4 py-2 rounded-full">Ganti Bukti Pembayaran</span>
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
                            <p class="text-sm font-bold text-[#222222] mb-1">Unggah Bukti Pembayaran</p>
                            <p class="text-xs text-[#666666]">Klik atau drag & drop screenshot/foto bukti pembayaran</p>
                            <p class="text-xs text-[#999999] mt-1">(JPG, PNG, max 2MB)</p>
                        </div>
                    </template>

                    <input type="file" id="payment_proof" name="payment_proof" x-ref="fileInput" @change="handleFileChange($event)" accept="image/jpeg,image/png" class="hidden" {{ isset($registration['payment_proof']) ? '' : 'required' }}>
                </div>
                <template x-if="errorMsg">
                    <p class="text-red-600 text-xs font-semibold mt-2" x-text="errorMsg"></p>
                </template>
                @error('payment_proof')
                    <p class="text-red-600 text-xs font-semibold mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Terms & Conditions -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-4 mb-8">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-xs font-semibold text-yellow-900 mb-1">Perhatian</p>
                    <p class="text-xs text-yellow-800">Pembayaran bersifat final. Dalam hal pembatalan, biaya komitmen tidak dapat dikembalikan. Bukti pembayaran akan diverifikasi sebelum akun Anda diaktifkan.</p>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex gap-4 mt-8">
            <a href="{{ route('registration.step3') }}" class="flex-1 px-6 py-3 border-2 border-gray-300 text-[#222222] font-bold rounded-xl hover:bg-gray-50 transition text-center">
                Kembali
            </a>
            <button type="submit" class="flex-1 px-6 py-3 bg-[#d62828] text-white font-bold rounded-xl hover:bg-red-700 transition">
                Selesaikan Pendaftaran
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
