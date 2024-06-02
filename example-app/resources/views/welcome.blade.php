<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Car inventory</title>
    @vite('resources/sass/app.scss')
  

</head>
<body>
    <div id="app">
        <navbar-component></navbar-component>
        <car-component></car-component>
        <part-component></part-component>
       
    </div>
    @vite('resources/js/app.js')
</body>
</html>
