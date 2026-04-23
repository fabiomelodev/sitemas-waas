<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Single Temas - Seu Site Profissional por Assinatura</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            light: '#3b82f6', // Azul Principal (estilo SaaS)
                            DEFAULT: '#2563eb',
                            dark: '#1d4ed8',
                        },
                        dark: {
                            900: '#0f172a', // Fundo Quase Preto
                            800: '#1e293b', // Cards/Seções
                            700: '#334155',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'], // Tipografia moderna
                    },
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Ajuste suave para scroll */
        html {
            scroll-behavior: smooth;
        }
    </style>
    @livewireStyles
</head>

<body class="bg-white text-dark-900 antialiased">

    <x-layout.header />

    <main>
        {{  $slot }}
    </main>

    <x-layout.footer />

    @livewireScripts
</body>

</html>