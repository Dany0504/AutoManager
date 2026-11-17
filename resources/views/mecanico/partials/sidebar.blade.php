@php
    $mechanicCurrentRoute = request()->route()?->getName();

    $mechanicProfileRoute = \Illuminate\Support\Facades\Route::has('profile.edit')
        ? 'profile.edit'
        : null;
@endphp

<aside class="mechanic-sidebar" id="mechanicSidebar">

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

        {{-- Solo visible en celular: abre y cierra el menú --}}
        <button
            type="button"
            class="mechanic-menu-toggle"
            id="mechanicMenuToggle"
            aria-controls="mechanicSidebarPanel"
            aria-expanded="false"
            aria-label="Abrir menú"
        >
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <div class="mechanic-sidebar-panel" id="mechanicSidebarPanel">

        <nav class="mechanic-sidebar-menu">

            <a
                href="{{ route('mecanico.dashboard') }}"
                class="{{ $mechanicCurrentRoute === 'mecanico.dashboard' || str_starts_with($mechanicCurrentRoute ?? '', 'mecanico.ordenes.') ? 'active' : '' }}"
            >
                Mis órdenes
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

    </div>

</aside>

<script>
    (function () {
        var sidebar = document.getElementById('mechanicSidebar');
        var toggle = document.getElementById('mechanicMenuToggle');
        if (!sidebar || !toggle) return;

        function setOpen(open) {
            sidebar.classList.toggle('open', open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggle.setAttribute('aria-label', open ? 'Cerrar menú' : 'Abrir menú');
        }

        toggle.addEventListener('click', function () {
            setOpen(!sidebar.classList.contains('open'));
        });

        // Cerrar al tocar fuera del menú o con la tecla Escape
        document.addEventListener('click', function (e) {
            if (sidebar.classList.contains('open') && !sidebar.contains(e.target)) setOpen(false);
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') setOpen(false);
        });
    })();
</script>
