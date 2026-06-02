@extends('layouts.student')

@section('title', 'Pembayaran - LPK Seishin')

@php
    // 🌟 FRONTEND STATE: Data Dummy Payment
    $isFullyPaid = false; // Ubah ke true untuk melihat state "Semua Tagihan Sudah Lunas!"

    // Data Tagihan Aktif
    $activeBill = (object) [
        'total' => 'Rp 1.299.000',
        'due_date' => '31 Mei 2026',
        'description' => 'Total Tagihan SPP Mei 2026'
    ];

    // Data Riwayat Transaksi
    $paymentHistory = [
        (object)['period' => 'Mei 2026', 'date' => '10 Apr 2026', 'no_trans' => 'SSN26042101', 'amount' => 'Rp 2.500.000', 'status' => 'Berhasil'],
        (object)['period' => 'Juni 2026', 'date' => '15 Mei 2026', 'no_trans' => 'SSN26051502', 'amount' => 'Rp 3.750.000', 'status' => 'Tertunda'],
        (object)['period' => 'Juli 2026', 'date' => '20 Jun 2026', 'no_trans' => 'SSN26062003', 'amount' => 'Rp 1.200.000', 'status' => 'Gagal'],
        (object)['period' => 'Agustus 2026', 'date' => '05 Jul 2026', 'no_trans' => 'SSN26070504', 'amount' => 'Rp 4.000.000', 'status' => 'Berhasil'],
        (object)['period' => 'September 2026', 'date' => '12 Agu 2026', 'no_trans' => 'SSN26081205', 'amount' => 'Rp 2.850.000', 'status' => 'Berhasil'],
        (object)['period' => 'Oktober 2026', 'date' => '22 Sep 2026', 'no_trans' => 'SSN26092206', 'amount' => 'Rp 3.100.000', 'status' => 'Tertunda'],
    ];

    $userName = Auth::user() ? Auth::user()->name : 'Ahmad Hidayat';
    $userLevel = Auth::user() && isset(Auth::user()->level) ? Auth::user()->level : 'Level Pra-N5';
@endphp

@section('content')
<div class="p-6 lg:p-10">
    
    <div class="mb-6 text-left">
        <h1 class="text-xl sm:text-2xl lg:text-[28px] font-bold font-ibm text-[#222222] tracking-tight mb-1">Pembayaran</h1>
        <p class="text-sm text-[#666666] font-medium">Kelola tagihan SPP, metode pembayaran, dan riwayat transaksi.</p>
    </div>

    @if(!$isFullyPaid)
        <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] mb-10 flex flex-col gap-4 lg:gap-6">
            
            <div class="flex justify-between items-center w-full">
                <h3 class="text-sm font-black text-[#444444]">Ringkasan Tagihan</h3>
                <span class="text-sm font-black text-[#d62828]">Jatuh Tempo: {{ $activeBill->due_date }}</span>
            </div>
            
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 w-full">
                <div class="text-left">
                    <h2 class="text-3xl lg:text-[32px] font-black text-[#222222] tracking-tight">Total Tagihan: {{ $activeBill->total }}</h2>
                    <p class="text-sm font-semibold text-[#666666] mt-1">{{ $activeBill->description }}</p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">
                    <button class="bg-white border border-gray-200 text-[#444444] hover:bg-gray-50 font-bold py-3 px-6 rounded-xl text-sm transition flex items-center justify-center gap-2 shadow-sm">
                        <svg class="w-5 h-5 text-[#d62828]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                        Unduh Faktur
                    </button>
                    <button class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-3 px-8 rounded-xl text-sm transition shadow-sm">
                        Bayar Sekarang
                    </button>
                </div>
            </div>

        </div>
    @else
    <div class="bg-white border border-gray-100 rounded-[32px] p-10 lg:p-14 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] mb-10 flex flex-col items-center justify-center text-center">
            <div class="w-20 h-20 mb-6 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-[0_8px_16px_rgba(34,197,94,0.3)]">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h2 class="text-2xl font-black text-[#222222] mb-2">Semua Tagihan Sudah Lunas!</h2>
            <p class="text-sm font-medium text-[#666666]">Terima kasih, pembayaran SPP {{ explode(' ', $userName)[0] }} sudah diperbarui.</p>
        </div>
    @endif

    <div class="text-left">
        <div class="flex items-center gap-2 mb-6">
            <div class="w-1 h-5 bg-[#d62828] rounded-full"></div>
            <h3 class="text-lg font-black text-[#222222]">Riwayat Pembayaran</h3>
        </div>

        <div class="overflow-x-auto bg-white border border-gray-100 rounded-3xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)]">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-[#F9FAFB] border-b border-gray-100">
                        <th class="py-4 px-6 text-sm font-bold text-[#444444]">Periode/Bulan</th>
                        <th class="py-4 px-6 text-sm font-bold text-[#444444]">Tanggal Pembayaran</th>
                        <th class="py-4 px-6 text-sm font-bold text-[#444444]">No. Transaksi</th>
                        <th class="py-4 px-6 text-sm font-bold text-[#444444]">Jumlah</th>
                        <th class="py-4 px-6 text-sm font-bold text-[#444444]">Status</th>
                        <th class="py-4 px-6 text-sm font-bold text-[#444444]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($paymentHistory as $history)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="py-4 px-6 text-sm font-medium text-[#666666]">{{ $history->period }}</td>
                            <td class="py-4 px-6 text-sm font-medium text-[#666666]">{{ $history->date }}</td>
                            <td class="py-4 px-6 text-sm font-medium text-[#666666]">{{ $history->no_trans }}</td>
                            <td class="py-4 px-6 text-sm font-medium text-[#666666]">{{ $history->amount }}</td>
                            
                            <td class="py-4 px-6">
                                <span class="px-3 py-1 text-xs font-bold rounded-md 
                                    {{ match($history->status) {
                                        'Berhasil' => 'bg-green-100 text-green-700',
                                        'Tertunda' => 'bg-orange-100 text-orange-500',
                                        'Gagal' => 'bg-red-100 text-red-600',
                                        default => 'bg-gray-100 text-gray-600'
                                    } }}">
                                    {{ $history->status }}
                                </span>
                            </td>
                            
                            <td class="py-4 px-6">
                                @if($history->status === 'Berhasil')
                                    <button class="flex items-center gap-2 text-xs font-bold text-[#d62828] hover:text-red-700 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path></svg>
                                        Unduh Bukti
                                    </button>
                                @else
                                    <span class="text-gray-400 font-bold ml-4">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection