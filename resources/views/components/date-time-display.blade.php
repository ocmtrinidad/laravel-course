@props(['post'])

<span class="{{ $post->checkPublishedAtTime() ? 'text-red-600' : '' }}">
    {{ $post->checkPublishedAtTime() ? $post->formattedPublishedAt() : $post->formattedCreatedAt() }}
</span>
