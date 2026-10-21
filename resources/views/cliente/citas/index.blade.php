
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis citas - AutoManager</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            color: #111;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* MENÚ LATERAL */
        .sidebar {
            width: 220px;
            flex-shrink: 0;
            background: #050505;
            color: white;
            display: flex;
            flex-direction: column;
        }

        .logo {
            padding: 22px 18px;
            border-bottom: 1px solid #222;
        }

        .logo-title {
            font-size: 16px;
            font-weight: bold;
        }

        .logo-role {
            display: block;
            margin-top: 5px;
            font-size: 11px;
            color: #999;
        }

        .menu {
            display: flex;
            flex-direction: column;
        }

        .menu a {
            padding: 14px 18px;
            color: #aaa;
            text-decoration: none;
            font-size: 14px;
        }

        .menu a:hover {
            background: #1c1c1c;
            color: white;
        }

        .menu a.active {
            background: #292929;
            color: white;
            font-weight: bold;
        }

        .session {
            margin-top: auto;
            border-top: 1px solid #222;
            padding: 18px;
            font-size: 12px;
        }

        .session-label {
            color: #777;
            margin-bottom: 5px;
        }

        .session-name {
            font-weight: bold;
            margin-bottom: 20px;
            overflow-wrap: anywhere;
        }

        .logout {
            background: none;
            border: none;
            color: #aaa;
            cursor: pointer;
            font-size: 13px;
        }

        .logout:hover {
            color: white;
        }

        /* CONTENIDO */
        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            background: white;
            border-bottom: 1px solid #ddd;
            padding: 28px 32px;
        }

        .topbar h1 {
            font-size: 25px;
            margin-bottom: 6px;
        }

        .topbar p {
            color: #777;
            font-size: 14px;
        }

        .content {
            padding: 30px 32px;
        }

        .btn-red {
            display: inline-block;
            background: #e52b2b;
            color: white;
            text-decoration: none;
            border: none;
            padding: 12px 18px;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            white-space: nowrap;
        }

        .btn-red:hover {
            background: #c82020;
        }

        /* MENSAJES */
        .success {
            background: #e9f7e9;
            border: 1px solid #a6d7a6;
            padding: 14px 16px;
            margin-bottom: 20px;
        }

        .empty {
            background: white;
            border: 1px solid #ddd;
            padding: 45px 25px;
            text-align: center;
        }

        .empty strong {
            display: block;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .empty p {
            color: #777;
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* TARJETAS DE CITAS */
        .appointments {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .appointment-card {
            background: white;
            border: 1px solid #ddd;
            padding: 24px;
        }

        .appointment-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 22px;
        }

        .folio {
            color: #e52b2b;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 7px;
        }

        .appointment-title {
            font-size: 19px;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 8px 12px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .status-pendiente {
            background: #f0f0f0;
            color: #555;
        }

        .status-diagnostico {
            background: #fff4d6;
            color: #8a6200;
        }

        .status-esperando {
            background: #fff0f0;
            color: #c22020;
        }

        .status-proceso {
            background: #e9f1ff;
            color: #2457a6;
        }

        .status-calidad {
            background: #eee9ff;
            color: #5a3fa3;
        }

        .status-listo {
            background: #e8f6e8;
            color: #247024;
        }

        .status-cancelado,
        .status-rechazado {
            background: #eeeeee;
            color: #777;
        }

        .appointment-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .info-box {
            border-top: 1px solid #eee;
            padding-top: 12px;
            min-width: 0;
        }

        .info-label {
            color: #888;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 7px;
        }

        .info-value {
            font-size: 14px;
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .notes {
            margin-top: 20px;
            padding-top: 18px;
            border-top: 1px solid #eee;
        }

        .notes-text {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        .authorization {
            margin-top: 20px;
            padding: 15px;
            border-left: 4px solid #e52b2b;
            background: #fff7f7;
            font-size: 13px;
            line-height: 1.6;
        }

        .authorization a {
            color: #e52b2b;
            font-weight: bold;
        }

        @media (max-width: 800px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                min-height: auto;
            }

            .session {
                margin-top: 0;
            }

            .topbar {
                padding: 22px 18px;
                flex-wrap: wrap;
            }

            .content {
                padding: 18px;
            }
        }

        @media (max-width: 520px) {
            .appointment-grid {
                grid-template-columns: 1fr;
            }

            .appointment-header {
                flex-direction: column;
            }

            .appointment-card {
                padding: 18px;
            }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div class="logo">
            <div class="logo-title">AutoManager</div>
            <span class="logo-role">Cliente</span>
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

        <div class="session">
            <div class="session-label">Sesión activa</div>
            <div class="session-name">{{ auth()->user()->name }}</div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout">Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <h1>Mis citas</h1>
                <p>Consulta tus citas y el estado de tus vehículos.</p>
            </div>

            <a href="{{ route('cliente.citas.create') }}" class="btn-red">
                + Agendar cita
            </a>
        </header>

        <section class="content">

            @if(session('success'))
                <div class="success">
                    {{ session('success') }}
                </div>
            @endif

            @if($appointments->isEmpty())
                <div class="empty">
                    <strong>No tienes citas registradas.</strong>
                    <p>Agenda una cita para comenzar.</p>

                    <a href="{{ route('cliente.citas.create') }}" class="btn-red">
                        + Agendar cita
                    </a>
                </div>
            @else
                <div class="appointments">

                    @foreach($appointments as $appointment)
                        <article class="appointment-card">

                            <div class="appointment-header">
                                <div>
                                    <div class="folio">
                                        {{ $appointment->folio }}
                                    </div>

                                    <div class="appointment-title">
                                        {{ $appointment->vehicle?->brand ?? 'Vehículo' }}
                                        {{ $appointment->vehicle?->model ?? '' }}
                                        {{ $appointment->vehicle?->year ?? '' }}
                                    </div>
                                </div>

                                <div>
                                    @switch($appointment->status)
                                        @case('pendiente')
                                            <span class="status status-pendiente">Pendiente</span>
                                            @break

                                        @case('diagnostico')
                                            <span class="status status-diagnostico">Diagnóstico</span>
                                            @break

                                        @case('esperando_aprobacion')
                                            <span class="status status-esperando">Esperando autorización</span>
                                            @break

                                        @case('en_proceso')
                                            <span class="status status-proceso">En proceso</span>
                                            @break

                                        @case('control_calidad')
                                            <span class="status status-calidad">Control de calidad</span>
                                            @break

                                        @case('listo')
                                            <span class="status status-listo">Listo</span>
                                            @break

                                        @case('cancelado')
                                            <span class="status status-cancelado">Cancelado</span>
                                            @break

                                        @default
                                            <span class="status status-pendiente">
                                                {{ ucfirst(str_replace('_', ' ', $appointment->status ?? 'pendiente')) }}
                                            </span>
                                    @endswitch
                                </div>
                            </div>

                            <div class="appointment-grid">
                                <div class="info-box">
                                    <div class="info-label">Servicio</div>
                                    <div class="info-value">
                                        {{ $appointment->service_type ?: 'No especificado' }}
                                    </div>
                                </div>

                                <div class="info-box">
                                    <div class="info-label">Mecánico</div>
                                    <div class="info-value">
                                        {{ $appointment->mechanic?->name ?? 'Sin asignar' }}
                                    </div>
                                </div>

                                <div class="info-box">
                                    <div class="info-label">Fecha de cita</div>
                                    <div class="info-value">
                                        {{ $appointment->appointment_date
                                            ? \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y')
                                            : 'Sin fecha' }}
                                    </div>
                                </div>

                                <div class="info-box">
                                    <div class="info-label">Hora</div>
                                    <div class="info-value">
                                        {{ $appointment->appointment_time
                                            ? \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')
                                            : 'Sin hora' }}
                                    </div>
                                </div>

                                <div class="info-box">
                                    <div class="info-label">Placas</div>
                                    <div class="info-value">
                                        {{ $appointment->vehicle?->plates ?: 'Sin placas' }}
                                    </div>
                                </div>
                            </div>

                            @if($appointment->notes)
                                <div class="notes">
                                    <div class="info-label">Observaciones</div>
                                    <div class="notes-text">{{ $appointment->notes }}</div>
                                </div>
                            @endif

                            @if($appointment->status === 'esperando_aprobacion')
                                <div class="authorization">
                                    El mecánico ha enviado un diagnóstico y un costo estimado.
                                    Puedes revisarlos en la sección
                                    <a href="{{ route('cliente.autorizaciones') }}">Autorizaciones</a>.
                                </div>
                            @endif

                        </article>
                    @endforeach

                </div>
            @endif

        </section>
    </main>
</div>
</body>
</html>
