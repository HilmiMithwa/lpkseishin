@extends('layouts.admin')

@section('title', 'Dashboard Admin - LPK Seishin')

@section('content')
<div class="p-6 lg:p-8 space-y-6">
    
    <!-- Header Titles -->
    <div>
        <h1 class="text-[32px] font-bold text-slate-800 leading-tight">Dashboard</h1>
        <p class="text-[15px] font-semibold text-slate-500 mt-1">Manajemen Admin</p>
    </div>

    <!-- Welcome Banner -->
    <div class="banner-red rounded-[24px] p-6 lg:p-10 text-white shadow-lg relative flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="relative z-10 w-full md:w-2/3">
            <h2 class="text-3xl lg:text-[40px] font-bold mb-3 leading-tight">Selamat Datang Kembali,<br>Admin</h2>
            <p class="text-white/90 text-sm lg:text-base font-medium max-w-lg">
                Berikut adalah ringkasan pendaftaran siswa, status pembayaran, dan operasional institusi hari ini.
            </p>
        </div>
        
        <!-- Clock Widget -->
        <div class="relative z-10 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-5 text-center min-w-[160px]">
            <p id="banner-date" class="text-xs font-bold text-white/90 uppercase tracking-wider mb-1">Rabu, 20 Mei 2026</p>
            <div class="flex items-end justify-center gap-2">
                <h3 id="banner-time" class="text-[40px] font-bold leading-none tracking-tight">14.23</h3>
            </div>
            <div class="mt-2 bg-white/20 rounded-full px-3 py-0.5 inline-block text-[10px] font-bold">WIB</div>
        </div>
    </div>

    <!-- Stats Grid (8 Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mt-8">
        
        <!-- Card 1: Total Siswa Aktif -->
        <x-card class="hover:-translate-y-1 transition-transform duration-300 p-5">
            <p class="text-xs font-bold text-slate-500 mb-3">Total Siswa Aktif</p>
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-[#d62828]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $total_siswa_aktif }}</h3>
            </div>
        </x-card>

        <!-- Card 2: Batch Berjalan -->
        <x-card class="hover:-translate-y-1 transition-transform duration-300 p-5">
            <p class="text-xs font-bold text-slate-500 mb-3">Batch Berjalan</p>
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-[#d62828]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $batch_berjalan }}</h3>
            </div>
        </x-card>

        <!-- Card 3: Tingkat Kelulusan -->
        <x-card class="hover:-translate-y-1 transition-transform duration-300 p-5">
            <p class="text-xs font-bold text-slate-500 mb-3">Tingkat Kelulusan</p>
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-[#d62828]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $tingkat_kelulusan }}%</h3>
            </div>
        </x-card>

        <!-- Card 4: Menunggu Pembayaran -->
        <x-card class="hover:-translate-y-1 transition-transform duration-300 p-5">
            <p class="text-xs font-bold text-slate-500 mb-3">Menunggu Pembayaran</p>
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-[#d62828] flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="text-right">
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Rp {{ number_format($menunggu_pembayaran, 0, ',', '.') }}</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mt-0.5">{{ $siswaMenungguPembayaranCount }} Siswa</p>
                </div>
            </div>
        </x-card>

        <!-- Card 5: Total Sensei -->
        <x-card class="hover:-translate-y-1 transition-transform duration-300 p-5">
            <p class="text-xs font-bold text-slate-500 mb-3">Total Sensei</p>
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-[#d62828]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $total_sensei }}</h3>
            </div>
        </x-card>

        <!-- Card 6: Total Alumni -->
        <x-card class="hover:-translate-y-1 transition-transform duration-300 p-5">
            <p class="text-xs font-bold text-slate-500 mb-3">Total Alumni</p>
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-[#d62828]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $total_alumni }}</h3>
            </div>
        </x-card>

        <!-- Card 7: Siswa Berisiko -->
        <x-card class="hover:-translate-y-1 transition-transform duration-300 p-5">
            <p class="text-xs font-bold text-slate-500 mb-3">Siswa Berisiko</p>
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-[#d62828]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <h3 class="text-3xl font-bold text-slate-800">{{ $siswa_berisiko }}</h3>
            </div>
        </x-card>

        <!-- Card 8: Pendapatan Bulanan -->
        <x-card class="hover:-translate-y-1 transition-transform duration-300 p-5">
            <p class="text-xs font-bold text-slate-500 mb-3">Pendapatan Bulanan</p>
            <div class="flex items-center justify-between">
                <div class="w-10 h-10 rounded-xl bg-rose-50 border border-rose-100 flex items-center justify-center text-[#d62828] flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="text-right">
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Rp {{ number_format($pendapatan_bulanan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </x-card>

    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mt-8">
        <!-- Enrollment Trends -->
        <div>
            <div class="flex items-center justify-between mb-3 px-1">
                <h3 class="font-bold text-sm text-slate-800">Tren Pendaftaran</h3>
                <form action="{{ route('admin.dashboard') }}" method="GET" class="inline-block">
                    <select name="year" onchange="this.form.submit()" class="text-xs font-semibold text-slate-600 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#d62828] focus:border-transparent py-1 pl-2 pr-6 cursor-pointer hover:bg-slate-50 transition shadow-sm">
                        @foreach($availableYears as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <x-card class="p-6 h-[320px] flex items-center justify-center">
                <div class="w-full h-full relative">
                    <canvas id="enrollmentChart"></canvas>
                </div>
            </x-card>
        </div>

        <!-- Payment Status -->
        <div>
            <h3 class="font-bold text-sm text-slate-800 mb-3 px-1">Status Pembayaran</h3>
            <x-card class="p-6 h-[320px] flex items-center justify-center relative">
                <div class="w-full h-full relative flex justify-center">
                    <canvas id="paymentChart"></canvas>
                </div>
            </x-card>
        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Update banner clock to match exactly "Rabu, 20 Mei 2026"
    function updateBannerClock() {
        const now = new Date();
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        const dayName = days[now.getDay()];
        const date = now.getDate();
        const monthName = months[now.getMonth()];
        const year = now.getFullYear();
        
        const dateString = `${dayName}, ${date} ${monthName} ${year}`;
        
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const timeString = `${hours}.${minutes}`;
        
        document.getElementById('banner-date').innerText = dateString;
        document.getElementById('banner-time').innerText = timeString;
    }
    
    setInterval(updateBannerClock, 1000);
    updateBannerClock();

    // Data dari Controller (Backend Integration Point)
    const enrollmentData = @json($enrollmentData ?? []);
    const paymentData = @json($paymentData ?? [0, 0, 0]); // Nilai Rupiah: Lunas, Cicilan Lancar, Menunggak

    // Format Rupiah
    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    };

    // 1. Enrollment Line Chart
    const ctxEnrollment = document.getElementById('enrollmentChart').getContext('2d');
    new Chart(ctxEnrollment, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Pendaftar',
                data: enrollmentData,
                borderColor: '#d62828',
                backgroundColor: 'rgba(214, 40, 40, 0.1)',
                borderWidth: 3,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#d62828',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 10,
                    titleFont: { family: 'Karla', size: 13 },
                    bodyFont: { family: 'Karla', size: 12, weight: 'bold' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f5f9', drawBorder: false },
                    ticks: { color: '#94a3b8', font: { family: 'Karla', size: 11 } }
                },
                x: {
                    grid: { display: false, drawBorder: false },
                    ticks: { color: '#94a3b8', font: { family: 'Karla', size: 11 } }
                }
            }
        }
    });

    // 2. Payment Doughnut Chart
    const ctxPayment = document.getElementById('paymentChart').getContext('2d');
    new Chart(ctxPayment, {
        type: 'doughnut',
        data: {
            labels: ['Lunas', 'Cicilan Lancar', 'Menunggak'],
            datasets: [{
                data: paymentData,
                backgroundColor: ['#10b981', '#eab308', '#d62828'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        color: '#64748b',
                        font: { family: 'Karla', size: 12, weight: 'bold' }
                    }
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) label += ': ';
                            if (context.raw !== null) {
                                label += formatRupiah(context.raw);
                            }
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection