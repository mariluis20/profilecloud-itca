@extends('layouts.app')

@section('title', 'Crear cuenta')

@section('content')
<div class="pc-auth">
    <div class="pc-auth-side">
        <span class="pc-blob b1"></span>
        <div class="position-relative" style="max-width: 460px;">
            <span class="pc-eyebrow">Únete a ProfileCloud</span>
            <h2 class="mt-3">Empieza a construir tu <em>identidad digital</em>.</h2>
            <ul class="list-unstyled mt-4 d-grid gap-3 text-white-50">
                <li><i class="bi bi-check2-circle me-2 text-warning"></i>Un enlace único para compartir tu perfil</li>
                <li><i class="bi bi-check2-circle me-2 text-warning"></i>Muestra tus habilidades y proyectos</li>
                <li><i class="bi bi-check2-circle me-2 text-warning"></i>Visible para empresas y docentes</li>
            </ul>
        </div>
    </div>
    <div class="pc-auth-form">
        <div class="pc-auth-card reveal">
            <span class="pc-eyebrow" style="color: var(--pc-gold)">Registro</span>
            <h1 class="mt-2">Crear mi perfil</h1>
            <p class="text-muted mb-4">Solo te tomará un minuto.</p>

            <form method="POST" action="{{ route('register.store') }}" novalidate>
                @csrf
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label for="first_name" class="form-label">Primer nombre <span class="text-danger">*</span></label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" maxlength="60" autofocus
                               class="form-control @error('first_name') is-invalid @enderror" required autocomplete="given-name">
                        @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="middle_name" class="form-label">Segundo nombre <small class="text-muted fw-normal">(opcional)</small></label>
                        <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}" maxlength="60"
                               class="form-control @error('middle_name') is-invalid @enderror" autocomplete="additional-name">
                        @error('middle_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="last_name" class="form-label">Primer apellido <span class="text-danger">*</span></label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" maxlength="60"
                               class="form-control @error('last_name') is-invalid @enderror" required autocomplete="family-name">
                        @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-sm-6">
                        <label for="second_last_name" class="form-label">Segundo apellido <small class="text-muted fw-normal">(opcional)</small></label>
                        <input type="text" id="second_last_name" name="second_last_name" value="{{ old('second_last_name') }}" maxlength="60"
                               class="form-control @error('second_last_name') is-invalid @enderror" autocomplete="family-name">
                        @error('second_last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror" required autocomplete="email">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label for="carrera" class="form-label">Carrera</label>
                    <select id="carrera" name="carrera" class="form-select @error('carrera') is-invalid @enderror" required>
                        <option value="">Selecciona tu carrera…</option>
                        @foreach($carreras as $carrera)
                            <option value="{{ $carrera }}" @selected(old('carrera') === $carrera)>{{ $carrera }}</option>
                        @endforeach
                    </select>
                    @error('carrera')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row g-3 mb-2">
                    <div class="col-sm-6">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                    </div>
                    <div class="col-sm-6">
                        <label for="password_confirmation" class="form-label">Confirmar</label>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control" required autocomplete="new-password">
                    </div>
                </div>
                @error('password')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
                <p class="small text-muted mb-4"><i class="bi bi-shield-lock me-1"></i>Mínimo 8 caracteres, con mayúsculas, minúsculas y números.</p>
                <button type="submit" class="btn btn-pc w-100 py-2">
                    <i class="bi bi-person-plus me-1"></i> Crear cuenta
                </button>
            </form>

            <p class="text-center text-muted mt-4 mb-0">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="fw-semibold">Inicia sesión</a>
            </p>
        </div>
    </div>
</div>
@endsection
