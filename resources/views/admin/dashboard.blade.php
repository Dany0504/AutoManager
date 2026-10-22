<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Administrador - AutoManager</title>

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

        /* =========================
           SIDEBAR
        ========================= */

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
            line-height: 1.1;
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

            font-size: 16px;

            transition: 0.2s;
        }

        .menu a.active {
            background: #1a1a1a;

            border-left: 4px solid #e11d2e;

            padding-left: 14px;
        }

        .menu a:hover {
            background: #111;
        }

        /* =========================
           SIDEBAR BOTTOM
        ========================= */

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
            font-size: 18px;

            margin-bottom: 14px;
        }

        .sidebar-bottom a,
        .sidebar-bottom button {
            display: block;

            color: #bbb;

            text-decoration: none;

            font-size: 15px;

            margin-top: 12px;

            background: none;
            border: none;

            cursor: pointer;

            padding: 0;
        }

        .sidebar-bottom a:hover,
        .sidebar-bottom button:hover {
            color: white;
        }

        /* =========================
           MAIN
        ========================= */

        .main {
            flex: 1;
            min-width: 0;
            padding: 0;
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

        /* =========================
           STATS
        ========================= */

        .stats {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 16px;

            margin-bottom: 22px;
        }

        .card {
            background: white;

            border: 1px solid #ddd;

            padding: 20px;
        }

        .card small {
            display: block;

            color: #777;

            font-size: 12px;

            text-transform: uppercase;

            letter-spacing: .5px;

            margin-bottom: 12px;

            font-weight: bold;
        }

        .card h2 {
            font-size: 28px;
        }

        .card .red {
            color: #e11d2e;
        }

        /* =========================
           SECTIONS
        ========================= */

        .section {
            background: white;

            border: 1px solid #ddd;

            margin-bottom: 22px;
        }

        .section-header {
            padding: 16px 22px;

            border-bottom: 1px solid #ddd;

            font-weight: bold;

            font-size: 18px;
        }

        .section-body {
            padding: 20px 22px;
        }

        /* =========================
           QUICK ACTIONS
        ========================= */

        .actions {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 14px;
        }

        .action {
            display: block;

            padding: 20px;

            text-decoration: none;

            border: 1px solid #ddd;

            transition: 0.2s;
        }

        .action h3 {
            font-size: 16px;

            margin-bottom: 8px;

            color: #111;
        }

        .action p {
            font-size: 13px;

            color: #777;
        }

        .action:hover {
            border-color: #e11d2e;

            transform: translateY(-2px);
        }

        .action.primary {
            background: #e11d2e;

            border-color: #e11d2e;
        }

        .action.primary h3,
        .action.primary p {
            color: white;
        }

        .action.dark {
            background: #050505;

            border-color: #050505;
        }

        .action.dark h3,
        .action.dark p {
            color: white;
        }

        /* =========================
           SUMMARY
        ========================= */

        .summary-grid {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 16px;
        }

        .summary-box {
            border: 1px solid #eee;

            padding: 18px;
        }

        .summary-box h3 {
            font-size: 15px;

            margin-bottom: 8px;
        }

        .summary-box p {
            color: #777;

            font-size: 14px;

            line-height: 1.5;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 1100px) {

            .stats {
                grid-template-columns: 1fr;
            }

            .actions {
                grid-template-columns: 1fr;
            }

            .summary-grid {
                grid-template-columns: 1fr;
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

            .menu a {
                border-left: none !important;
                padding-left: 18px !important;
            }

            .menu a.active {
                border-left: 4px solid #e11d2e !important;
            }

            .content {
                padding: 18px;
            }

        }

        @media (max-width: 500px) {

            .menu {
                grid-template-columns: 1fr;
            }

            .topbar {
                padding: 20px;
            }

            .topbar h1 {
                font-size: 21px;
            }

            .content {
                padding: 14px;
            }

        }

    </style>
</head>

<body>

<div class="layout">

    <!-- =========================
         SIDEBAR
    ========================== -->

    <aside class="sidebar">

        <div class="sidebar-top">

            <!-- LOGO -->

            <div class="brand">

                <div class="brand-box">
                    A
                </div>

                <div class="brand-text">

                    <h2>
                        AutoManager
                    </h2>

                    <p>
                        Administrador
                    </p>

                </div>

            </div>


            <!-- MENU -->

            <nav class="menu">

                <a href="{{ url('/admin') }}" class="active">
                    Dashboard
                </a>

                <a href="{{ route('citas.index') }}">
                    Citas
                </a>
                <a href="{{ route('usuarios.index') }}">
                    Usuarios
                </a>

                <a href="{{ route('vehiculos.index') }}">
                    Vehículos
                </a>

                <a href="{{ route('ordenes.index') }}">
                    Órdenes
                </a>

                <a href="{{ route('reportes.index') }}">
                    Reportes
                </a>
                <a href="{{ route('parametros.index') }}">
                    Parámetros
                </a>
            </nav>

        </div>


        <!-- PARTE INFERIOR -->

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

            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button type="submit">
                    ◦ Cerrar sesión
                </button>

            </form>

        </div>

    </aside>


    <!-- =========================
         MAIN
    ========================== -->

    <main class="main">


        <!-- TOPBAR -->

        <div class="topbar">

            <h1>
                Bienvenido, {{ auth()->user()->name }}
            </h1>

            <p>
                Resumen del taller
            </p>

        </div>


        <!-- CONTENIDO -->

        <div class="content">


            <!-- =========================
                 ESTADÍSTICAS
            ========================== -->

            <div class="stats">

                <div class="card">

                    <small>
                        Citas hoy
                    </small>

                    <h2 class="red">
                        {{ $citasHoy }}
                    </h2>

                </div>


                <div class="card">

                    <small>
                        Vehículos
                    </small>

                    <h2>
                        {{ $totalVehiculos }}
                    </h2>

                </div>


                <div class="card">

                    <small>
                        Órdenes
                    </small>

                    <h2>
                        3
                    </h2>

                </div>

            </div>


            <!-- =========================
                 ACCIONES RÁPIDAS
            ========================== -->

            <div class="section">

                <div class="section-header">
                    Acciones rápidas
                </div>


                <div class="section-body">

                    <div class="actions">


                        <a href="{{ route('citas.create') }}"
                           class="action primary">

                            <h3>
                                Nueva cita
                            </h3>

                            <p>
                                Registrar una nueva cita para un cliente.
                            </p>

                        </a>


                        <a href="{{ route('citas.index') }}"
                           class="action dark">

                            <h3>
                                Ver citas
                            </h3>

                            <p>
                                Consultar, buscar y administrar las citas.
                            </p>

                        </a>


                        <a href="{{ route('vehiculos.index') }}"
                           class="action">

                            <h3>
                                Vehículos
                            </h3>

                            <p>
                                Consultar y administrar los vehículos registrados.
                            </p>

                        </a>


                    </div>

                </div>

            </div>


            <!-- =========================
                 RESUMEN
            ========================== -->

            <div class="section">

                <div class="section-header">
                    Resumen del taller
                </div>


                <div class="section-body">

                    <div class="summary-grid">


                        <div class="summary-box">

                            <h3>
                                Citas programadas
                            </h3>

                            <p>
                                Actualmente tienes
                                <strong>{{ $citasHoy }}</strong>
                                cita(s) programada(s) para hoy.
                            </p>

                        </div>


                        <div class="summary-box">

                            <h3>
                                Vehículos registrados
                            </h3>

                            <p>
                                El sistema cuenta actualmente con
                                <strong>{{ $totalVehiculos }}</strong>
                                vehículo(s) registrados.
                            </p>

                        </div>


                    </div>

                </div>

            </div>


        </div>

    </main>

</div>

</body>

</html>