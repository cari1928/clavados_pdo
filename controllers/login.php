<?php
  //2016-10-20
  class Login extends CLweb {

    function newLogin($nombre_usuario, $pass, $elementos=null) {
      $pass = md5($pass);
      $sql = "select * from usuario where nombre_usuario='".$nombre_usuario."' and pass='".$pass."'";
      $data = $this->fetchAll($sql);

      if(isset($data[0])){
        //si el usuario no es administrador ni juez o si ya está logueado
        if(($data[0]['cve_rol'] != 'A' && $data[0]['cve_rol'] != 'J') || $data[0]['estado'] == 1){
          $this->indexMessages('Acceso denegado');
          die();
        }

        unset($data[0]['pass']); //se destruye la contraseña
        $_SESSION['nombre_usuario'] = $data[0]['nombre_usuario'];
        $_SESSION['cve_rol'] = $data[0]['cve_rol'];
        $_SESSION['validado'] = true;

        $this->setTabla("usuario");
        $this->update(
          array('estado'=>$elementos['estado'], 'nombre_usuario'=>$elementos['nombre_usuario']),
          $elementos['nombre_usuario'],
          array('nombre_usuario'=>$elementos['nombre_usuario']));

        if($data[0]['cve_rol'] == 'A'){
          header('Location: admin');
        } elseif ($data[0]['cve_rol'] == 'J'){
          header('Location: juez');
        }else{ //el usuario no tiene rol
          $this->indexMessages('Acceso denegado');
        }
      } else{
        $this->logout();
        header("Location: index.php");
      }
    }
//------------------------------------------------------------------------------
    function logout(){
      $this->setTabla("usuario");
      $this->update(
        array('estado'=> 0, 'nombre_usuario'=>$_SESSION['nombre_usuario']),
        $_SESSION['nombre_usuario'],
        array('nombre_usuario'=>$_SESSION['nombre_usuario']));

        session_destroy(); //se destruye la sesion
    }
  }
?>
