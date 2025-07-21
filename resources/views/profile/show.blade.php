<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full flex">
                    <div class="flex-1 pr-8">
                        <h1 class="text-5xl">{{ $user->name }}</h1>
                        <div class="mt-8">
                            @forelse ($posts as $post)
                                <x-post-item :$post />
                            @empty
                                <div class="text-center">
                                    <p class="text-gray-400 py-16">No Posts Found</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    {{-- x-data="{}" turns element to Alpine.js with js object --}}
                    <x-follow-container :$user class="w-[320px] border-l px-8">
                        <x-user-avatar :$user size="w-24 h-24" />
                        <h3>{{ $user->name }}</h3>
                        <p>
                            <span class="text-gray-500" x-text="followerCount"></span>
                            Followers
                        </p>
                        <p>{{ $user->bio }}</p>
                        @if (auth()->user() && auth()->user()->id !== $user->id)
                            <div>
                                {{-- @click calls follow() from x-data to change following variable --}}
                                {{-- Looks like there is an error with follow(), but it is correct  --}}
                                {{-- x-text uses Alpine.js to output a text --}}
                                {{-- :class uses Alpine.js to determine class --}}
                                <button @click="follow()" class="rounded-full px-4 py-2 text-white"
                                    x-text="following ? 'Unfollow' : 'Follow'":class="following ? 'bg-red-600' : 'bg-emerald-600'">
                                </button>
                            </div>
                        @endif
                    </x-follow-container>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
