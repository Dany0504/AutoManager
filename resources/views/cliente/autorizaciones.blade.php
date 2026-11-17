<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Autorizaciones - AutoManager</title>

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
        ========================== */

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

        /* =========================
           MAIN
        ========================== */

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

        /* =========================
           ALERT
        ========================== */

        .notification {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            color: #9a3412;

            padding: 16px 18px;

            border-radius: 10px;

            margin-bottom: 22px;
        }

        .notification strong {
            display: block;
            margin-bottom: 5px;
        }

        /* =========================
           EMPTY
        ========================== */

        .empty {
            background: white;
            border: 1px solid #ddd;
            border-radius: 12px;

            padding: 50px 25px;

            text-align: center;
        }

        .empty h2 {
            font-size: 20px;
            margin-bottom: 8px;
        }

        .empty p {
            color: #777;
        }

        /* =========================
           AUTH CARD
        ========================== */

        .authorization-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 12px;

            padding: 25px;

            margin-bottom: 20px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;

            gap: 20px;

            margin-bottom: 20px;
        }

        .folio {
            color: #e11d2e;
            font-weight: bold;
            font-size: 13px;
        }

        .card-header h2 {
            font-size: 20px;
            margin-top: 5px;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;

            padding: 7px 12px;

            border-radius: 999px;

            font-size: 12px;
            font-weight: bold;

            white-space: nowrap;
        }

        .info-grid {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 14px;

            margin-bottom: 20px;
        }

        .info {
            background: #f8f8f8;

            padding: 14px;

            border-radius: 8px;
        }

        .info span {
            display: block;

            color: #777;

            font-size: 12px;

            margin-bottom: 5px;
        }

        .info strong {
            font-size: 14px;
        }

        .diagnosis-box {
            border-top: 1px solid #eee;

            padding-top: 20px;

            margin-top: 5px;
        }

        .diagnosis-box h3 {
            font-size: 16px;

            margin-bottom: 10px;
        }

        .diagnosis-text {
            background: #fafafa;

            border: 1px solid #eee;

            border-radius: 8px;

            padding: 15px;

            color: #444;

            line-height: 1.6;

            white-space: pre-line;
        }

        .price-box {
            margin-top: 18px;

            background: #f5f5f5;

            border-radius: 8px;

            padding: 16px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .price-box span {
            color: #777;
            font-size: 14px;
        }

        .price-box strong {
            font-size: 24px;
        }

        .footer-note {
            margin-top: 18px;

            color: #777;

            font-size: 13px;
        }

        .actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 20px;
}

.actions form {
    margin: 0;
}

.btn-reject,
.btn-approve {
    border: none;
    border-radius: 8px;
    padding: 12px 18px;
    font-weight: bold;
    cursor: pointer;
    font-size: 14px;
}

.btn-reject {
    background: #e5e5e5;
    color: #111;
}

.btn-reject:hover {
    background: #d4d4d4;
}

.btn-approve {
    background: #e11d2e;
    color: white;
}

.btn-approve:hover {
    background: #c91828;
}

@media (max-width: 600px) {

    .actions {
        flex-direction: column;
    }

    .btn-reject,
    .btn-approve {
        width: 100%;
    }

}

        /* =========================
           RESPONSIVE
        ========================== */

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

            .content {
                padding: 18px;
            }

        }

        @media (max-width: 600px) {

            .menu {
                grid-template-columns: 1fr;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .card-header {
                flex-direction: column;
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
                        Cliente
                    </p>

                </div>

            </div>

            <nav class="menu">
            @include('cliente.partials.menu')
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

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button type="submit">
                    ◦ Cerrar sesión
                </button>

            </form>

        </div>

    </aside>


    <!-- MAIN -->

    <main class="main">

        <header class="topbar">

            <h1>
                Autorizaciones.
            </h1>

            <p>
                Revisa los diagnósticos y presupuestos de tus vehículos.
            </p>

        </header>


        <section class="content">

        @if(session('success'))

    <div class="notification">

        <strong>
            {{ session('success') }}
        </strong>

    </div>

@endif

            @if($appointments->count())

                <div class="notification">

                    <strong>
                        Tienes {{ $appointments->count() }}
                        {{ $appointments->count() === 1 ? 'autorización pendiente' : 'autorizaciones pendientes' }}.
                    </strong>

                    Revisa cuidadosamente el diagnóstico y el costo estimado de cada reparación.

                </div>


                @foreach($appointments as $appointment)

                    <div class="authorization-card">

                        <div class="card-header">

                            <div>

                                <div class="folio">
                                    {{ $appointment->folio }}
                                </div>

                                <h2>

                                    {{ $appointment->vehicle->brand }}

                                    {{ $appointment->vehicle->model }}

                                    {{ $appointment->vehicle->year }}

                                </h2>

                            </div>


                            <div class="pending">
                                Pendiente de autorización
                            </div>

                        </div>


                        <div class="info-grid">

                            <div class="info">

                                <span>
                                    Servicio solicitado
                                </span>

                                <strong>
                                    {{ $appointment->service_type }}
                                </strong>

                            </div>


                            <div class="info">

                                <span>
                                    Mecánico
                                </span>

                                <strong>
                                    {{ $appointment->mechanic?->name ?? 'Sin asignar' }}
                                </strong>

                            </div>


                            <div class="info">

                                <span>
                                    Fecha
                                </span>

                                <strong>
                                    {{ optional($appointment->diagnosis_submitted_at)->format('d/m/Y H:i') }}
                                </strong>

                            </div>


                            <div class="info">

                                <span>
                                    Placas
                                </span>

                                <strong>
                                    {{ $appointment->vehicle->plates ?? 'Sin placas' }}
                                </strong>

                            </div>

                        </div>


                        <div class="diagnosis-box">

                            <h3>
                                Diagnóstico del mecánico
                            </h3>

                            <div class="diagnosis-text">

                                {{ $appointment->diagnosis }}

                            </div>

                        </div>


                        <div class="price-box">

                            <span>
                                Costo estimado de reparación
                            </span>

                            <strong>
                                ${{ number_format($appointment->estimated_cost, 2) }}
                                MXN
                            </strong>

                        </div>


                        <div class="actions">

    <form
        action="{{ route('cliente.autorizaciones.reject', $appointment) }}"
        method="POST"
        onsubmit="return confirm('¿Estás seguro de rechazar esta reparación?')"
    >

        @csrf
        @method('PATCH')

        <button
            type="submit"
            class="btn-reject"
        >
            Rechazar
        </button>

    </form>


    <form
        action="{{ route('cliente.autorizaciones.approve', $appointment) }}"
        method="POST"
        onsubmit="return confirm('¿Deseas autorizar esta reparación por ${{ number_format($appointment->estimated_cost, 2) }} MXN?')"
    >

        @csrf
        @method('PATCH')

        <button
            type="submit"
            class="btn-approve"
        >
            Autorizar reparación
        </button>

    </form>

</div>

                    </div>

                @endforeach

            @else

                <div class="empty">

                    <h2>
                        No tienes autorizaciones pendientes
                    </h2>

                    <p>
                        Cuando un mecánico termine el diagnóstico de tu vehículo,
                        aparecerá aquí para que puedas revisarlo.

                    </p>

                </div>

            @endif

        </section>

    </main>

</div>

</body>

</html>