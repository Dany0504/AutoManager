@php
    $mechanicCurrentRoute = request()->route()?->getName();

    $mechanicProfileRoute = \Illuminate\Support\Facades\Route::has('profile.edit')
        ? 'profile.edit'
        : null;
@endphp

<aside class="mechanic-sidebar">

    <div class="mechanic-sidebar-header">
        <div class="mechanic-sidebar-logo">
            A
        </div>

        <div>
            <div class="mechanic-sidebar-brand">
                AutoManager
            </div>

            <div class="mechanic-sidebar-role">
                Mecánico
            </div>
        </div>
    </div>

    <nav class="mechanic-sidebar-menu">

        <a
            href="{{ route('mecanico.dashboard') }}"
            class="{{ $mechanicCurrentRoute === 'mecanico.dashboard' || str_starts_with($mechanicCurrentRoute ?? '', 'mecanico.citas.') ? 'active' : '' }}"
        >
            Mis citas
        </a>

        <a
            href="{{ route('mecanico.ordenes.create') }}"
            class="{{ in_array($mechanicCurrentRoute, ['mecanico.ordenes.create', 'mecanico.ordenes.store'], true) ? 'active' : '' }}"
        >
            Ingreso de órdenes
        </a>

        <a
            href="{{ route('mecanico.ordenes.detalle') }}"
            class="{{ str_starts_with($mechanicCurrentRoute ?? '', 'mecanico.ordenes.detalle') ? 'active' : '' }}"
        >
            Detalle de órdenes
        </a>

        <a
            href="{{ route('mecanico.ordenes.estatus') }}"
            class="{{ str_starts_with($mechanicCurrentRoute ?? '', 'mecanico.ordenes.estatus') ? 'active' : '' }}"
        >
            Cambio de estatus
        </a>

    </nav>

    <div class="mechanic-sidebar-footer">

        <div class="mechanic-session-label">
            Sesión activa
        </div>

        <div class="mechanic-session-name">
            {{ auth()->user()?->name ?? 'Mecánico' }}
        </div>

        @if($mechanicProfileRoute)
            <a href="{{ route($mechanicProfileRoute) }}">
                Perfil
            </a>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit">
                ← Cerrar sesión
            </button>
        </form>

    </div>

</aside>