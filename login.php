<?php
include ('cl_web.class.php');
$smarty = new Smarty();
$templates = $web->templateEngine();
// $web->conexion();

$email='';
$contrasena='';

// var_dump($_POST);
if (isset($_POST['datos']))
{
	// $email=$_POST['datos']['email'];
	// $contrasena=$_POST['datos']['contrasena'];
	//$web->login($email,$contrasena);
  if($_POST['datos']['usuario'] == 'a'){
    header('Location: admin');
  }
  elseif ($_POST['datos']['usuario'] == 'j'){
    header('Location: juez');
  }
  else{
    $templates->display('index.html');
  }
}else{
	$msg='';
	$templates->display('index.html');
}
?>
