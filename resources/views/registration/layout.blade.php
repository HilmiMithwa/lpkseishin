<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pendaftaran Siswa - LPK Seishin')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>

    <style>
        .flatpickr-day.selected, .flatpickr-day.selected:hover {
            background: #d62828 !important;
            border-color: #d62828 !important;
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
<body class="bg-gray-50 font-karla">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-2xl print:max-w-none">
            <!-- Header Banner -->
            <div class="banner-red rounded-3xl p-6 sm:p-8 mb-8 relative print:hidden">
                <div class="relative z-10">
                    <h1 class="text-2xl sm:text-3xl font-bold font-ibm text-white mb-2">Pendaftaran Siswa</h1>
                    <p class="text-white/90 text-sm sm:text-base">LPK Seishin - Bergabunglah dengan Kami</p>
                </div>
            </div>

            <!-- Progress Bar -->
            <div class="mb-8 print:hidden">
                <div class="flex justify-between items-center mb-6">
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center font-bold text-sm sm:text-base transition-all {{ $currentStep >= $i ? 'bg-[#d62828] text-white' : 'bg-gray-200 text-gray-600' }}">
                                {{ $i }}
                            </div>
                            <span class="text-xs sm:text-sm font-semibold text-[#222222] mt-2 text-center">
                                @switch($i)
                                    @case(1) Data Pribadi @break
                                    @case(2) Pendidikan @break
                                    @case(3) Dokumen @break
                                    @case(4) Pembayaran @break
                                @endswitch
                            </span>
                        </div>
                        @if ($i < 4)
                            <div class="flex-1 h-1 {{ $currentStep > $i ? 'bg-[#d62828]' : 'bg-gray-200' }} mx-2 mb-6"></div>
                        @endif
                    @endfor
                </div>
            </div>

            <!-- Content -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.08)] print:p-0 print:shadow-none print:bg-transparent">
                @yield('content')
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
