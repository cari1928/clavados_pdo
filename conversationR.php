<?php
//COMUNICACIÓN JUEZ - PUBLICO
include 'cl_web.class.php';

$web->conexion();

//ADMIN-JUEZ
$sql = "select * from ronda
    inner join enviardatosjuez on enviardatosjuez.cve_clavadista = ronda.cve_clavadista
    inner join clavado on clavado.cve_clavado = enviardatosjuez.cve_clavado
    inner join clavadista on clavadista.cve_clavadista = ronda.cve_clavadista
    inner join nacionalidad on clavadista.cve_nacionalidad = nacionalidad.cve_nacionalidad
  order by num_ronda DESC";
$result = $web->fetchAll($sql);

if (isset($result[0])) {
    $file = fopen("datos.txt", "w");
    fwrite($file, "num_ronda=>" . $result[0]['num_ronda'] . ";");
    fwrite($file, "calif_ronda=>" . $result[0]['calif_ronda'] . ";");
    fwrite($file, "nombre_completo=>" . $result[0]['nombre_completo'] . ";");
    fwrite($file, "bandera=>" . $result[0]['bandera'] . ";");
    fwrite($file, "cve_nacionalidad=>" . $result[0]['cve_nacionalidad'] . ";");
    fwrite($file, "dificultad=>" . $result[0]['dificultad']);
    fclose($file);

} else {
    $result[0]['num_ronda']        = "Falta por asignar";
    $result[0]['calif_ronda']      = "0";
    $result[0]['nombre_completo']  = "Falta por asignar";
    $result[0]['bandera']          = "a1.png";
    $result[0]['cve_nacionalidad'] = "Falta por asignar";
    $result[0]['dificultad']       = "Falta por asignar";
}

echo '<!DOCTYPE html>
  <html lang="en">
  <head>
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
      <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta charset="UTF-8">
    <!-- <link rel="stylesheet" type="text/css" href="css/main.css"> -->
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <title>{$title}</title>
  </head>
  <body id="contenedor">
    <header>
      <div class="container-fluid"> <!-- container para centrar las cosas -->
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-1">
            <div id="left-image" align="center">
              <img src="images/flags-normal/' . $result[0]['bandera'] . '" alt="No encontrado">
              <h3>' . $result[0]['cve_nacionalidad'] . '</h3>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-10">
            <div id="logo-header">
              <a href="index.php"><span class="site-name">' . $result[0]['nombre_completo'] . '</span></a>
              <span class="site-desc">SISCACLAO</span>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-1">
            <div id="right-image" align="center">
              <h3>Ronda: ' . $result[0]['num_ronda'] . '</h3>
            </div>
          </div>
        </div>
      </div>

      <nav class="navbar navbar-default navbar-static-top">
        <div class="container-fluid">
          <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-1" aria-expanded="false">

            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a href="index.php" class="navbar-brand"><span class="glyphicon glyphicon-tint"></span></a>
        </div>
          <div class="collapse navbar-collapse" id="navbar-1">
            <ul class="nav navbar-nav">
              <li><a href="calificaciones.php">Calificaciones</a></li>
              <li><a href="internet.php">Resultados</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
              <li><a href="registro.php">Registro</a></li>
              <li><a href="index.php">Login</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </header><!-- / #main-header -->
    <div class="container-fluid">
      <div class="second row">

        <nav class="col-xs-12" align="center">
          <p>' . $result[0]['calif_ronda'] . '</p>
        </nav>

      </div>
    </div>
    <section>
      <div class="container"> <!-- container para centrar las cosas -->
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-1">
              <div id="left-image" align="center">
                <img src="images/logo_header.png" alt="No encontrado">
              </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-10">
              <div id="logo-header">
                <span class="site-name">Dificultad: ' . $result[0]['dificultad'] . '</span>
              </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-1">
              <div id="right-image" align="center">
                <img src="images/rio2016.png" alt="No encontrado">
              </div>
            </div>
          </div>
      </div>

    </section>';
