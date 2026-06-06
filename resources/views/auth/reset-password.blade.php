<x-guest-layout>
    <x-slot name="title">Reset Password</x-slot>
    <x-slot name="subtitle">Buat password baru untuk akun Anda</x-slot>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <div class="space-y-1.5">
                <x-input-label for="email">Email</x-input-label>
                <x-text-input 
                    id="email" 
                    class="block w-full {{ $errors->has('email') ? '!border-red-400 !bg-red-50' : '' }}" 
                    type="email" 
                    name="email" 
                    :value="old('email', $request->email)" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="nama@email.com"
                />
            </div>
            @error('email')
                <p class="mt-1.5 text-sm text-red-500 flex items-center">
                    <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="space-y-1.5">
                <x-input-label for="password">Password Baru</x-input-label>
                <x-text-input 
                    id="password" 
                    class="block w-full {{ $errors->has('password') ? '!border-red-400 !bg-red-50' : '' }}"
                    type="password"
                    name="password"
                    required 
                    autocomplete="new-password"
                    placeholder="Buat password baru"
                />
            </div>
            @error('password')
                <p class="mt-1.5 text-sm text-red-500 flex items-center">
                    <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <div class="space-y-1.5">
                <x-input-label for="password_confirmation">Konfirmasi Password</x-input-label>
                <x-text-input 
                    id="password_confirmation" 
                    class="block w-full {{ $errors->has('password_confirmation') ? '!border-red-400 !bg-red-50' : '' }}"
                    type="password"
                    name="password_confirmation"
                    required 
                    autocomplete="new-password"
                    placeholder="Ulangi password baru"
                />
            </div>
            @error('password_confirmation')
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
            Reset Password
        </x-primary-button>
    </form>
</x-guest-layout>
