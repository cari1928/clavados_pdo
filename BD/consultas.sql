select bandera from nacionalidad where cve_nacionalidad='AF
'
$prom/= 5;

select * from ronda inner join enviarDatosJuez on enviarDatosJuez.cve_clavadista = ronda.cve_clavadista inner join clavado on clavado.cve_clavado = enviarDatosJuez.cve_clavado inner join clavadista on clavadista.cve_clavadista = ronda.cve_clavadista inner join nacionalidad on clavadista.cve_nacionalidad = nacionalidad.cve_nacionalidad order by cve_clavadista, num_ronda

select * from ronda inner join enviarDatosJuez on enviarDatosJuez.cve_clavadista = ronda.cve_clavadista inner join clavado on clavado.cve_clavado = enviarDatosJuez.cve_clavado inner join clavadista on clavadista.cve_clavadista = ronda.cve_clavadista inner join nacionalidad on clavadista.cve_nacionalidad = nacionalidad.cve_nacionalidad order by clavadista.cve_clavadista, num_ronda
