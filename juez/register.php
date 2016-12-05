<?php
include '../cl_web.class.php';

$web->conexion();
$web->checarAcceso();

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
