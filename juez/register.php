<?php
  include ('../cl_web.class.php');

  $web->conexion();
  $web->checarAcceso();

  //Insertar y clavado
  $_POST['nombre_usuario'] = $_SESSION['nombre_usuario'];

  $web->setTabla('enviarDatosJuez');
  $web->insert($_POST);

  echo "Mensaje registrado";
?>
