@extends('layouts.teacher')

@section('title', 'Kelas Saya - LPK Seishin')

@section('content')
@php
    // Dummy Data — Batch list
    if (!isset($batches) || (is_countable($batches) && count($batches) == 0)) {
        $batches = [
            (object)[
                'id_batch' => 2,
                'nama_batch' => 'Batch 2',
                'tanggal_mulai' => '24 January 2025',
                'tanggal_selesai' => '31 May 2025',
                'gradient' => 'from-[#d62828] to-[#8b1a1a]',
            ],
            (object)[
                'id_batch' => 3,
                'nama_batch' => 'Batch 3',
                'tanggal_mulai' => '1 June 2025',
                'tanggal_selesai' => '30 September 2025',
                'gradient' => 'from-[#c22626] to-[#7a1717]',
            ],
            (object)[
                'id_batch' => 4,
                'nama_batch' => 'Batch 4',
                'tanggal_mulai' => '1 October 2025',
                'tanggal_selesai' => '31 December 2025',
                'gradient' => 'from-[#b52222] to-[#6e1414]',
            ],
            (object)[
                'id_batch' => 5,
                'nama_batch' => 'Batch 5',
                'tanggal_mulai' => '1 January 2026',
                'tanggal_selesai' => '30 April 2026',
                'gradient' => 'from-[#a31e1e] to-[#5e1111]',
            ],
            (object)[
                'id_batch' => 1,
                'nama_batch' => 'Batch 1',
                'tanggal_mulai' => '24 January 2025',
                'tanggal_selesai' => '31 May 2025',
                'gradient' => 'from-[#6b6b6b] to-[#3d3d3d]',
            ],
        ];
    }
@endphp

<div class="p-4 sm:p-6 lg:p-10">

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 class="text-xl sm:text-2xl lg:text-[26px] font-bold font-ibm text-gray-900 tracking-tight">Kelas Saya</h1>
        <p class="text-xs sm:text-sm text-gray-500 font-medium">Pilih batch untuk melihat dan mengelola kelas Anda.</p>
    </div>

    {{-- Search & Filter --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 mb-6">
        <div class="relative flex-1 sm:flex-initial">
            <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <input type="text" id="search-batch" placeholder="Cari batch..." class="w-full sm:w-72 pl-10 pr-4 py-2.5 text-sm font-medium bg-white border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-300 transition placeholder:text-gray-400">
        </div>
        <button class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
            Filter
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
        </button>
    </div>

    {{-- Batch Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5" id="batch-grid">
        @foreach($batches as $batch)
        <div class="batch-card group relative bg-gradient-to-br {{ $batch->gradient }} rounded-2xl lg:rounded-3xl p-5 sm:p-6 shadow-sm hover:shadow-lg transition-all duration-300 cursor-pointer flex flex-col justify-between min-h-[160px] overflow-hidden"
             data-name="{{ strtolower($batch->nama_batch) }}">
            
            {{-- Decorative bg pattern --}}
            <div class="absolute top-0 right-0 w-1/2 h-full opacity-[0.08] pointer-events-none">
                <svg viewBox="0 0 200 200" class="w-full h-full" fill="white">
                    <circle cx="150" cy="50" r="80" />
                    <circle cx="180" cy="120" r="50" />
                </svg>
            </div>

            {{-- Batch Info --}}
            <div class="relative z-10">
                <h3 class="text-2xl sm:text-3xl font-bold font-ibm text-white mb-2 leading-tight">{{ $batch->nama_batch }}</h3>
                <div class="flex items-center gap-1.5 text-white/80">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-[11px] sm:text-xs font-medium">{{ $batch->tanggal_mulai }} - {{ $batch->tanggal_selesai }}</span>
                </div>
            </div>

            {{-- Manage Button --}}
            <div class="relative z-10 mt-4">
                <a href="{{ route('teacher.batch.show', $batch->id_batch) }}" class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-800 font-bold py-2 px-4 rounded-lg text-xs sm:text-sm transition shadow-sm group-hover:shadow-md">
                    Kelola Kelas
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
        @endforeach
    </div>

</div>

@endsection

@push('scripts')
<script>
    // Search functionality
    const searchInput = document.getElementById('search-batch');
    const batchCards = document.querySelectorAll('.batch-card');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            batchCards.forEach(card => {
                const name = card.dataset.name;
                card.closest('.batch-card').style.display = name.includes(query) ? '' : 'none';
            });
        });
    }
</script>
@endpush
