<?php
  include('../cl_web.class.php');

  $web = new Usuarios;
  $web->conexion();
  $web->checarAcceso(); //para evitar acceso a usuarios no logueados

  $usuarios = $web->getAll("select * from usuario order by nombre_usuario");

  if(count($usuarios) == 0){
    
  }

  var_dump($usuarios);
  $usuarios = $web->getNombresColumnas($usuarios[0]);
  echo "<br><br><br>";
  var_dump($usuarios);

  die();
  $web->setTemplate(); //prepara smarty
  $web->showTemplate('Administrador', 'SISCACLAO', 'Gestión de Usuarios',
    $_SESSION['nombre_usuario'], 'usuarios.html');
?>
