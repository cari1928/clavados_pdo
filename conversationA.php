<?php
  //COMUNICACIÓN JUEZ - PUBLICO
  include ('cl_web.class.php');

  $web->conexion();

  //ADMIN-JUEZ
  $sql = "select distinct num_ronda, bandera, clavadista.cve_nacionalidad, nombre_completo, calif_ronda from ronda
    inner join enviarDatosJuez on enviarDatosJuez.cve_clavadista = ronda.cve_clavadista
    inner join clavado on clavado.cve_clavado = enviarDatosJuez.cve_clavado
    inner join clavadista on clavadista.cve_clavadista = ronda.cve_clavadista
    inner join nacionalidad on clavadista.cve_nacionalidad = nacionalidad.cve_nacionalidad
  order by clavadista.cve_clavadista, num_ronda";
  $result = $web->fetchAll($sql);

  // echo $sql;
  // echo "<pre>";
  // var_dump($result);
  $tmpJ = 0;

  echo '<table id="interTable" class="table table-hover"> <!-- Lo cambiaremos por CSS -->
     <tr class="success">
        <td bgcolor="grey">CLASIFICACIÓN</td>
        <td bgcolor="grey">BANDERA</td><!--BANDERA-->
        <td bgcolor="grey">PAIS</td><!--PAIS-->
        <td bgcolor="grey">NOMBRE</td><!--NOMBRE-->
        <td bgcolor="grey">1</td>
        <td bgcolor="grey">2</td>
        <td bgcolor="grey">3</td>
        <td bgcolor="grey">4</td>
        <td bgcolor="grey">5</td>
        <td bgcolor="grey">6</td>
        <td bgcolor="grey">-</td><!---->
        <td bgcolor="grey"7>+</td><!--"+"-->
    </tr>';

  for ($i=0; $i < count($result); $i++) {
      $tmp = $result[$i]['nombre_completo'];
      echo "<tr>";
      echo "<td>".($i + 1)."</td>";
      echo "<td><img src='images/flags-normal/".$result[$i]['bandera']."' width='50px'></td>";
      echo "<td>".$result[$i]['cve_nacionalidad']."</td>";
      echo "<td>".$result[$i]['nombre_completo']."</td>";

      // die();
      for ($j=$i; $j < ($i+6); $j++) {
        if(isset($result[$j])) {
          if($tmp != $result[$j]['nombre_completo']) {
            $j = $i + 6;
          } else {
            $tmpJ = $j;
            echo "<td>".$result[$j]['calif_ronda']."</td>";
          }
        } else {
          echo "<td></td>";
        }
      }
      $i = $tmpJ + 1;

    echo "</tr>";
  }
?>
