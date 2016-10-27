<?php
include ('../cl_web.class.php');

$web = new Usuarios;

$web->conexion(); //para poder realizar consultas sobre la bd
$web->checarAcceso(); //restringe el acceso

$web->setTemplate(); //inicializa template
$web->showTemplate(array('title'=>"Administrador",'headerTitle1'=>"SISCACLAO",
      'headerTitle2'=>"Asignación de Niveles de Dificultad",
      'nombre_usuario'=>$_SESSION['nombre_usuario'], 'template'=>"index.html"));
?>
