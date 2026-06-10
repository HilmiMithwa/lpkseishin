@extends('layouts.admin')

@section('title', 'Manajemen Batch - LPK Seishin')

@section('content')
<div class="p-6 lg:p-8 space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-[32px] font-bold text-slate-800 leading-tight">Manajemen Batch</h1>
            <p class="text-[15px] font-semibold text-slate-500 mt-1">Kelola data angkatan (batch) dan jadwal pendaftaran siswa.</p>
        </div>
        <div>
            <button x-data="" x-on:click.prevent="$dispatch('open-add-batch-modal')" class="bg-[#d62828] text-white hover:bg-red-800 font-bold py-2.5 px-5 rounded-xl shadow-[0_2px_10px_-4px_rgba(214,40,40,0.5)] transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Batch
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <x-card class="overflow-hidden" padding="none">
        
        <!-- Toolbar (Search & Filter) -->
        <div class="p-5 lg:p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            
            <!-- Filters -->
            <form method="GET" action="{{ route('admin.batches') }}" class="flex gap-2 w-full sm:w-auto" id="filter-form">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <select name="status" onchange="this.form.submit()" class="border border-gray-200 text-slate-600 rounded-xl px-4 py-2 text-sm font-medium focus:ring-[#d62828]/20 focus:border-[#d62828] outline-none">
                    <option value="">Semua Status</option>
                    <option value="pendaftaran" {{ request('status') == 'pendaftaran' ? 'selected' : '' }}>Pendaftaran Buka</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Sedang Berjalan</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </form>

            <!-- Search Bar -->
            <form method="GET" action="{{ route('admin.batches') }}" class="relative w-full sm:w-64">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition-all sm:text-sm font-medium text-slate-800" placeholder="Cari batch...">
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-slate-500 font-bold">
                        <th class="px-6 py-4 rounded-tl-xl">Info Batch</th>
                        <th class="px-6 py-4">Periode</th>
                        <th class="px-6 py-4">Siswa / Kuota</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70">
                    @forelse($batches as $batch)
                    @php
                        $studentCount = $studentCounts[$batch->id_batch] ?? 0;
                        $quota = $batch->quota ?? 30;
                        $percentage = min(100, round(($studentCount / $quota) * 100));
                        
                        $startDateFormatted = \Carbon\Carbon::parse($batch->waktu_mulai)->translatedFormat('M Y');
                        $endDateFormatted = \Carbon\Carbon::parse($batch->waktu_berakhir)->translatedFormat('M Y');
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-bold text-slate-800">{{ $batch->nama }}</p>
                                <p class="text-xs font-medium text-slate-500 mt-0.5">{{ $batch->deskripsi ?? $batch->nama_program }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-700">{{ $startDateFormatted }} - {{ $endDateFormatted }}</p>
                            <p class="text-[11px] font-medium text-slate-500 mt-0.5">{{ $batch->durasi }} | SPP: Rp {{ number_format($batch->spp_nominal ?? 0, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-full bg-slate-100 rounded-full h-1.5 max-w-[80px]">
                                    <div class="h-1.5 rounded-full {{ $percentage >= 100 ? 'bg-emerald-500' : 'bg-[#d62828]' }}" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-600">{{ $studentCount }}/{{ $quota }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if(($batch->status ?? 'pendaftaran') == 'aktif')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-red-50 text-[#d62828] border border-red-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#d62828]"></span> Sedang Berjalan
                                </span>
                            @elseif(($batch->status ?? 'pendaftaran') == 'selesai')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> Pendaftaran Buka
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center" x-data>
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button x-on:click="$dispatch('open-edit-batch-modal', { batch: { id: '{{ $batch->id_batch }}', batch_name: '{{ addslashes($batch->nama) }}', description: '{{ addslashes($batch->deskripsi) }}', start_date: '{{ $batch->waktu_mulai }}', end_date: '{{ $batch->waktu_berakhir }}', status: '{{ $batch->status ?? 'pendaftaran' }}', quota: '{{ $batch->quota ?? 30 }}', spp_nominal: '{{ $batch->spp_nominal ?? 0 }}', jadwal: '{{ addslashes($batch->jadwal) }}', jam_mulai: '{{ $batch->jam_mulai ? \Carbon\Carbon::parse($batch->jam_mulai)->format('H:i') : '' }}', jam_selesai: '{{ $batch->jam_selesai ? \Carbon\Carbon::parse($batch->jam_selesai)->format('H:i') : '' }}' } })" class="p-1.5 text-slate-400 hover:text-[#d62828] bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-rose-50 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button x-on:click="$dispatch('open-delete-batch-modal', { id: '{{ $batch->id_batch }}' })" class="p-1.5 text-slate-400 hover:text-rose-600 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-rose-50 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500 italic text-sm">
                            Tidak ada data batch.
                        </td>
                    </tr>
                    @endforelse
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="p-4 border-t border-gray-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between text-sm gap-3 font-semibold">
            <span class="font-medium text-slate-500">
                Menampilkan 
                <span class="font-bold text-slate-800">{{ $batches->firstItem() ?? 0 }}</span> 
                hingga 
                <span class="font-bold text-slate-800">{{ $batches->lastItem() ?? 0 }}</span> 
                dari 
                <span class="font-bold text-slate-800">{{ $batches->total() }}</span> 
                batch
            </span>
            <div class="batches-pagination">
                {{ $batches->links() }}
            </div>
        </div>

    </x-card>

    @push('modals')
    <!-- Modal Tambah/Edit Batch -->
    <x-modal name="add-batch-modal" focusable maxWidth="2xl">
        <form method="POST" :action="isEdit ? '{{ url('admin/batches') }}/' + batchId : '{{ route('admin.batches.store') }}'" 
              x-data="{ isEdit: {{ old('batchId') ? 'true' : 'false' }}, batch_name: '{{ old('batch_name') }}', description: '{{ old('description') }}', start_date: '{{ old('start_date') }}', end_date: '{{ old('end_date') }}', status: '{{ old('status', 'pendaftaran') }}', quota: '{{ old('quota') }}', spp_nominal: '{{ old('spp_nominal') }}', jadwal: '{{ old('jadwal', 'Senin - Kamis') }}', jam_mulai: '{{ old('jam_mulai') }}', jam_selesai: '{{ old('jam_selesai') }}', batchId: '{{ old('batchId') }}' }" 
              @open-add-batch-modal.window="isEdit = false; batch_name = ''; description = ''; start_date = ''; end_date = ''; status = 'pendaftaran'; quota = ''; spp_nominal = ''; jadwal = 'Senin - Kamis'; jam_mulai = ''; jam_selesai = ''; batchId = ''; $dispatch('open-modal', 'add-batch-modal')"
              @open-edit-batch-modal.window="isEdit = true; batch_name = $event.detail.batch.batch_name; description = $event.detail.batch.description; start_date = $event.detail.batch.start_date; end_date = $event.detail.batch.end_date; status = $event.detail.batch.status; quota = $event.detail.batch.quota; spp_nominal = $event.detail.batch.spp_nominal; jadwal = $event.detail.batch.jadwal; jam_mulai = $event.detail.batch.jam_mulai; jam_selesai = $event.detail.batch.jam_selesai; batchId = $event.detail.batch.id; $dispatch('open-modal', 'add-batch-modal')">
            @csrf
            
            <!-- Hidden inputs -->
            <input type="hidden" name="batchId" x-bind:value="batchId">
            <template x-if="isEdit">
                <input type="hidden" name="_method" value="PUT">
            </template>
            
            <!-- Header -->
            <div class="flex justify-between items-start mb-8">
                <div class="flex items-center gap-3">
                    <h2 class="text-[22px] font-bold text-slate-800" x-text="isEdit ? 'Edit Batch' : 'Tambah Batch Baru'">
                    </h2>
                </div>
                <button type="button" x-on:click="$dispatch('close')" class="w-8 h-8 flex items-center justify-center bg-red-100 text-red-500 hover:bg-red-200 rounded-full transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Form Body -->
            <div class="space-y-6">
                <!-- Batch Name -->
                <div>
                    <label for="batch_name" class="block text-[13px] font-bold text-slate-500 mb-2">Nama Batch:</label>
                    <input x-model="batch_name" id="batch_name" type="text" name="batch_name" required placeholder="e.g., Batch 3 - 2027" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow placeholder-slate-400">
                    @error('batch_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-[13px] font-bold text-slate-500 mb-2">Deskripsi (Opsional):</label>
                    <textarea x-model="description" id="description" name="description" rows="3" placeholder="Tuliskan deskripsi singkat..." class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow placeholder-slate-400"></textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="block text-[13px] font-bold text-slate-500 mb-2">Tanggal Mulai:</label>
                        <input x-model="start_date" id="start_date" type="date" name="start_date" required class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow">
                        @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_date" class="block text-[13px] font-bold text-slate-500 mb-2">Tanggal Selesai:</label>
                        <input x-model="end_date" id="end_date" type="date" name="end_date" required class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow">
                        @error('end_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Schedule -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label for="jadwal" class="block text-[13px] font-bold text-slate-500 mb-2">Hari Jadwal:</label>
                        <input x-model="jadwal" id="jadwal" type="text" name="jadwal" placeholder="Senin - Kamis" required class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow placeholder-slate-400">
                        @error('jadwal')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="jam_mulai" class="block text-[13px] font-bold text-slate-500 mb-2">Jam Mulai:</label>
                        <input x-model="jam_mulai" id="jam_mulai" type="time" name="jam_mulai" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow">
                        @error('jam_mulai')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="jam_selesai" class="block text-[13px] font-bold text-slate-500 mb-2">Jam Selesai:</label>
                        <input x-model="jam_selesai" id="jam_selesai" type="time" name="jam_selesai" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow">
                        @error('jam_selesai')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Status & Quota -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <label for="status" class="block text-[13px] font-bold text-slate-500 mb-2">Status Pendaftaran:</label>
                        <select x-model="status" id="status" name="status" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow">
                            <option value="pendaftaran">Pendaftaran Buka</option>
                            <option value="aktif">Sedang Berjalan</option>
                            <option value="selesai">Selesai</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="quota" class="block text-[13px] font-bold text-slate-500 mb-2">Maksimal Kuota Siswa:</label>
                        <input x-model="quota" id="quota" type="number" name="quota" placeholder="e.g., 30" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow placeholder-slate-400">
                        @error('quota')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="spp_nominal" class="block text-[13px] font-bold text-slate-500 mb-2">Nominal SPP (Rp):</label>
                        <input x-model="spp_nominal" id="spp_nominal" type="number" name="spp_nominal" placeholder="e.g., 500000" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow placeholder-slate-400">
                        @error('spp_nominal')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="mt-10 flex items-center gap-4">
                <button type="button" x-on:click="$dispatch('close')" class="w-[140px] py-3.5 rounded-2xl border-2 border-[#d62828] text-[#d62828] font-bold text-sm hover:bg-red-50 transition-colors focus:outline-none focus:ring-2 focus:ring-[#d62828]/20">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-3.5 rounded-2xl bg-[#d62828] hover:bg-red-700 text-white font-bold text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-[#d62828]/50 shadow-md hover:shadow-lg" x-text="isEdit ? 'Simpan Perubahan' : 'Buat Batch'">
                </button>
            </div>
        </form>
    </x-modal>

    <!-- Modal Konfirmasi Hapus -->
    <x-modal name="delete-batch-modal" focusable maxWidth="md">
        <form method="POST" :action="'{{ url('admin/batches') }}/' + deleteBatchId" x-data="{ deleteBatchId: '' }" @open-delete-batch-modal.window="deleteBatchId = $event.detail.id; $dispatch('open-modal', 'delete-batch-modal')">
            @csrf
            @method('DELETE')
            <div class="p-6">
                <div class="flex items-center justify-center w-14 h-14 mx-auto bg-red-100 rounded-full mb-5">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-center text-slate-800 mb-2">Hapus Batch?</h3>
                <p class="text-sm text-center text-slate-500 mb-8">Apakah Anda yakin ingin menghapus data batch ini? Data yang dihapus tidak dapat dikembalikan lagi.</p>
                
                <div class="flex items-center gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="flex-1 py-3.5 text-sm font-bold text-slate-700 bg-white border border-gray-200 rounded-2xl hover:bg-gray-50 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-200">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 py-3.5 text-sm font-bold text-white bg-[#d62828] hover:bg-red-700 rounded-2xl shadow-md hover:shadow-lg transition-colors focus:outline-none focus:ring-2 focus:ring-[#d62828]/50">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </form>
    </x-modal>

    @if ($errors->any())
        <div x-data x-init="$dispatch('open-modal', 'add-batch-modal')"></div>
    @endif

    @if (session('success'))
        <div x-data x-init="$dispatch('show-toast', { message: '{{ session('success') }}' })"></div>
    @endif
    @endpush
</div>
@endsection
