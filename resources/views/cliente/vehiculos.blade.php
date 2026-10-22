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

        /* =========================
           SIDEBAR
        ========================== */

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
            font-size: 13px;
        }

        .logout:hover {
            color: white;
        }

        /* =========================
           CONTENIDO
        ========================== */

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

        /* =========================
           MENSAJES
        ========================== */

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

        /* =========================
           FORMULARIO
        ========================== */

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

        .field input,
.field select {
    width: 100%;
    height: 42px;
    border: 2px solid #222;
    background: white;
    padding: 0 12px;
    font-size: 14px;
    outline: none;
}

.field input:focus,
.field select:focus {
    border-color: #e52b2b;
}

.field select:disabled {
    background: #f3f3f3;
    color: #999;
    cursor: not-allowed;
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

        /* =========================
           VEHÍCULOS
        ========================== */

        .vehicle-item {
            background: white;
            border: 1px solid #ddd;
            padding: 25px;
            margin-bottom: 16px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            min-height: 100px;
        }

        .vehicle-left {
            display: flex;
            align-items: center;
        }

        .vehicle-name {
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /*
         * Todos los datos utilizan la misma altura,
         * tipografía y alineación.
         */
        .vehicle-details {
            display: flex;
            align-items: center;
            gap: 26px;
            flex-wrap: wrap;

            font-size: 13px;
            color: #777;
            line-height: 20px;
        }

        .vehicle-details span {
            display: inline-flex;
            align-items: center;
            height: 20px;
            padding: 0;
            margin: 0;
        }

        /*
         * La placa ya no tiene cajita gris,
         * padding especial ni fuente monospace.
         */
        .plates {
            background: transparent;
            padding: 0;
            color: #777;
            font-family: Arial, sans-serif;
        }

        .edit-link {
            color: #e52b2b;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
        }

        .edit-link:hover {
            text-decoration: underline;
        }

        .empty {
            background: white;
            border: 1px solid #ddd;
            padding: 35px;
            text-align: center;
            color: #777;
        }

        .empty p {
            margin-top: 8px;
        }

        /* =========================
           RESPONSIVE
        ========================== */

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

            .vehicle-details {
                gap: 12px;
                flex-direction: column;
                align-items: flex-start;
            }
        }

        .vehicles-section {
    margin-top: 20px;
}

.field select {
    width: 100%;
    height: 42px;
    border: 2px solid #222;
    background: white;
    padding: 0 12px;
    font-size: 14px;
    outline: none;
}

.field select:focus {
    border-color: #e52b2b;
}

.field select:disabled {
    background: #f3f3f3;
    color: #999;
    cursor: not-allowed;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
}

@media (max-width: 800px) {

    .form-grid {
        grid-template-columns: 1fr;
    }

}
    </style>
</head>

<body>

<div class="layout">

    {{-- =========================
         SIDEBAR
    ========================== --}}

    <aside class="sidebar">

        <div class="logo">
            <div class="logo-title">AutoManager</div>
            <span class="logo-role">Cliente</span>
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

        <div class="session">

            <div class="session-label">
                Sesión activa
            </div>

            <div class="session-name">
                {{ auth()->user()->name }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="logout">
                    Cerrar sesión
                </button>
            </form>

        </div>

    </aside>


    {{-- =========================
         CONTENIDO PRINCIPAL
    ========================== --}}

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

    {{-- MENSAJES --}}

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


    {{-- =========================
         FORMULARIO
    ========================== --}}

    <div
        id="formularioVehiculo"
        class="vehicle-form"
        style="{{ request('nuevo') || isset($vehicle) || $errors->any() ? '' : 'display:none;' }}"
    >

        <h3>
            {{ isset($vehicle) ? 'Editar vehículo' : 'Nuevo vehículo' }}
        </h3>

        <form
            method="POST"
            action="{{
                isset($vehicle)
                    ? route('cliente.vehiculos.update', $vehicle)
                    : route('cliente.vehiculos.store')
            }}"
        >

            @csrf

            @if(isset($vehicle))
                @method('PUT')
            @endif


            <div class="form-grid">

                {{-- AÑO --}}

                <div class="field">

                    <label>Año</label>

                    <select
                        id="yearSelect"
                        name="year"
                        required
                    >

                        <option value="">
                            Selecciona un año
                        </option>

                        @for($year = date('Y'); $year >= 1995; $year--)

                            <option
                                value="{{ $year }}"
                                @selected(old('year', $vehicle->year ?? '') == $year)
                            >
                                {{ $year }}
                            </option>

                        @endfor

                    </select>

                </div>


                {{-- MARCA --}}

                <div class="field">

                    <label>Marca</label>

                    <select
                        id="brandSelect"
                        name="brand"
                        required
                        disabled
                    >

                        <option value="">
                            Primero selecciona el año
                        </option>

                    </select>

                </div>


                {{-- MODELO --}}

                <div class="field">

                    <label>Modelo</label>

                    <select
                        id="modelSelect"
                        name="model"
                        required
                        disabled
                    >

                        <option value="">
                            Primero selecciona la marca
                        </option>

                    </select>

                </div>


                {{-- MOTOR --}}

                <div class="field">

                    <label>Motor</label>

                    <select
                        id="engineSelect"
                        name="engine"
                        required
                        disabled
                    >

                        <option value="">
                            Primero selecciona el modelo
                        </option>

                    </select>

                </div>


                {{-- PLACAS --}}

                <div class="field">

                    <label>Placas</label>

                    <input
                        type="text"
                        name="plates"
                        value="{{ old('plates', $vehicle->plates ?? '') }}"
                        placeholder="Placas"
                    >

                </div>


                {{-- KILOMETRAJE --}}

                <div class="field">

                    <label>Kilometraje</label>

                    <input
                        type="number"
                        name="mileage"
                        value="{{ old('mileage', $vehicle->mileage ?? '') }}"
                        placeholder="Kilometraje"
                        min="0"
                        required
                    >

                </div>


                {{-- COLOR --}}

                <div class="field">

                    <label>Color</label>

                    <input
                        type="text"
                        name="color"
                        value="{{ old('color', $vehicle->color ?? '') }}"
                        placeholder="Color"
                        required
                    >

                </div>

            </div>


            <div class="form-actions">

                <button
                    type="submit"
                    class="btn-red"
                >
                    {{ isset($vehicle) ? 'Guardar cambios' : 'Guardar' }}
                </button>


                <button
                    type="button"
                    class="btn-cancel"
                    onclick="ocultarFormulario()"
                >
                    Cancelar
                </button>

            </div>

        </form>

    </div>


    {{-- =========================
         LISTADO DE VEHÍCULOS
    ========================== --}}

    <div class="vehicles-section">

        @forelse($vehicles as $vehicle)

            <div class="vehicle-item">

                <div class="vehicle-left">

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

                            @if($vehicle->engine)

                                <span>
                                    {{ $vehicle->engine }}
                                </span>

                            @endif

                        </div>

                    </div>

                </div>


                <a
                    href="{{ route('cliente.vehiculos.edit', $vehicle) }}"
                    class="edit-link"
                >
                    Editar
                </a>

            </div>

        @empty

            <div class="empty">

                <strong>
                    No tienes vehículos registrados.
                </strong>

                <p>
                    Agrega tu primer vehículo para poder agendar una cita.
                </p>

            </div>

        @endforelse

    </div>

</section>

    </main>

</div>


{{-- =========================
     JAVASCRIPT
========================== --}}

<script>

function mostrarFormulario() {
    document.getElementById('formularioVehiculo').style.display = 'block';
}

function ocultarFormulario() {
    document.getElementById('formularioVehiculo').style.display = 'none';
}


// ===============================
// CATÁLOGO DE VEHÍCULOS
// ===============================

const yearSelect = document.getElementById('yearSelect');
const brandSelect = document.getElementById('brandSelect');
const modelSelect = document.getElementById('modelSelect');
const engineSelect = document.getElementById('engineSelect');


// ===============================
// AÑO → MARCAS
// ===============================

yearSelect.addEventListener('change', async function () {

    brandSelect.disabled = true;
    modelSelect.disabled = true;
    engineSelect.disabled = true;

    brandSelect.innerHTML =
        '<option value="">Cargando marcas...</option>';

    modelSelect.innerHTML =
        '<option value="">Primero selecciona la marca</option>';

    engineSelect.innerHTML =
        '<option value="">Primero selecciona el modelo</option>';

    if (!this.value) {
        return;
    }

    try {

        const response = await fetch(
            `/catalog/marcas/${this.value}`
        );

        const brands = await response.json();

        brandSelect.innerHTML =
            '<option value="">Selecciona una marca</option>';

        brands.forEach(brand => {

            brandSelect.innerHTML += `
                <option value="${brand}">
                    ${brand}
                </option>
            `;

        });

        brandSelect.disabled = false;

    } catch (error) {

        console.error(error);

        brandSelect.innerHTML =
            '<option value="">Error al cargar marcas</option>';
    }
});


// ===============================
// MARCA → MODELOS
// ===============================

brandSelect.addEventListener('change', async function () {

    modelSelect.disabled = true;
    engineSelect.disabled = true;

    modelSelect.innerHTML =
        '<option value="">Cargando modelos...</option>';

    engineSelect.innerHTML =
        '<option value="">Primero selecciona el modelo</option>';

    if (!this.value) {
        return;
    }

    try {

        const response = await fetch(
            `/catalog/modelos/${yearSelect.value}/${encodeURIComponent(this.value)}`
        );

        const models = await response.json();

        modelSelect.innerHTML =
            '<option value="">Selecciona un modelo</option>';

        models.forEach(model => {

            modelSelect.innerHTML += `
                <option value="${model}">
                    ${model}
                </option>
            `;

        });

        modelSelect.disabled = false;

    } catch (error) {

        console.error(error);

        modelSelect.innerHTML =
            '<option value="">Error al cargar modelos</option>';
    }
});


// ===============================
// MODELO → MOTORES
// ===============================

modelSelect.addEventListener('change', async function () {

    engineSelect.disabled = true;

    engineSelect.innerHTML =
        '<option value="">Cargando motores...</option>';

    if (!this.value) {
        return;
    }

    try {

        const response = await fetch(
            `/catalog/motores/${yearSelect.value}/${encodeURIComponent(brandSelect.value)}/${encodeURIComponent(this.value)}`
        );

        const engines = await response.json();

        engineSelect.innerHTML =
            '<option value="">Selecciona un motor</option>';

        engines.forEach(engine => {

            engineSelect.innerHTML += `
                <option value="${engine}">
                    ${engine}
                </option>
            `;

        });

        engineSelect.disabled = false;

    } catch (error) {

        console.error(error);

        engineSelect.innerHTML =
            '<option value="">Error al cargar motores</option>';
    }
});


// ===============================
// EDITAR VEHÍCULO
// ===============================

document.addEventListener('DOMContentLoaded', async function () {

    const selectedYear = "{{ old('year', $vehicle->year ?? '') }}";
    const selectedBrand = "{{ old('brand', $vehicle->brand ?? '') }}";
    const selectedModel = "{{ old('model', $vehicle->model ?? '') }}";
    const selectedEngine = "{{ old('engine', $vehicle->engine ?? '') }}";

    if (!selectedYear) {
        return;
    }

    yearSelect.value = selectedYear;

    // Cargar marcas
    const brandResponse = await fetch(
        `/catalog/marcas/${selectedYear}`
    );

    const brands = await brandResponse.json();

    brandSelect.innerHTML =
        '<option value="">Selecciona una marca</option>';

    brands.forEach(brand => {

        brandSelect.innerHTML += `
            <option
                value="${brand}"
                ${brand === selectedBrand ? 'selected' : ''}
            >
                ${brand}
            </option>
        `;

    });

    brandSelect.disabled = false;

    if (!selectedBrand) {
        return;
    }

    // Cargar modelos
    const modelResponse = await fetch(
        `/catalog/modelos/${selectedYear}/${encodeURIComponent(selectedBrand)}`
    );

    const models = await modelResponse.json();

    modelSelect.innerHTML =
        '<option value="">Selecciona un modelo</option>';

    models.forEach(model => {

        modelSelect.innerHTML += `
            <option
                value="${model}"
                ${model === selectedModel ? 'selected' : ''}
            >
                ${model}
            </option>
        `;

    });

    modelSelect.disabled = false;

    if (!selectedModel) {
        return;
    }

    // Cargar motores
    const engineResponse = await fetch(
        `/catalog/motores/${selectedYear}/${encodeURIComponent(selectedBrand)}/${encodeURIComponent(selectedModel)}`
    );

    const engines = await engineResponse.json();

    engineSelect.innerHTML =
        '<option value="">Selecciona un motor</option>';

    engines.forEach(engine => {

        engineSelect.innerHTML += `
            <option
                value="${engine}"
                ${engine === selectedEngine ? 'selected' : ''}
            >
                ${engine}
            </option>
        `;

    });

    engineSelect.disabled = false;
});

</script>

</body>
</html>