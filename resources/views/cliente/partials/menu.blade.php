{{--
    Enlaces del menú del cliente (compartido por todas sus pantallas).
    $pendingAuthorizations lo calcula el View::composer de AppServiceProvider.
--}}
<a href="{{ route('cliente.dashboard') }}"
   class="{{ request()->routeIs('cliente.dashboard') ? 'active' : '' }}">
    Inicio
</a>

<a href="{{ route('cliente.vehiculos') }}"
   class="{{ request()->routeIs('cliente.vehiculos*') ? 'active' : '' }}">
    Mis vehículos
</a>

<a href="{{ route('cliente.citas.create') }}"
   class="{{ request()->routeIs('cliente.citas.create') ? 'active' : '' }}">
    Agendar cita
</a>

<a href="{{ route('cliente.citas.index') }}"
   class="{{ request()->routeIs('cliente.citas.*') && !request()->routeIs('cliente.citas.create') ? 'active' : '' }}">
    Mis citas
</a>

<a href="{{ route('cliente.rastrear-orden') }}"
   class="{{ request()->routeIs('cliente.rastrear-orden') ? 'active' : '' }}">
    Rastrear orden
</a>

<a href="{{ route('cliente.historial') }}"
   class="{{ request()->routeIs('cliente.historial') ? 'active' : '' }}">
    Historial
</a>

<a href="{{ route('cliente.autorizaciones') }}"
   class="menu-con-aviso {{ request()->routeIs('cliente.autorizaciones*') ? 'active' : '' }}">
    Autorizaciones
    @if($pendingAuthorizations > 0)
        <span class="menu-aviso" title="{{ $pendingAuthorizations }} autorización(es) pendiente(s)">
            {{ $pendingAuthorizations }}
            <span class="sr-only">pendientes</span>
        </span>
    @endif
</a>

<a href="{{ route('profile.edit') }}"
   class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
    Perfil
</a>

@once
    <style>
        .menu-con-aviso {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .menu-aviso {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 20px;
            padding: 0 6px;
            border-radius: 999px;
            background: #e11d2e;
            color: #ffffff;
            font-size: 11px;
            font-weight: bold;
            line-height: 1;
            box-shadow: 0 0 0 3px rgba(225, 29, 46, .25);
            animation: menu-aviso-pulso 2s ease-in-out infinite;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0 0 0 0);
            white-space: nowrap;
        }

        @keyframes menu-aviso-pulso {
            0%, 100% { box-shadow: 0 0 0 3px rgba(225, 29, 46, .25); }
            50% { box-shadow: 0 0 0 6px rgba(225, 29, 46, .08); }
        }

        @media (prefers-reduced-motion: reduce) {
            .menu-aviso { animation: none; }
        }

        /* ===== Menú en celular: barra superior con botón ☰ ===== */

        .cliente-menu-toggle {
            display: none;
        }

        @media (max-width: 850px) {
            .layout {
                flex-direction: column !important;
            }

            aside.sidebar {
                position: sticky !important;
                top: 0;
                z-index: 1000;
                display: block !important;
                width: 100% !important;
                height: auto !important;
                min-height: 0 !important;
                max-height: 100vh;
                overflow-y: auto;
            }

            aside.sidebar .sidebar-top {
                padding: 0 !important;
            }

            aside.sidebar .brand,
            aside.sidebar .logo {
                display: flex;
                flex-direction: column;
                justify-content: center;
                min-height: 60px;
                margin: 0 !important;
                padding: 10px 70px 10px 16px !important;
                border-bottom: 0 !important;
            }

            aside.sidebar .brand {
                flex-direction: row;
                align-items: center;
                justify-content: flex-start;
            }

            /* Cerrado: solo se ve la barra con el logo y el botón */
            aside.sidebar .menu,
            aside.sidebar .sidebar-bottom,
            aside.sidebar .session {
                display: none !important;
            }

            /* Abierto: se despliegan las opciones y la sesión */
            aside.sidebar.menu-abierto {
                box-shadow: 0 12px 24px rgba(0, 0, 0, .35);
            }

            aside.sidebar.menu-abierto .menu {
                display: flex !important;
                flex-direction: column;
                border-top: 1px solid #222;
            }

            aside.sidebar.menu-abierto .sidebar-bottom,
            aside.sidebar.menu-abierto .session {
                display: block !important;
            }

            .cliente-menu-toggle {
                position: absolute;
                top: 9px;
                right: 14px;
                display: inline-flex;
                flex-direction: column;
                justify-content: center;
                gap: 5px;
                width: 42px;
                height: 42px;
                padding: 0 10px;
                border: 1px solid #333;
                border-radius: 8px;
                background: transparent;
                cursor: pointer;
            }

            .cliente-menu-toggle span {
                display: block;
                height: 2px;
                border-radius: 2px;
                background: #fff;
                transition: transform .2s ease, opacity .2s ease;
            }

            aside.sidebar.menu-abierto .cliente-menu-toggle span:nth-child(1) {
                transform: translateY(7px) rotate(45deg);
            }

            aside.sidebar.menu-abierto .cliente-menu-toggle span:nth-child(2) {
                opacity: 0;
            }

            aside.sidebar.menu-abierto .cliente-menu-toggle span:nth-child(3) {
                transform: translateY(-7px) rotate(-45deg);
            }

            /* Punto rojo sobre el botón si hay autorizaciones pendientes */
            .cliente-menu-toggle.con-aviso::after {
                content: "";
                position: absolute;
                top: -4px;
                right: -4px;
                width: 12px;
                height: 12px;
                border: 2px solid #050505;
                border-radius: 50%;
                background: #e11d2e;
            }

            aside.sidebar.menu-abierto .cliente-menu-toggle.con-aviso::after {
                display: none;
            }
        }
    </style>

    <script>
        (function () {
            var nav = document.currentScript && document.currentScript.closest('nav');
            var sidebar = nav && nav.closest('aside.sidebar');
            if (!sidebar) return;

            var toggle = document.createElement('button');
            toggle.type = 'button';
            toggle.className = 'cliente-menu-toggle';
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('aria-label', 'Abrir menú');
            toggle.innerHTML = '<span></span><span></span><span></span>';

            if (nav.querySelector('.menu-aviso')) {
                toggle.classList.add('con-aviso');
                toggle.setAttribute('aria-label', 'Abrir menú (tienes autorizaciones pendientes)');
            }

            sidebar.appendChild(toggle);

            function setOpen(open) {
                sidebar.classList.toggle('menu-abierto', open);
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            }

            toggle.addEventListener('click', function () {
                setOpen(!sidebar.classList.contains('menu-abierto'));
            });

            // Cerrar al tocar fuera del menú o con la tecla Escape
            document.addEventListener('click', function (e) {
                if (sidebar.classList.contains('menu-abierto') && !sidebar.contains(e.target)) setOpen(false);
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') setOpen(false);
            });
        })();
    </script>
@endonce
