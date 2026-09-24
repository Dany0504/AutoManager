<x-layouts.app title="Nueva Cita">

<div class="max-w-5xl mx-auto">

<div class="bg-white rounded-2xl shadow-lg p-8">

<form action="{{ route('citas.store') }}" method="POST" class="space-y-8">

@csrf

{{-- DATOS DEL CLIENTE --}}
<div class="flex justify-between items-center mb-6">

    <h2 class="text-3xl font-bold">
        Datos del Cliente
    </h2>

    <button
        type="button"
        id="openClientModal"
        class="bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-xl font-semibold">

        + Nuevo Cliente

    </button>

</div>

<div>
<label class="block font-semibold mb-2">Cliente</label>

<select id="clientSelect"
        name="client_id"
        class="w-full border rounded-xl p-3">

@foreach($clients as $client)

<option value="{{ $client->id }}">
{{ $client->name }}
</option>

@endforeach

</select>
</div>

<div>
<label class="block font-semibold mb-2">Teléfono</label>

<input
type="text"
id="phone"
readonly
class="w-full border rounded-xl p-3 bg-gray-100">
</div>

</div>

</div>

{{-- DATOS DEL VEHÍCULO --}}
<div>

<h2 class="text-xl font-bold border-b-2 border-red-600 pb-2 mb-4">
Datos del Vehículo
</h2>

<div class="grid md:grid-cols-2 gap-4">

<div>
<label class="block font-semibold mb-2">Vehículo</label>

<select id="vehicleSelect"
        name="vehicle_id"
        class="w-full border rounded-xl p-3">

<option value="">
Selecciona un vehículo
</option>

</select>

<p id="vehicleMessage"
    class="text-sm text-red-600 mt-2 hidden">

Este cliente no tiene vehículos registrados.

</p>
</div>

<div class="flex items-end">
<button
    type="button"
    id="openVehicleModal"
    class="w-full bg-black hover:bg-gray-900 text-white text-xl py-6 rounded-2xl font-semibold transition">

    + Registrar Vehículo

</button>
</div>

<div>
<label class="block font-semibold mb-2">
Kilometraje actual
</label>

<input
type="number"
name="mileage"
class="w-full border rounded-xl p-3"
placeholder="258000">
</div>

</div>

</div>

{{-- DATOS DEL SERVICIO --}}
<div>

<h2 class="text-xl font-bold border-b-2 border-red-600 pb-2 mb-4">
Servicio
</h2>

<div class="grid md:grid-cols-2 gap-4">

<div>
<label class="block font-semibold mb-2">Servicio</label>

<select name="service_type" class="w-full border rounded-xl p-3">
<option>Diagnóstico</option>
<option>Cambio de aceite</option>
<option>Frenos</option>
<option>Suspensión</option>
<option>Motor</option>
<option>Transmisión</option>
<option>Eléctrico</option>
<option>Otro</option>
</select>
</div>

<div>
<label class="block font-semibold mb-2">Prioridad</label>

<select name="priority"
class="w-full border rounded-xl p-3">
<option>Normal</option>
<option>Urgente</option>
</select>
</div>

<div>
<label class="block font-semibold mb-2">Fecha</label>

<input
type="date"
name="appointment_date"
class="w-full border rounded-xl p-3">
</div>

<div>
<label class="block font-semibold mb-2">Hora</label>

<input
type="time"
name="appointment_time"
class="w-full border rounded-xl p-3">
</div>

</div>

<div class="mt-4">
<label class="block font-semibold mb-2">Observaciones</label>

<textarea
name="notes"
rows="4"
class="w-full border rounded-xl p-3"
placeholder="Describe la falla..."></textarea>
</div>

</div>

<div class="flex justify-end gap-3">

<a href="{{ route('citas.index') }}"
class="bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-xl">

Cancelar

</a>

<button
class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold">

Guardar Cita

</button>

</div>

</form>

</div>

</div>

<script>
const clientSelect = document.getElementById('clientSelect');
const phoneInput = document.getElementById('phone');
const vehicleSelect = document.getElementById('vehicleSelect');
const vehicleMessage = document.getElementById('vehicleMessage');

async function loadClientData(id){

    const response = await fetch(`/admin/clientes/${id}/vehiculos`);

    const data = await response.json();

    phoneInput.value = data.phone ?? '';

    vehicleSelect.innerHTML =
        '<option value="">Selecciona un vehículo</option>';

    if(data.vehicles.length===0){

        vehicleMessage.classList.remove('hidden');

        return;
    }

    vehicleMessage.classList.add('hidden');

    data.vehicles.forEach(vehicle=>{

        vehicleSelect.innerHTML += `
            <option value="${vehicle.id}">
                ${vehicle.brand} ${vehicle.model} ${vehicle.year}
            </option>
        `;

    });

}

clientSelect.addEventListener('change',()=>{

    loadClientData(clientSelect.value);

});

window.addEventListener('DOMContentLoaded',()=>{

    if(clientSelect.value){

        loadClientData(clientSelect.value);

    }

});
</script>

<!-- Modal Nuevo Cliente -->
<div id="clientModal"
     class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden z-50">

    <div class="flex items-center justify-center min-h-screen p-6">

        <div class="bg-white w-full max-w-xl rounded-3xl shadow-2xl overflow-hidden">

            <!-- Encabezado -->
            <div class="bg-black px-8 py-6 flex justify-between items-center">

                <div>
                    <h2 class="text-2xl font-bold text-white">
                        Nuevo Cliente
                    </h2>

                    <p class="text-gray-400 text-sm">
                        Registra un cliente sin salir de la cita.
                    </p>
                </div>

                <button id="closeClientModal"
                        class="text-white text-3xl hover:text-red-500 transition">
                    ×
                </button>

            </div>

            <!-- Formulario -->
            <form id="newClientForm" class="p-8 space-y-6">

                @csrf

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Nombre completo
                    </label>

                    <input type="text"
                           name="name"
                           required
                           placeholder="Ej. Daniel Montaño de la Torre"
                           class="w-full border-2 border-gray-300 rounded-xl p-4 focus:border-red-600 focus:ring-red-600">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Teléfono
                    </label>

                    <input type="text"
                           name="phone"
                           required
                           placeholder="6621234567"
                           class="w-full border-2 border-gray-300 rounded-xl p-4 focus:border-red-600 focus:ring-red-600">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Correo (opcional)
                    </label>

                    <input type="email"
                           name="email"
                           placeholder="correo@ejemplo.com"
                           class="w-full border-2 border-gray-300 rounded-xl p-4 focus:border-red-600 focus:ring-red-600">
                </div>

                <!-- Botones -->
                <div class="flex justify-end gap-3 pt-2">

                    <button type="button"
                            id="cancelClientModal"
                            class="px-6 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 font-semibold">
                        Cancelar
                    </button>

                    <button type="submit"
                            class="px-6 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold shadow-lg">
                        Guardar Cliente
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded',()=>{

    const modal=document.getElementById('clientModal');

    const open=document.getElementById('openClientModal');

    const close=document.getElementById('closeClientModal');

    const cancel=document.getElementById('cancelClientModal');

    const form=document.getElementById('newClientForm');

    const clientSelect=document.getElementById('clientSelect');

    const phoneInput=document.getElementById('phone');

    open.onclick=()=>modal.classList.remove('hidden');

    open.onclick=()=>{
        modal.classList.remove('hidden');
    };

    const cerrar=()=>{
        modal.classList.add('hidden');
    };

    close.onclick=cerrar;
    cancel.onclick=cerrar;

    form.addEventListener('submit',async(e)=>{

        e.preventDefault();

        const data=new FormData(form);

        const response=await fetch('/admin/clientes/ajax',{

            method:'POST',

            headers:{
                'X-CSRF-TOKEN':document.querySelector('input[name=_token]').value,
                'Accept':'application/json'
            },

            body:data

        });

        const result=await response.json();

        if(result.success){

            const option=new Option(result.client.name,result.client.id,true,true);

            clientSelect.appendChild(option);

            phoneInput.value=result.client.phone;

            cerrar();

            form.reset();

            clientSelect.dispatchEvent(new Event('change'));

        }

    });

});
</script>



<!-- ================= MODAL REGISTRAR VEHÍCULO ================= -->

<div id="vehicleModal"
     class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden items-center justify-center z-50">

    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden">

        <!-- Encabezado -->

        <div class="bg-black px-8 py-6 flex justify-between items-center">

            <div>
                <h2 class="text-3xl font-bold text-white">
                    Registrar Vehículo
                </h2>

                <p class="text-gray-400 text-sm">
                    Agrega un vehículo al cliente seleccionado.
                </p>
            </div>

            <button id="closeVehicleModal"
                    type="button"
                    class="text-white text-3xl hover:text-red-500 transition">
                ×
            </button>

        </div>

        <!-- Formulario -->

        <form id="newVehicleForm" class="p-8 space-y-5">

            @csrf

            <input type="hidden"
                   id="vehicleClientId"
                   name="client_id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- Año -->

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Año
                    </label>

                    <select id="yearSelect"
                            name="year"
                            required
                            class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-red-600 focus:ring-red-600">

                        <option value="">Selecciona un año</option>

                        @for($year=date('Y');$year>=1995;$year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor

                    </select>

                </div>

                <!-- Marca -->

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Marca
                    </label>

                    <select id="brandSelect"
                            name="brand"
                            required
                            disabled
                            class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-red-600 focus:ring-red-600">

                        <option value="">Primero selecciona el año</option>

                    </select>

                </div>

                <!-- Modelo -->

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Modelo
                    </label>

                    <select id="modelSelect"
                            name="model"
                            required
                            disabled
                            class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-red-600 focus:ring-red-600">

                        <option value="">Primero selecciona la marca</option>

                    </select>

                </div>

                <!-- Motor -->

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Motor
                    </label>

                    <select id="engineSelect"
                            name="engine"
                            required
                            disabled
                            class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-red-600 focus:ring-red-600">

                        <option value="">Primero selecciona el modelo</option>

                    </select>

                </div>

                <!-- Color -->

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Color
                    </label>

                    <input type="text"
                           name="color"
                           required
                           placeholder="Ej. Azul"
                           class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-red-600 focus:ring-red-600">

                </div>

                <!-- Kilometraje -->

                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Kilometraje
                    </label>

                    <input type="number"
                           name="mileage"
                           required
                           placeholder="258000"
                           class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-red-600 focus:ring-red-600">

                </div>

            </div>

            <!-- Placas -->

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    Placas
                </label>

                <input type="text"
                       name="plates"
                       placeholder="WEJ117"
                       class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-red-600 focus:ring-red-600">
            </div>

            <!-- VIN -->

            <div>
                <label class="block mb-2 font-semibold text-gray-700">
                    VIN (opcional)
                </label>

                <input type="text"
                       name="vin"
                       placeholder="1HGCM82633A123456"
                       class="w-full border-2 border-gray-300 rounded-xl p-3 focus:border-red-600 focus:ring-red-600">
            </div>

            <!-- Botones -->

            <div class="flex justify-end gap-3 pt-3">

                <button type="button"
                        id="cancelVehicleModal"
                        class="px-5 py-3 rounded-xl bg-gray-200 hover:bg-gray-300 font-semibold">

                    Cancelar

                </button>

                <button type="submit"
                        class="px-5 py-3 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold shadow-lg">

                    Guardar Vehículo

                </button>

            </div>

        </form>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('vehicleModal');
    const open = document.getElementById('openVehicleModal');
    const close = document.getElementById('closeVehicleModal');
    const cancel = document.getElementById('cancelVehicleModal');

    const form = document.getElementById('newVehicleForm');

    const clientSelect = document.getElementById('clientSelect');
    const vehicleSelect = document.getElementById('vehicleSelect');

    const yearSelect = document.getElementById('yearSelect');
    const brandSelect = document.getElementById('brandSelect');
    const modelSelect = document.getElementById('modelSelect');
    const engineSelect = document.getElementById('engineSelect');

    // Abrir modal

    open.addEventListener('click', () => {

        if (!clientSelect.value) {
            alert('Primero selecciona un cliente.');
            return;
        }

        document.getElementById('vehicleClientId').value = clientSelect.value;

        modal.classList.remove('hidden');
        modal.classList.add('flex');

    });

    // Cerrar modal

    function cerrarModal() {

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        form.reset();

        brandSelect.innerHTML = '<option value="">Primero selecciona el año</option>';
        modelSelect.innerHTML = '<option value="">Primero selecciona la marca</option>';
        engineSelect.innerHTML = '<option value="">Primero selecciona el modelo</option>';

        brandSelect.disabled = true;
        modelSelect.disabled = true;
        engineSelect.disabled = true;

    }

    close.addEventListener('click', cerrarModal);
    cancel.addEventListener('click', cerrarModal);

    modal.addEventListener('click', function (e) {
        if (e.target === modal) cerrarModal();
    });

    // ================= AÑO -> MARCAS =================

    yearSelect.addEventListener('change', async function () {

        brandSelect.disabled = true;
        modelSelect.disabled = true;
        engineSelect.disabled = true;

        brandSelect.innerHTML = '<option>Cargando...</option>';
        modelSelect.innerHTML = '<option>Primero selecciona la marca</option>';
        engineSelect.innerHTML = '<option>Primero selecciona el modelo</option>';

        if (!this.value) return;

        const brands = await fetch(`/catalog/marcas/${this.value}`)
            .then(r => r.json());

        brandSelect.innerHTML = '<option value="">Selecciona una marca</option>';

        brands.forEach(brand => {
            brandSelect.innerHTML += `<option value="${brand}">${brand}</option>`;
        });

        brandSelect.disabled = false;

    });

    // ================= MARCA -> MODELOS =================

    brandSelect.addEventListener('change', async function () {

        modelSelect.disabled = true;
        engineSelect.disabled = true;

        modelSelect.innerHTML = '<option>Cargando...</option>';
        engineSelect.innerHTML = '<option>Primero selecciona el modelo</option>';

        if (!this.value) return;

        const models = await fetch(`/catalog/modelos/${yearSelect.value}/${encodeURIComponent(this.value)}`)
            .then(r => r.json());

        modelSelect.innerHTML = '<option value="">Selecciona un modelo</option>';

        models.forEach(model => {
            modelSelect.innerHTML += `<option value="${model}">${model}</option>`;
        });

        modelSelect.disabled = false;

    });

    // ================= MODELO -> MOTORES =================

    modelSelect.addEventListener('change', async function () {

        engineSelect.disabled = true;
        engineSelect.innerHTML = '<option>Cargando...</option>';

        if (!this.value) return;

        const engines = await fetch(`/catalog/motores/${yearSelect.value}/${encodeURIComponent(brandSelect.value)}/${encodeURIComponent(this.value)}`)
            .then(r => r.json());

        engineSelect.innerHTML = '<option value="">Selecciona un motor</option>';

        engines.forEach(engine => {
            engineSelect.innerHTML += `<option value="${engine}">${engine}</option>`;
        });

        engineSelect.disabled = false;

    });

    // ================= GUARDAR =================

    form.addEventListener('submit', async function (e) {

    e.preventDefault();

    try {

        const data = new FormData(form);

        const response = await fetch('/admin/vehiculos/ajax', {

            method: 'POST',

            headers: {
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },

            body: data

        });

        const result = await response.json();

        if (!response.ok) {
            console.error(result);
            alert('Error al guardar el vehículo.');
            return;
        }

        const texto = `${result.vehicle.brand} ${result.vehicle.model} (${result.vehicle.year})`;

        vehicleSelect.appendChild(
            new Option(texto, result.vehicle.id, true, true)
        );

        cerrarModal();

    } catch (error) {

        console.error(error);
        alert('Ocurrió un error. Revisa la consola (F12).');

    }

});

});
</script>

</x-layouts.app>