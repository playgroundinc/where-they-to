<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700&display=swap" rel="stylesheet">  
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
  <header>
  <div id="app">
    <index></index>
  </div>
  <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>