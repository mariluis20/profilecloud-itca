@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')
<section class="pc-page-head">
    <div class="container">
        <span class="pc-eyebrow">Administración</span>
        <h1>Gestión de usuarios</h1>
        <p>Activa o desactiva cuentas y asigna roles.</p>
        @include('admin._nav')
    </div>
</section>

<section class="container" style="margin-top: -28px; position: relative; z-index: 3;">
    <form method="GET" action="{{ route('admin.users') }}" class="pc-panel reveal mb-4">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
                <label for="q" class="form-label">Buscar</label>
                <input type="search" id="q" name="q" value="{{ request('q') }}" class="form-control" placeholder="Nombre o correo">
            </div>
            <div class="col-md-3">
                <label for="rol" class="form-label">Rol</label>
                <select id="rol" name="rol" class="form-select">
                    <option value="">Todos</option>
                    <option value="admin" @selected(request('rol') === 'admin')>Administrador</option>
                    <option value="estudiante" @selected(request('rol') === 'estudiante')>Estudiante</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="estado" class="form-label">Estado</label>
                <select id="estado" name="estado" class="form-select">
                    <option value="">Todos</option>
                    <option value="activos" @selected(request('estado') === 'activos')>Activos</option>
                    <option value="inactivos" @selected(request('estado') === 'inactivos')>Inactivos</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-pc" type="submit">Filtrar</button>
            </div>
        </div>
    </form>

    <div class="pc-panel reveal">
        <div class="table-responsive">
            <table class="table pc-table">
                <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Registro</th>
                    <th class="text-end">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $u)
                    @php($isMe = $u->id === auth()->id())
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="pc-avatar-sm">{{ $u->initials }}</span>
                                <div>
                                    <div class="fw-semibold">{{ $u->name }} @if($isMe)<span class="pc-chip gold mb-0 ms-1">Tú</span>@endif</div>
                                    <small class="text-muted">{{ $u->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td style="min-width: 160px;">
                            @if($isMe)
                                <span class="pc-chip mb-0">{{ $u->isAdmin() ? 'Administrador' : 'Estudiante' }}</span>
                            @else
                                <form method="POST" action="{{ route('admin.users.role', $u) }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="form-select form-select-sm" data-autosubmit aria-label="Rol de {{ $u->name }}">
                                        <option value="estudiante" @selected($u->isStudent())>Estudiante</option>
                                        <option value="admin" @selected($u->isAdmin())>Administrador</option>
                                    </select>
                                </form>
                            @endif
                        </td>
                        <td>
                            @if($u->is_active)
                                <span class="pc-chip success mb-0"><i class="bi bi-check-circle"></i>Activo</span>
                            @else
                                <span class="pc-chip mb-0"><i class="bi bi-slash-circle"></i>Inactivo</span>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $u->created_at?->format('d/m/Y') }}</small></td>
                        <td class="text-end text-nowrap">
                            @if($u->isStudent() && $u->profile)
                                <a href="{{ route('directory.show', $u->profile) }}" class="btn btn-ghost btn-sm" title="Ver perfil"><i class="bi bi-eye"></i></a>
                            @endif
                            @unless($isMe)
                                <form method="POST" action="{{ route('admin.users.toggle', $u) }}" class="d-inline"
                                      data-confirm="{{ $u->is_active ? '¿Desactivar' : '¿Activar' }} la cuenta de {{ $u->name }}?">
                                    @csrf
                                    @method('PATCH')
                                    @if($u->is_active)
                                        <button class="btn btn-outline-pc btn-sm" type="submit"><i class="bi bi-person-x me-1"></i>Desactivar</button>
                                    @else
                                        <button class="btn btn-gold btn-sm" type="submit"><i class="bi bi-person-check me-1"></i>Activar</button>
                                    @endif
                                </form>
                            @endunless
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-5">No se encontraron usuarios.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center mt-3">
            {{ $users->links() }}
        </div>
    </div>
</section>
@endsection
