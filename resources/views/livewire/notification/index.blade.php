<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
                    <h2 class="text-lg font-medium text-gray-900">Notifikasi</h2>
                    <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                        @if ($notifications->count() > 0)
                            <button wire:click="deleteAllNotifications" class="w-full sm:w-auto px-4 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Hapus Semua
                            </button>
                        @endif
                        @if ($unreadCount > 0)
                            <button wire:click="markAllAsRead" class="w-full sm:w-auto px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Tandai Semua Dibaca
                            </button>
                        @endif
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                        {{ session('message') }}
                    </div>
                @endif

                @if ($notifications->count() > 0)
                    <div class="space-y-4">
                        @foreach ($notifications as $notification)
                            <div class="p-4 rounded-md {{ $notification->is_read ? 'bg-gray-50' : 'bg-indigo-50 border-l-4 border-indigo-500' }} relative">
                                <div class="flex justify-between">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mr-3">
                                            @if ($notification->type == 'info')
                                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-blue-100">
                                                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </span>
                                            @elseif ($notification->type == 'warning')
                                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-yellow-100">
                                                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                    </svg>
                                                </span>
                                            @elseif ($notification->type == 'alert')
                                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-red-100">
                                                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </span>
                                            @elseif ($notification->type == 'success')
                                                <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-green-100">
                                                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="text-sm font-medium text-gray-900">{{ $notification->title }}</h3>
                                            <p class="mt-1 text-sm text-gray-600">{{ $notification->message }}</p>
                                            <p class="mt-1 text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2">
                                        @if (!$notification->is_read)
                                            <button wire:click="markAsRead({{ $notification->id }})" class="text-indigo-600 hover:text-indigo-900">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                        @endif
                                        <button wire:click="deleteNotification({{ $notification->id }})" class="text-red-600 hover:text-red-900">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada notifikasi</h3>
                        <p class="mt-1 text-sm text-gray-500">Anda belum memiliki notifikasi apapun.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
