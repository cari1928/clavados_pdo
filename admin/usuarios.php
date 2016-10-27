<?php
  include('../cl_web.class.php');

  $web = new Usuarios;
  $web->conexion();
  $web->checarAcceso(); //para evitar acceso a usuarios no logueados

  $rows = $web->fetchAll("
    select nombre_usuario 'Usuario', nombre_real 'Nombre', estado 'Estado', rol 'Rol'
     from usuario inner join rol on usuario.cve_rol = rol.cve_rol
     order by nombre_usuario
    ");
  if(count($rows) == 0){ //si la consulta no arrojó algo $web->setTemplate();
    $web->showTemplate(getElements(),
      array('type'=>'danger', 'msg'=>'No existen usuarios'));
    die();
  }

  $rows = changeState($rows);
  $columns = $web->getNombresColumnas($rows[0]);

  $web->setTemplate(); //prepara smarty
  $tabla = $web->showTable($columns, $rows, "admin/");

  $web->showTemplate(getElements(), null, $tabla);

/****************************************************************************
  FUNCTIONS
/****************************************************************************
  METHOD TO GET AN INDEXED ARRAY WITH THE SPECIFIC* INFORMATION OF A TEMPLATE
****************************************************************************/
  function getElements() {
    return array('title'=>"Administrador",'headerTitle1'=>"SISCACLAO",
          'headerTitle2'=>"Gestión de Usuarios",
          'nombre_usuario'=>$_SESSION['nombre_usuario'], 'template'=>"usuarios.html");
  }

/****************************************************************************
  METHOD TO DROP A SPECIFIC COLUMN OF AN ARRAY
  @returns Array New Array without the specifiated* column
****************************************************************************/
  function deleteColumn($array, $column){
    for ($i=0; $i < count($array); $i++) {
      unset($array[$i][$column]);
    }
    return $array;
  }
/****************************************************************************
  PENDIENT***
  @returns Array New Array without the specifiated* column
****************************************************************************/
  function changeState($array) {
    for ($i=0; $i < count($array); $i++) {
      if($array[$i]['Estado'] == 0) {
        $array[$i]['Estado'] = 'Deslogueado';
      } else {
        $array[$i]['Estado'] = 'Logueado';
      }
    }
    return $array;
  }
?>
