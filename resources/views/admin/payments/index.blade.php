@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran - LPK Seishin')

@section('content')
<div class="p-6 lg:p-8 space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-[32px] font-bold text-slate-800 leading-tight">Manajemen Pembayaran</h1>
            <p class="text-[15px] font-semibold text-slate-500 mt-1">Kelola verifikasi pembayaran pendaftaran dan biaya pendidikan siswa.</p>
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
                    <option value="menunggu">Menunggu Verifikasi</option>
                    <option value="lunas">Lunas</option>
                    <option value="ditolak">Ditolak</option>
                </select>
                <select class="border border-gray-200 text-slate-600 rounded-xl px-4 py-2 text-sm font-medium focus:ring-[#d62828]/20 focus:border-[#d62828] outline-none">
                    <option value="">Semua Batch</option>
                    <option value="batch1">Batch 1</option>
                    <option value="batch2">Batch 2</option>
                </select>
            </div>

            <!-- Search Bar -->
            <div class="relative w-full sm:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-xl leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition-all sm:text-sm font-medium text-slate-800" placeholder="Cari siswa...">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-gray-100 text-[11px] uppercase tracking-wider text-slate-500 font-bold">
                        <th class="px-6 py-4 rounded-tl-xl">Info Siswa & Batch</th>
                        <th class="px-6 py-4">Tgl. Pembayaran</th>
                        <th class="px-6 py-4">Nominal</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100/70">
                    @forelse($payments as $payment)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-[#d62828] font-bold">
                                    {{ strtoupper(substr($payment->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $payment->user->name }}</p>
                                    <p class="text-xs font-medium text-slate-500 mt-0.5">
                                        {{ $payment->payment_for }}
                                        @if($payment->batch) - {{ $payment->batch->nama }} @endif
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</p>
                            <p class="text-[11px] font-medium text-slate-500 mt-0.5">{{ $payment->payment_method }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-slate-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold 
                                {{ match($payment->status) {
                                    'lunas' => 'bg-emerald-50 text-emerald-600 border border-emerald-100',
                                    'menunggu' => 'bg-amber-50 text-amber-600 border border-amber-100',
                                    'ditolak' => 'bg-red-50 text-red-600 border border-red-100',
                                    default => 'bg-gray-50 text-gray-600 border border-gray-200'
                                } }}">
                                <span class="w-1.5 h-1.5 rounded-full 
                                    {{ match($payment->status) {
                                        'lunas' => 'bg-emerald-500',
                                        'menunggu' => 'bg-amber-500',
                                        'ditolak' => 'bg-red-500',
                                        default => 'bg-gray-500'
                                    } }}"></span> 
                                {{ strtoupper($payment->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center" x-data>
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button x-on:click="$dispatch('open-verify-modal', { payment: { id: '{{ $payment->id }}', name: '{{ addslashes($payment->user->name) }}', batch: '{{ addslashes($payment->payment_for) }} {{ $payment->batch ? '- ' . addslashes($payment->batch->nama) : '' }}', date: '{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}', method: '{{ addslashes($payment->payment_method) }}', amount: 'Rp {{ number_format($payment->amount, 0, ',', '.') }}', status: '{{ $payment->status }}', proof_url: '{{ Storage::disk('s3')->url($payment->proof_path) }}', description: '{{ addslashes($payment->description ?? '-') }}' } })" class="px-3 py-1.5 text-xs font-bold shadow-sm transition rounded-lg 
                                    {{ $payment->status === 'menunggu' ? 'text-[#d62828] bg-red-50 border border-red-100 hover:bg-[#d62828] hover:text-white' : 'text-slate-600 bg-white border border-gray-200 hover:bg-slate-50' }}" 
                                    title="{{ $payment->status === 'menunggu' ? 'Verifikasi' : 'Lihat Detail' }}">
                                    {{ $payment->status === 'menunggu' ? 'Verifikasi' : 'Detail' }}
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500 font-medium">Belum ada data pembayaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-4 border-t border-gray-100 bg-slate-50/50">
            {{ $payments->links() }}
        </div>

    </x-card>

    @push('modals')
    <!-- Modal Verifikasi Pembayaran -->
    <x-modal name="verify-payment-modal" focusable maxWidth="xl">
        <div class="p-0 overflow-hidden" 
             x-data="{ id: '', name: '', batch: '', date: '', method: '', amount: '', status: '', proof_url: '', description: '' }"
             @open-verify-modal.window="
                id = $event.detail.payment.id;
                name = $event.detail.payment.name; 
                batch = $event.detail.payment.batch; 
                date = $event.detail.payment.date; 
                method = $event.detail.payment.method; 
                amount = $event.detail.payment.amount; 
                status = $event.detail.payment.status; 
                proof_url = $event.detail.payment.proof_url;
                description = $event.detail.payment.description;
                $dispatch('open-modal', 'verify-payment-modal')">
            
            <!-- Header Modal -->
            <div class="bg-slate-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-800">Detail Pembayaran</h3>
                <button type="button" x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form :action="'{{ url('admin/payments') }}/' + id + '/verify'" method="POST">
                @csrf
                <div class="p-6 space-y-6">
                    <!-- Status Badge -->
                    <div class="flex justify-center">
                        <span x-show="status === 'menunggu'" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-amber-50 text-amber-600 border border-amber-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu Verifikasi
                        </span>
                        <span x-show="status === 'lunas'" style="display: none;" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Lunas / Terverifikasi
                        </span>
                        <span x-show="status === 'ditolak'" style="display: none;" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Ditolak
                        </span>
                    </div>

                    <!-- Detail Info -->
                    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden text-sm">
                        <div class="grid grid-cols-3 p-4 border-b border-gray-100">
                            <span class="font-bold text-slate-500">Nama Siswa</span>
                            <span class="col-span-2 font-semibold text-slate-800" x-text="name"></span>
                        </div>
                        <div class="grid grid-cols-3 p-4 border-b border-gray-100 bg-slate-50/50">
                            <span class="font-bold text-slate-500">Untuk</span>
                            <span class="col-span-2 font-semibold text-slate-800" x-text="batch"></span>
                        </div>
                        <div class="grid grid-cols-3 p-4 border-b border-gray-100">
                            <span class="font-bold text-slate-500">Metode</span>
                            <span class="col-span-2 font-semibold text-slate-800" x-text="method"></span>
                        </div>
                        <div class="grid grid-cols-3 p-4 border-b border-gray-100 bg-slate-50/50">
                            <span class="font-bold text-slate-500">Tanggal</span>
                            <span class="col-span-2 font-semibold text-slate-800" x-text="date"></span>
                        </div>
                        <div class="grid grid-cols-3 p-4 border-b border-gray-100">
                            <span class="font-bold text-slate-500">Keterangan</span>
                            <span class="col-span-2 font-semibold text-slate-800" x-text="description"></span>
                        </div>
                        <div class="grid grid-cols-3 p-4">
                            <span class="font-bold text-slate-500">Nominal</span>
                            <span class="col-span-2 font-bold text-[#d62828] text-base" x-text="amount"></span>
                        </div>
                    </div>

                    <!-- Bukti Pembayaran -->
                    <div>
                        <p class="text-[13px] font-bold text-slate-500 mb-2">Bukti Pembayaran:</p>
                        <a :href="proof_url" target="_blank" class="block w-full bg-slate-100 rounded-2xl border border-gray-200 overflow-hidden hover:opacity-90 transition-opacity">
                            <img :src="proof_url" alt="Bukti Pembayaran" class="w-full h-auto max-h-64 object-contain">
                        </a>
                        <p class="text-xs text-slate-400 mt-2 text-center">Klik gambar untuk melihat ukuran penuh</p>
                    </div>

                    <!-- Catatan Penolakan -->
                    <div x-data="{ showCatatan: false }" x-show="status === 'menunggu'" class="pt-2">
                        <button type="button" @click="showCatatan = !showCatatan" class="text-xs font-bold text-red-500 hover:text-red-700 underline" x-show="!showCatatan">
                            + Tambahkan catatan (jika menolak)
                        </button>
                        <div x-show="showCatatan" x-collapse>
                            <label class="block text-[13px] font-bold text-slate-500 mb-2">Catatan Penolakan:</label>
                            <textarea name="admin_note" rows="2" placeholder="Tuliskan alasan kenapa pembayaran ditolak..." class="w-full bg-white border border-gray-200 text-slate-700 text-sm rounded-xl focus:ring-red-500 focus:border-red-500 p-3 transition-shadow"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="px-6 py-5 bg-slate-50 border-t border-gray-100 flex items-center justify-end gap-3" x-show="status === 'menunggu'">
                    <button type="submit" name="status" value="ditolak" class="px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-slate-700 font-bold text-sm hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-colors focus:outline-none">
                        Tolak Pembayaran
                    </button>
                    <button type="submit" name="status" value="lunas" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500/50 shadow-md">
                        Verifikasi (Lunas)
                    </button>
                </div>
                <div class="px-6 py-5 bg-slate-50 border-t border-gray-100 flex items-center justify-end gap-3" x-show="status !== 'menunggu'" style="display: none;">
                    <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 rounded-xl border border-gray-200 bg-white text-slate-700 font-bold text-sm hover:bg-gray-50 transition-colors focus:outline-none">
                        Tutup
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
    @endpush
</div>
@endsection
