<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    {{-- Passing value to component key=value. If passing a variable, prefix with : --}}
                    <x-category-tabs>
                        {{-- Passing values inside tags will be output as {{slot}} --}}
                        No Categories
                    </x-category-tabs>
                </div>
            </div>

            <div class="mt-8">
                <div>
                    @forelse ($posts as $post)
                        {{-- Passing a variable to a component --}}
                        <x-post-item :post="$post" />
                    @empty
                        <div class="text-center">
                            <p class="text-gray-400 py-16">No Posts Found</p>
                        </div>
                    @endforelse
                </div>
                {{-- php artisan vendor:publish --tag=laravel-pagination to style pagination links  --}}
                {{ $posts->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
