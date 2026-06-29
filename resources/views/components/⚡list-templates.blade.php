<?php

use Livewire\Component;
use Illuminate\Support\Collection;
use App\Models\{Category, Plan, Template};
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;

new class extends Component {
    public Collection $categories;

    public Collection $plans;

    public Collection $templates;

    public int|null $filterCategoryId = null;

    public int|null $filterPlanId = null;

    public function mount()
    {
        $this->getCategories();

        $this->getPlans();

        $this->getFilterTemplates();
    }

    public function getCategories()
    {
        $this->categories = Category::query()->active()->with('templates')->whereHas('templates', function ($query) {
            return $query->active();
        })->get();
    }

    public function getPlans()
    {
        $this->plans = Plan::query()->orderBy('order', 'asc')->active()->with('templates')->whereHas('templates', function ($query) {
            return $query->active();
        })->get();
    }

    public function filterAllCategories()
    {
        $this->filterCategoryId = null;

        $this->getFilterTemplates();
    }

    public function filterAllPlans()
    {
        $this->filterPlanId = null;

        $this->getFilterTemplates();
    }

    public function filterCategory($categoryId)
    {
        $this->filterCategoryId = $categoryId;

        $this->getFilterTemplates();
    }

    public function filterPlan($planId)
    {
        $this->filterPlanId = $planId;

        $this->getFilterTemplates();
    }

    public function getFilterTemplates()
    {
        // Filtro hierárquico por plano: ao escolher um plano, mostramos os
        // modelos cujo plano tem ordem MENOR OU IGUAL à do plano selecionado.
        // Assim, o plano mais alto (ex.: Pro) enxerga todos os modelos.
        $maxOrder = $this->filterPlanId
            ? Plan::query()->whereKey($this->filterPlanId)->value('order')
            : null;

        $this->templates = Template::query()->active()
            ->with('plan')
            ->whereHas('category', function (Builder $query): Builder {
                return $query->when($this->filterCategoryId, fn(Builder $subQuery, $categoryId): Builder => $subQuery->where('id', $categoryId));
            })
            ->whereHas('plan', function (Builder $query) use ($maxOrder): Builder {
                return $query->active()->when(! is_null($maxOrder), fn(Builder $subQuery): Builder => $subQuery->where('order', '<=', $maxOrder));
            })
            ->get();
    }

    #[On('trigger-plan-filter')]
    public function handlePlanFilter($id)
    {
        $this->filterPlanId = $id;

        $this->filterCategoryId = null;

        $this->getFilterTemplates();
    }
};
?>

<div>
    <section id="modelos" class="pt-24 pb-0 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-extrabold text-dark-900 tracking-tight">
                    Nossos Modelos Premium
                </h2>

                <p class="max-w-xl lg:text-lg text-gray-600 mt-4 mx-auto">
                    Designs modernos, responsivos e otimizados para
                    conversão em qualquer dispositivo.
                </p>
            </div>

            <div class="mt-10 rounded-3xl border border-gray-100 bg-gray-50/60 p-5 md:p-6"
                x-data="{ activeCategory: 'all', activePlan: 'all' }"
                x-on:trigger-plan-filter.window="activePlan = String($event.detail.id)">

                <div class="flex flex-col lg:flex-row lg:items-end gap-6 lg:gap-8">

                    {{-- Categorias --}}
                    <div class="flex-1 min-w-0">
                        <span class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">
                            Filtrar por categoria
                        </span>

                        <div class="flex flex-wrap gap-2">
                            <button type="button" wire:click="filterAllCategories()" x-on:click="activeCategory = 'all'"
                                x-bind:class="activeCategory === 'all' ? 'bg-brand text-white border-brand shadow-sm shadow-brand/20' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-300'"
                                class="px-4 py-2 rounded-full text-sm font-semibold border transition-all cursor-pointer">
                                Todos
                            </button>

                            @foreach($categories as $category)
                                <button type="button" wire:key="category-{{ $category->id }}"
                                    wire:click="filterCategory({{ $category->id }})"
                                    x-on:click="activeCategory = '{{ $category->id }}'"
                                    x-bind:class="activeCategory === '{{ $category->id }}' ? 'bg-brand text-white border-brand shadow-sm shadow-brand/20' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-300'"
                                    class="px-4 py-2 rounded-full text-sm font-semibold border transition-all cursor-pointer">
                                    {{ $category->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Divisor --}}
                    <div class="hidden lg:block w-px self-stretch bg-gray-200"></div>

                    {{-- Planos (segmented control) --}}
                    @if(isset($plans) && $plans->isNotEmpty())
                        <div class="lg:shrink-0">
                            <span class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-3">
                                Plano
                            </span>

                            <div class="inline-flex items-center rounded-xl bg-gray-100 p-1 max-w-full overflow-x-auto">
                                <button type="button" wire:click="filterAllPlans()" x-on:click="activePlan = 'all'"
                                    x-bind:class="activePlan === 'all' ? 'bg-white text-dark-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                    class="px-4 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition-all cursor-pointer">
                                    Todos
                                </button>

                                @foreach($plans as $plan)
                                    <button type="button" wire:key="plan-btn-{{ $plan->id }}"
                                        wire:click="filterPlan({{ $plan->id }})" x-on:click="activePlan = '{{ $plan->id }}'"
                                        x-bind:class="activePlan === '{{ $plan->id }}' ? 'bg-white text-brand shadow-sm' : 'text-gray-500 hover:text-gray-700'"
                                        class="px-4 py-1.5 rounded-lg text-sm font-semibold whitespace-nowrap transition-all cursor-pointer">
                                        {{ $plan->name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Contador de resultados + estado de carregamento --}}
            <div class="flex items-center justify-center gap-2 mt-6 text-sm text-gray-500 h-5">
                <span wire:loading.remove wire:target="filterCategory,filterPlan,filterAllCategories,filterAllPlans">
                    {{ count($templates) }} {{ count($templates) === 1 ? 'modelo encontrado' : 'modelos encontrados' }}
                </span>
                <span wire:loading wire:target="filterCategory,filterPlan,filterAllCategories,filterAllPlans"
                    class="inline-flex items-center gap-2">
                    <svg class="w-4 h-4 animate-spin text-brand" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Atualizando…
                </span>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mt-6 transition-opacity duration-200"
                wire:loading.class="opacity-40 pointer-events-none"
                wire:target="filterCategory,filterPlan,filterAllCategories,filterAllPlans">

                @foreach($templates as $template)
                    <div wire:key="template-{{ $template->id }}"
                        class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                        <div class="aspect-16/10 bg-gray-100 overflow-hidden relative">
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
                            <span class="rounded-full shadow-sm text-xs font-bold text-white bg-brand py-1 px-3">
                                {{ $template->plan->name }}
                            </span>

                            <h3 class="text-xl font-bold text-dark-900 tracking-tight mt-2">
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

                                <a href="{{ route('subscription.show', $template->slug) }}"
                                    class="bg-gray-100 text-dark-900 px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">
                                    Assinar este Modelo
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if(count($templates) === 0)
                <div class="text-center py-16">
                    <div class="mx-auto w-14 h-14 rounded-2xl bg-gray-100 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>
                    </div>
                    <p class="text-dark-900 font-bold">Nenhum modelo encontrado</p>
                    <p class="text-gray-500 text-sm mt-1">Tente outra categoria ou plano.</p>
                </div>
            @endif
        </div>
    </section>
</div>