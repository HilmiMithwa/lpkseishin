@extends('layouts.teacher')

@section('title', 'Video Conference - LPK Seishin')

@section('content')
<div x-data="{ showCreateModal: false }" class="p-4 sm:p-6 lg:p-10">
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Video Conference</h1>
            <p class="text-sm text-[#666666] font-medium mt-2">Kelola jadwal pertemuan virtual untuk kelas Anda.</p>
        </div>
        <button @click="showCreateModal = true" class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-5 rounded-xl text-sm transition shadow-md flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
            Jadwalkan Meeting Baru
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
        </div>
    @endif

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
                
                <div class="space-y-2 mt-4 mb-6">
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
                    <a href="{{ route('teacher.meetings.join', $meeting->id_meeting) }}" class="flex-1 bg-gray-900 hover:bg-black text-white text-center py-2.5 rounded-xl text-sm font-bold transition">Mulai Kelas</a>
                    <form action="{{ route('teacher.meetings.destroy', $meeting->id_meeting) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 py-16 bg-white border border-dashed border-gray-200 rounded-3xl text-center">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-[#222222] mb-1">Belum Ada Jadwal Meeting</h3>
                <p class="text-[#666666] text-sm mb-6 max-w-md mx-auto">Anda belum membuat jadwal video conference untuk kelas mana pun. Klik tombol di atas untuk mulai membuat jadwal kelas live pertama Anda.</p>
            </div>
        @endforelse
    </div>

    <!-- Create Meeting Modal overlay -->
    <template x-teleport="body">
        <div x-show="showCreateModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden p-4 sm:p-6" x-cloak>
            <!-- Backdrop -->
            <div x-show="showCreateModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100 backdrop-blur-md" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 backdrop-blur-md" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-md" @click="showCreateModal = false"></div>

            <!-- Modal Panel -->
            <div x-show="showCreateModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4 sm:translate-y-0" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4 sm:translate-y-0" class="relative w-full max-w-lg bg-white rounded-3xl shadow-xl overflow-hidden z-10 flex flex-col max-h-full text-left transition-all sm:my-8">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-bold font-ibm text-[#222222]">Jadwalkan Video Conference</h3>
                        <button @click="showCreateModal = false" class="text-gray-400 hover:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
                <form action="{{ route('teacher.meetings.store') }}" method="POST">
                    @csrf
                    <div class="px-4 py-5 sm:p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-[#222222] mb-1">Pilih Mata Pelajaran</label>
                            <select name="id_mapel" required class="w-full rounded-xl border-gray-200 focus:border-[#d62828] focus:ring focus:ring-red-200 transition text-sm">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($mapels as $mapel)
                                    <option value="{{ $mapel->id_mapel }}">
                                        {{ $mapel->batch->nama ?? 'Tanpa Batch' }} - {{ $mapel->nama_mapel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-[#222222] mb-1">Judul Pertemuan</label>
                            <input type="text" name="judul" required placeholder="Contoh: Pembahasan Materi Pola Kalimat N4" class="w-full rounded-xl border-gray-200 focus:border-[#d62828] focus:ring focus:ring-red-200 transition text-sm">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-[#222222] mb-1">Waktu Mulai</label>
                                <input type="datetime-local" name="waktu_mulai" required class="w-full rounded-xl border-gray-200 focus:border-[#d62828] focus:ring focus:ring-red-200 transition text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-[#222222] mb-1">Waktu Selesai</label>
                                <input type="datetime-local" name="waktu_selesai" required class="w-full rounded-xl border-gray-200 focus:border-[#d62828] focus:ring focus:ring-red-200 transition text-sm">
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-transparent bg-[#d62828] px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-red-700 sm:ml-3">Buat Jadwal</button>
                        <button type="button" @click="showCreateModal = false" class="mt-3 w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 bg-white px-6 py-2.5 text-sm font-bold text-[#444444] shadow-sm hover:bg-gray-50 sm:mt-0">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </template>
</div>
@endsection

