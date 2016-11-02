<?php
  include('../cl_web.class.php');

  $web = new Clavadistas;
  $web->conexion();
  $web->checarAcceso(); //para evitar acceso a clavadistas no logueados

  $templates = $web->templateEngine();

  if(isset($_GET['action'])) {

    switch ($_GET['action']) {
      case 'insert':
          $web->setTabla("clavadista");
          $web->insert($_POST);
          header('Location: clavadistas.php');
        break;

      case 'form_update':
          $templates->setTemplateDir('../templates/admin/');
          $clavadista = $web->getUsuario($_GET['cve_clavadista']);

          die(var_dump($clavadista));

          $combo_rol = $web->showList("select * from rol", $clavadista[0]['cve_rol']);
          $templates->assign('clavadista', $clavadista[0]);
          $templates->assign('combo_rol', $combo_rol);
          messages($templates);
          die();
        break;

      case 'delete':
          $web->deleteUser($_GET['nombre_clavadista']);
          header('Location: clavadistas.php');
        break;

      case 'form_insert':
          $templates->setTemplateDir('../templates/admin/');
          $cmb_nacionalidad = $web->showList("select cve_nacionalidad, descripcion from nacionalidad");
          $cmb_genero = $web->showList('select * from genero');
          $cmb_tipo_clavado = $web->showList('select * from tipo_clavado');


          $web->assignTemplate('cmb_nacionalidad', $cmb_nacionalidad);
          die(var_dump($cmb_tipo_clavado));
          $web->assignTemplate('cmb_genero', $cmb_genero);
          $web->assignTemplate('cmb_tipo_clavado', $cmb_tipo_clavado);
          messages($templates, 'form_insert.html');
          die();
        break;

      case 'update':
          if(empty($_POST['pass'])){
            unset($_POST['pass']); //destruye campo de POST
          } else{
            $_POST['pass'] = md5($_POST['pass']); //encriptcaión de la nueva contraseña
          }

          $web->setTabla('clavadista');
          $web->update($_POST, $_POST['nombre_clavadista'],array('nombre_clavadista'=>$_POST['nombre_clavadista']));
          header('Location: clavadistas.php');
        break;
    }
  }

  $rows = $web->fetchAll("
    select cve_clavadista 'Clave', nombre_completo 'Nombre', genero 'Genero', descripcion 'Nacionalidad', bandera 'Bandera'
      from clavadista inner join genero on clavadista.cve_genero = genero.cve_genero
                      inner join nacionalidad on clavadista.cve_nacionalidad = nacionalidad.cve_nacionalidad
    ");

  if(count($rows) == 0){ //si la consulta no arrojó algo $web->setTemplate();
    $web->showTemplate(getElements(),
      array('type'=>'danger', 'msg'=>'No existen clavadistas'));
    die();
  }

  $columns = $web->getNombresColumnas($rows[0]);

  $web->setTemplate(); //prepara smarty
  $web->showTemplate(getElements(), null, array('rows'=>$rows, 'columns'=>$columns));

/****************************************************************************
  FUNCTIONS
/****************************************************************************
  METHOD TO GET AN INDEXED ARRAY WITH THE SPECIFIC* INFORMATION OF A TEMPLATE
****************************************************************************/
  function getElements($title="Administrador", $headerTitle1="SISCACLAO",
    $headerTitle2="Gestión de Clavadistas", $template="clavadista.html") {
      return array('title'=>$title,'headerTitle1'=>$headerTitle1,
            'headerTitle2'=>$headerTitle2, 'nombre_usuario'=>$_SESSION['nombre_usuario'],
            'template'=>$template);
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
//----------------------------------------------------------------------------------
	function messages($templates, $template, $msg="", $type=null){

		if($type == "warning"){
			$msg = '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
		}
		else if($type == "info"){
			$msg = '<div class="alert alert-success" role="alert">'.$msg.'</div>';
		}

		$templates->assign('title', 'Administrador');
	  $templates->assign('headerTitle1', 'SISCACLAO');
	  $templates->assign('headerTitle2', 'Sistema de Registro de Clavadistas');
    $templates->assign('nombre_usuario', $_SESSION['nombre_usuario']);
		$templates->assign('msg', $msg);
		$templates->display($template);
	}
?>
