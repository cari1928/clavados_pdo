<?php
  include ('../cl_web.class.php');

  $web->conexion();
  $web->checarAcceso();

  //Insertar y clavado
  $clavado = arrayClavado($_POST);
  $web->setTabla('clavado');
  $web->insert($clavado);


  $_POST['nombre_usuario'] = $_SESSION['nombre_usuario'];

  unset($_POST['dificultad']);

  $web->setTabla('enviarDatos');
  $web->insert($_POST);
  echo "Mensaje registrado";

//------------------------------------------------------------------------------------------------
  function arrayClavadista() {
    $temp = array
    (
      'cve_clavadista'=>$_POST['cve_clavadista'],
    );
    return $temp;
  }
//------------------------------------------------------------------------------------------------
  function arrayClavado($array) {
    $temp = array
    (
      'cve_clavado'=>$_POST['cve_clavado'],
      'dificultad'=>$_POST['dificultad'],
    );
    return $temp;
  }


?>
