<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Citas - AutoManager</title>

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
        ========================== */

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
           HEADER DE CONTENIDO
        ========================== */

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;

            margin-bottom: 20px;
        }

        .page-header h2 {
            font-size: 22px;
        }

        .page-header p {
            color: #777;
            font-size: 14px;
            margin-top: 5px;
        }

        .btn-primary {
            display: inline-block;

            background: #e11d2e;
            color: white;

            text-decoration: none;

            padding: 12px 18px;

            border-radius: 8px;

            font-size: 14px;
            font-weight: bold;

            transition: 0.2s;

            white-space: nowrap;
        }

        .btn-primary:hover {
            background: #c91828;
        }

        /* =========================
           CONTENEDOR
        ========================== */

        .section {
            background: white;

            border: 1px solid #ddd;
        }

        .section-header {
            padding: 18px 22px;

            border-bottom: 1px solid #ddd;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 20px;
        }

        .section-header h3 {
            font-size: 18px;
        }

        /* =========================
           BUSCADOR
        ========================== */

        .search-wrapper {
            position: relative;
        }

        .search-input {
            width: 340px;

            padding: 11px 14px;

            border: 1px solid #ccc;

            border-radius: 8px;

            font-size: 14px;

            outline: none;

            background: #fafafa;

            transition: 0.2s;
        }

        .search-input:focus {
            border-color: #e11d2e;

            background: white;

            box-shadow: 0 0 0 3px rgba(225, 29, 46, 0.10);
        }

        /* =========================
           MENSAJE
        ========================== */

        .success-message {
            margin: 18px 22px 0;

            padding: 12px 16px;

            background: #dcfce7;

            color: #166534;

            border: 1px solid #bbf7d0;

            border-radius: 8px;

            font-size: 14px;

            font-weight: 600;
        }

        /* =========================
           TABLA
        ========================== */

        .table-wrapper {
            width: 100%;

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
            padding: 15px 16px;

            text-align: left;

            font-size: 13px;

            font-weight: bold;
        }

        td {
            padding: 15px 16px;

            border-bottom: 1px solid #eee;

            font-size: 14px;

            vertical-align: middle;
        }

        tbody tr {
            transition: 0.15s;
        }

        tbody tr:hover {
            background: #f8f8f8;
        }

        /* =========================
           ESTADO
        ========================== */

        .status {
            display: inline-block;

            padding: 6px 10px;

            border-radius: 999px;

            font-size: 12px;

            font-weight: bold;

            background: #fee2e2;

            color: #b91c1c;
        }

        .status-select {
            padding: 7px 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: white;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            outline: none;
        }

        .status-select:focus {
            border-color: #e11d2e;
            box-shadow: 0 0 0 3px rgba(225, 29, 46, 0.10);
        }

        /* =========================
           BOTONES
        ========================== */

        .actions {
            display: flex;

            align-items: center;

            gap: 8px;

            white-space: nowrap;
        }

        .btn-edit {
            display: inline-block;

            background: #050505;

            color: white;

            text-decoration: none;

            padding: 8px 12px;

            border-radius: 7px;

            font-size: 13px;

            font-weight: 600;

            transition: 0.2s;
        }

        .btn-edit:hover {
            background: #222;
        }

        .btn-delete {
            background: #dc2626;

            color: white;

            border: none;

            padding: 8px 12px;

            border-radius: 7px;

            cursor: pointer;

            font-size: 13px;

            font-weight: 600;

            transition: 0.2s;
        }

        .btn-delete:hover {
            background: #b91c1c;
        }

        /* =========================
           VACÍO
        ========================== */

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

        /* =========================
           RESPONSIVE
        ========================== */

        @media (max-width: 1000px) {

            .section-header {
                align-items: stretch;
                flex-direction: column;
            }

            .search-input {
                width: 100%;
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

            .page-header {
                align-items: stretch;

                flex-direction: column;
            }

            .btn-primary {
                text-align: center;
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


            <nav class="menu">

                <a href="{{ url('/admin') }}">
                    Dashboard
                </a>

                <a href="{{ route('citas.index') }}" class="active">
                    Citas
                </a>

                <a href="#">
                    Usuarios
                </a>

                <a href="{{ route('vehiculos.index') }}">
                    Vehículos
                </a>

                <a href="#">
                    Mecánicos
                </a>

                <a href="#">
                    Inventario
                </a>

                <a href="#">
                    Reportes
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
                Citas
            </h1>

            <p>
                Administración y seguimiento de las citas del taller
            </p>

        </div>


        <!-- CONTENIDO -->

        <div class="content">


            <div class="page-header">

                <div>

                    <h2>
                        Citas registradas
                    </h2>

                    <p>
                        Consulta, busca, edita o elimina las citas existentes.
                    </p>

                </div>


                <a href="{{ route('citas.create') }}"
                   class="btn-primary">

                    + Nueva Cita

                </a>

            </div>


            <div class="section">


                <div class="section-header">

                    <h3>
                        Lista de citas
                    </h3>

                    <div class="search-wrapper">

                        <form method="GET"
                              id="searchForm">

                            <input
                                id="searchInput"
                                type="text"
                                name="buscar"
                                value="{{ $buscar }}"
                                placeholder="Buscar por folio, cliente o vehículo..."
                                class="search-input"
                                autocomplete="off">

                        </form>

                    </div>

                </div>


                @if(session('success'))

                    <div class="success-message">

                        {{ session('success') }}

                    </div>

                @endif


                <div class="table-wrapper">

                    <div id="tablaCitas">

                        <table>

                            <thead>

                            <tr>

                                <th>
                                    Cliente
                                </th>

                                <th>
                                    Vehículo
                                </th>

                                <th>
                                    Mecánico
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

                            @forelse($appointments as $appointment)

                                <tr>

                                    <td>
                                        {{ $appointment->client->name }}
                                    </td>


                                    <td>

                                        {{ $appointment->vehicle->brand }}

                                        {{ $appointment->vehicle->model }}

                                        ({{ $appointment->vehicle->year }})

                                    </td>

                                    <td>

                                        <form
                                            action="{{ route('citas.updateMechanic', $appointment) }}"
                                            method="POST"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <select
                                                name="mechanic_id"
                                                class="status-select"
                                                onchange="this.form.submit()"
                                            >
                                                <option value="">
                                                    Sin asignar
                                                </option>

                                                @foreach($mechanics as $mechanic)

                                                    <option value="{{ $mechanic->id }}"
                                                        {{ $appointment->mechanic_id === $mechanic->id ? 'selected' : '' }}>
                                                        {{ $mechanic->name }}
                                                    </option>

                                                @endforeach

                                            </select>
                                        </form>


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
    <form
        action="{{ route('citas.updateStatus', $appointment) }}"
        method="POST"
    >
        @csrf
        @method('PATCH')

        <select
            name="status"
            class="status-select"
            onchange="this.form.submit()"
        >
            <option value="pendiente"
                {{ $appointment->status === 'pendiente' ? 'selected' : '' }}>
                Pendiente
            </option>

            <option value="diagnostico"
                {{ $appointment->status === 'diagnostico' ? 'selected' : '' }}>
                Diagnóstico
            </option>

            <option value="en_proceso"
                {{ $appointment->status === 'en_proceso' ? 'selected' : '' }}>
                En proceso
            </option>

            <option value="control_calidad"
                {{ $appointment->status === 'control_calidad' ? 'selected' : '' }}>
                Control de calidad
            </option>

            <option value="listo"
                {{ $appointment->status === 'listo' ? 'selected' : '' }}>
                Listo para entrega
            </option>
        </select>
    </form>
</td>


                                    <td>

                                        <div class="actions">


                                            <a href="{{ route('citas.edit', $appointment) }}"
                                               class="btn-edit">

                                                Editar

                                            </a>


                                            <form
                                                action="{{ route('citas.destroy', $appointment) }}"
                                                method="POST"
                                                onsubmit="return confirm('¿Eliminar esta cita?')">

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn-delete">

                                                    Eliminar

                                                </button>

                                            </form>


                                        </div>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td colspan="8">

                                        <div class="empty">

                                            <strong>
                                                No hay citas registradas
                                            </strong>

                                            <span>
                                                Cuando se registre una cita aparecerá aquí.
                                            </span>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </main>

</div>


<!-- =========================
     BÚSQUEDA EN TIEMPO REAL
========================== -->

<script>

    let timer;

    const input = document.getElementById('searchInput');

    input.addEventListener('input', () => {

        clearTimeout(timer);

        timer = setTimeout(async () => {

            const url =
                `{{ route('citas.index') }}?buscar=${encodeURIComponent(input.value)}`;

            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const html = await response.text();

            const parser = new DOMParser();

            const doc = parser.parseFromString(html, 'text/html');

            const nuevaTabla =
                doc.getElementById('tablaCitas');

            if (nuevaTabla) {

                document.getElementById('tablaCitas').innerHTML =
                    nuevaTabla.innerHTML;

            }

            input.focus();

            input.setSelectionRange(
                input.value.length,
                input.value.length
            );

        }, 300);

    });

</script>

</body>

</html>