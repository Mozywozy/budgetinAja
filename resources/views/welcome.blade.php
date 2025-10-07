<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'BudgetinAja') }} - Kelola Keuangan dengan Mudah</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/Logo2.svg') }}">


    <!-- SEO Meta Tags -->
    <meta name="description"
        content="BudgetinAja - Aplikasi pengelolaan keuangan pribadi yang membantu Anda melacak pengeluaran, mengatur anggaran, dan mencapai tujuan keuangan dengan mudah.">
    <meta name="keywords"
        content="manajemen keuangan, aplikasi budget, pengelolaan uang, keuangan pribadi, anggaran bulanan, lacak pengeluaran, tabungan, tujuan keuangan">
    <meta name="author" content="BudgetinAja">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="BudgetinAja - Kelola Keuangan dengan Mudah">
    <meta property="og:description"
        content="Aplikasi pengelolaan keuangan pribadi yang membantu Anda melacak pengeluaran, mengatur anggaran, dan mencapai tujuan keuangan.">
    <meta property="og:image" content="{{ asset('img/Logo.svg') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta property="twitter:title" content="BudgetinAja - Kelola Keuangan dengan Mudah">
    <meta property="twitter:description"
        content="Aplikasi pengelolaan keuangan pribadi yang membantu Anda melacak pengeluaran, mengatur anggaran, dan mencapai tujuan keuangan.">
    <meta property="twitter:image" content="{{ asset('img/Logo.svg') }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url('/') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        /* Animasi custom */
        .pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Animasi hover untuk tombol */
        .btn-hover-effect {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-hover-effect:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: -100%;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.2) 50%, rgba(255, 255, 255, 0) 100%);
            transition: all 0.6s ease;
        }

        .btn-hover-effect:hover:after {
            left: 100%;
        }

        /* Mobile menu */
        .mobile-menu {
            transition: transform 0.3s ease-in-out;
            transform: translateX(-100%);
        }

        .mobile-menu.active {
            transform: translateX(0);
        }

        #menu-overlay.show {
            display: block;
        }
    </style>
</head>

<body class="bg-white text-gray-800 font-sans antialiased">

    {{-- Header --}}
    <header class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 shadow-sm">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="{{ asset('img/Logo.svg') }}" alt="BudgetinAja Logo" class="w-8 h-8 text-[#3CB371]" />
                <span class="text-2xl font-bold text-gray-800 tracking-tight">BudgetinAja</span>
            </a>

            <nav class="hidden md:flex items-center gap-6">
                <a href="#features" class="text-gray-600 hover:text-[#3CB371] transition-colors">Fitur</a>
                <a href="#testimonials" class="text-gray-600 hover:text-[#3CB371] transition-colors">Testimoni</a>
            </nav>

            <div class="hidden md:flex items-center gap-2">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="text-gray-600 hover:text-[#3CB371] hover:bg-green-50 px-4 py-2 rounded transition-all duration-300">
                        Dasbor
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-gray-600 hover:text-[#3CB371] hover:bg-green-50 px-4 py-2 rounded transition-all duration-300">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-[#3CB371] hover:bg-[#34a065] text-white rounded-full px-4 py-2 btn-hover-effect">
                        Daftar
                    </a>
                @endauth
            </div>

            <div class="md:hidden flex items-center gap-4">
                <a href="{{ route('register') }}"
                    class="bg-[#3CB371] hover:bg-[#34a065] text-white rounded-full px-4 py-2 btn-hover-effect">
                    Mulai
                </a>
                <button id="mobile-menu-button" class="text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <div id="menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

    <div id="mobile-menu" class="mobile-menu fixed top-0 left-0 h-full w-3/4 max-w-sm bg-white shadow-xl z-50 p-6">
        <div class="flex justify-between items-center mb-8">
            <a href="{{ url('/') }}" class="flex items-center gap-2">
                <img src="{{ asset('img/Logo.svg') }}" alt="BudgetinAja Logo" class="w-8 h-8" />
                <span class="text-2xl font-bold text-gray-800 tracking-tight">BudgetinAja</span>
            </a>
            <button id="close-menu-button" class="text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="flex flex-col gap-4">
            <a href="#features" class="py-2 border-b border-gray-100 text-gray-600 hover:text-[#3CB371]">Fitur</a>
            <a href="#testimonials"
                class="py-2 border-b border-gray-100 text-gray-600 hover:text-[#3CB371]">Testimoni</a>
            @auth
                <a href="{{ url('/dashboard') }}"
                    class="py-2 border-b border-gray-100 text-gray-600 hover:text-[#3CB371]">Dasbor</a>
            @else
                <a href="{{ route('login') }}"
                    class="py-2 border-b border-gray-100 text-gray-600 hover:text-[#3CB371]">Masuk</a>
                <a href="{{ route('register') }}"
                    class="py-2 border-b border-gray-100 text-gray-600 hover:text-[#3CB371]">Daftar</a>
            @endauth
        </nav>
    </div>

    {{-- Main Content --}}
    <main class="pt-24"> {{-- kasih padding biar tidak ketutup header --}}
        {{-- Hero Section --}}
        <section class="bg-green-50/50 pt-32 pb-20">
            <div class="container mx-auto px-6 text-center">
                <h1 class="text-4xl md:text-6xl font-extrabold text-gray-800 leading-tight" data-aos="fade-up"
                    data-aos-duration="1000">
                    Lacak Anggaran Anda, <br>
                    <span class="text-[#3CB371]">Hemat Lebih Cerdas</span> dengan BudgetinAja
                </h1>
                <p class="mt-6 max-w-2xl mx-auto text-lg text-gray-600" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="200">
                    Pantau dengan mudah pengeluaran, pendapatan, dan target tabungan Anda dalam satu tempat.
                    Ambil kendali atas masa depan keuangan Anda hari ini.
                </p>

                <div class="mt-8 flex flex-wrap justify-center gap-4" data-aos="fade-up" data-aos-duration="1000"
                    data-aos-delay="400">
                    @guest
                        <a href="{{ route('register') }}"
                            class="bg-[#3CB371] hover:bg-[#34a065] text-white rounded-full px-8 py-6 text-lg font-semibold shadow-lg shadow-green-500/20 pulse btn-hover-effect">
                            Mulai Sekarang
                        </a>
                        <a href="#features"
                            class="border border-gray-300 hover:bg-gray-100 rounded-full px-8 py-6 text-lg font-semibold transition-all duration-300">
                            Pelajari Lebih Lanjut
                        </a>
                    @else
                        <a href="{{ url('/dashboard') }}"
                            class="bg-[#3CB371] hover:bg-[#34a065] text-white rounded-full px-8 py-6 text-lg font-semibold shadow-lg shadow-green-500/20 btn-hover-effect">
                            Ke Dasbor
                        </a>
                    @endguest
                </div>

            </div>
        </section>

        {{-- Features Section --}}
        <section id="features" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Semua yang Anda Butuhkan untuk Sukses</h2>
                    <p class="mt-4 text-lg text-gray-600">Semua alat untuk manajemen keuangan yang cerdas.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    {{-- Feature 1 --}}
                    <div class="bg-gray-50/80 rounded-2xl p-8 text-center hover:shadow-xl hover:-translate-y-2 transition-all duration-300"
                        data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 mb-6 rounded-full bg-white shadow-md">
                            {{-- Wallet Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#4A90E2]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 12H4m16 0a2 2 0 002-2V8a2 2 0 00-2-2H6a2 2 0 00-2 2m16 4a2 2 0 01-2 2H6a2 2 0 01-2-2m0 0v4a2 2 0 002 2h12a2 2 0 002-2v-4z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Pelacakan Pengeluaran Mudah</h3>
                        <p class="text-gray-600">Catat dengan cepat pengeluaran harian Anda dan lihat ke mana uang Anda
                            mengalir.</p>
                    </div>

                    {{-- Feature 2 --}}
                    <div class="bg-gray-50/80 rounded-2xl p-8 text-center hover:shadow-xl hover:-translate-y-2 transition-all duration-300"
                        data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 mb-6 rounded-full bg-white shadow-md">
                            {{-- BarChart2 Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#3CB371]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 3v18m4-10v10M7 13v8M3 17v4h18v-2" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Wawasan Anggaran Cerdas</h3>
                        <p class="text-gray-600">Dapatkan laporan dan grafik cerdas untuk memahami kebiasaan
                            pengeluaran Anda.
                        </p>
                    </div>

                    {{-- Feature 3 --}}
                    <div class="bg-gray-50/80 rounded-2xl p-8 text-center hover:shadow-xl hover:-translate-y-2 transition-all duration-300"
                        data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 mb-6 rounded-full bg-white shadow-md">
                            {{-- LayoutGrid Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#f5a623]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 0h6v6h-6v-6z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Kategori Kustom</h3>
                        <p class="text-gray-600">Buat kategori yang dipersonalisasi untuk mengatur keuangan Anda sesuai
                            keinginan.</p>
                    </div>

                    {{-- Feature 4 --}}
                    <div class="bg-gray-50/80 rounded-2xl p-8 text-center hover:shadow-xl hover:-translate-y-2 transition-all duration-300"
                        data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                        <div
                            class="inline-flex items-center justify-center w-16 h-16 mb-6 rounded-full bg-white shadow-md">
                            {{-- FileDown Icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-[#bd10e0]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v12m0 0l-4-4m4 4l4-4M4 16h16" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Ekspor Laporan</h3>
                        <p class="text-gray-600">Ekspor data keuangan Anda dengan mudah ke CSV untuk catatan Anda.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Dashboard Preview Section --}}
        <section class="py-20 bg-gray-50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Visualisasikan Keuangan Anda</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Dasbor intuitif kami membuat data kompleks mudah dipahami.
                    </p>
                </div>

                <div class="rounded-2xl shadow-2xl shadow-gray-300/40 overflow-hidden border-4 border-gray-100 max-w-5xl mx-auto"
                    data-aos="zoom-in" data-aos-duration="1000">
                    <div class="p-2 sm:p-4 bg-gray-100/50">
                        <img src="{{ asset('img/dashboard-preview.png') }}" alt="Pratinjau Dasbor"
                            class="rounded-xl w-full hover:scale-[1.02] transition-transform duration-500">
                    </div>
                </div>
            </div>
        </section>


        {{-- Testimonials Section --}}
        <section id="testimonials" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Disukai oleh Para Penabung di Mana Saja
                    </h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Jangan hanya percaya kata-kata kami. Inilah yang dikatakan pengguna kami.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {{-- Testimonial 1 --}}
                    <div class="rounded-2xl shadow-lg h-full flex flex-col bg-white" data-aos="fade-up"
                        data-aos-duration="800" data-aos-delay="100">
                        <div class="p-8 flex-grow flex flex-col">
                            <p class="text-gray-600 flex-grow">
                                "BudgetinAja telah sepenuhnya mengubah cara saya mengelola keuangan.
                                Sangat sederhana dan menarik secara visual. Akhirnya saya merasa mengendalikan uang
                                saya!"
                            </p>
                            <div class="mt-6 flex items-center">
                                <img src="https://i.pravatar.cc/150?img=1" alt="Sarah L."
                                    class="w-12 h-12 rounded-full mr-4">
                                <div>
                                    <p class="font-semibold text-gray-800">Alesandro Yanto.</p>
                                    <p class="text-sm text-gray-500">Desainer Freelance</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Testimonial 2 --}}
                    <div class="rounded-2xl shadow-lg h-full flex flex-col bg-white" data-aos="fade-up"
                        data-aos-duration="800" data-aos-delay="200">
                        <div class="p-8 flex-grow flex flex-col">
                            <p class="text-gray-600 flex-grow">
                                "Sebagai seseorang yang menyukai data, saya menghargai laporan detailnya.
                                Aplikasi ini kuat namun sangat mudah digunakan. Sangat direkomendasikan!"
                            </p>
                            <div class="mt-6 flex items-center">
                                <img src="https://i.pravatar.cc/150?img=3" alt="Michael B."
                                    class="w-12 h-12 rounded-full mr-4">
                                <div>
                                    <p class="font-semibold text-gray-800">Cristiano Yudo.</p>
                                    <p class="text-sm text-gray-500">Insinyur Perangkat Lunak</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Testimonial 3 --}}
                    <div class="rounded-2xl shadow-lg h-full flex flex-col bg-white" data-aos="fade-up"
                        data-aos-duration="800" data-aos-delay="300">
                        <div class="p-8 flex-grow flex flex-col">
                            <p class="text-gray-600 flex-grow">
                                "Saya menggunakan ini untuk melacak pengeluaran pribadi dan bisnis saya.
                                Ini sangat membantu untuk musim pajak. Kategori kustom adalah fitur yang fantastis."
                            </p>
                            <div class="mt-6 flex items-center">
                                <img src="https://i.pravatar.cc/150?img=5" alt="Jessica T."
                                    class="w-12 h-12 rounded-full mr-4">
                                <div>
                                    <p class="font-semibold text-gray-800">Sri Moelyati.</p>
                                    <p class="text-sm text-gray-500">Pemilik Usaha Kecil</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- Footer --}}
    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-12">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center gap-2 mb-6 md:mb-0" data-aos="fade-right" data-aos-duration="800">
                    <img src="{{ asset('img/Logo2.svg') }}" alt="BudgetinAja Logo" class="w-8 h-8 text-[#3CB371]" />
                    <span class="text-2xl font-bold">BudgetinAja</span>
                </div>

                <div class="mb-6 ml-8 md:mb-0" data-aos="fade-left" data-aos-duration="800">
                    <a href="{{ config('services.saweria.url') }}" target="_blank" rel="noopener"
                        class="bg-amber-500 hover:bg-amber-600 text-white rounded-full px-4 py-2 inline-flex items-center justify-center btn-hover-effect">
                        Dukung via Saweria
                    </a>
                </div>

                <div class="flex gap-8 mb-6 md:mb-0" data-aos="fade-left" data-aos-duration="800">
                    <a href="#features" class="hover:text-[#3CB371] transition-colors">Features</a>
                    @guest
                        <a href="{{ route('login') }}" class="hover:text-[#3CB371] transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="hover:text-[#3CB371] transition-colors">Daftar</a>
                    @else
                        <a href="{{ url('/dashboard') }}" class="hover:text-[#3CB371] transition-colors">Dasbor</a>
                    @endguest
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} BudgetinAja. Seluruh hak cipta dilindungi.</p>
                <div class="mt-4 flex flex-col sm:flex-row gap-3 justify-center">
                    <button id="open-suggestion-modal"
                        class="bg-[#3CB371] hover:bg-[#34a065] text-white rounded-full px-4 py-2 btn-hover-effect">
                        Saran
                    </button>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal Saran -->
    <div id="suggestion-modal"
        class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Kirim Saran</h3>
                <button id="close-suggestion-modal" class="text-gray-600 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form id="suggestion-form" method="POST" action="{{ route('send.suggestion') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-medium mb-2">Nama</label>
                    <input type="text" id="name" name="name"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#3CB371] focus:border-transparent"
                        required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#3CB371] focus:border-transparent"
                        required>
                </div>
                <div class="mb-4">
                    <label for="suggestion" class="block text-gray-700 text-sm font-medium mb-2">Saran</label>
                    <textarea id="suggestion" name="suggestion" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#3CB371] focus:border-transparent"
                        required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-[#3CB371] hover:bg-[#34a065] text-white font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-[#3CB371] focus:ring-opacity-50 transition-colors">
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            once: false, // whether animation should happen only once - while scrolling down
            mirror: true, // whether elements should animate out while scrolling past them
        });

        // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const closeMenuButton = document.getElementById('close-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const menuOverlay = document.getElementById('menu-overlay');
            const mobileMenuLinks = document.querySelectorAll('#mobile-menu a');

            // Suggestion modal functionality
            const openSuggestionModalBtn = document.getElementById('open-suggestion-modal');
            const closeSuggestionModalBtn = document.getElementById('close-suggestion-modal');
            const suggestionModal = document.getElementById('suggestion-modal');

            function openSuggestionModal() {
                suggestionModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeSuggestionModal() {
                suggestionModal.classList.add('hidden');
                document.body.style.overflow = '';
            }

            if (openSuggestionModalBtn) {
                openSuggestionModalBtn.addEventListener('click', openSuggestionModal);
            }

            if (closeSuggestionModalBtn) {
                closeSuggestionModalBtn.addEventListener('click', closeSuggestionModal);
            }

            // Close modal when clicking outside
            suggestionModal.addEventListener('click', function(e) {
                if (e.target === suggestionModal) {
                    closeSuggestionModal();
                }
            });

            function openMenu() {
                mobileMenu.classList.add('active');
                menuOverlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function closeMenu() {
                mobileMenu.classList.remove('active');
                menuOverlay.classList.remove('show');
                document.body.style.overflow = '';
            }


            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', openMenu);
            }

            if (closeMenuButton) {
                closeMenuButton.addEventListener('click', closeMenu);
            }

            if (menuOverlay) {
                menuOverlay.addEventListener('click', closeMenu);
            }

            // Close menu when clicking on a link
            mobileMenuLinks.forEach(link => {
                link.addEventListener('click', closeMenu);
            });
        });
    </script>
</body>

</html>
