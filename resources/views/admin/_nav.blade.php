<div class="d-flex flex-wrap gap-2 mt-3">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm {{ request()->routeIs('admin.dashboard') ? 'btn-gold' : 'btn-outline-light-pc' }}"><i class="bi bi-speedometer2 me-1"></i>Resumen</a>
    <a href="{{ route('admin.users') }}" class="btn btn-sm {{ request()->routeIs('admin.users') ? 'btn-gold' : 'btn-outline-light-pc' }}"><i class="bi bi-people me-1"></i>Usuarios</a>
    <a href="{{ route('admin.logs') }}" class="btn btn-sm {{ request()->routeIs('admin.logs') ? 'btn-gold' : 'btn-outline-light-pc' }}"><i class="bi bi-journal-text me-1"></i>Bitácora</a>
</div>
