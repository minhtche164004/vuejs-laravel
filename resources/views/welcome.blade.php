<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link name="favicon" rel="shortcut icon" type="image/x-icon" href="https://www.sieuthimaytinhlangson.com/uploads/logo_banner/1676627057.png">
    <title>Siêu thị máy tính</title>

    @vite(['resources/css/app.css'])
</head>

<body>
    <div id="app">
    </div>
    @vite(['resources/js/app.js'])
</body>

</html>