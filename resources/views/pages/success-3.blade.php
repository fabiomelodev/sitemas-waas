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

    <main class="max-w-3xl mx-auto px-6 py-12 md:py-20">

        <div class="text-center mb-12">
            <div
                class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight mb-4">Pagamento Confirmado!</h1>
            <p class="text-slate-600 text-lg">Seja bem-vindo à Sitemas. Agora, vamos colocar seu site no ar.</p>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            <div class="bg-slate-900 p-6 text-white">
                <h2 class="text-lg font-bold">Etapa Final: Informações do Site</h2>
                <p class="text-slate-400 text-sm">Preencha os dados abaixo para iniciarmos a configuração do seu modelo.
                </p>
            </div>

            <form class="p-8 space-y-6">

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Nome da Empresa / Projeto</label>
                        <input type="text" placeholder="Ex: Advocacia Silva"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">WhatsApp de Contato</label>
                        <input type="text" placeholder="(11) 99999-0000"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Domínio Desejado</label>
                        <input type="text" placeholder="exemplo.com.br"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                        <p class="text-[10px] text-slate-400 mt-1 italic">Se já possuir um domínio, informe qual é.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Logotipo (Link ou Nome)</label>
                        <input type="text" placeholder="Envie o link ou anexe no WhatsApp depois"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2">Observações / Cores da Marca</label>
                    <textarea rows="3" placeholder="Ex: Gostaria de usar tons de azul escuro e dourado..."
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-600 focus:outline-none transition"></textarea>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-2 text-lg">
                        Enviar Dados e Finalizar
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </button>
                    <p class="text-center text-slate-400 text-xs mt-4">
                        Ao clicar, você será redirecionado para o nosso suporte oficial.
                    </p>
                </div>
            </form>
        </div>

        <div class="mt-8 text-center">
            <p class="text-slate-500 text-sm">
                Teve algum problema com o formulário?
                <a href="#" class="text-blue-600 font-semibold hover:underline">Fale conosco agora pelo WhatsApp</a>
            </p>
        </div>

    </main>

    <footer class="py-10 text-center">
        <p class="text-xs text-slate-400">&copy; 2026 Sitemas - Tecnologia para pequenos negócios.</p>
    </footer>

</body>

</html>