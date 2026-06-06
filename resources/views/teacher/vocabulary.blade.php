@extends('layouts.teacher')

@section('title', 'Database Kosakata - LPK Seishin')

@php
    $dailyKanji = '夢語り';
    $dailyRomaji = 'Yumegatari';
    $dailyMeaningEn = 'Speak of Dream';
    $dailyMeaningId = 'Cerita Mimpi';
    $dailyFurigana = 'ゆめがたり';

    $flashcardLevels = [
        (object)['level' => 1, 'total' => 104, 'updated' => '2 Hari Lalu'],
        (object)['level' => 2, 'total' => 104, 'updated' => '2 Hari Lalu'],
        (object)['level' => 3, 'total' => 104, 'updated' => '2 Hari Lalu'],
        (object)['level' => 4, 'total' => 104, 'updated' => '2 Hari Lalu'],
        (object)['level' => 5, 'total' => 104, 'updated' => '2 Hari Lalu'],
    ];
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
                <h2 class="text-4xl lg:text-5xl font-bold text-[#222222]">456 Kata</h2>
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
                        <h3 class="text-2xl font-bold text-[#222222] tracking-tight">Level {{ $lvl->level }}</h3>
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
            
            <form action="#" method="POST" @submit.prevent="window.dispatchEvent(new CustomEvent('show-toast', {detail: 'Level baru berhasil ditambahkan!'})); show = false;">
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
                        <x-text-input type="number" id="level" name="level" required placeholder="Contoh: 6" />
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
@endpush

