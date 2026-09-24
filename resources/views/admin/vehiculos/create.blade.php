<x-layouts.app title="Nuevo Vehículo">

<div class="max-w-3xl mx-auto">

<div class="bg-white rounded-2xl shadow-lg p-8">

<form action="{{ route('vehiculos.store') }}"
    method="POST"
    class="space-y-5">

@csrf

<div>

<label class="block font-semibold mb-2">

Cliente

</label>

<select name="client_id"
        class="w-full border rounded-xl p-3">

@foreach($clients as $client)

<option value="{{ $client->id }}">

{{ $client->name }}

</option>

@endforeach

</select>

</div>

<div class="grid md:grid-cols-2 gap-4">

<div>

<label class="block font-semibold mb-2">

Marca

</label>

<input type="text"
    name="brand"
    class="w-full border rounded-xl p-3"
    placeholder="Honda">

</div>

<div>

<label class="block font-semibold mb-2">

Modelo

</label>

<input type="text"
        name="model"
        class="w-full border rounded-xl p-3"
        placeholder="Accord">

</div>

</div>

<div class="grid md:grid-cols-2 gap-4">

<div>

<label class="block font-semibold mb-2">

Año

</label>

<input type="number"
        name="year"
        min="1980"
        max="2030"
        class="w-full border rounded-xl p-3">

</div>

<div>

<label class="block font-semibold mb-2">

Color

</label>

<input type="text"
        name="color"
        class="w-full border rounded-xl p-3">

</div>

</div>

<div class="grid md:grid-cols-2 gap-4">

<div>

<label class="block font-semibold mb-2">

Placas

</label>

<input type="text"
        name="plates"
        class="w-full border rounded-xl p-3">

</div>

<div>

<label class="block font-semibold mb-2">

Kilometraje

</label>

<input type="number"
        name="mileage"
        class="w-full border rounded-xl p-3">

</div>

</div>

<div>

<label class="block font-semibold mb-2">

VIN (Opcional)

</label>

<input type="text"
        name="vin"
        maxlength="17"
        class="w-full border rounded-xl p-3">

</div>

<div class="flex gap-4">

<button
class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold">

Guardar Vehículo

</button>

<a href="{{ route('vehiculos.index') }}"
class="bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-xl font-semibold">

Cancelar

</a>

</div>

</form>

</div>

</div>

</x-layouts.app>