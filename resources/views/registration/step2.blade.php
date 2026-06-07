@extends('registration.layout')

@section('title', 'Step 2: Pendidikan & Bahasa - Pendaftaran Siswa LPK Seishin')

@section('content')
<div>
    <h2 class="text-xl sm:text-2xl font-bold font-ibm text-[#222222] mb-1">Pendidikan & Bahasa</h2>
    <p class="text-sm text-[#666666] mb-6">Informasi tentang riwayat pendidikan dan kemampuan bahasa Jepang Anda</p>

    <form action="{{ route('registration.store-step2') }}" method="POST" id="step2Form">
        @csrf
        
        <!-- Education Section -->
        <div class="mb-8">
            <h3 class="text-base font-bold font-ibm text-[#222222] mb-4 pb-3 border-b border-gray-200">Riwayat Pendidikan</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <!-- Education Level -->
                <div x-data="{ open: false, selected: '{{ $registration['education_level'] ?? old('education_level') }}' }" class="relative">
                    <label for="education_level" class="block text-sm font-semibold text-[#222222] mb-2">Tingkat Pendidikan Terakhir *</label>
                    <input type="hidden" name="education_level" x-model="selected" required>
                    
                    <button type="button" @click="open = !open" @click.away="open = false" 
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition flex items-center justify-between bg-white hover:bg-gray-50 text-left"
                        :class="{ 'text-gray-900': selected, 'text-gray-400': !selected }">
                        <span x-text="selected ? selected : 'Pilih Tingkat Pendidikan'"></span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="open" x-transition.opacity.duration.200ms
                        class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden" style="display: none;">
                        <div class="p-1">
                            <template x-for="option in ['SMP', 'SMA', 'SMK', 'Kuliah']" :key="option">
                                <button type="button" @click="selected = option; open = false" 
                                    class="w-full px-4 py-2.5 text-left text-sm font-medium rounded-lg transition-colors"
                                    :class="{ 'bg-red-50 text-[#d62828]': selected === option, 'text-gray-700 hover:bg-gray-50 hover:text-gray-900': selected !== option }">
                                    <span x-text="option"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                    @error('education_level')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- School Name -->
                <div>
                    <label for="school_name" class="block text-sm font-semibold text-[#222222] mb-2">Nama Sekolah/Kampus *</label>
                    <input type="text" id="school_name" name="school_name" value="{{ $registration['school_name'] ?? old('school_name') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition" placeholder="Contoh: SMA Negeri 1" required>
                    @error('school_name')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Major -->
                <div>
                    <label for="major" class="block text-sm font-semibold text-[#222222] mb-2">Jurusan *</label>
                    <input type="text" id="major" name="major" value="{{ $registration['major'] ?? old('major') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition" placeholder="Contoh: IPA, IPS, Teknik Informatika" required>
                    @error('major')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Graduation Year -->
                <div>
                    <label for="graduation_year" class="block text-sm font-semibold text-[#222222] mb-2">Tahun Lulus *</label>
                    <input type="number" id="graduation_year" name="graduation_year" value="{{ $registration['graduation_year'] ?? old('graduation_year') }}" min="1950" max="{{ date('Y') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition" placeholder="Contoh: 2023" required>
                    @error('graduation_year')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- GPA -->
                <div>
                    <label for="gpa" class="block text-sm font-semibold text-[#222222] mb-2">IPK / Nilai Akhir <span class="text-[#666666]">(Opsional)</span></label>
                    <input type="number" id="gpa" name="gpa" value="{{ $registration['gpa'] ?? old('gpa') }}" min="0" max="4" step="0.01" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition" placeholder="Contoh: 3.50">
                    @error('gpa')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Organization Experience -->
                <div>
                    <label for="organization_experience" class="block text-sm font-semibold text-[#222222] mb-2">Pengalaman Organisasi <span class="text-[#666666]">(Opsional)</span></label>
                    <input type="text" id="organization_experience" name="organization_experience" value="{{ $registration['organization_experience'] ?? old('organization_experience') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition" placeholder="Contoh: Ketua OSIS, Anggota ROHIS">
                    @error('organization_experience')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Japanese Language Section -->
        <div class="mb-8" x-data="{ japaneseAbility: '{{ $registration['japanese_ability'] ?? old('japanese_ability') ?? '' }}', levelOpen: false, selectedLevel: '{{ $registration['japanese_level'] ?? old('japanese_level') }}' }">
            <h3 class="text-base font-bold font-ibm text-[#222222] mb-4 pb-3 border-b border-gray-200">Kemampuan Bahasa Jepang</h3>
            
            <div class="space-y-6">
                <!-- Japanese Ability Radio -->
                <div>
                    <p class="text-sm font-semibold text-[#222222] mb-3">Apakah Anda bisa bahasa Jepang? *</p>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer transition-colors" :class="{ 'bg-red-50 border-red-200': japaneseAbility === 'yes', 'hover:bg-gray-50': japaneseAbility !== 'yes' }" @click="japaneseAbility = 'yes'">
                            <input type="radio" id="japanese_yes" name="japanese_ability" value="yes" x-model="japaneseAbility" class="w-4 h-4 accent-[#d62828] cursor-pointer">
                            <label for="japanese_yes" class="text-sm text-[#222222] font-semibold cursor-pointer flex-1">Ya, saya bisa bahasa Jepang</label>
                        </div>
                        <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer transition-colors" :class="{ 'bg-red-50 border-red-200': japaneseAbility === 'no', 'hover:bg-gray-50': japaneseAbility !== 'no' }" @click="japaneseAbility = 'no'; selectedLevel = ''">
                            <input type="radio" id="japanese_no" name="japanese_ability" value="no" x-model="japaneseAbility" class="w-4 h-4 accent-[#d62828] cursor-pointer">
                            <label for="japanese_no" class="text-sm text-[#222222] font-semibold cursor-pointer flex-1">Tidak, saya tidak bisa bahasa Jepang</label>
                        </div>
                    </div>
                    @error('japanese_ability')
                        <p class="text-red-600 text-xs font-semibold mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Japanese Level Dropdown -->
                <div x-show="japaneseAbility === 'yes'" x-transition class="relative" style="display: none;">
                    <label for="japanese_level" class="block text-sm font-semibold text-[#222222] mb-2">Level Bahasa / Kemampuan *</label>
                    <input type="hidden" name="japanese_level" x-model="selectedLevel" :required="japaneseAbility === 'yes'">
                    
                    <button type="button" @click="levelOpen = !levelOpen" @click.away="levelOpen = false" 
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition flex items-center justify-between bg-white hover:bg-gray-50 text-left"
                        :class="{ 'text-gray-900': selectedLevel, 'text-gray-400': !selectedLevel }">
                        <span x-text="selectedLevel ? selectedLevel : 'Pilih Level'"></span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': levelOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="levelOpen" x-transition.opacity.duration.200ms
                        class="absolute z-50 w-full mt-2 bg-white border border-gray-100 rounded-xl shadow-lg overflow-hidden" style="display: none;">
                        <div class="p-1">
                            <template x-for="option in ['N5 (Beginner)', 'N4 (Elementary)', 'N3 (Intermediate)', 'N2 (Advanced)', 'N1 (Proficiency)']" :key="option">
                                <button type="button" @click="selectedLevel = option.split(' ')[0]; levelOpen = false" 
                                    class="w-full px-4 py-2.5 text-left text-sm font-medium rounded-lg transition-colors"
                                    :class="{ 'bg-red-50 text-[#d62828]': selectedLevel === option.split(' ')[0], 'text-gray-700 hover:bg-gray-50 hover:text-gray-900': selectedLevel !== option.split(' ')[0] }">
                                    <span x-text="option"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                    @error('japanese_level')
                        <p class="text-red-600 text-xs font-semibold mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex gap-4 mt-8">
            <a href="{{ route('registration.step1') }}" class="flex-1 px-6 py-3 border-2 border-gray-300 text-[#222222] font-bold rounded-xl hover:bg-gray-50 transition text-center">
                Kembali
            </a>
            <button type="submit" class="flex-1 px-6 py-3 bg-[#d62828] text-white font-bold rounded-xl hover:bg-red-700 transition">
                Lanjut ke Tahap Berikutnya
            </button>
        </div>
    </form>
</div>


@endsection
