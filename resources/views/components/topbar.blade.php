<header class="bg-black text-white h-16 flex items-center justify-between px-8 shadow-md">

    <h2 class="text-2xl font-bold">
        {{ $slot }}
    </h2>

    <div class="flex items-center gap-4">

        <span class="text-gray-300">
            {{ auth()->user()->name }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg font-semibold">
                Salir
            </button>
        </form>

    </div>

</header>