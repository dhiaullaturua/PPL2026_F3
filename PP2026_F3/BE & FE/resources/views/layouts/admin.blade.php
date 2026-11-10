<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'ERP PT Anaheim Nimbus Universal') }}</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('admin-workspace.css') }}?v=3">
</head>
<body class="admin-workspace" data-admin-page="@yield('admin-page')">
    @yield('content')
    <script src="{{ asset('admin-workspace.js') }}?v=3" defer></script>
    <script src="{{ asset('admin-insights.js') }}?v=1" defer></script>
</body>
</html>