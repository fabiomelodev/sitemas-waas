<x-layout.base
    title="Sitemas — Sites profissionais por assinatura | Hospedagem, manutenção e suporte"
    description="Escolha um modelo premium, assine um plano e nós cuidamos de tudo: hospedagem, manutenção e suporte. Sem fidelidade, com ativação gratuita e pagamento seguro.">

    <!-- hero -->
    <section class="relative bg-gray-50 py-24 md:py-32 overflow-hidden">

        <div class="max-w-7xl mx-auto px-6 relative z-10 text-center">
            <span
                class="inline-flex items-center rounded-full bg-brand/10 px-4 py-1.5 text-xs font-semibold text-brand ring-1 ring-inset ring-brand/20 mb-6">
                Website as a Service (WaaS)
            </span>

            <h1
                class="text-3xl sm:text-5xl md:text-7xl font-extrabold text-dark-900 tracking-tighter leading-none max-w-4xl mx-auto">
                Seu site profissional no ar, <span class="text-brand">sem dor de cabeça técnica.</span>
            </h1>

            <p class="max-w-2xl leading-relaxed lg:text-xl text-gray-600 mt-8 mx-auto">
                Escolha um modelo premium, assine um plano e nós cuidamos de tudo: hospedagem, manutenção e suporte.
                Simples, rápido e previsível.
            </p>

            <div class="mt-12 flex flex-col sm:flex-row items-center justify-center gap-6">
                <a href="#modelos"
                    class="w-full sm:w-auto bg-brand text-white px-8 py-4 rounded-xl font-bold hover:bg-brand-dark transition shadow-lg shadow-brand/20 transform hover:-translate-y-0.5">
                    Explorar Modelos
                </a>

                <a href="#planos"
                    class="w-full sm:w-auto text-dark-900 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition flex justify-center items-center gap-2 group">
                    Ver Planos

                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
        </div>

        <div class="absolute inset-0 z-0 opacity-30">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="dotted-pattern" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle cx="2" cy="2" r="1" fill="#cbd5e1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#dotted-pattern)" />
            </svg>
        </div>
    </section>
    <!-- end hero -->

    <livewire:list-templates />

    <section class="py-10 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div
                class="border border-gray-100 rounded-2xl p-6 grid grid-cols-2 lg:grid-cols-4 gap-6 shadow-sm bg-gray-50/50">
                @php
                    $trustItems = [
                        ['title' => 'Sem fidelidade', 'subtitle' => 'Cancele quando quiser'],
                        ['title' => 'Ativação gratuita', 'subtitle' => 'R$ 0,00 para começar'],
                        ['title' => 'Suporte humano', 'subtitle' => 'Atendimento via WhatsApp'],
                        ['title' => 'Pagamento seguro', 'subtitle' => 'Processado pela Asaas'],
                    ];
                @endphp

                @foreach($trustItems as $item)
                    <div class="flex items-center gap-3">
                        <div
                            class="shrink-0 w-9 h-9 rounded-full bg-brand/10 text-brand flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-dark-900 leading-tight">{{ $item['title'] }}</p>
                            <p class="text-xs text-gray-500">{{ $item['subtitle'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- problema -> solução -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16 max-w-2xl mx-auto">
                <span class="text-sm font-bold text-brand uppercase tracking-widest">O dilema de quem empreende</span>
                <h2 class="text-4xl font-extrabold text-dark-900 tracking-tight mt-3">
                    Ter um site profissional não devia ser tão complicado
                </h2>
            </div>

            <div class="grid lg:grid-cols-2 gap-8 items-stretch">
                <!-- o jeito antigo -->
                <div class="rounded-3xl border border-gray-100 bg-gray-50 p-8 md:p-10">
                    <h3 class="text-lg font-bold text-gray-500 mb-8 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-gray-300"></span>
                        Do jeito antigo
                    </h3>

                    @php
                        $painPoints = [
                            'Orçamentos de agência caros e imprevisíveis',
                            'Meses de espera para o site sair do papel',
                            'Quando algo quebra, ninguém dá manutenção',
                            'Ferramentas "faça você mesmo" que tomam o tempo que você não tem',
                        ];
                    @endphp

                    <ul class="space-y-5">
                        @foreach($painPoints as $pain)
                            <li class="flex items-start gap-3 text-gray-500">
                                <svg class="w-5 h-5 mt-0.5 shrink-0 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                {{ $pain }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- com a sitemas -->
                <div class="rounded-3xl bg-dark-900 p-8 md:p-10 shadow-xl">
                    <h3 class="text-lg font-bold text-white mb-8 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-brand"></span>
                        Com a Sitemas
                    </h3>

                    @php
                        $solutions = [
                            'Uma mensalidade fixa e previsível, sem surpresas',
                            'Seu site no ar em dias, não em meses',
                            'Hospedagem, manutenção e suporte sempre inclusos',
                            'A nossa equipe faz tudo por você, do início ao fim',
                        ];
                    @endphp

                    <ul class="space-y-5">
                        @foreach($solutions as $solution)
                            <li class="flex items-start gap-3 text-gray-100">
                                <svg class="w-5 h-5 mt-0.5 shrink-0 text-brand" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                {{ $solution }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section id="planos" class="py-24 bg-gray-50">

        <div class="max-w-7xl mx-auto px-6">

            <div class="text-center mb-16">

                <h2 class="text-4xl font-extrabold text-dark-900 tracking-tight">
                    Planos Simples e Transparentes
                </h2>

                <p class="max-w-xl lg:text-lg text-gray-600 mt-4 mx-auto">
                    Tudo o que você precisa para manter sua presença
                    online ativa, sem custos surpresas.
                </p>
            </div>

            <div class="flex justify-center mb-8">
                <div
                    class="inline-flex items-center gap-2 bg-green-100 border border-green-200 px-4 py-2 rounded-full shadow-sm">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>

                    <span class="text-green-800 text-xs font-bold uppercase tracking-wider">
                        Aproveite: R$ 0,00 de taxa de ativação
                    </span>
                </div>
            </div>

            <div class="grid lg:grid-cols-3 gap-8 mx-auto items-start mt-16">

                @foreach($plans as $plan)
                    @if($plan->is_recommended)
                        <x-plan-item-recommended :plan="$plan" />
                    @else
                        <x-plan-item :plan="$plan" />
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <section id="como-funciona" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-dark-900 tracking-tight">Como Funciona</h2>
                <p class="mt-4 text-lg text-gray-600">Do início ao fim, um processo transparente e sem burocracia.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-12">
                <div class="relative text-center">
                    <div
                        class="w-16 h-16 bg-brand text-white rounded-2xl flex items-center justify-center text-2xl font-bold mx-auto mb-6 shadow-lg shadow-brand/20">
                        1</div>
                    <h3 class="text-xl font-bold text-dark-900 mb-3">Escolha o Modelo</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Navegue por nossa vitrine e selecione o modelo
                        que
                        melhor se adapta ao seu nicho de atuação.</p>
                </div>

                <div class="relative text-center">
                    <div
                        class="w-16 h-16 bg-brand text-white rounded-2xl flex items-center justify-center text-2xl font-bold mx-auto mb-6 shadow-lg shadow-brand/20">
                        2</div>
                    <h3 class="text-xl font-bold text-dark-900 mb-3">Assine um Plano</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Escolha entre os planos Start ou Pro. O pagamento é
                        via
                        Asaas, com toda a segurança e praticidade.</p>
                </div>

                <div class="relative text-center">
                    <div
                        class="w-16 h-16 bg-brand text-white rounded-2xl flex items-center justify-center text-2xl font-bold mx-auto mb-6 shadow-lg shadow-brand/20">
                        3</div>
                    <h3 class="text-xl font-bold text-dark-900 mb-3">Site no Ar</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Após o envio do seu conteúdo, nossa equipe
                        configura
                        tudo e entrega seu site pronto para vender.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- comparativo -->
    <section class="py-24 bg-white">
        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center mb-16 max-w-2xl mx-auto">
                <span class="text-sm font-bold text-brand uppercase tracking-widest">Compare e decida</span>
                <h2 class="text-4xl font-extrabold text-dark-900 tracking-tight mt-3">
                    Por que a assinatura compensa
                </h2>
                <p class="lg:text-lg text-gray-600 mt-4">
                    O mesmo resultado profissional, sem o custo alto e a dor de cabeça das outras opções.
                </p>
            </div>

            <div class="overflow-x-auto rounded-3xl border border-gray-100 shadow-sm">
                <table class="w-full min-w-[640px] text-sm">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50">
                            <th class="text-left font-semibold text-gray-500 p-5 w-1/3">Critério</th>
                            <th class="text-center font-semibold text-gray-500 p-5">Fazer sozinho</th>
                            <th class="text-center font-semibold text-gray-500 p-5">Agência tradicional</th>
                            <th class="text-center font-bold text-brand p-5 bg-brand/5">Sitemas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                            $comparison = [
                                ['Custo para começar', 'Seu tempo', 'R$ 3.000+', 'R$ 0'],
                                ['Mensalidade previsível', '—', 'Raramente', 'Incluída'],
                                ['Hospedagem inclusa', 'Você gerencia', 'Custo à parte', 'Sim'],
                                ['Manutenção e suporte', 'Por sua conta', 'Cobrada por hora', 'Sempre inclusos'],
                                ['Tempo até publicar', 'Semanas', '1 a 2 meses', 'Poucos dias'],
                                ['Precisa saber de tecnologia', 'Sim', 'Não', 'Não'],
                            ];
                        @endphp

                        @foreach($comparison as $row)
                            <tr>
                                <td class="p-5 font-semibold text-dark-900">{{ $row[0] }}</td>
                                <td class="p-5 text-center text-gray-500">{{ $row[1] }}</td>
                                <td class="p-5 text-center text-gray-500">{{ $row[2] }}</td>
                                <td class="p-5 text-center font-bold text-dark-900 bg-brand/5">{{ $row[3] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-12">
                <a href="#planos"
                    class="inline-flex bg-brand text-white px-8 py-4 rounded-xl font-bold hover:bg-brand-dark transition shadow-lg shadow-brand/20">
                    Ver planos e começar
                </a>
            </div>
        </div>
    </section>

    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div
                class="bg-brand/5 border border-brand/10 rounded-3xl p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="max-w-xl">
                    <h3 class="text-2xl font-bold text-dark-900">Precisa de urgência?</h3>
                    <p class="mt-2 text-gray-600">Assinando hoje até às 14h, nossa equipe entra em contato no mesmo dia
                        para iniciar a configuração do seu modelo.</p>
                </div>

                @if($settings->whatsapp)
                    <a href="{{ $settings->whatsapp }}" target="_blank" rel="noopener"
                        class="shrink-0 inline-flex items-center gap-2.5 bg-green-600 hover:bg-green-700 text-white px-6 py-3.5 rounded-xl font-bold transition shadow-lg shadow-green-900/10">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.004 2c-5.525 0-10 4.478-10 10 0 1.777.463 3.445 1.263 4.9L2 22l5.222-1.263C8.61 21.51 10.217 22 12.004 22c5.525 0 10-4.478 10-10s-4.475-10-10-10zm0 18.294c-1.724 0-3.37-.487-4.794-1.407l-.343-.22-3.325.803.818-3.18-.24-.373c-.998-1.545-1.522-3.328-1.522-5.166 0-5.11 4.157-9.267 9.267-9.267 5.108 0 9.264 4.157 9.264 9.267s-4.156 9.267-9.264 9.267z" />
                        </svg>
                        Falar com um especialista
                    </a>
                @else
                    <a href="#planos"
                        class="shrink-0 inline-flex items-center gap-2.5 bg-brand hover:bg-brand-dark text-white px-6 py-3.5 rounded-xl font-bold transition shadow-lg shadow-brand/20">
                        Ver Planos
                    </a>
                @endif
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-6">
            <div class="text-center mb-12">
                <h3 class="text-2xl font-bold text-dark-900 tracking-tight">O que acontece após sua assinatura?</h3>
                <p class="text-gray-600 mt-2">Nossa prioridade é colocar seu negócio no mapa em tempo recorde.</p>
            </div>

            <div class="relative">
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-gray-100 -translate-y-1/2 z-0">
                </div>

                <div class="grid md:grid-cols-4 gap-8 relative z-10">
                    <div class="bg-white p-4 text-center">
                        <div
                            class="w-12 h-12 bg-white border-2 border-brand text-brand rounded-full flex items-center justify-center font-bold mx-auto mb-4 shadow-sm">
                            01</div>
                        <h4 class="font-bold text-dark-900 text-sm">Confirmação</h4>
                        <p class="text-xs text-gray-500 mt-1">Acesso imediato ao nosso WhatsApp.</p>
                    </div>
                    <div class="bg-white p-4 text-center">
                        <div
                            class="w-12 h-12 bg-white border-2 border-brand text-brand rounded-full flex items-center justify-center font-bold mx-auto mb-4 shadow-sm">
                            02</div>
                        <h4 class="font-bold text-dark-900 text-sm">Briefing</h4>
                        <p class="text-xs text-gray-500 mt-1">Você envia sua logo e textos básicos.</p>
                    </div>
                    <div class="bg-white p-4 text-center">
                        <div
                            class="w-12 h-12 bg-white border-2 border-brand text-brand rounded-full flex items-center justify-center font-bold mx-auto mb-4 shadow-sm">
                            03</div>
                        <h4 class="font-bold text-dark-900 text-sm">Ajustes</h4>
                        <p class="text-xs text-gray-500 mt-1">Personalizamos o modelo com sua marca.</p>
                    </div>
                    <div class="bg-white p-4 text-center">
                        <div
                            class="w-12 h-12 bg-brand text-white rounded-full flex items-center justify-center font-bold mx-auto mb-4 shadow-lg">
                            04</div>
                        <h4 class="font-bold text-dark-900 text-sm">Lançamento</h4>
                        <p class="text-xs text-gray-500 mt-1">Seu site no ar em até 24h úteis.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout.base>