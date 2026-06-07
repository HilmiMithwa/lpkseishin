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
                <div>
                    <label for="education_level" class="block text-sm font-semibold text-[#222222] mb-2">Tingkat Pendidikan Terakhir *</label>
                    <select id="education_level" name="education_level" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition" required>
                        <option value="">Pilih Tingkat Pendidikan</option>
                        <option value="SMP" {{ ($registration['education_level'] ?? old('education_level')) == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA" {{ ($registration['education_level'] ?? old('education_level')) == 'SMA' ? 'selected' : '' }}>SMA</option>
                        <option value="SMK" {{ ($registration['education_level'] ?? old('education_level')) == 'SMK' ? 'selected' : '' }}>SMK</option>
                        <option value="Kuliah" {{ ($registration['education_level'] ?? old('education_level')) == 'Kuliah' ? 'selected' : '' }}>Kuliah</option>
                    </select>
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
        <div class="mb-8">
            <h3 class="text-base font-bold font-ibm text-[#222222] mb-4 pb-3 border-b border-gray-200">Kemampuan Bahasa Jepang</h3>
            
            <div class="space-y-6">
                <!-- Japanese Ability Radio -->
                <div>
                    <p class="text-sm font-semibold text-[#222222] mb-3">Apakah Anda bisa bahasa Jepang? *</p>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50" onclick="selectJapanesability(this)">
                            <input type="radio" id="japanese_yes" name="japanese_ability" value="yes" {{ ($registration['japanese_ability'] ?? old('japanese_ability')) == 'yes' ? 'checked' : '' }} class="w-4 h-4 accent-[#d62828] cursor-pointer" onchange="toggleJapaneseLevel()">
                            <label for="japanese_yes" class="text-sm text-[#222222] font-semibold cursor-pointer flex-1">Ya, saya bisa bahasa Jepang</label>
                        </div>
                        <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50" onclick="selectJapanesability(this)">
                            <input type="radio" id="japanese_no" name="japanese_ability" value="no" {{ ($registration['japanese_ability'] ?? old('japanese_ability')) == 'no' ? 'checked' : '' }} class="w-4 h-4 accent-[#d62828] cursor-pointer" onchange="toggleJapaneseLevel()">
                            <label for="japanese_no" class="text-sm text-[#222222] font-semibold cursor-pointer flex-1">Tidak, saya tidak bisa bahasa Jepang</label>
                        </div>
                    </div>
                    @error('japanese_ability')
                        <p class="text-red-600 text-xs font-semibold mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Japanese Level Dropdown (hidden by default) -->
                <div id="japaneseLevel" class="hidden">
                    <label for="japanese_level" class="block text-sm font-semibold text-[#222222] mb-2">Level Bahasa / Kemampuan *</label>
                    <select id="japanese_level" name="japanese_level" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition">
                        <option value="">Pilih Level</option>
                        <option value="N5" {{ ($registration['japanese_level'] ?? old('japanese_level')) == 'N5' ? 'selected' : '' }}>N5 (Beginner)</option>
                        <option value="N4" {{ ($registration['japanese_level'] ?? old('japanese_level')) == 'N4' ? 'selected' : '' }}>N4 (Elementary)</option>
                        <option value="N3" {{ ($registration['japanese_level'] ?? old('japanese_level')) == 'N3' ? 'selected' : '' }}>N3 (Intermediate)</option>
                        <option value="N2" {{ ($registration['japanese_level'] ?? old('japanese_level')) == 'N2' ? 'selected' : '' }}>N2 (Advanced)</option>
                        <option value="N1" {{ ($registration['japanese_level'] ?? old('japanese_level')) == 'N1' ? 'selected' : '' }}>N1 (Proficiency)</option>
                    </select>
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

<script>
    function selectJapanesability(element) {
        const radio = element.querySelector('input[type="radio"]');
        radio.checked = true;
        toggleJapaneseLevel();
    }

    function toggleJapaneseLevel() {
        const japaneseLevel = document.getElementById('japaneseLevel');
        const japaneseYes = document.getElementById('japanese_yes').checked;
        
        if (japaneseYes) {
            japaneseLevel.classList.remove('hidden');
            document.getElementById('japanese_level').required = true;
        } else {
            japaneseLevel.classList.add('hidden');
            document.getElementById('japanese_level').required = false;
            document.getElementById('japanese_level').value = '';
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', toggleJapaneseLevel);
</script>
@endsection
