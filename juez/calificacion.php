<?php
  include ('../cl_web.class.php');

  $web = new Calificacion;
  $web->conexion();
  $web->checarAcceso();
  $templates = $web->templateEngine();
  $templates->setTemplateDir('../templates/juez/');

  if(!isset($_POST['calificacion'])) {
    $templates->assign('title', 'Juez');
    $templates->assign('headerTitle1', 'Prueba de Clavados Individual');
    $templates->assign('headerTitle2', 'SISCACLAO');
    $templates->assign('nombre_usuario', $_SESSION['nombre_usuario']);
    $templates->assign('clavadista', $clavadista);
    $templates->assign('clavado', $clavado);
    $templates->assign('msg', $web->assignTypeMessage('warning', 'Valor no válido'));
    $templates->display('index.html');
    die();
  } else {
    //existe post
    $web->setTabla('calificacion');

    die(var_dump($_POST));

    $web->insert();
  }

  //COMPLEMENTAR POST

  $web->setTabla('calificacion');
  $web->insert($_POST);

?>
