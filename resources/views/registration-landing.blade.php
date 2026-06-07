<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran - LPK Seishin</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Karla', sans-serif;
        }
        .font-ibm {
            font-family: 'IBM Plex Sans', sans-serif;
        }
        .banner-red {
            background: linear-gradient(90deg, #d62828 0%, #d62828 50%, #8b1a1a 100%);
            position: relative;
            overflow: hidden;
        }
        .banner-red::before {
            content: '';
            position: absolute;
            top: 50%;
            right: 0;
            transform: translateY(-50%);
            width: 65%;
            height: 160%;
            background-image: url("{{ asset('img/japanMap.svg') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: left center;
            opacity: 0.35;
            z-index: 0;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header/Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold font-ibm text-[#d62828]">
                LPK Seishin
            </div>
            <div class="space-x-4">
                <a href="/" class="text-[#666666] hover:text-[#222222] font-semibold text-sm transition">
                    Beranda
                </a>
                <a href="https://lpkseishin.id" target="_blank" class="text-[#666666] hover:text-[#222222] font-semibold text-sm transition">
                    Company Profile
                </a>
                <a href="{{ route('login') }}" class="text-[#666666] hover:text-[#222222] font-semibold text-sm transition">
                    Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="banner-red py-20 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-ibm text-white mb-6 max-w-2xl">
                Bergabunglah Dengan LPK Seishin
            </h1>
            <p class="text-lg text-white/90 mb-8 max-w-2xl">
                Pelajari bahasa Jepang dengan pengajar profesional dan dapatkan sertifikat yang diakui
            </p>
            <a href="{{ route('registration.step1') }}" class="inline-block px-8 py-4 bg-white text-[#d62828] font-bold rounded-xl hover:bg-gray-100 transition text-lg">
                Daftar Sekarang
            </a>
        </div>
    </div>

    <!-- Features Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <h2 class="text-3xl font-bold font-ibm text-[#222222] text-center mb-16">Mengapa Memilih LPK Seishin?</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="bg-white rounded-2xl p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)] hover:shadow-[0_4px_20px_-4px_rgba(0,0,0,0.15)] transition">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold font-ibm text-[#222222] mb-2">Program Berkualitas</h3>
                <p class="text-[#666666]">Kurikulum dirancang oleh ahli bahasa Jepang berpengalaman internasional</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-white rounded-2xl p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)] hover:shadow-[0_4px_20px_-4px_rgba(0,0,0,0.15)] transition">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold font-ibm text-[#222222] mb-2">Harga Terjangkau</h3>
                <p class="text-[#666666]">Paket pembelajaran yang fleksibel dan dapat disesuaikan dengan budget Anda</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-white rounded-2xl p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)] hover:shadow-[0_4px_20px_-4px_rgba(0,0,0,0.15)] transition">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-[#d62828]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold font-ibm text-[#222222] mb-2">Sertifikasi Resmi</h3>
                <p class="text-[#666666]">Dapatkan sertifikat yang diakui secara internasional setelah menyelesaikan program</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-gray-100 py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold font-ibm text-[#222222] mb-4">Siap untuk Memulai?</h2>
            <p class="text-[#666666] text-lg mb-8">Proses pendaftaran hanya membutuhkan waktu 10 menit. Ayo daftar sekarang!</p>
            <a href="{{ route('registration.step1') }}" class="inline-block px-8 py-4 bg-[#d62828] text-white font-bold rounded-xl hover:bg-red-700 transition text-lg">
                Mulai Pendaftaran
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#222222] text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="font-bold font-ibm text-lg mb-4">LPK Seishin</h3>
                    <p class="text-white/70 text-sm">Lembaga Pelatihan Bahasa Jepang Terpercaya</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Tautan</h4>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li><a href="/" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('registration.step1') }}" class="hover:text-white transition">Pendaftaran</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li>Email: info@lpkseishin.id</li>
                        <li>WhatsApp: +62 xxx xxxx xxxx</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Ikuti Kami</h4>
                    <ul class="space-y-2 text-sm text-white/70">
                        <li><a href="#" class="hover:text-white transition">Instagram</a></li>
                        <li><a href="#" class="hover:text-white transition">Facebook</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-white/20 pt-8 text-center text-sm text-white/70">
                <p>&copy; 2026 LPK Seishin. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>
</body>
</html>
