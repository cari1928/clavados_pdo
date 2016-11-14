<?php
  include ('../cl_web.class.php');

  $web->conexion();
  $web->checarAcceso();

  $sql = "select * from ronda
            inner join clavadista on ronda.cve_clavadista = clavadista.cve_clavadista
            where clavadista.cve_clavadista='".$_POST['cve_clavadista']."'
            order by num_ronda DESC";
  $result = $web->fetchAll($sql);

  var_dump($result);

  $msg = '';
  if(count($result) == 0) {
    //nm ronda = 1
    $tmp = array('num_ronda'=>1, 'cve_clavadista'=>$_POST['cve_clavadista']);

  } else if((count($result) == 5 && $result[0]['cve_genero'] == 'F')
         || (count($result) == 6 && $result[0]['cve_genero'] == 'M')){
     $msg = "Clavadista terminó sus rondas";
     die();

  } else {
    //crear array con elementos
    $tmp = array('num_ronda'=> $result[0]['num_ronda']+= 1, 'cve_clavadista'=>$_POST['cve_clavadista']);
  }

  //die(var_dump($tmp));
  $web->setTabla('ronda');
  $web->insert($tmp); //checar qué elementos se pueden insertar aquí

  //Insertar y clavado
  $clavado = arrayClavado($_POST);
  //var_dump($clavado);
  $web->setTabla('clavado');
  $web->update($clavado, null, array('cve_clavado'=>$_POST['cve_clavado']));

  $_POST['nombre_usuario'] = $_SESSION['nombre_usuario'];
  unset($_POST['dificultad']);

  $web->setTabla('enviarDatos');
  $web->insert($_POST);
  echo "Mensaje registrado";

//------------------------------------------------------------------------------------------------
  function arrayClavadista() {
    $temp = array
    (
      'cve_clavadista'=>$_POST['cve_clavadista'],
    );
    return $temp;
  }
//------------------------------------------------------------------------------------------------
  function arrayClavado($array) {
    $temp = array
    (
      'cve_clavado'=>$_POST['cve_clavado'],
      'dificultad'=>$_POST['dificultad'],
    );
    return $temp;
  }


?>
