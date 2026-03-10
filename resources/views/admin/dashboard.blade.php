<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Test Links (remove these once working) -->
            <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded">
                <p class="text-sm font-medium text-yellow-800 mb-2">Test Links:</p>
                <div class="flex space-x-4 text-sm">
                    <a href="/admin/dashboard" class="text-blue-600 hover:underline">/admin/dashboard</a>
                    <a href="/admin/platforms" class="text-blue-600 hover:underline">/admin/platforms</a>
                    <a href="/admin/categories" class="text-blue-600 hover:underline">/admin/categories</a>
                </div>
            </div>
            
            <!-- Navigation -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow">
                <div class="flex flex-wrap space-x-2 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        📊 Dashboard
                    </a>
                    <a href="{{ route('admin.platforms') }}" class="inline-block px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                        🎮 Platforms
                    </a>
                    <a href="{{ route('admin.categories') }}" class="inline-block px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                        📁 Categories
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['total_games'] }}</div>
                    <div class="text-sm text-gray-600">Total Games</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-2xl font-bold text-green-600">{{ $stats['total_platforms'] }}</div>
                    <div class="text-sm text-gray-600">Platforms</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['total_users'] }}</div>
                    <div class="text-sm text-gray-600">Total Users</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-2xl font-bold text-orange-600">{{ $stats['total_sellers'] }}</div>
                    <div class="text-sm text-gray-600">Sellers</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-2xl font-bold text-pink-600">{{ $stats['total_buyers'] }}</div>
                    <div class="text-sm text-gray-600">Buyers</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Games -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-medium">Recent Games</h3>
                    </div>
                    <div class="p-6">
                        @if($recentGames->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentGames as $game)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                        <div>
                                            <div class="font-medium">{{ $game->nom }}</div>
                                            <div class="text-sm text-gray-600">
                                                {{ $game->plateforme->nom ?? 'No Platform' }} • 
                                                ${{ number_format($game->prix, 2) }} • 
                                                {{ $game->user->name ?? 'Unknown' }}
                                            </div>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $game->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No games yet.</p>
                        @endif
                    </div>
                </div>

                <!-- Platforms Overview -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-medium">Platforms Overview</h3>
                    </div>
                    <div class="p-6">
                        @if($platforms->count() > 0)
                            <div class="space-y-3">
                                @foreach($platforms as $platform)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                        <div>
                                            <div class="font-medium">{{ $platform->nom }}</div>
                                            <div class="text-sm text-gray-600">{{ $platform->jeux_count }} games</div>
                                        </div>
                                        <div class="text-sm text-blue-600">
                                            <a href="{{ route('admin.platforms') }}">Manage</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">No platforms yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
