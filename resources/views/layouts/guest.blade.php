<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'LPK Seishin') }} - {{ $pageTitle ?? 'Auth' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-karla text-gray-900 antialiased bg-white min-h-screen">
        <div class="min-h-screen flex items-center justify-center px-4 py-8 sm:px-6 lg:px-8">
            <!-- Main Card -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden w-full max-w-4xl flex flex-col lg:flex-row">

                <!-- Left Panel - Illustration -->
                <div class="hidden lg:flex lg:w-[45%] relative overflow-hidden m-3 rounded-2xl">
                    @if(isset($leftPanel))
                        {{ $leftPanel }}
                    @else
                        <div class="w-full bg-gradient-to-br from-red-600 via-red-700 to-red-900 p-10 flex flex-col justify-between relative overflow-hidden">
                            <!-- Decorative circles -->
                            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
                            <div class="absolute -bottom-16 -left-10 w-52 h-52 bg-white/5 rounded-full"></div>

                            <div class="relative z-10">
                                <h2 class="text-white text-3xl font-bold font-ibm leading-tight">Raih Karir Impianmu <br>di Jepang</h2>
                                <p class="text-red-200 mt-3 text-sm">Akses ruang kelas digital Anda. Belajar, mengajar, dan pantau progres akademik dalam satu platform terintegrasi</p>
                            </div>

                            <div class="relative z-10 mt-auto flex items-end justify-center">
                                <img 
                                    src="https://res.cloudinary.com/dz8fs7rp1/image/upload/v1780406759/image_1010_1_psv3rx.png" 
                                    alt="Students illustration" 
                                    class="w-full scale-110 object-contain translate-y-16"
                                />
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Panel - Form -->
                <div class="w-full lg:w-[55%] p-8 sm:p-10 lg:p-12 flex flex-col justify-center">
                    <!-- Logo -->
                    <div class="flex items-center justify-center mb-6">
                        <img 
                            src="https://res.cloudinary.com/depmeqzg0/image/upload/v1775320259/logolpkseishin2_jju50g.webp" 
                            alt="LPK Seishin Logo" 
                            class="h-14 w-auto"
                        />
                    </div>

                    <!-- Title -->
                    <div class="text-center mb-0">
                        <h1 class="text-2xl font-bold text-gray-900 font-ibm">{{ $title ?? 'Selamat Datang' }}</h1>
                        @if(isset($subtitle))
                            <p class="text-gray-500 text-sm mt-1.5">{{ $subtitle }}</p>
                        @endif
                    </div>

                    <!-- Form Content -->
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
