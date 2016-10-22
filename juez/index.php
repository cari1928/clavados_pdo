<?php
include ('../cl_web.class.php');
$templates = $web->templateEngine();
$smarty = new Smarty();
$templates->setTemplateDir('../templates/juez/');

$web->checarAcceso();

$templates->assign('title', 'Juez');
$templates->assign('headerTitle1', 'Prueba de Clavados Individual');
$templates->assign('headerTitle2', 'SISCACLAO');
$templates->display('index.html');
// if (isset($_SESSION['logueado']))
// {
// 		$sql="select aux from usuarios where nombre='admin'";
// 		$admin=$web->DB->GetAll($sql);
// 		$sql="select aux from usuarios where nombre='".$_SESSION['nombre']."'";
// 		$juez=$web->DB->GetAll($sql);
// 		if ($admin[0]['aux']=='true' && $juez[0]['aux']=='false')
// 		{
// 			$templates->display('calificar.html');
// 		}
// 		else
// 		{
// 			$templates->display('index.html');
// 		}
// }
// else
// {
// 	header('Location: ../index.php');
// }
?>
