@extends('layouts.admin')

@section('title', 'Manajemen Program - LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl sm:text-[28px] lg:text-[32px] font-bold font-ibm text-[#0f172a] tracking-tight mb-2">Manajemen Program</h1>
            <p class="text-slate-500 text-[15px] font-medium">Kelola daftar program penyaluran yang tersedia di LPK.</p>
        </div>
        
        <button class="bg-[#d62828] text-white font-bold text-sm px-6 py-3 rounded-2xl hover:bg-[#b01e1e] transition-colors shadow-sm flex items-center gap-2 whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Program Baru
        </button>
    </div>

    <!-- Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Card 1: Tokutei Ginou -->
        <div class="bg-white border border-gray-100 rounded-[32px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] transition-shadow duration-300 flex flex-col h-full relative overflow-hidden group">
            <!-- Decorative Background Element -->
            <div class="absolute -right-12 -top-12 w-40 h-40 bg-rose-50 rounded-full blur-3xl opacity-50 group-hover:bg-rose-100 transition-colors"></div>
            
            <div class="relative z-10 flex flex-col h-full">
                <div class="flex justify-between items-start mb-5">
                    <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-[#d62828] border border-rose-100 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="bg-green-100 text-green-700 text-[11px] font-bold px-3 py-1 rounded-full border border-green-200">Aktif</span>
                </div>
                
                <h3 class="text-xl font-bold text-[#0f172a] mb-2 tracking-tight">Tokutei Ginou (SSW)</h3>
                <p class="text-slate-500 text-[13.5px] leading-relaxed mb-6 flex-grow">
                    Program penyaluran tenaga kerja terampil (Specified Skilled Worker) ke Jepang dengan standar kelulusan minimal N4.
                </p>
                
                <div class="bg-slate-50 rounded-2xl p-4 mb-6 border border-slate-100/60">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-slate-500 text-[13px] font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Batch Aktif
                        </span>
                        <span class="font-bold text-[#0f172a] text-[14px]">3 Batch</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-[13px] font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Total Siswa
                        </span>
                        <span class="font-bold text-[#0f172a] text-[14px]">45 Siswa</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 mt-auto pt-2">
                    <button class="flex-1 bg-white border border-slate-200 text-slate-700 font-bold text-[13px] py-2.5 rounded-[16px] hover:bg-slate-50 hover:border-slate-300 transition-colors shadow-sm">
                        Edit Detail
                    </button>
                    <button class="w-11 h-11 flex items-center justify-center bg-white border border-rose-200 text-rose-500 rounded-[16px] hover:bg-rose-50 transition-colors shadow-sm" title="Nonaktifkan Program">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Card 2: Magang -->
        <div class="bg-white border border-gray-100 rounded-[32px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] transition-shadow duration-300 flex flex-col h-full relative overflow-hidden group">
            <div class="absolute -right-12 -top-12 w-40 h-40 bg-blue-50 rounded-full blur-3xl opacity-50 group-hover:bg-blue-100 transition-colors"></div>
            
            <div class="relative z-10 flex flex-col h-full">
                <div class="flex justify-between items-start mb-5">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-600 border border-slate-200 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="bg-green-100 text-green-700 text-[11px] font-bold px-3 py-1 rounded-full border border-green-200">Aktif</span>
                </div>
                
                <h3 class="text-xl font-bold text-[#0f172a] mb-2 tracking-tight">Magang (Ginou Jisshusei)</h3>
                <p class="text-slate-500 text-[13.5px] leading-relaxed mb-6 flex-grow">
                    Program pelatihan kerja (magang) sambil praktik kerja industri di perusahaan Jepang dengan durasi kontrak 3 tahun.
                </p>
                
                <div class="bg-slate-50 rounded-2xl p-4 mb-6 border border-slate-100/60">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-slate-500 text-[13px] font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Batch Aktif
                        </span>
                        <span class="font-bold text-[#0f172a] text-[14px]">0 Batch</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-[13px] font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Total Siswa
                        </span>
                        <span class="font-bold text-[#0f172a] text-[14px]">0 Siswa</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 mt-auto pt-2">
                    <button class="flex-1 bg-white border border-slate-200 text-slate-700 font-bold text-[13px] py-2.5 rounded-[16px] hover:bg-slate-50 hover:border-slate-300 transition-colors shadow-sm">
                        Edit Detail
                    </button>
                    <button class="w-11 h-11 flex items-center justify-center bg-white border border-rose-200 text-rose-500 rounded-[16px] hover:bg-rose-50 transition-colors shadow-sm" title="Nonaktifkan Program">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Card 3: Engineering -->
        <div class="bg-white border border-gray-100 rounded-[32px] p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_8px_30px_-4px_rgba(0,0,0,0.1)] transition-shadow duration-300 flex flex-col h-full relative overflow-hidden group opacity-75">
            <div class="absolute -right-12 -top-12 w-40 h-40 bg-gray-100 rounded-full blur-3xl opacity-50 group-hover:bg-gray-200 transition-colors"></div>
            
            <div class="relative z-10 flex flex-col h-full">
                <div class="flex justify-between items-start mb-5">
                    <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-400 border border-slate-100 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                    </div>
                    <span class="bg-slate-100 text-slate-500 text-[11px] font-bold px-3 py-1 rounded-full border border-slate-200">Tidak Aktif</span>
                </div>
                
                <h3 class="text-xl font-bold text-[#0f172a] mb-2 tracking-tight text-slate-600">Engineering</h3>
                <p class="text-slate-400 text-[13.5px] leading-relaxed mb-6 flex-grow">
                    Program jalur profesional untuk lulusan D3/S1 di bidang IT, mesin, arsitektur yang menuntut skill khusus tinggi.
                </p>
                
                <div class="bg-slate-50 rounded-2xl p-4 mb-6 border border-slate-100/60 opacity-60">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-slate-500 text-[13px] font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Batch Aktif
                        </span>
                        <span class="font-bold text-slate-500 text-[14px]">0 Batch</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-500 text-[13px] font-medium flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Total Siswa
                        </span>
                        <span class="font-bold text-slate-500 text-[14px]">0 Siswa</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 mt-auto pt-2">
                    <button class="flex-1 bg-white border border-slate-200 text-slate-700 font-bold text-[13px] py-2.5 rounded-[16px] hover:bg-slate-50 hover:border-slate-300 transition-colors shadow-sm">
                        Edit Detail
                    </button>
                    <button class="w-11 h-11 flex items-center justify-center bg-white border border-emerald-200 text-emerald-600 rounded-[16px] hover:bg-emerald-50 transition-colors shadow-sm" title="Aktifkan Program">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
