<?php
include '../cl_web.class.php';

$web = new Usuarios;

$web->conexion(); //para poder realizar consultas sobre la bd
$web->checarAcceso(); //restringe el acceso
$web->setTemplate('../templates/admin/'); //inicializa template

$msg = null;

//var_dump($_POST);

if (isset($_POST['nueva_ronda'])) {

    $sql    = "select calif_ronda from ronda where calif_ronda is null";
    $result = $web->fetchAll($sql);

    if (count($result) > 0) {
        $msg = array('type' => 'danger', 'msg' => 'No es posible');
    } else {
        $web->deleteAll('enviardatosjuez');
        $web->deleteAll('enviardatos');

        //borrar datos de archivos
        file_put_contents("datos.txt", "");
        file_put_contents("datos2.txt", "");

        $msg = array('type' => 'info', 'msg' => 'Nueva ronda creada correctamente');
    }

} elseif (isset($_POST['cve_clavadista'])) {
    $clavadista = arrayClavadista($_POST);
    $clavado    = arrayClavado($_POST);

    $web->setTabla('clavadista');
    $web->insert($clavadista);

    $web->setTabla('clavado');
    $web->update($clavado, null, array('cve_clavado' => $_POST['cve_clavado']));

    $msg = array('type' => 'info', 'msg' => 'Enviado correctamente');
}

$cmb_clavado      = $web->showList("select cve_clavado, clavado from clavado");
$cmb_nacionalidad = $web->showList("select cve_nacionalidad, descripcion from nacionalidad");
$cmb_clavadista   = $web->showList("select cve_clavadista,nombre_completo from clavadista order by nombre_completo");
$cmb_genero       = $web->showList('select * from genero');
$web->assignTemplate('cmb_nacionalidad', $cmb_nacionalidad);
$web->assignTemplate('cmb_genero', $cmb_genero);
$web->assignTemplate('cmb_clavadista', $cmb_clavadista);
$web->assignTemplate('cmb_clavado', $cmb_clavado);
$web->showTemplate(array('title' => "Administrador", 'headerTitle1'         => "SISCACLAO",
    'headerTitle2'                   => "Asignación de Niveles de Dificultad",
    'nombre_usuario'                 => $_SESSION['nombre_usuario'], 'template' => "index.html"), $msg);

//---------------------------------------------------------------------------------
function arrayClavadista()
{
    $temp = array
        (
        'cve_clavadista'   => $_POST['cve_clavadista'],
        'nombre_completo'  => $_POST['nombre_completo'],
        'cve_nacionalidad' => $_POST['cve_nacionalidad'],
        'cve_genero'       => $_POST['cve_genero'],
    );
    return $temp;
}
//---------------------------------------------------------------------------------
function arrayClavadO($array)
{
    $temp = array
        (
        'cve_clavado' => $_POST['cve_clavado'],
        'dificultad'  => $_POST['dificultad'],
    );
    return $temp;
}
//---------------------------------------------------------------------------------
function checkNull($array)
{
    for ($i = 0; $i < count($array); $i++) {
        if ($array[$i]['calif_ronda'] == null) {
            return false;
        }
    }
    return true;
}
