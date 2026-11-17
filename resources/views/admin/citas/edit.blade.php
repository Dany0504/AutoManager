<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Cita - AutoManager</title>

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
           PAGE HEADER
        ========================== */

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;

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

        /* =========================
           FORM SECTION
        ========================== */

        .section {
            background: white;

            border: 1px solid #ddd;

            margin-bottom: 20px;
        }

        .section-header {
            padding: 18px 22px;

            border-bottom: 1px solid #ddd;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 15px;
        }

        .section-header h3 {
            font-size: 18px;
        }

        .section-header.red-line h3 {
            border-left: 4px solid #e11d2e;

            padding-left: 12px;
        }

        .section-body {
            padding: 22px;
        }

        /* =========================
           GRID
        ========================== */

        .grid-2 {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 18px;
        }

        .grid-3 {
            display: grid;

            grid-template-columns: repeat(3, 1fr);

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
        .field select,
        .field textarea {
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
        .field select:focus,
        .field textarea:focus {
            border-color: #e11d2e;

            box-shadow: 0 0 0 3px rgba(225, 29, 46, 0.10);
        }

        .field input[readonly] {
            background: #f1f1f1;

            color: #777;
        }

        .field textarea {
            resize: none;

            min-height: 120px;
        }

        /* =========================
           ACTION BUTTONS
        ========================== */

        .btn-red {
            background: #e11d2e;

            color: white;

            border: none;

            border-radius: 8px;

            padding: 11px 17px;

            font-size: 14px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.2s;
        }

        .btn-red:hover {
            background: #c91828;
        }

        .btn-black {
            background: #050505;

            color: white;

            border: none;

            border-radius: 8px;

            padding: 11px 17px;

            font-size: 14px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.2s;
        }

        .btn-black:hover {
            background: #222;
        }

        .btn-gray {
            background: #e5e5e5;

            color: #222;

            border: none;

            border-radius: 8px;

            padding: 11px 17px;

            font-size: 14px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.2s;
        }

        .btn-gray:hover {
            background: #d4d4d4;
        }

        .form-actions {
            display: flex;

            justify-content: flex-end;

            gap: 10px;

            margin-top: 5px;
        }

        /* =========================
           VEHICLE MESSAGE
        ========================== */

        .vehicle-message {
            color: #dc2626;

            font-size: 13px;

            margin-top: 7px;
        }

        .hidden {
            display: none;
        }

        /* =========================
           MODAL
        ========================== */

        .modal {
            position: fixed;

            inset: 0;

            background: rgba(0, 0, 0, 0.70);

            display: none;

            align-items: center;
            justify-content: center;

            z-index: 1000;

            padding: 20px;
        }

        .modal.show {
            display: flex;
        }

        .modal-box {
            background: white;

            border-radius: 18px;

            width: 100%;

            max-width: 720px;

            max-height: 90vh;

            overflow-y: auto;

            box-shadow: 0 20px 50px rgba(0,0,0,.30);
        }

        .modal-header {
            background: #050505;

            color: white;

            padding: 22px 26px;

            display: flex;

            justify-content: space-between;

            align-items: center;
        }

        .modal-header h2 {
            font-size: 22px;
        }

        .modal-header p {
            color: #aaa;

            font-size: 13px;

            margin-top: 5px;
        }

        .modal-close {
            background: none;

            border: none;

            color: white;

            font-size: 30px;

            cursor: pointer;

            line-height: 1;
        }

        .modal-body {
            padding: 26px;
        }

        .modal-actions {
            display: flex;

            justify-content: flex-end;

            gap: 10px;

            margin-top: 20px;
        }

        /* =========================
           SUCCESS
        ========================== */

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

        /* =========================
           RESPONSIVE
        ========================== */

        @media (max-width: 1000px) {

            .grid-3 {
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

            .page-header {
                align-items: stretch;

                flex-direction: column;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .form-actions a,
            .form-actions button {
                width: 100%;

                text-align: center;
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

                <a href="{{ route('ordenes.index') }}">
                    Órdenes
                </a>

                <a href="{{ route('reportes.index') }}">
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


        <div class="topbar">

            <h1>
                Editar cita
            </h1>

            <p>
                Modifica la información y programación de la cita.
            </p>

        </div>


        <div class="content">


            <div class="page-header">

                <div>

                    <h2>
                        Cita #{{ $cita->folio ?? $cita->id }}
                    </h2>

                    <p>
                        Actualiza los datos del cliente, vehículo y servicio.
                    </p>

                </div>

            </div>


            @if(session('success'))

                <div class="success-message">
                    {{ session('success') }}
                </div>

            @endif


            <!-- =========================
                 FORMULARIO
            ========================== -->

            <form
                action="{{ route('citas.update', $cita) }}"
                method="POST">

                @csrf

                @method('PUT')



<!-- =========================
     ASIGNACIÓN DEL MECÁNICO
========================== -->
<div class="section">
    <div class="section-header red-line">
        <h3>Asignación del mecánico</h3>
    </div>

    <div class="section-body">
        <div class="field">
            <label for="mechanic_id">Mecánico asignado</label>

            <select id="mechanic_id" name="mechanic_id">
                <option value="">Sin asignar</option>

                @foreach($mechanics as $mechanic)
                    <option
                        value="{{ $mechanic->id }}"
                        {{ old('mechanic_id', $cita->mechanic_id) == $mechanic->id ? 'selected' : '' }}
                    >
                        {{ $mechanic->name }}
                    </option>
                @endforeach
            </select>

            @error('mechanic_id')
                <p class="vehicle-message">{{ $message }}</p>
            @enderror

            <p style="color:#777; font-size:13px; margin-top:8px;">
                Selecciona el mecánico responsable de esta cita o déjala sin asignar.
            </p>
        </div>
    </div>
</div>


                <!-- =========================
                 CLIENTE
                ========================== -->

                <div class="section">

                    <div class="section-header red-line">

                        <h3>
                            Datos del Cliente
                        </h3>

                        <button
                            type="button"
                            id="openClientModal"
                            class="btn-red">

                            + Nuevo Cliente

                        </button>

                    </div>


                    <div class="section-body">

                        <div class="grid-2">


                            <div class="field">

                                <label for="clientSelect">
                                    Cliente
                                </label>

                                <select
                                    id="clientSelect"
                                    name="client_id"
                                    required>

                                    @foreach($clients as $client)

                                        <option
                                            value="{{ $client->id }}"
                                            @selected(old('client_id', $cita->client_id) == $client->id)>

                                            {{ $client->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="field">

                                <label for="phone">
                                    Teléfono
                                </label>

                                <input
                                    type="text"
                                    id="phone"
                                    value="{{ $cita->client?->phone }}"
                                    readonly>

                            </div>


                        </div>

                    </div>

                </div>


                <!-- =========================
                     VEHICULO
                ========================== -->

                <div class="section">

                    <div class="section-header red-line">

                        <h3>
                            Datos del Vehículo
                        </h3>

                    </div>


                    <div class="section-body">

                        <div class="grid-2">


                            <div class="field">

                                <label for="vehicleSelect">
                                    Vehículo
                                </label>

                                <select
                                    id="vehicleSelect"
                                    name="vehicle_id"
                                    required>

                                    <option value="">
                                        Selecciona un vehículo
                                    </option>

                                </select>


                                <p
                                    id="vehicleMessage"
                                    class="vehicle-message hidden">

                                    Este cliente no tiene vehículos registrados.

                                </p>

                            </div>


                            <div style="display:flex;align-items:flex-end;">

                                <button
                                    type="button"
                                    id="openVehicleModal"
                                    class="btn-black">

                                    + Registrar Vehículo

                                </button>

                            </div>


                            <div class="field">

                                <label for="mileage">
                                    Kilometraje actual
                                </label>

                                <input
                                    type="number"
                                    id="mileage"
                                    name="mileage"
                                    value="{{ old('mileage', $cita->vehicle?->mileage) }}"
                                    placeholder="258000">

                            </div>


                        </div>

                    </div>

                </div>


                <!-- =========================
                     SERVICIO
                ========================== -->

                <div class="section">

                    <div class="section-header red-line">

                        <h3>
                            Servicio
                        </h3>

                    </div>


                    <div class="section-body">


                        <div class="grid-3">


                            <div class="field">

                                <label for="service_type">
                                    Servicio
                                </label>

                                <select
                                    id="service_type"
                                    name="service_type"
                                    required>

                                    <option
                                        value="Mantenimiento general"
                                        @selected(old('service_type', $cita->service_type) == 'Mantenimiento general')>

                                        Mantenimiento general

                                    </option>

                                    <option
                                        value="Diagnóstico"
                                        @selected(old('service_type', $cita->service_type) == 'Diagnóstico')>

                                        Diagnóstico

                                    </option>

                                    <option
                                        value="Cambio de aceite"
                                        @selected(old('service_type', $cita->service_type) == 'Cambio de aceite')>

                                        Cambio de aceite

                                    </option>

                                    <option
                                        value="Frenos"
                                        @selected(old('service_type', $cita->service_type) == 'Frenos')>

                                        Frenos

                                    </option>

                                    <option
                                        value="Suspensión"
                                        @selected(old('service_type', $cita->service_type) == 'Suspensión')>

                                        Suspensión

                                    </option>

                                    <option
                                        value="Motor"
                                        @selected(old('service_type', $cita->service_type) == 'Motor')>

                                        Motor

                                    </option>

                                    <option
                                        value="Transmisión"
                                        @selected(old('service_type', $cita->service_type) == 'Transmisión')>

                                        Transmisión

                                    </option>

                                    <option
                                        value="Eléctrico"
                                        @selected(old('service_type', $cita->service_type) == 'Eléctrico')>

                                        Eléctrico

                                    </option>

                                    <option
                                        value="Otro"
                                        @selected(old('service_type', $cita->service_type) == 'Otro')>

                                        Otro

                                    </option>

                                </select>

                            </div>


                            <div class="field">

                                <label for="priority">
                                    Prioridad
                                </label>

                                <select
                                    id="priority"
                                    name="priority">

                                    <option
                                        value="Normal"
                                        @selected(old('priority', $cita->priority ?? 'Normal') == 'Normal')>

                                        Normal

                                    </option>

                                    <option
                                        value="Urgente"
                                        @selected(old('priority', $cita->priority ?? '') == 'Urgente')>

                                        Urgente

                                    </option>

                                </select>

                            </div>


                            <div class="field">

                                <label for="appointment_date">
                                    Fecha
                                </label>

                                <input
                                    type="date"
                                    id="appointment_date"
                                    name="appointment_date"
                                    value="{{ old('appointment_date', $cita->appointment_date) }}"
                                    required>

                            </div>


                            <div class="field">

                                <label for="appointment_time">
                                    Hora
                                </label>

                                <input
                                    type="time"
                                    id="appointment_time"
                                    name="appointment_time"
                                    value="{{ old('appointment_time', substr($cita->appointment_time, 0, 5)) }}"
                                    required>

                            </div>


                        </div>


                        <div class="field" style="margin-top:18px;">

                            <label for="notes">
                                Observaciones
                            </label>

                            <textarea
                                id="notes"
                                name="notes"
                                rows="4"
                                placeholder="Describe la falla...">{{ old('notes', $cita->notes) }}</textarea>

                        </div>


                    </div>

                </div>


                <!-- =========================
                     BOTONES
                ========================== -->

                <div class="form-actions">

                    <a
                        href="{{ route('citas.index') }}"
                        class="btn-black"
                        style="text-decoration:none;">

                        Cancelar

                    </a>


                    <button
                        type="submit"
                        class="btn-red">

                        Guardar Cambios

                    </button>

                </div>


            </form>


        </div>

    </main>

</div>


<!-- =========================================================
     MODAL REGISTRAR VEHÍCULO
========================================================= -->

<div
    id="vehicleModal"
    class="modal">


    <div class="modal-box">


        <div class="modal-header">

            <div>

                <h2>
                    Registrar Vehículo
                </h2>

                <p>
                    Agrega un vehículo al cliente seleccionado.
                </p>

            </div>


            <button
                type="button"
                id="closeVehicleModal"
                class="modal-close">

                ×

            </button>

        </div>


        <div class="modal-body">


            <form
                id="newVehicleForm">

                @csrf


                <input
                    type="hidden"
                    id="vehicleClientId"
                    name="client_id"
                    required>


                <div class="grid-2">


                    <div class="field">

                        <label for="yearSelect">
                            Año
                        </label>

                        <select
                            id="yearSelect"
                            name="year"
                            required>

                            <option value="">
                                Selecciona un año
                            </option>

                            @for($year = date('Y'); $year >= 1995; $year--)

                                <option value="{{ $year }}">
                                    {{ $year }}
                                </option>

                            @endfor

                        </select>

                    </div>


                    <div class="field">

                        <label for="brandSelect">
                            Marca
                        </label>

                        <input
                            type="text"
                            id="brandSelect"
                            name="brand"
                            required
                            placeholder="Ej. Toyota">

                    </div>


                    <div class="field">

                        <label for="modelSelect">
                            Modelo
                        </label>

                        <input
                            type="text"
                            id="modelSelect"
                            name="model"
                            required
                            placeholder="Ej. Corolla">

                    </div>


                    <div class="field">

                        <label for="engineSelect">
                            Motor
                        </label>

                        <input
                            type="text"
                            id="engineSelect"
                            name="engine"
                            required
                            placeholder="Ej. 1.8L">

                    </div>


                    <div class="field">

                        <label for="vehicleColor">
                            Color
                        </label>

                        <input
                            type="text"
                            id="vehicleColor"
                            name="color"
                            required
                            placeholder="Ej. Azul">

                    </div>


                    <div class="field">

                        <label for="vehicleMileage">
                            Kilometraje
                        </label>

                        <input
                            type="number"
                            id="vehicleMileage"
                            name="mileage"
                            required
                            placeholder="258000">

                    </div>


                </div>


                <div class="field" style="margin-top:18px;">

                    <label for="vehiclePlates">
                        Placas
                    </label>

                    <input
                        type="text"
                        id="vehiclePlates"
                        name="plates"
                        placeholder="WEJ117">

                </div>


                <div class="field" style="margin-top:18px;">

                    <label for="vehicleVin">
                        VIN (opcional)
                    </label>

                    <input
                        type="text"
                        id="vehicleVin"
                        name="vin"
                        placeholder="1HGCM82633A123456">

                </div>


                <div class="modal-actions">

                    <button
                        type="button"
                        id="cancelVehicleModal"
                        class="btn-gray">

                        Cancelar

                    </button>


                    <button
                        type="submit"
                        class="btn-red">

                        Guardar Vehículo

                    </button>

                </div>


            </form>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =====================================================
       ELEMENTOS DEL FORMULARIO PRINCIPAL
    ===================================================== */

    const clientSelect = document.getElementById('clientSelect');

    const phoneInput = document.getElementById('phone');

    const vehicleSelect = document.getElementById('vehicleSelect');

    const vehicleMessage = document.getElementById('vehicleMessage');

    const mileageInput = document.getElementById('mileage');


    const initialVehicleId =
        @json(old('vehicle_id', $cita->vehicle_id));


    let currentVehicles = [];


    /* =====================================================
       CARGAR CLIENTE Y VEHÍCULOS
    ===================================================== */

    async function loadClientData(id, selectedVehicleId = null) {

        if (!id) {
            return;
        }


        const response =
            await fetch(`/admin/clientes/${id}/vehiculos`);


        const data =
            await response.json();


        phoneInput.value =
            data.phone ?? '';


        currentVehicles =
            data.vehicles;


        vehicleSelect.innerHTML =
            '<option value="">Selecciona un vehículo</option>';


        if (data.vehicles.length === 0) {

            vehicleMessage.classList.remove('hidden');

            mileageInput.value = '';

            return;

        }


        vehicleMessage.classList.add('hidden');


        data.vehicles.forEach(vehicle => {


            const option =
                document.createElement('option');


            option.value =
                vehicle.id;


            option.textContent =
                `${vehicle.brand} ${vehicle.model} ${vehicle.year}`;


            if (
                selectedVehicleId &&
                String(vehicle.id) === String(selectedVehicleId)
            ) {

                option.selected = true;

            }


            vehicleSelect.appendChild(option);

        });


        actualizarKilometraje();

    }


    /* =====================================================
       ACTUALIZAR KILOMETRAJE
    ===================================================== */

    function actualizarKilometraje() {


        const vehicle =
            currentVehicles.find(
                vehicle =>
                    String(vehicle.id) ===
                    String(vehicleSelect.value)
            );


        mileageInput.value =
            vehicle?.mileage ?? '';

    }


    /* =====================================================
       CAMBIAR CLIENTE
    ===================================================== */

    clientSelect.addEventListener(
        'change',
        async () => {

            mileageInput.value = '';

            await loadClientData(
                clientSelect.value
            );

        }
    );


    /* =====================================================
       CAMBIAR VEHÍCULO
    ===================================================== */

    vehicleSelect.addEventListener(
        'change',
        actualizarKilometraje
    );


    /* =====================================================
       CARGA INICIAL
    ===================================================== */

    if (clientSelect.value) {

        loadClientData(
            clientSelect.value,
            initialVehicleId
        );

    }


    /* =====================================================
       MODAL
    ===================================================== */

    const modal =
        document.getElementById('vehicleModal');

    const open =
        document.getElementById('openVehicleModal');

    const close =
        document.getElementById('closeVehicleModal');

    const cancel =
        document.getElementById('cancelVehicleModal');

    const form =
        document.getElementById('newVehicleForm');


    /* =====================================================
       ABRIR MODAL
    ===================================================== */

    open.addEventListener('click', () => {


        if (!clientSelect.value) {

            alert(
                'Primero selecciona un cliente.'
            );

            return;

        }


        document.getElementById(
            'vehicleClientId'
        ).value =
            clientSelect.value;


        modal.classList.add('show');

    });


    /* =====================================================
       CERRAR MODAL
    ===================================================== */

    function cerrarModal() {

        modal.classList.remove('show');

        form.reset();

    }


    close.addEventListener(
        'click',
        cerrarModal
    );


    cancel.addEventListener(
        'click',
        cerrarModal
    );


    modal.addEventListener(
        'click',
        function (e) {

            if (e.target === modal) {

                cerrarModal();

            }

        }
    );


    /* =====================================================
       GUARDAR VEHÍCULO
    ===================================================== */

    form.addEventListener(
        'submit',
        async function (e) {

            e.preventDefault();


            try {

                const data =
                    new FormData(form);


                const response =
                    await fetch(
                        '/admin/vehiculos/ajax',
                        {
                            method: 'POST',

                            headers: {
                                'X-CSRF-TOKEN':
                                    form.querySelector(
                                        'input[name="_token"]'
                                    ).value,

                                'Accept':
                                    'application/json'
                            },

                            body: data
                        }
                    );


                const result =
                    await response.json();


                if (!response.ok) {

                    console.error(result);

                    alert(
                        'Error al guardar el vehículo.'
                    );

                    return;

                }


                const texto =
                    `${result.vehicle.brand} ${result.vehicle.model} (${result.vehicle.year})`;


                vehicleSelect.appendChild(
                    new Option(
                        texto,
                        result.vehicle.id,
                        true,
                        true
                    )
                );


                currentVehicles.push(
                    result.vehicle
                );


                actualizarKilometraje();


                cerrarModal();


            } catch (error) {

                console.error(error);

                alert(
                    'Ocurrió un error. Revisa la consola (F12).'
                );

            }

        }
    );

});

</script>


@include('partials.campos-obligatorios')
</body>

</html>