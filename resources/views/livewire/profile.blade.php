<div class="container mx-auto py-8 px-4">
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animate-pulse-slow {
            animation: pulse 2s infinite;
        }

        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1), 0 8px 10px -6px rgba(59, 130, 246, 0.1);
        }
    </style>
    @if (session()->has('message'))
        <div class="fixed top-4 right-4 bg-gradient-to-r from-white to-green-50 dark:from-green-900/20 dark:to-emerald-900/20 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-5 rounded-md shadow-lg z-50 transform transition-all duration-500 ease-in-out animate-fade-in-down"
            role="alert">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="font-medium">{{ session('message') }}</p>
            </div>
        </div>
    @endif

    <!-- Bagian Profil Pengguna -->
    <div
        class="bg-white rounded-xl shadow-xl p-8 mb-8 border border-blue-100 transition-all duration-300 hover:shadow-2xl hover-lift animate-fadeIn">
        <h2 class="text-3xl font-bold mb-8 text-gray-800 inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Profil Pengguna
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Avatar Section -->
            <div class="md:col-span-1">
                <div
                    class="flex flex-col items-center bg-white p-6 rounded-xl shadow-md border border-blue-100 transition-all duration-300 hover:shadow-lg">
                    <div class="w-40 h-40 mb-6 relative group">
                        @if ($current_avatar)
                            @if (filter_var($current_avatar, FILTER_VALIDATE_URL))
                                <img src="{{ $current_avatar }}" alt="Avatar"
                                    class="w-full h-full rounded-full object-cover border-4 border-blue-200 dark:border-blue-800 shadow-lg transition-transform duration-300 transform group-hover:scale-105">
                            @else
                                <img src="{{ Storage::url($current_avatar) }}" alt="Avatar"
                                    class="w-full h-full rounded-full object-cover border-4 border-blue-200 dark:border-blue-800 shadow-lg transition-transform duration-300 transform group-hover:scale-105">
                            @endif
                        @else
                            <div
                                class="w-full h-full rounded-full bg-gradient-to-r from-blue-300 to-indigo-300 dark:from-blue-600 dark:to-indigo-600 flex items-center justify-center text-white shadow-lg transition-transform duration-300 transform group-hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        @endif

                        <label for="avatar-upload"
                            class="absolute bottom-0 right-0 bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-full p-3 cursor-pointer hover:from-blue-600 hover:to-indigo-600 transition-all duration-300 transform hover:scale-110 shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </label>
                        <input id="avatar-upload" type="file" wire:model="avatar" class="hidden" accept="image/*"
                            wire:change="updateProfileAvatar">
                    </div>
                    @error('avatar')
                        <span
                            class="text-red-500 text-sm font-medium mt-1 bg-red-50 dark:bg-red-900/20 px-3 py-1 rounded-md inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            {{ $message }}
                        </span>
                    @enderror
                    <p
                        class="text-sm text-gray-600 mt-2 text-center font-medium bg-white px-4 py-2 rounded-lg border border-gray-200 inline-block shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1 text-blue-500"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Klik ikon kamera untuk mengganti foto profil
                    </p>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="md:col-span-2">
                <div
                    class="bg-white p-6 rounded-xl shadow-md border border-blue-100 transition-all duration-300 hover:shadow-lg">
                    <h3 class="text-xl font-semibold mb-6 text-gray-700 border-b border-blue-100 pb-2">Informasi Pribadi
                    </h3>
                    <form wire:submit.prevent="updateProfile" class="space-y-5">
                        <div class="group">
                            <label for="name"
                                class="block text-sm font-medium text-gray-700 mb-1 group-hover:text-blue-600 transition-colors duration-200">Nama</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-200"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" id="name" wire:model="name"
                                    class="pl-10 mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-blue-300">
                            </div>
                            @error('name')
                                <span class="text-red-500 text-sm font-medium mt-1 inline-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 mb-1 group-hover:text-blue-600 transition-colors duration-200">Email</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-200"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="email" id="email" wire:model="email"
                                    class="pl-10 mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-blue-300">
                            </div>
                            @error('email')
                                <span class="text-red-500 text-sm font-medium mt-1 inline-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="group">
                            <label for="currency"
                                class="block text-sm font-medium text-gray-700 mb-1 group-hover:text-blue-600 transition-colors duration-200">Mata
                                Uang</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-200"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <select id="currency" wire:model="currency"
                                    class="pl-10 mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-blue-300">
                                    <option value="IDR">IDR - Rupiah Indonesia</option>
                                    <option value="USD">USD - Dollar Amerika</option>
                                    <option value="EUR">EUR - Euro</option>
                                    <option value="SGD">SGD - Dollar Singapura</option>
                                    <option value="MYR">MYR - Ringgit Malaysia</option>
                                </select>
                            </div>
                            @error('currency')
                                <span class="text-red-500 text-sm font-medium mt-1 inline-block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div
                            class="flex items-center p-3 bg-white rounded-lg border border-gray-200 group hover:border-blue-300 transition-all duration-200">
                            <input type="checkbox" id="notification_enabled" wire:model="notification_enabled"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 h-5 w-5">
                            <label for="notification_enabled"
                                class="ml-3 block text-sm text-gray-700 group-hover:text-blue-600 transition-colors duration-200 font-medium">Aktifkan
                                Notifikasi</label>
                            @error('notification_enabled')
                                <span class="text-red-500 text-sm font-medium ml-2">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="inline-flex justify-center items-center py-2.5 px-6 border border-transparent shadow-md text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Password Change Section -->
    <div class="bg-white rounded-xl shadow-xl p-8 mb-8 border border-blue-100 transition-all duration-300 hover:shadow-2xl hover-lift animate-fadeIn"
        style="animation-delay: 0.2s;">
        <h2 class="text-3xl font-bold mb-8 text-gray-800 inline-flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-3 text-blue-500" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
            Ubah Password
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div
                class="bg-white p-6 rounded-xl shadow-md border border-blue-100 transition-all duration-300 hover:shadow-lg">
                <form wire:submit.prevent="updatePassword" class="space-y-5">
                    <div class="group">
                        <label for="current_password"
                            class="block text-sm font-medium text-gray-700 mb-1 group-hover:text-blue-600 transition-colors duration-200">Password
                            Saat Ini</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            <input type="password" id="current_password" wire:model.defer="current_password"
                                class="pl-10 mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-blue-300">
                        </div>
                        @error('current_password')
                            <span class="text-red-500 text-sm font-medium mt-1 inline-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="group">
                        <label for="password"
                            class="block text-sm font-medium text-gray-700 mb-1 group-hover:text-blue-600 transition-colors duration-200">Password
                            Baru</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="password" wire:model.defer="password"
                                class="pl-10 mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-blue-300">
                        </div>
                        @error('password')
                            <span class="text-red-500 text-sm font-medium mt-1 inline-block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="group">
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 mb-1 group-hover:text-blue-600 transition-colors duration-200">Konfirmasi
                            Password Baru</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-200"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <input type="password" id="password_confirmation" wire:model.defer="password_confirmation"
                                class="pl-10 mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500 transition-all duration-200 hover:border-blue-300">
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="inline-flex justify-center items-center py-2.5 px-6 border border-transparent shadow-md text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                            Perbarui Password
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-md border border-amber-100 transition-all duration-300 hover:shadow-lg">
                <h3 class="text-xl font-semibold mb-4 text-gray-700 inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Dukung Pengembangan
                </h3>
                <p class="text-gray-600 mb-4">
                   Aplikasi ini gratis dan akan selalu gratis. Kalau merasa terbantu, kamu bisa traktir kopi buat saya ☕.
                </p>
                <a href="{{ config('services.saweria.url') }}" target="_blank" rel="noopener"
                   class="inline-flex justify-center items-center py-2.5 px-6 border border-transparent shadow-md text-sm font-medium rounded-lg text-white bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-300 transform hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Click disini ya bro!
                </a>
                @if (!config('services.saweria.url'))
                    <p class="mt-3 text-xs text-gray-500">
                        Konfigurasi Saweria belum diatur. Tambahkan SAWERIA_URL di file .env.
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
