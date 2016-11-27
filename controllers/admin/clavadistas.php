<?php
class Clavadistas extends CLweb
{
    /****************************************************************************
    CLASS VARIABLES
     ****************************************************************************/
    public $temp = null;

//---------------------------------------------------------------------------------
    public function setTemplate($template = '../templates/admin/')
    {
        $this->temp = $this->templateEngine();
        $this->temp->setTemplateDir($template);
    }
//---------------------------------------------------------------------------------
    public function assignTemplate($name, $var)
    {
        echo $name . "<br>";
        echo $var;
        $this->temp->assign($name, $var);
    }
//---------------------------------------------------------------------------------
    public function displayTemplate($name, $var)
    {
        $this->temp->display($name, $var);
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
    public function showTemplate($elements, $extra = null, $table = null)
    {
        $this->temp->assign('title', $elements['title']);
        $this->temp->assign('headerTitle1', $elements['headerTitle1']);
        $this->temp->assign('headerTitle2', $elements['headerTitle2']);
        $this->temp->assign('nombre_usuario', $elements['nombre_usuario']);

        if (!isset($extra['type']) && !isset($extra['msg'])) { //array = ""
            $this->temp->assign('msg', ""); //sin mensaje
        } else {
            $msg = $this->assignTypeMessage($extra['type'], $extra['msg']); //crea el mensaje
            $this->temp->assign('msg', $msg); //con mensaje
        }

        if (!isset($table['rows']) && !isset($table['columns'])) { //array = ""
            $this->temp->assign('columns', ""); //sin tabla
            $this->temp->assign('rows', ""); //sin tabla
        } else {
            $this->temp->assign('columns', $table['columns']); //2016-10-06
            $this->temp->assign('rows', $table['rows']);
        }

        $this->temp->display($elements['template']);
    }
//---------------------------------------------------------------------------------
    public function assignTypeMessage($type, $msg)
    {
        return '<div class="alert alert-' . $type . '" role="alert">' . $msg . '</div>';
    }

    /**
     * Elimina un clavadista
     * @param  String $cve_clavadista ID del clavadista a eliminar
     * @return void
     */
    public function deleteClavadista($cve_clavadista)
    {
        $sql  = "DELETE FROM clavadista WHERE cve_clavadista= :cve_clavadista";
        $stmt = $this->conn->Prepare($sql);
        $stmt->bindParam(':cve_clavadista', $cve_clavadista, PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Realiza una consulta para obtener un clavadista específico
     * @param  String $cve_clavadista ID para obtener el clavadista específico
     * @return array                  Resultados del query realizado
     */
    public function getClavadista($cve_clavadista)
    {
        $clavadista = array();
        $statement  = $this->conn->Prepare("select * from clavadista where cve_clavadista='" . $cve_clavadista . "'");
        $statement->Execute();
        $clavadista = $statement->FetchAll(PDO::FETCH_ASSOC);

        return $clavadista;
    }

}
