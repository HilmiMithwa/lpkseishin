@extends('layouts.student')

@section('title', 'Detail Pendaftar - Admin LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10">
    
    <!-- Back Button & Status -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.registrations.index') }}" class="inline-flex items-center gap-2 text-[#d62828] hover:text-red-700 font-bold mb-2 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
            <h1 class="text-2xl sm:text-3xl font-bold font-ibm text-[#222222]">{{ $registration->full_name }}</h1>
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
                    @foreach(['ktp_photo' => 'Foto KTP', 'family_card_photo' => 'Kartu Keluarga', 'birth_certificate_photo' => 'Akte Kelahiran', 'passport_photo' => 'Pas Foto'] as $key => $label)
                        <div>
                            <p class="text-xs font-bold text-[#666666] uppercase mb-2">{{ $label }}</p>
                            @if($registration->$key)
                                <a href="{{ Storage::url($registration->$key) }}" target="_blank" class="inline-block">
                                    <img src="{{ Storage::url($registration->$key) }}" alt="{{ $label }}" class="h-40 w-full object-cover rounded-lg border border-gray-200 hover:border-[#d62828] transition cursor-pointer">
                                </a>
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
            <!-- Action Card -->
            @if($registration->status === 'pending' || $registration->status === 'verified')
                <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)] sticky top-6">
                    <h3 class="text-lg font-bold font-ibm text-[#222222] mb-4">Verifikasi Pendaftar</h3>

                    <!-- Approve Form -->
                    <form action="{{ route('admin.registrations.approve', $registration->id) }}" method="POST" id="approveForm" class="space-y-4 mb-6 pb-6 border-b border-gray-200">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-bold text-[#222222] mb-2">Pilih Batch/Kelas *</label>
                            <select name="id_batch" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition text-sm" required>
                                <option value="">-- Pilih Batch --</option>
                                @foreach($batches as $batch)
                                    <option value="{{ $batch->id_batch }}">
                                        {{ $batch->nama }} ({{ $batch->tingkat ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-[#222222] mb-2">Catatan (Opsional)</label>
                            <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition text-sm resize-none" placeholder="Tambahkan catatan..."></textarea>
                        </div>

                        <button type="submit" class="w-full px-4 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
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

                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menolak pendaftar ini?')" class="w-full px-4 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 mt-6">
                <h4 class="text-sm font-bold text-blue-900 mb-3">Informasi Tambahan</h4>
                <div class="space-y-2 text-xs text-blue-800">
                    <p><span class="font-bold">ID Pendaftar:</span> #{{ $registration->id }}</p>
                    <p><span class="font-bold">Tgl Daftar:</span> {{ $registration->created_at->format('d/m/Y H:i') }}</p>
                    <p><span class="font-bold">Tahap:</span> {{ $registration->current_step }}/4</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Show success message if approve was successful
    @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            const userData = {!! json_encode(session('user_data', [])) !!};
            if (userData.username) {
                alert('Akun berhasil dibuat!\n\nUsername: ' + userData.username + '\nEmail: ' + userData.email + '\nPassword: ' + userData.password + '\n\n⚠️ Pastikan informasi ini dicatat untuk diberikan ke pendaftar!');
            }
        });
    @endif
</script>
@endsection
