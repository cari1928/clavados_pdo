<?php
  include ('../cl_web.class.php');

  $web = new Index;
  $web->conexion();
  $web->checarAcceso();
  $templates = $web->templateEngine();
  $templates->setTemplateDir('../templates/juez/');

  $clavadista = $web->getAll('select * from clavadista inner join nacionalidad on clavadista.cve_nacionalidad = nacionalidad.cve_nacionalidad');
  $clavado = $web->getAll('select * from clavado');

  $file = fopen("datos.txt", "r");
  $datos = array();
  while(!feof($file)) {
    echo fgets($file). "<pre><br />";
    $element = explode("=>", fgets($file));
    var_dump($element);
    echo "<br>";
    $datos = array_push($datos, array($element[0]=>$element[1]));
    var_dump($datos);
  }
  fclose($file);

  die(var_dump($datos));

  $templates->assign('title', 'Juez');
  $templates->assign('headerTitle1', 'Prueba de Clavados Individual');
  $templates->assign('headerTitle2', 'SISCACLAO');
  $templates->assign('nombre_usuario', $_SESSION['nombre_usuario']);
  $templates->assign('clavadista', $clavadista);
  $templates->assign('clavado', $clavado);
  $templates->display('index.html');
?>
