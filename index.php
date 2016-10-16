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
	$msg='';
  $templates->assign('title', 'SISCACLAO');
  $templates->assign('headerTitle1', 'SISCACLAO');
  $templates->assign('headerTitle2', 'Sistema de Calificación de Clavados Individuales');
	$templates->display('index.html');
}
?>
