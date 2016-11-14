<?php
include('cl_web.class.php');
$smarty = new Smarty(); 
$templates = $web->templateEngine(); 

if (isset($_POST['datos']))
{
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
