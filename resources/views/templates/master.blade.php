<?php
    if (!isset($_SESSION)) {
    session_start();
    }
    if (!isset($_SESSION['idUsuario'])) {
        header('Location: /login');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    
    <script src="{{asset('js/jquery.slim.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.bundle.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    @include('templates.navbar')
</head>
<body>
    <!-- Message -->
    @if (isset($mensaje))
            <div class="alert alert-success alert-dismissible fade show" role="alert">{{ $mensaje }}</div>
    @endif
    @yield('container')
</body>
<footer>
    <script>
      window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
          $(this).remove();
        });
      }, 2000);
  </script>
</footer>
</html>