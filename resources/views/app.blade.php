<!DOCTYPE html>
<html dir='rtl'  lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/fonts/styles-fa-num/iran-yekan.css')}}">

    <!-- Scripts -->
   @viteReactRefresh
    @vite(['resources/js/app.jsx'])
    @inertiaHead
</head>
<body  class="font-sans antialiased">
@inertia
</body>
</html>
