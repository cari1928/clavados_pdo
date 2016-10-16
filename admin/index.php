<?php
include ('../cl_web.class.php');
$templates = $web->templateEngine();
$templates->setTemplateDir('../templates/admin/');

$templates->assign('title', 'Dificultad');
$templates->assign('headerTitle1', 'SISCACLAO');
$templates->assign('headerTitle2', 'Asignación de Nivel de Dificultad');
$templates->display('index.html');
// if (isset($_SESSION['logueado']))
// {
// 	$templates->setTemplateDir('../templates/admin/');
// 	if (isset($_POST['datos']))
// 	{
// 		if ($_POST['datos']['dificultad']>=1.3 && $_POST['datos']['dificultad']<=3.6 )
// 		{
// 			$sql="update usuarios set calificacion=".$_POST['datos']['dificultad']." where nombre='admin'";
// 			$web->query($sql);
// 			$sql="update usuarios set aux='true' where nombre='admin'";
// 			$web->query($sql);
// 			$templates->display('refresca.html');
// 		}
// 		else
// 		{
// 			$templates->assign("mensaje",'<label style= "color:red">El grado de dificultad no es valido</label>');
// 			$templates->display('index.html');
// 		}
//
// 	}
// 	else
// 	{
// 		$sql="select aux from usuarios where nombre='admin'";
// 		$datos=$web->DB->GetAll($sql);
// 		if($datos[0]['aux']=='false')
// 		{
// 		$templates->assign("mensaje",'');
// 		$templates->display('index.html');
// 		}
// 		else
// 		{
// 			$templates->display('refresca.html');
// 		}
// 	}
// }
// else
// {
// 	header('Location: ../index.php');
// }
?>
