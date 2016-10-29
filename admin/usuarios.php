<?php
  include('../cl_web.class.php');

  $web = new Usuarios;
  $web->conexion();
  $web->checarAcceso(); //para evitar acceso a usuarios no logueados

  $templates = $web->templateEngine();

  if(isset($_GET['action'])) {

    switch ($_GET['action']) {
      case 'insert':
          if($_POST['pass'] != $_POST['vpass']){
            $templates->setTemplateDir('../templates/admin/');
            messages($templates, "Las contraseñas no coinciden", "warning");
            die();
          }

          unset($_POST['vpass']); //destruye el campo
          $web->setTabla("usuario");
          $_POST['pass'] = md5($_POST['pass']);
          var_dump($_POST);
          // die();
          $web->insert($_POST);
          header('Location: usuarios.php');
        break;

      case 'form_update':
          $templates->setTemplateDir('../templates/admin/');
          $usuario = $web->getUsuario($_GET['nombre_usuario']);
          $combo_rol = $web->showList("select * from rol", $usuario[0]['cve_rol']);
          $templates->assign('usuario', $usuario[0]);
          $templates->assign('combo_rol', $combo_rol);
          messages($templates);
          die();
        break;

      case 'delete':
          $web->deleteUser($_GET['nombre_usuario']);
          header('Location: usuarios.php');
        break;

      case 'form_insert':
          $templates->setTemplateDir('../templates/admin/');
          messages($templates);
          die();
        break;

      case 'update':
          if(empty($_POST['pass'])){
            unset($_POST['pass']); //destruye campo de POST
          } else{
            $_POST['pass'] = md5($_POST['pass']); //encriptcaión de la nueva contraseña
          }

          $web->setTabla('usuario');
          $web->update($_POST, $_POST['nombre_usuario'],array('nombre_usuario'=>$_POST['nombre_usuario']));
          header('Location: usuarios.php');
        break;
    }
  }

  $rows = $web->fetchAll("
    select nombre_usuario 'Usuario', nombre_real 'Nombre', estado 'Estado', rol 'Rol'
     from usuario inner join rol on usuario.cve_rol = rol.cve_rol
     where nombre_usuario not in (select nombre_usuario from usuario where nombre_usuario='".$_SESSION['nombre_usuario']."')
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
  $web->showTemplate(getElements(), null, array('rows'=>$rows, 'columns'=>$columns));

/****************************************************************************
  FUNCTIONS
/****************************************************************************
  METHOD TO GET AN INDEXED ARRAY WITH THE SPECIFIC* INFORMATION OF A TEMPLATE
****************************************************************************/
  function getElements($title="Administrador", $headerTitle1="SISCACLAO",
    $headerTitle2="Gestión de Usuarios", $template="usuarios.html") {
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

//----------------------------------------------------------------------------------
	function messages($templates, $msg="", $type=null){

		if($type == "warning"){
			$msg = '<div class="alert alert-danger" role="alert">'.$msg.'</div>';
		}
		else if($type == "info"){
			$msg = '<div class="alert alert-success" role="alert">'.$msg.'</div>';
		}

		$templates->assign('title', 'Administrador');
	  $templates->assign('headerTitle1', 'SISCACLAO');
	  $templates->assign('headerTitle2', 'Sistema de Registro de Usuarios');
    $templates->assign('nombre_usuario', $_SESSION['nombre_usuario']);
		$templates->assign('msg', $msg);
		$templates->display('../registro.html');
	}
?>
