<?php
  //2016-10-20
  class Login extends CLweb {

// select * from usuario where nombre_usuario='Juan' and pass='81dc9bdb52d04dc20036dbd8313ed055'
    function newLogin($nombre_usuario, $pass) {
      $pass = md5($pass);
      $sql = "select * from usuario where nombre_usuario='".$nombre_usuario."' and pass='".$pass."'";
      $data = $this->fetchAll($sql);

      if(isset($data[0])){

        //si el usuario no es administrador ni juez
        if($data[0]['cve_rol'] != 'A' && $data[0]['cve_rol'] != 'J'){
          $this->logout();
          die();
        }

        if($data[0]['estado'] == 1){ //ya hay alguien logueado
          $templates->assign('title', 'SISCACLAO');
          $templates->assign('headerTitle1', 'SISCACLAO');
          $templates->assign('headerTitle2', 'Sistema de Calificación de Clavados Individuales');
          $templates->assign('route1', 'images/logo_header.png');
          $templates->assign('route2', 'images/rio2016.png');
          $templates->assign('msg', '<div class="alert alert-danger" role="alert"> Acceso denegado </div>');
        	$templates->display('index.html');
          die();
        }

        unset($data[0]['pass']); //se destruye la contraseña
        $_SESSION['nombre_usuario'] = $data[0]['nombre_usuario'];
        $_SESSION['cve_rol'] = $data[0]['cve_rol'];
        $_SESSION['validado'] = true;



        $web->setTabla("usuario");
        $estado = array('id_cliente'=>$_POST['id_cliente']);
        $web->update($_POST, $_POST['id_cliente'],array('id_cliente'=>$_POST['id_cliente']));


        if($data[0]['cve_rol'] == 'A'){
          header('Location: admin');
        }
        elseif ($data[0]['cve_rol'] == 'J'){
          header('Location: juez');
        }
      }
      else{
        $this->logout();
        header("Location: index.php");
      }
    }
//------------------------------------------------------------------------------
    function logout(){
      session_destroy(); //se destruye la sesion
    }
  }
?>
