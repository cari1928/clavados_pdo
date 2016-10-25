<?php
include ('../cl_web.class.php');
$templates = $web->templateEngine();
$smarty = new Smarty();
$templates->setTemplateDir('../templates/juez/');

$web->checarAcceso();

$templates->assign('title', 'Juez');
$templates->assign('headerTitle1', 'Prueba de Clavados Individual');
$templates->assign('headerTitle2', 'SISCACLAO');
$templates->assign('nombre_usuario', $_SESSION['nombre_usuario']);
$templates->display('index.html');
?>
