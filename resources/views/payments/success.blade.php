<x-layout.base-subscription>
    <section class="min-h-[80vh] flex items-center justify-center px-6 py-12">
        <div class="max-w-2xl w-full text-center">

            <!-- Icon Initial State -->
            <div class="mb-8 flex justify-center">
                <div class="relative">
                    <div class="absolute inset-0 bg-green-200 blur-2xl opacity-50 rounded-full"></div>
                    <div
                        class="relative bg-white border border-slate-200 w-20 h-20 rounded-3xl shadow-sm flex items-center justify-center">
                        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 mb-4">
                Pagamento confirmado! 🚀
            </h1>
            <p class="text-lg text-slate-600 mb-10">
                Obrigado por escolher a <strong>Single Temas</strong>. Seu ambiente de desenvolvimento já está sendo
                preparado.
            </p>

            <!-- Instructions Card -->
            <div
                class="bg-white border border-slate-200 rounded-4xl p-8 md:p-10 shadow-sm text-left relative overflow-hidden">
                <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    O que acontece agora?
                </h2>

                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">Confirmamos seu pagamento</p>
                            <p class="text-sm text-slate-500">Nosso sistema já notificou nossa equipe técnica.</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 004.812 4.812l.774-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900">Entraremos em contato</p>
                            <p class="text-sm text-slate-500">Em até 24h, um consultor da <strong>Sitemas</strong>
                                chamará você no WhatsApp para solicitar o logotipo e os dados básicos para iniciarmos a
                                configuração.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-8 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-400 mb-4 uppercase tracking-widest font-bold">Quer agilizar?</p>
                    <a href="{{ $settings->whatsapp }}"
                        class="inline-flex items-center justify-center gap-2 w-full bg-[#25D366] hover:bg-[#20ba5a] text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-green-900/10">
                        Chamar suporte agora
                    </a>
                </div>
            </div>

            <!-- Help Footer -->
            <p class="mt-8 text-sm text-slate-500">
                Não recebeu o e-mail? Verifique sua caixa de spam ou
                <a href="{{ $settings->whatsapp ?? '#' }}" class="text-blue-600 font-semibold hover:underline">fale
                    conosco no suporte</a>.
            </p>
        </div>
    </section>
</x-layout.base-subscription>