<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis vehículos - AutoManager</title>

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

        /* SIDEBAR */
        .sidebar {
            width: 220px;
            background: #050505;
            color: white;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
            margin-bottom: 4px;
        }

        .session-name {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .logout {
            background: none;
            border: none;
            color: #aaa;
            cursor: pointer;
            padding: 0;
        }

        .logout:hover {
            color: white;
        }

        /* CONTENIDO */
        .main {
            flex: 1;
        }

        .topbar {
            background: white;
            border-bottom: 1px solid #ddd;
            padding: 28px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .topbar h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .topbar p {
            color: #777;
            font-size: 14px;
        }

        .btn-red {
            background: #e52b2b;
            color: white;
            border: none;
            padding: 12px 18px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-red:hover {
            background: #c82020;
        }

        .content {
            padding: 32px;
        }

        /* MENSAJES */
        .success {
            padding: 14px;
            background: #e8f6e8;
            border: 1px solid #a6d7a6;
            margin-bottom: 20px;
        }

        .errors {
            padding: 14px;
            background: #ffe9e9;
            border: 1px solid #e5aaaa;
            margin-bottom: 20px;
        }

        .errors ul {
            margin-left: 20px;
        }

        /* FORMULARIO */
        .vehicle-form {
            background: white;
            border: 1px solid #ddd;
            padding: 26px;
            margin-bottom: 20px;
        }

        .vehicle-form h3 {
            margin-bottom: 22px;
            font-size: 16px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .field label {
            display: block;
            margin-bottom: 7px;
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
        }

        .field input {
            width: 100%;
            height: 42px;
            border: 2px solid #222;
            padding: 0 12px;
            font-size: 14px;
            outline: none;
        }

        .field input:focus {
            border-color: #e52b2b;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 18px;
        }

        .btn-cancel {
            padding: 11px 18px;
            border: 1px solid #ddd;
            background: white;
            cursor: pointer;
        }

        /* VEHÍCULOS */
        .vehicle-item {
            background: white;
            border: 1px solid #ddd;
            padding: 25px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .vehicle-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .vehicle-icon {
            width: 42px;
            height: 42px;
            background: #050505;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .vehicle-name {
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .vehicle-details {
            display: flex;
            gap: 22px;
            flex-wrap: wrap;
            font-size: 12px;
            color: #777;
        }

        .plates {
            background: #f3f3f3;
            padding: 4px 8px;
            color: #333;
            font-family: monospace;
        }

        .edit-link {
            color: #e52b2b;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
        }

        .empty {
            background: white;
            border: 1px solid #ddd;
            padding: 35px;
            text-align: center;
            color: #777;
        }

        @media (max-width: 800px) {
            .sidebar {
                width: 180px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .vehicle-item {
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

<div class="layout">

    <aside class="sidebar">

        <div class="logo">
            <div class="logo-title">🔴 AutoManager</div>
            <span class="logo-role">Cliente</span>
        </div>

        <nav class="menu">
            <a href="/cliente">Inicio</a>

            <a href="{{ route('cliente.vehiculos') }}" class="active">
                Mis vehículos
            </a>

            <a href="#">Agendar cita</a>
            <a href="#">Mis citas</a>
            <a href="#">Rastrear orden</a>
            <a href="#">Historial</a>
            <a href="#">Autorizaciones</a>

            <a href="{{ route('profile.edit') }}">
                Perfil
            </a>
        </nav>

        <div class="session">
            <div class="session-label">Sesión activa</div>
            <div class="session-name">
                {{ auth()->user()->name }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout">
                    ⏻ Cerrar sesión
                </button>
            </form>
        </div>

    </aside>

    <main class="main">

        <header class="topbar">

            <div>
                <h1>Mis vehículos</h1>
                <p>Administra los vehículos de tu cuenta</p>
            </div>

            <button
                type="button"
                class="btn-red"
                onclick="mostrarFormulario()">
                + Agregar vehículo
            </button>

        </header>

        <section class="content">

            @if(session('success'))
                <div class="success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="errors">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- FORMULARIO AGREGAR / EDITAR --}}
<div
    id="formularioVehiculo"
    class="vehicle-form"
    style="{{ isset($vehicle) || $errors->any() ? '' : 'display:none;' }}"
>

    <h3>
        {{ isset($vehicle) ? 'Editar vehículo' : 'Nuevo vehículo' }}
    </h3>

    <form
        method="POST"
        action="{{ isset($vehicle)
            ? route('cliente.vehiculos.update', $vehicle)
            : route('cliente.vehiculos.store') }}"
    >
        @csrf

        @if(isset($vehicle))
            @method('PUT')
        @endif

        <div class="form-grid">

            <div class="field">
                <label>Marca</label>
                <input
                    type="text"
                    name="brand"
                    value="{{ old('brand', $vehicle->brand ?? '') }}"
                    placeholder="Marca"
                    required>
            </div>

            <div class="field">
                <label>Modelo</label>
                <input
                    type="text"
                    name="model"
                    value="{{ old('model', $vehicle->model ?? '') }}"
                    placeholder="Modelo"
                    required>
            </div>

            <div class="field">
                <label>Año</label>
                <input
                    type="number"
                    name="year"
                    value="{{ old('year', $vehicle->year ?? '') }}"
                    placeholder="Año"
                    min="1950"
                    max="2035"
                    required>
            </div>

            <div class="field">
                <label>Motor</label>
                <input
                    type="text"
                    name="engine"
                    value="{{ old('engine', $vehicle->engine ?? '') }}"
                    placeholder="Motor"
                    required>
            </div>

            <div class="field">
                <label>Placas</label>
                <input
                    type="text"
                    name="plates"
                    value="{{ old('plates', $vehicle->plates ?? '') }}"
                    placeholder="Placas">
            </div>

            <div class="field">
                <label>Kilometraje</label>
                <input
                    type="number"
                    name="mileage"
                    value="{{ old('mileage', $vehicle->mileage ?? '') }}"
                    placeholder="Kilometraje"
                    min="0"
                    required>
            </div>

            <div class="field">
                <label>Color</label>
                <input
                    type="text"
                    name="color"
                    value="{{ old('color', $vehicle->color ?? '') }}"
                    placeholder="Color"
                    required>
            </div>

        </div>

        <div class="form-actions">

            <button type="submit" class="btn-red">
                {{ isset($vehicle) ? 'Guardar cambios' : 'Guardar' }}
            </button>

            @if(isset($vehicle))
                <a
                    href="{{ route('cliente.vehiculos') }}"
                    class="btn-cancel"
                    style="text-decoration:none; color:#111;">
                    Cancelar
                </a>
            @else
                <button
                    type="button"
                    class="btn-cancel"
                    onclick="ocultarFormulario()">
                    Cancelar
                </button>
            @endif

        </div>

    </form>

</div>


            {{-- LISTADO --}}
            @forelse($vehicles as $vehicle)

                <div class="vehicle-item">

                    <div class="vehicle-left">

                        <div class="vehicle-icon">
                            🚗
                        </div>

                        <div>

                            <div class="vehicle-name">
                                {{ $vehicle->brand }}
                                {{ $vehicle->model }}
                                {{ $vehicle->year }}
                            </div>

                            <div class="vehicle-details">

                                <span class="plates">
                                    {{ $vehicle->plates ?: 'Sin placas' }}
                                </span>

                                <span>
                                    {{ number_format($vehicle->mileage ?? 0) }} km
                                </span>

                                <span>
                                    {{ $vehicle->color ?: 'Sin color' }}
                                </span>

                            </div>

                        </div>

                    </div>

                    <a href="{{ route('cliente.vehiculos.edit', $vehicle) }}" class="edit-link">
                        Editar
                    </a>

                </div>

            @empty

                <div class="empty">
                    <strong>No tienes vehículos registrados.</strong>
                    <p>
                        Presiona "+ Agregar vehículo" para registrar el primero.
                    </p>
                </div>

            @endforelse

        </section>

    </main>

</div>

<script>
    function mostrarFormulario() {
        document.getElementById('formularioVehiculo').style.display = 'block';
    }

    function ocultarFormulario() {
        document.getElementById('formularioVehiculo').style.display = 'none';
    }
</script>

</body>
</html>