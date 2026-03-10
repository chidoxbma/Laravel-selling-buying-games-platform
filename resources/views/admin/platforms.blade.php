<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Platforms
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Navigation -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow">
                <div class="flex space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.platforms') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Platforms
                    </a>
                    <a href="{{ route('admin.categories') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        Categories
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Add New Platform -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-medium">Add New Platform</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.platforms') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Platform Name</label>
                                    <input type="text" name="nom" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                                    <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                                    Add Platform
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Existing Platforms -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-medium">Existing Platforms ({{ $platforms->count() }})</h3>
                        </div>
                        <div class="p-6">
                            @if($platforms->count() > 0)
                                <div class="space-y-4">
                                    @foreach($platforms as $platform)
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                            <div class="flex-1">
                                                <div class="font-medium text-lg">{{ $platform->nom }}</div>
                                                @if($platform->description)
                                                    <div class="text-sm text-gray-600 mt-1">{{ $platform->description }}</div>
                                                @endif>
                                                <div class="text-sm @if($platform->jeux_count > 0) text-red-600 @else text-blue-600 @endif mt-2">
                                                    {{ $platform->jeux_count }} game(s) associated
                                                    @if($platform->jeux_count > 0)
                                                        <span class="block text-xs text-gray-500 mt-1">
                                                            ⚠️ Cannot delete platform with games
                                                        </span>
                                                    @endif
                                                </div>
                                                @if($platform->jeux_count > 0)
                                                    <div class="mt-2">
                                                        <button onclick="toggleGames({{ $platform->id }})" class="text-xs text-blue-600 hover:text-blue-800">
                                                            Show games ({{ $platform->jeux_count }})
                                                        </button>
                                                        <div id="games-{{ $platform->id }}" class="hidden mt-2 p-2 bg-white rounded border text-xs">
                                                            @php
                                                                $games = \App\Models\Jeu::where('plateforme_id', $platform->id)->take(5)->get();
                                                            @endphp
                                                            @foreach($games as $game)
                                                                <div class="py-1">• {{ $game->nom }} (by {{ $game->user->name ?? 'Unknown' }})</div>
                                                            @endforeach
                                                            @if($platform->jeux_count > 5)
                                                                <div class="text-gray-500 italic">... and {{ $platform->jeux_count - 5 }} more</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                @if($platform->jeux_count == 0)
                                                    <form action="{{ route('admin.platforms.destroy', $platform->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this platform?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @else
                                                    <div class="text-center">
                                                        <span class="text-gray-400 text-sm block">Cannot delete</span>
                                                        <span class="text-xs text-gray-500">Has games</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <p class="text-gray-500 mb-4">No platforms found.</p>
                                    <p class="text-sm text-gray-400">Add your first platform using the form on the left.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
function toggleGames(platformId) {
    const gamesDiv = document.getElementById('games-' + platformId);
    if (gamesDiv.classList.contains('hidden')) {
        gamesDiv.classList.remove('hidden');
    } else {
        gamesDiv.classList.add('hidden');
    }
}
</script>
