@extends('layouts.admin')

@section('title', 'Detail Pendaftar - Admin LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10" x-data="{ previewOpen: false, previewUrl: '', previewTitle: '', previewIsPdf: false, zoomLevel: 1 }">
    
    <!-- Back Button & Status -->
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.registrations.index') }}" class="w-11 h-11 flex items-center justify-center bg-white border border-gray-200 rounded-full hover:bg-gray-50 transition-colors text-slate-500 hover:text-slate-700 shadow-sm" title="Kembali">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-2xl sm:text-[28px] lg:text-[32px] font-bold font-ibm text-[#0f172a] tracking-tight">{{ $registration->full_name }}</h1>
        </div>
        <div>
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold
                @switch($registration->status)
                    @case('pending') bg-yellow-100 text-yellow-800 @break
                    @case('verified') bg-blue-100 text-blue-800 @break
                    @case('accepted') bg-green-100 text-green-800 @break
                    @case('rejected') bg-red-100 text-red-800 @break
                @endswitch
            ">
                @switch($registration->status)
                    @case('pending') Menunggu Verifikasi @break
                    @case('verified') Terverifikasi @break
                    @case('accepted') Diterima & Akun Dibuat @break
                    @case('rejected') Ditolak @break
                @endswitch
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Data Pribadi -->
            <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)]">
                <h2 class="text-lg font-bold font-ibm text-[#222222] mb-4 pb-3 border-b border-gray-200">Data Pribadi</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Nama Lengkap</p>
                        <p class="text-sm font-semibold text-[#222222]">{{ $registration->full_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Jenis Kelamin</p>
                        <p class="text-sm font-semibold text-[#222222]">{{ $registration->gender }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Nomor KTP</p>
                        <p class="text-sm font-semibold text-[#222222]">{{ $registration->ktp_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Nomor WhatsApp</p>
                        <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $registration->whatsapp_number) }}" target="_blank" class="text-sm font-semibold text-[#d62828] hover:underline">
                            {{ $registration->whatsapp_number }}
                        </a>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Tempat Lahir</p>
                        <p class="text-sm font-semibold text-[#222222]">{{ $registration->birth_place }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Tanggal Lahir</p>
                        <p class="text-sm font-semibold text-[#222222]">{{ $registration->birth_date->format('d/m/Y') }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Alamat Lengkap</p>
                        <p class="text-sm font-semibold text-[#222222]">{{ $registration->full_address }}</p>
                    </div>
                </div>
            </div>

            <!-- Kontak Darurat -->
            <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)]">
                <h2 class="text-lg font-bold font-ibm text-[#222222] mb-4 pb-3 border-b border-gray-200">Kontak Darurat</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Nama Kontak</p>
                        <p class="text-sm font-semibold text-[#222222]">{{ $registration->contact_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Hubungan</p>
                        <p class="text-sm font-semibold text-[#222222]">{{ $registration->contact_relationship }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Nomor WhatsApp Kontak</p>
                        <a href="https://wa.me/{{ str_replace(['+', '-', ' '], '', $registration->contact_whatsapp) }}" target="_blank" class="text-sm font-semibold text-[#d62828] hover:underline">
                            {{ $registration->contact_whatsapp }}
                        </a>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pendidikan -->
            <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)]">
                <h2 class="text-lg font-bold font-ibm text-[#222222] mb-4 pb-3 border-b border-gray-200">Riwayat Pendidikan</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Tingkat Pendidikan</p>
                        <p class="text-sm font-semibold text-[#222222]">{{ ucfirst($registration->education_level) }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Nama Sekolah/Kampus</p>
                        <p class="text-sm font-semibold text-[#222222]">{{ $registration->school_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Jurusan</p>
                        <p class="text-sm font-semibold text-[#222222]">{{ $registration->major }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Tahun Lulus</p>
                        <p class="text-sm font-semibold text-[#222222]">{{ $registration->graduation_year }}</p>
                    </div>
                    @if($registration->gpa)
                        <div>
                            <p class="text-xs font-bold text-[#666666] uppercase mb-1">IPK / Nilai Akhir</p>
                            <p class="text-sm font-semibold text-[#222222]">{{ $registration->gpa }}</p>
                        </div>
                    @endif
                    @if($registration->organization_experience)
                        <div>
                            <p class="text-xs font-bold text-[#666666] uppercase mb-1">Pengalaman Organisasi</p>
                            <p class="text-sm font-semibold text-[#222222]">{{ $registration->organization_experience }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Kemampuan Bahasa Jepang -->
            <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)]">
                <h2 class="text-lg font-bold font-ibm text-[#222222] mb-4 pb-3 border-b border-gray-200">Kemampuan Bahasa Jepang</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-bold text-[#666666] uppercase mb-1">Kemampuan</p>
                        <p class="text-sm font-semibold text-[#222222]">{{ $registration->japanese_ability === 'yes' ? 'Ya, Bisa' : 'Tidak' }}</p>
                    </div>
                    @if($registration->japanese_ability === 'yes')
                        <div>
                            <p class="text-xs font-bold text-[#666666] uppercase mb-1">Level</p>
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-sm font-bold rounded-full">
                                {{ $registration->japanese_level }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Dokumen Pendukung -->
            <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)]">
                <h2 class="text-lg font-bold font-ibm text-[#222222] mb-4 pb-3 border-b border-gray-200">Dokumen Pendukung</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach(['ktp_photo' => 'Foto KTP', 'family_card_photo' => 'Kartu Keluarga', 'birth_certificate_photo' => 'Akte Kelahiran', 'passport_photo' => 'Pas Foto', 'payment_proof' => 'Bukti Transfer'] as $key => $label)
                        <div>
                            <p class="text-xs font-bold text-[#666666] uppercase mb-2">{{ $label }}</p>
                            @if($registration->$key)
                                @php
                                    $path = $registration->$key;
                                    $url = Str::startsWith($path, ['http://', 'https://']) ? $path : (Storage::disk('public')->exists($path) ? Storage::url($path) : Storage::disk('s3')->url($path));
                                    $isPdf = Str::endsWith(strtolower($path), '.pdf');
                                @endphp
                                <button type="button" @click="previewUrl = '{{ $url }}'; previewTitle = '{{ $label }}'; previewIsPdf = {{ $isPdf ? 'true' : 'false' }}; zoomLevel = 1; previewOpen = true" class="inline-block w-full text-left focus:outline-none group">
                                    @if($isPdf)
                                        <div class="h-40 w-full bg-red-50 text-[#d62828] rounded-xl border border-gray-200 group-hover:border-[#d62828] transition shadow-sm flex flex-col items-center justify-center">
                                            <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                            <span class="text-sm font-bold font-ibm">Lihat Dokumen</span>
                                        </div>
                                    @else
                                        <img src="{{ $url }}" alt="{{ $label }}" class="h-40 w-full object-cover rounded-xl border border-gray-200 group-hover:border-[#d62828] transition shadow-sm">
                                    @endif
                                </button>
                            @else
                                <div class="h-40 bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 flex items-center justify-center">
                                    <p class="text-sm text-[#666666]">Tidak ada file</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                <!-- Action Card -->
                @if($registration->status === 'pending' || $registration->status === 'verified')
                    <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)]">
                    <h3 class="text-lg font-bold font-ibm text-[#222222] mb-4">Verifikasi Pendaftar</h3>

                    <!-- Approve Form -->
                    <form action="{{ route('admin.registrations.approve', $registration->id) }}" method="POST" id="approveForm" class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-bold text-[#222222] mb-2">Pilih Batch/Kelas *</label>
                            <div class="relative" x-data="{ 
                                open: false, 
                                selectedValue: '',
                                selectedName: '-- Pilih Batch --',
                                batches: [
                                    @foreach($batches as $batch)
                                        @php
                                            $studentsCount = \Illuminate\Support\Facades\DB::table('student_list_batch')
                                                ->where('id_batch', $batch->id_batch)
                                                ->where('status', 'Active')
                                                ->count();
                                            $isFull = $studentsCount >= $batch->quota;
                                            $sisaSlot = max(0, $batch->quota - $studentsCount);
                                        @endphp
                                        { id: '{{ $batch->id_batch }}', name: '{{ addslashes($batch->nama) }} (Sisa slot: {{ $sisaSlot }})', isFull: {{ $isFull ? 'true' : 'false' }} }{{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                ]
                            }" @click.outside="open = false">
                                <select name="id_batch" class="opacity-0 absolute inset-0 w-full h-full cursor-pointer z-[-1]" x-model="selectedValue" required>
                                    <option value="">-- Pilih Batch --</option>
                                    @foreach($batches as $batch)
                                        @php
                                            $studentsCountOpt = \Illuminate\Support\Facades\DB::table('student_list_batch')
                                                ->where('id_batch', $batch->id_batch)
                                                ->where('status', 'Active')
                                                ->count();
                                            $sisaSlotOpt = max(0, $batch->quota - $studentsCountOpt);
                                        @endphp
                                        <option value="{{ $batch->id_batch }}">{{ $batch->nama }} (Sisa slot: {{ $sisaSlotOpt }})</option>
                                    @endforeach
                                </select>
                                
                                <button type="button" @click="open = !open" 
                                    class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl flex justify-between items-center focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition shadow-sm text-sm"
                                    :class="open ? 'border-[#d62828] ring-2 ring-[#d62828]/20' : ''">
                                    <span x-text="selectedName" :class="selectedValue ? 'text-[#222222] font-semibold' : 'text-gray-500'"></span>
                                    <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </button>
                                
                                <div x-show="open" x-transition.opacity.duration.200ms class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-lg py-2 overflow-hidden" style="display: none;">
                                    <button type="button" @click="selectedValue = ''; selectedName = '-- Pilih Batch --'; open = false" 
                                        class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors" 
                                        :class="selectedValue === '' ? 'text-[#d62828] font-bold bg-red-50/50' : 'text-[#666666]'">
                                        -- Pilih Batch --
                                    </button>
                                    <template x-for="batch in batches" :key="batch.id">
                                        <button type="button" @click="if(!batch.isFull) { selectedValue = batch.id; selectedName = batch.name; open = false }" 
                                            class="w-full text-left px-4 py-2.5 text-sm transition-colors flex justify-between" 
                                            :class="batch.isFull ? 'opacity-50 cursor-not-allowed bg-gray-50 text-gray-500' : (selectedValue === batch.id ? 'text-[#d62828] font-bold bg-red-50/50' : 'text-[#222222] hover:bg-gray-50')"
                                            :disabled="batch.isFull">
                                            <span x-text="batch.name"></span>
                                            <span x-show="batch.isFull" class="text-xs text-red-500 font-semibold">(Penuh)</span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-[#222222] mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition text-sm resize-none" placeholder="Tambahkan catatan..."></textarea>
                        </div>

                        <button type="submit" class="w-full px-5 py-3 bg-[#2b9348] hover:bg-green-700 text-white text-sm font-bold rounded-xl transition duration-200 shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Terima & Buat Akun
                        </button>
                    </form>

                    <!-- Reject Form -->
                    <form action="{{ route('admin.registrations.reject', $registration->id) }}" method="POST" id="rejectForm" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-sm font-bold text-[#222222] mb-2">Alasan Penolakan *</label>
                            <textarea name="rejection_reason" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition text-sm resize-none" placeholder="Jelaskan alasan penolakan..." required></textarea>
                        </div>

                        <button type="button" onclick="confirmReject()" class="w-full px-5 py-3 bg-white text-[#d62828] border border-red-200 hover:bg-red-50 text-sm font-bold rounded-xl transition duration-200 shadow-sm flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Tolak Pendaftar
                        </button>
                    </form>
                </div>
            @else
                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)]">
                    <div class="text-center">
                        @if($registration->status === 'accepted')
                            <div class="mb-4 flex justify-center">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm font-bold text-[#222222]">Pendaftar Diterima</p>
                            <p class="text-xs text-[#666666] mt-2">Akun sudah berhasil dibuat untuk pendaftar ini</p>
                        @else
                            <div class="mb-4 flex justify-center">
                                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm font-bold text-[#222222]">Pendaftar Ditolak</p>
                            <p class="text-xs text-[#666666] mt-2">Tidak dapat mengubah status</p>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Info Card -->
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4">
                <h4 class="text-sm font-bold text-blue-900 mb-3">Informasi Tambahan</h4>
                <div class="space-y-2 text-xs text-blue-800">
                    <p><span class="font-bold">ID Pendaftar:</span> #{{ $registration->id }}</p>
                    <p><span class="font-bold">Tgl Daftar:</span> {{ $registration->created_at->format('d/m/Y H:i') }}</p>
                    <p><span class="font-bold">Tahap:</span> {{ $registration->current_step }}/4</p>
                </div>
            </div>

            <!-- I -->
            </div>
        </div>
    </div>

    <!-- Alpine Lightbox Modal -->
    <template x-teleport="body">
        <div x-show="previewOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6">
            <!-- Backdrop -->
            <div x-show="previewOpen" x-transition.opacity.duration.300ms class="absolute inset-0 bg-gray-900/80 backdrop-blur-sm" @click="previewOpen = false"></div>
            
            <!-- Modal Content -->
            <div x-show="previewOpen" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="relative z-10 flex flex-col bg-white rounded-2xl shadow-2xl overflow-hidden" style="width: 800px; max-width: 95vw; height: 85vh; max-height: 95vh;">
                
                <!-- Header -->
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
                    <h3 class="text-xl font-bold font-ibm text-[#222222]" x-text="previewTitle"></h3>
                    <div class="flex items-center gap-2">
                        <template x-if="!previewIsPdf">
                            <div class="flex items-center bg-gray-100 rounded-lg p-1 mr-2">
                                <button @click="zoomLevel = Math.max(0.5, zoomLevel - 0.25)" class="p-1.5 text-gray-500 hover:text-[#d62828] hover:bg-white rounded shadow-sm transition-colors" title="Zoom Out">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path></svg>
                                </button>
                                <span class="text-xs font-bold text-gray-600 min-w-[3rem] text-center" x-text="Math.round(zoomLevel * 100) + '%'"></span>
                                <button @click="zoomLevel = Math.min(4, zoomLevel + 0.25)" class="p-1.5 text-gray-500 hover:text-[#d62828] hover:bg-white rounded shadow-sm transition-colors" title="Zoom In">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                </button>
                            </div>
                        </template>
                        <button @click="previewOpen = false" class="p-2 text-gray-400 hover:text-[#d62828] hover:bg-red-50 rounded-full transition-colors focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
                
                <!-- Body -->
                <div class="p-4 sm:p-6 bg-[#f8f9fa] flex-1 overflow-auto flex items-start justify-center">
                    <template x-if="previewIsPdf">
                        <iframe :src="previewUrl" class="w-full h-full rounded-xl border border-gray-200 shadow-sm bg-white"></iframe>
                    </template>
                    <template x-if="!previewIsPdf">
                        <img :src="previewUrl" :alt="previewTitle" class="h-auto object-contain rounded-xl shadow-sm border border-gray-200 bg-white" :style="`width: ${zoomLevel * 100}%; max-width: none; transition: width 0.2s ease-out;`">
                    </template>
                </div>
            </div>
        </div>
    </template>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmReject() {
        const form = document.getElementById('rejectForm');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        Swal.fire({
            title: 'Tolak Pendaftar?',
            text: "Apakah Anda yakin ingin menolak pendaftar ini? Tindakan ini tidak dapat dibatalkan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d62828',
            cancelButtonColor: '#666666',
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'font-bold rounded-xl px-5 py-2.5',
                cancelButton: 'font-bold rounded-xl px-5 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    // Show success message if approve was successful
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            const userData = {!! json_encode(session('user_data', [])) !!};
            if (userData.username) {
                Swal.fire({
                    title: 'Akun Berhasil Dibuat!',
                    html: `
                        <div class="text-left bg-gray-50 p-4 rounded-lg mt-3 mb-4 border border-gray-200">
                            <p class="mb-3 flex flex-col sm:flex-row sm:items-center"><span class="font-bold text-[#222222] sm:w-28 mb-1 sm:mb-0 block">Username:</span> <span class="text-[#d62828] font-mono bg-red-50 px-2 py-1 rounded w-full sm:w-auto">${userData.username}</span></p>
                            <p class="mb-3 flex flex-col sm:flex-row sm:items-center"><span class="font-bold text-[#222222] sm:w-28 mb-1 sm:mb-0 block">Email:</span> <span class="text-blue-700 font-mono bg-blue-50 px-2 py-1 rounded w-full sm:w-auto">${userData.email}</span></p>
                            <p class="flex flex-col sm:flex-row sm:items-center"><span class="font-bold text-[#222222] sm:w-28 mb-1 sm:mb-0 block">Password:</span> <span class="text-gray-800 font-mono font-bold bg-white border px-2 py-1 rounded shadow-sm w-full sm:w-auto">${userData.password}</span></p>
                        </div>
                        <div class="flex items-start gap-2 text-sm text-amber-700 bg-amber-50 p-3 rounded-lg border border-amber-200">
                            <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <p class="text-left font-medium">Pastikan informasi ini dicatat atau disalin untuk diberikan ke pendaftar!</p>
                        </div>
                    `,
                    icon: 'success',
                    confirmButtonText: 'Tutup & Salin Info',
                    confirmButtonColor: '#2b9348',
                    showCancelButton: true,
                    cancelButtonText: 'Tutup Saja',
                    cancelButtonColor: '#666666',
                    allowOutsideClick: false,
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'font-bold rounded-xl px-5 py-2.5',
                        cancelButton: 'font-bold rounded-xl px-5 py-2.5'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const info = `Username: ${userData.username}\nEmail: ${userData.email}\nPassword: ${userData.password}`;
                        navigator.clipboard.writeText(info).then(() => {
                            Swal.fire({
                                title: 'Berhasil Disalin!',
                                text: 'Informasi login telah disalin ke clipboard.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false,
                                customClass: {
                                    popup: 'rounded-2xl'
                                }
                            });
                        });
                    }
                });
            }
        });
    @endif
</script>
@endsection
