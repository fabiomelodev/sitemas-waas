<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Confirmado! - Sitemas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 antialiased text-slate-900">

    <header class="w-full bg-white border-b border-slate-100 py-6">
        <div class="max-w-3xl mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-sm">
                    <span class="text-white font-bold text-sm">S</span>
                </div>
                <span class="text-xl font-extrabold tracking-tight text-slate-900">
                    Single<span class="text-blue-600">Temas</span>
                </span>
            </div>

            <a href="/"
                class="group flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-slate-900 transition-colors">
                <div
                    class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-slate-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </div>
                Voltar ao Início
            </a>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-6 py-12 md:py-20">

        <div class="text-center mb-12">
            <div
                class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-slate-900 mb-4">
                Pagamento Confirmado!
            </h1>
            <p class="text-lg text-slate-600">
                Ficamos felizes em ter você conosco. Agora, precisamos de alguns detalhes para colocar seu site no ar.
            </p>
        </div>

        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-200 overflow-hidden">

            <div class="p-8 md:p-12">

                <form action="{{  route('subscription.store') }}" method="POST" class="space-y-8">
                    @method('POST')
                    @csrf

                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-widest text-blue-600 mb-6">
                            1. Identidade do
                            Negócio
                        </h3>

                        <div class="grid grid-cols-1 gap-6">

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2" for="business">
                                    Nome da Empresa / Profissional
                                </label>

                                <input
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 focus:border-transparent outline-none transition"
                                    type="text" placeholder="Ex: Advocacia Silva & Associados" name="business"
                                    id="business" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2" for="brand">
                                    Logotipo (se tiver)
                                </label>

                                <div
                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-blue-400 transition cursor-pointer">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-slate-400" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>

                                        <div class="flex text-sm text-slate-600">
                                            <span
                                                class="relative cursor-pointer bg-white rounded-md font-bold text-blue-600 hover:text-blue-500">
                                                Enviar arquivo
                                            </span>

                                            <p class="pl-1">
                                                ou arraste e solte
                                            </p>
                                        </div>

                                        <p class="text-xs text-slate-500">
                                            PNG, JPG até 10MB
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <div>
                        <h3 class="text-sm font-bold uppercase tracking-widest text-blue-600 mb-6">
                            2. Contato e Domínio
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2" for="whatsapp">
                                    WhatsApp para o Site
                                </label>

                                <input
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none transition"
                                    type="text" placeholder="(00) 00000-0000" name="whatsapp" id="whatsapp" />
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2" for="domain">
                                    Domínio Desejado
                                </label>

                                <input type="text" placeholder="ex: www.suaempresa.com.br"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-600 outline-none transition"
                                    name="domain" id="domain" />
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-slate-50 rounded-xl border border-slate-200">

                            <label class="flex items-center gap-3 cursor-pointer group" for="hasDomain">

                                <div class="relative flex items-center">
                                    <input type="checkbox"
                                        class="peer h-5 w-5 cursor-pointer appearance-none rounded border border-slate-300 bg-white checked:bg-blue-600 checked:border-blue-600 transition-all"
                                        name="has_domain" id="hasDomain" />

                                    <svg class="absolute h-3.5 w-3.5 text-white opacity-0 peer-checked:opacity-100 pointer-events-none left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="4" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>

                                <span class="text-sm font-medium text-slate-600 group-hover:text-slate-900 transition">
                                    Já possuo este domínio registrado (Registro.br, GoDaddy, etc)
                                </span>
                            </label>

                            <p class="mt-2 text-xs text-slate-400 ml-8">
                                *Caso já possua, entraremos em contato para solicitar o apontamento do DNS.
                            </p>
                        </div>
                    </div>

                    <hr class="border-slate-100">

                    <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100">
                        <div class="flex gap-4">
                            <div
                                class="shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">
                                !</div>
                            <div>
                                <h4 class="font-bold text-blue-900 mb-1">Próximo Passo</h4>
                                <p class="text-sm text-blue-800/80 leading-relaxed">
                                    Ao clicar no botão abaixo, seus dados serão enviados e você será direcionado para o
                                    nosso WhatsApp para finalizar a ativação técnica.
                                </p>
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-slate-900 hover:bg-black text-white py-5 rounded-2xl font-extrabold text-lg transition-all shadow-xl shadow-slate-900/20 flex items-center justify-center gap-3">
                        Enviar Informações e Ativar Site

                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <p class="text-center mt-12 text-slate-500 text-sm">
            Dúvidas no preenchimento? <a href="#" class="text-blue-600 font-bold hover:underline">Chame nosso suporte
                técnico.</a>
        </p>
    </main>
</body>

</html>