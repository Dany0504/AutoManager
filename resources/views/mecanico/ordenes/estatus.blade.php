
@extends('mecanico.layouts.app')

@section('title', 'Cambio de estatus | AutoManager')

@section('content')

<header class="mechanic-header">
    <h1>Cambio de estatus</h1>
    <p>Consulta el avance de las órdenes y registra las notas del técnico.</p>
</header>

<div class="mechanic-content">
    <div class="mechanic-status-container">

        {{-- MENSAJES --}}

        @if(session('success'))
            <div class="mechanic-success-message">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mechanic-error-message">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mechanic-error-message">
                <strong>Revisa lo siguiente:</strong>

                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- SELECCIONAR ORDEN --}}

        <section class="mechanic-status-card">
            <h2>Seleccionar orden</h2>

            <form
                method="GET"
                action="{{ route('mecanico.ordenes.estatus') }}"
            >
                <div class="mechanic-status-field">
                    <label for="cita">
                        Órdenes con ingreso registrado
                    </label>

                    <select
                        name="cita"
                        id="cita"
                        onchange="this.form.submit()"
                    >
                        @if($appointments->isEmpty())
                            <option value="">
                                No hay órdenes disponibles
                            </option>
                        @endif

                        @foreach($appointments as $appointment)
                            <option
                                value="{{ $appointment->id }}"
                                @selected($cita && $cita->id === $appointment->id)
                            >
                                {{ $appointment->folio ?? 'Cita #' . $appointment->id }}
                                —
                                {{ $appointment->vehicle?->brand ?? 'Vehículo' }}
                                {{ $appointment->vehicle?->model ?? '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </section>

        @if(!$cita)

            {{-- SIN ÓRDENES --}}

            <section class="mechanic-status-card mechanic-status-empty">
                <h2>No hay órdenes disponibles</h2>

                <p>
                    Primero registra el ingreso de un vehículo asignado.
                </p>

                <a
                    href="{{ route('mecanico.ordenes.create') }}"
                    class="mechanic-btn mechanic-btn-red"
                >
                    Ir a ingreso del vehículo
                </a>
            </section>

        @else

            @php
                $steps = [
                    [
                        'status' => 'pendiente',
                        'title' => 'Recepción',
                        'description' => 'Vehículo recibido y orden creada',
                    ],
                    [
                        'status' => 'diagnostico',
                        'title' => 'Diagnóstico',
                        'description' => 'Revisión y diagnóstico del vehículo',
                    ],
                    [
                        'status' => 'esperando_aprobacion',
                        'title' => 'Autorización',
                        'description' => 'Presupuesto enviado al cliente',
                    ],
                    [
                        'status' => 'en_proceso',
                        'title' => 'En proceso',
                        'description' => 'Trabajo de reparación en curso',
                    ],
                    [
                        'status' => 'control_calidad',
                        'title' => 'Control de calidad',
                        'description' => 'Pruebas y revisión final',
                    ],
                    [
                        'status' => 'listo',
                        'title' => 'Listo para entrega',
                        'description' => 'Vehículo disponible',
                    ],
                    [
                        'status' => 'entregado',
                        'title' => 'Entregado',
                        'description' => 'Vehículo entregado al cliente',
                    ],
                ];

                $statusOrder = array_column($steps, 'status');

                $currentIndex = array_search(
                    $cita->status,
                    $statusOrder,
                    true
                );

                $currentIndex = $currentIndex === false
                    ? -1
                    : $currentIndex;

                $authorized = in_array(
                    $cita->authorization_status,
                    ['autorizado', 'aprobado'],
                    true
                ) && $cita->authorized_at !== null;

                $nextStatuses = [
                    'esperando_aprobacion' => [
                        'status' => 'en_proceso',
                        'label' => 'En proceso',
                    ],
                    'en_proceso' => [
                        'status' => 'control_calidad',
                        'label' => 'Control de calidad',
                    ],
                    'control_calidad' => [
                        'status' => 'listo',
                        'label' => 'Listo para entrega',
                    ],
                ];

                $next = $nextStatuses[$cita->status] ?? null;

                $canAdvance = $next !== null
                    && (
                        $cita->status !== 'esperando_aprobacion'
                        || $authorized
                    );
            @endphp

            {{-- INFORMACIÓN DE LA ORDEN --}}

            <section class="mechanic-status-card">

                <div class="mechanic-status-order-head">

                    <div>
                        <div class="mechanic-status-order-folio">
                            {{ $cita->folio ?? 'Cita #' . $cita->id }}
                        </div>

                        <div class="mechanic-status-order-description">
                            {{ $cita->client?->user?->name ?? 'Sin cliente' }}
                            ·
                            {{ $cita->vehicle?->brand ?? '' }}
                            {{ $cita->vehicle?->model ?? '' }}
                            {{ $cita->vehicle?->year ?? '' }}
                        </div>
                    </div>

                    <span class="mechanic-status-badge">
                        {{ ucfirst(str_replace('_', ' ', $cita->status)) }}
                    </span>

                </div>

            </section>

            {{-- ETAPAS DE LA ORDEN --}}

            <section class="mechanic-status-card">
                <h2>Etapa actual y avance</h2>

                <div class="mechanic-status-timeline">

                    @foreach($steps as $index => $step)

                        @php
                            $isDone = $index < $currentIndex;
                            $isCurrent = $index === $currentIndex;
                        @endphp

                        <div
                            class="mechanic-status-step
                                {{ $isDone ? 'done' : '' }}
                                {{ $isCurrent ? 'current' : '' }}"
                        >

                            <div class="mechanic-status-step-marker">
                                @if($isDone)
                                    ✓
                                @elseif($isCurrent)
                                    ●
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </div>

                            <div>
                                <div class="mechanic-status-step-title">
                                    {{ $step['title'] }}
                                </div>

                                <div class="mechanic-status-step-description">
                                    {{ $step['description'] }}
                                </div>
                            </div>

                        </div>

                    @endforeach

                </div>
            </section>

            {{-- ADVERTENCIA DE AUTORIZACIÓN --}}

            @if(
                $cita->status === 'esperando_aprobacion'
                && !$authorized
            )
                <div class="mechanic-status-warning">
                    El presupuesto todavía no cuenta con una autorización
                    completa del cliente. No es posible iniciar la reparación.
                </div>
            @endif

            {{-- NOTA DEL TÉCNICO --}}

            <section class="mechanic-status-card">
                <h2>Nota del técnico</h2>

                <form
                    method="POST"
                    action="{{ route('mecanico.ordenes.estatus.update', $cita) }}"
                >
                    @csrf
                    @method('PATCH')

                    <div class="mechanic-status-field">

                        <label for="note">
                            Observaciones (opcional al avanzar)
                        </label>

                        <textarea
                            name="note"
                            id="note"
                            maxlength="3000"
                            placeholder="Describe los trabajos realizados, observaciones o resultados de la revisión..."
                        >{{ old('note') }}</textarea>

                    </div>

                    <div class="mechanic-status-actions">

                        @if($canAdvance)
                            <button
                                type="submit"
                                name="action"
                                value="advance"
                                class="mechanic-btn mechanic-btn-red"
                                onclick="return confirm('¿Confirmas que deseas avanzar esta orden a la siguiente etapa?')"
                            >
                                Avanzar a {{ $next['label'] }} →
                            </button>
                        @endif
                        @if($cita->status === 'listo')
                            <button
                                type="submit"
                                name="action"
                                value="deliver"
                                class="mechanic-btn mechanic-btn-red"
                                onclick="return confirm('¿Confirmas que el vehículo ya fue entregado al cliente?')"
                            >
                                Confirmar entrega ✓
                            </button>
                        @endif
                        <button
                            type="submit"
                            name="action"
                            value="note"
                            class="mechanic-btn mechanic-btn-dark"
                        >
                            Guardar nota
                        </button>

                    </div>

                </form>
            </section>

            {{-- HISTORIAL DE MOVIMIENTOS --}}

            <section class="mechanic-status-card">
                <h2>Historial de movimientos</h2>

                @forelse($logs as $log)

                    <div class="mechanic-status-log">

                        <div class="mechanic-status-log-title">

                            @if($log->previous_status === $log->new_status)
                                Nota registrada
                            @else
                                {{ ucfirst(str_replace('_', ' ', $log->previous_status)) }}
                                →
                                {{ ucfirst(str_replace('_', ' ', $log->new_status)) }}
                            @endif

                        </div>

                        <div class="mechanic-status-log-meta">
                            {{ $log->mechanic?->name ?? 'Mecánico' }}
                            ·
                            {{ $log->created_at?->format('d/m/Y H:i') }}
                        </div>

                        @if($log->note)
                            <div class="mechanic-status-log-note">
                                {{ $log->note }}
                            </div>
                        @endif

                    </div>

                @empty

                    <p class="mechanic-status-hint">
                        Todavía no hay movimientos registrados en este historial.
                    </p>

                @endforelse

            </section>

        @endif

    </div>
</div>

@endsection
