<?php
include('cl_web.class.php');
$smarty = new Smarty();
$templates = $web->templateEngine();
$web = new Registro;
$web->conexion();

if (isset($_POST['nombre_usuario'])) { //se va a insertar un nuevo usuario

	//verificacion de contraseña
	if($_POST['pass'] != $_POST['vpass']){
		messages($templates, "Las contraseñas no coinciden", "warning");
		die();
	}

	unset($_POST['vpass']); //destruye el campo
	$web->setTabla("usuario");
	$_POST['pass'] = md5($_POST['pass']);
	$web->insert($_POST);
	// messages($templates, "Registro completado", "info");
	header('Location: index.php');

}else{
  messages($templates);
}

//----------------------------------------------------------------------------------
	function messages($templates, $msg="", $type=null){

		if($type == "warning"){
			$msg = '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
		}
		else if($type == "info"){
			$msg = '<div class="alert alert-success" role="alert">'.$msg.'</div>';
		}

		$templates->assign('title', 'SISCACLAO');
	  $templates->assign('headerTitle1', 'SISCACLAO');
	  $templates->assign('headerTitle2', 'Sistema de Registro de Usuarios');
		$templates->assign('route1', 'images/logo_header.png');
		$templates->assign('route2', 'images/rio2016.png');
		$templates->assign('msg', $msg);
		$templates->display('registro.html');
	}
?>
