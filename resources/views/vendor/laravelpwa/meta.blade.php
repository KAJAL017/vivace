@php
    $config = config('laravelpwa');
@endphp

<!-- Web Application Manifest -->
<link rel="manifest" href="{{ route('laravelpwa.manifest') }}">

<!-- Chrome for Android theme color -->
<meta name="theme-color" content="{{ config('laravelpwa.theme_color', '#ffffff') }}">

<!-- Add to homescreen for Chrome on Android -->
<meta name="mobile-web-app-capable" content="{{ config('laravelpwa.display', 'standalone') }}">
<meta name="application-name" content="{{ config('laravelpwa.short_name', 'App') }}">
{{-- <link rel="icon" sizes="{{ data_get(end($config['icons']), 'sizes', '192x192') }}" href="{{ data_get(end($config['icons']), 'src', '/default-icon.png') }}"> --}}

<!-- Add to homescreen for Safari on iOS -->
<meta name="apple-mobile-web-app-capable" content="{{ config('laravelpwa.display', 'standalone') == 'standalone' ? 'yes' : 'no' }}">
<meta name="apple-mobile-web-app-status-bar-style" content="{{ config('laravelpwa.status_bar', 'default') }}">
<meta name="apple-mobile-web-app-title" content="{{ config('laravelpwa.short_name', 'App') }}">
{{-- <link rel="apple-touch-icon" href="{{ data_get(end($config['icons']), 'src', '/default-icon.png') }}"> --}}

<!-- Splash screen images for iOS -->
{{-- @foreach (['640x1136', '750x1334', '1242x2208', '1125x2436', '828x1792', '1242x2688', '1536x2048', '1668x2224', '1668x2388', '2048x2732'] as $size)
    <link href="{{ data_get($config['splash'], $size, '/default-splash.png') }}" media="(device-width: {{ $size }}) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
@endforeach --}}

<!-- Tile for Win8 -->
<meta name="msapplication-TileColor" content="{{ config('laravelpwa.background_color', '#ffffff') }}">
{{-- <meta name="msapplication-TileImage" content="{{ data_get(end($config['icons']), 'src', '/default-icon.png') }}"> --}}

<script type="text/javascript">
    // Initialize the service worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js', {
            scope: '.'
        }).then(function (registration) {
            // Registration was successful
            console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
        }, function (err) {
            // Registration failed :(
            console.log('Laravel PWA: ServiceWorker registration failed: ', err);
        });
    }
</script>
