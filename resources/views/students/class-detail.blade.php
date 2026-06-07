@extends('layouts.student')

@section('title', 'Detail Kelas - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10">
    
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('students.dashboard') }}" class="w-8 h-8 flex items-center justify-center rounded-full bg-white border border-gray-200 text-gray-500 hover:text-[#d62828] hover:border-red-200 hover:bg-red-50 transition shadow-sm flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight text-left">
                {{ $subject->nama_mapel }}
            </h1>
        </div>
        <nav class="flex items-center gap-2 text-sm font-medium text-[#666666] text-left">
            <a href="{{ route('students.dashboard') }}" class="hover:text-[#d62828] transition">Terdaftar</a> <span class="mx-1.5 text-gray-300">></span> 
            <span class="text-[#d62828]">{{ $subject->nama_mapel }}</span>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        
        <div class="lg:col-span-8 space-y-8">
            
            <div class="grid grid-cols-1 xl:grid-cols-5 gap-6 mb-8">

                <div class="banner-red xl:col-span-2 rounded-[32px] p-6 sm:p-8 flex flex-col items-center xl:items-start justify-center gap-6 relative overflow-hidden">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center text-[#d62828] font-black text-2xl flex-shrink-0 z-10">
                        あa
                    </div>
                    <div class="z-10 text-center xl:text-left">
                        <h1 class="text-2xl sm:text-3xl font-black text-white mb-2">{{ $subject->nama_mapel }}</h1>
                        <p class="text-white/80 text-xs font-medium leading-relaxed">
                            {{ $subject->deskripsi_mapel ?? 'Deskripsi kelas belum tersedia.' }}
                        </p>
                    </div>
                </div>

                <div class="xl:col-span-3 bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                    
                    <h3 class="text-lg font-bold text-[#222222] mb-6">Target dan Kualifikasi</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        
                        <div class="bg-white p-4 rounded-[24px] border border-gray-50 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#d62828] flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <circle cx="12" cy="12" r="6"></circle>
                                    <circle cx="12" cy="12" r="2"></circle>
                                    <path d="M14.5 9.5 21 3M21 3h-4M21 3v4"></path>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-[#666666] font-bold uppercase tracking-wider truncate">Target Sertifikasi</p>
                                <p class="font-bold text-[#222222] truncate">{{ $subject->target ?? 'Sertifikasi N4' }}</p>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-[24px] border border-gray-50 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#d62828] flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-[#666666] font-bold uppercase tracking-wider truncate">Total Durasi</p>
                                <p class="font-bold text-[#222222] truncate">{{ $subject->modul->sum('jp_teori') + $subject->modul->sum('jp_praktik') }} JP</p>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-[24px] border border-gray-50 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#d62828] flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M12 21H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4.5"></path>
                                    <path d="M16 3v4M8 3v4M3 11h18"></path>
                                    <circle cx="18" cy="18" r="4"></circle>
                                    <path d="M18 16v2h2"></path>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-[#666666] font-bold uppercase tracking-wider truncate">Jadwal</p>
                                <p class="font-bold text-[#222222] truncate">{{ $subject->jadwal ?? 'Belum ada jadwal' }}</p>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-[24px] border border-gray-50 shadow-sm flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#d62828] flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path>
                                    <path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path>
                                    <path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path>
                                    <path d="M12 15v3m-3 3h6"></path>
                                </svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-[#666666] font-bold uppercase tracking-wider">Syarat Kelulusan</p>
                                <p class="font-bold text-[#222222] truncate">
                                    Min. Skor {{ $subject->min_score ?? '0' }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-xl font-black text-[#222222] mb-6">Silabus dan Modul</h3>
                
                <div class="space-y-4">
                    @forelse($subject->modul as $modul)
                        @php
                            $isLocked = $modul->is_locked ?? false;
                            $hrefUrl = $isLocked ? '#' : route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $modul->id_modul]);
                            $lockedClasses = $isLocked ? 'opacity-60 cursor-not-allowed bg-gray-50/50 grayscale-[50%]' : 'hover:border-red-200 hover:shadow-md cursor-pointer bg-white';
                        @endphp

                        <a href="{{ $hrefUrl }}" 
                        class="block border border-gray-100 p-5 rounded-[24px] shadow-sm transition duration-200 {{ $lockedClasses }}">                                        
                            <div class="flex gap-4 items-start mb-4">
                                
                                <div class="w-12 h-12 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#d62828] flex-shrink-0">
                                    @if($isLocked)
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                        </svg>
                                    @elseif($modul->icon_type == 1)
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" /></svg>
                                    @elseif($modul->icon_type == 3)
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a1.5 1.5 0 01-1.5 1.5H9c-.443 0-.792-.35-.792-.792 0-.214-.078-.415-.224-.555C7.755 6 7.424 6 7.125 6c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401h0a1.5 1.5 0 011.5 1.5v2.625c0 .443-.35.792-.792.792-.214 0-.415.078-.555.224C10 16.245 10 16.576 10 16.875c0 1.036 1.007 1.875 2.25 1.875s2.25-.84 2.25-1.875c0-.369-.128-.713-.349-1.003-.215-.283-.401-.604-.401-.959v0a1.5 1.5 0 011.5-1.5h2.625c.443 0 .792.35.792.792 0 .214.078.415.224.555.229.229.56.229.859.229 1.036 0 1.875-1.007 1.875-2.25s-.84-2.25-1.875-2.25c-.369 0-.713.128-1.003.349-.283.215-.604.401-.959.401h0a1.5 1.5 0 01-1.5-1.5V6.087z" /></svg>
                                    @elseif($modul->icon_type == 4)
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" /></svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                                    @endif
                                </div>
                                
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-sm font-bold text-[#222222] leading-snug flex items-center gap-2">
                                        {{ $modul->nama_modul }}
                                        @if($isLocked)
                                            <span class="bg-gray-200 text-gray-500 text-[9px] font-black px-2 py-0.5 rounded-md tracking-widest uppercase">Terkunci</span>
                                        @endif
                                    </h4>
                                    <p class="text-[11px] text-[#666666] mt-1 font-semibold tracking-wide">
                                        {{ $modul->kode_modul ?? '-' }} | 
                                        Teori ({{ $modul->jp_teori ?? '0' }} JP) & Praktik ({{ $modul->jp_praktik ?? '0' }} JP)
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 text-[11px] font-bold">
                                <span class="text-[#666666] font-semibold">Progres</span>
                                <div class="flex-1 bg-[#FFDBDB] h-2 rounded-full overflow-hidden">
                                    <div class="bg-[#d62828] h-2 rounded-full transition-all" 
                                        style="width: {{ $modul->progress_percentage ?? 0 }}%">
                                    </div>
                                </div>
                                <span class="text-[#222222] font-black">
                                    {{ $modul->progress_percentage ?? 0 }}%
                                </span>
                            </div>

                        </a>
                    @empty
                        <p class="text-[#666666] italic text-sm text-center py-10">Belum ada modul untuk kelas ini.</p>
                    @endforelse
                </div>
            </div>


        </div>

        <div class="lg:col-span-4 space-y-8">
            
            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                <h3 class="text-lg font-bold text-[#222222] mb-6">Progres Kelas Keseluruhan</h3>
                
                <div class="flex items-center gap-6">
                    <div class="relative w-28 h-28 flex-shrink-0 flex items-center justify-center">
                        <svg class="w-full h-full -rotate-90">
                            <circle cx="56" cy="56" r="50" stroke="#FFDBDB" stroke-width="10" fill="transparent"></circle>
                            <circle cx="56" cy="56" r="50" stroke="#d62828" stroke-width="10" fill="transparent" 
                                stroke-dasharray="314.15" 
                                stroke-dashoffset="{{ isset($overallProgress) ? (314.15 - (314.15 * $overallProgress / 100)) : 157 }}">
                            </circle>
                        </svg>

                        <span class="absolute text-2xl font-black text-[#d62828]">
                            @isset($overallProgress)
                                {{ $overallProgress }}%
                            @else
                                <span class="text-[10px] text-[#666666] font-medium">0%</span>
                            @endisset
                        </span>
                    </div>

                    <div class="space-y-3">
                        <div class="leading-tight">
                            <p class="text-[11px] font-semibold text-[#666666]">Selesai:</p>
                            <p class="text-sm font-bold text-[#222222]">
                                {{ $completedModulesCount ?? '0' }} / {{ $modul_count }} Modul
                            </p>
                        </div>
                        <div class="leading-tight">
                            <p class="text-[11px] font-semibold text-[#666666]">Tersisa:</p>
                            <p class="text-sm font-bold text-[#222222]">
                                {{ $remainingModulesCount ?? '0' }} Modul
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-[32px] p-6 shadow-sm flex flex-col items-center">
                <div class="w-full text-left mb-6">
                    <h3 class="text-lg font-bold text-[#222222]">Mentor Sensei</h3>
                </div>
                
                @php
                    $guruName = $subject->guru->name ?? 'Belum ada guru';
                    $initials = collect(explode(' ', $guruName))->map(function($word) { return strtoupper(substr($word, 0, 1)); })->take(2)->join('');
                    
                    // Format WhatsApp Number (Ubah awalan 0 menjadi 62)
                    $waNumber = $subject->guru->nomor_telepon ?? null;
                    if ($waNumber) {
                        $waNumber = preg_replace('/[^0-9]/', '', $waNumber); // Hapus karakter non-angka
                        if (substr($waNumber, 0, 1) === '0') {
                            $waNumber = '62' . substr($waNumber, 1);
                        } elseif (substr($waNumber, 0, 2) !== '62') {
                            $waNumber = '62' . $waNumber; // Jaga-jaga jika inputnya 812xxx
                        }
                    }
                @endphp

                @if($subject->guru && $subject->guru->profile_photo_path)
                    <div class="w-24 h-24 rounded-full overflow-hidden shadow-sm ring-1 ring-gray-100 mb-4 border-4 border-white flex-shrink-0">
                        <img src="{{ Storage::disk('public')->url($subject->guru->profile_photo_path) }}" alt="{{ $guruName }}" class="w-full h-full object-cover" onerror="this.outerHTML='<div class=\'w-full h-full bg-[#FFDBDB] text-[#d62828] flex items-center justify-center text-3xl font-black\'>{{ $initials }}</div>'">
                    </div>
                @else
                    <div class="w-24 h-24 bg-[#FFDBDB] text-[#d62828] rounded-full flex items-center justify-center text-3xl font-black mb-4 border-4 border-white shadow-sm ring-1 ring-gray-100 flex-shrink-0">
                        {{ $initials }}
                    </div>
                @endif

                <h4 class="font-bold text-[#222222] text-lg leading-snug text-center">
                    {{ $guruName }}
                </h4>
                
                <p class="text-xs text-[#666666] font-medium mt-1 mb-6 text-center bg-gray-50 px-3 py-1 rounded-full">
                    Guru Bahasa Jepang
                </p>

                <div class="flex gap-2 w-full mt-auto">
                    <a href="{{ $waNumber ? 'https://wa.me/' . $waNumber : '#' }}" 
                    target="_blank" 
                    class="flex-1 bg-[#d62828] hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl text-xs transition flex items-center justify-center gap-2 shadow-sm">
                        <span>Hubungi Sensei</span>
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.588-5.946 0-6.556 5.332-11.888 11.888-11.888 3.176 0 6.161 1.237 8.404 3.48s3.481 5.229 3.481 8.405c0 6.555-5.332 11.89-11.888 11.89-2.014 0-3.991-.511-5.741-1.482l-6.243 1.636zm6.323-3.61c1.558.924 3.125 1.411 4.757 1.411 5.424 0 9.841-4.415 9.841-9.84 0-5.424-4.417-9.84-9.841-9.84-5.424 0-9.84 4.416-9.84 9.84 0 2.001.602 3.864 1.741 5.437l-1.011 3.693 3.791-1.127zm10.741-7.07c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.966-.941 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                    </a>

                    <a href="mailto:{{ $subject->guru->email ?? '#' }}" 
                    class="bg-[#FFDBDB] text-[#d62828] p-3 rounded-xl hover:bg-red-100 transition flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-[32px] p-6 shadow-sm" x-data="{ limit: 3, total: {{ count($subject->announcements ?? []) }} }">
                <h3 class="text-lg font-bold text-[#222222] mb-6 text-left">Pengumuman</h3>
                
                <div class="space-y-0">
                    @forelse($subject->announcements ?? [] as $index => $announcement)
                        <div class="py-3.5 border-b border-gray-100 last:border-0" x-show="{{ $index }} < limit" x-transition.duration.300ms style="display: {{ $index < 3 ? 'block' : 'none' }};">
                            <p class="text-xs sm:text-sm font-medium text-[#222222] hover:text-[#d62828] transition cursor-pointer break-words break-all">
                                {{ $announcement->title }} <span class="text-[#666666] font-normal inline-block">({{ $announcement->created_at ? $announcement->created_at->format('d M Y') : '' }})</span>
                            </p>
                        </div>
                    @empty
                        <div class="py-3.5 border-b border-gray-100 last:border-0 text-center">
                            <p class="text-xs sm:text-sm font-medium text-[#666666]">
                                Belum ada pengumuman
                            </p>
                        </div>
                    @endforelse
                </div>

                @if(count($subject->announcements ?? []) > 3)
                <div class="flex justify-end mt-4">
                    <button @click="limit += 3" x-show="limit < total" class="text-xs font-bold text-[#d62828] hover:underline transition tracking-wide cursor-pointer" type="button">
                        Muat Lebih Banyak
                    </button>
                    <span x-cloak x-show="limit >= total" class="text-[10px] font-bold text-gray-400 tracking-wide uppercase italic">
                        Semua telah dimuat
                    </span>
                </div>
                @endif
            </div>

@endsection