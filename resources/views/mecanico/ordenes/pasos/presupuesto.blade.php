{{-- PASO 2 · DIAGNÓSTICO Y PRESUPUESTO --}}

@php
    $editable = in_array($cita->status, ['pendiente', 'diagnostico'], true);

    $savedItems = old(
        'items',
        $cita->orderItems->map(fn ($item) => [
            'type' => $item->type,
            'name' => $item->name,
            'quantity' => $item->quantity,
            'unit_price' => $item->unit_price,
        ])->toArray()
    );

    $authorizationLabel = [
        'pendiente' => 'Pendiente de respuesta',
        'aprobado' => 'Autorizado',
        'autorizado' => 'Autorizado',
        'rechazado' => 'Rechazado',
    ][$cita->authorization_status] ?? 'Pendiente';
@endphp

<div class="mechanic-detail-container">

    @if($editable && $cita->authorization_status === 'rechazado')
        <div class="mechanic-status-warning">
            <strong>El cliente rechazó el presupuesto anterior.</strong>
            Ajusta el diagnóstico o los conceptos y vuelve a solicitar autorización.
        </div>
    @endif

    @if($cita->status === 'esperando_aprobacion')
        <div class="mechanic-order-waiting">
            <strong>Esperando la respuesta del cliente.</strong>
            El presupuesto se envió
            @if($cita->diagnosis_submitted_at)
                el {{ $cita->diagnosis_submitted_at->format('d/m/Y \a \l\a\s H:i') }}.
            @endif
            Cuando lo autorice, la orden pasará sola a <em>Reparación</em>.
        </div>
    @elseif(!$editable)
        <div class="mechanic-success-message">
            Presupuesto autorizado por el cliente. El diagnóstico y los conceptos son de solo lectura.
        </div>
    @endif

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
                <label for="diagnosis">Descripción del diagnóstico</label>
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

        <section class="mechanic-detail-card">

            <div class="mechanic-detail-card-heading">
                <h2>Servicios y refacciones</h2>

                @if($editable)
                    <button type="button" class="mechanic-btn mechanic-btn-red" onclick="addItem()">
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
                                    <select name="items[{{ $index }}][type]" @disabled(!$editable) required>
                                        <option value="servicio" @selected(($item['type'] ?? '') === 'servicio')>Servicio</option>
                                        <option value="refaccion" @selected(($item['type'] ?? '') === 'refaccion')>Refacción</option>
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
                                    <strong class="item-subtotal">$0.00</strong>
                                </td>
                                @if($editable)
                                    <td>
                                        <button type="button" class="mechanic-detail-remove" onclick="removeItem(this)">
                                            Quitar
                                        </button>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <p id="emptyItemsMessage" class="mechanic-detail-hint" style="display:none;">
                Todavía no has agregado servicios o refacciones.
            </p>

            <div class="mechanic-detail-total">
                <span>Total estimado</span>
                <strong id="grandTotal">$0.00</strong>
            </div>

            <p class="mechanic-detail-hint">
                Los precios se capturan manualmente. No se descuentan existencias de inventario.
            </p>

            @if($editable)
                <div class="mechanic-detail-actions">
                    <button type="submit" name="action" value="draft" class="mechanic-btn mechanic-btn-dark">
                        Guardar borrador
                    </button>

                    <button
                        type="submit"
                        name="action"
                        value="submit"
                        class="mechanic-btn mechanic-btn-red"
                        data-confirmar="¿Deseas enviar este presupuesto al cliente para autorización?"
                    >
                        Solicitar autorización al cliente →
                    </button>
                </div>
            @else
                <p class="mechanic-detail-hint">
                    Estado de autorización: <strong>{{ $authorizationLabel }}</strong>
                </p>
            @endif

        </section>

    </form>

</div>

@push('scripts')
    <script>
        let nextItemIndex = @json(count($savedItems));
        const canEdit = @json($editable);

        function addItem() {
            if (!canEdit) return;

            const tbody = document.getElementById('itemsBody');
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
                    <input type="text" name="items[${index}][name]" maxlength="200" placeholder="Descripción" required>
                </td>
                <td>
                    <input type="number" name="items[${index}][quantity]" value="1" min="1" max="100000" step="1"
                           class="item-quantity" oninput="calculateTotal()" required>
                </td>
                <td>
                    <input type="number" name="items[${index}][unit_price]" value="0" min="0" max="9999999999.99" step="0.01"
                           class="item-price" oninput="calculateTotal()" required>
                </td>
                <td><strong class="item-subtotal">$0.00</strong></td>
                <td>
                    <button type="button" class="mechanic-detail-remove" onclick="removeItem(this)">Quitar</button>
                </td>
            `;

            tbody.appendChild(row);
            row.querySelector('input[type="text"]').focus();
            calculateTotal();
        }

        function removeItem(button) {
            if (!canEdit) return;
            button.closest('tr')?.remove();
            calculateTotal();
        }

        function calculateTotal() {
            const rows = document.querySelectorAll('.item-row');
            let totalCents = 0;

            rows.forEach(row => {
                const quantity = Number(row.querySelector('.item-quantity')?.value || 0);
                const priceCents = Math.round(Number(row.querySelector('.item-price')?.value || 0) * 100);
                const subtotalCents = quantity * priceCents;
                totalCents += subtotalCents;

                const subtotal = row.querySelector('.item-subtotal');
                if (subtotal) subtotal.textContent = formatMoney(subtotalCents / 100);
            });

            document.getElementById('grandTotal').textContent = formatMoney(totalCents / 100);
            document.getElementById('emptyItemsMessage').style.display = rows.length === 0 ? 'block' : 'none';
        }

        function formatMoney(amount) {
            return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(amount);
        }

        document.addEventListener('DOMContentLoaded', calculateTotal);
    </script>
@endpush
