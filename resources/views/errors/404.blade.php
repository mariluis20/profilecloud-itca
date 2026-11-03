@extends('layouts.app')

@section('title', 'Página no encontrada')

@section('content')
<section class="container" style="padding: 100px 0 40px;">
    <div class="pc-panel pc-empty mx-auto reveal" style="max-width: 560px;">
        <i class="bi bi-compass"></i>
        <div class="pc-serif mt-3" style="font-size: 4rem; font-weight: 700; color: var(--pc-red); line-height: 1;">404</div>
        <h1 class="h3 mt-2">Página no encontrada</h1>
        <p class="mb-4">La página que buscas no existe o el perfil no es público.</p>
        <a href="{{ route('home') }}" class="btn btn-pc"><i class="bi bi-house me-1"></i>Volver al inicio</a>
    </div>
</section>
@endsection
