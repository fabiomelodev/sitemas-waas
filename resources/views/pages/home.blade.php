<x-layout.base>
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
                class="bg-amber-50 border border-amber-100 rounded-2xl p-4 flex flex-col md:flex-row items-center justify-center gap-4 shadow-sm">
                <div class="flex items-center gap-2">
                    <span class="relative flex h-3 w-3">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                    </span>
                    <p class="text-amber-900 text-sm font-medium text-center md:text-left">
                        <span class="font-bold">Atenção:</span> Devido à alta demanda de manutenção, restam apenas <span
                            class="bg-amber-200 px-2 py-0.5 rounded text-amber-900 font-extrabold">3 vagas</span> para
                        novos projetos esta semana.
                    </p>
                </div>
                <a href="#modelos"
                    class="text-amber-900 text-sm font-bold underline decoration-amber-300 hover:decoration-amber-500 transition-all">
                    Garantir minha vaga agora &rarr;
                </a>
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

                {{-- @if(isset($planStart))
                <div class="bg-white p-8 md:p-10 rounded-3xl border border-gray-100 shadow-sm relative">
                    <h3 class="text-2xl font-bold text-dark-900 tracking-tight">
                        {{ $planStart->name }}
                    </h3>

                    <p class="mt-2 text-gray-600 text-sm">
                        {!! $planStart->description !!}
                    </p>

                    <div class="mt-6 flex items-baseline gap-1">
                        <span class="text-5xl font-extrabold text-dark-900 tracking-tighter">R$
                            {{ $planStart->price }}
                        </span>

                        <span class="text-gray-500 text-sm font-medium">/mês</span>
                    </div>

                    <ul class="mt-10 space-y-4 text-sm text-gray-700">
                        @foreach($planStart->features as $feature)
                        <li class=" flex items-center gap-3 {{  $feature['status'] == 0 ? 'text-gray-400' : '' }}">
                            @if($feature['status'])
                            <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            @else
                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            @endif

                            {{ $feature['name'] }}
                        </li>
                        @endforeach
                    </ul>

                    <button x-data
                        @click="$dispatch('trigger-plan-filter', { id: 1 }); document.getElementById('modelos').scrollIntoView({ behavior: 'smooth' })"
                        class="w-full transition py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold cursor-pointer mt-12">
                        Ver Modelos Start
                    </button>
                </div>
                @endif

                @if($planPro)
                <div
                    class="bg-dark-900 p-8 md:p-10 rounded-3xl border border-dark-700 shadow-xl relative transform lg:scale-105">
                    <span
                        class="absolute -top-4 right-8 bg-brand text-white text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider">
                        Mais Popular
                    </span>

                    <h3 class="text-2xl font-bold text-white tracking-tight">
                        {{ $planPro->name }}
                    </h3>

                    <p class="mt-2 text-gray-300 text-sm">
                        {{ $planPro->description }}
                    </p>

                    <div class="mt-6 flex items-baseline gap-1">
                        <span class="text-5xl font-extrabold text-white tracking-tighter">R$
                            {{ $planPro->price }}</span>
                        <span class="text-gray-400 text-sm font-medium">/mês</span>
                    </div>

                    <ul class="mt-10 space-y-4 text-sm text-gray-200">
                        @foreach($planPro->features as $feature)
                        <li class=" flex items-center gap-3 {{  $feature['status'] == 0 ? 'text-gray-400' : '' }}">
                            @if($feature['status'])
                            <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            @else
                            <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            @endif

                            {{ $feature['name'] }}
                        </li>
                        @endforeach
                    </ul>

                    <button x-data
                        @click="$dispatch('trigger-plan-filter', { id: 2 }); document.getElementById('modelos').scrollIntoView({ behavior: 'smooth' })"
                        class="w-full transition py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold cursor-pointer mt-12">
                        Ver Modelos Pro
                    </button>
                </div>
                @endif --}}

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

    <section class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div
                class="bg-brand/5 border border-brand/10 rounded-3xl p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="max-w-xl">
                    <h3 class="text-2xl font-bold text-dark-900">Precisa de urgência?</h3>
                    <p class="mt-2 text-gray-600">Assinando hoje até às 14h, nossa equipe entra em contato no mesmo dia
                        para iniciar a configuração do seu modelo.</p>
                </div>
                <div class="flex -space-x-2 overflow-hidden">
                    <img class="inline-block h-12 w-12 rounded-full ring-2 ring-white"
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="">
                    <img class="inline-block h-12 w-12 rounded-full ring-2 ring-white"
                        src="https://images.unsplash.com/photo-1491528323818-fdd1faba62cc?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="">
                    <img class="inline-block h-12 w-12 rounded-full ring-2 ring-white"
                        src="https://images.unsplash.com/photo-1550525811-e5869dd03032?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="">
                    <div
                        class="flex items-center justify-center h-12 px-4 rounded-full bg-white border border-gray-100 text-xs font-bold text-gray-600">
                        +12 sites esta semana</div>
                </div>
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