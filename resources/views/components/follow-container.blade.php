@props(['user'])

{{-- x-data="{}" turns element to Alpine.js with js object --}}
<div {{ $attributes }} x-data="{
    followerCount: {{ $user->followers()->count() }},
    following: {{ $user->isFollowedBy(auth()->user()) ? 'true' : 'false' }},
    follow() {
        {{-- Alpine.js uses axios to handle requests --}}
        axios.post('/follow/{{ $user->id }}')
            .then(res => {
                this.following = !this.following
                this.followerCount = res.data.followerCount
            })
            .catch(err => {
                console.log(err)
            })
    },
}">
    {{ $slot }}
</div>
