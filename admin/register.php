<?php
include '../cl_web.class.php';

$web->conexion();
$web->checarAcceso();

$sql    = "select * from enviardatos";
$result = $web->fetchAll($sql);

if (count($result) == 1) {
    echo "No es posible";
    die();
}

$sql = "select * from ronda
            inner join clavadista on ronda.cve_clavadista = clavadista.cve_clavadista
            where clavadista.cve_clavadista='" . $_POST['cve_clavadista'] . "'
            order by num_ronda DESC";
$result = $web->fetchAll($sql);

$msg = '';
if (count($result) == 0) {
    //nm ronda = 1
    $tmp = array('num_ronda' => 1, 'cve_clavadista' => $_POST['cve_clavadista']);

} else if ((count($result) == 5 && $result[0]['cve_genero'] == 'F')
    || (count($result) == 6 && $result[0]['cve_genero'] == 'M')) {
    $msg = "Clavadista terminó sus rondas";
    die();

} else {
    //crear array con elementos
    $tmp = array('num_ronda' => $result[0]['num_ronda'] += 1, 'cve_clavadista' => $_POST['cve_clavadista']);
}

if ($_POST['dificultad'] >= 1 && $_POST['dificultad'] <= 5) {

}

$web->setTabla('ronda');
$web->insert($tmp); //checar qué elementos se pueden insertar aquí

//Insertar y clavado
$clavado = arrayClavado($_POST);
$web->setTabla('clavado');
$web->update($clavado, null, array('cve_clavado' => $_POST['cve_clavado']));

$_POST['nombre_usuario'] = $_SESSION['nombre_usuario'];
unset($_POST['dificultad']);

$web->setTabla('enviardatos');
$web->insert($_POST);
echo "Mensaje registrado";

/**
 * Creación de un arreglo personalizado
 * @return Array Arreglo ya personalizado
 */
function arrayClavadista()
{
    $temp = array
        (
        'cve_clavadista' => $_POST['cve_clavadista'],
    );
    return $temp;
}

/**
 * Creación de arreglo personalizado para clavados
 * @param  Array $array Arreglo a personalizar
 * @return Array Arreglo ya personalizado
 */
function arrayClavado($array)
{
    $temp = array
        (
        'cve_clavado' => $_POST['cve_clavado'],
        'dificultad'  => $_POST['dificultad'],
    );
    return $temp;
}
