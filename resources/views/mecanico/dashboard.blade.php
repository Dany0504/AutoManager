@extends('mecanico.layouts.app')

@section('title', 'Mis citas | AutoManager')

@section('content')

    <header class="mechanic-header">
        <h1>Panel del mecánico</h1>

        <p>
            Consulta y administra los vehículos asignados a tu taller.
        </p>
    </header>

    <div class="mechanic-content">

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

        {{-- ESTADÍSTICAS --}}

        <div class="mechanic-dashboard-stats">

            <div class="mechanic-dashboard-stat-card">
                <span>Citas asignadas</span>
                <strong>{{ $totalCitas }}</strong>
            </div>

            <div class="mechanic-dashboard-stat-card">
                <span>Pendientes</span>
                <strong>{{ $pendientes }}</strong>
            </div>

            <div class="mechanic-dashboard-stat-card">
                <span>En proceso</span>
                <strong>{{ $enProceso }}</strong>
            </div>

            <div class="mechanic-dashboard-stat-card">
                <span>Listos para entrega</span>
                <strong>{{ $listas }}</strong>
            </div>

        </div>

        {{-- VEHÍCULOS ASIGNADOS --}}

        <section class="mechanic-dashboard-section">

            <div class="mechanic-dashboard-section-header">

                <h2>Vehículos asignados</h2>

                <p>
                    Aquí aparecerán las citas que el administrador
                    te haya asignado.
                </p>

            </div>

            <div class="mechanic-dashboard-table-wrapper">

                @if($appointments->count())

                    <table class="mechanic-dashboard-table">

                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Cliente</th>
                                <th>Vehículo</th>
                                <th>Servicio</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($appointments as $appointment)

                                <tr>

                                    <td>
                                        <span class="mechanic-dashboard-folio">
                                            {{ $appointment->folio ?? 'Cita #' . $appointment->id }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $appointment->client?->user?->name
                                            ?? $appointment->client?->name
                                            ?? 'Sin cliente' }}
                                    </td>

                                    <td>
                                        {{ $appointment->vehicle?->brand ?? 'Sin marca' }}

                                        {{ $appointment->vehicle?->model ?? '' }}

                                        @if($appointment->vehicle?->year)
                                            ({{ $appointment->vehicle->year }})
                                        @endif
                                    </td>

                                    <td>
                                        {{ $appointment->service_type }}
                                    </td>

                                    <td>
                                        {{ $appointment->appointment_date
                                            ? \Illuminate\Support\Carbon::parse($appointment->appointment_date)->format('d/m/Y')
                                            : 'Sin fecha' }}
                                    </td>

                                    <td>
                                        {{ $appointment->appointment_time
                                            ? substr($appointment->appointment_time, 0, 5)
                                            : 'Sin hora' }}
                                    </td>

                                    <td>
                                        @switch($appointment->status)

                                            @case('pendiente')
                                                Pendiente
                                                @break

                                            @case('diagnostico')
                                                Diagnóstico
                                                @break

                                            @case('esperando_aprobacion')
                                                Esperando autorización
                                                @break

                                            @case('en_proceso')
                                                En proceso
                                                @break

                                            @case('control_calidad')
                                                Control de calidad
                                                @break

                                            @case('listo')
                                                Listo para entrega
                                                @break

                                            @case('rechazado')
                                                Rechazado
                                                @break

                                            @case('completado')
                                                Completado
                                                @break

                                            @default
                                                {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}

                                        @endswitch
                                    </td>

                                    <td>
                                        @php
                                            $ingresoRegistrado = !is_null($appointment->intake_registered_at);

                                            $estatusAvanzado = in_array($appointment->status, [
                                                'esperando_aprobacion',
                                                'en_proceso',
                                                'control_calidad',
                                                'listo',
                                            ], true);
                                        @endphp

                                        @if(!$ingresoRegistrado)

                                            {{-- Todavía no se registra el ingreso --}}
                                            <a
                                                href="{{ route('mecanico.ordenes.create', ['cita' => $appointment->id]) }}"
                                                class="mechanic-action-link"
                                            >
                                                Registrar ingreso
                                            </a>

                                        @elseif($estatusAvanzado)

                                            {{-- La orden ya está en una etapa posterior --}}
                                            <a
                                                href="{{ route('mecanico.ordenes.estatus', ['cita' => $appointment->id]) }}"
                                                class="mechanic-action-link"
                                            >
                                                Ver estatus
                                            </a>

                                        @else

                                            {{-- Ingreso registrado, pendiente de diagnóstico --}}
                                            <a
                                                href="{{ route('mecanico.ordenes.detalle', ['cita' => $appointment->id]) }}"
                                                class="mechanic-action-link"
                                            >
                                                Ver detalle
                                            </a>

                                        @endif
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else

                    <div class="mechanic-dashboard-empty">

                        <strong>
                            No tienes vehículos asignados
                        </strong>

                        <p>
                            Cuando el administrador te asigne una cita,
                            aparecerá aquí.
                        </p>

                    </div>

                @endif

            </div>

        </section>

    </div>

@endsection