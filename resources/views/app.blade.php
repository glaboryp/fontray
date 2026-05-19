<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="app-name" content="{{ config('app.name', 'Laravel') }}">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Schema.org: WebApplication -->
        <script type="application/ld+json">
        {!! json_encode([
            '@context'            => 'https://schema.org',
            '@type'               => 'WebApplication',
            'name'                => config('app.name', 'Fontray'),
            'url'                 => config('app.url'),
            'description'         => 'Identificador de fuentes tipográficas. Sube una imagen con texto y descubre qué fuente tipográfica se está utilizando. Rápido, preciso y completamente gratuito.',
            'applicationCategory' => 'DesignApplication',
            'operatingSystem'     => 'Web',
            'inLanguage'          => 'es',
            'isAccessibleForFree' => true,
            'offers'              => [
                '@type'         => 'Offer',
                'price'         => '0',
                'priceCurrency' => 'EUR',
            ],
            'author' => [
                '@type' => 'Organization',
                'name'  => config('app.name', 'Fontray'),
            ],
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
        </script>

        <!-- SEO: Canonical -->
        <link rel="canonical" href="{{ url()->current() }}" />

        <!-- SEO: Open Graph -->
        {{-- og:title y og:description actúan como fallback estático para crawlers sin JS (WhatsApp, Slack…) --}}
        {{-- Las páginas Vue sobrescriben estos valores vía <Head> para crawlers con JS (Twitter, LinkedIn…) --}}
        <meta property="og:type" content="website" />
        <meta property="og:site_name" content="{{ config('app.name', 'Fontray') }}" />
        <meta property="og:title" content="{{ config('app.name', 'Fontray') }} — Identificador de fuentes tipográficas" />
        <meta property="og:description" content="Sube una imagen con texto y descubre qué fuente tipográfica se está utilizando. Rápido, preciso y completamente gratuito." />
        <meta property="og:url" content="{{ url()->current() }}" />
        {{-- TODO: reemplazar logo_letras.png por una imagen dedicada de 1200×630 px --}}
        <meta property="og:image" content="{{ asset('images/logo_letras.png') }}" />
        <meta property="og:image:width" content="680" />
        <meta property="og:image:height" content="382" />
        <meta property="og:image:alt" content="Fontray — Identificador de fuentes tipográficas" />
        <meta property="og:locale" content="{{ str_replace('-', '_', app()->getLocale()) }}" />

        <!-- SEO: Twitter / X Cards -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="{{ config('app.name', 'Fontray') }} — Identificador de fuentes tipográficas" />
        <meta name="twitter:description" content="Sube una imagen con texto y descubre qué fuente tipográfica se está utilizando. Rápido, preciso y completamente gratuito." />
        <meta name="twitter:image" content="{{ asset('images/logo_letras.png') }}" />
        <meta name="twitter:image:alt" content="Fontray — Identificador de fuentes tipográficas" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
        <link rel="stylesheet" href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
