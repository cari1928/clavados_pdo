<?php
  class Usuarios extends CLweb {
    /****************************************************************************
      CLASS VARIABLES
    ****************************************************************************/
    var $temp = null;

//-------------------------------------------------------------------------------------------------
    function setTemplate(){
      $this->temp = $this->templateEngine();
      $this->temp->setTemplateDir('../templates/admin/');
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
    @param   Template  table  Contains a table.component.html template
  *******************************************************************************/
    function showTemplate($elements, $extra=null, $table=null){
      $this->temp->assign('title', $elements['title']);
      $this->temp->assign('headerTitle1', $elements['headerTitle1']);
      $this->temp->assign('headerTitle2', $elements['headerTitle2']);
      $this->temp->assign('nombre_usuario', $elements['nombre_usuario']);

      if(!isset($extra['type']) && !isset($extra['msg'])){ //array = ""
        $this->temp->assign('errorMsg', $extra); //sin mensaje
      } else {
        $msg = assignTypeMessage($extra['type'], $extra['msg']); //crea el mensaje
        $this->temp->assign('errorMsg', $msg); //con mensaje
      }

      if($table != null) { //se mostrará una tabla
        $this->temp->assign('table', $table);
      }

      $this->temp->display($elements['template']);
    }
//-------------------------------------------------------------------------------------------------
    function assignTypeMessage($type, $msg){
      return '<div class="alert alert-'.$type.'" role="alert">'.$msg.'</div>';
    }
  }
?>
