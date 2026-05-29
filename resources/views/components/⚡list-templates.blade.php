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
        $this->templates = Template::query()->active()->whereHas('category', function (Builder $query): Builder {
            return $query->when($this->filterCategoryId, fn(Builder $subQuery, $categoryId): Builder => $subQuery->where('id', $categoryId));
        })->whereHas('plan', function (Builder $query): Builder {
            return $query->when($this->filterPlanId, fn(Builder $subQuery, $planId): Builder => $subQuery->where('id', $planId));
        })->get();
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

            <div class="mt-10 flex flex-wrap items-center justify-center gap-3" x-data="{ activeCategory: 'all' }">

                <button type="button" wire:click="filterAllCategories()" x-on:click="activeCategory = 'all'"
                    x-bind:class="activeCategory === 'all' ? 'bg-brand text-white shadow-md shadow-brand/20 hover:bg-brand-dark' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                    class="px-6 py-2 rounded-full text-sm font-semibold transition-all cursor-pointer">
                    Todos
                </button>

                @foreach($categories as $category)
                    <button type="button" wire:click="filterCategory({{ $category->id }})"
                        x-on:click="activeCategory = '{{ $category->id }}'"
                        x-bind:class="activeCategory === '{{ $category->id }}' ? 'bg-brand text-white shadow-md shadow-brand/20 hover:bg-brand-dark' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
                        class="px-6 py-2 rounded-full text-sm font-semibold transition-all cursor-pointer">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            @if(isset($plans))
                <div x-data="{ activePlan: 'all'}" x-on:trigger-plan-filter.window="activePlan = String($event.detail.id)">
                    <div
                        class="overflow-hidden rounded-full border border-gray-100 flex lg:inline-flex justify-center mt-6">
                        <button class="shadow-md shadow-brand/20 text-xs font-bold cursor-pointer py-2 px-6" type="button"
                            x-on:click="activePlan = 'all'" wire:click="filterAllPlans()"
                            x-bind:class="activePlan === 'all' ? 'text-white bg-brand' : 'text-gray-600 hover:bg-gray-100'">
                            Todos
                        </button>

                        @foreach($plans as $plan)
                            <button class="border-l border-gray-100 text-xs font-bold cursor-pointer py-2 px-2" type="button"
                                wire:click="filterPlan({{ $plan->id }})" x-on:click="activePlan = '{{  $plan->id }}'"
                                x-bind:class="activePlan === '{{  $plan->id }}' ? 'text-white bg-brand' : 'text-gray-600 hover:bg-gray-100'">
                                {{ $plan->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">

                @foreach($templates as $template)
                    <div
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
                                {{  $template->plan->name }}
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

                                <a href="{{ route('subscription.show', $template->slug) }}" target="_blank"
                                    class="bg-gray-100 text-dark-900 px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-200 transition">
                                    Assinar este Modelo
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>