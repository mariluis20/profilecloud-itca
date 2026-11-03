@extends('layouts.app')

@section('title', 'Directorio de perfiles')

@section('content')
<section class="pc-page-head">
    <div class="container">
        <span class="pc-eyebrow">Directorio</span>
        <h1>Talento ITCA</h1>
        <p>Explora perfiles de estudiantes por nombre, habilidad, carrera o sede.</p>
    </div>
</section>

<section class="container" style="margin-top: -28px; position: relative; z-index: 3;">
    <form method="GET" action="{{ route('directory.index') }}" class="pc-panel reveal">
        <div class="row g-3 align-items-end">
            <div class="col-lg-4">
                <label for="q" class="form-label">Buscar</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="search" id="q" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nombre, habilidad o tecnología">
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <label for="carrera" class="form-label">Carrera</label>
                <select id="carrera" name="carrera" class="form-select">
                    <option value="">Todas</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera }}" @selected(request('carrera') === $carrera)>{{ $carrera }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 col-lg-2">
                <label for="sede" class="form-label">Sede</label>
                <select id="sede" name="sede" class="form-select">
                    <option value="">Todas</option>
                    @foreach($sedes as $sede)
                        <option value="{{ $sede }}" @selected(request('sede') === $sede)>{{ $sede }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-3 d-flex gap-2 align-items-center flex-wrap">
                <div class="form-check form-switch me-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="disponible" name="disponible" value="1" @checked(request()->boolean('disponible'))>
                    <label class="form-check-label small" for="disponible">Disponibles</label>
                </div>
                <button class="btn btn-pc flex-grow-1" type="submit">Filtrar</button>
                @if(request()->hasAny(['q', 'carrera', 'sede', 'disponible']))
                    <a href="{{ route('directory.index') }}" class="btn btn-ghost" title="Limpiar filtros"><i class="bi bi-x-lg"></i></a>
                @endif
            </div>
        </div>
    </form>
</section>

<section class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <p class="text-muted mb-0">
            <strong class="text-dark">{{ $profiles->total() }}</strong> {{ $profiles->total() === 1 ? 'perfil encontrado' : 'perfiles encontrados' }}
        </p>
    </div>

    @if($profiles->isEmpty())
        <div class="pc-panel pc-empty reveal">
            <i class="bi bi-search"></i>
            <h3 class="h4 mt-3">Sin resultados</h3>
            <p class="mb-0">Prueba con otra palabra o quita algunos filtros.</p>
        </div>
    @else
        <div class="row g-4">
            @foreach($profiles as $i => $profile)
                <div class="col-md-6 col-lg-4 reveal" data-delay="{{ ($i % 3) + 1 }}">
                    @include('partials.profile-card', ['profile' => $profile])
                </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-5">
            {{ $profiles->links() }}
        </div>
    @endif
</section>
@endsection
