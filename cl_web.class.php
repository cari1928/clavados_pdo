<?php
/*
  Clase     cp_web
  Autor:    Carolina
  Version:  0.1
  Fecha:    2016-09-22
*/

session_start(); //iniciaos la sesión

include('configs/configuration.php');
require_once('lib/smarty/Smarty.class.php'); // 2016-09-27_SMARTY_INICIOS

class CLweb {
  /****************************************************************************
    CLASS VARIABLES
  ****************************************************************************/
  var $cliente = null;
  var $conn = null;
  var $tabla = null;

  /****************************************************************************
    DATABASE CONNECTION  METHODS
  ****************************************************************************/
  function conexion() {
    $this->conn = new PDO (DB_ENGINE.':host='.DB_IP.';dbname='.DB_NAME, DB_USER, DB_PASS);
  }

  /****************************************************************************
    METHOD TO GET AN INDEXED ARRAY WITH THE INFORMATION OF A QUERY
    @param   String $query QUERY SQL
  ****************************************************************************/
  function getAll($query) {
    $datos = array();
    foreach($this->conn->query($query) as $fila) {
      array_push($datos, $fila);
    }
    return $datos;
  }

  /****************************************************************************
    METHOD TO GET AN ASSOCIATIVE ARRAY WITH THE INFORMATION OF A QUERY
    @param   String $query QUERY SQL
  ****************************************************************************/
  function fetchAll($query){
    $statement = $this->conn->Prepare($query);
    $statement->Execute();
    $datos = $statement->FetchAll(PDO::FETCH_ASSOC);
    return $datos;
  }

  /****************************************************************************
    METHOD INITIALIZE SMARTY TEMPLATES
  ****************************************************************************/
  // 2016-09-27_SMARTY_INICIOS
  function templateEngine() {
    $smarty = new Smarty(); //instancia la variable smarty
    $smarty->setTemplateDir(TEMPLATE);
    $smarty->setCompileDir(TEMPLATE_C);
    $smarty->setConfigDir(CONFIGS);
    $smarty->setCacheDir(CACHE);
    return $smarty;
  }

  /****************************************************************************
    METHOD TO GET HTML CODE OF A DROPDOWN LIST
    @param   String $query QUERY SQL
    @param   int $selected ELEMNT TO SELECT
  ****************************************************************************/
  //2016-10-04, regresa un arreglo asociativo, es para hacer combo
  function showList($query, $selected=null, $route=""){
    $datos = $this->getAll($query);
    $nombDatos = array_keys($datos[0]);
    $template = $this->templateEngine();
    $template->assign('selected', $selected); //2016-10-06
    $template->assign('datos', $datos);
    $template->assign('nombDatos', $nombDatos);
    //fecth: procesa la plantilla, el resultado lo guarda en una variable
    return $template->fetch($route.'select.component.html'); //Esto es hermoso T-T
  }

//---------------------------------------------------------------------------------
  function getArrayID($array, $field){
    $temp = array();
    for ($i=0; $i < count($array); $i++) {
      array_push($temp, $array[$i][$field]);
    }
    // die(var_dump($temp));
    return $temp;
  }

  /****************************************************************************
    METHOD TO STABLISH THE MANIPULATED TABLE
    @param   array $tabla CONTAINS THE COLUMNS OF GET OR POST TABLE
  ****************************************************************************/
  //2016-10-10
  function setTabla($tabla){ //Método para asignar la tabla
    $this->tabla = $tabla;
  }

  /****************************************************************************
    METHOD TO GET THE NAME OF THE TABLE
  ****************************************************************************/
  //2016-10-10
  function getTabla(){
    return $this->tabla;
  }

  /****************************************************************************
    GENERIC METHOD TO UPDATE ANY TABLE
    @param   array  $datos      CONTAINS THE COLUMNS OF GET OR POST
    @param   String $id         INDICATES PRIMARY KEY
    @param   array  $condition  ELEMENTS OF WHERE CONDITION
  ****************************************************************************/
  //2016-10-10
  function update($datos, $id, $condition=null){
    // die(var_dump($datos));
    $nombresColumnas = $this->getNombresColumnas($datos);
    $columnas = $this->getColumnas($datos, 'update');

    $where = "";
    if(!empty($condition)){
      $where = " where ";
      $nombresColumnasWhere = array_keys($condition);
      for ($i=0; $i < sizeof($nombresColumnasWhere); $i++) {
        $where.= $nombresColumnasWhere[$i];
        $where.= '=:'.$nombresColumnasWhere[$i];
        if($i != sizeof($nombresColumnasWhere) - 1)
            $where.= ' and ';
      }
    }

    $sql = "update ".$this->getTabla()." set ".$columnas.$where;
    $stmt = $this->conn->prepare($sql);
    for ($i=0; $i < sizeof($nombresColumnas); $i++) {
      $stmt->bindParam(':'.$nombresColumnas[$i], $datos[$nombresColumnas[$i]]);
    }
    $pdo=$stmt->execute();

    if (!$pdo) {
      echo "\nPDO::errorInfo():\n";
      print_r($stmt->errorInfo());
      die();
    }
  }

  /****************************************************************************
    GENERIC METHOD TO INSERT ANY TABLE
    @param   array  $datos      CONTAINS THE COLUMNS OF GET OR POST
  ****************************************************************************/
    function insert($datos){
      $nombresColumnas = $this->getNombresColumnas($datos);
      $columnas[0] = $this->getColumnas($datos, 'insert');
      $columnas[1] = ":".str_replace(',', ',:', $columnas[0]);

      $sql = "insert into ".$this->getTabla()." (".$columnas[0].") values(".$columnas[1].")";
      $stmt = $this->conn->prepare($sql);
      for ($i=0; $i < sizeof($nombresColumnas); $i++) {
        $stmt->bindParam(':'.$nombresColumnas[$i], $datos[$nombresColumnas[$i]]);
      }
      $pdo=$stmt->execute();

      if (!$pdo) {
        echo "\nPDO::errorInfo():\n";
        print_r($stmt->errorInfo());
        die();
      }
    }

  /****************************************************************************
    RETURNS THE COLUMNS INGRESED SEPARATED WITH COMMAS OR ,=:
    @param   array    $datos  CONTAINS THE COLUMNS OF THE TABLE
    @param   String   $accion INDICATES THE DML OPERATION: INSERT OR UPDATE
  ****************************************************************************/

    function getColumnas($datos, $accion=null){
      $nombresColumnas = $this->getNombresColumnas($datos);
      $columnas = "";
      for ($i=0; $i < sizeof($nombresColumnas); $i++) {
        $columnas.= $nombresColumnas[$i];

        if($accion == 'update') //si es por update se separa por =:
            $columnas.= '=:'.$nombresColumnas[$i];

        if($i != sizeof($nombresColumnas) - 1)
            $columnas.= ','; //separa por comas
      }
      return $columnas;
    }

  /****************************************************************************
    GENERIC METHOD TO UPDATE ANY TABLE
    @param   array  $datos      CONTAINS THE COLUMNS OF GET OR POST
  ****************************************************************************/
     //regresa los campos separados por comas y por :=
    function getNombresColumnas($datos){
      return array_keys($datos);
    }

/****************************************************************************
    METHOD THAT RETURNS A QUERY IN HTML SINTAX
    @param   String  $query      CONTAINS THE SQL QUERY
  ****************************************************************************/
    //2016-10-13
    function getQuery2HTML($query){
      $datos = $this->getAll($query);
      $campos = $this->getNombresColumnas($datos[0]);
      $template = $this->templateEngine();
      $template->assign('datos', $datos);
      $template->assign('campos', $campos);
      return $template->fetch('query2html2.component.html'); //Esto es hermoso T-T
    }

//------------------------------------------------------------------------------
     function checarAcceso($rol=null){
       $data = $_SESSION;
       if(isset($data['validado'])){
         if($data['validado']){

         }else{
           header('Location: ../login.php');
         }
       }else{
         header('Location: ../login.php');
       }
     }

//------------------------------------------------------------------------------
  function indexMessages($msg=""){
    $templates = $this->templateEngine();
    $templates->assign('title', 'SISCACLAO');
    $templates->assign('headerTitle1', 'SISCACLAO');
    $templates->assign('headerTitle2', 'Sistema de Calificación de Clavados Individuales');
    $templates->assign('route1', 'images/logo_header.png');
    $templates->assign('route2', 'images/rio2016.png');
    $templates->assign('msg', '<div class="alert alert-danger" role="alert">'.$msg.'</div>');
    $templates->display('index.html');
  }

} //END OF THE CLASS
//-----------------------------------------------------------------------------------------------

//Incluimos todos los controladores - //2016-09-29 se agregó foreach
  // foreach (glob("controllers/*.php") as $nombre_fichero) {
  //     include($nombre_fichero);
  // }

 include('controllers/login.php');
 include('controllers/registro.php');
 include('controllers/admin/usuarios.php');

$web = new CLweb;
$web->conexion();
$template = $web->templateEngine(); //2016-09-27_SMARTY_INICIOS
?>
