<?php
include '../cl_web.class.php';

$web->conexion();
$web->checarAcceso();

//calificacion, cve_clavadista, cve_clavado
$file    = fopen("datos.txt", "r");
$datos   = array();
$element = multiexplode(array("=>", ";"), fgets($file));
// var_dump($element);
for ($i = 0; $i < count($element); $i += 2) {
    $temp    = array($element[$i] => $element[$i + 1]);
    $datos[] = $temp;
}
fclose($file);

$_POST['cve_clavadista'] = $datos[0]['cve_clavadista'];
$_POST['cve_clavado']    = $datos[4]['cve_clavado'];

//Insertar y clavado
$_POST['nombre_usuario'] = $_SESSION['nombre_usuario'];

$sql   = "select * from enviardatosjuez";
$datos = $web->fetchAll($sql);

if (count($datos) < 7) {

    if ($_POST['calificacion'] >= 0 && $_POST['calificacion'] <= 10) {
        if ($_POST['calificacion'] == 0) {
            $web->setTabla('enviardatosjuez');
            $web->insert($_POST);

            echo "Calificación registrada";
        } else {
            $num = fmod($_POST['calificacion'], 0.5);

            if ($num == 0) {
                $web->setTabla('enviardatosjuez');
                $web->insert($_POST);

                echo "Calificación registrada";
            } else {
                echo "Calificación no válida";
            }
        }
    } else {
        echo "No está dentro del rango";
    }
}

//------------------------------------------------------------------------------
function multiexplode($delimiters, $string)
{
    $ready  = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return $launch;
}
