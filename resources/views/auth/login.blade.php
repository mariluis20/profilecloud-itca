@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
<div class="pc-auth">
    <div class="pc-auth-side">
        <span class="pc-blob b1"></span>
        <div class="position-relative" style="max-width: 460px;">
            <span class="pc-eyebrow">Bienvenido de vuelta</span>
            <h2 class="mt-3">Tu perfil profesional, <em>siempre</em> al día.</h2>
            <blockquote>
                “La mejor carta de presentación es el trabajo que ya hiciste. Aquí lo puedes mostrar.”
            </blockquote>
        </div>
    </div>
    <div class="pc-auth-form">
        <div class="pc-auth-card reveal">
            <span class="pc-eyebrow" style="color: var(--pc-gold)">Acceso</span>
            <h1 class="mt-2">Iniciar sesión</h1>
            <p class="text-muted mb-4">Ingresa con tu correo y contraseña.</p>

            <form method="POST" action="{{ route('login.attempt') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror"
                               placeholder="tucorreo@ejemplo.com" required autofocus autocomplete="username">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" id="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••" required autocomplete="current-password">
                        <button class="btn btn-ghost" type="button" data-toggle-password="password" aria-label="Mostrar contraseña"><i class="bi bi-eye"></i></button>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Mantener la sesión iniciada</label>
                </div>
                <button type="submit" class="btn btn-pc w-100 py-2">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Entrar
                </button>
            </form>

            <p class="text-center text-muted mt-4 mb-0">
                ¿No tienes cuenta? <a href="{{ route('register') }}" class="fw-semibold">Crea tu perfil</a>
            </p>
        </div>
    </div>
</div>
@endsection
