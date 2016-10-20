<?php
include ('cl_web.class.php');
$templates = $web->templateEngine();

$templates->assign('title', 'SISCACLAO');
$templates->assign('headerTitle1', 'Nombre Participante');
$templates->assign('headerTitle2', 'SISCACLAO');
$templates->assign('headerTitle3', 'Dificultad: Número');
$templates->assign('route1', 'china.jpg');
$templates->assign('route2', 'imagen.png');
$templates->display('calificaciones.html');
?>
