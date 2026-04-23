<?php

use Livewire\Component;
use Illuminate\Support\Collection;
use App\Models\{Category, Template};

new class extends Component {
    public Collection $categories;

    public Collection $templates;

    public function mount()
    {
        $this->getCategories();

        $this->getTemplates();
    }

    public function getCategories()
    {
        $this->categories = Category::all();
        ;
    }

    public function getTemplates()
    {
        $this->templates = Template::all();
    }

    public function getTemplatesByCategory($categoryId)
    {
        $this->templates = Template::where('category_id', $categoryId)->get();
    }
};
?>

<div>
    <section id="modelos" class="pt-24 pb-0 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-dark-900 tracking-tight">Nossos Templates Premium</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-xl mx-auto">Designs modernos, responsivos e otimizados para
                    conversão em qualquer dispositivo.</p>
            </div>

            <div class="mt-10 flex flex-wrap items-center justify-center gap-3" x-data="{ activeCategory: 'all' }">
                <button
                    class="px-6 py-2 rounded-full text-sm font-semibold bg-brand text-white shadow-md shadow-brand/20 transition-all hover:bg-brand-dark"
                    wire:click="getTemplates()" x-on:click="activeCategory = 'all'">
                    Todos
                </button>

                @foreach($categories as $category)
                    <button
                        class="px-6 py-2 rounded-full text-sm font-semibold text-gray-600 hover:bg-gray-200 transition-all"
                        wire:click="getTemplatesByCategory({{ $category->id }})"
                        x-on:click="activeCategory = '{{ $category->id }}'"
                        x-bind:class="activeCategory === '{{ $category->id }}' ? 'bg-brand text-white shadow-md shadow-brand/20 hover:bg-brand-dark' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'">
                        {{ $category->name }}
                    </button>
                @endforeach

                {{-- <button
                    class="px-6 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">
                    Saúde
                </button>

                <button
                    class="px-6 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">
                    Imobiliária
                </button>

                <button
                    class="px-6 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">
                    Landing Pages
                </button>

                <button
                    class="px-6 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all">
                    Institucional
                </button> --}}
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">

                @foreach($templates as $template)
                    <div
                        class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div class="aspect-[16/10] bg-gray-100 overflow-hidden relative">
                            @if($template->thumbnail)
                                <img src="{{ Storage::url($template->thumbnail) }}" alt="Preview Template"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex justify-center items-center">
                                    <p class="text-2xl font-bold text-brand">
                                        Sitemas
                                    </p>
                                </div>
                            @endif

                            @if($template->category->name)
                                <span
                                    class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-dark-900 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                    {{  $template->category->name }}
                                </span>
                            @endif
                        </div>

                        <div class="p-6">
                            <h3 class="text-xl font-bold text-dark-900 tracking-tight">
                                {{  $template->name }}
                            </h3>

                            <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                                {{  $template->excerpt }}
                            </p>

                            <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between gap-4">
                                @if($template->url)
                                    <a href="{{  $template->url }}" target="_blank"
                                        class="text-sm font-semibold text-brand hover:text-brand-dark transition flex items-center gap-1.5">
                                        Ver Demo
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                            </path>
                                        </svg>
                                    </a>
                                @endif

                                <a href="#planos"
                                    class="bg-gray-100 text-dark-900 px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">
                                    Assinar este Modelo
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- <div
                    class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                    <div class="aspect-[16/10] bg-gray-100 overflow-hidden relative">
                        <img src="https://via.placeholder.com/600x400/f1f5f9/94a3b8?text=Preview+Template+Clinica"
                            alt="Preview Template"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <span
                            class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-dark-900 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                            Saúde
                        </span>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-dark-900 tracking-tight">Modelo Vitalle</h3>
                        <p class="mt-2 text-sm text-gray-600 line-clamp-2">Perfeito para clínicas, médicos e
                            profissionais de bem-estar.</p>
                        <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between gap-4">
                            <a href="#" target="_blank"
                                class="text-sm font-semibold text-brand hover:text-brand-dark transition flex items-center gap-1.5">Ver
                                Demo <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                    </path>
                                </svg></a>
                            <a href="#planos"
                                class="bg-gray-100 text-dark-900 px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">Assinar
                                este Modelo</a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>
</div>