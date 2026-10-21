<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AutoManager - Mecánico</title>

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

        /* SIDEBAR */

        .sidebar {
            width: 220px;
            background: #050505;
            color: white;

            display: flex;
            flex-direction: column;
            justify-content: space-between;

            flex-shrink: 0;
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
            color: #aaa;
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

            transition: 0.2s;
        }

        .menu a:hover {
            background: #111;
        }

        .menu a.active {
            background: #1a1a1a;
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
        }

        .sidebar-bottom a,
        .sidebar-bottom button {
            display: block;

            color: #bbb;
            text-decoration: none;

            font-size: 14px;
            margin-top: 10px;

            background: none;
            border: none;

            cursor: pointer;
            padding: 0;
        }

        .sidebar-bottom a:hover,
        .sidebar-bottom button:hover {
            color: white;
        }

        /* MAIN */

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;

            padding: 24px 28px 18px;
        }

        .topbar h1 {
            font-size: 24px;
            margin-bottom: 4px;
        }

        .topbar p {
            color: #777;
            font-size: 14px;
        }

        .content {
            padding: 28px;
        }

        /* STATS */

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;

            margin-bottom: 24px;
        }

        .stat-card {
            background: white;

            border: 1px solid #ddd;
            border-radius: 10px;

            padding: 20px;
        }

        .stat-card span {
            color: #777;
            font-size: 13px;
        }

        .stat-card strong {
            display: block;

            margin-top: 8px;

            font-size: 28px;
        }

        /* SECTION */

        .section {
            background: white;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
        }

        .section-header {
            padding: 18px 22px;
            border-bottom: 1px solid #ddd;
        }

        .section-header h2 {
            font-size: 18px;
        }

        .section-header p {
            color: #777;
            font-size: 13px;
            margin-top: 5px;
        }

        /* TABLE */

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        thead {
            background: #050505;
            color: white;
        }

        th {
            padding: 14px 16px;
            text-align: left;
            font-size: 13px;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        /* STATUS */

        .status-form select {
            padding: 7px 10px;

            border: 1px solid #ddd;
            border-radius: 8px;

            background: white;

            font-size: 13px;
            font-weight: 600;

            cursor: pointer;
            outline: none;
        }

        .status-form select:focus {
            border-color: #e11d2e;
            box-shadow: 0 0 0 3px rgba(225, 29, 46, 0.10);
        }

        /* FOLIO */

        .folio {
            font-weight: bold;
            color: #e11d2e;
        }

        /* SUCCESS */

        .success-message {
            margin-bottom: 20px;

            padding: 12px 16px;

            background: #dcfce7;
            color: #166534;

            border: 1px solid #bbf7d0;
            border-radius: 8px;

            font-size: 14px;
            font-weight: 600;
        }

        /* EMPTY */

        .empty {
            text-align: center;
            padding: 50px 20px;
            color: #777;
        }

        .empty strong {
            display: block;

            color: #333;

            font-size: 16px;

            margin-bottom: 6px;
        }

        /* RESPONSIVE */

        @media (max-width: 1100px) {

            .stats {
                grid-template-columns: repeat(2, 1fr);
            }

        }

        @media (max-width: 850px) {

            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .menu {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
            }

            .menu a.active {
                border-left: 4px solid #e11d2e;
            }

            .content {
                padding: 18px;
            }

        }

        @media (max-width: 500px) {

            .stats {
                grid-template-columns: 1fr;
            }

            .menu {
                grid-template-columns: 1fr;
            }

            .content {
                padding: 14px;
            }

        }

    </style>

</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->

    <aside class="sidebar">

        <div class="sidebar-top">

            <div class="brand">

                <div class="brand-box">
                    A
                </div>

                <div class="brand-text">

                    <h2>
                        AutoManager
                    </h2>

                    <p>
                        Mecánico
                    </p>

                </div>

            </div>

            <nav class="menu">

                <a href="{{ route('mecanico.dashboard') }}"
                   class="active">
                    Mis citas
                </a>

            </nav>

        </div>

        <div class="sidebar-bottom">

            <p>
                Sesión activa
            </p>

            <h4>
                {{ auth()->user()->name }}
            </h4>

            <a href="{{ route('profile.edit') }}">
                Perfil
            </a>

            <form method="POST"
                  action="{{ route('logout') }}">

                @csrf

                <button type="submit">
                    ◦ Cerrar sesión
                </button>

            </form>

        </div>

    </aside>


    <!-- MAIN -->

    <main class="main">

        <div class="topbar">

            <h1>
                Panel del mecánico
            </h1>

            <p>
                Consulta y administra los vehículos asignados a tu taller.
            </p>

        </div>


        <div class="content">

            @if(session('success'))

                <div class="success-message">
                    {{ session('success') }}
                </div>

            @endif


            <!-- STATS -->

            <div class="stats">

                <div class="stat-card">

                    <span>
                        Citas asignadas
                    </span>

                    <strong>
                        {{ $totalCitas }}
                    </strong>

                </div>


                <div class="stat-card">

                    <span>
                        Pendientes
                    </span>

                    <strong>
                        {{ $pendientes }}
                    </strong>

                </div>


                <div class="stat-card">

                    <span>
                        En proceso
                    </span>

                    <strong>
                        {{ $enProceso }}
                    </strong>

                </div>


                <div class="stat-card">

                    <span>
                        Listos para entrega
                    </span>

                    <strong>
                        {{ $listas }}
                    </strong>

                </div>

            </div>


            <!-- CITAS -->

            <div class="section">

                <div class="section-header">

                    <h2>
                        Vehículos asignados
                    </h2>

                    <p>
                        Aquí aparecerán las citas que el administrador te haya asignado.
                    </p>

                </div>


                <div class="table-wrapper">

                    @if($appointments->count())

                        <table>

                            <thead>

                                <tr>

                                    <th>
                                        Folio
                                    </th>

                                    <th>
                                        Cliente
                                    </th>

                                    <th>
                                        Vehículo
                                    </th>

                                    <th>
                                        Servicio
                                    </th>

                                    <th>
                                        Fecha
                                    </th>

                                    <th>
                                        Hora
                                    </th>

                                    <th>
                                        Estado
                                    </th>

                                    <th>
                                        Acciones
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($appointments as $appointment)

                                    <tr>

                                        <td>
                                            <span class="folio">
                                                {{ $appointment->folio }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $appointment->client->name }}
                                        </td>

                                        <td>
                                            {{ $appointment->vehicle->brand }}
                                            {{ $appointment->vehicle->model }}
                                            ({{ $appointment->vehicle->year }})
                                        </td>

                                        <td>
                                            {{ $appointment->service_type }}
                                        </td>

                                        <td>
                                            {{ $appointment->appointment_date }}
                                        </td>

                                        <td>
                                            {{ $appointment->appointment_time }}
                                        </td>

                                        <td>

                                            
    @switch($appointment->status)

        @case('pendiente')
            Pendiente
            @break

        @case('diagnostico')
            Diagnóstico
            @break

        @case('esperando_aprobacion')
            Esperando autorización
            @break

        @case('en_proceso')
            En proceso
            @break

        @case('control_calidad')
            Control de calidad
            @break

        @case('listo')
            Listo para entrega
            @break

        @case('rechazado')
            Rechazado
            @break

        @default
            {{ ucfirst($appointment->status) }}

    @endswitch


                                        </td>

                                        <td>

    <a
        href="{{ route('mecanico.citas.show', $appointment) }}"
        class="btn-edit"
    >
        Abrir orden
    </a>

</td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    @else

                        <div class="empty">

                            <strong>
                                No tienes vehículos asignados
                            </strong>

                            <span>
                                Cuando el administrador te asigne una cita aparecerá aquí.
                            </span>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </main>

</div>

</body>
</html>