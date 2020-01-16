<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700&display=swap" rel="stylesheet">  
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>
  <header>
    <div class="container">
      <nav>
        <ul>
          <li><a href="/">Home</a></li>
          <li><a href="/users">Users</a></li>
          <li><a href="/performers">Performers</a></li>
          <li><a href="/venues">Venues</a></li>
          <li><a href="/families">Families</a></li>
          <li><a href="/events">Events</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <div id="root" class="container">
    <main>
      @yield('content')
    </main>
  </div>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js"></script>
  <script src="{{ asset('js/app.js') }}" defer></script>
  <div id="app">
    <index></index>
  </div>
</body>
</html>