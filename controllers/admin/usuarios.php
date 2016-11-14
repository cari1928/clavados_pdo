<?php
  class Usuarios extends CLweb {
    /****************************************************************************
      CLASS VARIABLES
    ****************************************************************************/
    var $temp = null;

//---------------------------------------------------------------------------------
    function setTemplate($template='../templates/admin/'){
      $this->temp = $this->templateEngine();
      $this->temp->setTemplateDir($template);
    }
//---------------------------------------------------------------------------------
    function assignTemplate($name, $var){
      $this->temp->assign($name, $var);
    }

/*********************************************************************************
    METHOD TO SET A CUSTOM TEMPLATE
    @param   Array  elements  Contains all the template information
                @param   String title           The content of the html title tag
                @param   String headerTitle1    First title's html Header tag
                @param   String headerTitle2    Second title's html Header tag
                @param   String nombre_usuario  The content of $_SESSION
                @param   String template        Destiny html template
    @param   Array  extra           Used to show a message, only for some web pages
                @param String type  Indicates a ERROR or INFO message
                @param String msg   The content of the message
    @param   Array  table
  *******************************************************************************/
    function showTemplate($elements, $extra=null, $table=null){
      $this->temp->assign('title', $elements['title']);
      $this->temp->assign('headerTitle1', $elements['headerTitle1']);
      $this->temp->assign('headerTitle2', $elements['headerTitle2']);
      $this->temp->assign('nombre_usuario', $elements['nombre_usuario']);

      if(!isset($extra['type']) && !isset($extra['msg'])){ //array = ""
        $this->temp->assign('msg', ""); //sin mensaje
      } else {
        $msg = $this->assignTypeMessage($extra['type'], $extra['msg']); //crea el mensaje
        $this->temp->assign('msg', $msg); //con mensaje
      }

      if(!isset($table['rows']) && !isset($table['columns'])){ //array = ""
        $this->temp->assign('columns', ""); //sin tabla
        $this->temp->assign('rows', ""); //sin tabla
      } else {
        $this->temp->assign('columns', $table['columns']); //2016-10-06
        $this->temp->assign('rows', $table['rows']);
      }

      $this->temp->display($elements['template']);
    }
//---------------------------------------------------------------------------------
    function assignTypeMessage($type, $msg){
      return '<div class="alert alert-'.$type.'" role="alert">'.$msg.'</div>';
    }
//---------------------------------------------------------------------------------
    function deleteUser($nombre_usuario){ //2016-09-29
      // $count = $this->conn->exec("DELETE FROM usuario WHERE nombre_usuario=".$nombre_usuario);
      //Esto previene inyección SQL!!!
      $sql = "DELETE FROM usuario WHERE nombre_usuario= :nombre_usuario";
      $stmt = $this->conn->Prepare($sql);
      $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
      $stmt->execute();
    }
//---------------------------------------------------------------------------------
    function getUsuario($nombre_usuario){
      $usuario = array();
      $statement = $this->conn->Prepare("select * from usuario where nombre_usuario='".$nombre_usuario."'");
      $statement->Execute();
      $usuario =  $statement->FetchAll(PDO::FETCH_ASSOC);

      return $usuario;
    }
    
    /*Utilizado para eliminar datos de las tablas:
        *enviarDatosJuez
        *enviarDatos        
        *clavado
    */
    function deleteAll($table) { 
      $sql = "DELETE FROM ".$table;
      $stmt = $this->conn->Prepare($sql);
      //$stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
      $stmt->execute();
    } 
  }

?>
