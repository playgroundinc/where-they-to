<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title></title>
</head>
<body>
  <header>
    <nav>
      <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/users">All Users</a></li>
        <li><a href="/performers">All Performers</a></li>
        <li><a href="/venues">All Venues</a></li>
        <li><a href="/families">All Families</a></li>
      </ul>
    </nav>
  </header>
  <div id="root" class="container">
  @yield('content')
  </div>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js"></script>
  <script src="../../js/vendor.js"></script>
  <script src="../../js/app.js"></script>
</body>
</html>