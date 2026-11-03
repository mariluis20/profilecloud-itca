@extends('layouts.app')

@section('title', 'Mi panel')

@section('content')
<section class="pc-page-head">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3">
            <div>
                <span class="pc-eyebrow">Mi panel</span>
                <h1>Hola, {{ \Illuminate\Support\Str::of($user->name)->explode(' ')->first() }}</h1>
                <p>Administra tu perfil, tus habilidades y tus proyectos.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('directory.show', $profile) }}" class="btn btn-outline-light-pc"><i class="bi bi-eye me-1"></i>Ver perfil público</a>
                <a href="{{ route('student.profile.edit') }}" class="btn btn-gold"><i class="bi bi-pencil-square me-1"></i>Editar perfil</a>
            </div>
        </div>
    </div>
</section>

<section class="container" style="margin-top: -28px; position: relative; z-index: 3;">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="pc-panel reveal text-center">
                <div class="pc-panel-title justify-content-center"><i class="bi bi-graph-up-arrow"></i>Perfil completado</div>
                <div class="pc-ring" style="--p: {{ $completion }};" data-label="{{ $completion }}%"></div>
                @php
                    $checks = [
                    'Titular profesional' => filled($profile->headline),
                    'Biografía' => filled($profile->bio),
                    'Carrera y sede' => filled($profile->carrera) && filled($profile->sede),
                    'Foto de perfil' => filled($profile->photo_path),
                    'Al menos un enlace' => filled($profile->github_url) || filled($profile->linkedin_url) || filled($profile->website_url),
                    '3 habilidades o más' => $profile->skills->count() >= 3,
                    'Al menos un proyecto' => $profile->projects->count() >= 1,
                    ];
                @endphp
                <ul class="pc-list-check text-start mt-4 mb-0 ps-0">
                    @foreach($checks as $label => $done)
                        <li class="{{ $done ? 'done' : '' }}"><i class="bi {{ $done ? 'bi-check-circle-fill' : 'bi-circle' }}"></i>{{ $label }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="pc-panel reveal">
                <div class="pc-panel-title"><i class="bi bi-shield-check"></i>Visibilidad</div>
                <p class="mb-2">
                    @if($profile->is_public)
                        <span class="pc-chip success"><i class="bi bi-globe2"></i>Perfil público</span>
                    @else
                        <span class="pc-chip"><i class="bi bi-eye-slash"></i>Perfil privado</span>
                    @endif
                    @if($profile->available)
                        <span class="pc-chip gold"><i class="bi bi-briefcase"></i>Disponible</span>
                    @endif
                </p>
                <small class="text-muted">Puedes cambiar esto desde <a href="{{ route('student.profile.edit') }}">Editar perfil</a>.</small>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="pc-panel reveal">
                <div class="pc-panel-title"><i class="bi bi-lightning-charge"></i>Mis habilidades <span class="pc-chip gold ms-1 mb-0">{{ $profile->skills->count() }}/20</span></div>

                <form method="POST" action="{{ route('student.skills.store') }}" class="row g-2 mb-4">
                    @csrf
                    <div class="col-md-6">
                        <input type="text" name="name" value="{{ old('name') }}" maxlength="50"
                               class="form-control @error('name') is-invalid @enderror" placeholder="Ej. Laravel, Linux, Figma" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4">
                        <select name="level" class="form-select @error('level') is-invalid @enderror" required>
                            @foreach($levels as $value => $label)
                                <option value="{{ $value }}" @selected((int) old('level', 3) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-pc" type="submit"><i class="bi bi-plus-lg"></i></button>
                    </div>
                </form>

                @forelse($profile->skills as $skill)
                    <div class="pc-skill d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <div class="top"><span class="fw-semibold">{{ $skill->name }}</span><small>{{ $skill->level_label }}</small></div>
                            <div class="pc-bar"><span data-width="{{ $skill->percent }}"></span></div>
                        </div>
                        <form method="POST" action="{{ route('student.skills.destroy', $skill) }}" data-confirm="¿Eliminar la habilidad {{ $skill->name }}?">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-ghost btn-sm" type="submit" title="Eliminar"><i class="bi bi-trash3"></i></button>
                        </form>
                    </div>
                @empty
                    <p class="text-muted mb-0">Agrega tu primera habilidad con el formulario de arriba.</p>
                @endforelse
            </div>

            <div class="pc-panel reveal">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="pc-panel-title mb-0"><i class="bi bi-kanban"></i>Mis proyectos</div>
                    <a href="{{ route('student.projects.create') }}" class="btn btn-pc btn-sm"><i class="bi bi-plus-lg me-1"></i>Nuevo proyecto</a>
                </div>
                @forelse($profile->projects as $project)
                    <div class="pc-project">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <div>
                                <h4>{{ $project->title }}</h4>
                                <p class="text-muted small mb-2">{{ \Illuminate\Support\Str::limit($project->description, 140) }}</p>
                                @foreach($project->tech_list as $tech)
                                    <span class="pc-chip">{{ $tech }}</span>
                                @endforeach
                            </div>
                            <div class="d-flex gap-1 flex-shrink-0">
                                <a href="{{ route('student.projects.edit', $project) }}" class="btn btn-ghost btn-sm" title="Editar"><i class="bi bi-pencil"></i></a>
                                <form method="POST" action="{{ route('student.projects.destroy', $project) }}" data-confirm="¿Eliminar el proyecto {{ $project->title }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-ghost btn-sm" type="submit" title="Eliminar"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="pc-empty py-4">
                        <i class="bi bi-folder-plus"></i>
                        <p class="mt-2 mb-0">Aún no tienes proyectos. ¡Publica el primero!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
