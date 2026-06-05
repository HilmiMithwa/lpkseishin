@extends('layouts.teacher')

@section('title', 'Profil Guru - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10">

    <div class="mb-8 text-left">
        <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Profil</h1>
        <p class="text-sm text-[#666666] font-medium mt-2">Kelola informasi pribadi dan pengaturan akun Anda.</p>
    </div>

    <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] mb-6 flex flex-col sm:flex-row items-center sm:items-start gap-6 lg:gap-8 relative">
        
        <div class="relative flex-shrink-0 mt-2 sm:mt-0">
            <img src="https://images.unsplash.com/photo-1544816155-12df9643f363?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80" alt="Profile Picture" class="w-28 h-28 lg:w-32 lg:h-32 rounded-full object-cover shadow-sm">
            <button class="absolute top-1 right-1 w-8 h-8 bg-white border border-gray-100 text-[#d62828] rounded-full shadow-sm flex items-center justify-center hover:bg-gray-50 transition transform translate-x-2 -translate-y-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </button>
        </div>

        <div class="flex-1 text-center sm:text-left space-y-2 lg:pt-2">
            <h2 class="text-3xl lg:text-[32px] font-bold text-[#222222] tracking-tight">{{ Auth::user()->name ?? 'Ahmad Hidayat' }}</h2>
            
            <div class="text-[15px] font-bold text-[#666666] space-y-1.5 mx-auto sm:mx-0 w-fit sm:w-auto text-left">
                <div class="flex items-center">
                    <span class="w-36">ID Sensei</span>
                    <span class="w-6 text-center">:</span>
                    <span class="text-[#666666]">022025005</span>
                </div>
                <div class="flex items-center">
                    <span class="w-36">Status</span>
                    <span class="w-6 text-center">:</span>
                    <span class="text-[#444444]">Aktif</span>
                </div>
                <div class="flex items-center">
                    <span class="w-36">Tanggal Bergabung</span>
                    <span class="w-6 text-center">:</span>
                    <span class="text-[#444444]">23 Januari 2024</span>
                </div>
            </div>
        </div>

        <div class="sm:absolute sm:right-8 sm:top-1/2 sm:-translate-y-1/2 mt-4 sm:mt-0">
            <span class="bg-[#d62828] text-white text-sm font-bold px-6 py-2.5 rounded-full shadow-sm">
                Level: JLPT N2
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col">
            <h3 class="text-lg font-bold text-[#222222] mb-6">Detail Pribadi</h3>

            <form action="#" method="POST" class="flex flex-col justify-between flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="name" value="Nama Lengkap:" />
                        <x-text-input id="name" name="name" type="text" :value="Auth::user()->name ?? 'Ahmad Hidayat'" />
                    </div>
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="email" value="Email:" />
                        <x-text-input id="email" name="email" type="email" :value="Auth::user()->email ?? 'madd.hdyt@gmail.com'" />
                    </div>
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="phone" value="Nomor Telepon:" />
                        <x-text-input id="phone" name="phone" type="text" value="+62 0831 9210 3301" />
                    </div>
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="dob" value="Tanggal Lahir:" />
                        <x-text-input id="dob" name="dob" type="text" value="04 Juli 2004" />
                    </div>
                </div>

                <div class="flex justify-end mt-auto">
                    <x-primary-button type="button">
                        Simpan Perubahan
                    </x-primary-button>
                </div>
            </form>
        </div>

        <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col">
            <h3 class="text-lg font-bold text-[#222222] mb-6">Batch yang Ditugaskan</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 flex-1 content-start">
                @foreach(['Batch 1', 'Batch 2', 'Batch 3', 'Batch 4', 'Batch 6'] as $batch)
                <a href="#" class="flex items-center justify-between p-4 border border-gray-100 rounded-[16px] hover:border-[#d62828] hover:shadow-sm transition-all group">
                    <span class="font-bold text-[#222222] text-sm">{{ $batch }}</span>
                    <div class="w-6 h-6 bg-[#d62828] text-white rounded-md flex items-center justify-center shadow-sm group-hover:-translate-y-0.5 transition-transform">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

    </div>

    <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
        <h3 class="text-lg font-bold text-[#222222] mb-6">Ubah Kata Sandi</h3>

        <form action="#" method="POST">
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
                    <x-primary-button type="button" class="w-full">
                        Perbarui Kata Sandi
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
