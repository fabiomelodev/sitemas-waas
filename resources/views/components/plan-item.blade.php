<div class="bg-white p-8 md:p-10 rounded-3xl border border-gray-100 shadow-sm relative">
    <h3 class="text-2xl font-bold text-dark-900 tracking-tight">
        {{  $plan->name }}
    </h3>

    <span class="block mt-2 text-gray-600 text-sm">
        {!! $plan->description !!}
    </span>

    <div class="mt-6 flex items-baseline gap-1">
        <span class="text-5xl font-extrabold text-dark-900 tracking-tighter">
            {{ \App\Helpers\FormatCurrency::getFormatCurrency($plan->price) }}
        </span>

        <span class="text-gray-500 text-sm font-medium">/mês</span>
    </div>

    <ul class="mt-10 space-y-4 text-sm text-gray-700">
        @foreach($plan->features as $feature)
            <li class=" flex items-center gap-3 {{  $feature['status'] == 0 ? 'text-gray-400' : '' }}">
                @if($feature['status'])
                    <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
                    </svg>
                @else
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                @endif

                {{  $feature['name'] }}
            </li>
        @endforeach
    </ul>

    <button x-data
        @click="$dispatch('trigger-plan-filter', { id: {{ $plan->id }} }); document.getElementById('modelos').scrollIntoView({ behavior: 'smooth' })"
        class="w-full transition py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl font-bold cursor-pointer mt-12">
        {{-- Ver Modelos Start --}}
        {{ $plan->button_cta }}
    </button>
</div>