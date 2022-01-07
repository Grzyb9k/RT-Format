<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="corporate">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="icon" href="{{ asset('assets/favicon.ico') }}">
    </head>
    <body>
    <div id="app" class="flex items-center bg-gray-100 min-h-screen">
        <home />
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
