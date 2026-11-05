
@extends('mecanico.layouts.app')

@section('title', 'Ingreso de órdenes | AutoManager')

@section('content')

<header class="mechanic-header">
    <h1>Ingreso de órdenes</h1>
    <p>Recepción y registro de vehículos asignados al taller.</p>
</header>

<div class="mechanic-content">

    <div class="mechanic-intake-container">

        {{-- MENSAJES --}}

        @if (session('success'))
            <div class="mechanic-success-message">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mechanic-error-message">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mechanic-error-message">
                <strong>Corrige estos errores:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- SELECCIONAR CITA --}}

        <section class="mechanic-intake-card">

            <h3>Seleccionar cita asignada</h3>

            <form
                method="GET"
                action="{{ route('mecanico.ordenes.create') }}"
            >

                <div class="mechanic-intake-field">

                    <label for="cita">Cita</label>

                    <select name="cita" id="cita" required>

                        <option value="">
                            Selecciona una cita
                        </option>

                        @foreach ($appointments as $item)

                            <option
                                value="{{ $item->id }}"
                                @selected(
                                    (int) ($selectedAppointment?->id ?? 0)
                                    === (int) $item->id
                                )
                            >
                                {{ $item->folio }}
                                |
                                {{ $item->appointment_date?->format('d/m/Y') }}
                                |
                                {{ $item->service_type }}
                            </option>

                        @endforeach

                    </select>

                </div>

                <button
                    type="submit"
                    class="mechanic-btn mechanic-btn-red"
                >
                    Cargar cita
                </button>

            </form>

            @if ($appointments->isEmpty())

                <p class="mechanic-intake-hint">
                    No tienes citas asignadas disponibles.
                    El administrador debe asignarte una.
                </p>

            @endif

        </section>

        {{-- DATOS DE LA CITA SELECCIONADA --}}

        @if ($selectedAppointment)

            @php

                $cliente = data_get(
                    $selectedAppointment,
                    'client.user.name'
                )
                ?? data_get(
                    $selectedAppointment,
                    'client.name'
                )
                ?? 'Cliente sin nombre';

                $marca = data_get(
                    $selectedAppointment,
                    'vehicle.brand'
                )
                ?? data_get(
                    $selectedAppointment,
                    'vehicle.marca'
                )
                ?? '';

                $modelo = data_get(
                    $selectedAppointment,
                    'vehicle.model'
                )
                ?? data_get(
                    $selectedAppointment,
                    'vehicle.modelo'
                )
                ?? '';

                $anio = data_get(
                    $selectedAppointment,
                    'vehicle.year'
                )
                ?? data_get(
                    $selectedAppointment,
                    'vehicle.anio'
                )
                ?? '';

                $vehiculo = trim("$marca $modelo $anio");

                $registrado =
                    $selectedAppointment->intake_registered_at !== null;

            @endphp

            {{-- INFORMACIÓN DE LA CITA --}}

            <div class="mechanic-intake-info">

                <div>
                    <strong>Folio:</strong>
                    {{ $selectedAppointment->folio }}
                </div>

                <div>
                    <strong>Fecha:</strong>
                    {{ $selectedAppointment->appointment_date?->format('d/m/Y') }}
                </div>

                <div>
                    <strong>Servicio:</strong>
                    {{ $selectedAppointment->service_type }}
                </div>

            </div>

            @if ($registrado)

                <div class="mechanic-success-message">
                    El ingreso de este vehículo ya está registrado.
                </div>

            @else

                {{-- FORMULARIO DE INGRESO --}}

                <form
                    method="POST"
                    action="{{ route('mecanico.ordenes.store') }}"
                    enctype="multipart/form-data"
                >

                    @csrf

                    <input
                        type="hidden"
                        name="appointment_id"
                        value="{{ $selectedAppointment->id }}"
                    >

                    {{-- CLIENTE Y VEHÍCULO --}}

                    <section class="mechanic-intake-card">

                        <h3>Datos del cliente y vehículo</h3>

                        <div class="mechanic-intake-grid">

                            <div class="mechanic-intake-field">

                                <label for="intake_client">
                                    Cliente
                                </label>

                                <input
                                    type="text"
                                    id="intake_client"
                                    value="{{ $cliente }}"
                                    readonly
                                >

                            </div>

                            <div class="mechanic-intake-field">

                                <label for="intake_vehicle">
                                    Vehículo
                                </label>

                                <input
                                    type="text"
                                    id="intake_vehicle"
                                    value="{{ $vehiculo ?: 'Vehículo registrado' }}"
                                    readonly
                                >

                            </div>

                            <div class="mechanic-intake-field">

                                <label for="intake_mileage">
                                    Kilometraje
                                </label>

                                <input
                                    type="number"
                                    name="intake_mileage"
                                    id="intake_mileage"
                                    placeholder="Ej. 48250"
                                    min="0"
                                    max="9999999"
                                    value="{{ old('intake_mileage') }}"
                                    required
                                >

                            </div>

                            <div class="mechanic-intake-field">

                                <label for="intake_fuel_level">
                                    Nivel de combustible
                                </label>

                                <select
                                    name="intake_fuel_level"
                                    id="intake_fuel_level"
                                    required
                                >

                                    <option value="">
                                        Selecciona
                                    </option>

                                    @foreach ([
                                        'Vacio' => 'Vacío',
                                        '1/4' => '1/4',
                                        '1/2' => '1/2',
                                        '3/4' => '3/4',
                                        'Lleno' => 'Lleno'
                                    ] as $valor => $texto)

                                        <option
                                            value="{{ $valor }}"
                                            @selected(
                                                old('intake_fuel_level') === $valor
                                            )
                                        >
                                            {{ $texto }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </section>

                    {{-- MOTIVO DE INGRESO --}}

                    <section class="mechanic-intake-card">

                        <h3>Motivo de ingreso</h3>

                        <div class="mechanic-intake-field">

                            <label for="intake_customer_description">
                                Descripción del cliente
                            </label>

                            <textarea
                                name="intake_customer_description"
                                id="intake_customer_description"
                                placeholder="¿Qué reporta el cliente?"
                                required
                            >{{ old('intake_customer_description') }}</textarea>

                        </div>

                        <div class="mechanic-intake-field">

                            <label for="intake_observations">
                                Observaciones iniciales
                            </label>

                            <textarea
                                name="intake_observations"
                                id="intake_observations"
                                placeholder="Golpes, rayones, accesorios, etc."
                            >{{ old('intake_observations') }}</textarea>

                        </div>

                    </section>

                    {{-- FOTOGRAFÍAS --}}

                    <section class="mechanic-intake-card">

                        <h3>Fotos del vehículo</h3>

                        <div class="mechanic-intake-photos">

                            {{-- FRENTE --}}

                            <div class="mechanic-intake-photo">

                                <label for="photo_front">
                                    Frente
                                </label>

                                <img
                                    id="preview_front"
                                    alt="Vista previa del frente"
                                >

                                <input
                                    type="file"
                                    id="photo_front"
                                    name="photo_front"
                                    accept="image/jpeg,image/png,image/webp"
                                    data-preview="preview_front"
                                >

                            </div>

                            {{-- LADO IZQUIERDO --}}

                            <div class="mechanic-intake-photo">

                                <label for="photo_left">
                                    Lado izquierdo
                                </label>

                                <img
                                    id="preview_left"
                                    alt="Vista previa del lado izquierdo"
                                >

                                <input
                                    type="file"
                                    id="photo_left"
                                    name="photo_left"
                                    accept="image/jpeg,image/png,image/webp"
                                    data-preview="preview_left"
                                >

                            </div>

                            {{-- LADO DERECHO --}}

                            <div class="mechanic-intake-photo">

                                <label for="photo_right">
                                    Lado derecho
                                </label>

                                <img
                                    id="preview_right"
                                    alt="Vista previa del lado derecho"
                                >

                                <input
                                    type="file"
                                    id="photo_right"
                                    name="photo_right"
                                    accept="image/jpeg,image/png,image/webp"
                                    data-preview="preview_right"
                                >

                            </div>

                            {{-- TRASERA --}}

                            <div class="mechanic-intake-photo">

                                <label for="photo_rear">
                                    Trasera
                                </label>

                                <img
                                    id="preview_rear"
                                    alt="Vista previa de la parte trasera"
                                >

                                <input
                                    type="file"
                                    id="photo_rear"
                                    name="photo_rear"
                                    accept="image/jpeg,image/png,image/webp"
                                    data-preview="preview_rear"
                                >

                            </div>

                        </div>

                        <p class="mechanic-intake-hint">
                            Las fotos son opcionales.
                            Máximo 5 MB por imagen.
                        </p>

                    </section>

                    {{-- BOTONES --}}

                    <div class="mechanic-intake-actions">

                        <button
                            type="submit"
                            class="mechanic-btn mechanic-btn-red"
                        >
                            Registrar ingreso del vehículo
                        </button>

                        <a
                            href="{{ route('mecanico.dashboard') }}"
                            class="mechanic-intake-btn-outline"
                        >
                            Cancelar
                        </a>

                    </div>

                </form>

            @endif

        @endif

    </div>

</div>

@endsection

@push('scripts')

<script>
document.querySelectorAll('input[type="file"][data-preview]')
    .forEach(input => {

        input.addEventListener('change', function () {

            const preview = document.getElementById(
                this.dataset.preview
            );

            const file = this.files[0];

            if (!preview) {
                return;
            }

            if (!file) {
                preview.removeAttribute('src');
                preview.style.display = 'none';
                return;
            }

            const reader = new FileReader();

            reader.onload = event => {
                preview.src = event.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);

        });

    });
</script>

@endpush
