@extends('layouts.teacher')

@section('title', 'Database Kosakata - LPK Seishin')

@php
    $dailyKanji = $dailyWord->kanji ?? 'Kosong';
    $dailyRomaji = $dailyWord->romaji ?? '-';
    $dailyMeaningEn = $dailyWord->meaning_en ?? '-';
    $dailyMeaningId = $dailyWord->meaning_id ?? '-';
    $dailyFurigana = $dailyWord->furigana ?? '-';
@endphp

@push('styles')
<style>
    .banner-red {
        background: linear-gradient(90deg, #d62828 0%, #d62828 50%, #8b1a1a 100%);
        position: relative;
        overflow: hidden;
    }
    .banner-red::before {
        content: '';
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        width: 65%;
        height: 160%;
        background-image: url("{{ asset('img/japanMap.svg') }}");
        background-repeat: no-repeat;
        background-size: cover;
        background-position: left center;
        opacity: 0.75;
        z-index: 0;
        pointer-events: none;
    }
</style>
@endpush

@section('content')
<div class="p-4 sm:p-6 lg:p-10 space-y-8" x-data>
    
    <div class="text-left mb-4">
        <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Database Kosakata</h1>
        <p class="text-sm text-[#666666] font-medium mt-2">Kelola bank kosakata bahasa Jepang</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Banner Word of The Day --}}
        <div class="lg:col-span-2 banner-red rounded-[32px] p-6 lg:px-10 lg:py-8 text-white flex justify-between items-center relative shadow-sm h-auto lg:h-[240px]">
            
            <div class="z-10 flex flex-col h-full justify-between items-start text-left">
                <div class="mb-6">
                    <span class="text-[15px] font-bold tracking-wide text-white/90 select-none">
                        Kata Hari Ini
                    </span>
                </div>
                <div class="text-left mt-auto">
                    <p class="text-sm font-bold text-white/80 italic tracking-wider mb-1">{{ $dailyFurigana }}</p>
                    <h2 class="text-5xl lg:text-6xl font-bold tracking-tight text-white leading-none">
                        {{ $dailyKanji }}
                    </h2>
                    <p class="text-[15px] font-bold text-white/90 tracking-wide mt-2">
                        {{ $dailyRomaji }}
                    </p>
                </div>
            </div>
            
            <div class="z-10 flex-shrink-0 mr-4 lg:mr-12">
                <div class="bg-white rounded-[20px] py-4 px-8 text-center text-gray-800 shadow-sm flex flex-col justify-center items-center min-w-[160px] border border-gray-50 select-none">
                    <p class="text-[10px] font-bold text-[#666666] capitalize mb-1">Terjemahan</p>
                    <h3 class="text-[13px] font-bold text-[#222222] leading-snug tracking-tight">
                        {{ $dailyMeaningEn }}
                    </h3>
                    <p class="text-[11px] font-bold text-[#666666] mt-0.5">
                        {{ $dailyMeaningId }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Total Word Card --}}
        <div class="lg:col-span-1 bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm relative h-[240px] flex flex-col">
            <h3 class="text-base font-bold text-[#222222] absolute top-8 left-8">Total Kata</h3>
            <div class="flex-1 flex items-center justify-center">
                <h2 class="text-4xl lg:text-5xl font-bold text-[#222222]">{{ $totalWords }} Kata</h2>
            </div>
        </div>
    </div>

    {{-- Flashcard Module Section --}}
    <div class="space-y-4 pt-4">
        <div class="flex items-center gap-2 border-l-2 border-[#d62828] pl-2 text-left">
            <h3 class="text-sm font-bold text-[#222222]">Modul Flashcard</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($flashcardLevels as $lvl)
                <div class="bg-white border border-gray-100 rounded-[28px] p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition duration-200 min-h-[200px]">
                    
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-[52px] h-[52px] bg-white border border-gray-100 rounded-2xl flex items-center justify-center text-[#d62828] font-medium text-2xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] select-none">
                            あa
                        </div>
                        <h3 class="text-2xl font-bold text-[#222222] tracking-tight flex-1">Level {{ $lvl->level }}</h3>
                        
                        <!-- Dropdown Options -->
                        <div x-data="{ openOptions: false }" class="relative">
                            <button @click="openOptions = !openOptions" @click.away="openOptions = false" class="text-gray-400 hover:text-gray-600 p-2 rounded-full hover:bg-gray-100 transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                            </button>
                            <div x-show="openOptions" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-10" x-transition>
                                <button @click="$dispatch('open-edit-level', { level: {{ $lvl->level }} }); openOptions = false" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center gap-2 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit Level
                                </button>
                                <button @click="$dispatch('open-delete-level', { level: {{ $lvl->level }} }); openOptions = false" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus Level
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3 text-[13px] tracking-wide mb-6">
                        <div class="flex items-center">
                            <span class="w-24 text-gray-500 font-medium">Total Kata</span>
                            <span class="w-4 text-gray-800 font-bold">:</span>
                            <span class="text-gray-700 font-bold">{{ $lvl->total }} Kata</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-24 text-gray-500 font-medium">Diperbarui</span>
                            <span class="w-4 text-gray-800 font-bold">:</span>
                            <span class="text-gray-700 font-bold">{{ $lvl->updated }}</span>
                        </div>
                    </div>

                    <div class="flex justify-end mt-auto">
                        <a href="{{ route('teacher.vocabulary.level', ['id' => $lvl->level]) }}" class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-2 px-5 rounded-xl text-sm shadow-sm transition duration-200 flex items-center gap-2">
                            Buka Flashcard
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach

            {{-- Add Level Button --}}
            <button @click="$dispatch('open-add-level')" class="border-2 border-dashed border-[#d62828]/40 hover:border-[#d62828] rounded-[28px] p-6 flex flex-col items-center justify-center min-h-[200px] text-[#d62828] hover:bg-red-50/50 transition duration-200 group">
                <div class="flex items-center gap-2 text-xl font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Level
                </div>
            </button>
        </div>
    </div>

</div>
@endsection

@push('modals')
    {{-- Modal Tambah Level --}}
    <div x-data="{ show: false }" @open-add-level.window="show = true" x-show="show" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak style="display: none;">
        <div x-show="show" @click.away="show = false" class="bg-white rounded-[24px] w-full max-w-md mx-4 shadow-xl overflow-hidden transform transition-all" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <form action="#" method="GET" @submit.prevent="window.location.href = '{{ url('/teacher/vocabulary/level') }}/' + document.getElementById('level_input').value; show = false;">
                @csrf
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-bold text-[#222222]">Tambah Level Baru</h3>
                    <button type="button" @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <x-input-label for="level">Nomor Level <span class="text-red-500">*</span></x-input-label>
                        <x-text-input type="number" id="level_input" name="level" required placeholder="Contoh: 6" />
                        <p class="text-xs text-gray-500 mt-2">Level baru akan dibuat sebagai kumpulan flashcard kosong.</p>
                    </div>
                </div>

                <div class="px-6 py-5 border-t border-gray-100 flex justify-end gap-3 bg-gray-50/50">
                    <button type="button" @click="show = false" class="px-6 py-2.5 text-sm font-bold text-gray-600 hover:text-gray-900 transition">Batal</button>
                    <x-primary-button>Simpan Level</x-primary-button>
                </div>
            </form>

        </div>
    </div>

    {{-- Modal Edit Level --}}
    <div x-data="{ show: false, oldLevel: '', newLevel: '', confirmMergeStep: 0, existingLevels: {{ json_encode(collect($flashcardLevels)->pluck('level')->toArray()) }} }" 
         @open-edit-level.window="show = true; oldLevel = $event.detail.level; newLevel = $event.detail.level; confirmMergeStep = 0" 
         x-show="show" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak style="display: none;">
        <div x-show="show" @click.away="show = false" class="bg-white rounded-[24px] w-full max-w-md mx-4 shadow-xl overflow-hidden transform transition-all" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <form :action="'{{ url('/teacher/vocabulary/level') }}/' + oldLevel + '/update'" method="POST">
                @csrf
                @method('PUT')
                <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="text-lg font-bold text-[#222222]">Edit Level</h3>
                    <button type="button" @click="show = false" class="text-gray-400 hover:text-gray-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <x-input-label for="new_level">Ubah Nomor Level <span class="text-red-500">*</span></x-input-label>
                        <x-text-input type="number" id="new_level" name="new_level" x-model="newLevel" @input="confirmMergeStep = 0" required placeholder="Contoh: 6" />
                        <p class="text-xs text-gray-500 mt-2">Seluruh kosakata pada level ini akan dipindahkan ke nomor level yang baru.</p>

                        <!-- Warning Message -->
                        <div x-show="newLevel !== '' && parseInt(newLevel) !== parseInt(oldLevel) && existingLevels.includes(parseInt(newLevel))" x-cloak style="display: none;" class="mt-6 p-6 text-center flex flex-col items-center bg-red-50 border border-red-100 rounded-2xl">
                            <div class="w-14 h-14 bg-red-100 text-red-500 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-red-700 mb-2">Peringatan Penggabungan!</h3>
                            <p class="text-red-600 text-sm leading-relaxed">Level <span x-text="newLevel" class="font-bold"></span> sudah ada. Menyimpan ini akan <b>menggabungkan</b> seluruh kosakata Level <span x-text="oldLevel" class="font-bold"></span> ke Level <span x-text="newLevel" class="font-bold"></span>. Tindakan ini tidak dapat di-undo!</p>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-5 border-t border-gray-100 bg-gray-50/50">
                    <!-- Normal Actions -->
                    <div x-show="!(newLevel !== '' && parseInt(newLevel) !== parseInt(oldLevel) && existingLevels.includes(parseInt(newLevel)))" class="flex justify-end gap-3">
                        <button type="button" @click="show = false" class="px-6 py-2.5 text-sm font-bold text-gray-600 hover:text-gray-900 transition">Batal</button>
                        <x-primary-button>Simpan Perubahan</x-primary-button>
                    </div>

                    <!-- Destructive Actions -->
                    <div x-show="newLevel !== '' && parseInt(newLevel) !== parseInt(oldLevel) && existingLevels.includes(parseInt(newLevel))" x-cloak style="display: none;" class="flex gap-4">
                        <button type="button" @click="show = false" class="flex-1 py-3.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-xl text-sm font-bold transition shadow-sm">Batal</button>
                        <button type="button" x-show="confirmMergeStep === 0" @click="confirmMergeStep = 1" class="flex-1 py-3.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-bold shadow-sm transition">
                            Ya, Gabungkan Level
                        </button>
                        <button type="submit" x-show="confirmMergeStep === 1" x-cloak style="display: none;" class="flex-1 py-3.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-bold shadow-sm transition focus:outline-none focus:ring-4 focus:ring-red-500/30 ring-2 ring-red-200">
                            Apa kamu yakin?
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Hapus Level --}}
    <div x-data="{ show: false, level: '', confirmDeleteStep: 0 }" 
         @open-delete-level.window="show = true; level = $event.detail.level; confirmDeleteStep = 0" 
         x-show="show" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm" x-cloak style="display: none;">
        <div x-show="show" @click.away="show = false" class="bg-white rounded-[24px] w-full max-w-md mx-4 shadow-xl overflow-hidden transform transition-all" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <form :action="'{{ url('/teacher/vocabulary/level') }}/' + level" method="POST">
                @csrf
                @method('DELETE')
                <div class="p-8 text-center flex flex-col items-center">
                    <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-[#222222] mb-3">Hapus Level <span x-text="level"></span>?</h3>
                    <p class="text-gray-500 text-[15px] leading-relaxed px-4">Tindakan ini akan menghapus <span class="font-bold text-gray-800">seluruh kosakata</span> yang ada di dalam level ini secara permanen. Anda yakin?</p>
                </div>

                <div class="px-8 py-5 border-t border-gray-100 flex gap-4 bg-gray-50/50">
                    <button type="button" @click="show = false" class="flex-1 py-3.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-xl text-sm font-bold transition shadow-sm">Batal</button>
                    <button type="button" x-show="confirmDeleteStep === 0" @click="confirmDeleteStep = 1" class="flex-1 py-3.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-bold shadow-sm transition">
                        Ya, Hapus Semua
                    </button>
                    <button type="submit" x-show="confirmDeleteStep === 1" x-cloak style="display: none;" class="flex-1 py-3.5 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-bold shadow-sm transition focus:outline-none focus:ring-4 focus:ring-red-500/30 ring-2 ring-red-200">
                        Apa kamu yakin?
                    </button>
                </div>
            </form>
        </div>

    {{-- Global Toast Notification --}}
    <div x-data="{ show: false, message: '' }" 
         x-on:show-toast.window="
            message = typeof $event.detail === 'string' ? $event.detail : $event.detail.message;
            show = true;
            setTimeout(() => show = false, 3000);
         "
         class="fixed bottom-6 right-6 z-[110] flex flex-col gap-2 pointer-events-none">
        
        <div x-show="show" style="display: none;"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:translate-x-4"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-2xl bg-white shadow-lg ring-1 ring-black ring-opacity-5 flex items-center p-4 gap-4 border border-gray-100">
             
             <!-- Success Icon -->
             <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-50 flex items-center justify-center">
                 <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                 </svg>
             </div>
             
             <!-- Text -->
             <div class="flex-1">
                 <p class="text-sm font-bold font-ibm text-gray-900" x-text="message"></p>
                 <p class="text-xs font-karla text-gray-500 mt-0.5">Sistem telah diperbarui.</p>
             </div>
             
             <!-- Close -->
             <button type="button" @click="show = false" class="text-gray-400 hover:text-gray-500 transition">
                 <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                     <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                 </svg>
             </button>
        </div>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('alpine:init', () => {
                setTimeout(() => {
                    window.dispatchEvent(new CustomEvent('show-toast', { detail: "{{ session('success') }}" }));
                }, 100);
            });
        </script>
    @endif
@endpush

