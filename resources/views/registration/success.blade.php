@extends('registration.layout')

@section('title', 'Pendaftaran Berhasil - LPK Seishin')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-green-50 to-white flex items-center justify-center py-12 px-4">
    <div class="text-center max-w-xl">
        <!-- Success Icon -->
        <div class="mb-6 flex justify-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center animate-pulse">
                <svg class="w-10 h-10 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>

        <!-- Success Message -->
        <h1 class="text-3xl font-bold font-ibm text-[#222222] mb-2">Pendaftaran Berhasil!</h1>
        <p class="text-[#666666] text-lg mb-8">Terima kasih telah mendaftar di LPK Seishin. Kami akan segera memverifikasi data Anda.</p>

        <!-- Registration Info -->
        <div class="bg-white border-2 border-green-200 rounded-2xl p-8 mb-8 text-left">
            <h3 class="text-base font-bold font-ibm text-[#222222] mb-4">Informasi Pendaftaran</h3>
            
            <div class="space-y-3">
                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                    <span class="text-sm font-semibold text-[#666666]">ID Pendaftaran</span>
                    <span class="text-sm font-bold text-[#222222]">{{ $registration->id }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                    <span class="text-sm font-semibold text-[#666666]">Nama</span>
                    <span class="text-sm font-bold text-[#222222]">{{ $registration->full_name }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-200">
                    <span class="text-sm font-semibold text-[#666666]">Status</span>
                    <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-800 text-xs font-bold rounded-full">Menunggu Verifikasi</span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm font-semibold text-[#666666]">Tanggal Pendaftaran</span>
                    <span class="text-sm font-bold text-[#222222]">{{ $registration->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mb-8 text-left">
            <h3 class="text-base font-bold font-ibm text-blue-900 mb-4">Langkah Selanjutnya</h3>
            
            <ol class="space-y-3 text-sm text-blue-800">
                <li class="flex gap-3">
                    <span class="flex-shrink-0 flex items-center justify-center w-6 h-6 bg-blue-600 text-white rounded-full text-xs font-bold">1</span>
                    <span>Kami akan memverifikasi dokumen Anda dalam 1-3 hari kerja</span>
                </li>
                <li class="flex gap-3">
                    <span class="flex-shrink-0 flex items-center justify-center w-6 h-6 bg-blue-600 text-white rounded-full text-xs font-bold">2</span>
                    <span>Anda akan menerima notifikasi melalui WhatsApp {{ $registration->whatsapp_number }}</span>
                </li>
                <li class="flex gap-3">
                    <span class="flex-shrink-0 flex items-center justify-center w-6 h-6 bg-blue-600 text-white rounded-full text-xs font-bold">3</span>
                    <span>Jika diterima, Anda akan mendapatkan akses ke portal pembelajaran</span>
                </li>
            </ol>
        </div>

        <!-- Contact Info -->
        <div class="bg-red-50 border border-red-200 rounded-2xl p-6 mb-8">
            <p class="text-sm text-[#666666] mb-3">Ada pertanyaan? Hubungi kami:</p>
            <a href="https://wa.me/62xxxx" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 bg-[#d62828] text-white font-bold rounded-xl hover:bg-red-700 transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-5.031 1.378c-3.055 2.316-4.753 5.75-4.753 9.426 0 1.925.464 3.783 1.348 5.472L2.75 21.25l5.375-1.389c1.573.857 3.355 1.312 5.195 1.312 5.516 0 10-4.486 10-9.999 0-2.65-.994-5.153-2.807-7.003-1.815-1.849-4.249-2.868-6.736-2.868l-.006.001z"/>
                </svg>
                Chat di WhatsApp
            </a>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4">
            <a href="/" class="flex-1 px-6 py-3 border-2 border-[#d62828] text-[#d62828] font-bold rounded-xl hover:bg-red-50 transition">
                Kembali ke Beranda
            </a>
            <button type="button" onclick="window.print()" class="flex-1 px-6 py-3 bg-[#d62828] text-white font-bold rounded-xl hover:bg-red-700 transition">
                Cetak Bukti Pendaftaran
            </button>
        </div>
    </div>
</div>
@endsection
