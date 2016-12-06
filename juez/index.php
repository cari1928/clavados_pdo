<?php
include '../cl_web.class.php';

$web->conexion();
$web->checarAcceso();
$templates = $web->templateEngine();
$templates->setTemplateDir('../templates/juez/');

if (!isset($_POST['cve_clavado'])) {
    $clavadista = $web->getAll('select * from clavadista inner join nacionalidad on clavadista.cve_nacionalidad = nacionalidad.cve_nacionalidad');
    $clavado    = $web->getAll('select * from clavado');

    $file  = fopen("datos.txt", "r");
    $datos = array();

    $element = multiexplode(array("=>", ";"), fgets($file));
    // var_dump($element);

    if ($element[0] != "") {
        for ($i = 0; $i < count($element); $i += 2) {
            $temp    = array($element[$i] => $element[$i + 1]);
            $datos[] = $temp;
        }
        fclose($file);
    } else {
        $datos[0]['cve_clavadista'] = "";
        $datos[4]['cve_clavado']    = "";
    }

    $templates->assign('title', 'Juez');
    $templates->assign('headerTitle1', 'Prueba de Clavados Individual');
    $templates->assign('headerTitle2', 'SISCACLAO');
    $templates->assign('nombre_usuario', $_SESSION['nombre_usuario']);
    $templates->assign('clavadista', $clavadista);
    $templates->assign('clavado', $clavado);
    $templates->assign('cve_clavadista', $datos[0]['cve_clavadista']);
    $templates->assign('cve_clavado', $datos[4]['cve_clavado']);
    $templates->display('index.html');

} else {
    echo "existe post";
}

//---------------------------------------------------------------------------------
function multiexplode($delimiters, $string)
{
    $ready  = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return $launch;
}
