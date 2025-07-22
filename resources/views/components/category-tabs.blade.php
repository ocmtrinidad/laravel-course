<ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400 justify-center">
    <li class="me-2">
        {{-- request('model') gets the binded route model in web.php. --}}
        <a href="{{ route('dashboard') }}"
            class="{{ request('category')
                ? ' inline-block px-4 py-2'
                : ' inline-block px-4 py-2 text-white bg-blue-600 rounded-lg active' }}">
            All
        </a>
    </li>
    @forelse ($categories as $category)
        <div>
            <li class="me-2">
                {{-- Route::currentRouteNamed('route_name') checks if url is the same as route_name --}}
                <a href="{{ route('post.byCategory', $category) }}"
                    class="{{ Route::currentRouteNamed('post.byCategory') && request('category')->id == $category->id
                        ? 'inline-block px-4 py-2 text-white bg-blue-600 rounded-lg active'
                        : 'inline-block px-4 py-2 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white' }}">
                    {{ $category->name }}
                </a>
            </li>
        </div>
    @empty
        {{ $slot }}
    @endforelse
</ul>
