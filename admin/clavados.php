<?php
include '../cl_web.class.php';

$templates = $web->templateEngine();
$web       = new Clavados;
$web->conexion();
$web->checarAcceso(); //para evitar acceso a clavadistas no logueados

if (isset($_GET['action'])) {

    switch ($_GET['action']) {
        case 'insert':
            $web->setTabla("clavado");
            $web->insert($_POST);
            header('Location: clavados.php');
            break;

        case 'form_update':
            $templates->setTemplateDir('../templates/admin/');
            $clavado = $web->getClavado($_GET['cve_clavado']);

            $templates->assign('clavado', $clavado[0]);
            messages($templates, 'form_clavados.html');
            die();
            break;

        case 'delete':
            $web->deleteClavado($_GET['cve_clavado']);
            header('Location: clavados.php');
            break;

        case 'form_insert': //muestra el formulario para que el admin inserte nuevo clavado
            $templates->setTemplateDir('../templates/admin/');
            messages($templates, 'form_clavados.html');
            die();
            break;

        case 'update':
            $web->setTabla('clavado');
            $web->update($_POST, null, array(
                'cve_clavado' => $_POST['cve_clavado'],
            ));
            header('Location: clavados.php');
            break;
    }
}

$rows = $web->fetchAll("
    select cve_clavado 'Clave', clavado 'Clavado', dificultad 'Dificultad'
      from clavado order by cve_clavado
    ");

if (count($rows) == 0) {
    //si la consulta no arrojó algo $web->setTemplate();
    $web->showTemplate(getElements(), array(
        'type' => 'danger',
        'msg'  => 'No existen Clavados',
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
 * Se obtiene un arreglo indexado con la información específica de un template
 * @param  string $title        Título de la página HTML
 * @param  string $headerTitle1 Título Grande a mostrar en el header
 * @param  string $headerTitle2 Título Pequeño a mostrar en el header
 * @param  string $template     Nombre del archivo html a mostrar con display
 * @return array                Contiene un arreglo que contiene los parámetros introducidos
 */
function getElements($title = "Administrador", $headerTitle1 = "SISCACLAO",
    $headerTitle2 = "Gestión de Clavados", $template = "clavados.html") {
    return array(
        'title'          => $title,
        'headerTitle1'   => $headerTitle1,
        'headerTitle2'   => $headerTitle2,
        'nombre_usuario' => $_SESSION['nombre_usuario'],
        'template'       => $template,
    );
}

/**
 * Elimina una columna específica de un arreglo
 * @param  [type] $array  Arreglo al cual se eliminará el campo
 * @param  [type] $column Campo a eliminar
 * @return array         Nuevo arreglo sin el campo especificado
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
    $templates->assign('headerTitle2', 'Sistema de Registro de Clavados');
    $templates->assign('nombre_usuario', $_SESSION['nombre_usuario']);
    $templates->assign('msg', $msg);
    $templates->display($template);
}
