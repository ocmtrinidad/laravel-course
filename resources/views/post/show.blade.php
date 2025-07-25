<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8 flex flex-col gap-4">
                <h1 class="text-2xl">{{ $post->title }}</h1>
                <div class="flex gap-4">
                    <x-user-avatar :user="$post->user" />
                    <div class="flex flex-col">

                        <x-follow-container :user="$post->user" class="flex gap-2">
                            <a href="{{ route('profile.show', ['user' => $post->user]) }}"
                                class="hover:underline">{{ $post->user->name }}</a>
                            @auth
                                @if (auth()->user()->id !== $post->user->id)
                                    <button @click=follow() :class="following ? 'text-red-600' : 'text-emerald-600'"
                                        x-text="following ? 'Unfollow' : 'Follow'">
                                    </button>
                                @endif
                            @endauth

                        </x-follow-container>

                        <div class="flex gap-2 text-gray-500 text-sm">
                            <p>{{ $post->readTime() }} min read</p>
                            <p>{{ $post->formattedCreatedAt() }}</p>
                        </div>
                    </div>
                </div>

                @auth
                    @if (auth()->user()->id === $post->user_id)
                        <div class="border-t pt-4">
                            <x-primary-button>
                                <a href="{{ route('post.edit', $post->slug) }}">Edit Post</a>
                            </x-primary-button>
                            <form action="{{ route('post.destroy', $post->id) }}" method="post" class="inline-block">
                                @csrf
                                @method('delete')
                                <x-danger-button>Delete Post</x-danger-button>
                            </form>
                        </div>
                    @endif
                @endauth

                <x-like-button :$post />

                <div>
                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full">
                    <div class="mt-4">
                        {{ $post->content }}
                    </div>
                </div>

                <div class="px-4 py-2 bg-gray-200 rounded-xl max-w-fit">
                    <a href="{{ route('post.byCategory', $post->category) }}">{{ $post->category->name }}</a>
                </div>

                <x-like-button :$post />
            </div>
        </div>
    </div>
</x-app-layout>
