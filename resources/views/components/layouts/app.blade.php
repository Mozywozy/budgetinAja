<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BudgetinAja') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('img/Logo2.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Notyf CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Notyf JS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        /* Custom styles for smooth scrolling and animations */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar for sidebar */
        .sidebar-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-track {
            background: rgba(44, 137, 93, 0.1);
            border-radius: 10px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(36, 109, 164, 0.5);
            border-radius: 10px;
        }

        .sidebar-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(36, 109, 164, 0.8);
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            body.sidebar-open {
                overflow: hidden;
            }

            #sidebar {
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            }

            main {
                width: 100%;
                position: absolute;
                left: 0;
            }

            body.sidebar-open main {
                overflow: hidden;
            }
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside id="sidebar"
            class="bg-gradient-to-r from-[#2C895D] to-[#246DA4] text-white w-64 h-screen flex-shrink-0 flex flex-col transition-all duration-300 ease-in-out transform fixed md:sticky top-0 md:translate-x-0 -translate-x-full z-50 rounded-tr-3xl rounded-br-3xl">
            <!-- Logo -->
            <div class="p-4 border-b border-opacity-20 border-white flex gap-5">
                <img src="{{ asset('img/Logo2.svg') }}" alt="BudgetinAja Logo" class="h-8 w-auto transition-transform duration-300 group-hover:scale-105">
                <a href="{{ route('dashboard') }}" class="flex items-center relative group overflow-hidden">
                    <span
                        class="font-bold text-xl relative z-10 transition-transform duration-300 group-hover:text-green-200">BudgetinAja</span>
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-white group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <!-- User Profile -->
            <div class="p-4 border-b border-opacity-20 border-white">
                <a href="{{ route('profile') }}">
                    <div
                        class="flex items-center space-x-3 group cursor-pointer hover:bg-white hover:bg-opacity-10 p-2 rounded-lg transition-all duration-300">
                        <div
                            class="w-10 h-10 rounded-full bg-[#2C895D] flex items-center justify-center overflow-hidden ring-2 ring-white ring-opacity-50 transform group-hover:scale-110 transition-all duration-300">
                            @if (Auth::user()->avatar)
                                @if (filter_var(Auth::user()->avatar, FILTER_VALIDATE_URL))
                                    <img src="{{ Auth::user()->avatar }}" alt="Avatar"
                                        class="w-full h-full object-cover">
                                @else
                                    <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar"
                                        class="w-full h-full object-cover">
                                @endif
                            @else
                                <span class="text-lg font-semibold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div>
                            <p class="font-medium group-hover:text-green-200 transition-colors duration-200">
                                {{ Auth::user()->name }}</p>
                            <a href="{{ route('profile') }}"
                                class="text-xs text-blue-200 hover:text-white group-hover:text-blue-100 transition-colors duration-200">View Profile</a>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 py-4 overflow-y-auto sidebar-scrollbar">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-white bg-opacity-20 border-l-4 border-white' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200 group">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-3 group-hover:text-green-200 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="group-hover:translate-x-1 transition-transform duration-200">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('budgets') }}"
                            class="flex items-center px-4 py-3 {{ request()->routeIs('budgets*') ? 'bg-white bg-opacity-20 border-l-4 border-white' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200 group">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-3 group-hover:text-green-200 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="group-hover:translate-x-1 transition-transform duration-200">Budget</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories') }}"
                            class="flex items-center px-4 py-3 {{ request()->routeIs('categories*') ? 'bg-white bg-opacity-20 border-l-4 border-white' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200 group">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-3 group-hover:text-green-200 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <span class="group-hover:translate-x-1 transition-transform duration-200">Category</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('transactions') }}"
                            class="flex items-center px-4 py-3 {{ request()->routeIs('transactions*') ? 'bg-white bg-opacity-20 border-l-4 border-white' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200 group">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-3 group-hover:text-green-200 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            <span class="group-hover:translate-x-1 transition-transform duration-200">Transaction</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('goals') }}"
                            class="flex items-center px-4 py-3 {{ request()->routeIs('goals*') ? 'bg-white bg-opacity-20 border-l-4 border-white' : 'hover:bg-white hover:bg-opacity-10' }} transition-all duration-200 group">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-3 group-hover:text-green-200 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span class="group-hover:translate-x-1 transition-transform duration-200">Goals</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Bottom Section -->
            <div class="p-4 border-t border-opacity-20 border-white">
                <div class="space-y-2">
                    <!-- Notification Link -->
                    <a href="{{ route('notifications') }}"
                        class="flex items-center px-4 py-2 hover:bg-white hover:bg-opacity-10 rounded-lg transition-all duration-300 group">
                        <div class="relative transform group-hover:scale-110 transition-transform duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 mr-3 group-hover:text-green-200 transition-colors duration-200"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <!-- Notification Badge -->
                            @if (Auth::user()->unreadNotifications()->count() > 0)
                                <span
                                    class="absolute -top-1 -right-1 inline-flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-600 rounded-full animate-pulse">{{ Auth::user()->unreadNotifications()->count() }}</span>
                            @endif
                        </div>
                        <span class="group-hover:translate-x-1 transition-transform duration-200">Notification</span>
                    </a>

                    <!-- Saweria Support -->
                    <a href="{{ config('services.saweria.url') }}" target="_blank" rel="noopener"
                        class="flex items-center px-4 py-2 hover:bg-white hover:bg-opacity-10 rounded-lg transition-all duration-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-3 transition-colors duration-200"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="group-hover:translate-x-1 transition-transform duration-200">Dukung via Saweria</span>
                    </a>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center px-4 py-2 text-left hover:bg-white hover:bg-opacity-10 rounded-lg transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Mobile Sidebar Toggle Button -->
        <div class="fixed top-4 right-4 z-50 md:hidden">
            <button id="sidebarToggle"
                class="bg-gradient-to-r from-[#2C895D] to-[#246DA4] text-white p-3 rounded-full shadow-lg hover:shadow-green-500/30 transform hover:scale-105 transition-all duration-300 focus:outline-none flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Page Content -->
        <main class="flex-1 py-6 overflow-y-auto overflow-x-hidden h-screen transition-all duration-300">
            <div class="px-4 sm:px-6 lg:px-8 mx-auto">
                <!-- Mobile Header -->
                <div class="md:hidden mb-6 flex items-center justify-between">
                    <h1 class="text-2xl font-bold text-gray-800">BudgetinAja</h1>
                </div>

                {{ $slot }}
            </div>
        </main>
    </div>

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        // Sidebar Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const body = document.body;
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                    body.classList.toggle('sidebar-open');
                });
            }
        });
        
        const notyf = new Notyf({
            duration: 2000,
            position: {
                x: 'right',
                y: 'top',
            },
            types: [{
                    type: 'success',
                    background: '#10B981',
                    dismissible: true,
                    icon: {
                        className: 'fas fa-check-circle',
                        tagName: 'i',
                        color: 'white'
                    }
                },
                {
                    type: 'error',
                    background: '#EF4444',
                    dismissible: true,
                    icon: {
                        className: 'fas fa-times-circle',
                        tagName: 'i',
                        color: 'white'
                    }
                },
                {
                    type: 'info',
                    background: '#3B82F6',
                    dismissible: true,
                    icon: {
                        className: 'fas fa-info-circle',
                        tagName: 'i',
                        color: 'white'
                    }
                }
            ]
        });

        // Listener untuk event Livewire
        document.addEventListener('DOMContentLoaded', () => {
            // Untuk Livewire v3, gunakan Livewire.on untuk mendengarkan event
            Livewire.on('notyf:success', (data) => {
                notyf.success(data.message);
            });

            Livewire.on('notyf:error', (data) => {
                notyf.error(data.message);
            });

            Livewire.on('notyf:info', (data) => {
                notyf.open({
                    type: 'info',
                    message: data.message
                });
            });

            Livewire.on('notyf:warning', (data) => {
                notyf.open({
                    type: 'warning',
                    message: data.message
                });
            });

            // Tetap pertahankan listener lama untuk kompatibilitas
            window.addEventListener('notyf:success', event => {
                notyf.success(event.detail.message);
            });

            window.addEventListener('notyf:error', event => {
                notyf.error(event.detail.message);
            });

            window.addEventListener('notyf:info', event => {
                notyf.open({
                    type: 'info',
                    message: event.detail.message
                });
            });

            // Tampilkan notifikasi dari session flash setelah halaman dimuat
            // Tambahkan timeout untuk memastikan notifikasi muncul setelah halaman selesai dimuat
            setTimeout(() => {
                @if (session()->has('notyf_type') && session()->has('notyf_message'))
                    @if (session('notyf_type') === 'success')
                        notyf.success("{{ session('notyf_message') }}");
                    @elseif (session('notyf_type') === 'error')
                        notyf.error("{{ session('notyf_message') }}");
                    @elseif (session('notyf_type') === 'info')
                        notyf.open({
                            type: 'info',
                            message: "{{ session('notyf_message') }}"
                        });
                    @elseif (session('notyf_type') === 'warning')
                        notyf.open({
                            type: 'warning',
                            message: "{{ session('notyf_message') }}"
                        });
                    @endif
                @endif
            }, 500); // Tunggu 500ms setelah halaman dimuat
        });
    </script>
</body>

</html>
