@extends('layouts.app')

@section('title', 'Error del servidor')

@section('content')
<section class="container" style="padding: 100px 0 40px;">
    <div class="pc-panel pc-empty mx-auto reveal" style="max-width: 560px;">
        <i class="bi bi-exclamation-triangle"></i>
        <div class="pc-serif mt-3" style="font-size: 4rem; font-weight: 700; color: var(--pc-red); line-height: 1;">500</div>
        <h1 class="h3 mt-2">Error del servidor</h1>
        <p class="mb-4">Algo salió mal de nuestro lado. Intenta de nuevo en unos minutos.</p>
        <a href="{{ route('home') }}" class="btn btn-pc"><i class="bi bi-house me-1"></i>Volver al inicio</a>
    </div>
</section>
@endsection
