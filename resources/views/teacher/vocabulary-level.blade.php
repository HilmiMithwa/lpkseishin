@extends('layouts.teacher')

@section('title', "Level {$level_id} - LPK Seishin")

@php
    $words = [
        '夢語り', '望ましい', 'ランプ', '望ましい', 'ランプ', '望ましい',
        '夢語り', '望ましい', 'ランプ', '夢語り', '望ましい', 'ランプ',
        '夢語り', '望ましい', 'ランプ', '夢語り', '望ましい', 'ランプ',
    ];
@endphp

@section('content')
<div class="p-4 sm:p-6 lg:p-10 space-y-4" x-data="{ hoveredIndex: null, activePage: 1, showFilter: false }">
    
    {{-- Header Row: Title + Breadcrumb + Create Button --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-2">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('teacher.vocabulary') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-gray-900 tracking-tight">Level {{ $level_id }}</h1>
            </div>
            <nav class="flex flex-wrap items-center gap-1.5 text-xs sm:text-sm">
                <a href="{{ route('teacher.vocabulary') }}" class="text-gray-500 hover:text-gray-700 font-medium transition">Database Kosakata</a>
                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-[#d62828] font-semibold">Level {{ $level_id }}</span>
            </nav>
        </div>
        <x-primary-button @click="$dispatch('open-create')" class="self-start gap-2">
            Buat Flashcard +
        </x-primary-button>
    </div>

    {{-- Main Box --}}
    <div class="bg-white rounded-[32px] shadow-sm border border-gray-100 p-6 lg:p-8 mt-4">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h3 class="text-lg font-bold text-[#222222]">Daftar Flashcard</h3>
            <p class="text-sm font-bold text-[#d62828]">Total: 124 Kata</p>
        </div>

        {{-- Toolbar --}}
        <form action="#" method="GET" class="flex items-center gap-3 mb-8">
            <div class="relative w-full sm:w-64">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kata..." class="w-full pl-10 pr-4 py-2 text-sm font-medium bg-white border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-300 transition">
            </div>
            
            <div class="relative">
                <button type="button" @click="showFilter = !showFilter" class="px-5 py-2 bg-white border border-gray-200 rounded-full text-sm font-bold text-gray-700 hover:bg-gray-50 flex items-center gap-2 transition">
                    Filter
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                </button>
                <div x-show="showFilter" @click.away="showFilter = false" class="absolute left-0 sm:right-0 sm:left-auto mt-2 w-56 bg-white rounded-2xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.12)] border border-gray-100 p-2 z-20" x-cloak style="display: none;" x-transition>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider px-3 py-2">Kategori Kata</p>
                    <button type="submit" name="category" value="" class="w-full text-left block px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition">Semua Kategori</button>
                    <button type="submit" name="category" value="meishi" class="w-full text-left block px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition">Kata Benda (Meishi)</button>
                    <button type="submit" name="category" value="doushi" class="w-full text-left block px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition">Kata Kerja (Doushi)</button>
                    <button type="submit" name="category" value="keiyoushi" class="w-full text-left block px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-red-50 hover:text-red-600 rounded-xl transition">Kata Sifat (Keiyoushi)</button>
                </div>
            </div>
        </form>

        {{-- Grid --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-5">
            @foreach($words as $index => $word)
                <div @mouseenter="hoveredIndex = {{ $index }}" @mouseleave="hoveredIndex = null" @click="$dispatch('open-detail', { 
                        word: '{{ $word }}', 
                        furigana: 'べんきょう',
                        romaji: 'Benkyou',
                        arti: 'Belajar',
                        category: 'meishi',
                        context_jp: '私は毎日日本語を勉強します。',
                        context_id: 'Saya belajar bahasa Jepang setiap hari.'
                    })"
                     class="aspect-[4/3] sm:aspect-square border border-gray-200 rounded-[28px] flex items-center justify-center text-center p-4 cursor-pointer transition-colors duration-200"
                     :class="hoveredIndex === {{ $index }} ? 'bg-[#d62828] text-white border-[#d62828] shadow-md' : 'bg-white text-[#222222] hover:bg-gray-50'">
                    
                    <span x-show="hoveredIndex !== {{ $index }}" class="text-3xl font-bold">{{ $word }}</span>
                    
                    <div x-show="hoveredIndex === {{ $index }}" class="flex flex-col items-center justify-center w-full h-full gap-1" style="display:none;">
                        <span class="text-sm font-semibold">Buka<br>Flashcard</span>
                        <svg class="w-3.5 h-3.5 mt-1 self-end mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"></path></svg>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="flex justify-end mt-10">
            <div class="flex gap-2">
                <button @click="if(activePage > 1) activePage--" class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#EABABA] text-red-600 hover:bg-red-200 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="activePage = 1" :class="activePage === 1 ? 'bg-[#d62828] text-white' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50'" class="w-9 h-9 flex items-center justify-center rounded-lg transition font-bold text-sm">1</button>
                <button @click="activePage = 2" :class="activePage === 2 ? 'bg-[#d62828] text-white' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50'" class="w-9 h-9 flex items-center justify-center rounded-lg transition font-bold text-sm">2</button>
                <button @click="activePage = 3" :class="activePage === 3 ? 'bg-[#d62828] text-white' : 'bg-white text-gray-700 border border-gray-200 hover:bg-gray-50'" class="w-9 h-9 flex items-center justify-center rounded-lg transition font-bold text-sm">3</button>
                <button @click="if(activePage < 3) activePage++" class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#d62828] text-white hover:bg-red-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </div>

    </div>

</div>
@endsection

@push('modals')
    {{-- Modal Word Detail --}}
    <div x-data="{ show: false, showDelete: false, wordData: {} }" @open-detail.window="show = true; wordData = $event.detail; showDelete = false" x-show="show" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 sm:p-0" x-cloak style="display: none;">
        <div x-show="show" @click.away="show = false" class="bg-[#F5F5F5] sm:bg-white rounded-[32px] w-full max-w-[800px] shadow-2xl overflow-hidden flex flex-col max-h-[90vh] relative" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            {{-- Header --}}
            <div class="px-8 py-5 flex justify-between items-center bg-white shrink-0 z-10 rounded-t-[32px]">
                <h3 class="text-[17px] font-bold text-[#222222]">Detail Kata: <span x-text="wordData.word"></span></h3>
                <button @click="show = false" class="w-7 h-7 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            {{-- Body --}}
            <div class="p-8 flex flex-col md:flex-row gap-8 overflow-y-auto custom-scrollbar bg-gray-50/30">
                <!-- Left: Preview Box -->
                <div class="w-full md:w-[45%] flex-shrink-0">
                    <div class="border-[3px] border-[#F4C430] rounded-[32px] p-8 flex flex-col justify-center items-center text-center shadow-sm h-full min-h-[320px] bg-white">
                        <h2 class="text-6xl font-bold text-[#222222] mb-3 tracking-tight" x-text="wordData.word"></h2>
                        <p class="text-[15px] font-bold text-[#444444] mb-8 tracking-wider" x-text="wordData.furigana"></p>
                        
                        <div class="w-full space-y-3 text-[13px] mt-auto">
                            <div class="flex justify-between border-t border-gray-100 pt-3">
                                <span class="font-bold text-gray-400">JP</span>
                                <span class="font-bold text-[#222222]" x-text="wordData.romaji"></span>
                            </div>
                            <div class="flex justify-between border-t border-gray-100 pt-3">
                                <span class="font-bold text-gray-400">EN</span>
                                <span class="font-bold text-[#222222]">Study</span>
                            </div>
                            <div class="flex justify-between border-t border-gray-100 pt-3">
                                <span class="font-bold text-gray-400">ID</span>
                                <span class="font-bold text-[#222222]" x-text="wordData.arti"></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right: Details -->
                <div class="w-full md:w-[55%] flex flex-col justify-center gap-5">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Definisi</p>
                        <p class="text-[15px] font-semibold text-[#222222] leading-relaxed">Tindakan untuk belajar atau mempelajari sesuatu hal baru.</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Penggunaan Kontekstual (oleh Sensei)</p>
                        <p class="text-[15px] font-bold text-[#222222]" x-text="wordData.context_jp"></p>
                        <p class="text-[13px] font-medium text-gray-500 mt-0.5" x-text="wordData.context_id"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Indeks Kata</p>
                        <p class="text-[15px] font-bold text-[#222222]">#14</p>
                    </div>
                    
                    <div class="flex items-center gap-3 mt-2">
                        <a href="#" class="px-6 py-2.5 text-sm font-bold text-gray-600 border border-gray-200 bg-white rounded-xl hover:bg-gray-50 transition flex-1 text-center">Sebelumnya</a>
                        <a href="#" class="px-6 py-2.5 text-sm font-bold text-white bg-[#d62828] rounded-xl hover:bg-red-700 transition flex-1 text-center">Selanjutnya</a>
                    </div>
                    
                    <button @click="showDelete = true" class="flex items-center justify-center gap-2 mt-1 text-sm font-bold text-red-500 bg-white border border-red-100 rounded-xl py-3 hover:bg-red-50 hover:border-red-200 transition w-full shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus Kata
                    </button>
                </div>
            </div>
            
            {{-- Footer --}}
            <div class="px-8 py-5 border-t border-gray-100 flex gap-4 bg-white shrink-0 rounded-b-[32px]">
                <button @click="$dispatch('open-edit', wordData); show = false" class="py-3.5 bg-[#d62828] hover:bg-red-700 text-white rounded-xl text-sm font-bold shadow-sm transition flex-1">Edit Flashcard</button>
                <button @click="show = false" class="px-10 py-3.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl text-sm font-bold transition">Tutup</button>
            </div>
            
            {{-- Delete Confirmation Overlay --}}
            <div x-show="showDelete" class="absolute inset-0 z-50 bg-white/90 backdrop-blur-sm flex items-center justify-center p-8 rounded-[32px]" x-transition x-cloak style="display: none;">
                <div class="bg-white p-6 rounded-3xl shadow-xl border border-red-100 text-center max-w-sm" @click.away="showDelete = false">
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="font-bold text-lg text-slate-800 mb-2">Hapus Flashcard?</h3>
                    <p class="text-sm text-slate-500 mb-6">Flashcard <span class="font-bold text-[#d62828]" x-text="wordData.word"></span> akan dihapus permanen dan tidak dapat dikembalikan.</p>
                    <div class="flex gap-3">
                        <button type="button" @click="showDelete = false" class="flex-1 py-3 bg-gray-100 hover:bg-gray-200 text-slate-700 rounded-xl font-bold text-sm transition">Batal</button>
                        <form action="#" method="POST" @submit.prevent="window.dispatchEvent(new CustomEvent('show-toast', {detail: 'Flashcard berhasil dihapus!'})); showDelete = false; show = false;" class="flex-1 flex">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex-1 py-3 bg-[#d62828] hover:bg-red-700 text-white rounded-xl font-bold text-sm transition shadow-sm border border-red-700">Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Create Flash Card --}}
    <div x-data="{ show: false, kanji: '', furigana: '', romaji: '', arti: '', category: '', context_jp: '', context_id: '' }" @open-create.window="show = true" x-show="show" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 sm:p-0" x-cloak style="display: none;">
        <div x-show="show" @click.away="show = false" class="bg-[#F5F5F5] sm:bg-white rounded-[32px] w-full max-w-[800px] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <form action="#" method="POST" @submit.prevent="window.dispatchEvent(new CustomEvent('show-toast', {detail: 'Flashcard berhasil dibuat!'})); show = false; kanji=''; furigana=''; romaji=''; arti=''; category=''; context_jp=''; context_id='';" class="flex flex-col h-full overflow-hidden">
                @csrf
                
                {{-- Header --}}
                <div class="px-8 py-5 flex justify-between items-center bg-white shrink-0 z-10 rounded-t-[32px]">
                    <h3 class="text-[17px] font-bold text-[#222222]">Buat Flashcard Baru</h3>
                    <button type="button" @click="show = false" class="w-7 h-7 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                {{-- Body --}}
                <div class="p-8 flex flex-col gap-6 overflow-y-auto custom-scrollbar flex-1 bg-white">
                    
                    {{-- Top Section: Preview & 4 Inputs --}}
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Left: Preview Box -->
                        <div class="w-full md:w-[45%] flex-shrink-0 relative">
                            <div class="border-[3px] border-[#F4C430] rounded-[32px] p-8 flex flex-col justify-center items-center text-center relative shadow-sm h-full min-h-[300px] bg-[#FFFCF0]">
                                <span class="absolute top-6 left-6 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Preview</span>
                                
                                <h2 class="text-6xl font-bold text-[#222222] mb-3 tracking-tight" x-text="kanji || '...' "></h2>
                                <p class="text-[15px] font-bold text-[#444444] mb-8 tracking-wider" x-text="furigana || '...' "></p>
                                
                                <div class="w-full space-y-3 text-[13px] mt-auto">
                                    <div class="flex justify-between border-t border-[#F4C430]/30 pt-3">
                                        <span class="font-bold text-gray-500">JP</span>
                                        <span class="font-bold text-[#222222]" x-text="romaji || '-'"></span>
                                    </div>
                                    <div class="flex justify-between border-t border-[#F4C430]/30 pt-3">
                                        <span class="font-bold text-gray-500">EN</span>
                                        <span class="font-bold text-[#222222]">-</span>
                                    </div>
                                    <div class="flex justify-between border-t border-[#F4C430]/30 pt-3">
                                        <span class="font-bold text-gray-500">ID</span>
                                        <span class="font-bold text-[#222222]" x-text="arti || '-'"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right: 4 Short Inputs -->
                        <div class="w-full md:w-[55%] flex flex-col justify-center gap-4">
                            <div class="space-y-1.5">
                                <x-input-label>Kata Jepang (Kanji/Kana): <span class="text-red-500">*</span></x-input-label>
                                <x-text-input type="text" name="kanji" x-model="kanji" required placeholder="Contoh: 勉強" />
                            </div>
                            <div class="space-y-1.5">
                                <x-input-label>Furigana (Cara baca): <span class="text-red-500">*</span></x-input-label>
                                <x-text-input type="text" name="furigana" x-model="furigana" required placeholder="Contoh: べんきょう" />
                            </div>
                            <div class="space-y-1.5">
                                <x-input-label>Romaji: <span class="text-red-500">*</span></x-input-label>
                                <x-text-input type="text" name="romaji" x-model="romaji" required placeholder="Contoh: Benkyou" />
                            </div>
                            <div class="space-y-1.5">
                                <x-input-label>Arti (Indonesia): <span class="text-red-500">*</span></x-input-label>
                                <x-text-input type="text" name="meaning_id" x-model="arti" required placeholder="Contoh: Belajar" />
                            </div>
                        </div>
                    </div>

                    {{-- Bottom Section: Full Width Inputs --}}
                    <div class="flex flex-col gap-4 mt-2">
                        <div class="space-y-1.5">
                            <x-input-label>Kategori Kata: <span class="text-red-500">*</span></x-input-label>
                            <div class="relative">
                                <select name="category" x-model="category" required class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm appearance-none shadow-sm">
                                    <option value="">Pilih Kategori</option>
                                    <option value="meishi">Kata Benda (Meishi)</option>
                                    <option value="doushi">Kata Kerja (Doushi)</option>
                                    <option value="keiyoushi">Kata Sifat (Keiyoushi)</option>
                                </select>
                                <svg class="w-4 h-4 text-gray-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Penggunaan Kontekstual (Jepang): <span class="text-red-500">*</span></x-input-label>
                            <textarea name="context_jp" x-model="context_jp" required rows="3" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm resize-none shadow-sm" placeholder="Tuliskan satu kalimat contoh... (Contoh: 私は毎日日本語を勉強します)"></textarea>
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Terjemahan Penggunaan: <span class="text-red-500">*</span></x-input-label>
                            <textarea name="context_id" x-model="context_id" required rows="3" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm resize-none shadow-sm" placeholder="Terjemahan dari kalimat contoh di atas..."></textarea>
                        </div>
                    </div>
                </div>
                
                {{-- Footer --}}
                <div class="px-8 py-5 border-t border-gray-100 flex gap-4 bg-white shrink-0 rounded-b-[32px]">
                    <x-primary-button class="flex-1">Simpan Flashcard</x-primary-button>
                    <button type="button" @click="show = false" class="px-10 py-3.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl text-sm font-bold transition">Batal</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit Flash Card --}}
    <div x-data="{ show: false, kanji: '', furigana: '', romaji: '', arti: '', category: '', context_jp: '', context_id: '' }" 
         @open-edit.window="
            show = true; 
            kanji = $event.detail.word;
            furigana = $event.detail.furigana;
            romaji = $event.detail.romaji;
            arti = $event.detail.arti;
            category = $event.detail.category;
            context_jp = $event.detail.context_jp;
            context_id = $event.detail.context_id;
         " 
         x-show="show" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm p-4 sm:p-0" x-cloak style="display: none;">
        <div x-show="show" @click.away="show = false" class="bg-[#F5F5F5] sm:bg-white rounded-[32px] w-full max-w-[800px] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <form action="#" method="POST" @submit.prevent="window.dispatchEvent(new CustomEvent('show-toast', {detail: 'Flashcard berhasil diperbarui!'})); show = false;" class="flex flex-col h-full overflow-hidden">
                @csrf
                @method('PUT')
                
                {{-- Header --}}
                <div class="px-8 py-5 flex justify-between items-center bg-white shrink-0 z-10 rounded-t-[32px]">
                    <h3 class="text-[17px] font-bold text-[#222222]">Edit Flashcard</h3>
                    <button type="button" @click="show = false" class="w-7 h-7 flex items-center justify-center rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                {{-- Body --}}
                <div class="p-8 flex flex-col gap-6 overflow-y-auto custom-scrollbar flex-1 bg-white">
                    
                    {{-- Top Section: Preview & 4 Inputs --}}
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Left: Preview Box -->
                        <div class="w-full md:w-[45%] flex-shrink-0 relative">
                            <div class="border-[3px] border-[#F4C430] rounded-[32px] p-8 flex flex-col justify-center items-center text-center relative shadow-sm h-full min-h-[300px] bg-[#FFFCF0]">
                                <span class="absolute top-6 left-6 text-[10px] font-bold text-gray-400 uppercase tracking-wider">Preview</span>
                                
                                <h2 class="text-6xl font-bold text-[#222222] mb-3 tracking-tight" x-text="kanji || '...' "></h2>
                                <p class="text-[15px] font-bold text-[#444444] mb-8 tracking-wider" x-text="furigana || '...' "></p>
                                
                                <div class="w-full space-y-3 text-[13px] mt-auto">
                                    <div class="flex justify-between border-t border-[#F4C430]/30 pt-3">
                                        <span class="font-bold text-gray-500">JP</span>
                                        <span class="font-bold text-[#222222]" x-text="romaji || '-'"></span>
                                    </div>
                                    <div class="flex justify-between border-t border-[#F4C430]/30 pt-3">
                                        <span class="font-bold text-gray-500">EN</span>
                                        <span class="font-bold text-[#222222]">-</span>
                                    </div>
                                    <div class="flex justify-between border-t border-[#F4C430]/30 pt-3">
                                        <span class="font-bold text-gray-500">ID</span>
                                        <span class="font-bold text-[#222222]" x-text="arti || '-'"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right: 4 Short Inputs -->
                        <div class="w-full md:w-[55%] flex flex-col justify-center gap-4">
                            <div class="space-y-1.5">
                                <x-input-label>Kata Jepang (Kanji/Kana): <span class="text-red-500">*</span></x-input-label>
                                <x-text-input type="text" name="kanji" x-model="kanji" required placeholder="Contoh: 勉強" />
                            </div>
                            <div class="space-y-1.5">
                                <x-input-label>Furigana (Cara baca): <span class="text-red-500">*</span></x-input-label>
                                <x-text-input type="text" name="furigana" x-model="furigana" required placeholder="Contoh: べんきょう" />
                            </div>
                            <div class="space-y-1.5">
                                <x-input-label>Romaji: <span class="text-red-500">*</span></x-input-label>
                                <x-text-input type="text" name="romaji" x-model="romaji" required placeholder="Contoh: Benkyou" />
                            </div>
                            <div class="space-y-1.5">
                                <x-input-label>Arti (Indonesia): <span class="text-red-500">*</span></x-input-label>
                                <x-text-input type="text" name="meaning_id" x-model="arti" required placeholder="Contoh: Belajar" />
                            </div>
                        </div>
                    </div>

                    {{-- Bottom Section: Full Width Inputs --}}
                    <div class="flex flex-col gap-4 mt-2">
                        <div class="space-y-1.5">
                            <x-input-label>Kategori Kata: <span class="text-red-500">*</span></x-input-label>
                            <div class="relative">
                                <select name="category" x-model="category" required class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm appearance-none shadow-sm">
                                    <option value="">Pilih Kategori</option>
                                    <option value="meishi">Kata Benda (Meishi)</option>
                                    <option value="doushi">Kata Kerja (Doushi)</option>
                                    <option value="keiyoushi">Kata Sifat (Keiyoushi)</option>
                                </select>
                                <svg class="w-4 h-4 text-gray-400 absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Penggunaan Kontekstual (Jepang): <span class="text-red-500">*</span></x-input-label>
                            <textarea name="context_jp" x-model="context_jp" required rows="3" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm resize-none shadow-sm" placeholder="Tuliskan satu kalimat contoh... (Contoh: 私は毎日日本語を勉強します)"></textarea>
                        </div>
                        <div class="space-y-1.5">
                            <x-input-label>Terjemahan Penggunaan: <span class="text-red-500">*</span></x-input-label>
                            <textarea name="context_id" x-model="context_id" required rows="3" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-1 focus:ring-[#d62828] focus:border-[#d62828] transition text-[#222222] font-bold text-sm resize-none shadow-sm" placeholder="Terjemahan dari kalimat contoh di atas..."></textarea>
                        </div>
                    </div>
                </div>
                
                {{-- Footer --}}
                <div class="px-8 py-5 border-t border-gray-100 flex gap-4 bg-white shrink-0 rounded-b-[32px]">
                    <x-primary-button class="flex-1">Simpan Perubahan</x-primary-button>
                    <button type="button" @click="show = false" class="px-10 py-3.5 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl text-sm font-bold transition">Batal</button>
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
             <button @click="show = false" class="text-gray-400 hover:text-gray-500 transition">
                 <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                     <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                 </svg>
             </button>
        </div>
    </div>
@endpush
