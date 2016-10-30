<?php
  include ('../cl_web.class.php');

  $web = new Index;
  $web->conexion();
  $web->checarAcceso();
  $templates = $web->templateEngine();
  $templates->setTemplateDir('../templates/juez/');

  $clavadista = $web->getAll('select * from clavadista inner join nacionalidad on clavadista.cve_nacionalidad = nacionalidad.cve_nacionalidad');
  $clavado = $web->getAll('select * from clavado');

  $templates->assign('title', 'Juez');
  $templates->assign('headerTitle1', 'Prueba de Clavados Individual');
  $templates->assign('headerTitle2', 'SISCACLAO');
  $templates->assign('nombre_usuario', $_SESSION['nombre_usuario']);
  $templates->assign('clavadista', $clavadista);
  $templates->assign('clavado', $clavado);
  $templates->display('index.html');
?>
