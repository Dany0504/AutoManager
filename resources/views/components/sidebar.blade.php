<aside class="w-64 bg-black text-white min-h-screen flex flex-col">

    <div class="p-6 border-b border-gray-800">
        <h1 class="text-3xl font-extrabold text-red-600">
            AutoManager
        </h1>

        <p class="text-gray-400 text-sm mt-1">
            Taller Mecánico
        </p>
    </div>

    <nav class="flex-1 mt-4">

        {{-- Dashboard --}}
        <x-nav-link
            href="/admin"
            :active="request()->is('admin')"
            :icon='<<<SVG
<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10l9-7 9 7v10a1 1 0 01-1 1h-5v-6H9v6H4a1 1 0 01-1-1V10z"/>
</svg>
SVG'>
            Dashboard
        </x-nav-link>

        {{-- Citas --}}
        <x-nav-link
            href="{{ route('citas.index') }}"
            :active="request()->is('admin/citas*')"
            :icon='<<<SVG
<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M5 11h14M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
</svg>
SVG'>
            Citas
        </x-nav-link>

        {{-- Usuarios --}}
        <x-nav-link
            href="#"
            :active="request()->is('admin/usuarios*')"
            :icon='<<<SVG
<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5V4H2v16h5m10 0v-2a3 3 0 00-6 0v2m6 0H7m8-8a3 3 0 11-6 0 3 3 0 016 0z"/>
</svg>
SVG'>
            Usuarios
        </x-nav-link>

        {{-- Vehículos --}}
        <x-nav-link
            href="{{ route('vehiculos.index') }}"
            :active="request()->is('admin/vehiculos*')"
            :icon='<<<SVG
<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13l2-5a2 2 0 012-1h10a2 2 0 012 1l2 5M5 13h14M7 18a1.5 1.5 0 11-3 0A1.5 1.5 0 017 18zm15 0a1.5 1.5 0 11-3 0A1.5 1.5 0 0122 18z"/>
</svg>
SVG'>
            Vehículos
        </x-nav-link>

        {{-- Mecánicos --}}
        <x-nav-link
            href="#"
            :active="request()->is('admin/mecanicos*')"
            :icon='<<<SVG
<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.7 6.3a4 4 0 105.66 5.66l-4.24 4.24-5.66-5.66 4.24-4.24zM4 20l6-6"/>
</svg>
SVG'>
            Mecánicos
        </x-nav-link>

        {{-- Inventario --}}
        <x-nav-link
            href="#"
            :active="request()->is('admin/inventario*')"
            :icon='<<<SVG
<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0v10l-8 4m8-14l-8 4m0 10L4 17V7m8 4L4 7"/>
</svg>
SVG'>
            Inventario
        </x-nav-link>

        {{-- Reportes --}}
        <x-nav-link
            href="#"
            :active="request()->is('admin/reportes*')"
            :icon='<<<SVG
<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6m4 6V7m4 10V11M5 21h14"/>
</svg>
SVG'>
            Reportes
        </x-nav-link>

    </nav>

</aside>