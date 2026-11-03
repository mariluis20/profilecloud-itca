@if($profile->photo_url)
    <img src="{{ $profile->photo_url }}" alt="Foto de {{ $profile->user->name }}" class="pc-avatar {{ $class ?? '' }}">
@else
    <div class="pc-avatar {{ $class ?? '' }}" aria-hidden="true">{{ $profile->user->initials }}</div>
@endif
