@extends('layouts.student')

@section('title', 'Profil - LPK Seishin')



@section('content')
<div class="p-4 sm:p-6 lg:p-10">
    
    <div class="mb-8 text-left">
        <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Profil</h1>
        <p class="text-sm text-[#666666] font-medium mt-2">Kelola informasi pribadi dan pengaturan akun Anda.</p>
    </div>
    
    <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] mb-6 flex flex-col sm:flex-row items-center sm:items-start gap-6 lg:gap-8 relative">
        
        <div class="relative flex-shrink-0 mt-2 sm:mt-0 group">
            <img src="{{ $userData->avatar_url }}" onerror="this.onerror=null; this.src='{{ $userData->fallback_avatar_url }}'" alt="Profile Picture" class="w-28 h-28 lg:w-32 lg:h-32 rounded-full object-cover shadow-sm border-4 border-white">
            <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data" class="absolute top-1 right-1 transform translate-x-1 -translate-y-1">
                @csrf
                <label for="photo-upload" class="w-8 h-8 bg-white border border-gray-100 text-[#d62828] rounded-full shadow-sm flex items-center justify-center hover:bg-gray-50 transition cursor-pointer" title="Ubah Foto Profil">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </label>
                <input id="photo-upload" type="file" name="photo" class="hidden" accept="image/*" onchange="this.form.submit()">
            </form>
        </div>

        <div class="flex-1 text-center sm:text-left space-y-2 lg:pt-2">
            <h2 class="text-3xl lg:text-[32px] font-bold text-[#222222] tracking-tight">{{ $userData->name }}</h2>
            
            <div class="text-[15px] font-bold text-[#666666] space-y-1.5 mx-auto sm:mx-0 w-fit sm:w-auto text-left">
                <div class="flex items-center">
                    <span class="w-14">ID</span>
                    <span class="w-6 text-center">:</span>
                    <span class="text-[#666666]">{{ $userData->id_number }}</span>
                </div>
                <div class="flex items-center">
                    <span class="w-14">Batch</span>
                    <span class="w-6 text-center">:</span>
                    <span class="text-[#444444]">{{ $userData->batch }}</span>
                </div>
            </div>
        </div>

        <div class="sm:absolute sm:right-8 sm:top-1/2 sm:-translate-y-1/2 mt-4 sm:mt-0">
            <span class="bg-[#d62828] text-white text-sm font-bold px-6 py-2.5 rounded-full shadow-sm">
                Level: {{ $userData->level }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
            <h3 class="text-lg font-bold text-[#222222] mb-6">Detail Pribadi</h3>

            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-green-50 text-green-700 border border-green-100">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('students.profile.update') }}" method="POST" class="flex flex-col justify-between">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="name" value="Nama Lengkap:" />
                        <x-text-input id="name" name="name" type="text" :value="old('name', $userData->name)" />
                    </div>
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="email" value="Email:" />
                        <x-text-input id="email" name="email" type="email" :value="old('email', $userData->email)" />
                    </div>
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="nomor_telepon" value="Nomor Telepon:" />
                        <x-text-input id="nomor_telepon" name="nomor_telepon" type="text" :value="old('nomor_telepon', $userData->nomor_telepon)" />
                    </div>
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="tanggal_lahir" value="Tanggal Lahir:" />
                        <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" :value="old('tanggal_lahir', $userData->tanggal_lahir)" />
                    </div>
                </div>

                <div class="flex justify-end">
                    <x-primary-button>
                        Simpan Perubahan
                    </x-primary-button>
                </div>
            </form>
        </div>

        <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col">
            <h3 class="text-lg font-bold text-[#222222] mb-6">Persyaratan LPK</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 flex-1">
                <div class="space-y-1.5 text-left">
                    <x-input-label value="Tingkat Pendidikan:" />
                    <div class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-2.5 text-sm font-bold text-[#444444] select-none cursor-not-allowed">
                        {{ $userData->education }}
                    </div>
                </div>
                <div class="space-y-1.5 text-left">
                    <x-input-label value="Tinggi / Berat Badan:" />
                    <div class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-2.5 text-sm font-bold text-[#444444] select-none cursor-not-allowed">
                        {{ $userData->height_weight }}
                    </div>
                </div>
                <div class="space-y-1.5 text-left">
                    <x-input-label value="Nama Kontak Darurat:" />
                    <div class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-2.5 text-sm font-bold text-[#444444] select-none cursor-not-allowed">
                        {{ $userData->emergency_name }}
                    </div>
                </div>
                <div class="space-y-1.5 text-left">
                    <x-input-label value="Telepon Kontak Darurat:" />
                    <div class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-2.5 text-sm font-bold text-[#444444] select-none cursor-not-allowed">
                        {{ $userData->emergency_phone }}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
        <h3 class="text-lg font-bold text-[#222222] mb-6">Ubah Kata Sandi</h3>

        @if(session('status') === 'password-updated')
            <div class="mb-6 p-4 rounded-2xl bg-green-50 text-green-700 border border-green-100">
                Kata sandi berhasil diperbarui.
            </div>
        @endif

        @if($errors->updatePassword->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 text-red-700 border border-red-100">
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    @foreach($errors->updatePassword->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5 items-end">
                <div class="space-y-1.5 text-left">
                    <x-input-label for="current_password" value="Kata Sandi Saat Ini" />
                    <x-text-input id="current_password" name="current_password" type="password" />
                </div>
                <div class="space-y-1.5 text-left">
                    <x-input-label for="password" value="Kata Sandi Baru" />
                    <x-text-input id="password" name="password" type="password" />
                </div>
                <div class="space-y-1.5 text-left">
                    <x-input-label for="password_confirmation" value="Konfirmasi Kata Sandi" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" />
                </div>
                <div>
                    <x-primary-button class="w-full">
                        Perbarui Kata Sandi
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection