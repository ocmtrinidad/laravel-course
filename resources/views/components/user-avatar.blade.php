@props(['user', 'size' => 'w-12 h-12'])

@if ($user->image)
    <img class="{{ $size }} rounded-full" src="{{ $user->imageUrl() }}" alt="{{ $user->name }}">
@else
    <img class="{{ $size }} rounded-full"
        src="https://w7.pngwing.com/pngs/510/812/png-transparent-organization-computer-icons-avatar-company-information-profile-miscellaneous-angle-company.png"
        alt="Default Avatar">
@endif
