@extends('layouts.app')

@php($editing = $project->exists)

@section('title', $editing ? 'Editar proyecto' : 'Nuevo proyecto')

@section('content')
<section class="pc-page-head">
    <div class="container">
        <a href="{{ route('dashboard') }}" class="text-white-50 small"><i class="bi bi-arrow-left me-1"></i>Volver al panel</a>
        <h1>{{ $editing ? 'Editar proyecto' : 'Nuevo proyecto' }}</h1>
        <p>Describe qué hiciste, con qué tecnologías y dónde se puede ver.</p>
    </div>
</section>

<section class="container" style="margin-top: -28px; position: relative; z-index: 3; max-width: 860px;">
    <form method="POST" action="{{ $editing ? route('student.projects.update', $project) : route('student.projects.store') }}" class="pc-panel reveal" novalidate>
        @csrf
        @if($editing)
            @method('PUT')
        @endif
        <div class="row g-3">
            <div class="col-md-9">
                <label for="title" class="form-label">Título del proyecto</label>
                <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" maxlength="120" class="form-control @error('title') is-invalid @enderror" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-3">
                <label for="year" class="form-label">Año</label>
                <input type="number" id="year" name="year" min="2000" max="2100" value="{{ old('year', $project->year ?? date('Y')) }}" class="form-control @error('year') is-invalid @enderror">
                @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="description" class="form-label">Descripción</label>
                <textarea id="description" name="description" rows="5" maxlength="2000" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $project->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
                <label for="technologies" class="form-label">Tecnologías</label>
                <input type="text" id="technologies" name="technologies" value="{{ old('technologies', $project->technologies) }}" maxlength="255" class="form-control @error('technologies') is-invalid @enderror" placeholder="Separadas por coma: Laravel, MariaDB, Bootstrap">
                @error('technologies')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="repo_url" class="form-label">Repositorio</label>
                <input type="url" id="repo_url" name="repo_url" value="{{ old('repo_url', $project->repo_url) }}" class="form-control @error('repo_url') is-invalid @enderror" placeholder="https://github.com/usuario/proyecto">
                @error('repo_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label for="demo_url" class="form-label">Demo en línea</label>
                <input type="url" id="demo_url" name="demo_url" value="{{ old('demo_url', $project->demo_url) }}" class="form-control @error('demo_url') is-invalid @enderror" placeholder="https://...">
                @error('demo_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('dashboard') }}" class="btn btn-ghost">Cancelar</a>
            <button type="submit" class="btn btn-pc"><i class="bi bi-check2 me-1"></i>{{ $editing ? 'Guardar cambios' : 'Publicar proyecto' }}</button>
        </div>
    </form>
</section>
@endsection
