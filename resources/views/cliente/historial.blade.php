<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial - AutoManager</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            color: #111;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 220px;
            flex-shrink: 0;
            background: #050505;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar-top {
            padding: 18px 0;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 18px 20px;
            border-bottom: 1px solid #1d1d1d;
        }

        .brand-box {
            width: 26px;
            height: 26px;
            border-radius: 4px;
            background: #e11d2e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: bold;
        }

        .brand-text h2 {
            font-size: 18px;
        }

        .brand-text p {
            color: #bbb;
            font-size: 12px;
            margin-top: 3px;
        }

        .menu {
            margin-top: 8px;
        }

        .menu a {
            display: block;
            padding: 14px 18px;
            color: white;
            text-decoration: none;
            font-size: 15px;
        }

        .menu a:hover,
        .menu a.active {
            background: #1a1a1a;
        }

        .menu a.active {
            border-left: 4px solid #e11d2e;
            padding-left: 14px;
        }

        .sidebar-bottom {
            padding: 18px;
            border-top: 1px solid #1d1d1d;
        }

        .sidebar-bottom p {
            color: #aaa;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .sidebar-bottom h4 {
            font-size: 17px;
            margin-bottom: 14px;
            overflow-wrap: anywhere;
        }

        .sidebar-bottom button {
            color: #bbb;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            margin-top: 12px;
        }

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            background: white;
            border-bottom: 1px solid #ddd;
            padding: 24px 28px 18px;
        }

        .topbar h1 {
            font-size: 25px;
            margin-bottom: 5px;
        }

        .topbar p {
            color: #777;
            font-size: 14px;
        }

        .content {
            padding: 28px;
        }

        .summary {
            background: white;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 22px;
        }

        .summary small {
            display: block;
            color: #777;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .summary h2 {
            font-size: 26px;
        }

        .summary h2 span {
            color: #e11d2e;
        }

        .history-card {
            background: white;
            border: 1px solid #ddd;
            margin-bottom: 16px;
        }

        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            padding: 18px 22px;
            border-bottom: 1px solid #eee;
        }

        .folio {
            color: #e11d2e;
            font-weight: bold;
            font-size: 14px;
        }

        .status {
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .status.completed {
            background: #e5e7eb;
            color: #111;
        }

        .status.cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .history-body {
            padding: 20px 22px;
        }

        .history-body h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .history-body p {
            color: #666;
            font-size: 14px;
            line-height: 1.8;
        }

        .history-body strong {
            color: #222;
        }

        .observations {
            margin-top: 14px;
            padding: 12px;
            background: #f8f8f8;
            border-left: 3px solid #e11d2e;
            color: #555;
            font-size: 13px;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .empty {
            background: white;
            border: 1px solid #ddd;
            padding: 45px 20px;
            text-align: center;
        }

        .empty .icon {
            font-size: 38px;
            margin-bottom: 12px;
        }

        .empty h3 {
            margin-bottom: 10px;
        }

        .empty p {
            color: #777;
            font-size: 14px;
            line-height: 1.6;
        }

        .empty a {
            display: inline-block;
            margin-top: 18px;
            padding: 12px 18px;
            background: #e11d2e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        @media(max-width: 850px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .menu {
                display: flex;
                flex-wrap: wrap;
            }

            .menu a {
                padding: 12px;
            }

            .menu a.active {
                padding-left: 8px;
            }

            .content {
                padding: 16px;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="brand">
                <div class="brand-box">A</div>
                <div class="brand-text">
                    <h2>AutoManager</h2>
                    <p>Cliente</p>
                </div>
            </div>

            <nav class="menu">

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
       class="{{ request()->routeIs('cliente.autorizaciones*') ? 'active' : '' }}">
        Autorizaciones
    </a>

    <a href="{{ route('profile.edit') }}"
       class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
        Perfil
    </a>

</nav>
        </div>

        <div class="sidebar-bottom">
            <p>Sesión activa</p>
            <h4>{{ auth()->user()->name }}</h4>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">◦ Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <h1>Historial de servicios</h1>
            <p>Consulta las citas finalizadas y canceladas de tus vehículos.</p>
        </header>

        <div class="content">

            <div class="summary">
                <small>Servicios en el historial</small>
                <h2><span>{{ $history->count() }}</span> registros</h2>
            </div>

            @forelse($history as $item)

                @php
                    $cancelled = strtolower(trim($item->status ?? '')) === 'cancelado';
                @endphp

                <article class="history-card">

                    <div class="history-header">
                        <span class="folio">
                            {{ $item->folio ?: 'Orden #' . $item->id }}
                        </span>

                        <span class="status {{ $cancelled ? 'cancelled' : 'completed' }}">
                            {{ $cancelled ? 'Cancelado' : 'Completado' }}
                        </span>
                    </div>

                    <div class="history-body">

                        <h3>{{ $item->service_type }}</h3>

                        <p>
                            <strong>Vehículo:</strong>
                            @if($item->vehicle)
                                {{ $item->vehicle->brand }}
                                {{ $item->vehicle->model }}
                                {{ $item->vehicle->year }}
                            @else
                                No disponible
                            @endif
                        </p>

                        <p>
                            <strong>Fecha:</strong>
                            {{ \Carbon\Carbon::parse($item->appointment_date)->format('d/m/Y') }}
                        </p>

                        <p>
                            <strong>Hora:</strong>
                            {{ $item->appointment_time }}
                        </p>

                        @if($item->notes)
                            <div class="observations">
                                <strong>Observaciones:</strong>
                                {{ $item->notes }}
                            </div>
                        @endif

                    </div>
                </article>

            @empty

                <div class="empty">
                    <div class="icon">🔧</div>
                    <h3>Tu historial está vacío</h3>
                    <p>
                        Cuando tengas citas completadas o canceladas,
                        aparecerán aquí junto con la información del servicio.
                    </p>

                    <a href="{{ route('cliente.citas.create') }}">
                        Agendar una cita
                    </a>
                </div>

            @endforelse

        </div>
    </main>
</div>
</body>
</html>