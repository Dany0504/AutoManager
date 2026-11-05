
@extends('mecanico.layouts.app')

@section('title', 'Detalle de órdenes | AutoManager')

@section('content')

<header class="mechanic-header">
    <h1>Detalle de órdenes</h1>
    <p>Diagnóstico, servicios, refacciones y autorización del cliente.</p>
</header>

<div class="mechanic-content">
    <div class="mechanic-detail-container">

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
                <strong>Revisa los siguientes datos:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- SELECCIONAR CITA --}}

        <section class="mechanic-detail-card">
            <h2>Seleccionar cita</h2>

            <form
                method="GET"
                action="{{ route('mecanico.ordenes.detalle') }}"
            >
                <div class="mechanic-detail-field">
                    <label for="cita">
                        Citas con ingreso registrado
                    </label>

                    <select
                        id="cita"
                        name="cita"
                        onchange="this.form.submit()"
                    >
                        @if($appointments->isEmpty())
                            <option value="">
                                No hay citas con ingreso registrado
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
                                —
                                {{ $appointment->appointment_date?->format('d/m/Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <p class="mechanic-detail-hint">
                    Las citas sin ingreso del vehículo no aparecen aquí.
                </p>
            </form>
        </section>

        @if(!$cita)

            <section class="mechanic-detail-card mechanic-detail-empty">
                <h2>No hay órdenes disponibles</h2>

                <p>
                    Primero registra el ingreso de un vehículo
                    desde la sección correspondiente.
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
                $editable = in_array($cita->status, [
                    'pendiente',
                    'diagnostico',
                ], true);

                $savedItems = old(
                    'items',
                    $cita->orderItems->map(function ($item) {
                        return [
                            'type' => $item->type,
                            'name' => $item->name,
                            'quantity' => $item->quantity,
                            'unit_price' => $item->unit_price,
                        ];
                    })->toArray()
                );

                $photos = [
                    'Frente' => $cita->intake_photo_front,
                    'Lado izquierdo' => $cita->intake_photo_left,
                    'Lado derecho' => $cita->intake_photo_right,
                    'Parte trasera' => $cita->intake_photo_rear,
                ];
            @endphp

            {{-- INFORMACIÓN DE LA ORDEN --}}

            <section class="mechanic-detail-card">
                <h2>Información de la orden</h2>

                <div class="mechanic-detail-grid">

                    <div>
                        <div class="mechanic-detail-info-label">Folio</div>
                        <div class="mechanic-detail-info-value">
                            {{ $cita->folio ?? 'Cita #' . $cita->id }}
                        </div>
                    </div>

                    <div>
                        <div class="mechanic-detail-info-label">Estado</div>
                        <span class="mechanic-detail-badge">
                            {{ str_replace('_', ' ', ucfirst($cita->status)) }}
                        </span>
                    </div>

                    <div>
                        <div class="mechanic-detail-info-label">Cliente</div>
                        <div class="mechanic-detail-info-value">
                            {{ $cita->client?->user?->name ?? 'Sin cliente' }}
                        </div>
                    </div>

                    <div>
                        <div class="mechanic-detail-info-label">Vehículo</div>
                        <div class="mechanic-detail-info-value">
                            {{ $cita->vehicle?->brand }}
                            {{ $cita->vehicle?->model }}
                            {{ $cita->vehicle?->year }}
                        </div>
                    </div>

                    <div>
                        <div class="mechanic-detail-info-label">
                            Kilometraje de ingreso
                        </div>
                        <div class="mechanic-detail-info-value">
                            {{ $cita->intake_mileage ?? 'No registrado' }}
                        </div>
                    </div>

                    <div>
                        <div class="mechanic-detail-info-label">Combustible</div>
                        <div class="mechanic-detail-info-value">
                            {{ $cita->intake_fuel_level ?? 'No registrado' }}
                        </div>
                    </div>

                    <div>
                        <div class="mechanic-detail-info-label">
                            Descripción del cliente
                        </div>
                        <div class="mechanic-detail-info-value">
                            {{ $cita->intake_customer_description ?: 'Sin descripción' }}
                        </div>
                    </div>

                    <div>
                        <div class="mechanic-detail-info-label">
                            Observaciones de ingreso
                        </div>
                        <div class="mechanic-detail-info-value">
                            {{ $cita->intake_observations ?: 'Sin observaciones' }}
                        </div>
                    </div>

                </div>

                {{-- FOTOGRAFÍAS DE INGRESO --}}

                @if(collect($photos)->filter()->isNotEmpty())

                    <h2 class="mechanic-detail-photos-title">
                        Fotografías de ingreso
                    </h2>

                    <div class="mechanic-detail-photo-grid">

                        @foreach($photos as $label => $path)

                            @if($path)
                                <div>
                                    <a
                                        href="{{ asset('storage/' . $path) }}"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                    >
                                        <img
                                            src="{{ asset('storage/' . $path) }}"
                                            alt="{{ $label }}"
                                        >
                                    </a>

                                    <p>{{ $label }}</p>
                                </div>
                            @endif

                        @endforeach

                    </div>

                @endif
            </section>

            @if(!$editable)
                <div class="mechanic-success-message">
                    Esta orden ya fue enviada a autorización
                    o se encuentra en una etapa posterior.
                    El diagnóstico y los conceptos son de solo lectura.
                </div>
            @endif

            {{-- FORMULARIO DE DIAGNÓSTICO --}}

            <form
                method="POST"
                action="{{ route('mecanico.ordenes.detalle.save', $cita) }}"
                id="orderForm"
            >
                @csrf
                @method('PATCH')

                <section class="mechanic-detail-card">
                    <h2>Diagnóstico del vehículo</h2>

                    <div class="mechanic-detail-field">
                        <label for="diagnosis">
                            Descripción del diagnóstico
                        </label>

                        <textarea
                            id="diagnosis"
                            name="diagnosis"
                            placeholder="Describe las fallas encontradas y los trabajos recomendados..."
                            maxlength="5000"
                            @disabled(!$editable)
                            required
                        >{{ old('diagnosis', $cita->diagnosis) }}</textarea>
                    </div>
                </section>

                {{-- SERVICIOS Y REFACCIONES --}}

                <section class="mechanic-detail-card">

                    <div class="mechanic-detail-card-heading">
                        <h2>Servicios y refacciones</h2>

                        @if($editable)
                            <button
                                type="button"
                                class="mechanic-btn mechanic-btn-red"
                                onclick="addItem()"
                            >
                                + Agregar concepto
                            </button>
                        @endif
                    </div>

                    <div class="mechanic-detail-table-wrap">

                        <table class="mechanic-detail-table">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Descripción</th>
                                    <th>Cantidad</th>
                                    <th>Precio unitario</th>
                                    <th>Subtotal</th>

                                    @if($editable)
                                        <th>Acción</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody id="itemsBody">

                                @foreach($savedItems as $index => $item)

                                    <tr class="item-row">

                                        <td>
                                            <select
                                                name="items[{{ $index }}][type]"
                                                @disabled(!$editable)
                                                required
                                            >
                                                <option
                                                    value="servicio"
                                                    @selected(($item['type'] ?? '') === 'servicio')
                                                >
                                                    Servicio
                                                </option>

                                                <option
                                                    value="refaccion"
                                                    @selected(($item['type'] ?? '') === 'refaccion')
                                                >
                                                    Refacción
                                                </option>
                                            </select>
                                        </td>

                                        <td>
                                            <input
                                                type="text"
                                                name="items[{{ $index }}][name]"
                                                value="{{ $item['name'] ?? '' }}"
                                                placeholder="Descripción"
                                                maxlength="200"
                                                @disabled(!$editable)
                                                required
                                            >
                                        </td>

                                        <td>
                                            <input
                                                type="number"
                                                name="items[{{ $index }}][quantity]"
                                                value="{{ $item['quantity'] ?? 1 }}"
                                                min="1"
                                                max="100000"
                                                step="1"
                                                class="item-quantity"
                                                oninput="calculateTotal()"
                                                @disabled(!$editable)
                                                required
                                            >
                                        </td>

                                        <td>
                                            <input
                                                type="number"
                                                name="items[{{ $index }}][unit_price]"
                                                value="{{ $item['unit_price'] ?? 0 }}"
                                                min="0"
                                                max="9999999999.99"
                                                step="0.01"
                                                class="item-price"
                                                oninput="calculateTotal()"
                                                @disabled(!$editable)
                                                required
                                            >
                                        </td>

                                        <td>
                                            <strong class="item-subtotal">
                                                $0.00
                                            </strong>
                                        </td>

                                        @if($editable)
                                            <td>
                                                <button
                                                    type="button"
                                                    class="mechanic-detail-remove"
                                                    onclick="removeItem(this)"
                                                >
                                                    Quitar
                                                </button>
                                            </td>
                                        @endif

                                    </tr>

                                @endforeach

                            </tbody>
                        </table>

                    </div>

                    <p
                        id="emptyItemsMessage"
                        class="mechanic-detail-hint"
                        style="display:none;"
                    >
                        Todavía no has agregado servicios o refacciones.
                    </p>

                    <div class="mechanic-detail-total">
                        <span>Total estimado</span>
                        <strong id="grandTotal">$0.00</strong>
                    </div>

                    <p class="mechanic-detail-hint">
                        Los precios se capturan manualmente.
                        No se descuentan existencias de inventario.
                    </p>

                    @if($editable)

                        <div class="mechanic-detail-actions">

                            <button
                                type="submit"
                                name="action"
                                value="draft"
                                class="mechanic-btn mechanic-btn-dark"
                            >
                                Guardar cambios
                            </button>

                            <button
                                type="submit"
                                name="action"
                                value="submit"
                                class="mechanic-btn mechanic-btn-red"
                                onclick="return confirm('¿Deseas enviar este presupuesto al cliente para autorización?')"
                            >
                                Solicitar autorización al cliente
                            </button>

                        </div>

                    @else

                        <p class="mechanic-detail-hint">
                            Estado de autorización:
                            <strong>
                                {{ $cita->authorization_status ?? 'Pendiente' }}
                            </strong>
                        </p>

                    @endif

                </section>

            </form>

        @endif

    </div>
</div>

@endsection

@push('scripts')

<script>
    let nextItemIndex = @json(isset($savedItems) ? count($savedItems) : 0);

    const canEdit = @json(isset($editable) ? $editable : false);

    function addItem() {
        if (!canEdit) {
            return;
        }

        const tbody = document.getElementById('itemsBody');

        if (!tbody) {
            return;
        }

        const index = nextItemIndex++;
        const row = document.createElement('tr');

        row.className = 'item-row';

        row.innerHTML = `
            <td>
                <select name="items[${index}][type]" required>
                    <option value="servicio">Servicio</option>
                    <option value="refaccion">Refacción</option>
                </select>
            </td>

            <td>
                <input
                    type="text"
                    name="items[${index}][name]"
                    maxlength="200"
                    placeholder="Descripción"
                    required
                >
            </td>

            <td>
                <input
                    type="number"
                    name="items[${index}][quantity]"
                    value="1"
                    min="1"
                    max="100000"
                    step="1"
                    class="item-quantity"
                    oninput="calculateTotal()"
                    required
                >
            </td>

            <td>
                <input
                    type="number"
                    name="items[${index}][unit_price]"
                    value="0"
                    min="0"
                    max="9999999999.99"
                    step="0.01"
                    class="item-price"
                    oninput="calculateTotal()"
                    required
                >
            </td>

            <td>
                <strong class="item-subtotal">$0.00</strong>
            </td>

            <td>
                <button
                    type="button"
                    class="mechanic-detail-remove"
                    onclick="removeItem(this)"
                >
                    Quitar
                </button>
            </td>
        `;

        tbody.appendChild(row);
        calculateTotal();
    }

    function removeItem(button) {
        if (!canEdit) {
            return;
        }

        const row = button.closest('tr');

        if (row) {
            row.remove();
        }

        calculateTotal();
    }

    function calculateTotal() {
        const rows = document.querySelectorAll('.item-row');

        let totalCents = 0;

        rows.forEach(row => {
            const quantityInput = row.querySelector('.item-quantity');
            const priceInput = row.querySelector('.item-price');

            const quantity = Number(quantityInput?.value || 0);
            const price = Number(priceInput?.value || 0);

            const priceCents = Math.round(price * 100);
            const subtotalCents = quantity * priceCents;

            totalCents += subtotalCents;

            const subtotalElement = row.querySelector('.item-subtotal');

            if (subtotalElement) {
                subtotalElement.textContent = formatMoney(
                    subtotalCents / 100
                );
            }
        });

        const totalElement = document.getElementById('grandTotal');

        if (totalElement) {
            totalElement.textContent = formatMoney(
                totalCents / 100
            );
        }

        const emptyMessage = document.getElementById(
            'emptyItemsMessage'
        );

        if (emptyMessage) {
            emptyMessage.style.display =
                rows.length === 0 ? 'block' : 'none';
        }
    }

    function formatMoney(amount) {
        return new Intl.NumberFormat('es-MX', {
            style: 'currency',
            currency: 'MXN',
        }).format(amount);
    }

    document.addEventListener('DOMContentLoaded', calculateTotal);
</script>

@endpush
