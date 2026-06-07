@extends('registration.layout')

@section('title', 'Step 1: Data Pribadi - Pendaftaran Siswa LPK Seishin')

@section('content')
<div>
    <h2 class="text-xl sm:text-2xl font-bold font-ibm text-[#222222] mb-1">Data Pribadi</h2>
    <p class="text-sm text-[#666666] mb-6">Isi informasi pribadi Anda dengan lengkap dan benar</p>

    <form action="{{ route('registration.store-step1') }}" method="POST">
        @csrf
        
        <!-- Personal Data Section -->
        <div class="mb-8">
            <h3 class="text-base font-bold font-ibm text-[#222222] mb-4 pb-3 border-b border-gray-200">Data Diri</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Nama Lengkap -->
                <div class="sm:col-span-2">
                    <label for="full_name" class="block text-sm font-semibold text-[#222222] mb-2">Nama Lengkap *</label>
                    <input type="text" id="full_name" name="full_name" value="{{ $registration['full_name'] ?? old('full_name') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition" placeholder="Contoh: Budi Santoso" required>
                    @error('full_name')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No WhatsApp -->
                <div>
                    <label for="whatsapp_number" class="block text-sm font-semibold text-[#222222] mb-2">No. WhatsApp *</label>
                    <input type="tel" id="whatsapp_number" name="whatsapp_number" value="{{ $registration['whatsapp_number'] ?? old('whatsapp_number') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition" placeholder="+62 atau 0..." required>
                    @error('whatsapp_number')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div x-data="{ open: false, selected: '{{ $registration['gender'] ?? old('gender') }}' }" class="relative">
                    <label for="gender" class="block text-sm font-semibold text-[#222222] mb-2">Jenis Kelamin *</label>
                    <input type="hidden" name="gender" x-model="selected" required>
                    
                    <button type="button" @click="open = !open" @click.away="open = false" 
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition flex items-center justify-between bg-white hover:bg-gray-50 text-left"
                        :class="{ 'text-gray-900': selected, 'text-gray-400': !selected }">
                        <span x-text="selected ? selected : 'Pilih Jenis Kelamin'"></span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" x-transition.opacity.duration.200ms
                        class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden" style="display: none;">
                        <div class="p-1">
                            <button type="button" @click="selected = 'Laki-laki'; open = false" 
                                class="w-full px-4 py-2.5 text-left text-sm font-medium rounded-lg transition-colors"
                                :class="{ 'bg-red-50 text-[#d62828]': selected === 'Laki-laki', 'text-gray-700 hover:bg-gray-50 hover:text-gray-900': selected !== 'Laki-laki' }">
                                Laki-laki
                            </button>
                            <button type="button" @click="selected = 'Perempuan'; open = false" 
                                class="w-full px-4 py-2.5 text-left text-sm font-medium rounded-lg transition-colors"
                                :class="{ 'bg-red-50 text-[#d62828]': selected === 'Perempuan', 'text-gray-700 hover:bg-gray-50 hover:text-gray-900': selected !== 'Perempuan' }">
                                Perempuan
                            </button>
                        </div>
                    </div>
                    @error('gender')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No KTP -->
                <div>
                    <label for="ktp_number" class="block text-sm font-semibold text-[#222222] mb-2">Nomor KTP (16 digit) *</label>
                    <input type="text" id="ktp_number" name="ktp_number" value="{{ $registration['ktp_number'] ?? old('ktp_number') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition" placeholder="Contoh: 3201234567890123" maxlength="16" required>
                    @error('ktp_number')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label for="birth_place" class="block text-sm font-semibold text-[#222222] mb-2">Tempat Lahir *</label>
                    <input type="text" id="birth_place" name="birth_place" value="{{ $registration['birth_place'] ?? old('birth_place') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition" placeholder="Contoh: Jakarta" required>
                    @error('birth_place')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div x-data="{ init() { flatpickr(this.$refs.dateInput, { locale: 'id', dateFormat: 'Y-m-d', maxDate: 'today', altInput: true, altFormat: 'd F Y', allowInput: true }); } }">
                    <label for="birth_date" class="block text-sm font-semibold text-[#222222] mb-2">Tanggal Lahir *</label>
                    <div class="relative">
                        <input type="text" x-ref="dateInput" id="birth_date" name="birth_date" value="{{ $registration['birth_date'] ?? old('birth_date') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition bg-white" placeholder="Pilih Tanggal Lahir" required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6"></path></svg>
                        </div>
                    </div>
                    @error('birth_date')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Lengkap -->
                <div class="sm:col-span-2">
                    <label for="full_address" class="block text-sm font-semibold text-[#222222] mb-2">Alamat Lengkap *</label>
                    <textarea id="full_address" name="full_address" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition resize-none" placeholder="Jalan, Nomor, Kelurahan, Kecamatan, Kota, Provinsi, Kode Pos" required>{{ $registration['full_address'] ?? old('full_address') }}</textarea>
                    @error('full_address')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Emergency Contact Section -->
        <div class="mb-8">
            <h3 class="text-base font-bold font-ibm text-[#222222] mb-4 pb-3 border-b border-gray-200">Kontak Darurat</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Nama Kontak -->
                <div>
                    <label for="contact_name" class="block text-sm font-semibold text-[#222222] mb-2">Nama Kontak *</label>
                    <input type="text" id="contact_name" name="contact_name" value="{{ $registration['contact_name'] ?? old('contact_name') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition" placeholder="Contoh: Ibu Siti" required>
                    @error('contact_name')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hubungan Kontak -->
                <div>
                    <label for="contact_relationship" class="block text-sm font-semibold text-[#222222] mb-2">Hubungan *</label>
                    <input type="text" id="contact_relationship" name="contact_relationship" value="{{ $registration['contact_relationship'] ?? old('contact_relationship') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition" placeholder="Contoh: Ibu, Ayah, Kakak" required>
                    @error('contact_relationship')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No WhatsApp Kontak -->
                <div class="sm:col-span-2">
                    <label for="contact_whatsapp" class="block text-sm font-semibold text-[#222222] mb-2">No. WhatsApp Kontak *</label>
                    <input type="tel" id="contact_whatsapp" name="contact_whatsapp" value="{{ $registration['contact_whatsapp'] ?? old('contact_whatsapp') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition" placeholder="+62 atau 0..." required>
                    @error('contact_whatsapp')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Requirements Section -->
        <div class="mb-8">
            <h3 class="text-base font-bold font-ibm text-[#222222] mb-4 pb-3 border-b border-gray-200">Persyaratan</h3>
            
            <div class="space-y-4">
                <!-- Requirement 1 -->
                <div class="flex items-start gap-3 p-4 bg-red-50/50 rounded-xl border border-red-100/50">
                    <input type="checkbox" id="requirement_one" name="requirement_one" value="1" {{ ($registration['requirement_one'] ?? old('requirement_one')) ? 'checked' : '' }} class="mt-1 w-5 h-5 accent-[#d62828] cursor-pointer rounded" required>
                    <label for="requirement_one" class="text-sm text-[#222222] cursor-pointer flex-1">
                        Saya menyatakan semua data yang saya isi adalah benar dan dapat dipertanggungjawabkan.
                    </label>
                </div>
                @error('requirement_one')
                    <p class="text-red-600 text-xs font-semibold">{{ $message }}</p>
                @enderror

                <!-- Requirement 2 -->
                <div class="flex items-start gap-3 p-4 bg-red-50/50 rounded-xl border border-red-100/50">
                    <input type="checkbox" id="requirement_two" name="requirement_two" value="1" {{ ($registration['requirement_two'] ?? old('requirement_two')) ? 'checked' : '' }} class="mt-1 w-5 h-5 accent-[#d62828] cursor-pointer rounded" required>
                    <label for="requirement_two" class="text-sm text-[#222222] cursor-pointer flex-1">
                        Saya bersedia mengikuti seluruh tahapan seleksi dan aturan program yang berlaku.
                    </label>
                </div>
                @error('requirement_two')
                    <p class="text-red-600 text-xs font-semibold">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex gap-4 mt-8">
            <a href="/" class="flex-1 px-6 py-3 border-2 border-gray-300 text-[#222222] font-bold rounded-xl hover:bg-gray-50 transition text-center">
                Batalkan
            </a>
            <button type="submit" class="flex-1 px-6 py-3 bg-[#d62828] text-white font-bold rounded-xl hover:bg-red-700 transition">
                Lanjut ke Tahap Berikutnya
            </button>
        </div>
    </form>
</div>
@endsection
