<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="token" id="token" value="{{ csrf_token() }}">


    <title inertia>{{ config('app.name', 'Cavite State University') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="shortcut icon" href="#">

    <!-- Scripts -->
    @routes
    <script src="{{ mix('js/app.js') }}" defer></script>
    @inertiaHead
</head>

<body class="font-sans antialiased">

    @inertia

    @env('local')
    <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script>
    @endenv

    <script>
        var botmanWidget = {
            frameEndpoint: '/botman/chat',
            dateTimeFormat: 'm/d/yy HH:MM',
            title: 'CvSU Bot',
            introMessage: "Welcome to Cavite State University! Type 'Hi' to start conversation.",
            displayMessageTime: true,
            mainColor: '#10b981',
            bubbleBackground: '#10b981',
            aboutLink: 'https://cvsu.edu.ph/',
            aboutText: 'Cavite State University',
        };
    </script>
    <script src='https://cdn.jsdelivr.net/npm/botman-web-widget@0/build/js/widget.js'></script>

</body>

</html>
