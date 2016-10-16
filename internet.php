<?php
include ('cl_web.class.php');
$templates = $web->templatesEngine();

$templates->assign('title', 'SISCACLAO');
$templates->assign('headerTitle1', 'Tablero de Clavados Individual');
$templates->assign('headerTitle2', 'SISCACLAO');
$templates->display('internet.html');
?>
