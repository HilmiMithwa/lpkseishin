@extends('layouts.student')

@section('title', 'Profil - LPK Seishin')



@section('content')
<div class="p-4 sm:p-6 lg:p-10">
    
    <div class="mb-6 text-left">
        <h1 class="text-xl sm:text-2xl lg:text-[28px] font-bold font-ibm text-[#222222] tracking-tight mb-1">Profil</h1>
        <p class="text-sm text-[#666666] font-medium">Kelola informasi pribadi dan pengaturan akun Anda.</p>
    </div>
    
    <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] mb-6 flex flex-col sm:flex-row items-center sm:items-start gap-6 lg:gap-8 relative">
        
        <div class="relative flex-shrink-0 mt-2 sm:mt-0">
            <img src="{{ $userData->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($userData->name) . '&background=f3f4f6&color=d62828&bold=true' }}" alt="Profile Picture" class="w-28 h-28 lg:w-32 lg:h-32 rounded-full object-cover shadow-sm">
            <button class="absolute top-1 right-1 w-8 h-8 bg-white border border-gray-100 text-[#d62828] rounded-full shadow-sm flex items-center justify-center hover:bg-gray-50 transition transform translate-x-2 -translate-y-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </button>
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
                        <label class="text-sm font-bold text-[#666666]">Nama Lengkap:</label>
                        <input type="text" name="name" value="{{ old('name', $userData->name) }}" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#222222] focus:outline-none focus:border-[#d62828] transition">
                    </div>
                    <div class="space-y-1.5 text-left">
                        <label class="text-sm font-bold text-[#666666]">Email:</label>
                        <input type="email" name="email" value="{{ old('email', $userData->email) }}" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#222222] focus:outline-none focus:border-[#d62828] transition">
                    </div>
                    <div class="space-y-1.5 text-left">
                        <label class="text-sm font-bold text-[#666666]">Nomor Telepon:</label>
                        <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $userData->nomor_telepon) }}" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#222222] focus:outline-none focus:border-[#d62828] transition">
                    </div>
                    <div class="space-y-1.5 text-left">
                        <label class="text-sm font-bold text-[#666666]">Tanggal Lahir:</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $userData->tanggal_lahir) }}" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#222222] focus:outline-none focus:border-[#d62828] transition">
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col">
            <h3 class="text-lg font-bold text-[#222222] mb-6">Persyaratan LPK</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 flex-1">
                <div class="space-y-1.5 text-left">
                    <label class="text-sm font-bold text-[#666666]">Tingkat Pendidikan:</label>
                    <div class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-2.5 text-sm font-bold text-[#444444] select-none cursor-not-allowed">
                        {{ $userData->education }}
                    </div>
                </div>
                <div class="space-y-1.5 text-left">
                    <label class="text-sm font-bold text-[#666666]">Tinggi / Berat Badan:</label>
                    <div class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-2.5 text-sm font-bold text-[#444444] select-none cursor-not-allowed">
                        {{ $userData->height_weight }}
                    </div>
                </div>
                <div class="space-y-1.5 text-left">
                    <label class="text-sm font-bold text-[#666666]">Nama Kontak Darurat:</label>
                    <div class="w-full bg-gray-100 border border-transparent rounded-xl px-4 py-2.5 text-sm font-bold text-[#444444] select-none cursor-not-allowed">
                        {{ $userData->emergency_name }}
                    </div>
                </div>
                <div class="space-y-1.5 text-left">
                    <label class="text-sm font-bold text-[#666666]">Telepon Kontak Darurat:</label>
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
                    <label class="text-sm font-bold text-[#666666]">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#222222] focus:outline-none focus:border-[#d62828] transition">
                </div>
                <div class="space-y-1.5 text-left">
                    <label class="text-sm font-bold text-[#666666]">Kata Sandi Baru</label>
                    <input type="password" name="password" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#222222] focus:outline-none focus:border-[#d62828] transition">
                </div>
                <div class="space-y-1.5 text-left">
                    <label class="text-sm font-bold text-[#666666]">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-[#222222] focus:outline-none focus:border-[#d62828] transition">
                </div>
                <div>
                    <button type="submit" class="w-full bg-[#d62828] hover:bg-red-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition shadow-sm">
                        Perbarui Kata Sandi
                    </button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection