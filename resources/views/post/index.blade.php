{{-- Uses layout from the view() of /app/View/Components/AppLayout.php --}}
<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 text-gray-900">
                    {{-- Pass values to component with key=value --}}
                    {{-- Add a : prefix if passing a variable --}}
                    <x-category-tabs>
                        {{-- Passing values inside tags will be output as {{slot}} --}}
                        No Categories
                    </x-category-tabs>
                </div>
            </div>

            <div class="mt-4">
                @if (Route::currentRouteNamed('myPosts'))
                    <h2 class="font-bold text-2xl">{{ auth()->user()->name }}'s Posts:</h2>
                @endif

                <div>
                    @forelse ($posts as $post)
                        {{-- Equivalent to :post="$post" --}}
                        <x-post-item :$post />
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
