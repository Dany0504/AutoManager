
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reportes - AutoManager</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fff;
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
            border-bottom: 1px solid #222;
        }

        .brand-box {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e11d2e;
            border-radius: 4px;
            font-weight: bold;
        }

        .brand h2 {
            font-size: 17px;
        }

        .brand p {
            color: #aaa;
            font-size: 12px;
            margin-top: 3px;
        }

        .menu a {
            display: block;
            padding: 14px 18px;
            color: #ddd;
            text-decoration: none;
            font-size: 15px;
        }

        .menu a:hover {
            background: #151515;
        }

        .menu a.active {
            background: #252525;
            border-left: 4px solid #e11d2e;
            padding-left: 14px;
            color: white;
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
            display: block;
            margin-top: 12px;
            color: #bbb;
            background: none;
            border: none;
            font-size: 14px;
            text-decoration: none;
            cursor: pointer;
        }

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            padding: 24px 28px;
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

        .tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .tab {
            padding: 11px 16px;
            border: 1px solid #ddd;
            color: #333;
            text-decoration: none;
            font-size: 13px;
        }

        .tab.active {
            background: #050505;
            color: white;
            border-color: #050505;
        }

        .panel {
            border: 1px solid #ddd;
            background: white;
            padding: 24px;
            margin-bottom: 20px;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 26px;
        }

        .panel-header h2 {
            font-size: 18px;
        }

        .export-buttons {
            display: flex;
            gap: 8px;
        }

        .btn {
            display: inline-block;
            padding: 11px 15px;
            font-size: 13px;
            text-decoration: none;
            cursor: pointer;
            border: 1px solid #111;
            background: white;
            color: #111;
        }

        .btn-dark {
            background: #050505;
            color: white;
        }

        .chart {
            height: 250px;
            display: flex;
            align-items: flex-end;
            gap: 8px;
            padding-top: 20px;
        }

        .chart-item {
            flex: 1;
            min-width: 0;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
        }

        .chart-value {
            font-size: 11px;
            color: #777;
            margin-bottom: 6px;
            text-align: center;
        }

        .chart-bar {
            width: 100%;
            background: #e11d2e;
            min-height: 2px;
        }

        .chart-label {
            font-size: 11px;
            color: #777;
            margin-top: 8px;
            text-align: center;
        }

        .table-wrapper {
            overflow-x: auto;
            border: 1px solid #ddd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #fafafa;
            text-align: left;
            padding: 16px;
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
        }

        td {
            padding: 16px;
            border-top: 1px solid #eee;
            font-size: 14px;
        }

        .empty {
            text-align: center;
            color: #777;
            padding: 30px;
        }

        .note {
            margin-bottom: 20px;
            color: #666;
            font-size: 13px;
            line-height: 1.5;
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

            .panel-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media print {
            .sidebar,
            .tabs,
            .export-buttons {
                display: none !important;
            }

            .content {
                padding: 0;
            }

            .panel {
                break-inside: avoid;
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
                <a href="{{ route('usuarios.index') }}">Usuarios</a>
                <a href="{{ route('citas.index') }}">Citas</a>
                <a href="{{ route('vehiculos.index') }}">Vehículos</a>
                <a href="{{ route('ordenes.index') }}">Órdenes</a>
                <a href="{{ route('reportes.index') }}" class="active">Reportes</a>
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
            <h1>Reportes</h1>
            <p>Indicadores y análisis del taller</p>
        </div>

        <div class="content">

            <div class="tabs">
                <a href="{{ route('reportes.index', ['reporte' => 'ingresos']) }}"
                   class="tab {{ $reporte === 'ingresos' ? 'active' : '' }}">
                    Ingresos
                </a>

                <a href="{{ route('reportes.index', ['reporte' => 'ordenes']) }}"
                   class="tab {{ $reporte === 'ordenes' ? 'active' : '' }}">
                    Órdenes
                </a>

                <a href="{{ route('reportes.index', ['reporte' => 'servicios']) }}"
                   class="tab {{ $reporte === 'servicios' ? 'active' : '' }}">
                    Servicios más solicitados
                </a>

                <a href="{{ route('reportes.index', ['reporte' => 'mecanicos']) }}"
                   class="tab {{ $reporte === 'mecanicos' ? 'active' : '' }}">
                    Desempeño mecánicos
                </a>
            </div>

            <p class="note">
                @if ($reporte === 'ingresos')
                    Los importes corresponden a costos estimados de citas,
                    no a pagos cobrados.
                @elseif ($reporte === 'mecanicos')
                    El desempeño se representa por cantidad de citas asignadas.
                @else
                    Los resultados se calculan con las citas registradas en AutoManager.
                @endif
            </p>

            <section class="panel">

                <div class="panel-header">
                    <h2>{{ $titulo }}</h2>

                    <div class="export-buttons">
                        <button type="button" class="btn"
                                onclick="window.print()">
                            Exportar PDF
                        </button>

                        <a href="{{ route('reportes.exportar', ['reporte' => $reporte]) }}"
                           class="btn btn-dark">
                            Exportar Excel
                        </a>
                    </div>
                </div>

                @php
                    $maximo = $datos->max(
                        fn ($fila) => $reporte === 'ingresos'
                            ? $fila['monto']
                            : $fila['total']
                    ) ?: 1;
                @endphp

                <div class="chart">
                    @forelse ($datos as $fila)
                        @php
                            $valor = $reporte === 'ingresos'
                                ? $fila['monto']
                                : $fila['total'];

                            $etiqueta = $reporte === 'ingresos'
                                ? $fila['mes']
                                : $fila['nombre'];

                            $altura = $valor > 0
                                ? max(3, ($valor / $maximo) * 100)
                                : 1;
                        @endphp

                        <div class="chart-item">
                            <div class="chart-value">
                                @if ($reporte === 'ingresos')
                                    ${{ number_format($valor, 0) }}
                                @else
                                    {{ $valor }}
                                @endif
                            </div>

                            <div class="chart-bar"
                                 style="height: {{ $altura }}%;">
                            </div>

                            <div class="chart-label">
                                {{ $etiqueta }}
                            </div>
                        </div>
                    @empty
                        <p class="empty">No hay datos para este reporte.</p>
                    @endforelse
                </div>

            </section>

            <div class="table-wrapper">
                <table>
                    @if ($reporte === 'ingresos')
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Monto estimado</th>
                                <th>Órdenes</th>
                                <th>Ticket promedio estimado</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($datos as $fila)
                                <tr>
                                    <td>{{ ucfirst($fila['mes']) }}</td>

                                    <td>
                                        <strong>
                                            ${{ number_format($fila['monto'], 2) }}
                                        </strong>
                                    </td>

                                    <td>{{ $fila['ordenes'] }}</td>

                                    <td>
                                        ${{ number_format($fila['promedio'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @else
                        <thead>
                            <tr>
                                <th>
                                    @if ($reporte === 'ordenes')
                                        Estado
                                    @elseif ($reporte === 'servicios')
                                        Servicio
                                    @else
                                        Mecánico
                                    @endif
                                </th>
                                <th>Total de citas</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($datos as $fila)
                                <tr>
                                    <td>{{ $fila['nombre'] }}</td>
                                    <td><strong>{{ $fila['total'] }}</strong></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="empty">
                                        No hay información registrada.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    @endif
                </table>
            </div>

        </div>
    </main>
</div>
</body>
</html>
