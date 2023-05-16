<!DOCTYPE html>
<html lang="{{ $lang }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title }}</title>

    @vite('resources/css/app.scss')

    {{ $head ?? '' }}
</head>
<body>
    {{ $slot }}

    @vite('resources/js/app.ts')

    {{ $footer ?? '' }}
</body>
</html>
