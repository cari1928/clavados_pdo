create table enviarDatos(nombre_usuario varchar(10),
                            cve_clavadista varchar(7),
                            cve_clavado varchar(7),
constraint envDatosPK primary key (nombre_usuario, cve_clavadista, cve_clavado),
constraint envDatosFK foreign key (nombre_usuario) references usuario(nombre_usuario),
constraint envDatosFK2 foreign key (cve_clavadista) references clavadista(cve_clavadista),
constraint envDatosFK3 foreign key (cve_clavado) references clavado(cve_clavado))

create table conversation(idConversation int not null,
                          nombre_usuario varchar(10),
                            cve_clavadista varchar(7),
                            cve_clavado varchar(7),
constraint convPK primary key (idConversation, nombre_usuario, cve_clavadista, cve_clavado),
constraint convFK foreign key (nombre_usuario) references usuario(nombre_usuario),
constraint convFK2 foreign key (cve_clavadista) references clavadista(cve_clavadista),
constraint convFK3 foreign key (cve_clavado) references clavado(cve_clavado))
