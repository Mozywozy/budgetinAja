<div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Header dan Tombol Tambah -->
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#2C895D] mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text- mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Daftar Anggaran</h2>
            </div>
            <button wire:click="openForm"
                class="px-5 py-2.5 bg-[#2C895D] to-[#246DA4] text-white rounded-lg hover:bg-[#246DA4] focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all duration-200 flex items-center shadow-md hover:shadow-lg transform hover:-translate-y-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Anggaran
            </button>
        </div>

        <!-- Flash Message -->
        @if (session()->has('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm animate-fadeIn"
                role="alert">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>{{ session('message') }}</p>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm animate-fadeIn" role="alert">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Filter dan Pencarian -->
        <div class="bg-white overflow-hidden shadow-md rounded-xl mb-8 transition-all duration-300 hover:shadow-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="col-span-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" id="search" wire:model.live="search" placeholder="Cari anggaran..."
                                class="pl-10 w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-200">
                        </div>
                    </div>
                    <div class="col-span-1">
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" id="date_from" wire:model.live="date_from"
                                class="pl-10 w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-200">
                        </div>
                    </div>
                    <div class="col-span-1">
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Sampai
                            Tanggal</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="date" id="date_to" wire:model.live="date_to"
                                class="pl-10 w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-200">
                        </div>
                    </div>
                    <div class="col-span-1 flex items-end">
                        <button wire:click="resetFilters"
                            class="px-4 py-2.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 w-full flex items-center justify-center shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Anggaran dengan Card -->
        <div class="bg-transparent">
            <div class="p-0">
                @if (count($budgets) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($budgets as $budget)
                            @php
                                $remaining = $budget->remaining;
                                $percentage = ($remaining / $budget->total_amount) * 100;
                                
                                // Warna untuk status anggaran
                                $statusColors = [
                                    'high' => ['bg' => 'bg-green-500', 'text' => 'text-green-600', 'border' => 'border-green-500', 'light' => 'bg-green-50', 'ring' => 'ring-green-500/30'],
                                    'medium' => ['bg' => 'bg-yellow-500', 'text' => 'text-yellow-600', 'border' => 'border-yellow-500', 'light' => 'bg-yellow-50', 'ring' => 'ring-yellow-500/30'],
                                    'low' => ['bg' => 'bg-red-500', 'text' => 'text-red-600', 'border' => 'border-red-500', 'light' => 'bg-red-50', 'ring' => 'ring-red-500/30'],
                                ];
                                
                                $status = $percentage > 50 ? 'high' : ($percentage > 25 ? 'medium' : 'low');
                                $colors = $statusColors[$status];

                                $now = \Carbon\Carbon::now();
                                $dateStatus = 'Aktif';
                                $dateStatusClass = 'bg-green-100 text-green-800';
                                $dateStatusIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />';

                                if ($budget->end_date < $now) {
                                    $dateStatus = 'Selesai';
                                    $dateStatusClass = 'bg-gray-100 text-gray-800';
                                    $dateStatusIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />';
                                } elseif ($budget->start_date > $now) {
                                    $dateStatus = 'Akan Datang';
                                    $dateStatusClass = 'bg-blue-100 text-blue-800 border border-blue-200';
                                    $dateStatusIcon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />';
                                }
                            @endphp

                            <div
                                class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 ring-1 {{ $colors['ring'] }}">
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1 pr-2">
                                            <h3 class="text-xl font-bold text-gray-800 truncate">
                                                {{ $budget->notes ?: 'Anggaran Tanpa Nama' }}
                                            </h3>
                                            <div class="mt-1">
                                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-semibold rounded-full {{ $dateStatusClass }} shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        {!! $dateStatusIcon !!}
                                                    </svg>
                                                    {{ $dateStatus }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2 shrink-0">
                                            <button wire:click="edit({{ $budget->id }})"
                                                class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-full hover:bg-indigo-100 transition-colors duration-200 shadow-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>  
                                            </button>
                                            <button wire:click="confirmDelete({{ $budget->id }})"
                                                class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-full hover:bg-red-100 transition-colors duration-200 shadow-sm z-10">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mt-6 bg-{{ $colors['light'] }} p-4 rounded-xl">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm font-medium text-gray-700">Total Anggaran:</span>
                                            <span class="text-lg font-bold text-gray-900">@currency($budget->total_amount, auth()->user()->currency)</span>
                                        </div>
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm font-medium text-gray-700">Sisa Anggaran:</span>
                                            <span class="text-lg font-bold {{ $colors['text'] }}">
                                                @currency($remaining, auth()->user()->currency)
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Progress Bar -->
                                    <div class="mt-4">
                                        <div class="w-full bg-gray-200 rounded-full h-3">
                                            <div class="{{ $colors['bg'] }} h-3 rounded-full transition-all duration-500 ease-out"
                                                style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-500 mt-2">
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 {{ $colors['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                Terpakai: {{ number_format(100 - $percentage, 0) }}%
                                            </span>
                                            <span class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 {{ $colors['text'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                Tersisa: {{ number_format($percentage, 0) }}%
                                            </span>
                                        </div>
                                    </div>

                                    <div class="mt-5 pt-4 border-t border-gray-100">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div class="bg-gray-50 p-3 rounded-lg">
                                                <span class="block text-xs text-gray-500 mb-1">Tanggal Mulai</span>
                                                <span class="text-sm font-medium flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $budget->start_date->format('d M Y') }}
                                                </span>
                                            </div>
                                            <div class="bg-gray-50 p-3 rounded-lg">
                                                <span class="block text-xs text-gray-500 mb-1">Tanggal Selesai</span>
                                                <span class="text-sm font-medium flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $budget->end_date->format('d M Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada anggaran</h3>
                        <p class="mt-1 text-sm text-gray-500 max-w-md mx-auto">Mulai buat anggaran baru untuk mengelola keuangan Anda dengan lebih efektif.
                        </p>
                        <div class="mt-8">
                            <button wire:click="openForm"
                                class="inline-flex items-center px-6 py-3 border border-transparent shadow-md text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Tambah Anggaran
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Form Modal -->
    <div class="fixed inset-0 overflow-y-auto z-50" style="display: {{ $showForm ? 'block' : 'none' }}">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-xl leading-6 font-bold text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $isEditing ? 'Edit Anggaran' : 'Tambah Anggaran Baru' }}
                            </h3>
                            <div class="mt-6">
                                <form wire:submit.prevent="save">
                                    <div class="grid grid-cols-1 gap-y-5">
                                        <div>
                                            <label for="total_amount"
                                                class="block text-sm font-medium text-gray-700 mb-1">Total Anggaran</label>
                                            <div class="mt-1 relative rounded-md shadow-sm">
                                                <div
                                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <span
                                                        class="text-gray-500 sm:text-sm">{{ auth()->user()->currency }}</span>
                                                </div>
                                                <input type="number" id="total_amount" wire:model="total_amount"
                                                    class="pl-16 focus:ring-indigo-500 border focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-lg transition-all duration-200"
                                                    placeholder="0">
                                            </div>
                                            @error('total_amount')
                                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <!-- Input mata uang dihilangkan, menggunakan mata uang user secara langsung -->

                                        <div>
                                            <label for="start_date"
                                                class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                            <div class="relative rounded-md shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <input type="date" id="start_date" wire:model="start_date"
                                                    class="pl-10 focus:ring-indigo-500 border focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg transition-all duration-200">
                                            </div>
                                            @error('start_date')
                                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="end_date"
                                                class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                                            <div class="relative rounded-md shadow-sm">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <input type="date" id="end_date" wire:model="end_date"
                                                    class="pl-10 focus:ring-indigo-500 border focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg transition-all duration-200">
                                            </div>
                                            @error('end_date')
                                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="notes"
                                                class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                            <div class="relative rounded-md shadow-sm">
                                                <div class="absolute top-3 left-3 flex items-center pointer-events-none">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </div>
                                                <textarea id="notes" wire:model="notes" rows="3"
                                                    class="pl-10 focus:ring-indigo-500 border focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-lg transition-all duration-200"
                                                    placeholder="Deskripsi anggaran..."></textarea>
                                            </div>
                                            @error('notes')
                                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="save" type="button"
                        class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200">
                        {{ $isEditing ? 'Perbarui' : 'Simpan' }}
                    </button>
                    <button wire:click="closeForm" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="fixed inset-0 overflow-y-auto z-50" style="display: {{ $showDeleteModal ? 'block' : 'none' }}">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-bold text-gray-900">
                                Konfirmasi Hapus
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin menghapus anggaran ini? Tindakan ini tidak dapat dibatalkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="deleteBudget" type="button"
                        class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200">
                        Hapus
                    </button>
                    <button wire:click="cancelDelete" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
