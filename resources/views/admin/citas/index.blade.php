<x-layouts.app title="Configuración de Citas">

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

<div class="bg-white rounded-xl shadow">

<div class="flex flex-col md:flex-row justify-between gap-4 mb-6">

<form method="GET" id="searchForm" class="mb-5">

    <input
        id="searchInput"
        type="text"
        name="buscar"
        value="{{ $buscar }}"
        placeholder="Buscar por folio, cliente o vehículo..."
        class="border rounded-lg px-4 py-2 w-80">

</form>
<script>
let timer;

const input = document.getElementById('searchInput');

input.addEventListener('input', () => {

    clearTimeout(timer);

    timer = setTimeout(async () => {

        const url = `{{ route('citas.index') }}?buscar=${encodeURIComponent(input.value)}`;

        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        const html = await response.text();

        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');

        document.getElementById('tablaCitas').innerHTML =
            doc.getElementById('tablaCitas').innerHTML;

        input.focus();
        input.setSelectionRange(input.value.length, input.value.length);

    }, 300);

});
</script>

<a href="{{ route('citas.create') }}"
class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold text-center">

Nueva Cita

</a>

</div>

@if(session('success'))

<div class="m-4 bg-green-100 text-green-800 p-3 rounded">

{{ session('success') }}

</div>

@endif

<div  class="overflow-x-auto">
<div id ="tablaCitas">
<table class="w-full">

<thead class="bg-black text-white">

<tr>

<th class="p-4">Cliente</th>
<th class="p-4">Vehículo</th>
<th class="p-4">Servicio</th>
<th class="p-4">Fecha</th>
<th class="p-4">Hora</th>
<th class="p-4">Estado</th>
<th class="p-4">Acciones</th>

</tr>

</thead>

<tbody>

@forelse($appointments as $appointment)

<tr class="border-b hover:bg-gray-100">

<td class="p-4">{{ $appointment->client->name }}</td>
<td class="p-4">{{ $appointment->vehicle->brand }} {{ $appointment->vehicle->model }} ({{ $appointment->vehicle->year }})</td>
<td class="p-4">{{ $appointment->service_type }}</td>
<td class="p-4">{{ $appointment->appointment_date }}</td>
<td class="p-4">{{ $appointment->appointment_time }}</td>

<td class="p-4">

<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">

{{ ucfirst($appointment->status) }}

</span>

</td>

<td class="p-4 flex gap-2">

<a href="{{ route('citas.edit',$appointment) }}"
class="bg-black text-white px-3 py-1 rounded">

Editar

</a>

<form action="{{ route('citas.destroy', $appointment) }}"
      method="POST"
      onsubmit="return confirm('¿Eliminar esta cita?')"
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

<td colspan="7" class="text-center p-8">

No hay citas registradas.

</td>

</tr>

@endforelse

</tbody>

</table>
</div>

</div>

</div>

</x-layouts.app>