<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <h1 class="text-2xl mb-4">{{ $post->title }}</h1>
                <div class="flex gap-4">
                    @if ($post->user->image)
                        <img class="w-12 h-12 rounded-full" src="{{ $post->user->imageUrl() }}"
                            alt="{{ $post->user->username }}">
                    @else
                        <img class="w-12 h-12 rounded-full"
                            src="https://w7.pngwing.com/pngs/510/812/png-transparent-organization-computer-icons-avatar-company-information-profile-miscellaneous-angle-company.png"
                            alt="Default Avatar">
                    @endif
                    <div>
                        <div class="flex gap-2">
                            <h3>{{ $post->user->name }}</h3>
                            <a href="#" class="text-emerald-500">Follow</a>
                        </div>
                        <div class="flex gap-2 text-gray-500 text-sm">
                            <p>{{ $post->readTime() }} min read</p>
                            {{-- format("M d, Y") cases can be changed, and "," can be removed --}}
                            <p>{{ $post->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                <x-clap-button>3.4k</x-clap-button>

                <div class="mt-8">
                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full">
                    <div class="mt-4">
                        {{ $post->content }}
                    </div>
                </div>

                <div class="mt-8">
                    <span class ="px-4 py-2 bg-gray-200 rounded-xl">{{ $post->category->name }}</span>
                </div>

                <x-clap-button>3.4k</x-clap-button>
            </div>
        </div>
    </div>
</x-app-layout>
