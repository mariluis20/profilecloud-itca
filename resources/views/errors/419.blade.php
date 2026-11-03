@extends('layouts.app')

@section('title', 'La sesión expiró')

@section('content')
<section class="container" style="padding: 100px 0 40px;">
    <div class="pc-panel pc-empty mx-auto reveal" style="max-width: 560px;">
        <i class="bi bi-hourglass-split"></i>
        <div class="pc-serif mt-3" style="font-size: 4rem; font-weight: 700; color: var(--pc-red); line-height: 1;">419</div>
        <h1 class="h3 mt-2">La sesión expiró</h1>
        <p class="mb-4">Por seguridad, la página expiró. Vuelve a intentarlo.</p>
        <a href="{{ route('home') }}" class="btn btn-pc"><i class="bi bi-house me-1"></i>Volver al inicio</a>
    </div>
</section>
@endsection
