<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="ProfileCloud ITCA: directorio de perfiles profesionales y proyectos de estudiantes.">
    <title>@yield('title', 'Inicio') · ProfileCloud ITCA</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/logo.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600;1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/profilecloud.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg pc-navbar fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand pc-brand" href="{{ route('home') }}">
            <img src="{{ asset('img/logo.svg') }}" class="pc-logo" alt="">
            <span>Profile<strong>Cloud</strong></span>
            <small>ITCA</small>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Abrir menú">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('directory.*') ? 'active' : '' }}" href="{{ route('directory.index') }}">Perfiles</a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Iniciar sesión</a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-pc btn-sm px-3" href="{{ route('register') }}">
                            <i class="bi bi-person-plus me-1"></i> Crear mi perfil
                        </a>
                    </li>
                @else
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Administración</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard', 'student.*') ? 'active' : '' }}" href="{{ route('dashboard') }}">Mi panel</a>
                        </li>
                    @endif
                    <li class="nav-item dropdown ms-lg-2 d-none d-lg-block">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="pc-avatar-sm">{{ auth()->user()->initials }}</span>
                            <span class="d-lg-none">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 p-2">
                            <li class="px-3 py-2">
                                <div class="fw-semibold">{{ auth()->user()->name }}</div>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            @if(auth()->user()->isStudent() && auth()->user()->profile)
                                <li><a class="dropdown-item rounded-3" href="{{ route('directory.show', auth()->user()->profile) }}"><i class="bi bi-person-badge me-2"></i>Ver mi perfil público</a></li>
                                <li><a class="dropdown-item rounded-3" href="{{ route('student.profile.edit') }}"><i class="bi bi-pencil-square me-2"></i>Editar perfil</a></li>
                            @endif
                            @if(auth()->user()->isAdmin())
                                <li><a class="dropdown-item rounded-3" href="{{ route('admin.users') }}"><i class="bi bi-people me-2"></i>Usuarios</a></li>
                                <li><a class="dropdown-item rounded-3" href="{{ route('admin.logs') }}"><i class="bi bi-journal-text me-2"></i>Bitácora</a></li>
                            @endif
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item rounded-3 text-danger"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item d-lg-none border-top mt-2 pt-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="pc-avatar-sm">{{ auth()->user()->initials }}</span>
                            <div>
                                <div class="fw-semibold">{{ auth()->user()->name }}</div>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </div>
                        </div>
                    </li>
                    @if(auth()->user()->isStudent() && auth()->user()->profile)
                        <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('directory.show', auth()->user()->profile) }}"><i class="bi bi-person-badge me-2"></i>Ver mi perfil público</a></li>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('student.profile.edit') }}"><i class="bi bi-pencil-square me-2"></i>Editar perfil</a></li>
                    @endif
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('admin.users') }}"><i class="bi bi-people me-2"></i>Usuarios</a></li>
                        <li class="nav-item d-lg-none"><a class="nav-link" href="{{ route('admin.logs') }}"><i class="bi bi-journal-text me-2"></i>Bitácora</a></li>
                    @endif
                    <li class="nav-item d-lg-none mt-2">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-pc w-100"><i class="bi bi-box-arrow-right me-1"></i>Cerrar sesión</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<div class="pc-toasts" aria-live="polite">
    @if(session('success'))
        <div class="pc-toast" role="status">
            <i class="bi bi-check-circle-fill"></i>
            <div class="flex-grow-1">{{ session('success') }}</div>
            <button type="button" class="btn-close btn-sm" data-close aria-label="Cerrar"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="pc-toast error" role="alert">
            <i class="bi bi-exclamation-octagon-fill"></i>
            <div class="flex-grow-1">{{ session('error') }}</div>
            <button type="button" class="btn-close btn-sm" data-close aria-label="Cerrar"></button>
        </div>
    @endif
</div>

<main>
    @yield('content')
</main>

<footer class="pc-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-5">
                <a class="pc-brand mb-3" href="{{ route('home') }}">
                    <img src="{{ asset('img/logo.svg') }}" class="pc-logo" alt="">
                    <span>Profile<strong>Cloud</strong></span>
                </a>
                <p class="mt-3 mb-0" style="max-width: 400px;">
                    Plataforma para que los estudiantes publiquen su perfil profesional, sus habilidades y sus proyectos, y conecten con oportunidades reales.
                </p>
            </div>
            <div class="col-6 col-lg-3">
                <h5>Explorar</h5>
                <ul class="list-unstyled mt-3 d-grid gap-2">
                    <li><a href="{{ route('home') }}">Inicio</a></li>
                    <li><a href="{{ route('directory.index') }}">Directorio de perfiles</a></li>
                    <li><a href="{{ route('directory.index', ['disponible' => 1]) }}">Disponibles para pasantía</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-4">
                <h5>Infraestructura</h5>
                <ul class="list-unstyled mt-3 d-grid gap-2 small">
                    <li><i class="bi bi-hdd-stack me-2 text-warning"></i>Debian 13 · Apache 2.4</li>
                    <li><i class="bi bi-filetype-php me-2 text-warning"></i>PHP 8.4 (PHP-FPM) · Laravel</li>
                    <li><i class="bi bi-database me-2 text-warning"></i>MariaDB</li>
                </ul>
            </div>
        </div>
        <div class="pc-footer-bottom d-flex flex-column flex-md-row justify-content-between gap-2">
            <span>© {{ date('Y') }} ProfileCloud · Proyecto académico de Gestión de Servidores Web</span>
            <span>ITCA-FEPADE · El Salvador</span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/profilecloud.js') }}"></script>
@stack('scripts')
</body>
</html>
