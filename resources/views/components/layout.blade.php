<!DOCTYPE html>
<html lang="ES">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - MajaStore</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body id="app">
    <header-component>
    </header-component>
    {{ $slot }}
    <footer-component>
    </footer-component>
</body>

</html>
