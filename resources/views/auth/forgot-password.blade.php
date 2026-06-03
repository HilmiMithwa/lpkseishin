<x-guest-layout>
    <x-slot name="pageTitle">Lupa Password</x-slot>
    <x-slot name="title">Lupa Password?</x-slot>
    <x-slot name="subtitle">Masukkan email Anda dan kami akan mengirim link reset</x-slot>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <input 
                id="email" 
                class="block w-full px-4 py-3.5 rounded-xl text-sm focus:ring-2 focus:ring-red-500/20 focus:bg-white transition-all duration-200 placeholder-gray-400 border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50 focus:border-red-400' }}" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus
                placeholder="Alamat email"
            />
            @error('email')
                <p class="mt-1.5 text-xs text-red-500 flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button 
            type="submit"
            class="w-full bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 text-white font-semibold py-3.5 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-red-500/25 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 text-sm"
        >
            Kirim Link Reset
        </button>

        <!-- Back to Login -->
        <div class="text-center pt-2">
            <p class="text-sm text-gray-500">
                Ingat password Anda? 
                <a href="{{ route('login') }}" class="text-red-600 hover:text-red-700 font-semibold transition-colors">Kembali ke Login</a>
            </p>
        </div>
    </form>
</x-guest-layout>
