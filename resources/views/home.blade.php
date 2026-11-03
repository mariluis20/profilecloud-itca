@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<section class="pc-hero">
    <span class="pc-blob b1"></span>
    <span class="pc-blob b2"></span>
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-7">
                <span class="pc-eyebrow anim d1">Escuela Especializada en Ingeniería · ITCA-FEPADE</span>
                <h1 class="anim d2">Tu talento, <em>visible</em><br>para el mundo.</h1>
                <p class="lead anim d3">
                    ProfileCloud reúne los perfiles, habilidades y proyectos de nuestros estudiantes en un solo lugar,
                    para que empresas y docentes descubran el talento que se forma en las aulas.
                </p>
                <form action="{{ route('directory.index') }}" method="GET" class="pc-hero-search mt-4 anim d4" role="search">
                    <i class="bi bi-search ms-3 align-self-center text-muted"></i>
                    <input type="search" name="q" placeholder="Busca por nombre, habilidad o tecnología…" aria-label="Buscar perfiles">
                    <button class="btn btn-pc" type="submit">Buscar</button>
                </form>
                <div class="d-flex flex-wrap gap-3 mt-4 anim d4">
                    <a href="{{ route('directory.index') }}" class="btn btn-gold"><i class="bi bi-people me-1"></i> Explorar perfiles</a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-light-pc"><i class="bi bi-person-plus me-1"></i> Crear mi perfil</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-light-pc"><i class="bi bi-speedometer2 me-1"></i> Ir a mi panel</a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                @php($hero = $featured->first())
                <div class="position-relative anim d3">
                    <div class="pc-hero-card-back"></div>
                    <div class="pc-hero-card">
                        @if($hero)
                            <div class="d-flex align-items-center gap-3 mb-3">
                                @include('partials.avatar', ['profile' => $hero, 'class' => 'mt-0'])
                                <div>
                                    <div class="pc-serif fw-bold fs-5">{{ $hero->user->name }}</div>
                                    <small class="text-muted">{{ $hero->headline }}</small>
                                </div>
                            </div>
                            @foreach($hero->skills->take(3) as $skill)
                                <div class="pc-skill">
                                    <div class="top"><span>{{ $skill->name }}</span><small>{{ $skill->level_label }}</small></div>
                                    <div class="pc-bar"><span style="width: {{ $skill->percent }}%"></span></div>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <span class="pc-chip gold mb-0"><i class="bi bi-mortarboard"></i>{{ \Illuminate\Support\Str::limit($hero->carrera, 28) }}</span>
                                <a href="{{ route('directory.show', $hero) }}" class="small fw-semibold">Ver perfil <i class="bi bi-arrow-right"></i></a>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-cloud-check fs-1" style="color: var(--pc-gold)"></i>
                                <p class="mt-3 mb-0 text-muted">Sé el primero en publicar tu perfil.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pc-stats">
    <div class="container">
        <div class="row g-3 g-lg-4">
            @foreach([
                ['icon' => 'bi-people', 'value' => $stats['estudiantes'], 'label' => 'Perfiles publicados'],
                ['icon' => 'bi-kanban', 'value' => $stats['proyectos'], 'label' => 'Proyectos compartidos'],
                ['icon' => 'bi-lightning-charge', 'value' => $stats['habilidades'], 'label' => 'Habilidades distintas'],
                ['icon' => 'bi-briefcase', 'value' => $stats['disponibles'], 'label' => 'Disponibles para pasantía'],
            ] as $i => $stat)
                <div class="col-6 col-lg-3">
                    <div class="pc-stat reveal" data-delay="{{ $i + 1 }}">
                        <i class="bi {{ $stat['icon'] }}"></i>
                        <div class="num mt-2" data-count="{{ $stat['value'] }}">0</div>
                        <div class="lbl">{{ $stat['label'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="pc-section">
    <div class="container">
        <div class="text-center mb-5 reveal">
            <span class="pc-eyebrow" style="color: var(--pc-gold)">Cómo funciona</span>
            <h2 class="pc-section-title mt-2">Tres pasos para destacar</h2>
            <div class="pc-divider"></div>
            <p class="pc-section-sub mx-auto">Un espacio institucional, ordenado y confiable para mostrar quién eres y lo que sabes hacer.</p>
        </div>
        <div class="row g-4">
            @foreach([
                ['icon' => 'bi-person-vcard', 'title' => 'Crea tu cuenta', 'text' => 'Regístrate con tu correo, elige tu carrera y obtén tu propio espacio dentro de la plataforma.'],
                ['icon' => 'bi-stars', 'title' => 'Muestra tu trabajo', 'text' => 'Agrega tu biografía, tus habilidades con su nivel y los proyectos que has desarrollado.'],
                ['icon' => 'bi-briefcase', 'title' => 'Conecta', 'text' => 'Empresas y docentes encuentran tu perfil en el directorio público y conocen tu potencial.'],
            ] as $i => $step)
                <div class="col-md-4">
                    <div class="pc-step reveal" data-delay="{{ $i + 1 }}">
                        <span class="n">0{{ $i + 1 }}</span>
                        <div class="icon"><i class="bi {{ $step['icon'] }}"></i></div>
                        <h3 class="h5 fw-bold">{{ $step['title'] }}</h3>
                        <p class="text-muted mb-0">{{ $step['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="pc-section pt-0">
    <div class="container">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4 reveal">
            <div>
                <span class="pc-eyebrow" style="color: var(--pc-gold)">Talento destacado</span>
                <h2 class="pc-section-title mt-2 mb-0">Perfiles recientes</h2>
                <div class="pc-divider mb-0"></div>
            </div>
            <a href="{{ route('directory.index') }}" class="btn btn-outline-pc">Ver todo el directorio <i class="bi bi-arrow-right ms-1"></i></a>
        </div>
        @if($featured->isEmpty())
            <div class="pc-panel pc-empty">
                <i class="bi bi-cloud"></i>
                <p class="mt-3 mb-0">Aún no hay perfiles publicados.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($featured as $i => $profile)
                    <div class="col-md-6 col-lg-4 reveal" data-delay="{{ ($i % 3) + 1 }}">
                        @include('partials.profile-card', ['profile' => $profile])
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@if($topSkills->isNotEmpty())
<section class="pc-section pt-0">
    <div class="container">
        <div class="pc-panel text-center reveal">
            <span class="pc-eyebrow" style="color: var(--pc-gold)">Lo que más dominan</span>
            <h2 class="pc-section-title mt-2">Habilidades populares</h2>
            <div class="pc-divider"></div>
            <div class="mt-3">
                @foreach($topSkills as $skill)
                    <a href="{{ route('directory.index', ['q' => $skill->name]) }}" class="pc-chip fs-6 px-3 py-2">
                        {{ $skill->name }} <span class="opacity-50 ms-1">{{ $skill->total }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

<section class="pc-section pt-0">
    <div class="container">
        <div class="pc-cta reveal">
            <div class="row align-items-center g-4 position-relative">
                <div class="col-lg-8">
                    <h2>¿Listo para que te <em>descubran</em>?</h2>
                    <p class="mb-0 text-white-50">Crea tu perfil en minutos y compártelo con un solo enlace en tu CV, LinkedIn o portafolio.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-gold btn-lg">Comenzar ahora</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-gold btn-lg">Ir a mi panel</a>
                    @endguest
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
