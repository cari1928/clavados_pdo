<?php
include ('cl_web.class.php');
$smarty = new Smarty();
$templates = $web->templateEngine();
$web = new Login;
$web->conexion();
if (isset($_POST['nombre_usuario']))
{
  $nombre_usuario = $_POST['nombre_usuario'];
  $pass = $_POST['pass'];
  $web->newLogin($nombre_usuario, $pass, $_POST);
}else if(isset($_GET['action'])){
  $web->logout();
  header('Location: index.php');
}else{
  header('Location: index.php');
}
?>
