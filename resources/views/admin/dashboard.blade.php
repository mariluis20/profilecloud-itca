@extends('layouts.app')

@section('title', 'Administración')

@section('content')
<section class="pc-page-head">
    <div class="container">
        <span class="pc-eyebrow">Administración</span>
        <h1>Panel de control</h1>
        <p>Estado general de la plataforma y actividad reciente.</p>
        @include('admin._nav')
    </div>
</section>

<section class="container" style="margin-top: -28px; position: relative; z-index: 3;">
    @php
        $cards = [
            ['icon' => 'bi-people', 'value' => $stats['usuarios'], 'label' => 'Usuarios registrados', 'gold' => false],
            ['icon' => 'bi-mortarboard', 'value' => $stats['estudiantes'], 'label' => 'Estudiantes', 'gold' => true],
            ['icon' => 'bi-globe2', 'value' => $stats['publicos'], 'label' => 'Perfiles públicos', 'gold' => false],
            ['icon' => 'bi-kanban', 'value' => $stats['proyectos'], 'label' => 'Proyectos', 'gold' => true],
            ['icon' => 'bi-lightning-charge', 'value' => $stats['habilidades'], 'label' => 'Habilidades', 'gold' => false],
            ['icon' => 'bi-person-x', 'value' => $stats['inactivos'], 'label' => 'Cuentas desactivadas', 'gold' => true],
            ['icon' => 'bi-shield-exclamation', 'value' => $stats['fallidos'], 'label' => 'Accesos fallidos (24 h)', 'gold' => false],
        ];
    @endphp
    <div class="row g-3">
        @foreach($cards as $i => $card)
            <div class="col-6 col-md-4 col-xl-3">
                <div class="pc-admin-stat reveal" data-delay="{{ ($i % 4) + 1 }}">
                    <div class="ic {{ $card['gold'] ? 'gold' : '' }}"><i class="bi {{ $card['icon'] }}"></i></div>
                    <div>
                        <div class="num" data-count="{{ $card['value'] }}">0</div>
                        <div class="lbl">{{ $card['label'] }}</div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4 mt-1">
        <div class="col-lg-6">
            <div class="pc-panel reveal h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="pc-panel-title mb-0"><i class="bi bi-person-plus"></i>Últimos registros</div>
                    <a href="{{ route('admin.users') }}" class="small fw-semibold">Ver todos</a>
                </div>
                <div class="table-responsive">
                    <table class="table pc-table">
                        <tbody>
                        @foreach($recentUsers as $u)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="pc-avatar-sm">{{ $u->initials }}</span>
                                        <div>
                                            <div class="fw-semibold">{{ $u->name }}</div>
                                            <small class="text-muted">{{ $u->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end"><small class="text-muted">{{ $u->created_at?->diffForHumans() }}</small></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="pc-panel reveal h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="pc-panel-title mb-0"><i class="bi bi-activity"></i>Actividad reciente</div>
                    <a href="{{ route('admin.logs') }}" class="small fw-semibold">Bitácora completa</a>
                </div>
                <ul class="pc-timeline">
                    @forelse($recentLogs as $log)
                        <li>
                            <span class="dot {{ $log->action === 'login_fallido' ? 'bad' : '' }}"></span>
                            <div class="flex-grow-1">
                                <div class="fw-semibold small">{{ $log->label }}</div>
                                <small class="text-muted">{{ $log->user?->name ?? 'Visitante' }} · {{ $log->ip_address }}{{ $log->detail ? ' · '.$log->detail : '' }}</small>
                            </div>
                            <small class="text-muted text-nowrap">{{ $log->created_at?->diffForHumans() }}</small>
                        </li>
                    @empty
                        <li class="text-muted">Sin actividad registrada.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection
