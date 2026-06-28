<div>
    <section id="faq" class="py-24 bg-white">

        <div class="max-w-4xl mx-auto px-6">

            <div class="text-center mb-16">

                <h2 class="text-4xl font-extrabold text-dark-900 tracking-tight text-center">
                    Perguntas Frequentes
                </h2>

                <p class="lg:text-lg text-gray-600 mt-4">
                    Tire suas dúvidas sobre como funciona nossa assinatura de sites.
                </p>
            </div>

            <div class="space-y-4">
                @foreach($faqs as $faq)
                    <details
                        class="group border border-gray-100 rounded-2xl bg-gray-50 p-6 [&_summary::-webkit-details-marker]:hidden">
                        <summary class="flex items-center justify-between cursor-pointer">
                            <h3 class="text-lg font-bold text-dark-900">
                                {{  $faq->name }}
                            </h3>

                            <span class="ml-1.5 shrink-0 transition duration-300 group-open:-rotate-180">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>

                        <p class="mt-4 leading-relaxed text-gray-600 text-sm">
                            {{ $faq->description }}
                        </p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-24 bg-white border-t border-gray-100">

        <div class="max-w-4xl mx-auto px-6 text-center">

            <h2 class="text-4xl md:text-5xl font-extrabold text-dark-900 tracking-tighter leading-tight">
                Pronto Para Profissionalizar Sua Presença Digital?
            </h2>

            <p class="lg:text-lg text-gray-600 mt-6">
                Escolha seu modelo e deixe toda a complexidade técnica com a gente. Simples, rápido e sem contratos de
                fidelidade.
            </p>

            <div class="flex flex-col lg:flex-row items-center justify-center gap-6 mt-12">

                <a href="#modelos"
                    class="bg-dark-900 text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-800 transition shadow-md">
                    Escolher Meu Modelo
                </a>

                @if($settings->whatsapp)
                    <a href="{{  $settings->whatsapp }}" target="_blank"
                        class="text-green-500 px-8 py-4 rounded-xl font-semibold hover:bg-brand/5 transition flex items-center gap-2.5">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.004 2c-5.525 0-10 4.478-10 10 0 1.777.463 3.445 1.263 4.9L2 22l5.222-1.263C8.61 21.51 10.217 22 12.004 22c5.525 0 10-4.478 10-10s-4.475-10-10-10zm0 18.294c-1.724 0-3.37-.487-4.794-1.407l-.343-.22-3.325.803.818-3.18-.24-.373c-.998-1.545-1.522-3.328-1.522-5.166 0-5.11 4.157-9.267 9.267-9.267 5.108 0 9.264 4.157 9.264 9.267s-4.156 9.267-9.264 9.267zm5.335-6.708c-.292-.146-1.73-.854-1.997-.953-.267-.098-.462-.146-.657.146-.195.293-.755.953-.926 1.148-.17.195-.341.219-.633.073-.292-.147-1.23-.453-2.344-1.447-.866-.77-1.452-1.723-1.622-2.015-.17-.292-.018-.45.127-.595.13-.13.292-.341.438-.512.147-.171.195-.293.292-.488.097-.195.048-.366-.024-.512-.072-.147-.657-1.586-.901-2.172-.236-.57-.478-.492-.657-.502-.167-.008-.36-.01-.555-.01-.195 0-.512.073-.78.366-.268.293-1.023 1.002-1.023 2.443 0 1.44 1.047 2.833 1.194 3.028.147.195 2.06 3.14 4.99 4.413.697.303 1.24.484 1.66.617.7.223 1.338.19 1.843.115.56-.083 1.73-.707 1.974-1.39.244-.683.244-1.268.17-1.39-.073-.122-.269-.195-.561-.341z">
                            </path>
                        </svg>

                        Tirar Dúvidas
                    </a>
                @endif
            </div>
        </div>
    </section>

    <footer class="py-16 bg-white border-t border-gray-100">

        <div class="max-w-7xl mx-auto px-6">

            <div class="grid md:grid-cols-3 gap-12 mb-12">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-6 h-6 bg-brand rounded-full flex items-center justify-center"><span
                                class="text-white text-[10px] font-bold">S</span></div>
                        <span class="text-xl font-bold text-dark-900">Site<span class="text-brand">mas</span></span>
                    </div>

                    <p class="text-sm text-gray-500 leading-relaxed">
                        Especialistas em WaaS (Website as a Service). Transformando empresas através de design de alta
                        performance e tecnologia simplificada.
                    </p>
                </div>

                <div class="flex flex-col gap-4">
                    <h5 class="text-sm font-bold text-dark-900 uppercase tracking-widest mb-2">
                        Siga a Sitemas
                    </h5>

                    <p class="text-sm text-gray-500 italic">
                        Acompanhe nossas novidades:
                    </p>

                    <div class="flex items-center gap-4">
                        @if($settings->instagram)
                            <a href="{{  $settings->instagram }}" target="_blank"
                                class="group flex items-center gap-2 text-sm font-semibold text-gray-700 hover:text-brand transition-all">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-brand/10 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.332 3.608 1.308.975.975 1.245 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.332 2.633-1.308 3.608-.975.975-2.242 1.245-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.332-3.608-1.308-.975-.975-1.245-2.242-1.308-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.062-1.366.332-2.633 1.308-3.608.975-.975 2.242-1.245 3.608-1.308 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948s.014 3.667.072 4.947c.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072s3.667-.014 4.947-.072c4.358-.2 6.78-2.618 6.98-6.98.058-1.281.072-1.689.072-4.948s-.014-3.667-.072-4.947c-.2-4.358-2.618-6.78-6.98-6.98-1.28-.058-1.689-.072-4.948-.072zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                    </svg>
                                </div>
                                Instagram
                            </a>
                        @endif

                        @if($settings->facebook)
                            <a href="{{  $settings->facebook }}" target="_blank"
                                class="group flex items-center gap-2 text-sm font-semibold text-gray-700 hover:text-brand transition-all">
                                <div
                                    class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-brand/10 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                                    </svg>
                                </div>
                                Facebook
                            </a>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <h5 class="text-sm font-bold text-dark-900 uppercase tracking-widest">
                        Segurança & Pagamentos
                    </h5>

                    <div class="flex items-center gap-4 opacity-70 grayscale hover:grayscale-0 transition-all">

                        <div class="flex flex-col border border-gray-200 px-3 py-1 rounded bg-gray-50">
                            <span class="text-[8px] text-gray-400 uppercase font-bold">Processado por</span>
                            <span class="text-sm font-extrabold text-blue-600 italic">Asaas</span>
                        </div>

                        <div class="flex flex-col border border-gray-200 px-3 py-1 rounded bg-gray-50">
                            <span class="text-[8px] text-gray-400 uppercase font-bold">Proteção</span>
                            <span class="text-sm font-extrabold text-green-600">SSL ATIVO</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-8 border-t border-gray-50 text-center">
                <p class="text-xs text-gray-400">
                    &copy; {{ date('Y') }} Sitemas — Todos os direitos reservados.
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    Desenvolvido por <span class="font-semibold text-gray-500">Single Temas</span>
                </p>
            </div>
        </div>
    </footer>
</div>