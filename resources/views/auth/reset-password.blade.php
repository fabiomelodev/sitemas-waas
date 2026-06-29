<!DOCTYPE html>
<html lang="pt-br" class="h-full bg-gray-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar minha conta | Sitemas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="h-full">

    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="flex justify-center">
                <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <span class="text-white text-3xl font-bold">S</span>
                </div>
            </div>
            <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">
                Crie sua conta na Sitemas
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Falta pouco! Defina uma senha para criar seu acesso ao painel.
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white px-4 py-8 shadow-xl border border-gray-100 sm:rounded-2xl sm:px-10">

                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">E-mail de
                            Acesso</label>
                        <div class="mt-1">
                            <input type="text" value="{{ $email }}" disabled
                                class="block w-full rounded-md border-gray-200 bg-gray-50 px-3 py-2 text-gray-500 sm:text-sm border shadow-sm">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 text-left">Crie sua
                            senha</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" required
                                class="block w-full rounded-lg border-gray-300 px-3 py-2.5 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border"
                                placeholder="Mínimo 8 caracteres">
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-gray-700 text-left">Confirmar Senha</label>
                        <div class="mt-1">
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="block w-full rounded-lg border-gray-300 px-3 py-2.5 text-gray-900 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border"
                                placeholder="Digite novamente">
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="flex w-full justify-center rounded-lg bg-blue-600 px-4 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all active:scale-95">
                            Criar minha conta
                        </button>
                    </div>
                </form>

            </div>

            <p class="mt-10 text-center text-xs text-gray-400 uppercase tracking-widest">
                &copy; {{ date('Y') }} Sitemas - Gerenciamento de Sites Profissionais
            </p>
        </div>
    </div>

</body>

</html>