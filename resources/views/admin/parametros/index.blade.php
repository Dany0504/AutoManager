<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parámetros - AutoManager</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #fff;
            color: #111;
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 220px;
            flex-shrink: 0;
            background: #050505;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .brand {
            padding: 22px 18px;
            border-bottom: 1px solid #252525;
            font-weight: bold;
        }

        .brand small {
            display: block;
            margin-top: 5px;
            color: #aaa;
            font-weight: normal;
        }

        .menu a {
            display: block;
            padding: 14px 18px;
            color: #ccc;
            text-decoration: none;
            font-size: 14px;
        }

        .menu a:hover { background: #191919; }

        .menu a.active {
            background: #292929;
            color: white;
            border-left: 4px solid #df1426;
            padding-left: 14px;
            font-weight: bold;
        }

        .sidebar-bottom {
            padding: 18px;
            border-top: 1px solid #252525;
            font-size: 13px;
        }

        .sidebar-bottom small { color: #999; }

        .sidebar-bottom button {
            margin-top: 15px;
            border: none;
            background: none;
            color: #bbb;
            cursor: pointer;
        }

        .main {
            flex: 1;
            min-width: 0;
        }

        .header {
            padding: 24px 30px;
            border-bottom: 1px solid #e5e5e5;
        }

        .header h1 {
            margin: 0 0 6px;
            font-size: 24px;
        }

        .header p {
            margin: 0;
            color: #777;
            font-size: 13px;
        }

        .content {
            max-width: 1100px;
            padding: 28px 30px 60px;
        }

        .section-heading {
            margin: 36px 0 18px;
            padding-bottom: 12px;
            border-bottom: 2px solid #111;
        }

        .section-heading:first-child { margin-top: 0; }

        .section-heading h2 {
            margin: 0 0 5px;
            font-size: 21px;
        }

        .section-heading p {
            margin: 0;
            color: #777;
            font-size: 13px;
        }

        .panel {
            border: 1px solid #ddd;
            padding: 24px;
            margin-bottom: 20px;
        }

        .panel h3 {
            font-size: 16px;
            margin: 0 0 20px;
            padding-bottom: 14px;
            border-bottom: 1px solid #ddd;
        }

        .field { margin-bottom: 18px; }

        .field label,
        .field-label {
            display: block;
            margin-bottom: 8px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #888;
        }

        .field input,
        .field textarea {
            display: block;
            width: 100%;
            padding: 11px;
            border: 1px solid #555;
            background: #fff;
            font: inherit;
            font-size: 14px;
        }

        .field textarea {
            min-height: 70px;
            resize: none;
        }

        .two-columns {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 18px;
        }

        .btn {
            display: inline-block;
            padding: 12px 17px;
            background: white;
            border: 1px solid #111;
            color: #111;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-red {
            background: #dc1425;
            border-color: #dc1425;
            color: white;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 22px;
        }

        .success {
            padding: 14px;
            margin-bottom: 22px;
            background: #eaf7ed;
            border: 1px solid #9dcba8;
            color: #205b2d;
        }

        .errors {
            padding: 14px 18px;
            margin-bottom: 22px;
            background: #fff0f0;
            border: 1px solid #dc1425;
            color: #a40c1b;
        }

        .errors p { margin: 6px 0; }

        .days {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .day {
            cursor: pointer;
            position: relative;
        }

        .day input {
            position: absolute;
            opacity: 0;
            width: 1px;
            height: 1px;
        }

        .day span {
            display: flex;
            justify-content: center;
            align-items: center;
            min-width: 39px;
            height: 39px;
            border: 1px solid #ddd;
            color: #888;
            font-size: 13px;
            font-weight: bold;
        }

        .day input:checked + span {
            background: #050505;
            border-color: #050505;
            color: white;
        }

        .day input:focus-visible + span {
            outline: 2px solid #dc1425;
            outline-offset: 2px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            padding: 13px 10px;
            text-align: left;
            background: #fafafa;
            color: #888;
            font-size: 11px;
            text-transform: uppercase;
        }

        td {
            padding: 12px 10px;
            border-top: 1px solid #e8e8e8;
            font-size: 13px;
            overflow-wrap: anywhere;
        }

        .service-input {
            width: 90px;
            padding: 8px;
            border: 1px solid #555;
            font-size: 13px;
        }

        .blocked-controls {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 14px;
        }

        .blocked-controls input {
            padding: 10px;
            border: 1px solid #555;
        }

        .blocked-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .blocked-tag {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 9px;
            border: 1px solid #ddd;
            font-size: 12px;
        }

        .blocked-tag button {
            border: none;
            background: none;
            color: #d41425;
            cursor: pointer;
            font-weight: bold;
        }

        .comparison {
            display: none;
            border: 1px solid #ddd;
            margin-bottom: 26px;
        }

        .comparison.visible { display: block; }

        .comparison-header {
            padding: 16px;
            background: #050505;
            color: white;
            font-weight: bold;
        }

        .old-value {
            color: #888;
            text-decoration: line-through;
        }

        .new-value { color: #dc1425; }

        .note {
            color: #777;
            font-size: 12px;
            line-height: 1.5;
        }

        @media (max-width: 800px) {
            .layout { flex-direction: column; }
            .sidebar { width: 100%; }
            .content { padding: 18px; }
            .header { padding: 20px; }
            .two-columns { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div>
            <div class="brand">
                AutoManager
                <small>Administrador</small>
            </div>

            <nav class="menu">
                <a href="{{ url('/admin') }}">Dashboard</a>
                <a href="{{ route('usuarios.index') }}">Usuarios</a>
                <a href="{{ route('citas.index') }}">Citas</a>
                <a href="{{ route('vehiculos.index') }}">Vehículos</a>
                <a href="{{ route('ordenes.index') }}">Órdenes</a>
                <a href="{{ route('reportes.index') }}">Reportes</a>
                <a href="{{ route('parametros.index') }}" class="active">
                    Parámetros
                </a>
            </nav>
        </div>

        <div class="sidebar-bottom">
            <small>Sesión activa</small>
            <p>{{ auth()->user()->name }}</p>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Cerrar sesión</button>
            </form>
        </div>
    </aside>

    <main class="main">
        <header class="header">
            <h1>Parámetros generales</h1>
            <p>Configuración global del sistema y de las citas</p>
        </header>

        <div class="content">

            @if (session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="errors">
                    <strong>Revisa los siguientes campos:</strong>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- DATOS DEL TALLER -->

            <div class="section-heading">
                <h2>Datos del taller</h2>
                <p>Información general de AutoManager</p>
            </div>

            <form id="workshopForm"
                  method="POST"
                  action="{{ route('parametros.update') }}">
                @csrf
                @method('PUT')

                <section class="panel">
                    <h3>Información del taller</h3>

                    <div class="field">
                        <label for="name">Nombre del taller</label>
                        <input id="name" name="name" required
                               value="{{ old('name', $settings->name) }}">
                    </div>

                    <div class="field">
                        <label for="rfc">RFC</label>
                        <input id="rfc" name="rfc" maxlength="13"
                               value="{{ old('rfc', $settings->rfc) }}">
                    </div>

                    <div class="field">
                        <label for="phone">Teléfono principal</label>
                        <input id="phone" name="phone"
                               value="{{ old('phone', $settings->phone) }}">
                    </div>

                    <div class="field">
                        <label for="address">Dirección</label>
                        <textarea id="address" name="address">{{ old('address', $settings->address) }}</textarea>
                    </div>

                    <div class="field">
                        <label for="email">Correo de contacto</label>
                        <input id="email" name="email" type="email"
                               value="{{ old('email', $settings->email) }}">
                    </div>

                    <div class="field">
                        <label for="tax_percentage">IVA aplicable (%)</label>
                        <input id="tax_percentage" name="tax_percentage"
                               type="number" min="0" max="100" step="0.01"
                               required
                               value="{{ old('tax_percentage', $settings->tax_percentage) }}">
                    </div>
                </section>

                <div class="actions">
                    <button type="button" class="btn" id="compareButton">
                        Ver comparativo
                    </button>

                    <button type="submit" class="btn btn-red">
                        Guardar parámetros
                    </button>
                </div>
            </form>

            <section class="comparison" id="comparison">
                <div class="comparison-header" id="comparisonTitle">
                    Resumen de cambios
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Campo</th>
                                <th>Valor actual</th>
                                <th>Nuevo valor</th>
                            </tr>
                        </thead>
                        <tbody id="comparisonBody"></tbody>
                    </table>
                </div>
            </section>

            <!-- CONFIGURACIÓN DE CITAS -->

            <div id="configuracion-citas" class="section-heading">
                <h2>Configuración de citas</h2>
                <p>Horarios, duraciones y capacidad</p>
            </div>

            <form method="POST"
                  action="{{ route('parametros.citas.update') }}"
                  id="appointmentForm">
                @csrf
                @method('PUT')

                <section class="panel">
                    <h3>Horario de atención</h3>

                    <div class="two-columns">
                        <div class="field">
                            <label for="opening_time">Hora de apertura</label>
                            <input id="opening_time" name="opening_time"
                                   type="time" required
                                   value="{{ substr($appointmentSettings->opening_time, 0, 5) }}">
                        </div>

                        <div class="field">
                            <label for="closing_time">Hora de cierre</label>
                            <input id="closing_time" name="closing_time"
                                   type="time" required
                                   value="{{ substr($appointmentSettings->closing_time, 0, 5) }}">
                        </div>

                        <div class="field">
                            <label for="slot_duration">
                                Duración de slot (min)
                            </label>
                            <input id="slot_duration" name="slot_duration"
                                   type="number" min="5" max="480" required
                                   value="{{ $appointmentSettings->slot_duration }}">
                        </div>

                        <div class="field">
                            <label for="break_start">Descanso (inicio)</label>
                            <input id="break_start" name="break_start"
                                   type="time"
                                   value="{{ substr($appointmentSettings->break_start ?? '', 0, 5) }}">
                        </div>
                    </div>

                    <div class="field">
                        <span class="field-label">Días laborales</span>

                        <div class="days">
                            @foreach ([
                                1 => 'L',
                                2 => 'Ma',
                                3 => 'Mi',
                                4 => 'J',
                                5 => 'V',
                                6 => 'S',
                                0 => 'D'
                            ] as $dayNumber => $dayName)
                                <label class="day">
                                    <input type="checkbox"
                                           name="working_days[]"
                                           value="{{ $dayNumber }}"
                                           @checked(in_array(
                                               $dayNumber,
                                               $appointmentSettings->working_days ?? []
                                           ))>
                                    <span>{{ $dayName }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </section>

                <section class="panel">
                    <h3>Duración y capacidad por servicio</h3>

                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Servicio</th>
                                    <th>Duración (min)</th>
                                    <th>Cap. simultánea</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($appointmentSettings->services ?? [] as $i => $service)
                                    <tr>
                                        <td>
                                            {{ $service['name'] }}
                                            <input type="hidden"
                                                   name="services[{{ $i }}][name]"
                                                   value="{{ $service['name'] }}">
                                        </td>

                                        <td>
                                            <input class="service-input"
                                                   type="number"
                                                   min="5"
                                                   max="1440"
                                                   required
                                                   name="services[{{ $i }}][duration]"
                                                   value="{{ $service['duration'] }}">
                                        </td>

                                        <td>
                                            <input class="service-input"
                                                   type="number"
                                                   min="1"
                                                   max="100"
                                                   required
                                                   name="services[{{ $i }}][capacity]"
                                                   value="{{ $service['capacity'] }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="panel">
                    <h3>Bloqueo de fechas</h3>

                    <div class="blocked-controls">
                        <input type="date" id="newBlockedDate">

                        <button type="button"
                                class="btn btn-red"
                                id="addBlockedDate">
                            Bloquear fecha
                        </button>
                    </div>

                    <div id="blockedDateInputs"></div>
                    <div id="blockedDateList" class="blocked-list"></div>

                    <p class="note">
                        Las fechas bloqueadas se guardarán al presionar
                        Guardar configuración.
                    </p>
                </section>

                <div class="actions">
                    <button type="submit" class="btn btn-red">
                        Guardar configuración
                    </button>
                </div>
            </form>

            <p class="note">
                Esta sección almacena las reglas administrativas.
                Para aplicarlas automáticamente al reservar citas,
                el módulo de registro de citas también deberá consultarlas.
            </p>

        </div>
    </main>
</div>

<script>
    // Comparativo de datos del taller.
    const originalValues = {{ Illuminate\Support\Js::from([
        'name' => $settings->name,
        'rfc' => $settings->rfc,
        'phone' => $settings->phone,
        'address' => $settings->address,
        'email' => $settings->email,
        'tax_percentage' => (string) $settings->tax_percentage,
    ]) }};

    const fieldLabels = {
        name: 'Nombre del taller',
        rfc: 'RFC',
        phone: 'Teléfono principal',
        address: 'Dirección',
        email: 'Correo de contacto',
        tax_percentage: 'IVA aplicable (%)'
    };

    const compareButton = document.getElementById('compareButton');
    const comparison = document.getElementById('comparison');
    const comparisonBody = document.getElementById('comparisonBody');
    const comparisonTitle = document.getElementById('comparisonTitle');

    function createCell(row, value, className = '') {
        const cell = document.createElement('td');
        cell.textContent = value === '' ? '—' : value;
        cell.className = className;
        row.appendChild(cell);
    }

    function updateComparison() {
        comparisonBody.replaceChildren();
        let count = 0;

        Object.entries(fieldLabels).forEach(([key, label]) => {
            const previous = String(originalValues[key] ?? '').trim();
            const current = document.getElementById(key).value.trim();

            if (previous !== current) {
                const row = document.createElement('tr');

                createCell(row, label);
                createCell(row, previous, 'old-value');
                createCell(row, current, 'new-value');

                comparisonBody.appendChild(row);
                count++;
            }
        });

        comparisonTitle.textContent =
            `Resumen de cambios (${count} modificaciones)`;

        if (count === 0) {
            const row = document.createElement('tr');
            const cell = document.createElement('td');
            cell.colSpan = 3;
            cell.textContent = 'No hay cambios pendientes.';
            row.appendChild(cell);
            comparisonBody.appendChild(row);
        }
    }

    compareButton.addEventListener('click', () => {
        comparison.classList.toggle('visible');

        compareButton.textContent =
            comparison.classList.contains('visible')
                ? 'Ocultar comparativo'
                : 'Ver comparativo';

        if (comparison.classList.contains('visible')) {
            updateComparison();
        }
    });

    document.getElementById('workshopForm')
        .addEventListener('input', () => {
            if (comparison.classList.contains('visible')) {
                updateComparison();
            }
        });

    // Fechas bloqueadas.
    const savedBlockedDates = {{ Illuminate\Support\Js::from(
        $appointmentSettings->blocked_dates ?? []
    ) }};

    let blockedDates = [...new Set(savedBlockedDates)];

    const blockedDateList = document.getElementById('blockedDateList');
    const blockedDateInputs = document.getElementById('blockedDateInputs');
    const newBlockedDate = document.getElementById('newBlockedDate');

    function renderBlockedDates() {
        blockedDateList.replaceChildren();
        blockedDateInputs.replaceChildren();

        blockedDates.sort();

        blockedDates.forEach(date => {
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'blocked_dates[]';
            hidden.value = date;
            blockedDateInputs.appendChild(hidden);

            const tag = document.createElement('span');
            tag.className = 'blocked-tag';

            const label = document.createElement('span');
            label.textContent = date;

            const remove = document.createElement('button');
            remove.type = 'button';
            remove.textContent = '×';
            remove.setAttribute('aria-label', 'Quitar fecha ' + date);

            remove.addEventListener('click', () => {
                blockedDates = blockedDates.filter(item => item !== date);
                renderBlockedDates();
            });

            tag.appendChild(label);
            tag.appendChild(remove);
            blockedDateList.appendChild(tag);
        });

        if (blockedDates.length === 0) {
            const message = document.createElement('span');
            message.className = 'note';
            message.textContent = 'No hay fechas bloqueadas.';
            blockedDateList.appendChild(message);
        }
    }

    document.getElementById('addBlockedDate')
        .addEventListener('click', () => {
            const date = newBlockedDate.value;

            if (!date) {
                alert('Selecciona una fecha.');
                return;
            }

            if (!blockedDates.includes(date)) {
                blockedDates.push(date);
            }

            newBlockedDate.value = '';
            renderBlockedDates();
        });

    renderBlockedDates();
</script>


@include('partials.campos-obligatorios')
</body>
</html>
