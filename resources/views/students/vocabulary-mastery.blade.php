@extends('layouts.student')

@section('title', 'Penguasaan Kosakata - LPK Seishin')


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
<div class="p-4 sm:p-6 lg:p-10 space-y-8">
    
    <div class="text-left mb-4">
        <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Penguasaan Kosakata</h1>
        <p class="text-sm text-[#666666] font-medium mt-2">Penguasaan Kosakata</p>
    </div>

    <div class="w-full banner-red rounded-[32px] p-6 lg:p-10 text-white flex flex-col md:flex-row justify-between items-center relative shadow-sm min-h-[180px]">
        
        <div class="space-y-2 z-10 flex flex-col justify-center items-center">
            <div>
                <span class="text-base font-semibold tracking-wide text-white/90 select-none">
                    Kata Hari Ini
                </span>
            </div>
            <div class="pt-0.5 text-center">
                <h2 class="text-6xl lg:text-8xl font-bold tracking-tight text-white mt-0.5">
                    {{ $dailyWord->kanji }}
                </h2>
                
                <p class="text-base font-bold text-red-100/90 tracking-wide mt-1">
                    {{ $dailyWord->romaji }}
                </p>
            </div>
        </div>
        <div class="mt-6 md:mt-0 flex flex-col items-end gap-2.5 z-10 w-full md:w-52 flex-shrink-0 animate-[fadeIn_0.2s_ease-out]">
            
            <button class="w-10 h-10 bg-white text-[#666666] hover:text-amber-500 rounded-xl flex items-center justify-center shadow-sm hover:scale-105 transition-all duration-200 text-lg border border-gray-100/50">
                ★
            </button>

            <div class="bg-white rounded-[24px] py-4 px-5 text-center text-gray-800 shadow-sm w-full flex flex-col justify-center items-center min-h-[96px] border border-gray-50 select-none h-auto">
                <p class="text-[9px] font-bold text-[#666666] uppercase tracking-widest">Terjemahan</p>
                
                <h3 class="text-sm font-bold text-[#222222] mt-1.5 leading-snug tracking-tight max-w-full break-words">
                    {{ $dailyWord->meaning_id }}
                </h3>
                
                <p class="text-xs font-medium text-[#444444] mt-1 max-w-full break-words">
                    {{ $dailyWord->meaning_en }}
                </p>
            </div>

        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
        
        <div class="bg-white border border-gray-100 rounded-[28px] p-6 shadow-sm flex items-center justify-between text-left">
            <div class="space-y-1">
                <div class="flex items-center gap-2 mb-1.5">
                    <div class="w-5 h-5 rounded-full border border-[#d62828] flex items-center justify-center text-[#d62828]">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="text-xs font-bold text-[#444444] capitalize tracking-wide">Dikuasai</p>
                </div>
                <h2 class="text-3xl font-bold text-[#222222] tracking-tight">{{ $statMastered }} Kata</h2>
            </div>
            
            <div class="relative w-[70px] h-[70px] flex items-center justify-center flex-shrink-0">
                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                    <path class="text-gray-100" stroke-width="3.5" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                    <path class="text-[#d62828]" stroke-width="3.5" stroke-dasharray="{{ $masteredPercentage }}, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                </svg>
                <span class="absolute text-xs font-bold text-[#222222]">{{ $masteredPercentage }}%</span>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-[28px] p-6 shadow-sm flex flex-col justify-center text-left">
            <div class="space-y-1">
                <div class="flex items-center gap-2 mb-1.5">
                    <div class="w-5 h-5 rounded-full border border-[#d62828] flex items-center justify-center text-[#d62828]">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    </div>
                    <p class="text-xs font-bold text-[#444444] capitalize tracking-wide">Dipelajari</p>
                </div>
                <h2 class="text-3xl font-bold text-[#222222] tracking-tight">{{ $statLearning }} Kata</h2>
            </div>
        </div>

        <div class="bg-white border border-gray-100 rounded-[28px] p-6 shadow-sm flex items-center justify-between text-left">
            <div class="space-y-1">
                <div class="flex items-center gap-2 mb-1.5">
                    <div class="w-5 h-5 rounded-full border border-[#d62828] flex items-center justify-center text-[#d62828]">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                    <p class="text-xs font-bold text-[#444444] capitalize tracking-wide">Favorit</p>
                </div>
                <h2 class="text-3xl font-bold text-[#222222] tracking-tight">{{ $statFavourite }} Kata</h2>
            </div>
            <a href="{{ route('students.vocabulary-favorites') }}" class="w-12 h-12 bg-[#d62828] hover:bg-red-700 text-white rounded-full flex items-center justify-center transition shadow-sm hover:-translate-y-0.5 duration-200 flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>

    </div>

    <div class="space-y-4">
        <div class="flex items-center gap-2 border-l-2 border-[#d62828] pl-2 text-left">
            <h3 class="text-sm font-bold text-[#222222]">Modul Flashcard</h3>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($flashcardLevels as $lvl)
                <div class="bg-white border border-gray-100 rounded-[28px] p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition duration-200 min-h-[220px]">
                    
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-[52px] h-[52px] bg-white border border-gray-100 rounded-2xl flex items-center justify-center text-[#d62828] font-medium text-2xl shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] select-none">
                                あa
                            </div>
                            <h3 class="text-xl font-bold text-[#222222] tracking-tight">Level {{ $lvl->level }}</h3>
                        </div>
                        
                        <span class="text-[11px] font-bold capitalize px-3 py-1.5 rounded-lg {{ $lvl->status === 'Selesai' ? 'bg-[#22c55e] text-white' : 'bg-[#eab308] text-white' }}">
                            {{ $lvl->status }}
                        </span>
                    </div>

                    <div class="space-y-2.5 text-[13px] tracking-wide mb-6">
                        <div class="flex items-center">
                            <span class="w-24 text-gray-500 font-medium">Total Kata</span>
                            <span class="w-4 text-gray-800 font-bold">:</span>
                            <span class="text-gray-700 font-bold">{{ $lvl->total }} Kata</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-24 text-gray-500 font-medium">Dikuasai</span>
                            <span class="w-4 text-gray-800 font-bold">:</span>
                            <span class="text-gray-700 font-bold">{{ $lvl->mastered }} Kata</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-24 text-gray-500 font-medium">Diperbarui</span>
                            <span class="w-4 text-gray-800 font-bold">:</span>
                            <span class="text-gray-700 font-bold">{{ $lvl->updated }}</span>
                        </div>
                    </div>

                    <div class="flex justify-end mt-auto">
                        <button class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-5 rounded-xl text-sm shadow-sm transition duration-200 flex items-center gap-2" onclick="window.location.href='{{ route('students.vocabulary-level', ['id' => $lvl->level]) }}'">
                            Buka Flashcard
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </button>
                    </div>
                    
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection