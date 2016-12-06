UPDATE ronda SET calif_ronda=12 WHERE num_ronda=1 and cve_clavadista='A000007'Todo bien

alter table orden_clavados drop primary key
alter table orden_clavados add constraint orden_clavadospk primary key(orden, numero_ronda)

select distinct clavadista.cve_clavadista, calif_ronda from ronda right outer join clavadista on clavadista.cve_clavadista = ronda.cve_clavadista;

select * from ronda where cve_clavadista='C000011' order by num_ronda DESCArray ( ) 

select * from ronda where cve_clavadista='C000012' order by num_ronda DESC

select * from ronda inner join enviardatosjuez on enviardatosjuez.cve_clavadista = ronda.cve_clavadista inner join clavado on clavado.cve_clavado = enviardatosjuez.cve_clavado inner join clavadista on clavadista.cve_clavadista = ronda.cve_clavadista inner join nacionalidad on clavadista.cve_nacionalidad = nacionalidad.cve_nacionalidad order by num_ronda
