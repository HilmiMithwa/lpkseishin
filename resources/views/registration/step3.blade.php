@extends('registration.layout')

@section('title', 'Step 3: Dokumen Pendukung - Pendaftaran Siswa LPK Seishin')

@section('content')
<div>
    <h2 class="text-xl sm:text-2xl font-bold font-ibm text-[#222222] mb-1">Dokumen Pendukung</h2>
    <p class="text-sm text-[#666666] mb-6">Unggah dokumen-dokumen pendukung Anda (Format: JPG, PNG | Max: 2MB per file)</p>

    <form action="{{ route('registration.store-step3') }}" method="POST" enctype="multipart/form-data" id="step3Form">
        @csrf
        
        <div class="space-y-6">
            <!-- KTP Photo -->
            <div class="p-6 border-2 border-dashed border-gray-300 rounded-2xl hover:border-[#d62828]/50 transition" data-upload-field="ktp_photo">
                <label for="ktp_photo" class="cursor-pointer">
                    <div class="text-center">
                        <div class="mb-3 flex justify-center">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-bold text-[#222222] mb-1">Foto KTP</p>
                        <p class="text-xs text-[#666666]">Klik atau drag & drop untuk mengunggah</p>
                    </div>
                    <input type="file" id="ktp_photo" name="ktp_photo" accept="image/jpeg,image/png" class="hidden" {{ isset($registration['ktp_photo']) ? '' : 'required' }}>
                </label>
                <div class="feedback-container">
                    @if(isset($registration['ktp_photo']))
                        <p class="text-xs text-green-600 font-semibold mt-2">✓ File sudah diunggah</p>
                    @endif
                </div>
                @error('ktp_photo')
                    <p class="text-red-600 text-xs font-semibold mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Family Card Photo -->
            <div class="p-6 border-2 border-dashed border-gray-300 rounded-2xl hover:border-[#d62828]/50 transition" data-upload-field="family_card_photo">
                <label for="family_card_photo" class="cursor-pointer">
                    <div class="text-center">
                        <div class="mb-3 flex justify-center">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-bold text-[#222222] mb-1">Kartu Keluarga</p>
                        <p class="text-xs text-[#666666]">Klik atau drag & drop untuk mengunggah</p>
                    </div>
                    <input type="file" id="family_card_photo" name="family_card_photo" accept="image/jpeg,image/png" class="hidden" {{ isset($registration['family_card_photo']) ? '' : 'required' }}>
                </label>
                <div class="feedback-container">
                    @if(isset($registration['family_card_photo']))
                        <p class="text-xs text-green-600 font-semibold mt-2">✓ File sudah diunggah</p>
                    @endif
                </div>
                @error('family_card_photo')
                    <p class="text-red-600 text-xs font-semibold mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Birth Certificate Photo -->
            <div class="p-6 border-2 border-dashed border-gray-300 rounded-2xl hover:border-[#d62828]/50 transition" data-upload-field="birth_certificate_photo">
                <label for="birth_certificate_photo" class="cursor-pointer">
                    <div class="text-center">
                        <div class="mb-3 flex justify-center">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-bold text-[#222222] mb-1">Akte Kelahiran</p>
                        <p class="text-xs text-[#666666]">Klik atau drag & drop untuk mengunggah</p>
                    </div>
                    <input type="file" id="birth_certificate_photo" name="birth_certificate_photo" accept="image/jpeg,image/png" class="hidden" {{ isset($registration['birth_certificate_photo']) ? '' : 'required' }}>
                </label>
                <div class="feedback-container">
                    @if(isset($registration['birth_certificate_photo']))
                        <p class="text-xs text-green-600 font-semibold mt-2">✓ File sudah diunggah</p>
                    @endif
                </div>
                @error('birth_certificate_photo')
                    <p class="text-red-600 text-xs font-semibold mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Passport Photo -->
            <div class="p-6 border-2 border-dashed border-gray-300 rounded-2xl hover:border-[#d62828]/50 transition" data-upload-field="passport_photo">
                <label for="passport_photo" class="cursor-pointer">
                    <div class="text-center">
                        <div class="mb-3 flex justify-center">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </div>
                        </div>
                        <p class="text-sm font-bold text-[#222222] mb-1">Pas Foto Terbaru</p>
                        <p class="text-xs text-[#666666]">Klik atau drag & drop untuk mengunggah</p>
                        <p class="text-xs text-[#666666] mt-1">(Ukuran 4x6 cm, latar belakang merah)</p>
                    </div>
                    <input type="file" id="passport_photo" name="passport_photo" accept="image/jpeg,image/png" class="hidden" {{ isset($registration['passport_photo']) ? '' : 'required' }}>
                </label>
                <div class="feedback-container">
                    @if(isset($registration['passport_photo']))
                        <p class="text-xs text-green-600 font-semibold mt-2">✓ File sudah diunggah</p>
                    @endif
                </div>
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
    // Drag and drop functionality
    const fileInputs = ['ktp_photo', 'family_card_photo', 'birth_certificate_photo', 'passport_photo'];
    
    fileInputs.forEach(inputId => {
        const input = document.getElementById(inputId);
        const dropZone = input.closest('[data-upload-field]');
        const feedbackContainer = dropZone.querySelector('.feedback-container');
        
        // Handle click to select file
        dropZone.addEventListener('click', (e) => {
            // Only trigger file picker if not clicking on feedback text
            if (!e.target.closest('.feedback-container')) {
                input.click();
            }
        });
        
        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        // Highlight on drag
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight(e) {
            dropZone.classList.add('!border-[#d62828]', '!bg-red-50');
        }
        
        function unhighlight(e) {
            dropZone.classList.remove('!border-[#d62828]', '!bg-red-50');
        }
        
        // Handle drop
        dropZone.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles(files);
        }
        
        // Handle file input change (from click)
        input.addEventListener('change', function() {
            handleFiles(this.files);
        });
        
        function handleFiles(files) {
            // Validate file
            if (files.length > 0) {
                const file = files[0];
                const validTypes = ['image/jpeg', 'image/png'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (!validTypes.includes(file.type)) {
                    alert('Format file harus JPEG atau PNG');
                    return;
                }
                
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar (maksimal 2MB)');
                    return;
                }
                
                // Use DataTransfer to properly set files
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
                
                // Show file name in feedback container (outside clickable label)
                feedbackContainer.innerHTML = '<p class="text-xs text-green-600 font-semibold mt-2">✓ ' + file.name + ' (' + (file.size / 1024).toFixed(1) + 'KB)</p>';
            }
        }
    });
</script>
@endsection
