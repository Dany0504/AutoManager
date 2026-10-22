
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de órdenes - AutoManager</title>

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
            background: #050505;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-shrink: 0;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 18px;
            border-bottom: 1px solid #1d1d1d;
        }

        .brand-box {
            background: #e11d2e;
            color: white;
            padding: 7px 10px;
            border-radius: 4px;
            font-weight: bold;
        }

        .brand h2 {
            font-size: 18px;
        }

        .brand p {
            font-size: 12px;
            color: #aaa;
            margin-top: 4px;
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

        .menu a:hover {
            background: #111;
        }

        .menu a.active {
            background: #252525;
            border-left: 4px solid #e11d2e;
            padding-left: 14px;
        }

        .sidebar-bottom {
            padding: 18px;
            border-top: 1px solid #222;
        }

        .sidebar-bottom p {
            color: #aaa;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .sidebar-bottom h4 {
            margin-bottom: 14px;
        }

        .sidebar-bottom a,
        .sidebar-bottom button {
            color: #bbb;
            background: none;
            border: none;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
            display: block;
            margin-top: 12px;
        }

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            padding: 24px 28px;
            background: white;
            border-bottom: 1px solid #ddd;
        }

        .topbar h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .topbar p {
            color: #777;
            font-size: 14px;
        }

        .content {
            padding: 28px;
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 18px;
        }

        .filter {
            display: inline-block;
            padding: 10px 16px;
            background: white;
            border: 1px solid #ddd;
            color: #333;
            text-decoration: none;
            font-size: 13px;
        }

        .filter.active {
            background: #050505;
            color: white;
            border-color: #050505;
        }

        .badge.pendiente {
            background: #fef3c7;
            color: #92400e;
        }

        .table-wrapper {
            overflow-x: auto;
            background: white;
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 16px;
            background: #f8f8f8;
            text-align: left;
            font-size: 12px;
            color: #777;
            text-transform: uppercase;
        }

        td {
            padding: 16px;
            border-top: 1px solid #eee;
            font-size: 13px;
        }

        .badge {
            display: inline-block;
            padding: 5px 8px;
            font-size: 12px;
            font-weight: bold;
        }

        .badge.proceso {
            background: #e11d2e;
            color: white;
        }

        .badge.diagnostico {
            background: #111;
            color: white;
        }

        .badge.listo {
            background: #e5e7eb;
            color: #111;
        }

        .badge.completado {
            background: #f3f4f6;
            color: #777;
        }

        .detail {
            color: #111;
            text-decoration: none;
            font-weight: bold;
        }

        .detail:hover {
            color: #e11d2e;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #777;
        }

        @media (max-width: 850px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
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
        <div>
            <div class="brand">
                <div class="brand-box">A</div>
                <div>
                    <h2>AutoManager</h2>
                    <p>Administrador</p>
                </div>
            </div>

            <nav class="menu">
                <a href="{{ url('/admin') }}">Dashboard</a>

                <a href="{{ route('citas.index') }}">Citas</a>

                <a href="{{ route('usuarios.index') }}">Usuarios</a>

                <a href="{{ route('vehiculos.index') }}">Vehículos</a>

                <a href="{{ route('ordenes.index') }}" class="active">Órdenes</a>

                <a href="{{ route('reportes.index') }}">Reportes</a>
                <a href="{{ route('parametros.index') }}">Parámetros</a>
            </nav>
        </div>

        <div class="sidebar-bottom">
            <p>Sesión activa</p>
            <h4>{{ auth()->user()->name }}</h4>

            <a href="{{ route('profile.edit') }}">Perfil</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">◦ Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <h1>Gestión de órdenes</h1>
            <p>Filtrar, revisar y reasignar órdenes de trabajo.</p>
        </div>

        <div class="content">

            <div class="filters">
                <a href="{{ route('ordenes.index') }}"
                   class="filter {{ $estado === 'todos' ? 'active' : '' }}">
                    Todos
                </a>

                <a href="{{ route('ordenes.index', ['estado' => 'pendiente']) }}"
                class="filter {{ $estado === 'pendiente' ? 'active' : '' }}">
                    Pendiente
                </a>

                <a href="{{ route('ordenes.index', ['estado' => 'en_proceso']) }}"
                   class="filter {{ $estado === 'en_proceso' ? 'active' : '' }}">
                    En proceso
                </a>

                <a href="{{ route('ordenes.index', ['estado' => 'diagnostico']) }}"
                   class="filter {{ $estado === 'diagnostico' ? 'active' : '' }}">
                    Diagnóstico
                </a>

                <a href="{{ route('ordenes.index', ['estado' => 'listo']) }}"
                   class="filter {{ $estado === 'listo' ? 'active' : '' }}">
                    Listo
                </a>

                <a href="{{ route('ordenes.index', ['estado' => 'completado']) }}"
                   class="filter {{ $estado === 'completado' ? 'active' : '' }}">
                    Completado
                </a>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Vehículo</th>
                            <th>Mecánico</th>
                            <th>Estatus</th>
                            <th>Fecha</th>
                            <th>Monto</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($ordenes as $orden)
                            <tr>
                                <!-- FOLIO -->
                                <td>
                                    <strong>
                                        {{ $orden->folio ?: 'ORD-' . $orden->id }}
                                    </strong>
                                </td>

                                <!-- CLIENTE -->
                                <td>
                                    {{ $orden->client?->user?->name ?? 'Sin cliente' }}
                                </td>

                                <!-- VEHÍCULO -->
                                <td>
                                    {{ $orden->vehicle?->brand ?? 'Sin vehículo' }}
                                    {{ $orden->vehicle?->model ?? '' }}
                                    {{ $orden->vehicle?->year ?? '' }}
                                </td>

                                <!-- MECÁNICO -->
                                <td>
                                    {{ $orden->mechanic?->name ?? 'Sin asignar' }}
                                </td>

                                <!-- ESTADO -->
                                <td>
                                    @php
                                        $claseEstado = match ($orden->status) {
                                            'en_proceso' => 'proceso',
                                            'diagnostico' => 'diagnostico',
                                            'listo' => 'listo',
                                            'completado' => 'completado',
                                            default => 'pendiente',
                                        };
                                    @endphp

                                    <span class="badge {{ $claseEstado }}">
                                        {{ ucfirst(str_replace('_', ' ', $orden->status)) }}
                                    </span>
                                </td>

                                <!-- FECHA -->
                                <td>
                                    {{ $orden->appointment_date?->format('d/m/Y') ?? '—' }}
                                </td>

                                <!-- MONTO -->
                                <td>
                                    @if ($orden->estimated_cost !== null)
                                        ${{ number_format((float) $orden->estimated_cost, 2) }}
                                    @else
                                        —
                                    @endif
                                </td>

                                <!-- ACCIONES -->
                                <td>
                                    <a href="{{ route('ordenes.show', $orden->id) }}" class="detail">
                                        Detalle
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty">
                                    No hay órdenes registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</div>
</body>
</html>
