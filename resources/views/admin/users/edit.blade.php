@extends('layouts.admin')

@section('title', 'Edit User - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10" x-data="{ tab: 'pribadi' }">

    <!-- Header & Breadcrumbs -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-3">
            <a href="{{ route('admin.users') }}" class="w-11 h-11 flex items-center justify-center bg-white border border-gray-200 rounded-full hover:bg-gray-50 transition-colors text-slate-500 hover:text-slate-700 shadow-sm" title="Kembali">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="text-2xl sm:text-[28px] lg:text-[32px] font-bold font-ibm text-[#0f172a] tracking-tight">Edit Siswa</h1>
        </div>
        <nav class="flex text-[15px] font-medium" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.users') }}" class="text-slate-500 hover:text-slate-700 transition-colors">Data Siswa</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-slate-300 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        <span class="text-[#d62828] ml-1">Edit Siswa</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Top Banner Card -->
    <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] mb-8 flex flex-col sm:flex-row items-center sm:items-start gap-6 lg:gap-8 relative">
        <div class="relative flex-shrink-0 mt-2 sm:mt-0">
            <img src="https://ui-avatars.com/api/?name=Ahmad+Hidayat&background=f3f4f6&color=d62828&bold=true" class="w-28 h-28 lg:w-32 lg:h-32 rounded-full object-cover shadow-sm border-4 border-white">
        </div>
        
        <div class="flex-1 text-center sm:text-left space-y-2 lg:pt-2 w-full">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                <div>
                    <h2 class="text-3xl lg:text-[32px] font-bold text-[#222222] tracking-tight">Ahmad Hidayat</h2>
                    
                    <div class="text-[15px] font-bold text-[#666666] space-y-1.5 mx-auto sm:mx-0 w-fit sm:w-auto text-left mt-3">
                        <div class="flex items-center">
                            <span class="w-24">ID</span>
                            <span class="w-6 text-center">:</span>
                            <span class="text-[#666666]">022025005</span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-24">Batch</span>
                            <span class="w-6 text-center">:</span>
                            <span class="text-[#444444]">Batch 5</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex flex-col items-center sm:items-end gap-3 mt-2 sm:mt-0">
                    <span class="bg-[#d62828] text-white text-sm font-bold px-6 py-2.5 rounded-full shadow-sm">
                        Level: Pra-N5
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="flex items-center flex-wrap gap-x-8 gap-y-0 border-b border-gray-200 mb-8">
        <button @click="tab = 'pribadi'" :class="tab === 'pribadi' ? 'border-[#d62828] text-[#d62828]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap pb-3 font-bold text-[15px] border-b-2 transition-colors -mb-px">
            Informasi Pribadi
        </button>
        <button @click="tab = 'akademik'" :class="tab === 'akademik' ? 'border-[#d62828] text-[#d62828]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap pb-3 font-bold text-[15px] border-b-2 transition-colors -mb-px">
            Akademik
        </button>
        <button @click="tab = 'pembayaran'" :class="tab === 'pembayaran' ? 'border-[#d62828] text-[#d62828]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap pb-3 font-bold text-[15px] border-b-2 transition-colors -mb-px">
            Pembayaran
        </button>
    </div>

    <!-- Tab Content: Informasi Pribadi -->
    <div x-show="tab === 'pribadi'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
        <form action="#" method="POST" x-data x-on:submit.prevent="setTimeout(() => $dispatch('show-toast', { message: 'Profil berhasil diperbarui!' }), 300)">
            <div class="space-y-6">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                    <!-- Personal Details Card -->
                    <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
                        <h3 class="text-lg font-bold text-[#222222] mb-6">Detail Pribadi</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="space-y-1.5 text-left">
                                <x-input-label for="name" value="Nama Lengkap:" />
                                <x-text-input id="name" name="name" type="text" value="Ahmad Hidayat" />
                            </div>
                            <div class="space-y-1.5 text-left">
                                <x-input-label for="email" value="Email:" />
                                <x-text-input id="email" name="email" type="email" value="madd.hdyt@gmail.com" />
                            </div>
                            <div class="space-y-1.5 text-left">
                                <x-input-label for="phone" value="Nomor Telepon:" />
                                <x-text-input id="phone" name="phone" type="text" value="+62 0831 9210 3301" />
                            </div>
                            <div class="space-y-1.5 text-left">
                                <x-input-label for="dob" value="Tanggal Lahir:" />
                                <x-text-input id="dob" name="dob" type="text" value="04 July 2004" />
                            </div>
                        </div>
                    </div>

                    <!-- LPK Requirements Card -->
                    <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
                        <h3 class="text-lg font-bold text-[#222222] mb-6">Persyaratan LPK</h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="space-y-1.5 text-left">
                                <x-input-label for="education" value="Tingkat Pendidikan:" />
                                <x-text-input id="education" name="education" type="text" value="SMA/SMK" />
                            </div>
                            <div class="space-y-1.5 text-left">
                                <x-input-label for="hw" value="Tinggi / Berat Badan:" />
                                <x-text-input id="hw" name="hw" type="text" value="160 cm / 59 kg" />
                            </div>
                            <div class="space-y-1.5 text-left">
                                <x-input-label for="em_name" value="Nama Kontak Darurat:" />
                                <x-text-input id="em_name" name="em_name" type="text" value="Muria Mardika" />
                            </div>
                            <div class="space-y-1.5 text-left">
                                <x-input-label for="em_phone" value="Nomor Kontak Darurat:" />
                                <x-text-input id="em_phone" name="em_phone" type="text" value="+62 0831 9210 3302" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Change Password Card -->
                <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
                    <h3 class="text-lg font-bold text-[#222222] mb-6">Ubah Kata Sandi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div class="space-y-1.5 text-left">
                            <x-input-label for="current_password" value="Kata Sandi Saat Ini:" />
                            <x-text-input id="current_password" name="current_password" type="password" />
                        </div>
                        <div class="space-y-1.5 text-left">
                            <x-input-label for="new_password" value="Kata Sandi Baru:" />
                            <x-text-input id="new_password" name="new_password" type="password" />
                        </div>
                        <div class="space-y-1.5 text-left">
                            <x-input-label for="confirm_password" value="Konfirmasi Kata Sandi:" />
                            <x-text-input id="confirm_password" name="confirm_password" type="password" />
                        </div>
                    </div>
                </div>

                <!-- Global Action Buttons -->
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('admin.users') }}" class="px-6 py-3 rounded-2xl border border-gray-200 bg-white text-gray-600 font-bold text-sm hover:bg-gray-50 transition-colors shadow-sm">
                        Batal
                    </a>
                    <button type="submit" class="bg-[#d62828] text-white font-bold text-sm px-6 py-3 rounded-2xl hover:bg-[#b01e1e] transition-colors shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>
                
            </div>
        </form>
    </div>
    
    <!-- Tab Content: Akademik -->
    <div x-show="tab === 'akademik'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
        <form action="#" method="POST" x-data x-on:submit.prevent="setTimeout(() => $dispatch('show-toast', { message: 'Data akademik berhasil diperbarui!' }), 300)">
            <div class="space-y-6">
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                    <!-- Program & Penempatan Card -->
                    <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
                        <h3 class="text-lg font-bold text-[#222222] mb-6">Program & Penempatan</h3>
                        
                        <div class="space-y-6">
                            <div class="space-y-1.5 text-left">
                                <label class="block text-[13px] font-bold text-slate-500">Program Penyaluran:</label>
                                <div class="relative" x-data="{ open: false, selected: 'Tokutei Ginou (SSW)', options: ['Tokutei Ginou (SSW)', 'Magang (Ginou Jisshusei)', 'Engineering'] }" @click.outside="open = false">
                                    <button type="button" @click="open = !open" class="w-full bg-white border border-gray-200 text-slate-700 text-[14.5px] font-medium rounded-[20px] p-4 flex justify-between items-center transition-shadow focus:border-[#d62828] outline-none">
                                        <span x-text="selected"></span>
                                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" x-transition.opacity.duration.200ms class="absolute z-10 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-lg py-1.5 overflow-hidden" style="display: none;">
                                        <template x-for="option in options">
                                            <button type="button" @click="selected = option; open = false" class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors" :class="selected === option ? 'text-[#d62828] font-bold bg-rose-50/50' : 'text-slate-600 font-medium'">
                                                <span x-text="option"></span>
                                            </button>
                                        </template>
                                    </div>
                                    <input type="hidden" name="program" :value="selected">
                                </div>
                            </div>

                            <div class="space-y-1.5 text-left">
                                <label class="block text-[13px] font-bold text-slate-500">Pilih Batch:</label>
                                <div class="relative" x-data="{ open: false, selected: 'Batch 5', options: ['Batch 5', 'Batch 6', 'Batch 7'] }" @click.outside="open = false">
                                    <button type="button" @click="open = !open" class="w-full bg-white border border-gray-200 text-slate-700 text-[14.5px] font-medium rounded-[20px] p-4 flex justify-between items-center transition-shadow focus:border-[#d62828] outline-none">
                                        <span x-text="selected"></span>
                                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" x-transition.opacity.duration.200ms class="absolute z-10 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-lg py-1.5 overflow-hidden" style="display: none;">
                                        <template x-for="option in options">
                                            <button type="button" @click="selected = option; open = false" class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors" :class="selected === option ? 'text-[#d62828] font-bold bg-rose-50/50' : 'text-slate-600 font-medium'">
                                                <span x-text="option"></span>
                                            </button>
                                        </template>
                                    </div>
                                    <input type="hidden" name="batch" :value="selected">
                                </div>
                            </div>
                            
                            <div class="space-y-1.5 text-left">
                                <label class="block text-[13px] font-bold text-slate-500">Tanggal Masuk LPK:</label>
                                <input type="date" value="2026-01-15" class="w-full bg-white border border-gray-200 text-slate-700 text-[14.5px] font-medium rounded-[20px] p-4 focus:border-[#d62828] focus:ring-[#d62828] focus:ring-1 outline-none transition-shadow">
                            </div>
                        </div>
                    </div>

                    <!-- Status Card -->
                    <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
                        <h3 class="text-lg font-bold text-[#222222] mb-6">Status</h3>
                        
                        <div class="space-y-6">
                            <div class="space-y-1.5 text-left">
                                <label class="block text-[13px] font-bold text-slate-500">Status Keaktifan:</label>
                                <div class="relative" x-data="{ open: false, selected: 'Aktif', options: ['Aktif', 'Tidak Aktif'] }" @click.outside="open = false">
                                    <button type="button" @click="open = !open" :class="selected === 'Aktif' ? 'bg-green-100 text-green-700 focus:ring-green-600/30' : 'bg-rose-100 text-rose-700 focus:ring-rose-600/30'" class="w-full font-bold border-none text-[14.5px] rounded-[20px] p-4 flex justify-between items-center transition-colors focus:ring-2 outline-none">
                                        <span x-text="selected"></span>
                                        <svg class="w-4 h-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" x-transition.opacity.duration.200ms class="absolute z-10 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-lg py-1.5 overflow-hidden" style="display: none;">
                                        <template x-for="option in options">
                                            <button type="button" @click="selected = option; open = false" class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors" :class="selected === option ? 'text-green-600 font-bold bg-green-50/50' : 'text-slate-600 font-medium'">
                                                <span x-text="option"></span>
                                            </button>
                                        </template>
                                    </div>
                                    <input type="hidden" name="status_keaktifan" :value="selected">
                                </div>
                            </div>
                            <div class="space-y-1.5 text-left">
                                <label class="block text-[13px] font-bold text-slate-500">Level:</label>
                                <div class="relative" x-data="{ open: false, selected: 'Pra-N5', options: ['Pra-N5', 'N5', 'N4'] }" @click.outside="open = false">
                                    <button type="button" @click="open = !open" class="w-full bg-white border border-gray-200 text-slate-700 text-[14.5px] font-medium rounded-[20px] p-4 flex justify-between items-center transition-shadow focus:border-[#d62828] outline-none">
                                        <span x-text="selected"></span>
                                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" x-transition.opacity.duration.200ms class="absolute z-10 w-full mt-2 bg-white border border-gray-100 rounded-2xl shadow-lg py-1.5 overflow-hidden" style="display: none;">
                                        <template x-for="option in options">
                                            <button type="button" @click="selected = option; open = false" class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 transition-colors" :class="selected === option ? 'text-[#d62828] font-bold bg-rose-50/50' : 'text-slate-600 font-medium'">
                                                <span x-text="option"></span>
                                            </button>
                                        </template>
                                    </div>
                                    <input type="hidden" name="level" :value="selected">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Global Action Buttons -->
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('admin.users') }}" class="px-6 py-3 rounded-2xl border border-gray-200 bg-white text-gray-600 font-bold text-sm hover:bg-gray-50 transition-colors shadow-sm">
                        Batal
                    </a>
                    <button type="submit" class="bg-[#d62828] text-white font-bold text-sm px-6 py-3 rounded-2xl hover:bg-[#b01e1e] transition-colors shadow-sm">
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </form>
    </div>

    <!-- Tab Content Placeholder: Pembayaran -->
    <div x-show="tab === 'pembayaran'" style="display: none;">
        <div class="bg-white border border-gray-100 rounded-[32px] p-6 lg:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] text-center text-slate-500 py-16">
            Riwayat pembayaran siswa akan ditampilkan di sini.
        </div>
    </div>

</div>
@endsection
