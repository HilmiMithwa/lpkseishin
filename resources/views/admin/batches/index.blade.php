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
            <div class="flex gap-2 w-full sm:w-auto">
                <select class="border border-gray-200 text-slate-600 rounded-xl px-4 py-2 text-sm font-medium focus:ring-[#d62828]/20 focus:border-[#d62828] outline-none">
                    <option value="">Semua Status</option>
                    <option value="pendaftaran">Pendaftaran Buka</option>
                    <option value="aktif">Sedang Berjalan</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>

            <!-- Search Bar -->
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition-all sm:text-sm font-medium text-slate-800" placeholder="Cari batch...">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-slate-500 font-bold">
                        <th class="px-6 py-4 rounded-tl-xl">Info Batch</th>
                        <th class="px-6 py-4">Periode</th>
                        <th class="px-6 py-4">Kuota / Siswa</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70">
                    <!-- Row 1 Mock Data -->
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-bold text-slate-800">Batch 1 - Gelombang Pertama</p>
                                <p class="text-xs font-medium text-slate-500 mt-0.5">Program Dasar & Intensif</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-700">Jan 2026 - Jun 2026</p>
                            <p class="text-[11px] font-medium text-slate-500 mt-0.5">6 Bulan</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-full bg-slate-100 rounded-full h-1.5 max-w-[80px]">
                                    <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 100%"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-600">30/30</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-red-50 text-[#d62828] border border-red-100">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#d62828]"></span> Sedang Berjalan
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center" x-data>
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button x-on:click="$dispatch('open-edit-batch-modal', { batch: { batch_name: 'Batch 1 - Gelombang Pertama', description: 'Program Dasar & Intensif', start_date: '2026-01-01', end_date: '2026-06-30', status: 'aktif', quota: '30' } })" class="p-1.5 text-slate-400 hover:text-[#d62828] bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-rose-50 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button x-on:click="$dispatch('open-modal', 'delete-batch-modal')" class="p-1.5 text-slate-400 hover:text-rose-600 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-rose-50 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 2 Mock Data -->
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div>
                                <p class="text-sm font-bold text-slate-800">Batch 2 - Gelombang Kedua</p>
                                <p class="text-xs font-medium text-slate-500 mt-0.5">Program Persiapan JLPT</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-700">Jul 2026 - Des 2026</p>
                            <p class="text-[11px] font-medium text-slate-500 mt-0.5">6 Bulan</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-full bg-slate-100 rounded-full h-1.5 max-w-[80px]">
                                    <div class="bg-[#d62828] h-1.5 rounded-full" style="width: 40%"></div>
                                </div>
                                <span class="text-xs font-bold text-slate-600">12/30</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> Pendaftaran Buka
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center" x-data>
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button x-on:click="$dispatch('open-edit-batch-modal', { batch: { batch_name: 'Batch 2 - Gelombang Kedua', description: 'Program Persiapan JLPT', start_date: '2026-07-01', end_date: '2026-12-31', status: 'pendaftaran', quota: '30' } })" class="p-1.5 text-slate-400 hover:text-[#d62828] bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-rose-50 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button x-on:click="$dispatch('open-modal', 'delete-batch-modal')" class="p-1.5 text-slate-400 hover:text-rose-600 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-rose-50 transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Placeholder -->
        <div class="p-4 border-t border-gray-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between text-sm gap-3">
            <span class="font-medium text-slate-500">Menampilkan <span class="font-bold text-slate-800">2</span> dari <span class="font-bold text-slate-800">2</span> batch</span>
            <div class="flex gap-1">
                <button disabled class="p-1.5 rounded-lg border border-gray-200 bg-white text-gray-400 opacity-50 cursor-not-allowed"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg></button>
                <button disabled class="p-1.5 rounded-lg border border-gray-200 bg-white text-gray-400 opacity-50 cursor-not-allowed"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></button>
            </div>
        </div>

    </x-card>

    @push('modals')
    <!-- Modal Tambah/Edit Batch -->
    <x-modal name="add-batch-modal" focusable maxWidth="2xl">
        <form method="POST" action="#" 
              x-data="{ isEdit: false, batch_name: '', description: '', start_date: '', end_date: '', status: 'pendaftaran', quota: '' }" 
              @open-add-batch-modal.window="isEdit = false; batch_name = ''; description = ''; start_date = ''; end_date = ''; status = 'pendaftaran'; quota = ''; $dispatch('open-modal', 'add-batch-modal')"
              @open-edit-batch-modal.window="isEdit = true; batch_name = $event.detail.batch.batch_name; description = $event.detail.batch.description; start_date = $event.detail.batch.start_date; end_date = $event.detail.batch.end_date; status = $event.detail.batch.status; quota = $event.detail.batch.quota; $dispatch('open-modal', 'add-batch-modal')"
              x-on:submit.prevent="$dispatch('close'); $dispatch('show-toast', { message: isEdit ? 'Perubahan batch berhasil disimpan!' : 'Data batch berhasil disimpan!' })">
            @csrf
            
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
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-[13px] font-bold text-slate-500 mb-2">Deskripsi (Opsional):</label>
                    <textarea x-model="description" id="description" name="description" rows="3" placeholder="Tuliskan deskripsi singkat..." class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow placeholder-slate-400"></textarea>
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="block text-[13px] font-bold text-slate-500 mb-2">Tanggal Mulai:</label>
                        <input x-model="start_date" id="start_date" type="date" name="start_date" required class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow">
                    </div>
                    <div>
                        <label for="end_date" class="block text-[13px] font-bold text-slate-500 mb-2">Tanggal Selesai:</label>
                        <input x-model="end_date" id="end_date" type="date" name="end_date" required class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow">
                    </div>
                </div>
                
                <!-- Status & Quota -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-[13px] font-bold text-slate-500 mb-2">Status Pendaftaran:</label>
                        <select x-model="status" id="status" name="status" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow">
                            <option value="pendaftaran">Pendaftaran Buka</option>
                            <option value="aktif">Sedang Berjalan</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>
                    <div>
                        <label for="quota" class="block text-[13px] font-bold text-slate-500 mb-2">Maksimal Kuota Siswa:</label>
                        <input x-model="quota" id="quota" type="number" name="quota" placeholder="e.g., 30" class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-2xl focus:ring-[#d62828] focus:border-[#d62828] p-3.5 transition-shadow placeholder-slate-400">
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
                <button type="button" x-on:click="$dispatch('close'); setTimeout(() => $dispatch('show-toast', { message: 'Batch berhasil dihapus!' }), 300)" class="flex-1 py-3.5 text-sm font-bold text-white bg-[#d62828] hover:bg-red-700 rounded-2xl shadow-md hover:shadow-lg transition-colors focus:outline-none focus:ring-2 focus:ring-[#d62828]/50">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </x-modal>
    @endpush
</div>
@endsection
