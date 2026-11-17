{{-- PASO 3 · REPARACIÓN --}}

@php
    $subSteps = [
        'en_proceso' => ['title' => 'Reparación en curso', 'description' => 'Trabajos autorizados por el cliente'],
        'control_calidad' => ['title' => 'Control de calidad', 'description' => 'Pruebas y revisión final'],
        'listo' => ['title' => 'Listo para entrega', 'description' => 'Vehículo terminado'],
    ];

    // Mientras se repara, marca la etapa actual; si ya está lista o entregada, todo queda completo.
    $position = match ($cita->status) {
        'en_proceso' => 0,
        'control_calidad' => 1,
        default => count($subSteps),
    };

    $next = [
        'en_proceso' => ['label' => 'Pasar a control de calidad', 'confirm' => '¿Terminaste la reparación y pasas el vehículo a control de calidad?'],
        'control_calidad' => ['label' => 'Marcar como listo para entrega', 'confirm' => '¿El vehículo pasó el control de calidad y está listo para entregarse?'],
    ][$cita->status] ?? null;
@endphp

<div class="mechanic-status-container">

    <section class="mechanic-status-card">
        <h2>Avance de la reparación</h2>

        <div class="mechanic-status-timeline">
            @foreach($subSteps as $status => $sub)
                @php
                    $i = $loop->index;
                    $isDone = $i < $position;
                    $isCurrent = $i === $position;
                @endphp

                <div class="mechanic-status-step {{ $isDone ? 'done' : '' }} {{ $isCurrent ? 'current' : '' }}">
                    <div class="mechanic-status-step-marker">
                        @if($isDone) ✓ @elseif($isCurrent) ● @else {{ $i + 1 }} @endif
                    </div>
                    <div>
                        <div class="mechanic-status-step-title">{{ $sub['title'] }}</div>
                        <div class="mechanic-status-step-description">{{ $sub['description'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    @if($next)
        <section class="mechanic-status-card">
            <h2>Siguiente paso</h2>

            <form method="POST" action="{{ route('mecanico.ordenes.estatus.update', $cita) }}">
                @csrf
                @method('PATCH')

                <div class="mechanic-status-field">
                    <label for="note_avance">Trabajos realizados u observaciones (opcional)</label>
                    <textarea
                        name="note"
                        id="note_avance"
                        maxlength="3000"
                        placeholder="Ej. Se cambiaron balatas delanteras y se rectificaron discos."
                    >{{ old('action') === 'advance' ? old('note') : '' }}</textarea>
                </div>

                <div class="mechanic-status-actions">
                    <button
                        type="submit"
                        name="action"
                        value="advance"
                        class="mechanic-btn mechanic-btn-red"
                        data-confirmar="{{ $next['confirm'] }}"
                    >
                        {{ $next['label'] }} →
                    </button>
                </div>
            </form>
        </section>
    @else
        <div class="mechanic-success-message">
            La reparación está terminada.
        </div>
    @endif

</div>
