<?php
if (!isset($_SESSION)) {
            session_start();
        }
if ($_SESSION != null) {
    header('Location: /');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <script src="{{ asset('js/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>

<body>
    <div class="p-5">
        @if (isset($mensaje))
            <div class="alert alert-success alert-dismissible fade show" role="alert">{{ $mensaje }}</div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-success alert-dismissible fade show" role="alert">
            @php
                $mensaje = null;
                foreach ($errors->all() as $msg) {
                    echo $msg."<br>";
                }
            @endphp
            </div>
        @endif
        <form action="/crearUsuario" method="POST">
            <h1 class="h3 mb-3 fw-normal">Registrarse</h1>

            <div class="form-floating">
                <label for="floatingInput">Nombre de Usuario</label>
                <input type="text" class="form-control" id="floatingInput" name="username"
                    placeholder="juanitoGamer777">
            </div>
            <div class="form-floating">
                <label for="floatingPassword">Contraseña</label>
                <input type="password" class="form-control" id="floatingPassword" name="password"
                    placeholder="Password">
            </div>
            <div class="form-floating">
                <label for="floatingPassword">E-mail</label>
                <input type="email" class="form-control" id="floatingEmail" name="email"
                    placeholder="correo@Correo.correo">
            </div>
            <br>
            <div class="checkbox mb-3">
                <label>
                    <a href="/login" class="text-bg-dark">Iniciar sesion</a>
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
            {{ csrf_field() }}
            {{ method_field('POST') }}
        </form>
    </div>
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
