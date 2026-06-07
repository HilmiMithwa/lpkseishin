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
        <div class="bg-red-50 border border-red-200 rounded-2xl p-6 mb-8 flex flex-col sm:flex-row items-center justify-between text-left gap-4">
            <div>
                <h3 class="text-base font-bold font-ibm text-red-900 mb-1">Butuh Bantuan?</h3>
                <p class="text-sm text-red-800">Hubungi admin kami jika Anda memiliki pertanyaan.</p>
            </div>
            <a href="https://wa.me/6281222130032" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 bg-[#d62828] text-white font-bold rounded-xl hover:bg-red-700 transition flex-shrink-0 shadow-sm">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.588-5.946 0-6.556 5.332-11.888 11.888-11.888 3.176 0 6.161 1.237 8.404 3.48s3.481 5.229 3.481 8.405c0 6.555-5.332 11.89-11.888 11.89-2.014 0-3.991-.511-5.741-1.482l-6.243 1.636zm6.323-3.61c1.558.924 3.125 1.411 4.757 1.411 5.424 0 9.841-4.415 9.841-9.84 0-5.424-4.417-9.84-9.841-9.84-5.424 0-9.84 4.416-9.84 9.84 0 2.001.602 3.864 1.741 5.437l-1.011 3.693 3.791-1.127zm10.741-7.07c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.966-.941 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                </svg>
                Chat WhatsApp
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
