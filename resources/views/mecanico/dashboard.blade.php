@extends('mecanico.layouts.app')

@section('title', 'Mis órdenes | AutoManager')

@section('content')

    <header class="mechanic-header">
        <h1>Mis órdenes</h1>

        <p>
            Abre una orden para continuar su trabajo: ingreso, diagnóstico, reparación y entrega.
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

                <nav class="mechanic-dashboard-filters" aria-label="Filtrar citas">
                    @foreach([
                        'activas' => 'Activas',
                        'hoy' => 'Hoy',
                        'todas' => 'Todas',
                    ] as $clave => $texto)
                        <a
                            href="{{ route('mecanico.dashboard', ['filtro' => $clave]) }}"
                            class="{{ $filtro === $clave ? 'active' : '' }}"
                        >
                            {{ $texto }}
                            <span>{{ $conteoFiltros[$clave] }}</span>
                        </a>
                    @endforeach
                </nav>

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
                                        {{ $appointment->status_label }}
                                    </td>

                                    <td>
                                        @php
                                            $accion = \App\Http\Controllers\MechanicOrderController::nextActionLabel($appointment);
                                        @endphp

                                        <a
                                            href="{{ route('mecanico.ordenes.ficha', $appointment) }}"
                                            class="mechanic-action-link {{ $accion === 'Esperando cliente' || $accion === 'Ver orden' ? 'secondary' : '' }}"
                                        >
                                            {{ $accion }}
                                        </a>
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else

                    <div class="mechanic-dashboard-empty">

                        <strong>
                            @if($filtro === 'hoy')
                                No tienes citas activas para hoy
                            @elseif($filtro === 'activas' && $conteoFiltros['todas'] > 0)
                                No tienes órdenes activas
                            @else
                                No tienes vehículos asignados
                            @endif
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