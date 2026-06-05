<x-guest-layout>
    <x-slot name="title">Konfirmasi Password</x-slot>
    <x-slot name="subtitle">Masukkan password Anda untuk melanjutkan</x-slot>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div>
            <div class="space-y-1.5">
                <x-input-label for="password">Password</x-input-label>
                <x-text-input 
                    id="password" 
                    class="block w-full {{ $errors->has('password') ? '!border-red-400 !bg-red-50' : '' }}"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password"
                    placeholder="Masukkan password Anda"
                />
            </div>
            @error('password')
                <p class="mt-1.5 text-sm text-red-500 flex items-center">
                    <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Submit Button -->
        <x-primary-button 
            type="submit"
            class="w-full justify-center"
        >
            Konfirmasi
        </x-primary-button>
    </form>
</x-guest-layout>
