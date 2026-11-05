<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rastrear orden - AutoManager</title>

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
            background: #fff;
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

        .order-card {
            background: white;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .order-header {
            padding: 18px 22px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .folio {
            font-weight: bold;
            color: #e11d2e;
            font-size: 17px;
        }

        .status {
            display: inline-block;
            padding: 7px 10px;
            background: #f3f4f6;
            color: #444;
            font-size: 12px;
            font-weight: bold;
            border-radius: 4px;
        }

        .order-body {
            padding: 22px;
        }

        .vehicle {
            margin-bottom: 8px;
            font-size: 18px;
        }

        .muted {
            color: #777;
            font-size: 14px;
            line-height: 1.7;
        }

        .service {
            margin-top: 14px;
            font-size: 14px;
        }

        .timeline {
            display: flex;
            align-items: flex-start;
            margin-top: 30px;
        }

        .step {
            flex: 1;
            min-width: 0;
            text-align: center;
        }

        .circle {
            width: 27px;
            height: 27px;
            border: 2px solid #ddd;
            border-radius: 50%;
            background: white;
            color: #999;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 9px;
            font-size: 12px;
            font-weight: bold;
        }

        .step span {
            display: block;
            color: #888;
            font-size: 12px;
            line-height: 1.4;
        }

        .step.completed .circle {
            background: #111;
            border-color: #111;
            color: white;
        }

        .step.completed span {
            color: #444;
        }

        .step.current .circle {
            background: #e11d2e;
            border-color: #e11d2e;
            color: white;
        }

        .step.current span {
            color: #e11d2e;
            font-weight: bold;
        }

        .progress-line {
            flex: .5;
            height: 2px;
            background: #ddd;
            margin-top: 13px;
        }

        .progress-line.completed {
            background: #111;
        }

        .notes {
            margin-top: 25px;
            padding: 14px;
            background: #f8f8f8;
            border-left: 3px solid #e11d2e;
            font-size: 14px;
            line-height: 1.5;
        }

        .empty {
            padding: 35px 20px;
            text-align: center;
            background: white;
            border: 1px solid #ddd;
            color: #777;
        }

        .empty h3 {
            color: #111;
            margin-bottom: 10px;
        }

        .empty a {
            display: inline-block;
            margin-top: 15px;
            padding: 11px 18px;
            color: white;
            background: #e11d2e;
            text-decoration: none;
            border-radius: 5px;
        }

        @media (max-width: 850px) {
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

            .timeline {
                gap: 3px;
            }

            .step span {
                font-size: 10px;
            }

            .progress-line {
                flex: .2;
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
            <h1>Rastrear orden</h1>
            <p>Consulta el avance de las órdenes de servicio de tus vehículos.</p>
        </header>

        <div class="content">

            @forelse($orders as $order)

                @php
                    $steps = [
                        'Recepción',
                        'Diagnóstico',
                        'En proceso',
                        'Control de calidad',
                        'Listo para entrega',
                        'Entregado',
                    ];
                    $status = strtolower(trim($order->status ?? 'pendiente'));

                    $statusSteps = [
                        'pendiente' => 0,
                        'diagnostico' => 1,
                        'en_proceso' => 2,
                        'control_calidad' => 3,
                        'listo' => 4,
                        'completado' => 4,
                        'entregado' => 5,
                    ];

                    $currentStep = $statusSteps[$status] ?? 0;

                    $statusLabels = [
                        'pendiente' => 'Recepción',
                        'diagnostico' => 'Diagnóstico',
                        'en_proceso' => 'En proceso',
                        'control_calidad' => 'Control de calidad',
                        'listo' => 'Listo para entrega',
                        'completado' => 'Completado',
                        'entregado' => 'Entregado',
                    ];

                    $statusLabel = $statusLabels[$status]
                        ?? ucfirst(str_replace('_', ' ', $status));
                @endphp

                <article class="order-card">
                    <div class="order-header">
                        <span class="folio">
                            {{ $order->folio ?: 'Orden #' . $order->id }}
                        </span>

                        <span class="status">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <div class="order-body">

                        <h3 class="vehicle">
                            @if($order->vehicle)
                                {{ $order->vehicle->brand }}
                                {{ $order->vehicle->model }}
                                {{ $order->vehicle->year }}
                            @else
                                Vehículo no disponible
                            @endif
                        </h3>

                        <p class="muted">
                            Fecha:
                            {{ \Carbon\Carbon::parse($order->appointment_date)->format('d/m/Y') }}
                            · Hora:
                            {{ $order->appointment_time }}
                        </p>

                        <p class="service">
                            <strong>Servicio:</strong>
                            {{ $order->service_type }}
                        </p>

                        @if($status === 'cancelado')
                            <div class="notes">
                                Esta cita está cancelada y no tiene un progreso de reparación activo.
                            </div>
                        @else
                            <div class="timeline">
                                @foreach($steps as $index => $step)
                                    <div class="step
                                        {{ $index < $currentStep ? 'completed' : '' }}
                                        {{ $index === $currentStep ? 'current' : '' }}">

                                        <div class="circle">
                                            @if($index < $currentStep)
                                                ✓
                                            @elseif($index === $currentStep)
                                                •
                                            @endif
                                        </div>

                                        <span>{{ $step }}</span>
                                    </div>

                                    @if($index < count($steps) - 1)
                                        <div class="progress-line
                                            {{ $index < $currentStep ? 'completed' : '' }}">
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        @if($order->notes)
                            <div class="notes">
                                <strong>Observaciones:</strong>
                                {{ $order->notes }}
                            </div>
                        @endif

                    </div>
                </article>

            @empty

                <div class="empty">
                    <h3>No tienes órdenes activas</h3>
                    <p>
                        Cuando tengas una cita pendiente o una reparación en curso,
                        podrás consultar aquí su progreso.
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
