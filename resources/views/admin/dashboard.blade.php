<x-layouts.app title="Dashboard Administrador">

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <x-stat-card
title="Citas Hoy"
value="12"
:icon='<<<SVG
<svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
</svg>
SVG'/>

    <x-stat-card
title="Vehículos"
value="58"
:icon='<<<SVG
<svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L9 7m6 6l4-4l-4-4"/>
</svg>
SVG'/>

    <x-stat-card
title="Mecánicos"
value="3"
:icon='<<<SVG
<svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
</svg>
SVG'/>

</div>

<div class="mt-8 bg-white rounded-2xl shadow-lg p-6">

    <h3 class="text-2xl font-bold mb-5 text-black">
        Acciones rápidas
    </h3>

    <div class="flex gap-4">

        <a href="{{ route('citas.create') }}"
           class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl font-semibold">
            Nueva Cita
        </a>

        <a href="{{ route('citas.index') }}"
           class="bg-black hover:bg-gray-800 text-white px-6 py-3 rounded-xl font-semibold">
            Ver Citas
        </a>

    </div>

</div>

</x-layouts.app>