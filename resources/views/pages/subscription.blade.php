<x-layout.base-subscription
    :title="'Assinar ' . $template->name . ' — Sitemas'"
    :description="$template->excerpt"
    :image="$template->thumbnail ? \Illuminate\Support\Facades\Storage::url($template->thumbnail) : null">

    <section class="max-w-5xl mx-auto px-6 py-12 md:py-20"
        x-data="{ open: false, name: '', email: '', phone: '', cpf_cnpj: '' }">
        <div class="grid md:grid-cols-12 gap-12 items-start">

            <div class="md:col-span-7">
                <h1 class="text-3xl font-extrabold tracking-tight text-slate-900 mb-8">
                    Ótima escolha! Vamos configurar seu site.
                </h1>

                <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                    <div class="aspect-video bg-slate-100 relative group">
                        @if($template->thumbnail)
                            <img src="{{ Storage::url($template->thumbnail) }}" alt="Modelo Selecionado"
                                class="w-full h-full object-cover">
                        @endif

                        <div class="absolute inset-0 bg-linear-to-t from-black/60 to-transparent flex items-end p-6">
                            <span class="text-white font-bold text-lg">
                                Modelo: {{ $template->name }}
                            </span>
                        </div>
                    </div>

                    <div class="p-8">
                        <p class="text-sm text-gray-600 mb-4">
                            {{ $template->excerpt }}
                        </p>

                        <h3 class="font-bold text-slate-900 mb-4 italic">
                            O que está incluso neste design:
                        </h3>

                        @if($template->features)
                            <ul class="grid grid-cols-2 gap-4">

                                @foreach($template->features as $feature)
                                    <li class="flex items-center gap-2 text-sm text-slate-600">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $feature['name'] }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <div class="md:col-span-5 sticky top-28">
                <div
                    class="bg-slate-900 rounded-3xl p-8 shadow-xl shadow-blue-900/10 border border-slate-800 text-white">
                    @if($plan->is_recommended)
                        <span
                            class="bg-blue-600 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest mb-4 inline-block">
                            Plano Recomendado
                        </span>
                    @endif

                    <h2 class="text-2xl font-bold mb-2">
                        {{  $plan->name }}
                    </h2>

                    <p class="text-slate-400 text-sm mb-6">
                        Tudo o que você precisa para este modelo profissional.
                    </p>

                    <div class="flex items-baseline gap-1 mb-8">
                        <span class="text-4xl font-extrabold tracking-tighter">
                            {{ \App\Helpers\FormatCurrency::getFormatCurrency($plan->price) }}</span>
                        <span class="text-slate-400 text-sm">/mês</span>
                    </div>

                    <div class="space-y-4 mb-10">
                        @foreach($plan->features as $feature)
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-sm text-slate-200">
                                    {{ $feature['name'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <button @click="open = true"
                        class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-4 rounded-xl font-bold transition shadow-lg shadow-blue-900/20 cursor-pointer mb-4">
                        Assinar Agora e Começar
                    </button>

                    <p class="text-[11px] text-slate-500 text-center flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Pagamento seguro via Asaas
                    </p>
                </div>

                <div class="mt-6 p-6 bg-white border border-slate-200 rounded-3xl flex items-center gap-4">
                    <div
                        class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.004 2c-5.525 0-10 4.478-10 10 0 1.777.463 3.445 1.263 4.9L2 22l5.222-1.263C8.61 21.51 10.217 22 12.004 22c5.525 0 10-4.478 10-10s-4.475-10-10-10zm0 18.294c-1.724 0-3.37-.487-4.794-1.407l-.343-.22-3.325.803.818-3.18-.24-.373c-.998-1.545-1.522-3.328-1.522-5.166 0-5.11 4.157-9.267 9.267-9.267 5.108 0 9.264 4.157 9.264 9.267s-4.156 9.267-9.264 9.267zm5.335-6.708c-.292-.146-1.73-.854-1.997-.953-.267-.098-.462-.146-.657.146-.195.293-.755.953-.926 1.148-.17.195-.341.219-.633.073-.292-.147-1.23-.453-2.344-1.447-.866-.77-1.452-1.723-1.622-2.015-.17-.292-.018-.45.127-.595.13-.13.292-.341.438-.512.147-.171.195-.293.292-.488.097-.195.048-.366-.024-.512-.072-.147-.657-1.586-.901-2.172-.236-.57-.478-.492-.657-.502-.167-.008-.36-.01-.555-.01-.195 0-.512.073-.78.366-.268.293-1.023 1.002-1.023 2.443 0 1.44 1.047 2.833 1.194 3.028.147.195 2.06 3.14 4.99 4.413.697.303 1.24.484 1.66.617.7.223 1.338.19 1.843.115.56-.083 1.73-.707 1.974-1.39.244-.683.244-1.268.17-1.39-.073-.122-.269-.195-.561-.341z">
                            </path>
                        </svg>
                    </div>

                    @if($settings->whatsapp)
                        <div>
                            <p class="text-xs text-slate-500">Ficou com dúvida?</p>

                            <a href="{{ $settings->whatsapp }}"
                                class="text-sm font-bold text-slate-900 hover:text-green-600 transition">
                                Fale conosco pelo WhatsApp
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" x-cloak>

            <div @click.away="open = false" class="bg-white rounded-xl shadow-2xl max-w-md w-full p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Quase lá! 🚀</h3>
                <p class="text-gray-600 mb-6">
                    Informe seu e-mail e Whatsapp para vincularmos ao modelo escolhido e prosseguir para o
                    pagamento seguro.
                </p>

                <form action="{{  route('subscription.checkout', ['plan' => $plan, 'template' => $template]) }}"
                    method="POST">
                    @csrf

                    @error('message')
                        <p class="mb-4 text-sm text-red-600 bg-red-50 border border-red-100 rounded-lg p-3">
                            {{ $message }}
                        </p>
                    @enderror

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="name">
                            Seu nome completo
                        </label>

                        <input type="text" name="name" id="name" required placeholder="Maria da Silva"
                            x-model="name" value="{{ old('name') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-4">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="email">
                            Seu melhor e-mail
                        </label>

                        <input type="email" name="email" id="email" required placeholder="exemplo@email.com"
                            x-model="email" value="{{ old('email') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-4">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="phone">
                            Seu Whatsapp
                        </label>

                        <input type="text" name="phone" id="phone" required placeholder="(11) 91234-5678"
                            x-model="phone" value="{{ old('phone') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-4">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="cpf_cnpj">
                            CPF ou CNPJ
                        </label>

                        <input type="text" name="cpf_cnpj" id="cpf_cnpj" required placeholder="000.000.000-00"
                            x-model="cpf_cnpj" value="{{ old('cpf_cnpj') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 py-2 px-4">

                        <p class="mt-1 text-[11px] text-gray-400">Necessário para emissão da cobrança.</p>
                    </div>

                    <div class="flex flex-col gap-3">
                        <button type="submit" :disabled="!name || !email || !phone || !cpf_cnpj"
                            class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                            Ir para Pagamento Seguro
                        </button>

                        <button @click="open = false" type="button" class="text-gray-500 text-sm hover:underline">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>


</x-layout.base-subscription>