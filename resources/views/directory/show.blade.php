@extends('layouts.app')

@section('title', $profile->user->name)

@section('content')
<section class="pc-page-head" style="padding-bottom: 96px;">
    <span class="pc-blob b1"></span>
    <div class="container">
        <div class="d-flex flex-column flex-md-row align-items-md-center gap-4">
            @include('partials.avatar', ['profile' => $profile, 'class' => 'pc-avatar-xl'])
            <div class="flex-grow-1">
                <span class="pc-eyebrow">Perfil profesional</span>
                <h1>{{ $profile->user->name }}</h1>
                <p class="fs-5 mb-3">{{ $profile->headline ?: 'Estudiante ITCA-FEPADE' }}</p>
                <div>
                    @if($profile->carrera)<span class="pc-chip ghost"><i class="bi bi-mortarboard"></i>{{ $profile->carrera }}</span>@endif
                    @if($profile->sede)<span class="pc-chip ghost"><i class="bi bi-geo-alt"></i>Sede {{ $profile->sede }}</span>@endif
                    @if($profile->ciclo)<span class="pc-chip ghost"><i class="bi bi-calendar3"></i>Ciclo {{ $profile->ciclo }}</span>@endif
                    @if($profile->available)<span class="pc-chip gold"><i class="bi bi-briefcase"></i>Disponible para pasantía</span>@endif
                </div>
            </div>
            @if($isOwner)
                <div>
                    <a href="{{ route('student.profile.edit') }}" class="btn btn-gold"><i class="bi bi-pencil-square me-1"></i>Editar perfil</a>
                </div>
            @endif
        </div>
        @unless($profile->isVisible())
            <div class="alert alert-warning mt-4 mb-0 rounded-4">
                <i class="bi bi-eye-slash me-1"></i> Este perfil no es público. Solo tú y los administradores pueden verlo.
            </div>
        @endunless
    </div>
</section>

<section class="container" style="margin-top: -40px; position: relative; z-index: 3;">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="pc-panel reveal">
                <div class="pc-panel-title"><i class="bi bi-person-lines-fill"></i>Acerca de mí</div>
                @if($profile->bio)
                    <p class="mb-0" style="white-space: pre-line; line-height: 1.75;">{{ $profile->bio }}</p>
                @else
                    <p class="text-muted mb-0">Este estudiante aún no ha escrito su biografía.</p>
                @endif
            </div>

            <div class="pc-panel reveal">
                <div class="pc-panel-title"><i class="bi bi-kanban"></i>Proyectos <span class="pc-chip gold ms-1 mb-0">{{ $profile->projects->count() }}</span></div>
                @forelse($profile->projects as $project)
                    <div class="pc-project">
                        <div class="d-flex justify-content-between flex-wrap gap-2">
                            <h4>{{ $project->title }}</h4>
                            @if($project->year)<small class="text-muted">{{ $project->year }}</small>@endif
                        </div>
                        <p class="text-muted mb-3">{{ $project->description }}</p>
                        <div class="d-flex justify-content-between flex-wrap gap-2 align-items-center">
                            <div>
                                @foreach($project->tech_list as $tech)
                                    <span class="pc-chip">{{ $tech }}</span>
                                @endforeach
                            </div>
                            <div class="d-flex gap-2">
                                @if($project->repo_url)
                                    <a href="{{ $project->repo_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-ghost btn-sm"><i class="bi bi-github me-1"></i>Código</a>
                                @endif
                                @if($project->demo_url)
                                    <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-pc btn-sm"><i class="bi bi-box-arrow-up-right me-1"></i>Demo</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">Todavía no hay proyectos publicados.</p>
                @endforelse
            </div>
        </div>

        <div class="col-lg-4">
            <div class="pc-panel reveal">
                <div class="pc-panel-title"><i class="bi bi-lightning-charge"></i>Habilidades</div>
                @forelse($profile->skills as $skill)
                    <div class="pc-skill">
                        <div class="top"><span class="fw-semibold">{{ $skill->name }}</span><small>{{ $skill->level_label }}</small></div>
                        <div class="pc-bar"><span data-width="{{ $skill->percent }}"></span></div>
                    </div>
                @empty
                    <p class="text-muted mb-0">Sin habilidades registradas.</p>
                @endforelse
            </div>

            <div class="pc-panel reveal">
                <div class="pc-panel-title"><i class="bi bi-link-45deg"></i>Contacto y enlaces</div>
                <div class="d-grid gap-2">
                    @auth
                        <a href="mailto:{{ $profile->user->email }}" class="btn btn-pc"><i class="bi bi-envelope me-1"></i>{{ $profile->user->email }}</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-ghost"><i class="bi bi-lock me-1"></i>Inicia sesión para ver el correo</a>
                    @endauth
                    @if($profile->linkedin_url)
                        <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-pc"><i class="bi bi-linkedin me-1"></i>LinkedIn</a>
                    @endif
                    @if($profile->github_url)
                        <a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-pc"><i class="bi bi-github me-1"></i>GitHub</a>
                    @endif
                    @if($profile->website_url)
                        <a href="{{ $profile->website_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-pc"><i class="bi bi-globe2 me-1"></i>Sitio web</a>
                    @endif
                </div>
            </div>

            <div class="pc-panel reveal text-center">
                <small class="text-muted d-block mb-2">Enlace para compartir</small>
                <code class="d-block text-break small">{{ route('directory.show', $profile) }}</code>
            </div>
        </div>
    </div>
</section>
@endsection
