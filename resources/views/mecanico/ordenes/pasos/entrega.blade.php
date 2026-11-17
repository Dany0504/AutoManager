{{-- PASO 4 · ENTREGA --}}

<div class="mechanic-status-container">

    @if($cita->status === 'listo')

        <section class="mechanic-status-card">
            <h2>Entregar el vehículo</h2>

            <p class="mechanic-order-text">
                El vehículo está listo. Cuando el cliente lo recoja, confirma la entrega para cerrar la orden.
            </p>

            <div class="mechanic-order-summary">
                <div>
                    <span>Total autorizado</span>
                    <strong>${{ number_format((float) $cita->estimated_cost, 2) }}</strong>
                </div>
                <div>
                    <span>Conceptos</span>
                    <strong>{{ $cita->orderItems->count() }}</strong>
                </div>
            </div>

            <form method="POST" action="{{ route('mecanico.ordenes.estatus.update', $cita) }}">
                @csrf
                @method('PATCH')

                <div class="mechanic-status-field">
                    <label for="note_entrega">Comentarios de la entrega (opcional)</label>
                    <textarea
                        name="note"
                        id="note_entrega"
                        maxlength="3000"
                        placeholder="Ej. Se entregaron las piezas reemplazadas al cliente."
                    >{{ old('action') === 'deliver' ? old('note') : '' }}</textarea>
                </div>

                <div class="mechanic-status-actions">
                    <button
                        type="submit"
                        name="action"
                        value="deliver"
                        class="mechanic-btn mechanic-btn-red"
                        data-confirmar="¿Confirmas que el vehículo ya fue entregado al cliente?"
                    >
                        Confirmar entrega ✓
                    </button>
                </div>
            </form>
        </section>

    @else

        <section class="mechanic-status-card mechanic-order-done">
            <div class="mechanic-order-done-icon">✓</div>
            <h2>Orden cerrada</h2>
            <p class="mechanic-order-text">
                @if($cita->status === 'cancelado')
                    Esta orden fue cancelada.
                @else
                    El vehículo fue entregado al cliente.
                @endif
                Puedes consultar los pasos anteriores y el historial.
            </p>
        </section>

    @endif

</div>
