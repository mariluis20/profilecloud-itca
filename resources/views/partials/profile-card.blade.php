@php($projectsTotal = $profile->projects_count ?? $profile->projects->count())
<article class="pc-card">
    @if($profile->available)
        <span class="pc-available"><span class="dot"></span>Disponible</span>
    @endif
    <div class="pc-card-top"></div>
    <div class="pc-card-body">
        @include('partials.avatar', ['profile' => $profile])
        <h3>{{ $profile->user->name }}</h3>
        <p class="headline mb-2">{{ $profile->headline ?: 'Estudiante ITCA-FEPADE' }}</p>
        <div class="mb-2">
            @if($profile->carrera)
                <span class="pc-chip gold"><i class="bi bi-mortarboard"></i>{{ \Illuminate\Support\Str::limit($profile->carrera, 34) }}</span>
            @endif
            @if($profile->sede)
                <span class="pc-chip gold"><i class="bi bi-geo-alt"></i>{{ $profile->sede }}</span>
            @endif
        </div>
        <div class="mb-3">
            @foreach($profile->skills->take(4) as $skill)
                <span class="pc-chip">{{ $skill->name }}</span>
            @endforeach
            @if($profile->skills->count() > 4)
                <span class="pc-chip">+{{ $profile->skills->count() - 4 }}</span>
            @endif
        </div>
        <div class="pc-card-foot">
            <span><i class="bi bi-kanban me-1"></i>{{ $projectsTotal }} {{ (int) $projectsTotal === 1 ? 'proyecto' : 'proyectos' }}</span>
            <a href="{{ route('directory.show', $profile) }}">Ver perfil <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</article>
