<x-guest-layout>
    <x-slot name="title">Verifikasi Email</x-slot>
    <x-slot name="subtitle">Satu langkah lagi sebelum memulai</x-slot>

    <div class="space-y-5">
        <p class="text-sm text-gray-600 leading-relaxed">
            Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik link yang baru saja kami kirim. Jika tidak menerima email, kami akan dengan senang hati mengirimkan yang baru.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">
                Link verifikasi baru telah dikirim ke alamat email yang Anda gunakan saat mendaftar.
            </div>
        @endif

        <div class="flex items-center justify-between gap-4 pt-2">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button 
                    type="submit"
                    class="bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 text-sm"
                >
                    Kirim Ulang Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button 
                    type="submit" 
                    class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors"
                >
                    Keluar
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
