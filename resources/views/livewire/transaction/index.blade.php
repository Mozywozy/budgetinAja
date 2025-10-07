<div>
    <div class="container mx-auto px-4 py-6">
        <!-- Flash Message Success dengan animasi fade-out -->
        @if (session()->has('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md mb-4 animate-pulse"
                role="alert">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-green-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="font-medium">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        <!-- Flash Message Error dengan animasi fade-out -->
        @if (session()->has('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md mb-4 animate-pulse"
                role="alert">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-red-500 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Header dengan efek hover pada tombol -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-[#2C895D] flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2 text-[#2C895D]" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                Transaksi
            </h1>
            <button wire:click="openModal"
                class="bg-[#2C895D] hover:bg-[#246DA4] text-white px-4 py-2 rounded-lg shadow-md transform hover:scale-105 transition-all duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Transaksi
            </button>
        </div>

        <!-- Filter Section dengan tampilan yang lebih modern -->
        <div
            class="bg-white rounded-xl shadow-lg p-6 mb-6 border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                Filter
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="transition-all duration-200 hover:shadow-md p-2 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live="search"
                            class="pl-10 w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                            placeholder="Cari deskripsi...">
                    </div>
                </div>
                <div class="transition-all duration-200 hover:shadow-md p-2 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                    <select wire:model.live="type"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                        <option value="">Semua</option>
                        <option value="income">Pemasukan</option>
                        <option value="expense">Pengeluaran</option>
                    </select>
                </div>
                <div class="transition-all duration-200 hover:shadow-md p-2 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select wire:model.live="category_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                        <option value="">Semua</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="transition-all duration-200 hover:shadow-md p-2 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" wire:model.live="date_from"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                </div>
                <div class="transition-all duration-200 hover:shadow-md p-2 rounded-lg">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" wire:model.live="date_to"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200">
                </div>
                <div class="flex items-end">
                    <!-- Bar aksi di atas tabel/filter -->
                    <div class="mt-4 flex flex-nowrap items-center gap-2 w-full overflow-x-auto md:overflow-visible whitespace-nowrap">
                        <button type="button" wire:click="resetFilters"
                            class="shrink-0 min-w-max inline-flex items-center px-3 py-2 text-sm bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 4v6h6M20 20v-6h-6M5 19a9 9 0 0114-14" />
                            </svg>
                            Reset Filter
                        </button>
                        <!-- Download Excel (hijau, aktif) -->
                        <button type="button" wire:click="exportToExcel"
                            class="shrink-0 min-w-max inline-flex items-center px-3 py-2 text-sm bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition-colors duration-200
                                   disabled:opacity-60 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled" wire:target="exportToExcel">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 4h16v16H4zM12 8v8m-4-4h8" />
                            </svg>
                            Download Excel
                        </button>
                        <!-- Download Template (biru) -->
                        <button type="button" wire:click="downloadTemplate"
                            class="shrink-0 min-w-max inline-flex items-center px-3 py-2 text-sm bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition-colors duration-200
                                   disabled:opacity-60 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled" wire:target="downloadTemplate">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 4h16v16H4zM12 8v8m-4-4h8" />
                            </svg>
                            Download Template
                        </button>
                        <!-- Import File (ungu) -->
                        <input id="importFileInput" type="file" class="hidden" accept=".xlsx,.xls"
                               wire:model="import_file">
                        <button type="button"
                            onclick="document.getElementById('importFileInput').click()"
                            class="shrink-0 min-w-max inline-flex items-center px-3 py-2 text-sm bg-purple-600 text-white rounded-lg shadow hover:bg-purple-700 transition-colors duration-200
                                   disabled:opacity-60 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled" wire:target="importFile,import_file">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v16m8-8H4" />
                            </svg>
                            Import File
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Table dengan desain yang lebih modern -->
        <div
            class="bg-white rounded-xl shadow-lg overflow-x-auto overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors duration-200"
                            wire:click="sortBy('transaction_date')">
                            <div class="flex items-center">
                                <span>Tanggal</span>
                                @if ($sortField === 'transaction_date')
                                    <span class="ml-1">{!! $sortDirection === 'asc' ? '&#8593;' : '&#8595;' !!}</span>
                                @endif
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors duration-200"
                            wire:click="sortBy('type')">
                            <div class="flex items-center">
                                <span>Tipe</span>
                                @if ($sortField === 'type')
                                    <span class="ml-1">{!! $sortDirection === 'asc' ? '&#8593;' : '&#8595;' !!}</span>
                                @endif
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kategori
                        </th>
                        <!-- Tambahkan kolom Budget -->
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Budget
                        </th>
                        <!-- Akhir tambahan kolom Budget -->
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100 transition-colors duration-200"
                            wire:click="sortBy('amount')">
                            <div class="flex items-center">
                                <span>Jumlah</span>
                                @if ($sortField === 'amount')
                                    <span class="ml-1">{!! $sortDirection === 'asc' ? '&#8593;' : '&#8595;' !!}</span>
                                @endif
                            </div>
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Deskripsi
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($transactions as $transaction)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $transaction->transaction_date->format('d M Y') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaction->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} transition-all duration-200 hover:shadow-sm">
                                    {{ $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center">
                                    <span class="h-7 w-7 rounded-full flex items-center justify-center mr-2 shadow-sm"
                                        style="background-color: {{ $transaction->category->color }}">
                                        <i class="{{ $transaction->category->icon }} text-white text-xs"></i>
                                    </span>
                                    <span class="font-medium">{{ $transaction->category->name }}</span>
                                </div>
                            </td>
                            <!-- Tambahkan sel Budget (nama budget) -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ optional($transaction->budget)->notes ?? '—' }}
                            </td>
                            <!-- Akhir tambahan sel Budget -->
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium {{ $transaction->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-bold">@currency($transaction->amount, auth()->user()->currency)</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $transaction->description }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button wire:click="edit({{ $transaction->id }})"
                                        class="text-indigo-600 hover:text-indigo-900 bg-indigo-100 hover:bg-indigo-200 p-1.5 rounded-lg transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $transaction->id }})"
                                        class="text-red-600 hover:text-red-900 bg-red-100 hover:bg-red-200 p-1.5 rounded-lg transition-colors duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400 mb-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <p class="text-lg font-medium">Tidak ada transaksi yang ditemukan.</p>
                                    <p class="text-sm text-gray-400 mt-1">Coba ubah filter atau tambahkan transaksi
                                        baru.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination Links dengan styling yang lebih baik -->
            <div class="mt-4 px-6 py-3 bg-gray-50 border-t border-gray-200">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div class="fixed inset-0 z-10 overflow-y-auto" style="display: {{ $isOpen ? 'block' : 'none' }}">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div
                    class="absolute inset-0 bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-opacity duration-300">
                </div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full animate-fadeIn">
                <!-- Header dengan gradient -->
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-4 py-3 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-white">
                        {{ $isEdit ? 'Edit Transaksi' : 'Tambah Transaksi Baru' }}
                    </h3>
                    <button type="button" wire:click="closeModal"
                        class="text-white hover:text-gray-200 transition-colors duration-150 focus:outline-none">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <div class="mt-2">
                                <form wire:submit.prevent="{{ $isEdit ? 'update' : 'save' }}">
                                    <div class="mb-4">
                                        <label class="text-sm font-medium text-gray-700 mb-1 flex items-center">
                                            <svg class="h-4 w-4 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            Tipe
                                        </label>
                                        <select wire:model.live="form_type"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200">
                                            <option value="income">Pemasukan</option>
                                            <option value="expense">Pengeluaran</option>
                                        </select>
                                        @error('form_type')
                                            <span
                                                class="text-red-500 text-xs mt-1 animate-pulse">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="text-sm font-medium text-gray-700 mb-1 flex items-center">
                                            <svg class="h-4 w-4 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Jumlah
                                        </label>
                                        <div class="relative rounded-md shadow-sm">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-gray-500 sm:text-sm">Rp</span>
                                            </div>
                                            <input type="number" wire:model.live="amount"
                                                class="w-full pl-12 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200">
                                        </div>
                                        @error('amount')
                                            <span
                                                class="text-red-500 text-xs mt-1 animate-pulse">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="text-sm font-medium text-gray-700 mb-1 flex items-center">
                                            <svg class="h-4 w-4 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6h16M4 12h16M4 18h7" />
                                            </svg>
                                            Deskripsi
                                        </label>
                                        <input type="text" wire:model.live="description"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200">
                                        @error('description')
                                            <span
                                                class="text-red-500 text-xs mt-1 animate-pulse">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="text-sm font-medium text-gray-700 mb-1 flex items-center">
                                            <svg class="h-4 w-4 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Tanggal
                                        </label>
                                        <input type="date" wire:model.live="transaction_date"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200">
                                        @error('transaction_date')
                                            <span
                                                class="text-red-500 text-xs mt-1 animate-pulse">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="text-sm font-medium text-gray-700 mb-1 flex items-center">
                                            <svg class="h-4 w-4 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                            </svg>
                                            Kategori
                                        </label>
                                        <select wire:model.live="form_category_id"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($form_categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('form_category_id')
                                            <span
                                                class="text-red-500 text-xs mt-1 animate-pulse">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="text-sm font-medium text-gray-700 mb-1 flex items-center">
                                            <svg class="h-4 w-4 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            Budget
                                        </label>
                                        <select wire:model.live="budget_id"
                                            class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition-all duration-200">
                                            <option value="">Pilih Budget</option>
                                            @foreach ($budgets as $budget)
                                                <option value="{{ $budget->id }}">{{ $budget->notes }}</option>
                                            @endforeach
                                        </select>
                                        @error('budget_id')
                                            <span
                                                class="text-red-500 text-xs mt-1 animate-pulse">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- <div class="mb-4">
                                        <label class="text-sm font-medium text-gray-700 mb-1 flex items-center">
                                            <svg class="h-4 w-4 mr-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            Lampiran
                                        </label>
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-blue-400 transition-colors duration-200">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                        <span>Upload file</span>
                                                        <input id="file-upload" wire:model="attachment" type="file" class="sr-only">
                                                    </label>
                                                    <p class="pl-1">atau drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">
                                                    PNG, JPG, PDF hingga 10MB
                                                </p>
                                            </div>
                                        </div>
                                        @error('attachment')
                                            <span class="text-red-500 text-xs mt-1 animate-pulse">{{ $message }}</span>
                                        @enderror

                                        @if ($current_attachment)
                                            <div class="mt-2">
                                                <a href="{{ Storage::url($current_attachment) }}" target="_blank"
                                                    class="text-blue-500 hover:text-blue-700 transition-colors duration-150 flex items-center">
                                                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Lihat lampiran saat ini
                                                </a>
                                            </div>
                                        @endif
                                    </div> --}}

                                    <div class="mt-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit"
                                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-base font-medium text-white hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transform hover:scale-105 transition-all duration-200">
                                            <svg class="h-5 w-5 mr-1 -ml-1" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            {{ $isEdit ? 'Update' : 'Simpan' }}
                                        </button>
                                        <button type="button" wire:click="closeModal"
                                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm transform hover:scale-105 transition-all duration-200">
                                            <svg class="h-5 w-5 mr-1 -ml-1" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fixed inset-0 overflow-y-auto" style="display: {{ $showDeleteModal ? 'block' : 'none' }}">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10 animate-pulse">
                            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Konfirmasi Hapus
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin menghapus transaksi ini? Tindakan ini tidak dapat
                                    dibatalkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="deleteTransaction" type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Hapus
                    </button>
                    <button wire:click="cancelDelete" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form tetap sama, hanya perubahan minor pada styling -->
    <!-- ... existing modal code ... -->

    <!-- ... existing delete modal code ... -->

    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('showAlert', (data) => {
                console.log('Alert data:', data);
                Swal.fire({
                    title: data.type === 'error' ? 'Perhatian!' : 'Informasi',
                    text: data.message ||
                        'Kategori ini sudah mencapai limit budget',
                    icon: data.type || 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        @this.closeModal();
                    }
                });
            });
        });
    </script>

    <style>
        /* Animasi untuk modal */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }

        /* Efek focus untuk input */
        input:focus,
        select:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        /* Efek hover untuk tombol */
        button:hover {
            transform: translateY(-1px);
            transition: all 0.2s;
        }
    </style>
</div>
