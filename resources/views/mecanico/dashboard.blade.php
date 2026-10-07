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
            font-family: Arial, Helvetica, sans-serif;
            background: #ffffff;
            color: #111111;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* =========================
           SIDEBAR
        ========================== */

        .sidebar {
            width: 175px;
            min-height: 100vh;
            background: #111111;
            color: #ffffff;

            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;

            display: flex;
            flex-direction: column;
        }

        .brand {
            height: 58px;
            display: flex;
            align-items: center;
            padding: 0 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .brand-letter {
            font-size: 12px;
            margin-right: 17px;
        }

        .brand-name {
            font-size: 12px;
            font-weight: bold;
        }

        .brand-role {
            display: block;
            font-size: 8px;
            font-weight: normal;
            color: #9b9b9b;
            margin-top: 2px;
        }

        .menu {
            padding-top: 10px;
        }

        .menu a {
            display: block;
            padding: 10px 12px;
            color: #bdbdbd;
            text-decoration: none;
            font-size: 12px;
            transition: 0.2s;
        }

        .menu a:hover {
            background: #1f1f1f;
            color: #ffffff;
        }

        .menu a.active {
            background: #292929;
            color: #ffffff;
            font-weight: bold;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 13px 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .session-label {
            font-size: 9px;
            color: #777777;
            margin-bottom: 5px;
        }

        .mechanic-name {
            font-size: 11px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 17px;
        }

        .collapse-link {
            display: block;
            color: #888888;
            text-decoration: none;
            font-size: 10px;
            margin-bottom: 17px;
        }

        .collapse-link:hover {
            color: #ffffff;
        }

        .logout-form {
            margin: 0;
        }

        .logout-button {
            background: transparent;
            border: none;
            color: #888888;
            font-size: 10px;
            cursor: pointer;
            padding: 0;
        }

        .logout-button:hover {
            color: #ffffff;
        }

        /* =========================
           CONTENIDO PRINCIPAL
        ========================== */

        .main {
            margin-left: 175px;
            width: calc(100% - 175px);
            min-height: 100vh;
        }

        /* =========================
           HEADER
        ========================== */

        .header {
            height: 83px;
            border-bottom: 1px solid #e7e7e7;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 27px;
        }

        .header-title h1 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .header-title p {
            color: #777777;
            font-size: 11px;
        }

        .header-stats {
            display: flex;
            align-items: center;
            gap: 28px;
            text-align: center;
        }

        .header-stat-number {
            font-size: 20px;
            font-weight: bold;
            line-height: 1;
        }

        .header-stat-number.red {
            color: #e3262e;
        }

        .header-stat-label {
            margin-top: 5px;
            color: #777777;
            font-size: 9px;
        }

        /* =========================
           AGENDA
        ========================== */

        .content {
            padding: 26px 27px;
        }

        .appointment {
            width: 100%;
            min-height: 66px;

            border: 1px solid #e2e2e2;
            margin-bottom: 8px;

            display: grid;
            grid-template-columns: 85px 1.1fr 2fr 130px;
            align-items: center;

            padding: 0 16px;
            background: #ffffff;
        }

        .time {
            height: 38px;

            display: flex;
            align-items: center;

            border-right: 1px solid #e5e5e5;

            font-family: Consolas, monospace;
            font-size: 12px;
            font-weight: bold;
        }

        .client {
            padding-left: 17px;
        }

        .client-name {
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .plates {
            font-family: Consolas, monospace;
            color: #777777;
            font-size: 9px;
        }

        .vehicle {
            padding-left: 15px;
        }

        .vehicle-name {
            font-size: 11px;
            margin-bottom: 4px;
        }

        .service {
            color: #777777;
            font-size: 9px;
        }

        .status-container {
            text-align: right;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            font-size: 9px;
        }

        .status-progress {
            background: #e3262e;
            color: #ffffff;
            font-weight: bold;
        }

        .status-waiting {
            background: #111111;
            color: #ffffff;
            font-weight: bold;
        }

        .status-pending {
            background: #f4f4f4;
            color: #777777;
        }

        /* =========================
           RESPONSIVE
        ========================== */

        @media (max-width: 900px) {

            .appointment {
                grid-template-columns: 70px 1fr 1.5fr 100px;
            }

            .sidebar {
                width: 160px;
            }

            .main {
                margin-left: 160px;
                width: calc(100% - 160px);
            }
        }

        @media (max-width: 700px) {

            .sidebar {
                display: none;
            }

            .main {
                margin-left: 0;
                width: 100%;
            }

            .header {
                padding: 0 15px;
            }

            .content {
                padding: 15px;
            }

            .appointment {
                grid-template-columns: 65px 1fr;
                gap: 10px;
                padding: 12px;
            }

            .vehicle {
                padding-left: 0;
            }

            .status-container {
                text-align: left;
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

        <div class="brand">

            <div class="brand-letter">
                A
            </div>

            <div>
                <div class="brand-name">
                    AutoManager
                </div>

                <span class="brand-role">
                    Mecánico
                </span>
            </div>

        </div>


        <nav class="menu">

            <a href="#" class="active">
                Agenda del día
            </a>

            <a href="#">
                Nueva orden
            </a>

            <a href="#">
                Detalle de orden
            </a>

            <a href="#">
                Cambio de estatus
            </a>

            <a href="#">
                Inventario
            </a>

        </nav>


        <div class="sidebar-footer">

            <div class="session-label">
                Sesión activa
            </div>

            <div class="mechanic-name">
                Carlos Mendoza
            </div>

            <a href="#" class="collapse-link">
                ← &nbsp; Contraer
            </a>


            <form
                method="POST"
                action="{{ route('logout') }}"
                class="logout-form"
            >
                @csrf

                <button
                    type="submit"
                    class="logout-button"
                >
                    ↻ &nbsp; Cerrar sesión
                </button>

            </form>

        </div>

    </aside>


    <!-- =========================
         CONTENIDO
    ========================== -->

    <main class="main">

        <!-- HEADER -->

        <header class="header">

            <div class="header-title">

                <h1>
                    Agenda del día
                </h1>

                <p>
                    Miércoles, 3 de septiembre de 2026
                </p>

            </div>


            <div class="header-stats">

                <div>

                    <div class="header-stat-number">
                        5
                    </div>

                    <div class="header-stat-label">
                        Citas
                    </div>

                </div>


                <div>

                    <div class="header-stat-number red">
                        1
                    </div>

                    <div class="header-stat-label">
                        En proceso
                    </div>

                </div>

            </div>

        </header>


        <!-- AGENDA -->

        <section class="content">


            <!-- CITA 1 -->

            <div class="appointment">

                <div class="time">
                    08:00
                </div>

                <div class="client">

                    <div class="client-name">
                        Ana García
                    </div>

                    <div class="plates">
                        ABC-123
                    </div>

                </div>

                <div class="vehicle">

                    <div class="vehicle-name">
                        Toyota Corolla 2020
                    </div>

                    <div class="service">
                        Cambio de aceite + frenos
                    </div>

                </div>

                <div class="status-container">

                    <span class="status status-progress">
                        En proceso
                    </span>

                </div>

            </div>


            <!-- CITA 2 -->

            <div class="appointment">

                <div class="time">
                    10:00
                </div>

                <div class="client">

                    <div class="client-name">
                        Roberto Lima
                    </div>

                    <div class="plates">
                        DEF-456
                    </div>

                </div>

                <div class="vehicle">

                    <div class="vehicle-name">
                        Honda Civic 2019
                    </div>

                    <div class="service">
                        Diagnóstico eléctrico
                    </div>

                </div>

                <div class="status-container">

                    <span class="status status-waiting">
                        Esperando
                    </span>

                </div>

            </div>


            <!-- CITA 3 -->

            <div class="appointment">

                <div class="time">
                    11:30
                </div>

                <div class="client">

                    <div class="client-name">
                        Sofía Reyes
                    </div>

                    <div class="plates">
                        GHI-789
                    </div>

                </div>

                <div class="vehicle">

                    <div class="vehicle-name">
                        Nissan Sentra 2021
                    </div>

                    <div class="service">
                        Alineación y balanceo
                    </div>

                </div>

                <div class="status-container">

                    <span class="status status-pending">
                        Pendiente
                    </span>

                </div>

            </div>


            <!-- CITA 4 -->

            <div class="appointment">

                <div class="time">
                    14:00
                </div>

                <div class="client">

                    <div class="client-name">
                        Marco Peña
                    </div>

                    <div class="plates">
                        JKL-012
                    </div>

                </div>

                <div class="vehicle">

                    <div class="vehicle-name">
                        Ford F-150 2017
                    </div>

                    <div class="service">
                        Revisión general
                    </div>

                </div>

                <div class="status-container">

                    <span class="status status-pending">
                        Pendiente
                    </span>

                </div>

            </div>


            <!-- CITA 5 -->

            <div class="appointment">

                <div class="time">
                    16:00
                </div>

                <div class="client">

                    <div class="client-name">
                        Valeria Ruiz
                    </div>

                    <div class="plates">
                        MNO-345
                    </div>

                </div>

                <div class="vehicle">

                    <div class="vehicle-name">
                        Chevrolet Spark 2022
                    </div>

                    <div class="service">
                        Cambio de aceite
                    </div>

                </div>

                <div class="status-container">

                    <span class="status status-pending">
                        Pendiente
                    </span>

                </div>

            </div>


        </section>

    </main>

</div>

</body>
</html>