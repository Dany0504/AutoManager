<x-layouts.app title="Gestión de Vehículos">

<div class="bg-white rounded-2xl shadow-lg p-6">

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 p-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">

        <input
            type="text"
            placeholder="Buscar vehículo..."
            class="w-full md:w-96 border border-gray-300 rounded-xl px-4 py-3">

        <a href="{{ route('vehiculos.create') }}"
            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold">

            Nuevo Vehículo

        </a>

    </div>

    <div class="overflow-x-auto">

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

                        <button
                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg">

                            Eliminar

                        </button>

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

</x-layouts.app>