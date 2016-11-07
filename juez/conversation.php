<?php
  include ('../cl_web.class.php');

  $web->conexion();
  $web->checarAcceso();
  $templates = $web->templateEngine();
  $templates->setTemplateDir('../templates/admin/');

  $sql = "select * from enviarDatos
    inner join clavadista on enviarDatos.cve_clavadista = clavadista.cve_clavadista
    inner join nacionalidad on nacionalidad.cve_nacionalidad = clavadista.cve_nacionalidad
    inner join clavado on clavado.cve_clavado = enviarDatos.cve_clavado
  order by idConversation desc;";
  $result = $web->fetchAll($sql);

  $file = fopen("datos.txt", "w");
  fwrite($file, "cve_clavadista=>".$result[0]['cve_clavadista'].";");
  fwrite($file, "cve_nacionalidad=>".$result[0]['cve_nacionalidad'].";");
  fwrite($file, "nombre_completo=>".$result[0]['nombre_completo'].";");
  fwrite($file, "dificultad=>".$result[0]['dificultad'].";" );
  fwrite($file, "cve_clavado=>".$result[0]['cve_clavado']);
  fclose($file);

  echo '<section>
  	<div id="conversation" class="container-fluid">
  		<div class="row">

  			<div class="col-sx-12">
  				<table class="califBar table table-bordered">
  					<tr bgcolor="#648A60">
  						<td align="center" border="none">'.$result[0]['cve_clavadista'].'</td>
  							<td align="center">'.$result[0]['cve_nacionalidad'].'</td>
  							<td align="center"><img src="../images/flags-normal/'.$result[0]['bandera'].'" alt=":(" width="50"></td>
  							<td align="center" colspan="6">'.$result[0]['nombre_completo'].'</td>
  					</tr>
  					<tr bgcolor="#00B04F">
  						<td align="center">C1</td>
  						<td align="center">C2</td>
  						<td align="center">C3</td>
  						<td align="center">C4</td>
  						<td align="center">C5</td>
  						<td align="center">C6</td>
  						<td align="center">C7</td>
  						<td align="center">Dificultad: '.$result[0]['dificultad'].'</td>
  					</tr>
  					<tr>
  						<td align="center" bgcolor="#BF000" colspan="3">Total:</td>
  						<td align="center"></td>
  						<td align="center"></td>
  						<td align="center"></td>
  						<td align="center" bgcolor="425c3f" colspan="3">TTT</td>
  					</tr>
  				</table>
  			</div>

  		</div>
  	</div>
  </section>';
?>
