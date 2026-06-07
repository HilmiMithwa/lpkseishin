@extends('layouts.student')

@section('title', 'Pembayaran - LPK Seishin')

@php
    $userName = Auth::user() ? Auth::user()->name : 'Siswa';
@endphp

@section('content')
<div class="p-6 lg:p-10" x-data="{ showPaymentModal: false }">
    
    <div class="mb-8 text-left">
        <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Pembayaran</h1>
        <p class="text-sm text-[#666666] font-medium mt-2">Kelola tagihan, upload bukti pembayaran manual, dan riwayat transaksi.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] mb-10 flex flex-col gap-4 lg:gap-6">
        
        <div class="flex justify-between items-center w-full">
            <h3 class="text-sm font-bold text-[#444444]">Ringkasan Tagihan</h3>
            <span class="text-sm font-bold text-[#d62828]">Jatuh Tempo: {{ $activeBill->due_date }}</span>
        </div>
        
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 w-full">
            <div class="text-left">
                @if($isFullyPaid)
                    <h2 class="text-3xl lg:text-[32px] font-bold text-emerald-600 tracking-tight">SPP bulan ini sudah lunas</h2>
                    <p class="text-sm font-semibold text-[#666666] mt-1">Terima kasih atas pembayaran Anda.</p>
                @else
                    <h2 class="text-3xl lg:text-[32px] font-bold text-[#222222] tracking-tight">Total Estimasi: Rp {{ number_format($activeBill->total, 0, ',', '.') }}</h2>
                    <p class="text-sm font-semibold text-[#666666] mt-1">{{ $activeBill->description }}</p>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                @if(!$isFullyPaid)
                <a href="{{ route('students.invoice') }}" target="_blank" class="bg-white border border-gray-200 text-[#444444] hover:bg-gray-50 font-bold py-3 px-6 rounded-xl text-sm transition flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-5 h-5 text-[#d62828]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                    Unduh Invoice
                </a>
                @endif
                <button @click="showPaymentModal = true" class="bg-[#d62828] text-white hover:bg-[#b01e1e] font-bold py-3 px-8 rounded-xl text-sm transition shadow-sm">
                    Bayar Manual
                </button>
            </div>
        </div>
    </div>

    <div class="text-left">
        <div class="flex items-center gap-2 mb-6">
            <div class="w-1 h-5 bg-[#d62828] rounded-full"></div>
            <h3 class="text-lg font-bold text-[#222222]">Riwayat Pembayaran</h3>
        </div>

        <div class="overflow-x-auto bg-white border border-gray-100 rounded-3xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)]">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-[#F9FAFB] border-b border-gray-100">
                        <th class="py-4 px-6 text-sm font-bold text-[#222222]">Tanggal</th>
                        <th class="py-4 px-6 text-sm font-bold text-[#222222]">Untuk</th>
                        <th class="py-4 px-6 text-sm font-bold text-[#222222]">Jumlah</th>
                        <th class="py-4 px-6 text-sm font-bold text-[#222222]">Metode</th>
                        <th class="py-4 px-6 text-sm font-bold text-[#222222]">Status</th>
                        <th class="py-4 px-6 text-sm font-bold text-[#222222]">Catatan Admin</th>
                        <th class="py-4 px-6 text-sm font-bold text-[#222222] text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-4 px-6 text-sm font-semibold text-[#666666]">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                            <td class="py-4 px-6 text-sm font-semibold text-[#444444]">{{ $payment->payment_for }} <br> <span class="text-xs text-gray-500">{{ optional($payment->batch)->nama }}</span></td>
                            <td class="py-4 px-6 text-sm font-bold text-[#444444]">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-sm font-medium text-[#666666]">{{ $payment->payment_method }}</td>
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 text-xs font-bold rounded-full 
                                    {{ match($payment->status) {
                                        'lunas' => 'bg-green-100 text-green-700',
                                        'menunggu' => 'bg-amber-100 text-amber-600',
                                        'ditolak' => 'bg-red-100 text-red-600',
                                        default => 'bg-gray-100 text-gray-600'
                                    } }}">
                                    {{ strtoupper($payment->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-xs text-gray-500 max-w-[200px] truncate">
                                {{ $payment->admin_note ?? '-' }}
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($payment->status === 'lunas')
                                    <a href="{{ route('students.invoice.history', $payment->id) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-[#d62828] bg-red-50 border border-red-100 rounded-lg shadow-sm hover:bg-[#d62828] hover:text-white transition" title="Unduh Invoice">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Invoice
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">Belum ada riwayat pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Form Pembayaran -->
    <div x-show="showPaymentModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            
            <div x-show="showPaymentModal" x-transition.opacity class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" @click="showPaymentModal = false"></div>

            <div x-show="showPaymentModal" x-transition class="inline-block w-full max-w-2xl p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white shadow-xl rounded-3xl">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Upload Bukti Pembayaran Manual</h3>
                    <button @click="showPaymentModal = false" class="text-gray-400 hover:text-gray-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('students.payment.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="payment_for" value="Tujuan Pembayaran" />
                            <select name="payment_for" id="payment_for" required class="mt-1 block w-full border-gray-300 focus:border-[#d62828] focus:ring-[#d62828] rounded-md shadow-sm">
                                <option value="">Pilih Tujuan...</option>
                                <option value="Pendaftaran">Biaya Pendaftaran</option>
                                <option value="Biaya Pendidikan">Biaya Pendidikan (SPP)</option>
                                <option value="Buku/Modul">Buku / Modul</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="id_batch" value="Batch (Jika Berlaku)" />
                            <select name="id_batch" id="id_batch" class="mt-1 block w-full border-gray-300 focus:border-[#d62828] focus:ring-[#d62828] rounded-md shadow-sm">
                                <option value="">Tidak Spesifik Batch</option>
                                @foreach($batches as $batch)
                                    <option value="{{ $batch->id_batch }}">{{ $batch->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="amount" value="Nominal Pembayaran (Rp)" />
                            <x-text-input id="amount" name="amount" type="number" required class="mt-1 block w-full" placeholder="Contoh: 1500000" />
                        </div>
                        <div>
                            <x-input-label for="payment_method" value="Metode" />
                            <select name="payment_method" id="payment_method" required class="mt-1 block w-full border-gray-300 focus:border-[#d62828] focus:ring-[#d62828] rounded-md shadow-sm">
                                <option value="Transfer Bank BCA">Transfer Bank BCA</option>
                                <option value="Transfer Bank Mandiri">Transfer Bank Mandiri</option>
                                <option value="Transfer Bank BRI">Transfer Bank BRI</option>
                                <option value="Tunai (Di Kantor)">Tunai (Di Kantor)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="payment_date" value="Tanggal Pembayaran" />
                        <x-text-input id="payment_date" name="payment_date" type="date" required class="mt-1 block w-full" value="{{ date('Y-m-d') }}" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Keterangan Tambahan (Opsional)" />
                        <textarea id="description" name="description" rows="2" class="mt-1 block w-full border-gray-300 focus:border-[#d62828] focus:ring-[#d62828] rounded-md shadow-sm" placeholder="Catatan untuk admin..."></textarea>
                    </div>

                    <div>
                        <x-input-label for="proof_image" value="Upload Bukti Pembayaran (JPG/PNG)" />
                        <input type="file" id="proof_image" name="proof_image" required accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-[#d62828] hover:file:bg-red-100">
                    </div>

                    <div class="mt-6 flex justify-end gap-3 pt-4 border-t">
                        <button type="button" @click="showPaymentModal = false" class="px-4 py-2 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 font-bold text-sm">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-[#d62828] text-white rounded-xl hover:bg-[#b01e1e] font-bold text-sm shadow-sm">Kirim Bukti Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection