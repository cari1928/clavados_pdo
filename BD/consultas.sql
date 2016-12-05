UPDATE ronda SET calif_ronda=12 WHERE num_ronda=1 and cve_clavadista='A000007'Todo bien

alter table orden_clavados drop primary key
alter table orden_clavados add constraint orden_clavadospk primary key(orden, numero_ronda)

select distinct clavadista.cve_clavadista, calif_ronda from ronda right outer join clavadista on clavadista.cve_clavadista = ronda.cve_clavadista;

select * from ronda where cve_clavadista='C000011' order by num_ronda DESCArray ( ) 

