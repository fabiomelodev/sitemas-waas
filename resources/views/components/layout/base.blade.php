<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitemas - Seu Site Profissional por Assinatura</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite('resources/js/app.js')
    @livewireStyles
</head>

<body class="bg-white text-dark-900 antialiased">

    @if (config('services.asaas.env') === 'sandbox')
        <div class="w-full bottom-0 left-0 fixed bg-orange-500 p-1 z-[9999]">
            <p class="text-xs font-bold text-center text-white">
                Sandbox
            </p>
        </div>
    @endif

    <x-layout.header />

    <main>
        {{  $slot }}
    </main>

    <x-layout.footer />

    @livewireScripts
</body>

</html>