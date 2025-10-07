<div>
    <div
        class="mb-8 bg-gradient-to-r from-[#2C895D] to-[#246DA4] p-8 rounded-lg shadow-lg text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 opacity-10">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-full h-full">
                <path
                    d="M12 7a1 1 0 0 1-1-1V4a1 1 0 0 1 2 0v2a1 1 0 0 1-1 1zm9 5a1 1 0 0 1-1 1h-2a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1zM6 12a1 1 0 0 1-1 1H3a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1zm.293 5.293a1 1 0 0 1 1.414-1.414l1.414 1.414a1 1 0 0 1-1.414 1.414l-1.414-1.414zM16.293 7.707a1 1 0 0 1 1.414-1.414l1.414 1.414a1 1 0 0 1-1.414 1.414l-1.414-1.414zM12 16a1 1 0 0 1 1 1v2a1 1 0 0 1-2 0v-2a1 1 0 0 1 1-1z" />
                <path d="M12 8a4 4 0 1 0 0 8 4 4 0 0 0 0-8zm0 6a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" />
            </svg>
        </div>
        <div class="relative z-10">
            <h1 class="text-3xl font-bold mb-2">Dashboard</h1>
            <p class="text-indigo-100 text-lg">Ringkasan keuangan Anda</p>
            <div class="mt-4 flex flex-wrap gap-4">
                <div class="bg-white bg-opacity-20 rounded-lg px-4 py-2 backdrop-blur-sm">
                    <p class="text-sm text-indigo-100">Bulan Ini</p>
                    <p class="text-xl font-bold">{{ now()->format('F Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Total Budget Card -->
        <div
            class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center">
                    <div
                        class="flex-shrink-0 bg-gradient-to-r from-indigo-500 to-indigo-600 rounded-lg p-4 shadow-md transform transition-transform duration-300 hover:scale-105">
                        <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-semibold text-indigo-600 truncate">Total Budget</dt>
                            <dd>
                                <div class="text-2xl font-bold text-indigo-700 mt-1">
                                    @currency(auth()->user()->budgets->sum('total_amount'), auth()->user()->currency)
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Expenses Card -->
        <div
            class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center">
                    <div
                        class="flex-shrink-0 bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-4 shadow-md transform transition-transform duration-300 hover:scale-105">
                        <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-semibold text-red-600 truncate">Total Expenses</dt>
                            <dd>
                                <div class="text-2xl font-bold text-red-600 mt-1">
                                    @currency(auth()->user()->transactions()->expense()->sum('amount'), auth()->user()->currency)
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Income Card -->
        <div
            class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center">
                    <div
                        class="flex-shrink-0 bg-gradient-to-r from-green-500 to-green-600 rounded-lg p-4 shadow-md transform transition-transform duration-300 hover:scale-105">
                        <svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-semibold text-green-600 truncate">Total Income</dt>
                            <dd>
                                <div class="text-2xl font-bold text-green-600 mt-1">
                                    @currency(auth()->user()->transactions()->income()->sum('amount'), auth()->user()->currency)
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Recent Transactions -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="h-6 w-6 text-indigo-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Transaksi Terbaru
                </h2>
                <div class="overflow-x-auto">
                    @if (auth()->user()->transactions->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gradient-to-r from-[#2C895D] to-[#246DA4]">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Tanggal</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Kategori</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                        Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach (auth()->user()->transactions()->latest()->take(5)->get() as $transaction)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                                            {{ $transaction->transaction_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="h-8 w-8 rounded-full flex items-center justify-center {{ $transaction->type === 'expense' ? 'bg-red-100 text-red-500' : 'bg-green-100 text-green-500' }}">
                                                    @if ($transaction->type === 'expense')
                                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                                        </svg>
                                                    @else
                                                        <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                                        </svg>
                                                    @endif
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $transaction->category->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $transaction->description }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $transaction->type === 'expense' ? 'text-red-600' : 'text-green-600' }}">
                                            {{ $transaction->type === 'expense' ? '-' : '+' }}@currency($transaction->amount, auth()->user()->currency)
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-12 text-gray-500 bg-gray-50 rounded-lg">
                            <svg class="h-12 w-12 text-gray-400 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                            </svg>
                            <p class="text-lg">Belum ada transaksi</p>
                            <a href="{{ route('transactions') }}"
                                class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Tambah Transaksi
                            </a>
                        </div>
                    @endif
                </div>
                <div class="mt-6 text-right">
                    <a href="{{ route('transactions') }}"
                        class="text-indigo-600 hover:text-indigo-900 text-sm font-medium inline-flex items-center">
                        Lihat semua transaksi
                        <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Budget Overview -->
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Budget</h2>
                <div class="space-y-4">
                    @if (auth()->user()->budgets->count() > 0)
                        @foreach (auth()->user()->budgets()->latest()->take(3)->get() as $budget)
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="flex justify-between items-center mb-2">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $budget->notes }}</h3>
                                    <span class="text-xs text-gray-500">{{ $budget->start_date->format('d M Y') }} -
                                        {{ $budget->end_date->format('d M Y') }}</span>
                                </div>
                                <div class="relative pt-1">
                                    <div class="flex mb-2 items-center justify-between">
                                        <div>
                                            <span class="text-xs font-semibold inline-block text-indigo-600">
                                                @currency($budget->transactions->sum('amount'), auth()->user()->currency) /
                                                @currency($budget->total_amount, auth()->user()->currency)
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span
                                                class="text-xs font-semibold inline-block {{ ($budget->transactions->sum('amount') / $budget->total_amount) * 100 > 80 ? 'text-red-600' : 'text-green-600' }}">
                                                {{ round(($budget->transactions->sum('amount') / $budget->total_amount) * 100) }}%
                                            </span>
                                        </div>
                                    </div>
                                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-gray-200">
                                        <div style="width:{{ ($budget->transactions->sum('amount') / $budget->total_amount) * 100 }}%"
                                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center {{ ($budget->transactions->sum('amount') / $budget->total_amount) * 100 > 80 ? 'bg-red-500' : 'bg-green-500' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-gray-500">Belum ada budget</div>
                    @endif
                </div>
                <div class="mt-4 text-right">
                    <a href="{{ route('budgets') }}"
                        class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Lihat semua budget →</a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Category Spending -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="h-6 w-6 text-indigo-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                    </svg>
                    Pengeluaran per Kategori
                </h2>
                @if (auth()->user()->categories->count() > 0)
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-full h-64 flex items-center justify-center">
                            <canvas id="categoryChart" width="200" height="200"></canvas>
                        </div>
                        <div class="w-full mt-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                            @foreach (auth()->user()->categories()->withCount([
            'transactions as spent' => function ($query) {
                $query->where('type', 'expense')->select(DB::raw('sum(amount)'));
            },
        ])->orderByDesc('spent')->take(5)->get() as $category)
                                {{-- <div class="flex flex-col items-center p-3 rounded-lg border border-gray-100 hover:shadow-md transition-all">
                                    <div class="flex items-center mb-2">
                                        <div class="w-3 h-3 rounded-full category-color"
                                            data-category="{{ $category->name }}"></div>
                                        <span class="ml-2 text-sm font-medium text-gray-900">{{ $category->name }}</span>
                                    </div>
                                    <span class="text-sm font-bold text-gray-900">@currency($category->spent, auth()->user()->currency)</span>
                                    @if ($category->monthly_limit > 0)
                                        <div class="text-xs text-gray-500 text-center mt-1">
                                            {{ round(($category->spent / $category->monthly_limit) * 100) }}% dari limit
                                            <div>@currency($category->monthly_limit, auth()->user()->currency)</div>
                                        </div>
                                    @endif
                                </div> --}}
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500 bg-gray-50 rounded-lg">
                        <svg class="h-12 w-12 text-gray-400 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="text-lg">Belum ada kategori</p>
                        <a href="{{ route('categories') }}"
                            class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Tambah Kategori
                        </a>
                    </div>
                @endif
                <div class="mt-6 text-right">
                    <a href="{{ route('categories') }}"
                        class="text-indigo-600 hover:text-indigo-900 text-sm font-medium inline-flex items-center">
                        Lihat semua kategori
                        <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Savings Goals -->
        <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-all duration-300">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="h-6 w-6 text-indigo-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Target Tabungan
                </h2>
                <div class="space-y-4">
                    @if (auth()->user()->goals->count() > 0)
                        @foreach (auth()->user()->goals()->latest()->take(3)->get() as $goal)
                            <div
                                class="border border-gray-200 rounded-lg p-5 hover:border-indigo-300 transition-colors duration-300 bg-white hover:bg-indigo-50">
                                <div class="flex justify-between items-center mb-3">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $goal->name }}</h3>
                                    <span
                                        class="px-3 py-1 text-xs font-medium rounded-full {{ $goal->isAchieved() ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $goal->isAchieved() ? 'Tercapai' : 'Dalam Proses' }}
                                    </span>
                                </div>
                                <div class="relative pt-1">
                                    <div class="flex mb-2 items-center justify-between">
                                        <div>
                                            <span class="text-sm font-bold inline-block text-indigo-600">
                                                @currency($goal->current_amount, auth()->user()->currency) / @currency($goal->target_amount, auth()->user()->currency)
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-sm font-bold inline-block text-indigo-600">
                                                {{ $goal->progress_percentage }}%
                                            </span>
                                        </div>
                                    </div>
                                    <div class="overflow-hidden h-3 mb-4 text-xs flex rounded-full bg-gray-200">
                                        <div style="width:{{ $goal->progress_percentage }}%"
                                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-gradient-to-r from-indigo-500 to-purple-600 transition-all duration-500 ease-in-out">
                                        </div>
                                    </div>
                                    <div class="flex justify-between items-center text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <svg class="h-4 w-4 text-gray-500 mr-1" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            Target: {{ $goal->target_date->format('d M Y') }}
                                        </div>
                                        @if (!$goal->isAchieved())
                                            <div class="text-indigo-600 font-medium">
                                                {{ $goal->target_date->diffForHumans() }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-12 text-gray-500 bg-gray-50 rounded-lg">
                            <svg class="h-12 w-12 text-gray-400 mx-auto mb-3" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-lg">Belum ada target tabungan</p>
                            <a href="{{ route('goals') }}"
                                class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Tambah Target
                            </a>
                        </div>
                    @endif
                </div>
                <div class="mt-6 text-right">
                    <a href="{{ route('goals') }}"
                        class="text-indigo-600 hover:text-indigo-900 text-sm font-medium inline-flex items-center">
                        Lihat semua target
                        <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah elemen canvas ada
        const chartCanvas = document.getElementById('categoryChart');
        if (!chartCanvas) return;

        // Ambil data kategori
        const categories = [];
        const amounts = [];
        const colors = [
            '#4F46E5', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
            '#EC4899', '#06B6D4', '#F97316', '#84CC16', '#6366F1'
        ];

        // Ambil data dari elemen HTML
        @if (auth()->user()->categories->count() > 0)
            @foreach (auth()->user()->categories()->withCount([
            'transactions as spent' => function ($query) {
                $query->where('type', 'expense')->select(DB::raw('sum(amount)'));
            },
        ])->orderByDesc('spent')->take(5)->get() as $index => $category)
                categories.push('{{ $category->name }}');
                amounts.push({{ $category->spent ?: 0 }});
                // Set warna untuk indikator kategori
                document.querySelectorAll('.category-color[data-category="{{ $category->name }}"]')
                    .forEach(el => {
                        el.style.backgroundColor = colors[{{ $index }} % colors.length];
                    });
            @endforeach
        @endif

        // Buat chart
        if (categories.length > 0) {
            const ctx = chartCanvas.getContext('2d');
            const categoryChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: categories,
                    datasets: [{
                        data: amounts,
                        backgroundColor: colors.slice(0, categories.length),
                        borderWidth: 1,
                        borderColor: '#fff',
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const currency = '{{ auth()->user()->currency }}';
                                    const percentage = Math.round((value / amounts.reduce((a, b) =>
                                        a + b, 0)) * 100);

                                    // Format mata uang sesuai dengan kode mata uang
                                    let formattedValue = new Intl.NumberFormat('id-ID', {
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 0
                                    }).format(value);

                                    let currencySymbol = '';
                                    switch (currency) {
                                        case 'IDR':
                                            currencySymbol = 'Rp. ';
                                            break;
                                        case 'USD':
                                            currencySymbol = '$ ';
                                            break;
                                        case 'EUR':
                                            currencySymbol = '€ ';
                                            break;
                                        case 'SGD':
                                            currencySymbol = 'S$ ';
                                            break;
                                        case 'MYR':
                                            currencySymbol = 'RM ';
                                            break;
                                        default:
                                            currencySymbol = '';
                                            break;
                                    }

                                    return `${label}: ${currencySymbol}${formattedValue} (${percentage}%)`;
                                }
                            }
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });

            // Membuat chart responsif
            window.addEventListener('resize', function() {
                categoryChart.resize();
            });
        }
    });
</script>
