<x-filament-widgets::widget>
    @php
        $isCanceled = $status === 'canceled';
        $daysLabel = $days >= 1 ? "por mais {$days} " . ($days === 1 ? 'dia' : 'dias') : 'por menos de 1 dia';
    @endphp

    <style>
        .sn-alert { display: flex; gap: .75rem; align-items: flex-start; border-radius: .75rem; padding: 1rem 1.25rem; border: 1px solid; }
        .sn-alert--canceled { background: #fffbeb; border-color: #fde68a; }
        .sn-alert--overdue { background: #fef2f2; border-color: #fecaca; }
        .sn-icon { flex: 0 0 auto; width: 1.5rem; height: 1.5rem; }
        .sn-alert--canceled .sn-icon { color: #d97706; }
        .sn-alert--overdue .sn-icon { color: #dc2626; }
        .sn-title { font-weight: 700; font-size: .95rem; margin: 0 0 .15rem; }
        .sn-alert--canceled .sn-title { color: #92400e; }
        .sn-alert--overdue .sn-title { color: #991b1b; }
        .sn-text { font-size: .875rem; margin: 0; }
        .sn-alert--canceled .sn-text { color: #b45309; }
        .sn-alert--overdue .sn-text { color: #b91c1c; }
        .sn-text strong { font-weight: 700; }
        .dark .sn-alert--canceled { background: rgba(217,119,6,.12); border-color: rgba(217,119,6,.4); }
        .dark .sn-alert--overdue { background: rgba(220,38,38,.12); border-color: rgba(220,38,38,.4); }
        .dark .sn-alert--canceled .sn-title, .dark .sn-alert--canceled .sn-text { color: #fcd34d; }
        .dark .sn-alert--overdue .sn-title, .dark .sn-alert--overdue .sn-text { color: #fca5a5; }
    </style>

    <div class="sn-alert {{ $isCanceled ? 'sn-alert--canceled' : 'sn-alert--overdue' }}">
        <svg class="sn-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
        </svg>
        <div>
            @if ($isCanceled)
                <p class="sn-title">Assinatura cancelada</p>
                <p class="sn-text">
                    Você ainda tem acesso ao painel <strong>{{ $daysLabel }}</strong>, até <strong>{{ $expiresAt }}</strong>.
                    Após essa data, o acesso e o seu site serão encerrados.
                </p>
            @else
                <p class="sn-title">Pagamento em atraso</p>
                <p class="sn-text">
                    Regularize para manter seu site no ar. Seu acesso continua <strong>{{ $daysLabel }}</strong>,
                    até <strong>{{ $expiresAt }}</strong>.
                </p>
            @endif
        </div>
    </div>
</x-filament-widgets::widget>
