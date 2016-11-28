<?php
include '../cl_web.class.php';

$web = new Clavadistas;
$web->conexion();
$web->checarAcceso(); //para evitar acceso a clavadistas no logueados

$templates = $web->templateEngine();

if (isset($_GET['action'])) {

    switch ($_GET['action']) {
        case 'insert':
            $web->setTabla("clavadista");
            $web->insert($_POST);
            header('Location: clavadistas.php');
            break;

        case 'form_update':
            $templates->setTemplateDir('../templates/admin/');
            $clavadista = $web->getClavadista($_GET['cve_clavadista']);

            // die(var_dump($clavadista));

            $cmb_nacionalidad = $web->showList("select cve_nacionalidad, descripcion from nacionalidad order by cve_nacionalidad", $clavadista[0]['cve_nacionalidad']);
            $cmb_genero       = $web->showList("select cve_genero, genero from genero order by cve_genero", $clavadista[0]['cve_genero']);

            $templates->assign('clavadista', $clavadista[0]);
            $templates->assign('cmb_nacionalidad', $cmb_nacionalidad);
            $templates->assign('cmb_genero', $cmb_genero);
            messages($templates, "form_clavadistas.html");
            die();
            break;

        case 'delete':
            $web->deleteClavadista($_GET['cve_clavadista']);
            header('Location: clavadistas.php');
            break;

        case 'form_insert':
            $templates->setTemplateDir('../templates/admin/');

            $cmb_nacionalidad = $web->showList("select cve_nacionalidad, descripcion from nacionalidad order by cve_nacionalidad");
            $cmb_genero       = $web->showList("select cve_genero, genero from genero order by cve_genero");

            $templates->assign('cmb_nacionalidad', $cmb_nacionalidad);
            $templates->assign('cmb_genero', $cmb_genero);
            messages($templates, 'form_clavadistas.html');
            die();
            break;

        case 'update':
            $web->setTabla('clavadista');
            $web->update($_POST, null, array(
                'cve_clavadista' => $_POST['cve_clavadista'],
            ));
            header('Location: clavadistas.php');
            break;

        case 'orden':
            $templates->setTemplateDir('../templates/admin/');
            $clavadista = $web->getClavadista($_GET['cve_clavadista']);

            if ($clavadista[0]['cve_genero'] == 'F') {
                $numero_rondas = 5;
            } else {
                $numero_rondas = 6;
            }

            // $cmb_clavados = $web->showList("select cve_clavado, clavado from clavado order by cve_clavado", null, "", "difficultyValue(this);");

            //arreglo con dificultades
            $dificultades = $web->getClavados("select clavado, dificultad from clavado");

            $sql   = "select cve_clavado, clavado from clavado order by cve_clavado";
            $datos = $web->getAll($sql);

            $templates->assign('clavadista', $clavadista[0]);
            $templates->assign('datos', $datos);
            $templates->assign('nombDatos', 'cve_clavado');
            $templates->assign('dificultades', $dificultades);
            $templates->assign('numero_rondas', $numero_rondas);
            messages($templates, 'form_orden.html');
            die();
            break;

        case 'insert_orden':
            echo "<pre>";
            die(print_r($_POST));

            $web->setTabla("orden_clavados");
            $web->insert($_POST);
            header('Location: clavadistas.php');
            break;
    }
}

$rows = $web->fetchAll("
    select cve_clavadista 'Clave', nombre_completo 'Nombre', genero 'Genero', descripcion 'Nacionalidad', bandera 'Bandera'
      from clavadista inner join genero on clavadista.cve_genero = genero.cve_genero
                      inner join nacionalidad on clavadista.cve_nacionalidad = nacionalidad.cve_nacionalidad
    ");

if (count($rows) == 0) {
    //si la consulta no arrojó algo $web->setTemplate();
    $web->showTemplate(getElements(), array(
        'type' => 'danger',
        'msg'  => 'No existen clavadistas',
    ));
    die();
}

$columns = $web->getNombresColumnas($rows[0]);

$web->setTemplate(); //prepara smarty
$web->showTemplate(getElements(), null, array(
    'rows'    => $rows,
    'columns' => $columns,
));

/**
 * Obtiene un arreglo indexado con información específica de un template
 * @param  string $title        Título de la pestaña de la página
 * @param  string $headerTitle1 Título Grande del Header
 * @param  string $headerTitle2 Título Pequeño del Header
 * @param  string $template     Archivo HTML a mostrar con display
 * @return array                Contiene los parámetros ordenados en el arreglo
 */
function getElements($title = "Administrador", $headerTitle1 = "SISCACLAO",
    $headerTitle2 = "Gestión de Clavadistas", $template = "clavadista.html") {
    return array('title' => $title, 'headerTitle1'          => $headerTitle1,
        'headerTitle2'       => $headerTitle2, 'nombre_usuario' => $_SESSION['nombre_usuario'],
        'template'           => $template);
}

/**
 * Elimina una columna específica de un arreglo
 * @param  Array $array  Arreglo al cual se eliminará un campo
 * @param  String $column Columna a eliminar del arreglo
 * @return Array         Arreglo sin el elemento eliminado
 */
function deleteColumn($array, $column)
{
    for ($i = 0; $i < count($array); $i++) {
        unset($array[$i][$column]);
    }
    return $array;
}

/**
 * Gestiona el contenido y muestreo de mensajes al usuario
 * @param  String $templates Objeto de tipo template para poder usar los metos asign y display
 * @param  String $template  Nombre del archivo html que se mostrará con display
 * @param  string $msg       Contenido del mensaje
 * @param  String $type      Clase bootstrap para diseñar el mensaje
 * @return void
 */
function messages($templates, $template, $msg = "", $type = null)
{

    if ($type == "warning") {
        $msg = '<div class="alert alert-danger" role="alert">' . $msg . '</div>';
    } else if ($type == "info") {
        $msg = '<div class="alert alert-success" role="alert">' . $msg . '</div>';
    }

    $templates->assign('title', 'Administrador');
    $templates->assign('headerTitle1', 'SISCACLAO');
    $templates->assign('headerTitle2', 'Sistema de Registro de Clavadistas');
    $templates->assign('nombre_usuario', $_SESSION['nombre_usuario']);
    $templates->assign('msg', $msg);
    $templates->display($template);
}
