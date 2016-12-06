<?php
//COMUNICACIÓN ADMIN-JUEZ
//COMUNICACION JUEZ-JUEZ
include '../cl_web.class.php';

$web->conexion();
$web->checarAcceso();

//ADMIN-JUEZ
$sql = "select * from enviardatos
    inner join clavadista on enviardatos.cve_clavadista = clavadista.cve_clavadista
    inner join nacionalidad on nacionalidad.cve_nacionalidad = clavadista.cve_nacionalidad
    inner join clavado on clavado.cve_clavado = enviardatos.cve_clavado";
$result = $web->fetchAll($sql);

if (isset($result[0])) {
    $file = fopen("datos.txt", "w");
    fwrite($file, "cve_clavadista=>" . $result[0]['cve_clavadista'] . ";");
    fwrite($file, "cve_nacionalidad=>" . $result[0]['cve_nacionalidad'] . ";");
    fwrite($file, "nombre_completo=>" . $result[0]['nombre_completo'] . ";");
    fwrite($file, "dificultad=>" . $result[0]['dificultad'] . ";");
    fwrite($file, "cve_clavado=>" . $result[0]['cve_clavado']);
    fclose($file);
}

//JUEZ-JUEZ
$sql = "select * from enviardatosjuez
  inner join clavado on clavado.cve_clavado = enviardatosjuez.cve_clavado";
$result_2 = $web->fetchAll($sql);

$prom = "0";
if (count($result_2) == 7) {
    //todos los jueces han calificado
    $sql = "select cve_clavadista, calificacion, clavado.dificultad from enviardatosjuez
        inner join clavado on enviardatosjuez.cve_clavado = clavado.cve_clavado
    order by calificacion";
    $temp = $web->fetchAll($sql); //se obtienen  las 7 calificaciones

    $caliRonda = 0;
    for ($i = 2; $i < count($temp) - 2; $i++) {
        $caliRonda += $temp[$i]['calificacion'];
    }
    $caliRonda *= $temp[0]['dificultad'];

    $sql      = "select * from ronda where cve_clavadista='" . $temp[0]['cve_clavadista'] . "' order by num_ronda DESC";
    $resRonda = $web->fetchAll($sql);

    $tmp = array(
        'num_ronda'      => $resRonda[0]['num_ronda'],
        'cve_clavadista' => $temp[0]['cve_clavadista'],
        'calif_ronda'    => $caliRonda,
    );

    // print_r($tmp);

    $web->setTabla('ronda');
    $web->update($tmp, null, array('num_ronda' => $resRonda[0]['num_ronda'], 'cve_clavadista' => $temp[0]['cve_clavadista']));
    $web->update2($tmp);

    $sql = "select calif_ronda, cve_genero from ronda
  inner join clavadista on ronda.cve_clavadista = clavadista.cve_clavadista
  where clavadista.cve_clavadista='" . $temp[0]['cve_clavadista'] . "'";
    $resRonda = $web->fetchAll($sql);

    $prom = 0;
    for ($i = 0; $i < count($resRonda); $i++) {
        $prom += $resRonda[$i]['calif_ronda'];
    }

    $web->setTabla('clavadista');
    $web->update(array('calif_final' => $prom, 'cve_clavadista' => $temp[0]['cve_clavadista']), null, array('cve_clavadista' => $temp[0]['cve_clavadista']));

} else {
    $caliRonda = "";
}

$file = fopen("datos2.txt", "w");
for ($i = 0; $i < count($result_2); $i++) {
    fwrite($file, "cve_clavadista=>" . $result_2[$i]['cve_clavadista'] . ";");
    fwrite($file, "nombre_usuario=>" . $result_2[$i]['nombre_usuario'] . ";");
    fwrite($file, "dificultad=>" . $result_2[$i]['dificultad'] . ";");
    fwrite($file, "cve_clavado=>" . $result_2[$i]['cve_clavado']);

    if ($i != count($result_2) - 1) {
        fwrite($file, ";");
    }
}
fclose($file);

if (!isset($result[0])) {
    $result[0]['cve_clavadista']   = "";
    $result[0]['cve_nacionalidad'] = "";
    $result[0]['bandera']          = "";
    $result[0]['nombre_completo']  = "";
    $result[0]['dificultad']       = "";
}

echo '<section>
    <div id="conversation" class="container-fluid">
      <div class="row">

        <div class="col-sx-12">
          <table class="califBar table table-bordered" style="color:white">
            <tr bgcolor="#648A60">
              <td align="center" border="none">' . $result[0]['cve_clavadista'] . '</td>
                <td align="center">' . $result[0]['cve_nacionalidad'] . '</td>
                <td align="center"><img src="../images/flags-normal/' . $result[0]['bandera'] . '" alt=":(" width="50"></td>
                <td align="center" colspan="6">' . $result[0]['nombre_completo'] . '</td>
            </tr>
            <tr bgcolor="#00B04F">';

if (isset($result_2[0])) {
    $num = count($result_2);
    for ($i = 0; $i < $num; $i++) {
        echo '<td align="center">' . $result_2[$i]['calificacion'] . '</td>';
    }

    if ($num != 7) {
        $num = 7 - $num;
        for ($i = 0; $i < $num; $i++) {
            echo '<td align="center">Juez Siguiente</td>';
        }
    }
} else {
    for ($i = 0; $i < 7; $i++) {
        echo '<td align="center">Juez Siguiente</td>';
    }
}

echo '<td align="center">Dificultad: ' . $result[0]['dificultad'] . '</td>
            </tr>
            <tr>
              <td align="center" bgcolor="#BF000" colspan="3">' . $prom . '</td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center"></td>
              <td align="center" bgcolor="425c3f" colspan="3">' . $caliRonda . '</td>
            </tr>
          </table>
        </div>

      </div>
    </div>
  </section>';
