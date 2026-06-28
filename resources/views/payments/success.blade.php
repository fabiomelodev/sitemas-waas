<x-layout.base-subscription
    title="Pagamento confirmado — Sitemas"
    description="Recebemos seu pagamento. Veja os próximos passos para colocar seu site no ar.">

    <section class="px-6 py-12 md:py-20">
        <div class="max-w-3xl mx-auto">

            <!-- Confirmação -->
            <div class="text-center">
                <div class="mb-8 flex justify-center">
                    <div class="relative">
                        <div class="absolute inset-0 bg-green-200 blur-2xl opacity-50 rounded-full"></div>
                        <div
                            class="relative bg-white border border-slate-200 w-20 h-20 rounded-3xl shadow-sm flex items-center justify-center">
                            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <h1 class="text-4xl font-extrabold tracking-tight text-slate-900 mb-4">
                    Pagamento confirmado! 🚀
                </h1>
                <p class="text-lg text-slate-600 max-w-xl mx-auto">
                    Obrigado por escolher a <strong>Sitemas</strong>. Recebemos seu pagamento e já começamos a preparar
                    o seu site. Veja abaixo o que vem a seguir.
                </p>
            </div>

            <!-- Próximos passos -->
            <div class="bg-white border border-slate-200 rounded-4xl p-8 md:p-10 shadow-sm mt-12">
                <h2 class="text-xl font-bold text-slate-900 mb-8">Seus próximos passos</h2>

                <ol class="relative border-s-2 border-slate-100 ms-3 space-y-8">
                    @php
                        $steps = [
                            [
                                'title' => 'Pagamento confirmado',
                                'text' => 'Tudo certo por aqui — nossa equipe já foi notificada automaticamente.',
                                'state' => 'done',
                            ],
                            [
                                'title' => 'Defina sua senha de acesso',
                                'text' => 'Enviamos um e-mail com um link para você criar sua senha e acessar o painel. Não esqueça de conferir a caixa de spam.',
                                'state' => 'current',
                            ],
                            [
                                'title' => 'Envie seu material',
                                'text' => 'Um consultor entra em contato pelo WhatsApp em até 24 horas úteis para receber seu logotipo e os textos do site (veja o checklist abaixo).',
                                'state' => 'next',
                            ],
                            [
                                'title' => 'Seu site no ar',
                                'text' => 'Após recebermos seu material, configuramos tudo e publicamos seu site em até 24 horas úteis.',
                                'state' => 'next',
                            ],
                        ];
                    @endphp

                    @foreach($steps as $step)
                        <li class="ms-8">
                            <span
                                class="absolute -start-[13px] flex items-center justify-center w-6 h-6 rounded-full ring-4 ring-white
                                @class([
                                    'bg-green-500 text-white' => $step['state'] === 'done',
                                    'bg-blue-600 text-white' => $step['state'] === 'current',
                                    'bg-slate-200 text-slate-500' => $step['state'] === 'next',
                                ])">
                                @if($step['state'] === 'done')
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                        <path
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                                    </svg>
                                @else
                                    <span class="text-xs font-bold">{{ $loop->iteration }}</span>
                                @endif
                            </span>

                            <h3 class="font-bold text-slate-900">{{ $step['title'] }}</h3>
                            <p class="text-sm text-slate-500 mt-1 leading-relaxed">{{ $step['text'] }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Checklist do que preparar -->
            <div class="bg-blue-50/60 border border-blue-100 rounded-4xl p-8 md:p-10 mt-8">
                <h2 class="text-xl font-bold text-slate-900 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    Adiante o processo: prepare seu material
                </h2>
                <p class="text-sm text-slate-600 mb-6">
                    Quanto antes você enviar estes itens, mais rápido seu site fica pronto.
                </p>

                @php
                    $checklist = [
                        'Logotipo (de preferência em PNG com fundo transparente)',
                        'Nome do negócio e uma breve descrição do que você faz',
                        'Textos e serviços que devem aparecer no site',
                        'Fotos do seu trabalho, equipe ou produtos',
                        'Contatos: telefone, e-mail, endereço e redes sociais',
                        'Domínio próprio, caso você já tenha um (ex.: seunegocio.com.br)',
                    ];
                @endphp

                <ul class="grid sm:grid-cols-2 gap-x-8 gap-y-4">
                    @foreach($checklist as $item)
                        <li class="flex items-start gap-3 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                            {{ $item }}
                        </li>
                    @endforeach
                </ul>

                @if($settings->whatsapp)
                    <a href="{{ $settings->whatsapp }}" target="_blank" rel="noopener"
                        class="mt-8 inline-flex items-center justify-center gap-2 w-full bg-[#25D366] hover:bg-[#20ba5a] text-white py-4 rounded-2xl font-bold transition-all shadow-lg shadow-green-900/10">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M12.004 2c-5.525 0-10 4.478-10 10 0 1.777.463 3.445 1.263 4.9L2 22l5.222-1.263C8.61 21.51 10.217 22 12.004 22c5.525 0 10-4.478 10-10s-4.475-10-10-10zm0 18.294c-1.724 0-3.37-.487-4.794-1.407l-.343-.22-3.325.803.818-3.18-.24-.373c-.998-1.545-1.522-3.328-1.522-5.166 0-5.11 4.157-9.267 9.267-9.267 5.108 0 9.264 4.157 9.264 9.267s-4.156 9.267-9.264 9.267z" />
                        </svg>
                        Enviar meu material pelo WhatsApp
                    </a>
                @endif
            </div>

            <!-- Ajuda -->
            <p class="mt-8 text-center text-sm text-slate-500">
                Não recebeu o e-mail para definir sua senha? Verifique a caixa de spam
                @if($settings->whatsapp)
                    ou <a href="{{ $settings->whatsapp }}" target="_blank" rel="noopener"
                        class="text-blue-600 font-semibold hover:underline">fale com o suporte</a>.
                @else
                    e aguarde alguns minutos.
                @endif
            </p>
        </div>
    </section>
</x-layout.base-subscription>
