@props([
    'title' => null,
    'description' => null,
    'image' => null,
])

@php
    $defaultTitle = 'Sitemas — Seu site profissional por assinatura';
    $defaultDescription = 'Escolha um modelo premium, assine um plano e nós cuidamos de tudo: hospedagem, manutenção e suporte. Sem fidelidade e com ativação gratuita.';

    $pageTitle = $title ?: $defaultTitle;
    $pageDescription = \Illuminate\Support\Str::limit(strip_tags($description ?: $defaultDescription), 160);
    $currentUrl = url()->current();

    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                'name' => 'Sitemas',
                'url' => config('app.url'),
                'description' => $defaultDescription,
            ],
            [
                '@type' => 'WebSite',
                'name' => 'Sitemas',
                'url' => config('app.url'),
                'inLanguage' => 'pt-BR',
            ],
        ],
    ];
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}">
<meta name="robots" content="index, follow">
<meta name="theme-color" content="#2563eb">
<link rel="canonical" href="{{ $currentUrl }}">

{{-- Open Graph --}}
<meta property="og:type" content="website">
<meta property="og:site_name" content="Sitemas">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:url" content="{{ $currentUrl }}">
<meta property="og:locale" content="pt_BR">
@if ($image)
    <meta property="og:image" content="{{ $image }}">
@endif

{{-- Twitter --}}
<meta name="twitter:card" content="{{ $image ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
@if ($image)
    <meta name="twitter:image" content="{{ $image }}">
@endif

<script type="application/ld+json">
    {!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
