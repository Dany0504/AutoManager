<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Vehículo - AutoManager</title>

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

        /* SIDEBAR BOTTOM */

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

        /* HEADER */

        .page-header {
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

        /* FORM */

        .section {
            background: white;

            border: 1px solid #ddd;
        }

        .section-header {
            padding: 18px 22px;

            border-bottom: 1px solid #ddd;
        }

        .section-header h3 {
            font-size: 18px;

            border-left: 4px solid #e11d2e;

            padding-left: 12px;
        }

        .section-body {
            padding: 22px;
        }

        .grid-2 {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 18px;
        }

        .field {
            width: 100%;
        }

        .field label {
            display: block;

            font-size: 14px;

            font-weight: bold;

            margin-bottom: 7px;
        }

        .field input,
        .field select {
            width: 100%;

            border: 1px solid #ccc;

            border-radius: 8px;

            padding: 11px 13px;

            font-size: 14px;

            font-family: Arial, sans-serif;

            outline: none;

            background: white;

            transition: 0.2s;
        }

        .field input:focus,
        .field select:focus {
            border-color: #e11d2e;

            box-shadow: 0 0 0 3px rgba(225, 29, 46, 0.10);
        }

        .form-actions {
            display: flex;

            justify-content: flex-end;

            gap: 10px;

            margin-top: 20px;
        }

        .btn-red {
            background: #e11d2e;

            color: white;

            border: none;

            border-radius: 8px;

            padding: 12px 18px;

            font-size: 14px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.2s;
        }

        .btn-red:hover {
            background: #c91828;
        }

        .btn-black {
            display: inline-block;

            background: #050505;

            color: white;

            text-decoration: none;

            border: none;

            border-radius: 8px;

            padding: 12px 18px;

            font-size: 14px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.2s;
        }

        .btn-black:hover {
            background: #222;
        }

        /* RESPONSIVE */

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

            .grid-2 {
                grid-template-columns: 1fr;
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

            .section-body {
                padding: 16px;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .form-actions button,
            .form-actions a {
                width: 100%;

                text-align: center;
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
                        Administrador
                    </p>

                </div>

            </div>


            <nav class="menu">

                <a href="{{ url('/admin') }}">
                    Dashboard
                </a>

                <a href="{{ route('citas.index') }}">
                    Citas
                </a>

                <a href="#">
                    Usuarios
                </a>

                <a href="{{ route('vehiculos.index') }}" class="active">
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


    <!-- MAIN -->

    <main class="main">


        <div class="topbar">

            <h1>
                Editar vehículo
            </h1>

            <p>
                Actualiza la información del vehículo.
            </p>

        </div>


        <div class="content">


            <div class="page-header">

                <h2>
                    Editar vehículo
                </h2>

                <p>
                    Modifica los datos y guarda los cambios.
                </p>

            </div>


            <form
                action="{{ route('vehiculos.update', $vehiculo) }}"
                method="POST">

                @csrf

                @method('PUT')


                <div class="section">


                    <div class="section-header">

                        <h3>
                            Datos del Vehículo
                        </h3>

                    </div>


                    <div class="section-body">


                        <!-- CLIENTE -->

                        <div class="field">

                            <label for="client_id">
                                Cliente
                            </label>

                            <select
                                id="client_id"
                                name="client_id"
                                required>

                                @foreach($clients as $client)

                                    <option
                                        value="{{ $client->id }}"
                                        @selected(
                                            old(
                                                'client_id',
                                                $vehiculo->client_id
                                            ) == $client->id
                                        )>

                                        {{ $client->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="grid-2" style="margin-top:18px;">


                            <!-- MARCA -->

                            <div class="field">

                                <label for="brand">
                                    Marca
                                </label>

                                <input
                                    type="text"
                                    id="brand"
                                    name="brand"
                                    value="{{ old('brand', $vehiculo->brand) }}"
                                    required>

                            </div>


                            <!-- MODELO -->

                            <div class="field">

                                <label for="model">
                                    Modelo
                                </label>

                                <input
                                    type="text"
                                    id="model"
                                    name="model"
                                    value="{{ old('model', $vehiculo->model) }}"
                                    required>

                            </div>


                        </div>


                        <div class="grid-2" style="margin-top:18px;">


                            <!-- AÑO -->

                            <div class="field">

                                <label for="year">
                                    Año
                                </label>

                                <input
                                    type="number"
                                    id="year"
                                    name="year"
                                    min="1950"
                                    max="2035"
                                    value="{{ old('year', $vehiculo->year) }}"
                                    required>

                            </div>


                            <!-- MOTOR -->

                            <div class="field">

                                <label for="engine">
                                    Motor
                                </label>

                                <input
                                    type="text"
                                    id="engine"
                                    name="engine"
                                    value="{{ old('engine', $vehiculo->engine) }}"
                                    placeholder="Ej. 2.4L">

                            </div>


                        </div>


                        <div class="grid-2" style="margin-top:18px;">


                            <!-- COLOR -->

                            <div class="field">

                                <label for="color">
                                    Color
                                </label>

                                <input
                                    type="text"
                                    id="color"
                                    name="color"
                                    value="{{ old('color', $vehiculo->color) }}"
                                    required>

                            </div>


                            <!-- PLACAS -->

                            <div class="field">

                                <label for="plates">
                                    Placas
                                </label>

                                <input
                                    type="text"
                                    id="plates"
                                    name="plates"
                                    value="{{ old('plates', $vehiculo->plates) }}">

                            </div>


                        </div>


                        <div class="grid-2" style="margin-top:18px;">


                            <!-- KILOMETRAJE -->

                            <div class="field">

                                <label for="mileage">
                                    Kilometraje
                                </label>

                                <input
                                    type="number"
                                    id="mileage"
                                    name="mileage"
                                    min="0"
                                    value="{{ old('mileage', $vehiculo->mileage) }}"
                                    required>

                            </div>


                            <!-- VIN -->

                            <div class="field">

                                <label for="vin">
                                    VIN (Opcional)
                                </label>

                                <input
                                    type="text"
                                    id="vin"
                                    name="vin"
                                    maxlength="30"
                                    value="{{ old('vin', $vehiculo->vin) }}">

                            </div>


                        </div>


                        <!-- BOTONES -->

                        <div class="form-actions">

                            <a
                                href="{{ route('vehiculos.index') }}"
                                class="btn-black">

                                Cancelar

                            </a>


                            <button
                                type="submit"
                                class="btn-red">

                                Guardar Cambios

                            </button>

                        </div>


                    </div>

                </div>


            </form>

        </div>

    </main>

</div>

</body>

</html>