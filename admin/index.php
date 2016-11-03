<?php
include ('../cl_web.class.php');

$web = new Usuarios;

$web->conexion(); //para poder realizar consultas sobre la bd
$web->checarAcceso(); //restringe el acceso
$web->setTemplate('../templates/admin/'); //inicializa template

$msg = null;

if(isset($_POST['cve_clavadista'])) {
  die("index.php");

  $clavadista = arrayClavadista($_POST);
  $clavado = arrayClavado($_POST);

  $web->setTabla('clavadista');
  $web->insert($clavadista);

  $web->setTabla('clavado');
  $web->insert($clavado);

  $msg = array('type'=>'info', 'msg'=>'Enviado correctamente');
}

$cmb_nacionalidad = $web->showList("select cve_nacionalidad, descripcion from nacionalidad");
$cmb_clavadista = $web->showList("select cve_clavadista,nombre_completo from clavadista");
$cmb_genero = $web->showList('select * from genero');
$web->assignTemplate('cmb_nacionalidad', $cmb_nacionalidad);
$web->assignTemplate('cmb_genero', $cmb_genero);
$web->assignTemplate('cmb_clavadista', $cmb_clavadista);
$web->showTemplate(array('title'=>"Administrador",'headerTitle1'=>"SISCACLAO",
      'headerTitle2'=>"Asignación de Niveles de Dificultad",
      'nombre_usuario'=>$_SESSION['nombre_usuario'], 'template'=>"index.html"), $msg);

//------------------------------------------------------------------------------------------------
  function arrayClavadista() {
    $temp = array
    (
      'cve_clavadista'=>$_POST['cve_clavadista'],
      'nombre_completo'=>$_POST['nombre_completo'],
      'cve_nacionalidad'=>$_POST['cve_nacionalidad'],
      'cve_genero'=>$_POST['cve_genero']
    );
    return $temp;
  }
//------------------------------------------------------------------------------------------------
  function arrayClavadO($array) {
    $temp = array
    (
      'cve_clavado'=>$_POST['cve_clavado'],
      'dificultad'=>$_POST['dificultad'],
      'cve_tipo_clavado'=>$_POST['cve_tipo_clavado']
    );
    return $temp;
  }
?>
