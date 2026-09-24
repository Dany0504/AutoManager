<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>AutoManager</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

    <x-sidebar/>

    <div class="flex-1 flex flex-col">

        <x-topbar>
            {{ $title }}
        </x-topbar>

        <main class="flex-1 p-8 bg-gray-100">
            {{ $slot }}
        </main>

    </div>

</div>

</body>