<?php
include ('../cl_web.class.php');

$web = new Usuarios;

$web->conexion(); //para poder realizar consultas sobre la bd
$web->checarAcceso(); //restringe el acceso

$web->setTemplate(); //inicializa template
$web->showTemplate('Administrador', 'SISCACLAO', 'Asignación de Nivel de Dificultad',
  $_SESSION['nombre_usuario'], 'index.html');
?>
