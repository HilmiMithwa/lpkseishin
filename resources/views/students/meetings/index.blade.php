@extends('layouts.student')

@section('title', 'Video Conference - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10">
    <div class="mb-8">
        <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Video Conference</h1>
        <p class="text-sm text-[#666666] font-medium mt-2">Daftar jadwal kelas live (virtual tatap muka) untuk mata pelajaran Anda.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($meetings as $meeting)
            <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-md transition flex flex-col relative overflow-hidden">
                @if($meeting->status == 'ongoing' || ($meeting->waktu_mulai <= now()->addHours(7) && $meeting->waktu_selesai >= now()->addHours(7)))
                    <div class="absolute top-0 right-0 bg-red-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl uppercase tracking-wider animate-pulse">Live Now</div>
                @elseif($meeting->waktu_mulai > now()->addHours(7))
                    <div class="absolute top-0 right-0 bg-blue-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl uppercase tracking-wider">Upcoming</div>
                @else
                    <div class="absolute top-0 right-0 bg-gray-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl uppercase tracking-wider">Ended</div>
                @endif
                
                <div class="mb-4 mt-2">
                    <span class="text-xs font-bold text-[#d62828] bg-red-50 px-2.5 py-1 rounded-md">{{ $meeting->mapel->nama_mapel }}</span>
                </div>
                <h3 class="text-xl font-bold font-ibm text-[#222222] leading-tight mb-2">{{ $meeting->judul }}</h3>
                
                <div class="flex items-center gap-2 mb-4">
                    <img src="{{ $meeting->mapel->guru->avatar_url ?? 'https://ui-avatars.com/api/?name=Sensei&background=f3f4f6&color=d62828' }}" onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Sensei&background=f3f4f6&color=d62828'" class="w-6 h-6 rounded-full">
                    <p class="text-[12px] font-bold text-[#444444]">{{ $meeting->mapel->guru->name ?? 'Sensei' }}</p>
                </div>

                <div class="space-y-2 mt-2 mb-6">
                    <div class="flex items-center gap-2 text-sm text-[#666666]">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($meeting->waktu_mulai)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-[#666666]">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium">{{ \Carbon\Carbon::parse($meeting->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($meeting->waktu_selesai)->format('H:i') }} WIB</span>
                    </div>
                </div>

                <div class="mt-auto pt-4 border-t border-gray-100 flex gap-2">
                    <a href="{{ route('students.meetings.join', $meeting->id_meeting) }}" class="flex-1 bg-[#d62828] hover:bg-red-700 text-white text-center py-2.5 rounded-xl text-sm font-bold transition">Join Meeting</a>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 py-16 bg-white border border-dashed border-gray-200 rounded-3xl text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-[#222222] mb-1">Tidak Ada Jadwal Kelas Live</h3>
                <p class="text-[#666666] text-sm mb-6 max-w-md mx-auto">Sensei Anda belum menjadwalkan kelas tatap muka virtual (video conference) untuk mata pelajaran yang Anda ikuti.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
