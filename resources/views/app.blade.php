<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Chubcay') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @viteReactRefresh
        @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
        @inertiaHead
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
    <script src="https://dev.shift4.com/checkout.js"
        className="shift4-button"
        data-key="pk_test_uEasbndcT9gzaQoWJl5usCqZ"
        data-checkout-request={shift4Payment}
        data-name="Chubcay"
        data-description="Checkout example"
        data-amount={package_details.price}
        data-checkout-button="Pay now">
    </script>
</html>
