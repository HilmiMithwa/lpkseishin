@extends('layouts.admin')

@section('title', 'Verifikasi Pendaftar - Admin LPK Seishin')

@section('content')
<div class="p-4 sm:p-6 lg:p-10">
    
    <div class="mb-8">
        <h1 class="text-2xl sm:text-[28px] lg:text-3xl font-semibold font-ibm text-[#222222] tracking-tight mb-1">Verifikasi Pendaftar</h1>
        <p class="text-sm text-[#666666] font-medium mt-2">Kelola dan verifikasi data pendaftar siswa baru</p>
    </div>

    <!-- Search & Filter Section -->
    <div class="bg-white rounded-2xl p-6 mb-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)]">
        <form action="{{ route('admin.registrations.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Search Input -->
            <div class="sm:col-span-2 lg:col-span-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, no WA, atau KTP..." class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition text-sm">
            </div>

            <!-- Status Filter -->
            <div>
                <select name="status" onchange="this.form.submit()" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#d62828]/20 focus:border-[#d62828] transition text-sm">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ request('status') === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="accepted" {{ request('status') === 'accepted' ? 'selected' : '' }}>Diterima</option>
                    <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="sm:col-span-1 lg:col-span-1">
                <button type="submit" class="w-full px-4 py-3 bg-[#d62828] text-white font-bold rounded-xl hover:bg-red-700 transition text-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Registration List Table -->
    <div class="bg-white rounded-2xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#222222] uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#222222] uppercase tracking-wider">No. KTP</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#222222] uppercase tracking-wider">No. WA</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#222222] uppercase tracking-wider">Pendidikan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#222222] uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#222222] uppercase tracking-wider">Tgl Daftar</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#222222] uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($registrations as $reg)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-semibold text-[#222222]">{{ $reg->full_name }}</p>
                                    <p class="text-xs text-[#666666]">{{ $reg->gender }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-semibold text-[#222222]">{{ $reg->ktp_number }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-[#666666]">{{ $reg->whatsapp_number }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-semibold text-[#222222]">{{ ucfirst($reg->education_level) }}</p>
                                    <p class="text-xs text-[#666666]">{{ $reg->school_name }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                    @switch($reg->status)
                                        @case('pending') bg-yellow-100 text-yellow-800 @break
                                        @case('verified') bg-blue-100 text-blue-800 @break
                                        @case('accepted') bg-green-100 text-green-800 @break
                                        @case('rejected') bg-red-100 text-red-800 @break
                                    @endswitch
                                ">
                                    @switch($reg->status)
                                        @case('pending') Pending @break
                                        @case('verified') Terverifikasi @break
                                        @case('accepted') Diterima @break
                                        @case('rejected') Ditolak @break
                                    @endswitch
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-[#666666]">{{ $reg->created_at->format('d/m/Y') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.registrations.show', $reg->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-bold text-[#d62828] hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex justify-center mb-3">
                                    <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                </div>
                                <p class="text-[#666666] font-semibold">Tidak ada data pendaftar</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $registrations->links() }}
    </div>
</div>
@endsection
