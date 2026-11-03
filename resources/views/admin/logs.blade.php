@extends('layouts.app')

@section('title', 'Bitácora')

@section('content')
<section class="pc-page-head">
    <div class="container">
        <span class="pc-eyebrow">Administración</span>
        <h1>Bitácora de actividad</h1>
        <p>Registro de accesos y cambios realizados en la plataforma.</p>
        @include('admin._nav')
    </div>
</section>

<section class="container" style="margin-top: -28px; position: relative; z-index: 3;">
    <div class="pc-panel reveal">
        <form method="GET" action="{{ route('admin.logs') }}" class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <label for="accion" class="form-label mb-0 me-1">Filtrar por acción</label>
            <select id="accion" name="accion" class="form-select w-auto" data-autosubmit>
                <option value="">Todas</option>
                @foreach($labels as $key => $label)
                    <option value="{{ $key }}" @selected(request('accion') === $key)>{{ $label }}</option>
                @endforeach
            </select>
            @if(request('accion'))
                <a href="{{ route('admin.logs') }}" class="btn btn-ghost btn-sm">Limpiar</a>
            @endif
        </form>

        <div class="table-responsive">
            <table class="table pc-table">
                <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Acción</th>
                    <th>Usuario</th>
                    <th>Detalle</th>
                    <th>IP</th>
                </tr>
                </thead>
                <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td class="text-nowrap"><small>{{ $log->created_at?->format('d/m/Y H:i:s') }}</small></td>
                        <td>
                            <span class="pc-chip {{ $log->action === 'login_fallido' ? '' : 'gold' }} mb-0">{{ $log->label }}</span>
                        </td>
                        <td>{{ $log->user?->name ?? '—' }}</td>
                        <td><small class="text-muted">{{ $log->detail ?? '—' }}</small></td>
                        <td><code class="small">{{ $log->ip_address }}</code></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-5">Sin registros.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $logs->links() }}
        </div>
    </div>
</section>
@endsection
