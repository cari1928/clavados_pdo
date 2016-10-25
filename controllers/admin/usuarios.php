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

//-------------------------------------------------------------------------------------------------
    function showTemplate($title="", $headerTitle1, $headerTitle2, $nombre_usuario,
        $template){
      $this->temp->assign('title', $title);
      $this->temp->assign('headerTitle1', $headerTitle1);
      $this->temp->assign('headerTitle2', $headerTitle2);
      $this->temp->assign('nombre_usuario', $nombre_usuario);
      $this->temp->display($template);
    }
  }
?>
