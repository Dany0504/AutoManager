<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Agendar cita - AutoManager</title>

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
            min-height: 100vh;
            background: #050505;
            color: white;
            display: flex;
            flex-direction: column;
        }

        .logo {
            padding: 22px 18px;
            border-bottom: 1px solid #222;
        }

        .logo-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 16px;
            font-weight: bold;
        }

        .logo-box {
            width: 27px;
            height: 27px;
            background: #e52b2b;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 3px;
            font-size: 13px;
        }

        .logo-role {
            display: block;
            margin-top: 4px;
            margin-left: 37px;
            color: #999;
            font-size: 11px;
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
            margin-bottom: 5px;
        }

        .session-name {
            font-weight: bold;
            margin-bottom: 18px;
        }

        .logout {
            border: none;
            background: none;
            color: #aaa;
            cursor: pointer;
            padding: 0;
        }

        .logout:hover {
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
            background: white;
            border-bottom: 1px solid #ddd;
            padding: 27px 32px;
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
            padding: 30px 32px;
        }

        /* =========================
           MENSAJES
        ========================== */

        .success {
            background: #e9f7e9;
            border: 1px solid #a6d7a6;
            padding: 14px 16px;
            margin-bottom: 20px;
        }

        .errors {
            background: #ffe9e9;
            border: 1px solid #e5aaaa;
            padding: 14px 16px;
            margin-bottom: 20px;
        }

        .errors ul {
            margin-left: 20px;
        }

        /* =========================
           INDICADOR DE PASOS
        ========================== */

        .steps {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            border: 1px solid #ddd;
            background: white;
            margin-bottom: 30px;
        }

        .step-indicator {
            padding: 14px 12px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }

        .step-indicator.active {
            background: #e52b2b;
            color: white;
            font-weight: bold;
        }

        .step-indicator.completed {
            background: #050505;
            color: white;
            font-weight: bold;
        }

        .step-number {
            margin-right: 6px;
            opacity: .8;
        }

        /* =========================
           TARJETA
        ========================== */

        .appointment-card {
            width: 570px;
            max-width: 100%;
            background: white;
            border: 1px solid #ddd;
            padding: 25px;
        }

        .step-content {
            display: none;
        }

        .step-content.active {
            display: block;
        }

        .field {
            margin-bottom: 20px;
        }

        .field label {
            display: block;
            color: #666;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .field select,
        .field input {
            width: 100%;
            height: 44px;
            border: 2px solid #222;
            background: white;
            padding: 0 12px;
            font-size: 14px;
            outline: none;
        }

        .field select:focus,
        .field input:focus {
            border-color: #e52b2b;
        }

        /* =========================
           SERVICIOS
        ========================== */

        .service-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .fault-field {
            margin-top: 18px;
        }

        .fault-field label {
            display: block;
            color: #666;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .fault-field textarea {
            width: 100%;
            min-height: 95px;
            border: 2px solid #222;
            background: white;
            padding: 12px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            resize: vertical;
            outline: none;
        }

        .fault-field textarea:focus {
            border-color: #e52b2b;
        }

        .service-option {
            position: relative;
        }

        .service-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .service-option label {
            display: flex;
            align-items: center;
            min-height: 44px;
            border: 2px solid #e1e1e1;
            padding: 10px 12px;
            cursor: pointer;
            font-size: 13px;
            transition: .15s;
        }

        .service-option label:hover {
            border-color: #999;
        }

        .service-option input:checked + label {
            border-color: #e52b2b;
            background: #fff4f4;
            color: #e52b2b;
            font-weight: bold;
        }

        /* =========================
           HORARIOS
        ========================== */

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-top: 8px;
        }

        .time-option {
            position: relative;
        }

        .time-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .time-option label {
            display: flex;
            height: 44px;
            align-items: center;
            justify-content: center;
            border: 2px solid #e1e1e1;
            cursor: pointer;
            font-family: monospace;
            font-size: 14px;
        }

        .time-option label:hover {
            border-color: #999;
        }

        .time-option input:checked + label {
            border-color: #e52b2b;
            color: #e52b2b;
            background: #fff4f4;
            font-weight: bold;
        }

        /* =========================
           BOTONES
        ========================== */

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-next,
        .btn-confirm {
            flex: 1;
            min-height: 44px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            padding: 10px 18px;
        }

        .btn-next {
            background: #050505;
            color: white;
        }

        .btn-confirm {
            background: #e52b2b;
            color: white;
        }

        .btn-confirm:hover {
            background: #c82020;
        }

        .btn-back {
            min-height: 44px;
            border: 2px solid #111;
            background: white;
            padding: 10px 18px;
            cursor: pointer;
            font-weight: bold;
        }

        /* =========================
           CONFIRMACIÓN
        ========================== */

        .confirm-title {
            font-size: 17px;
            margin-bottom: 10px;
        }

        .confirm-row {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }

        .confirm-label {
            color: #777;
        }

        .confirm-value {
            text-align: right;
            font-weight: bold;
        }

        .warning {
            display: none;
            padding: 11px 13px;
            margin-bottom: 18px;
            background: #fff3f3;
            border: 1px solid #e52b2b;
            color: #b51d1d;
            font-size: 13px;
        }

        /* =========================
           RESPONSIVE
        ========================== */

        @media(max-width: 850px) {
            .sidebar {
                width: 185px;
            }

            .content {
                padding: 20px;
            }

            .service-grid {
                grid-template-columns: 1fr;
            }

            .schedule-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>

<div class="layout">

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        <div class="logo">

            <div class="logo-title">
                <div class="logo-box">A</div>
                AutoManager
            </div>

            <span class="logo-role">
                Cliente
            </span>

        </div>

        <nav class="menu">

            <a href="{{ route('cliente.dashboard') }}">
                Inicio
            </a>

            <a href="{{ route('cliente.vehiculos') }}">
                Mis vehículos
            </a>

            <a href="{{ route('cliente.citas.create') }}" class="active">
                Agendar cita
            </a>

            <a href="#">
                Mis citas
            </a>

            <a href="#">
                Rastrear orden
            </a>

            <a href="#">
                Historial
            </a>

            <a href="#">
                Autorizaciones
            </a>

            <a href="{{ route('profile.edit') }}">
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


    {{-- CONTENIDO --}}
    <main class="main">

        <header class="topbar">

            <h1>Agendar cita</h1>

            <p>
                Selecciona vehículo, servicio, fecha y hora
            </p>

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


            {{-- PASOS --}}
            <div class="steps">

                <div
                    id="indicator1"
                    class="step-indicator active"
                >
                    <span class="step-number">1</span>
                    Vehículo y servicio
                </div>

                <div
                    id="indicator2"
                    class="step-indicator"
                >
                    <span class="step-number">2</span>
                    Fecha y hora
                </div>

                <div
                    id="indicator3"
                    class="step-indicator"
                >
                    <span class="step-number">3</span>
                    Confirmar
                </div>

            </div>


            <div id="warning" class="warning"></div>


            <form
                method="POST"
                action="{{ route('cliente.citas.store') }}"
                id="appointmentForm"
            >

                @csrf


                {{-- ======================================
                     PASO 1
                ======================================= --}}

                <div
                    id="step1"
                    class="appointment-card step-content active"
                >

                    <div class="field">

                        <label for="vehicle_id">
                            Vehículo
                        </label>

                        <select
                            name="vehicle_id"
                            id="vehicle_id"
                            required
                        >

                            <option value="">
                                Seleccionar vehículo
                            </option>

                            @foreach($vehicles as $vehicle)

                                <option
                                    value="{{ $vehicle->id }}"
                                    data-brand="{{ $vehicle->brand }}"
                                    data-model="{{ $vehicle->model }}"
                                    data-year="{{ $vehicle->year }}"
                                    data-plates="{{ $vehicle->plates ?: 'Sin placas' }}"
                                    {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}
                                >
                                    {{ $vehicle->brand }}
                                    {{ $vehicle->model }}
                                    {{ $vehicle->year }}

                                    @if($vehicle->plates)
                                        - {{ $vehicle->plates }}
                                    @endif
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="field">

                        <label>
                            Tipo de servicio
                        </label>


                        <div class="service-grid">

                            <div class="service-option">

                                <input
                                    type="radio"
                                    name="service_type"
                                    id="service_oil"
                                    value="Cambio de aceite"
                                    {{ old('service_type') === 'Cambio de aceite' ? 'checked' : '' }}
                                >

                                <label for="service_oil">
                                    Cambio de aceite
                                </label>

                            </div>


                            <div class="service-option">

                                <input
                                    type="radio"
                                    name="service_type"
                                    id="service_brakes"
                                    value="Frenos"
                                    {{ old('service_type') === 'Frenos' ? 'checked' : '' }}
                                >

                                <label for="service_brakes">
                                    Frenos
                                </label>

                            </div>


                            <div class="service-option">

                                <input
                                    type="radio"
                                    name="service_type"
                                    id="service_alignment"
                                    value="Alineación y balanceo"
                                    {{ old('service_type') === 'Alineación y balanceo' ? 'checked' : '' }}
                                >

                                <label for="service_alignment">
                                    Alineación y balanceo
                                </label>

                            </div>


                            <div class="service-option">

                                <input
                                    type="radio"
                                    name="service_type"
                                    id="service_major"
                                    value="Servicio mayor"
                                    {{ old('service_type') === 'Servicio mayor' ? 'checked' : '' }}
                                >

                                <label for="service_major">
                                    Servicio mayor
                                </label>

                            </div>


                            <div class="service-option">

                                <input
                                    type="radio"
                                    name="service_type"
                                    id="service_general"
                                    value="Revisión general"
                                    {{ old('service_type') === 'Revisión general' ? 'checked' : '' }}
                                >

                                <label for="service_general">
                                    Revisión general
                                </label>

                            </div>


                            <div class="service-option">

                                <input
                                    type="radio"
                                    name="service_type"
                                    id="service_electric"
                                    value="Diagnóstico eléctrico"
                                    {{ old('service_type') === 'Diagnóstico eléctrico' ? 'checked' : '' }}
                                >

                                <label for="service_electric">
                                    Diagnóstico eléctrico
                                </label>

                            </div>

                        </div>
                        <div class="fault-field">
                                <label for="notes">
                                    Describe la falla
                                </label>

                                <textarea
                                    name="notes"
                                    id="notes"
                                    maxlength="1000"
                                    placeholder="Ej. Hace un ruido al frenar, vibra al acelerar, no enciende correctamente..."
                                >{{ old('notes') }}</textarea>
                            </div>

                    </div>


                    <div class="actions">

                        <button
                            type="button"
                            class="btn-next"
                            onclick="goStep2()"
                        >
                            Continuar →
                        </button>

                    </div>

                </div>


                {{-- ======================================
                     PASO 2
                ======================================= --}}

                <div
                    id="step2"
                    class="appointment-card step-content"
                >

                    <div class="field">

                        <label for="appointment_date">
                            Fecha
                        </label>

                        <input
                            type="date"
                            name="appointment_date"
                            id="appointment_date"
                            min="{{ now()->format('Y-m-d') }}"
                            value="{{ old('appointment_date') }}"
                            required
                        >

                    </div>


                    <div class="field">

                        <label>
                            Horario disponible
                        </label>


                        <div class="schedule-grid">

                            @foreach([
                                '08:00',
                                '09:00',
                                '10:00',
                                '11:00',
                                '14:00',
                                '15:00',
                                '16:00',
                                '17:00'
                            ] as $time)

                                @php
                                    $timeId = 'time_' . str_replace(':', '', $time);
                                @endphp

                                <div class="time-option">

                                    <input
                                        type="radio"
                                        name="appointment_time"
                                        id="{{ $timeId }}"
                                        value="{{ $time }}"
                                        {{ old('appointment_time') === $time ? 'checked' : '' }}
                                    >

                                    <label for="{{ $timeId }}">
                                        {{ $time }}
                                    </label>

                                </div>

                            @endforeach

                        </div>

                    </div>


                    <div class="actions">

                        <button
                            type="button"
                            class="btn-back"
                            onclick="showStep(1)"
                        >
                            ← Atrás
                        </button>

                        <button
                            type="button"
                            class="btn-next"
                            onclick="goStep3()"
                        >
                            Continuar →
                        </button>

                    </div>

                </div>


                {{-- ======================================
                     PASO 3
                ======================================= --}}

                <div
                    id="step3"
                    class="appointment-card step-content"
                >

                    <h3 class="confirm-title">
                        Confirmar cita
                    </h3>


                    <div class="confirm-row">

                        <span class="confirm-label">
                            Vehículo
                        </span>

                        <span
                            class="confirm-value"
                            id="confirmVehicle"
                        >
                        </span>

                    </div>


                    <div class="confirm-row">

                        <span class="confirm-label">
                            Servicio
                        </span>

                        <span
                            class="confirm-value"
                            id="confirmService"
                        >
                        </span>

                    </div>


                    <div class="confirm-row">

                        <span class="confirm-label">
                            Fecha
                        </span>

                        <span
                            class="confirm-value"
                            id="confirmDate"
                        >
                        </span>

                    </div>


                    <div class="confirm-row">

                        <span class="confirm-label">
                            Hora
                        </span>

                        <span
                            class="confirm-value"
                            id="confirmTime"
                        >
                        </span>

                    </div>


                    <div class="actions">

                        <button
                            type="button"
                            class="btn-back"
                            onclick="showStep(2)"
                        >
                            ← Atrás
                        </button>

                        <button
                            type="submit"
                            class="btn-confirm"
                        >
                            Confirmar cita
                        </button>

                    </div>

                </div>

            </form>

        </section>

    </main>

</div>


<script>

    function showWarning(message) {

        const warning = document.getElementById('warning');

        warning.textContent = message;
        warning.style.display = 'block';

        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

    }


    function hideWarning() {

        document.getElementById('warning').style.display = 'none';

    }


    function showStep(step) {

        hideWarning();

        document.getElementById('step1').classList.remove('active');
        document.getElementById('step2').classList.remove('active');
        document.getElementById('step3').classList.remove('active');

        document.getElementById('indicator1').className = 'step-indicator';
        document.getElementById('indicator2').className = 'step-indicator';
        document.getElementById('indicator3').className = 'step-indicator';


        if (step === 1) {

            document.getElementById('step1').classList.add('active');

            document.getElementById('indicator1').classList.add('active');

        }


        if (step === 2) {

            document.getElementById('step2').classList.add('active');

            document.getElementById('indicator1').classList.add('completed');
            document.getElementById('indicator2').classList.add('active');

        }


        if (step === 3) {

            document.getElementById('step3').classList.add('active');

            document.getElementById('indicator1').classList.add('completed');
            document.getElementById('indicator2').classList.add('completed');
            document.getElementById('indicator3').classList.add('active');

        }

    }


    function goStep2() {

        const vehicle = document.getElementById('vehicle_id').value;

        const service = document.querySelector(
            'input[name="service_type"]:checked'
        );


        if (!vehicle) {

            showWarning('Selecciona un vehículo para continuar.');

            return;

        }


        if (!service) {

            showWarning('Selecciona un tipo de servicio para continuar.');

            return;

        }


        showStep(2);

    }


    function goStep3() {

        const date = document.getElementById('appointment_date').value;

        const time = document.querySelector(
            'input[name="appointment_time"]:checked'
        );


        if (!date) {

            showWarning('Selecciona una fecha para continuar.');

            return;

        }


        if (!time) {

            showWarning('Selecciona un horario para continuar.');

            return;

        }


        fillConfirmation();

        showStep(3);

    }


    function fillConfirmation() {

        const vehicleSelect =
            document.getElementById('vehicle_id');

        const vehicleOption =
            vehicleSelect.options[vehicleSelect.selectedIndex];

        const service =
            document.querySelector(
                'input[name="service_type"]:checked'
            );

        const date =
            document.getElementById('appointment_date').value;

        const time =
            document.querySelector(
                'input[name="appointment_time"]:checked'
            );


        let vehicleText =
            vehicleOption.dataset.brand + ' ' +
            vehicleOption.dataset.model + ' ' +
            vehicleOption.dataset.year + ' - ' +
            vehicleOption.dataset.plates;


        document.getElementById('confirmVehicle').textContent =
            vehicleText;

        document.getElementById('confirmService').textContent =
            service.value;

        document.getElementById('confirmDate').textContent =
            date;

        document.getElementById('confirmTime').textContent =
            time.value;

    }

</script>

</body>
</html>