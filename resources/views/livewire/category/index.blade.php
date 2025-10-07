<div>
    <div class="py-8 bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header dan Tombol Tambah -->
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#2C895D] mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <h2 class="text-3xl font-bold text-gray-800 tracking-tight">Daftar Kategori</h2>
                </div>
                <button wire:click="create"
                    class="px-5 py-2.5 bg-[#2C895D] text-white rounded-lg hover:bg-[#246DA4] focus:outline-none focus:ring-2 focus:ring-[#246DA4] focus:ring-offset-2 transition-all duration-200 flex items-center shadow-md hover:shadow-lg transform hover:-translate-y-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Kategori
                </button>
            </div>

            <!-- Filter dan Pencarian -->
            <div class="bg-white overflow-hidden shadow-md rounded-xl mb-8 transition-all duration-300 hover:shadow-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input wire:model.live="search" type="text" id="search" placeholder="Cari kategori..."
                                    class="pl-10 w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-200">
                            </div>
                        </div>
                        <div class="col-span-1">
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>
                                </div>
                                <select wire:model.live="type" id="type" class="pl-10 w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all duration-200">
                                    <option value="">Semua Tipe</option>
                                    <option value="income">Pemasukan</option>
                                    <option value="expense">Pengeluaran</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Kategori dengan Card -->
            <div class="bg-transparent">
                <div class="p-0">
                    @if (count($categories) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($categories as $category)
                                <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    <div class="p-6">
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="flex items-center">
                                                <div class="h-10 w-10 rounded-full mr-3 flex items-center justify-center shadow-inner" style="background-color: {{ $category->color }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        @if($category->type === 'income')
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                                        @endif
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-gray-800">{{ $category->name }}</h3>
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $category->type === 'income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $category->type === 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button wire:click="edit({{ $category->id }})"
                                                    class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-full hover:bg-indigo-100 transition-colors duration-200 shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </button>
                                                <button wire:click="confirmDelete({{ $category->id }})"
                                                    class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-full hover:bg-red-100 transition-colors duration-200 shadow-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        @if ($category->type === 'expense' && $category->budget_limit)
                                            <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                                                <div class="flex justify-between items-center mb-2">
                                                    <span class="text-sm font-medium text-gray-700">Budget Limit:</span>
                                                    <span class="text-base font-bold text-gray-900">{!! App\Helpers\CurrencyHelper::format($category->budget_limit, auth()->user()->currency, true) !!}</span>
                                                </div>
                                                <div class="flex justify-between items-center mb-2">
                                                    <span class="text-sm font-medium text-gray-700">Penggunaan:</span>
                                                    <span class="text-base font-bold {{ $category->isAtOrOverLimit() ? 'text-red-600' : ($category->isApproachingLimit() ? 'text-yellow-600' : 'text-blue-600') }}">
                                                        {!! App\Helpers\CurrencyHelper::format(min($category->current_month_spent, $category->budget_limit), auth()->user()->currency, true) !!}
                                                    </span>
                                                </div>
                                                
                                                <!-- Progress Bar -->
                                                <div class="mt-2">
                                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                        <div class="h-2.5 rounded-full transition-all duration-500 ease-out {{ $category->isAtOrOverLimit() ? 'bg-red-500' : ($category->isApproachingLimit() ? 'bg-yellow-500' : 'bg-blue-500') }}"
                                                            style="width: {{ min(($category->current_month_spent / $category->budget_limit) * 100, 100) }}%"></div>
                                                    </div>
                                                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                                                        <span>{{ min(number_format(($category->current_month_spent / $category->budget_limit) * 100, 0), 100) }}% terpakai</span>
                                                        <span>{{ number_format(100 - min(($category->current_month_spent / $category->budget_limit) * 100, 100), 0) }}% tersisa</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($category->type === 'expense')
                                            <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-sm font-medium text-gray-700">Penggunaan Bulan Ini:</span>
                                                    <span class="text-base font-bold text-gray-900">{!! App\Helpers\CurrencyHelper::format($category->current_month_spent, auth()->user()->currency, true) !!}</span>
                                                </div>
                                                <div class="mt-2 text-xs text-gray-500">Tidak ada batas budget yang ditetapkan</div>
                                            </div>
                                        @else
                                            <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                                                <div class="flex justify-between items-center">
                                                    <span class="text-sm font-medium text-gray-700">Pemasukan Bulan Ini:</span>
                                                    <span class="text-base font-bold text-green-600">{!! App\Helpers\CurrencyHelper::format($category->current_month_income ?? 0, auth()->user()->currency, true) !!}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination Links -->
                        <div class="mt-6">
                            {{ $categories->links() }}
                        </div>
                    @else
                        <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                            <h3 class="mt-2 text-lg font-medium text-gray-900">Tidak ada kategori</h3>
                            <p class="mt-1 text-sm text-gray-500 max-w-md mx-auto">Mulai buat kategori baru untuk mengelola keuangan Anda dengan lebih efektif.</p>
                            <div class="mt-8">
                                <button wire:click="create" class="inline-flex items-center px-6 py-3 border border-transparent shadow-md text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah Kategori
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Modal Form dan Delete Modal tetap sama -->
            @if ($showModal)
                <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <!-- Background overlay -->
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                        <!-- Modal panel -->
                        <div
                            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                            {{ $isEditing ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
                                        </h3>
                                        <div class="mt-4">
                                            <form wire:submit.prevent="save">
                                                <div class="grid grid-cols-1 gap-6">
                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama
                                                            Kategori</label>
                                                        <input wire:model="name" type="text"
                                                            class="w-full px-4 py-2 border rounded-lg"
                                                            placeholder="Nama kategori">
                                                        @error('name')
                                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                                                        <select wire:model="type" class="w-full px-4 py-2 border rounded-lg">
                                                            <option value="income">Pemasukan</option>
                                                            <option value="expense">Pengeluaran</option>
                                                        </select>
                                                        @error('type')
                                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 mb-1">Warna</label>
                                                        <input wire:model="color" type="color"
                                                            class="w-full px-4 py-2 border rounded-lg h-10">
                                                        @error('color')
                                                            <span class="text-red-500 text-sm">{{ $message }}</span>
                                                        @enderror
                                                    </div>

                                                    @if ($type === 'expense')
                                                        <div>
                                                            <label class="block text-sm font-medium text-gray-700 mb-1">Batas
                                                                Budget</label>
                                                            <input wire:model="budget_limit" type="number" step="0.01"
                                                                class="w-full px-4 py-2 border rounded-lg "
                                                                placeholder="Batas budget bulanan" required>
                                                            @error('budget_limit')
                                                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    @endif
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button wire:click="save" type="button"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    {{ $isEditing ? 'Perbarui' : 'Simpan' }}
                                </button>
                                <button wire:click="closeModal" type="button"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
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
                    <button wire:click="deleteCategory({{ $categoriesToDelete }})" type="button"
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
