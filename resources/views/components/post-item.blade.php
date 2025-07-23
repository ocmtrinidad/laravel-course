<div>
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex mb-8">
        <div class="p-5 flex-1">
            <a
                href="{{ route('post.show', [
                    'username' => $post->user->username,
                    'post' => $post,
                ]) }}">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    {{ $post->title }}</h5>
            </a>
            <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $post->content }}
            </div>
            {{-- Passing username and post to post.show --}}
            <a href="">
                {{ $post->formattedCreatedAt() }}
            </a>
        </div>
        <a
            href="{{ route('post.show', [
                'username' => $post->user->username,
                'post' => $post,
            ]) }}">
            {{-- Get picture  --}}
            <img class="rounded-r-lg w-48 h-full object-cover" src="{{ $post->imageUrl('preview') }}" />
        </a>
    </div>
</div>
