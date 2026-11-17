{{-- PASO 1 · INGRESO DEL VEHÍCULO --}}

@if($cita->intake_registered_at === null)

    <div class="mechanic-intake-container">

        <form
            method="POST"
            action="{{ route('mecanico.ordenes.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            <input type="hidden" name="appointment_id" value="{{ $cita->id }}">

            <section class="mechanic-intake-card">

                <h3>Estado del vehículo al llegar</h3>

                <div class="mechanic-intake-grid">

                    <div class="mechanic-intake-field">
                        <label for="intake_mileage">Kilometraje</label>
                        <input
                            type="number"
                            name="intake_mileage"
                            id="intake_mileage"
                            placeholder="Ej. 48250"
                            min="0"
                            max="9999999"
                            value="{{ old('intake_mileage', $cita->vehicle?->mileage) }}"
                            required
                        >
                    </div>

                    <div class="mechanic-intake-field">
                        <label for="intake_fuel_level">Nivel de combustible</label>
                        <select name="intake_fuel_level" id="intake_fuel_level" required>
                            <option value="">Selecciona</option>
                            @foreach([
                                'Vacio' => 'Vacío',
                                '1/4' => '1/4',
                                '1/2' => '1/2',
                                '3/4' => '3/4',
                                'Lleno' => 'Lleno',
                            ] as $valor => $texto)
                                <option value="{{ $valor }}" @selected(old('intake_fuel_level') === $valor)>
                                    {{ $texto }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>

            </section>

            <section class="mechanic-intake-card">

                <h3>Motivo de ingreso</h3>

                <div class="mechanic-intake-field">
                    <label for="intake_customer_description">Descripción del cliente</label>
                    <textarea
                        name="intake_customer_description"
                        id="intake_customer_description"
                        placeholder="¿Qué reporta el cliente?"
                        required
                    >{{ old('intake_customer_description', $cita->notes) }}</textarea>
                </div>

                <div class="mechanic-intake-field">
                    <label for="intake_observations">Observaciones iniciales</label>
                    <textarea
                        name="intake_observations"
                        id="intake_observations"
                        placeholder="Golpes, rayones, accesorios, etc."
                    >{{ old('intake_observations') }}</textarea>
                </div>

            </section>

            <section class="mechanic-intake-card">

                <h3>Fotos del vehículo</h3>

                <div class="mechanic-intake-photos">
                    @foreach([
                        'front' => 'Frente',
                        'left' => 'Lado izquierdo',
                        'right' => 'Lado derecho',
                        'rear' => 'Trasera',
                    ] as $lado => $texto)
                        <div class="mechanic-intake-photo">
                            <label for="photo_{{ $lado }}">{{ $texto }}</label>
                            <img id="preview_{{ $lado }}" alt="Vista previa: {{ $texto }}">
                            <input
                                type="file"
                                id="photo_{{ $lado }}"
                                name="photo_{{ $lado }}"
                                accept="image/jpeg,image/png,image/webp"
                                data-preview="preview_{{ $lado }}"
                            >
                        </div>
                    @endforeach
                </div>

                <p class="mechanic-intake-hint">
                    Las fotos son opcionales. Máximo 5 MB por imagen.
                </p>

            </section>

            <div class="mechanic-intake-actions">
                <button type="submit" class="mechanic-btn mechanic-btn-red">
                    Registrar ingreso y continuar →
                </button>
            </div>

        </form>

    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('input[type="file"][data-preview]').forEach(function (input) {
                input.addEventListener('change', function () {
                    var preview = document.getElementById(this.dataset.preview);
                    var file = this.files[0];
                    if (!preview) return;
                    if (!file) {
                        preview.removeAttribute('src');
                        preview.style.display = 'none';
                        return;
                    }
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                });
            });
        </script>
    @endpush

@else

    @php
        $photos = array_filter([
            'Frente' => $cita->intake_photo_front,
            'Lado izquierdo' => $cita->intake_photo_left,
            'Lado derecho' => $cita->intake_photo_right,
            'Parte trasera' => $cita->intake_photo_rear,
        ]);
    @endphp

    <section class="mechanic-detail-card">

        <h2>Ingreso registrado</h2>

        <div class="mechanic-detail-grid">
            <div>
                <div class="mechanic-detail-info-label">Fecha de ingreso</div>
                <div class="mechanic-detail-info-value">
                    {{ \Illuminate\Support\Carbon::parse($cita->intake_registered_at)->format('d/m/Y H:i') }}
                </div>
            </div>
            <div>
                <div class="mechanic-detail-info-label">Kilometraje</div>
                <div class="mechanic-detail-info-value">
                    {{ $cita->intake_mileage !== null ? number_format($cita->intake_mileage) . ' km' : 'No registrado' }}
                </div>
            </div>
            <div>
                <div class="mechanic-detail-info-label">Combustible</div>
                <div class="mechanic-detail-info-value">
                    {{ $cita->intake_fuel_level === 'Vacio' ? 'Vacío' : ($cita->intake_fuel_level ?? 'No registrado') }}
                </div>
            </div>
            <div>
                <div class="mechanic-detail-info-label">Descripción del cliente</div>
                <div class="mechanic-detail-info-value">
                    {{ $cita->intake_customer_description ?: 'Sin descripción' }}
                </div>
            </div>
            <div>
                <div class="mechanic-detail-info-label">Observaciones de ingreso</div>
                <div class="mechanic-detail-info-value">
                    {{ $cita->intake_observations ?: 'Sin observaciones' }}
                </div>
            </div>
        </div>

        @if($photos)
            <h2 class="mechanic-detail-photos-title">Fotografías de ingreso</h2>

            <div class="mechanic-detail-photo-grid">
                @foreach($photos as $label => $path)
                    <div>
                        <a href="{{ asset('storage/' . $path) }}" target="_blank" rel="noopener noreferrer">
                            <img src="{{ asset('storage/' . $path) }}" alt="{{ $label }}">
                        </a>
                        <p>{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        @endif

    </section>

@endif
