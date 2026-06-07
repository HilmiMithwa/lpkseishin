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
                            Program lanjutan dengan fokus praktik persiapan ujian level N4.
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
                                <p class="font-bold text-[#222222] truncate">{{ $subject->jp ?? '0' }} JP</p>
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
                            // Logika otomatis mendeteksi tipe modul berdasarkan kata kunci di namanya
                            $namaModulKecil = strtolower($modul->nama_modul);
                            
                            if (str_contains($namaModulKecil, 'intro') || str_contains($namaModulKecil, 'kanji')) {
                                $tipeModul = 'intro';
                            } elseif (str_contains($namaModulKecil, 'practice') || str_contains($namaModulKecil, 'simulation') || str_contains($namaModulKecil, 'test')) {
                                $tipeModul = 'test';
                            } else {
                                $tipeModul = 'materi'; // Default menggunakan icon buku
                            }
                        @endphp

                        <a href="{{ route('modules.show', ['id_mapel' => $subject->id_mapel, 'id_modul' => $modul->id_modul]) }}" 
                        class="block bg-white border border-gray-100 p-5 rounded-[24px] shadow-sm hover:border-red-200 hover:shadow-md transition duration-200 cursor-pointer">                                        
                            <div class="flex gap-4 items-start mb-4">
                                
                                <div class="w-12 h-12 bg-[#FFDBDB] rounded-2xl flex items-center justify-center text-[#d62828] flex-shrink-0">
                                    @if($tipeModul === 'intro')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <path d="m5 8 6 6M4 14h14M2 4h12M7 2v2M19 11l3.5 7.5M19 11l-3.5 7.5M16.5 16h5M11 5c0 3.5-2.5 7.5-6 9" />
                                        </svg>
                                    @elseif($tipeModul === 'test')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <rect x="3" y="4" width="11" height="16" rx="2" />
                                            <path d="M7 8h3M7 12h3M7 16h2" />
                                            <path d="M18 4l1 1-5 11h-2v-2l5-10z" />
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                        </svg>
                                    @endif
                                </div>
                                
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-sm font-bold text-[#222222] leading-snug">
                                        {{ $modul->nama_modul }}
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

            <div class="bg-white border border-gray-100 rounded-[32px] p-6 text-center shadow-sm">
                <h3 class="text-lg font-bold text-[#222222] mb-6 text-left">Mentor Sensei</h3>
                
                <div class="bg-[#FFDBDB] rounded-2xl p-6 mb-4 flex items-center justify-center">
                    <svg class="w-24 h-24 text-[#d62828]" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M3.5 3.5h16.5a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-11" />
                        <path d="M13.5 9h4" />
                        
                        <circle cx="5.5" cy="7.5" r="2.5" />
                        <path d="M3.0 21v-9h4v9" />
                        <path d="M7.5 13h4.5" />
                        <path d="M3.5 16h3.0" />
                    </svg>
                </div>

                <h4 class="font-bold text-[#222222] text-base sm:text-lg leading-snug">
                    {{ $subject->guru->name ?? 'Belum ada guru' }}
                </h4>
                
                <p class="text-xs text-[#666666] font-medium mt-0.5 mb-5">
                    Guru Bahasa Jepang
                </p>

                <div class="flex gap-2">
                    <a href="{{ isset($subject->guru->nomor_telepon) ? 'https://wa.me/' . $subject->guru->nomor_telepon : '#' }}" 
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

            <div class="bg-white border border-gray-100 rounded-[32px] p-8 shadow-sm">
                <h3 class="text-lg font-bold text-[#222222] mb-6 text-left">Pengumuman</h3>
                
                <div class="space-y-0">
                    @forelse($subject->announcements ?? [] as $announcement)
                        <div class="py-3.5 border-b border-gray-100 last:border-0">
                            <p class="text-xs sm:text-sm font-medium text-[#222222] hover:text-[#d62828] transition cursor-pointer">
                                {{ $announcement->title }} <span class="text-[#666666] font-normal">({{ $announcement->created_at ? $announcement->created_at->format('d M Y') : '' }})</span>
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

                <div class="flex justify-end mt-4">
                    <button class="text-xs font-bold text-[#d62828] hover:underline transition tracking-wide">
                        Muat Lebih Banyak
                    </button>
                </div>
            </div>

@endsection