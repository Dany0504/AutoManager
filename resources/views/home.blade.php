<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AutoManager</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
            font-family: Arial, sans-serif;
            background:#0f0f0f;
            color:white;
            min-height:100vh;
            overflow-x:hidden;
            overflow-y:auto;
        }

        header {
            padding: 25px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo h2 {
            color: #e11d2e;
            font-size: 38px;
        }

        .logo p {
            color: #aaa;
            font-size: 15px;
        }

        .botones button {
            padding: 12px 22px;
            margin-left: 12px;
            border-radius: 8px;
            cursor: pointer;
            border: none;
            font-size: 15px;
        }

        .login {
            background: transparent;
            color: white;
            border: 1px solid #666 !important;
        }

        .registro {
            background: #e11d2e;
            color: white;
        }

        .principal {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: calc(100vh - 170px);
            padding: 0 70px;
        }

        .texto {
            width: 50%;
        }

        .texto h1 {
            font-size: 90px;
            line-height: 0.95;
            margin-bottom: 25px;
        }

        .texto p {
            font-size: 22px;
            color: #c9c9c9;
            margin-bottom: 35px;
            max-width: 500px;
        }

        .acciones button {
            padding: 18px 30px;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            cursor: pointer;
            margin-right: 15px;
            transition: .25s;
        }

        .agendar {
            background: #e11d2e;
            color: white;
        }

        .agendar:hover {
            background: #c41223;
        }

        .rastrear {
            background: transparent;
            border: 1px solid white !important;
            color: white;
        }

        .rastrear:hover {
            background: white;
            color: black;
        }

        .imagen {
            width: 45%;
        }

        .imagen img {
            width: 100%;
            border-radius: 20px;
        }

        footer {
            height: 60px;
            border-top: 1px solid #333;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 40px;
            color: #aaa;
            font-size: 14px;
        }

        /* MODAL */

        .modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .7);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .contenido-modal{
    width:700px;
    max-width:95%;
    max-height:85vh;
    background:white;
    color:black;
    border-radius:20px;
    overflow:hidden;
    display:flex;
    flex-direction:column;
}

        .cabecera {
            background: black;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
        }

        .cerrar {
            cursor: pointer;
            font-size: 28px;
        }

        .cuerpo{
    padding:25px;
    overflow-y:auto;
    max-height:calc(85vh - 75px);
}

        .cuerpo input {
            width: 100%;
            padding: 13px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        .cuerpo button {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 10px;
            background: #e11d2e;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        

        /* ================= RESPONSIVE ================= */

@media (max-width: 992px) {

    header {
        padding: 40px 50px;
    }

    .principal {
        flex-direction: column;
        justify-content: center;
        text-align: center;
        padding: 30px;
        gap: 30px;
    }

    .texto,
    .imagen {
        width: 100%;
    }

    .texto h1 {
        font-size: 60px;
    }

    .texto p {
        font-size: 20px;
        max-width: none;
    }

    .acciones {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }

    .imagen img {
        max-width: 550px;
    }

    footer {
        flex-direction: column;
        gap: 10px;
        height: auto;
        padding: 15px 0;
    }
}

@media (max-width: 600px) {

    header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
        padding: 20px;
    }

    .botones {
        display: flex;
        gap: 10px;
    }

    .botones button {
        margin: 0;
    }

    .texto h1 {
        font-size: 42px;
        line-height: 1.1;
    }

    .texto p {
        font-size: 17px;
    }

    .acciones button {
        width: 100%;
        margin: 0;
    }

    .imagen img {
        max-width: 100%;
    }

    .contenido-modal {
        width: 90%;
    }
}
@media (max-width: 992px){

    body{
        overflow-y:auto;
    }

    .principal{
        flex-direction:column;
        justify-content:center;
        text-align:center;
        height:auto;
        min-height:calc(100vh - 170px);
        padding:40px 30px;
        gap:40px;
    }

    .texto,
    .imagen{
        width:100%;
    }

    .texto h1{
        font-size:60px;
    }

    footer{
        position:static;
        padding:20px 0;
        flex-direction:column;
        gap:10px;
        height:auto;
    }
}

@media (max-width:600px){

    .texto h1{
        font-size:42px;
    }

    .acciones button{
        width:100%;
        margin-bottom:12px;
    }
}

.cuerpo select,
.cuerpo textarea{
    width:100%;
    padding:13px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:15px;
}

.cuerpo h3{
    margin-bottom:12px;
}

.cuerpo hr{
    border:none;
    border-top:1px solid #ddd;
}


    </style>
</head>

<body>

<header>

    <div class="logo">
        <h2>AutoManager</h2>
        <p>Taller Mecánico</p>
    </div>

    <div class="botones">

        <a href="/login">
            <button class="login">Iniciar sesión</button>
        </a>

        <a href="/register">
            <button class="registro">Registrarse</button>
        </a>

    </div>

</header>

<section class="principal">

    <div class="texto">

        <h1>Tu vehículo en las mejores manos.</h1>

        <p>
            Agenda tu cita en minutos y consulta el estado de tu vehículo con tu folio.
        </p>

        <div class="acciones">

            <button class="agendar" onclick="abrir('agendarModal')">
                Agendar Cita
            </button>

            <button class="rastrear" onclick="abrir('rastrearModal')">
                Rastrear Vehículo
            </button>

        </div>

    </div>

    <div class="imagen">

        <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=900&q=80">

    </div>

</section>

<footer>

    <span>Contacto: 662-123-4567</span>

    <span>Ubicación: Blvd. Solidaridad #2450, Hermosillo, Sonora</span>

</footer>

<!-- MODAL AGENDAR -->

<div class="modal" id="agendarModal">

    <div class="contenido-modal" style="width:700px; max-width:95%;">

        <div class="cabecera">

            <h2>Agendar Cita</h2>

            <span class="cerrar" onclick="cerrar('agendarModal')">×</span>

        </div>

        <form id="publicAppointmentForm">

            <div class="cuerpo">

                <h3>Datos del cliente</h3>

                <input name="name" placeholder="Nombre completo" required>

                <input name="phone" placeholder="Teléfono" required>

                <input name="email" type="email" placeholder="Correo (opcional)">

                <hr style="margin:20px 0;">

                <h3>Datos del vehículo</h3>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">

                    <select id="yearPublic" name="year" required>
                        <option value="">Año</option>
                    </select>

                    <select id="brandPublic" name="brand" disabled required>
                        <option>Marca</option>
                    </select>

                    <select id="modelPublic" name="model" disabled required>
                        <option>Modelo</option>
                    </select>

                    <select id="enginePublic" name="engine" disabled required>
                        <option>Motor</option>
                    </select>

                </div>

                <input name="color" placeholder="Color" required>

                <input name="plates" placeholder="Placas">

                <input name="mileage" type="number" placeholder="Kilometraje" required>

                <hr style="margin:20px 0;">

                <h3>Datos de la cita</h3>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">

                    <input type="date" name="appointment_date" required>

                    <input type="time" name="appointment_time" required>

                </div>

                <select name="service_type" required style="margin-top:12px;">

                    <option value="">Tipo de servicio</option>

                    <option>Mantenimiento preventivo</option>

                    <option>Cambio de aceite</option>

                    <option>Diagnóstico</option>

                    <option>Frenos</option>

                    <option>Suspensión</option>

                    <option>Motor</option>

                    <option>Eléctrico</option>

                    <option>Otro</option>

                </select>

                <textarea
                    name="description"
                    placeholder="Describe brevemente el problema..."
                    rows="3"
                    style="width:100%;margin-top:12px;padding:13px;border-radius:8px;"></textarea>

                <button type="submit" style="margin-top:20px;">

                    Solicitar cita

                </button>

            </div>

        </form>

    </div>

</div>
<!-- MODAL RASTREAR -->

<div class="modal" id="rastrearModal">

    <div class="contenido-modal">

        <div class="cabecera">

            <h2>Rastrear Vehículo</h2>

            <span class="cerrar" onclick="cerrar('rastrearModal')">×</span>

        </div>

        <div class="cuerpo">

            <input placeholder="AM-2026-000123">

            <button>Buscar</button>

        </div>

    </div>

</div>

<script>

function abrir(id){
    document.getElementById(id).style.display='flex';
}

function cerrar(id){
    document.getElementById(id).style.display='none';
}

window.onclick=function(e){

    document.querySelectorAll('.modal').forEach(modal=>{

        if(e.target===modal)
            modal.style.display='none';

    });

}

// ================= CATÁLOGO PÚBLICO =================

const yearPublic = document.getElementById('yearPublic');
const brandPublic = document.getElementById('brandPublic');
const modelPublic = document.getElementById('modelPublic');
const enginePublic = document.getElementById('enginePublic');

// Llenar años
for(let y = new Date().getFullYear(); y >= 1995; y--){
    yearPublic.innerHTML += `<option value="${y}">${y}</option>`;
}

// AÑO → MARCAS
yearPublic.addEventListener('change', async function(){

    brandPublic.disabled = true;
    modelPublic.disabled = true;
    enginePublic.disabled = true;

    brandPublic.innerHTML = '<option value="">Cargando...</option>';
    modelPublic.innerHTML = '<option value="">Modelo</option>';
    enginePublic.innerHTML = '<option value="">Motor</option>';

    if(!this.value) return;

    try{

        const res = await fetch(`/catalog/marcas/${this.value}`);
        const brands = await res.json();

        brandPublic.innerHTML = '<option value="">Selecciona una marca</option>';

        brands.forEach(brand=>{
            brandPublic.innerHTML += `<option value="${brand}">${brand}</option>`;
        });

        brandPublic.disabled = false;

    }catch(err){
        console.error(err);
    }

});

// MARCA → MODELOS
brandPublic.addEventListener('change', async function(){

    modelPublic.disabled = true;
    enginePublic.disabled = true;

    modelPublic.innerHTML = '<option value="">Cargando...</option>';
    enginePublic.innerHTML = '<option value="">Motor</option>';

    if(!this.value) return;

    try{

        const res = await fetch(`/catalog/modelos/${yearPublic.value}/${encodeURIComponent(this.value)}`);
        const models = await res.json();

        modelPublic.innerHTML = '<option value="">Selecciona un modelo</option>';

        models.forEach(model=>{
            modelPublic.innerHTML += `<option value="${model}">${model}</option>`;
        });

        modelPublic.disabled = false;

    }catch(err){
        console.error(err);
    }

});

// MODELO → MOTORES
modelPublic.addEventListener('change', async function(){

    enginePublic.disabled = true;
    enginePublic.innerHTML = '<option value="">Cargando...</option>';

    if(!this.value) return;

    try{

        const res = await fetch(`/catalog/motores/${yearPublic.value}/${encodeURIComponent(brandPublic.value)}/${encodeURIComponent(this.value)}`);
        const engines = await res.json();

        enginePublic.innerHTML = '<option value="">Selecciona un motor</option>';

        engines.forEach(engine=>{
            enginePublic.innerHTML += `<option value="${engine}">${engine}</option>`;
        });

        enginePublic.disabled = false;

    }catch(err){
        console.error(err);
    }

});
// ================= ENVIAR CITA PÚBLICA =================

document.getElementById('publicAppointmentForm').addEventListener('submit', async function(e){

    e.preventDefault();

    const form = this;
    const data = new FormData(form);

    try{

        const response = await fetch('/agendar-cita',{

            method:'POST',

            headers:{
                'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content,
                'Accept':'application/json'
            },

            body:data

        });

        const result = await response.json();

        if(!response.ok){

            console.error(result);
            alert('Error al crear la cita.');
            return;
        }

        cerrar('agendarModal');

        document.getElementById('successName').textContent=result.name;
        document.getElementById('successDate').textContent=result.date;
        document.getElementById('successTime').textContent=result.time;
        document.getElementById('successFolio').textContent=result.folio;

        abrir('successModal');

        form.reset();

    }catch(error){

        console.error(error);
        alert('Error al conectar con el servidor.');

    }

});


</script>
<div class="modal" id="successModal">

    <div class="contenido-modal" style="width:420px;">

        <div class="cabecera">

            <h2>Cita registrada</h2>

            <span class="cerrar" onclick="cerrar('successModal')">×</span>

        </div>

        <div class="cuerpo" style="text-align:center;">

            <div style="font-size:55px;color:#22c55e;">✓</div>

            <h3 style="margin:15px 0;">¡Tu cita fue creada con éxito!</h3>

            <p><strong>Cliente:</strong> <span id="successName"></span></p>

            <p><strong>Fecha:</strong> <span id="successDate"></span></p>

            <p><strong>Hora:</strong> <span id="successTime"></span></p>

            <div style="background:#f3f4f6;padding:18px;border-radius:12px;margin:20px 0;">

                <p>Tu folio es</p>

                <h2 id="successFolio" style="color:#e11d2e;"></h2>

            </div>

            <button onclick="cerrar('successModal')">
                Entendido
            </button>

        </div>

    </div>

</div>
</body>

</html>