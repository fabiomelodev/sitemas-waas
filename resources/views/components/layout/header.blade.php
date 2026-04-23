<header class="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-gray-100">

    <nav class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <a class="flex items-center gap-2" href="{{  route('home') }}">
            <div class="w-8 h-8 bg-brand rounded-full flex items-center justify-center shadow-md">
                <span class="text-white font-bold text-lg">S</span>
            </div>
            <span class="text-2xl font-extrabold text-dark-900 tracking-tight">
                Site<span class="text-brand">mas</span></span>
        </a>

        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-700">
            <a href="#modelos" class="hover:text-brand transition">Modelos</a>
            <a href="#planos" class="hover:text-brand transition">Planos</a>
            <a href="#como-funciona" class="hover:text-brand transition">Como Funciona</a>
            <a href="#faq" class="hover:text-brand transition">FAQ</a>
        </div>

        <div class="flex items-center gap-4">
            @if($settings->whatsapp)
                <a href="{{  $settings->whatsapp }}" target="_blank"
                    class="text-sm font-semibold text-brand hover:text-brand-dark transition">
                    Suporte
                </a>
            @endif

            <a href="#planos"
                class="bg-dark-900 text-white px-5 py-2.5 rounded-full text-sm font-semibold hover:bg-gray-800 transition shadow-sm">
                Começar Agora
            </a>
        </div>
    </nav>
</header>