@extends('layouts.admin')

@section('title', 'Profil Admin - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10">

    <div class="mb-8 text-left">
        <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Profil</h1>
        <p class="text-sm text-[#666666] font-medium mt-2">Kelola informasi pribadi dan pengaturan akun administrator Anda.</p>
    </div>

    <!-- Banner Profil -->
    <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] mb-6 flex flex-col sm:flex-row items-center sm:items-start gap-6 lg:gap-8 relative">
        
        <div class="relative flex-shrink-0 mt-2 sm:mt-0">
            <img src="https://ui-avatars.com/api/?name=Admin+Sistem&background=f3f4f6&color=d62828&bold=true" alt="Profile Picture" class="w-28 h-28 lg:w-32 lg:h-32 rounded-full object-cover shadow-sm border-4 border-white">
            <button class="absolute top-1 right-1 w-8 h-8 bg-white border border-gray-100 text-[#d62828] rounded-full shadow-sm flex items-center justify-center hover:bg-gray-50 transition transform translate-x-2 -translate-y-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </button>
        </div>

        <div class="flex-1 text-center sm:text-left space-y-2 lg:pt-2">
            <h2 class="text-3xl lg:text-[32px] font-bold text-[#222222] tracking-tight">{{ Auth::user()->name ?? 'Admin Sistem LPK' }}</h2>
            
            <div class="text-[15px] font-bold text-[#666666] space-y-1.5 mx-auto sm:mx-0 w-fit sm:w-auto text-left">
                <div class="flex items-center">
                    <span class="w-36">ID Admin</span>
                    <span class="w-6 text-center">:</span>
                    <span class="text-[#666666]">ADM-001</span>
                </div>
                <div class="flex items-center">
                    <span class="w-36">Status</span>
                    <span class="w-6 text-center">:</span>
                    <span class="text-[#444444]">Aktif</span>
                </div>
                <div class="flex items-center">
                    <span class="w-36">Hak Akses</span>
                    <span class="w-6 text-center">:</span>
                    <span class="text-[#444444]">Super Admin</span>
                </div>
            </div>
        </div>

        <div class="sm:absolute sm:right-8 sm:top-1/2 sm:-translate-y-1/2 mt-4 sm:mt-0">
            <span class="bg-[#d62828] text-white text-sm font-bold px-6 py-2.5 rounded-full shadow-sm">
                Administrator
            </span>
        </div>
    </div>

    <!-- Konten Bawah -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Detail Pribadi -->
        <div class="lg:col-span-2 bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col" x-data="{ isEditing: false }" x-on:submit.prevent="isEditing = false; setTimeout(() => $dispatch('show-toast', { message: 'Profil berhasil diperbarui!' }), 300)">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-[#222222]">Detail Pribadi</h3>
                <button type="button" x-show="!isEditing" @click="isEditing = true" class="text-sm font-bold text-[#d62828] hover:underline">
                    Edit Profil
                </button>
                <button type="button" x-show="isEditing" @click="isEditing = false" class="text-sm font-bold text-slate-500 hover:text-slate-700 hover:underline" style="display: none;">
                    Batal Edit
                </button>
            </div>

            <form action="#" method="POST" class="flex flex-col justify-between flex-1">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="name" value="Nama Lengkap:" />
                        <x-text-input id="name" name="name" type="text" :value="Auth::user()->name ?? 'Admin Sistem LPK'" x-bind:disabled="!isEditing" x-bind:class="!isEditing ? 'bg-slate-50 text-slate-500 cursor-not-allowed border-gray-200' : ''" />
                    </div>
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="email" value="Email:" />
                        <x-text-input id="email" name="email" type="email" :value="Auth::user()->email ?? 'admin@lpkseishin.com'" x-bind:disabled="!isEditing" x-bind:class="!isEditing ? 'bg-slate-50 text-slate-500 cursor-not-allowed border-gray-200' : ''" />
                    </div>
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="phone" value="Nomor Telepon:" />
                        <x-text-input id="phone" name="phone" type="text" value="+62 0812 3456 7890" x-bind:disabled="!isEditing" x-bind:class="!isEditing ? 'bg-slate-50 text-slate-500 cursor-not-allowed border-gray-200' : ''" />
                    </div>
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="dob" value="Lokasi Kantor:" />
                        <x-text-input id="dob" name="dob" type="text" value="Gedung Utama Lt. 2" x-bind:disabled="!isEditing" x-bind:class="!isEditing ? 'bg-slate-50 text-slate-500 cursor-not-allowed border-gray-200' : ''" />
                    </div>
                </div>

                <div class="flex justify-end mt-auto" x-show="isEditing" style="display: none;" x-transition>
                    <x-primary-button type="submit">
                        Simpan Perubahan
                    </x-primary-button>
                </div>
            </form>
        </div>

        <!-- Ubah Kata Sandi -->
        <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] flex flex-col">
            <h3 class="text-lg font-bold text-[#222222] mb-6">Ubah Kata Sandi</h3>
            
            <form action="#" method="POST" class="flex flex-col flex-1" x-data x-on:submit.prevent="setTimeout(() => { $dispatch('show-toast', { message: 'Kata sandi berhasil diubah!' }); $event.target.reset(); }, 300)">
                <div class="space-y-5 mb-8">
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="current_password" value="Kata Sandi Saat Ini" />
                        <x-text-input id="current_password" name="current_password" type="password" required />
                    </div>
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="new_password" value="Kata Sandi Baru" />
                        <x-text-input id="new_password" name="new_password" type="password" required />
                    </div>
                    <div class="space-y-1.5 text-left">
                        <x-input-label for="new_password_confirmation" value="Konfirmasi Kata Sandi" />
                        <x-text-input id="new_password_confirmation" name="new_password_confirmation" type="password" required />
                    </div>
                </div>

                <div class="flex justify-end mt-auto">
                    <x-primary-button type="submit" class="w-full justify-center">
                        Perbarui Kata Sandi
                    </x-primary-button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
