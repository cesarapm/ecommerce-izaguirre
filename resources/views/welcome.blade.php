<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

                <!-- SEO Meta Tags -->
                <title>IzaguirreQu | Joyería artesanal mexicana</title>
                <meta name="description" content="IzaguirreQu crea joyería artesanal mexicana con alma contemporánea. Piezas únicas, simbología ancestral y diseño hecho para mujeres que buscan portar su historia.">
                <meta name="keywords" content="joyería artesanal mexicana, joyas contemporáneas, joyería hecha a mano, joyería con símbolos, IzaguirreQu, accesorios mexicanos, diseño artesanal, joyería femenina">
                <meta name="author" content="IzaguirreQu">
        <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
                <meta name="publisher" content="IzaguirreQu">
                <link rel="canonical" href="{{ url()->current() }}">



        <link rel="image_src" href="{{ asset('og-image.png') }}" />
    <meta property="og:type" content="image/png" />
        <meta property="og:title" content="IzaguirreQu | Joyería artesanal mexicana" />
        <meta property="og:description" content="Joyería artesanal mexicana con diseño contemporáneo, misterio y herencia cultural. Piezas que conectan el arte con el alma." />
        <meta property="og:image" content="{{ asset('og-image.png') }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta
      property="og:image:alt"
            content="IzaguirreQu, joyería artesanal mexicana con piezas de inspiración ancestral y diseño contemporáneo."
    />
        <meta property="og:url" content="{{ url()->current() }}" />
        <meta property="og:site_name" content="IzaguirreQu" />
    <meta property="og:locale" content="es_MX" />

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
                <meta property="og:url" content="{{ url()->current() }}">
                <meta property="og:title" content="IzaguirreQu | Joyería artesanal mexicana">
                <meta property="og:description" content="Descubre piezas artesanales mexicanas con energía femenina, detalle escultórico y simbolismo que honra su origen.">
                <meta property="og:image" content="{{ asset('og-image.png') }}">
                <meta property="og:site_name" content="IzaguirreQu">

        <!-- Twitter -->
        <meta property="twitter:card" content="summary_large_image">
                <meta property="twitter:url" content="{{ url()->current() }}">
                <meta property="twitter:title" content="IzaguirreQu | Joyería artesanal mexicana">
                <meta property="twitter:description" content="Piezas hechas a mano que mezclan herencia mexicana, diseño contemporáneo y una presencia que no necesita explicarse.">
                <meta property="twitter:image" content="{{ asset('og-image.png') }}">

           <!-- WhatsApp -->
    <meta property="og:image:type" content="image/png" />
        <meta property="og:image:secure_url" content="{{ asset('og-image.png') }}" />
        <!-- Favicons -->
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <meta name="theme-color" content="#8c745f">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div id="app"></div>
    </body>
</html>
