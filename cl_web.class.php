<?php
/*
Clase     cp_web
Autor:    Carolina
Version:  0.1
Fecha:    2016-09-22
 */

session_start(); //iniciaos la sesión

include 'configs/configuration.php';
require_once 'lib/smarty/Smarty.class.php'; // 2016-09-27_SMARTY_INICIOS

class CLweb
{
    /****************************************************************************
    CLASS VARIABLES
     ****************************************************************************/
    public $cliente = null;
    public $conn    = null;
    public $tabla   = null;

    /****************************************************************************
    DATABASE CONNECTION  METHODS
     ****************************************************************************/
    public function conexion()
    {
        $this->conn = new PDO(DB_ENGINE . ':host=' . DB_IP . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    }

    /****************************************************************************
    METHOD TO GET AN INDEXED ARRAY WITH THE INFORMATION OF A QUERY
    @param   String $query QUERY SQL
     ****************************************************************************/
    public function getAll($query)
    {
        $datos = array();
        foreach ($this->conn->query($query) as $fila) {
            array_push($datos, $fila);
        }
        return $datos;
    }

    /****************************************************************************
    METHOD TO GET AN ASSOCIATIVE ARRAY WITH THE INFORMATION OF A QUERY
    @param   String $query QUERY SQL
     ****************************************************************************/
    public function fetchAll($query)
    {
        $statement = $this->conn->Prepare($query);
        $statement->Execute();
        $datos = $statement->FetchAll(PDO::FETCH_ASSOC);
        return $datos;
    }

    /****************************************************************************
    METHOD INITIALIZE SMARTY TEMPLATES
     ****************************************************************************/
    // 2016-09-27_SMARTY_INICIOS
    public function templateEngine()
    {
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
    public function showList($query, $selected = null, $route = "", $function = null)
    {
        $datos     = $this->getAll($query);
        $nombDatos = array_keys($datos[0]);
        $template  = $this->templateEngine();
        $template->assign('selected', $selected); //2016-10-06
        $template->assign('function', $function);
        $template->assign('datos', $datos);
        $template->assign('nombDatos', $nombDatos);
        //fecth: procesa la plantilla, el resultado lo guarda en una variable
        return $template->fetch($route . 'select.component.html'); //Esto es hermoso T-T
    }

//---------------------------------------------------------------------------------
    public function getArrayID($array, $field)
    {
        $temp = array();
        for ($i = 0; $i < count($array); $i++) {
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
    public function setTabla($tabla)
    {
        //Método para asignar la tabla
        $this->tabla = $tabla;
    }

    /****************************************************************************
    METHOD TO GET THE NAME OF THE TABLE
     ****************************************************************************/
    //2016-10-10
    public function getTabla()
    {
        return $this->tabla;
    }

    /****************************************************************************
    GENERIC METHOD TO UPDATE ANY TABLE
    @param   array  $datos      CONTAINS THE COLUMNS OF GET OR POST
    @param   String $id         INDICATES PRIMARY KEY
    @param   array  $condition  ELEMENTS OF WHERE CONDITION
     ****************************************************************************/
    //2016-10-10
    public function update($datos, $id, $condition = null)
    {
        // die(var_dump($datos));
        $nombresColumnas = $this->getNombresColumnas($datos);
        $columnas        = $this->getColumnas($datos, 'update');

        $where = "";
        if (!empty($condition)) {
            $where                = " where ";
            $nombresColumnasWhere = array_keys($condition);
            for ($i = 0; $i < sizeof($nombresColumnasWhere); $i++) {
                $where .= $nombresColumnasWhere[$i];
                $where .= '=:' . $nombresColumnasWhere[$i];
                if ($i != sizeof($nombresColumnasWhere) - 1) {
                    $where .= ' and ';
                }

            }
        }

        $sql = "update " . $this->getTabla() . " set " . $columnas . $where;
        //echo $sql;
        $stmt = $this->conn->prepare($sql);
        for ($i = 0; $i < sizeof($nombresColumnas); $i++) {
            $stmt->bindParam(':' . $nombresColumnas[$i], $datos[$nombresColumnas[$i]]);
            //echo $nombresColumnas[$i]."-".$datos[$nombresColumnas[$i]]."<br>";
        }
        $pdo = $stmt->execute();

        if (!$pdo) {
            echo "\nPDO::errorInfo():\n";
            print_r($stmt->errorInfo());
            die();
        }
    }

    public function update2($array)
    {
        $sql = "UPDATE ronda SET calif_ronda=" . $array['calif_ronda'] . " WHERE num_ronda=" . $array['num_ronda'] . " and cve_clavadista='" . $array['cve_clavadista'] . "'";
        echo $sql;
        $stmt  = $this->conn->query($sql);
        $OK    = $stmt->execute();
        $error = $stmt->errorInfo();

        if (!$OK) {
            echo $error[2];
        } else {
            echo "Todo bien";
        }
    }

    /****************************************************************************
    GENERIC METHOD TO INSERT ANY TABLE
    @param   array  $datos      CONTAINS THE COLUMNS OF GET OR POST
     ****************************************************************************/
    public function insert($datos)
    {
        $nombresColumnas = $this->getNombresColumnas($datos);
        $columnas[0]     = $this->getColumnas($datos, 'insert');
        $columnas[1]     = ":" . str_replace(',', ',:', $columnas[0]);

        $sql  = "insert into " . $this->getTabla() . " (" . $columnas[0] . ") values(" . $columnas[1] . ")";
        $stmt = $this->conn->prepare($sql);
        for ($i = 0; $i < sizeof($nombresColumnas); $i++) {
            $stmt->bindParam(':' . $nombresColumnas[$i], $datos[$nombresColumnas[$i]]);
        }
        $pdo = $stmt->execute();

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

    public function getColumnas($datos, $accion = null)
    {
        $nombresColumnas = $this->getNombresColumnas($datos);
        $columnas        = "";
        for ($i = 0; $i < sizeof($nombresColumnas); $i++) {
            $columnas .= $nombresColumnas[$i];

            if ($accion == 'update') //si es por update se separa por =:
            {
                $columnas .= '=:' . $nombresColumnas[$i];
            }

            if ($i != sizeof($nombresColumnas) - 1) {
                $columnas .= ',';
            }
            //separa por comas
        }
        return $columnas;
    }

    /****************************************************************************
    GENERIC METHOD TO UPDATE ANY TABLE
    @param   array  $datos      CONTAINS THE COLUMNS OF GET OR POST
     ****************************************************************************/
    //regresa los campos separados por comas y por :=
    public function getNombresColumnas($datos)
    {
        return array_keys($datos);
    }

/****************************************************************************
METHOD THAT RETURNS A QUERY IN HTML SINTAX
@param   String  $query      CONTAINS THE SQL QUERY
 ****************************************************************************/
    //2016-10-13
    public function getQuery2HTML($query)
    {
        $datos    = $this->getAll($query);
        $campos   = $this->getNombresColumnas($datos[0]);
        $template = $this->templateEngine();
        $template->assign('datos', $datos);
        $template->assign('campos', $campos);
        return $template->fetch('query2html2.component.html'); //Esto es hermoso T-T
    }

//------------------------------------------------------------------------------
    public function checarAcceso($rol = null)
    {
        $data = $_SESSION;
        if (isset($data['validado'])) {
            if ($data['validado']) {

            } else {
                header('Location: ../login.php');
            }
        } else {
            header('Location: ../login.php');
        }
    }

//------------------------------------------------------------------------------
    public function indexMessages($msg = "")
    {
        $templates = $this->templateEngine();
        $templates->assign('title', 'SISCACLAO');
        $templates->assign('headerTitle1', 'SISCACLAO');
        $templates->assign('headerTitle2', 'Sistema de Calificación de Clavados Individuales');
        $templates->assign('route1', 'images/logo_header.png');
        $templates->assign('route2', 'images/rio2016.png');
        $templates->assign('msg', '<div class="alert alert-danger" role="alert">' . $msg . '</div>');
        $templates->display('index.html');
    }

} //END OF THE CLASS
//---------------------------------------------------------------------------------

//Incluimos todos los controladores - //2016-09-29 se agregó foreach
// foreach (glob("controllers/*.php") as $nombre_fichero) {
//     include($nombre_fichero);
// }

include 'controllers/login.php';
include 'controllers/registro.php';
include 'controllers/admin/usuarios.php';
include 'controllers/admin/clavadistas.php';
include 'controllers/admin/clavados.php';

$web = new CLweb;
$web->conexion();
$template = $web->templateEngine(); //2016-09-27_SMARTY_INICIOS
