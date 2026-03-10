<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Categories
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
                    <a href="{{ route('admin.platforms') }}" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                        Platforms
                    </a>
                    <a href="{{ route('admin.categories') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Categories
                    </a>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Add New Category -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-medium">Add New Category</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.categories') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                                    <input type="text" name="nom" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                                    <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                </div>
                                <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                                    Add Category
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Existing Categories -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-medium">Managed Categories ({{ $categories->count() }})</h3>
                        </div>
                        <div class="p-6">
                            @if($categories->count() > 0)
                                <div class="space-y-4">
                                    @foreach($categories as $category)
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                            <div class="flex-1">
                                                <div class="font-medium text-lg">{{ $category->nom }}</div>
                                                @if($category->description)
                                                    <div class="text-sm text-gray-600 mt-1">{{ $category->description }}</div>
                                                @endif
                                                <div class="text-sm text-blue-600 mt-2">
                                                    {{ $category->annonces_count }} annonce(s) associated
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                @if($category->annonces_count == 0)
                                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                                            Delete
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400 text-sm">Cannot delete</span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <p class="text-gray-500 mb-4">No managed categories found.</p>
                                    <p class="text-sm text-gray-400">Add your first category using the form on the left.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Legacy Categories -->
                    @if($legacyCategories->count() > 0)
                        <div class="bg-white rounded-lg shadow mt-8">
                            <div class="p-6 border-b">
                                <h3 class="text-lg font-medium">Legacy Categories (from annonces)</h3>
                                <p class="text-sm text-gray-600 mt-1">Categories that exist in annonces but not managed yet</p>
                            </div>
                            <div class="p-6">
                                <div class="space-y-3">
                                    @foreach($legacyCategories as $category)
                                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded">
                                            <div>
                                                <div class="font-medium">{{ $category->categorie }}</div>
                                                <div class="text-sm text-gray-600">{{ $category->count }} annonce(s)</div>
                                            </div>
                                            <div class="text-sm text-yellow-600">
                                                Legacy
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
