<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">Status do seu site</x-slot>
        <x-slot name="description">Acompanhe a produção do seu site, do recebimento até a publicação.</x-slot>

        @php
            $keys = array_keys($stages);
            $currentIndex = array_search($currentStage, $keys);
            $currentIndex = $currentIndex === false ? 0 : $currentIndex;
        @endphp

        <ol class="flex flex-col gap-6 sm:flex-row sm:gap-2">
            @foreach ($stages as $key => $label)
                @php
                    $i = $loop->index;
                    $done = $i < $currentIndex;
                    $active = $i === $currentIndex;
                @endphp
                <li class="flex flex-1 items-center gap-3">
                    <span @class([
                        'flex h-9 w-9 shrink-0 items-center justify-center rounded-full text-sm font-bold',
                        'bg-primary-600 text-white' => $done || $active,
                        'ring-4 ring-primary-500/20' => $active,
                        'bg-gray-100 text-gray-400 dark:bg-gray-800 dark:text-gray-500' => ! $done && ! $active,
                    ])>
                        @if ($done)
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                            </svg>
                        @else
                            {{ $i + 1 }}
                        @endif
                    </span>

                    <div>
                        <p @class([
                            'text-sm font-semibold',
                            'text-gray-950 dark:text-white' => $active,
                            'text-gray-700 dark:text-gray-300' => $done,
                            'text-gray-400 dark:text-gray-500' => ! $done && ! $active,
                        ])>
                            {{ $label }}
                        </p>
                        @if ($active)
                            <p class="text-xs text-primary-600 dark:text-primary-400">Etapa atual</p>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    </x-filament::section>
</x-filament-widgets::widget>
