<!-- navbar with boostrap 4.6 active validation -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">

      <?php $indexURL = '/index.php' ?>
      <li class="nav-item <?php echo active_pagina($indexURL) ?>">
        <a class="nav-link" href="{{route('inicio')}}">Home <?php echo current_pagina($indexURL) ?></a>
      </li>

      <?php $cuentasURL = '/index.php/cuentas' ?>
      <li class="nav-item <?php echo active_pagina($cuentasURL) ?>">
        <a class="nav-link" href="{{route('cuentas')}}">Cuentas <?php echo current_pagina($cuentasURL) ?></a>
      </li>

      <?php $cobrosURL = '/index.php/cobros' ?>
      <li class="nav-item <?php echo active_pagina($cobrosURL) ?>">
        <a class="nav-link" href="{{route('cobros')}}">cobros <?php echo current_pagina($cobrosURL) ?></a>
      </li>

      <?php $abonosURL = '/index.php/abonos' ?>
      <li class="nav-item <?php echo active_pagina($abonosURL) ?>">
        <a class="nav-link" href="{{route('abonos')}}">abonos <?php echo current_pagina($abonosURL) ?></a>
      </li>

      {{-- comment 
      <?php $copiURL = '/index.php/copi' ?>
      <li class="nav-item <?php echo active_pagina($copiURL) ?>">
        <a class="nav-link" href="{{route('copi')}}">copi <?php echo current_pagina($copiURL) ?></a>
      </li>
      --}}
    </ul>
  </div>
</nav>
<?php

//Function that gets the filename of the currently executing script (url) and compare it with the url of the navbar link, then give the respectives
//tags to style the navbar
//
// active_pagina(String URL) Will return "'active'" if the page URL is the same that the variable String URL
// current_pagina(String URL) Will return "'<span class="sr-only">(current)</span>'" if the page URL is the same that the variable String URL
// mostrar_url() Will return the page URL
function active_pagina(String $url)
{
  if (htmlspecialchars($_SERVER["PHP_SELF"]) == $url) {
    return 'active';
  }
}
function current_pagina(String $url)
{
  if (htmlspecialchars($_SERVER["PHP_SELF"]) == $url) {
    return '<span class="sr-only">(current)</span>';
  }
}
function mostrar_url()
{
  return htmlspecialchars($_SERVER["PHP_SELF"]);
}
?>