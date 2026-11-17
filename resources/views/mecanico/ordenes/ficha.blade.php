@extends('mecanico.layouts.app')

@section('title', ($cita->folio ?? 'Orden #' . $cita->id) . ' | AutoManager')

@section('content')

@php
    $vehiculo = trim(implode(' ', array_filter([
        $cita->vehicle?->brand,
        $cita->vehicle?->model,
        $cita->vehicle?->year,
    ])));

    $partials = [
        1 => 'mecanico.ordenes.pasos.ingreso',
        2 => 'mecanico.ordenes.pasos.presupuesto',
        3 => 'mecanico.ordenes.pasos.reparacion',
        4 => 'mecanico.ordenes.pasos.entrega',
    ];

    $closed = in_array($cita->status, \App\Models\Appointment::FINISHED_STATUSES, true);
@endphp

<header class="mechanic-header mechanic-order-header">
    <a href="{{ route('mecanico.dashboard') }}" class="mechanic-order-back">← Mis órdenes</a>

    <div class="mechanic-order-title">
        <div>
            <h1>{{ $cita->folio ?? 'Orden #' . $cita->id }}</h1>
            <p>{{ $vehiculo ?: 'Vehículo' }} · {{ $cita->client?->user?->name ?? $cita->client?->name ?? 'Sin cliente' }}</p>
        </div>

        <span class="mechanic-status-badge">{{ $cita->status_label }}</span>
    </div>

    <dl class="mechanic-order-facts">
        <div>
            <dt>Servicio</dt>
            <dd>{{ $cita->service_type ?: '—' }}</dd>
        </div>
        <div>
            <dt>Cita</dt>
            <dd>
                {{ $cita->appointment_date?->format('d/m/Y') ?? '—' }}
                @if($cita->appointment_time)
                    · {{ substr($cita->appointment_time, 0, 5) }}
                @endif
            </dd>
        </div>
        <div>
            <dt>Placas</dt>
            <dd>{{ $cita->vehicle?->plates ?: '—' }}</dd>
        </div>
        <div>
            <dt>Teléfono</dt>
            <dd>
                @php $telefono = $cita->client?->phone ?? $cita->client?->user?->phone; @endphp
                @if($telefono)
                    <a href="tel:{{ preg_replace('/\D+/', '', $telefono) }}">{{ $telefono }}</a>
                @else
                    —
                @endif
            </dd>
        </div>
    </dl>
</header>

<div class="mechanic-content">
    <div class="mechanic-order">

        {{-- MENSAJES --}}

        @if(session('success'))
            <div class="mechanic-success-message">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="mechanic-error-message">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="mechanic-error-message">
                <strong>Revisa los siguientes datos:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- PASOS --}}

        <nav class="mechanic-order-steps" aria-label="Pasos de la orden">
            @foreach($steps as $number => $info)
                @php
                    $done = $number < $currentStep || ($number === 4 && $closed);
                    $isCurrent = $number === $currentStep && !$done;
                    $reachable = $number <= $currentStep;
                    $classes = trim(
                        ($done ? 'done ' : '')
                        . ($isCurrent ? 'current ' : '')
                        . ($number === $step ? 'selected ' : '')
                        . (!$reachable ? 'locked' : '')
                    );
                @endphp

                @if($reachable)
                    <a
                        href="{{ route('mecanico.ordenes.ficha', ['cita' => $cita, 'paso' => $number]) }}"
                        class="{{ $classes }}"
                        @if($number === $step) aria-current="step" @endif
                    >
                @else
                    <span class="{{ $classes }}" aria-disabled="true">
                @endif
                        <span class="mechanic-order-step-marker">{{ $done ? '✓' : $number }}</span>
                        <span class="mechanic-order-step-text">
                            <strong>{{ $info['title'] }}</strong>
                            <small>{{ $info['description'] }}</small>
                        </span>
                @if($reachable)
                    </a>
                @else
                    </span>
                @endif
            @endforeach
        </nav>

        @if($step < $currentStep)
            <div class="mechanic-order-viewing">
                Estás viendo un paso anterior.
                <a href="{{ route('mecanico.ordenes.ficha', $cita) }}">
                    Ir al paso actual: {{ $steps[$currentStep]['title'] }} →
                </a>
            </div>
        @endif

        {{-- CONTENIDO DEL PASO --}}

        @include($partials[$step])

        {{-- HISTORIAL Y NOTAS --}}

        @if($cita->intake_registered_at !== null)
            <section class="mechanic-status-card mechanic-order-history">
                <h2>Historial de la orden</h2>

                @unless($closed)
                    <form method="POST" action="{{ route('mecanico.ordenes.estatus.update', $cita) }}" class="mechanic-order-note">
                        @csrf
                        @method('PATCH')

                        <div class="mechanic-status-field">
                            <label for="note_bitacora">Agregar nota</label>
                            <textarea
                                name="note"
                                id="note_bitacora"
                                maxlength="3000"
                                rows="2"
                                placeholder="Observaciones, avances o pendientes de esta orden…"
                                required
                            >{{ old('action') === 'note' ? old('note') : '' }}</textarea>
                        </div>

                        <button type="submit" name="action" value="note" class="mechanic-btn mechanic-btn-dark">
                            Guardar nota
                        </button>
                    </form>
                @endunless

                @forelse($logs as $log)
                    <div class="mechanic-status-log">
                        <div class="mechanic-status-log-title">
                            @if($log->previous_status === $log->new_status)
                                Nota registrada
                            @else
                                {{ \App\Models\Appointment::statusLabel($log->previous_status) }}
                                →
                                {{ \App\Models\Appointment::statusLabel($log->new_status) }}
                            @endif
                        </div>

                        <div class="mechanic-status-log-meta">
                            {{ $log->mechanic?->name ?? 'Usuario eliminado' }}
                            @if($log->mechanic?->rol === 'cliente')
                                (cliente)
                            @endif
                            · {{ $log->created_at?->format('d/m/Y H:i') }}
                        </div>

                        @if($log->note)
                            <div class="mechanic-status-log-note">{{ $log->note }}</div>
                        @endif
                    </div>
                @empty
                    <p class="mechanic-status-hint">Todavía no hay movimientos registrados.</p>
                @endforelse
            </section>
        @endif

    </div>
</div>

@endsection
