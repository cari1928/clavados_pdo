<?php
include('cl_web.class.php');
$smarty = new Smarty(); // 2016-09-27_SMARTY_INICIOS
$templates = $web->templateEngine(); // 2016-09-27_SMARTY_INICIOS
// $web = new Clientes;
// $web->conexion();

if (isset($_POST['datos']))
{
	// $email=$_POST['datos']['email'];
	// $contrasena=$_POST['datos']['contrasena'];
	//$web->login($email,$contrasena);
  $templates->display('resultados.html');
}else{
  $templates->assign('title', 'SISCACLAO');
  $templates->assign('headerTitle1', 'SISCACLAO');
  $templates->assign('headerTitle2', 'Sistema de Calificación de Clavados Individuales');
  $templates->assign('route1', 'images/logo_header.png');
  $templates->assign('route2', 'images/rio2016.png');
  $templates->assign('msg', '');
	$templates->display('index.html');
}
?>
