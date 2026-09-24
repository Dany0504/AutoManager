<x-layouts.app title="Gestión de Vehículos">

<style>
    .btn-eliminar {
        background-color: #ff0000;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-eliminar:hover {
        background-color: #c53030;
    }
</style>

<div class="bg-white rounded-2xl shadow-lg p-6">

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 p-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">

        <form method="GET" id="searchForm" class="mb-5">

    <input
        id="searchInput"
        type="text"
        name="buscar"
        value="{{ $buscar }}"
        placeholder="Buscar marca, modelo, año o cliente..."
        class="border rounded-lg px-4 py-2 w-80">

</form>

<script>
let timer;

const input = document.getElementById('searchInput');

input.addEventListener('input', () => {

    clearTimeout(timer);

    timer = setTimeout(async () => {

        const url = `{{ route('vehiculos.index') }}?buscar=${encodeURIComponent(input.value)}`;

        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const html = await response.text();

        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        document.getElementById('tablaVehiculos').innerHTML =
            doc.getElementById('tablaVehiculos').innerHTML;

        input.focus();
        input.setSelectionRange(input.value.length, input.value.length);

    }, 300);

});
</script>

        <a href="{{ route('vehiculos.create') }}"
            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold">

            Nuevo Vehículo

        </a>

    </div>

    <div class="overflow-x-auto">
        <div id=tablaVehiculos>
        <table class="w-full">

            <thead class="bg-black text-white">

                <tr>

                    <th class="p-4 text-left">Cliente</th>
                    <th class="p-4 text-left">Marca</th>
                    <th class="p-4 text-left">Modelo</th>
                    <th class="p-4 text-left">Año</th>
                    <th class="p-4 text-left">Color</th>
                    <th class="p-4 text-left">Placas</th>
                    <th class="p-4 text-left">KM</th>
                    <th class="p-4 text-left">Acciones</th>

                </tr>

            </thead>

            <tbody>

                @forelse($vehicles as $vehicle)

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-4">{{ $vehicle->client?->name ?? 'Sin cliente' }}</td>

                    <td class="p-4">{{ $vehicle->brand }}</td>

                    <td class="p-4">{{ $vehicle->model }}</td>

                    <td class="p-4">{{ $vehicle->year }}</td>

                    <td class="p-4">{{ $vehicle->color }}</td>

                    <td class="p-4">{{ $vehicle->plates ?? '—' }}</td>

                    <td class="p-4">{{ number_format($vehicle->mileage) }}</td>

                    <td class="p-4 flex gap-2">

                        <a href="#"
                            class="bg-black hover:bg-gray-800 text-white px-3 py-2 rounded-lg">

                            Editar

                        </a>

                        <form action="{{ route('vehiculos.destroy', $vehicle) }}"
      method="POST"
      onsubmit="return confirm('¿Eliminar este vehículo?')"
      style="display:inline;">

    @csrf
    @method('DELETE')

    <button type="submit" class="btn-eliminar">
        Eliminar
    </button>

</form>
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="8" class="text-center p-10 text-gray-500">

                        No hay vehículos registrados.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>
        </div>
    </div>

</div>

</x-layouts.app>