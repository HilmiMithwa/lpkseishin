<x-guest-layout>
    <x-slot name="title">Konfirmasi Password</x-slot>
    <x-slot name="subtitle">Masukkan password Anda untuk melanjutkan</x-slot>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-800 mb-1.5">Password</label>
            <input 
                id="password" 
                class="block w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all duration-200 placeholder-gray-400 @error('password') border-red-400 bg-red-50 @enderror"
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="Masukkan password Anda"
            />
            @error('password')
                <p class="mt-1.5 text-sm text-red-500 flex items-center">
                    <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button 
            type="submit"
            class="w-full bg-gradient-to-r from-red-700 to-red-600 hover:from-red-800 hover:to-red-700 text-white font-semibold py-3 rounded-xl transition-all duration-200 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 text-sm"
        >
            Konfirmasi
        </button>
    </form>
</x-guest-layout>
