<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">{{ $sites->count() > 1 ? 'Status dos seus sites' : 'Status do seu site' }}</x-slot>
        <x-slot name="description">Acompanhe a produção do seu site, do recebimento até a publicação.</x-slot>

        {{-- Estilos próprios (classes locais) para não depender de um tema custom do Filament --}}
        <style>
            .ss-site + .ss-site { margin-top: 1.75rem; padding-top: 1.5rem; border-top: 1px solid rgba(0,0,0,.06); }
            .dark .ss-site + .ss-site { border-top-color: rgba(255,255,255,.08); }
            .ss-site-name { font-size: .9rem; font-weight: 700; margin: 0 0 1rem; color: #111827; }
            .dark .ss-site-name { color: #fff; }
            .ss-steps { display: flex; flex-wrap: wrap; gap: 1.25rem; }
            .ss-step { display: flex; align-items: center; gap: .75rem; flex: 1 1 170px; min-width: 150px; }
            .ss-badge { display: flex; align-items: center; justify-content: center; width: 2.25rem; height: 2.25rem; border-radius: 9999px; font-weight: 700; font-size: .875rem; background: #e5e7eb; color: #9ca3af; flex: 0 0 auto; }
            .ss-badge svg { width: 1.25rem; height: 1.25rem; }
            .ss-step--done .ss-badge, .ss-step--active .ss-badge { background: #2563eb; color: #fff; }
            .ss-step--active .ss-badge { box-shadow: 0 0 0 4px rgba(37, 99, 235, .2); }
            .ss-label { font-size: .875rem; font-weight: 600; color: #9ca3af; margin: 0; }
            .ss-step--done .ss-label { color: #374151; }
            .ss-step--active .ss-label { color: #111827; }
            .ss-current { font-size: .75rem; color: #2563eb; margin: .125rem 0 0; }
            .dark .ss-badge { background: #374151; color: #9ca3af; }
            .dark .ss-step--done .ss-badge, .dark .ss-step--active .ss-badge { background: #2563eb; color: #fff; }
            .dark .ss-label { color: #6b7280; }
            .dark .ss-step--done .ss-label { color: #d1d5db; }
            .dark .ss-step--active .ss-label { color: #fff; }
        </style>

        @php $keys = array_keys($stages); @endphp

        @foreach ($sites as $site)
            @php
                $currentIndex = array_search($site->stage, $keys);
                $currentIndex = $currentIndex === false ? 0 : $currentIndex;
            @endphp
            <div class="ss-site">
                @if ($sites->count() > 1)
                    <p class="ss-site-name">{{ $site->company_name }}</p>
                @endif

                <div class="ss-steps">
                    @foreach ($stages as $key => $label)
                        @php
                            $i = $loop->index;
                            $done = $i < $currentIndex;
                            $active = $i === $currentIndex;
                        @endphp
                        <div class="ss-step {{ $done ? 'ss-step--done' : ($active ? 'ss-step--active' : '') }}">
                            <span class="ss-badge">
                                @if ($done)
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                    </svg>
                                @else
                                    {{ $i + 1 }}
                                @endif
                            </span>
                            <div>
                                <p class="ss-label">{{ $label }}</p>
                                @if ($active)
                                    <p class="ss-current">Etapa atual</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </x-filament::section>
</x-filament-widgets::widget>
