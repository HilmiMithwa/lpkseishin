<x-guest-layout>
    <x-slot name="pageTitle">Login</x-slot>
    <x-slot name="title">Welcome Back!</x-slot>
    <x-slot name="subtitle">Masuk ke akun Anda untuk melanjutkan</x-slot>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-5 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-text-input 
                id="email" 
                class="block w-full py-3.5 bg-gray-50 focus:bg-white placeholder-gray-400 {{ $errors->has('email') ? '!border-red-400 !bg-red-50' : '' }}" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
                autocomplete="username"
                placeholder="Alamat email"
            />
            @error('email')
                <p class="mt-1.5 text-xs text-red-500 flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div class="relative">
            <x-text-input 
                id="password" 
                class="block w-full py-3.5 pr-12 bg-gray-50 focus:bg-white placeholder-gray-400 {{ $errors->has('password') ? '!border-red-400 !bg-red-50' : '' }}"
                type="password"
                name="password"
                required 
                autocomplete="current-password"
                placeholder="Password"
            />
            <button 
                type="button" 
                onclick="const p = document.getElementById('password'); p.type = p.type === 'password' ? 'text' : 'password'; this.querySelector('.eye-open').classList.toggle('hidden'); this.querySelector('.eye-closed').classList.toggle('hidden');"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors"
            >
                <svg class="w-5 h-5 eye-open" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <svg class="w-5 h-5 eye-closed hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
            </button>
            @error('password')
                <p class="mt-1.5 text-xs text-red-500 flex items-center">
                    <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center cursor-pointer select-none">
                <input 
                    id="remember_me" 
                    type="checkbox" 
                    class="w-4 h-4 text-red-600 bg-red-600 border-gray-300 rounded focus:ring-2 focus:ring-red-500/20 cursor-pointer checked:bg-red-600" 
                    name="remember"
                >
                <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a 
                    href="{{ route('password.request') }}" 
                    class="text-sm text-gray-600 hover:text-red-600 font-medium transition-colors"
                >
                    Lupa Password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <x-primary-button 
            type="submit"
            class="w-full justify-center py-3.5"
        >
            Masuk
        </x-primary-button>

        <!-- Register Link -->
        <div class="text-center pt-2">
            <p class="text-sm text-gray-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-red-600 hover:text-red-700 font-semibold transition-colors">Daftar</a>
            </p>
        </div>
    </form>
</x-guest-layout>
