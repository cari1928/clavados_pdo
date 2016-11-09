-- MySQL dump 10.13  Distrib 5.5.52, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: clavados_pdo
-- ------------------------------------------------------
-- Server version	5.5.52-0+deb8u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `calificacion`
--

DROP TABLE IF EXISTS `calificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calificacion` (
  `ejecucion` int(11) NOT NULL AUTO_INCREMENT,
  `cve_clavadista` varchar(7) NOT NULL,
  `cve_clavado` varchar(7) NOT NULL,
  `nombre_usuario` varchar(10) NOT NULL,
  `calificacion` float(12,0) DEFAULT NULL,
  PRIMARY KEY (`ejecucion`,`cve_clavadista`,`cve_clavado`,`nombre_usuario`),
  KEY `calificacionfk1` (`nombre_usuario`),
  KEY `calificacionfk3` (`cve_clavado`),
  KEY `calificacionfk2` (`cve_clavadista`),
  CONSTRAINT `calificacionfk1` FOREIGN KEY (`nombre_usuario`) REFERENCES `usuario` (`nombre_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `calificacionfk2` FOREIGN KEY (`cve_clavadista`) REFERENCES `clavadista` (`cve_clavadista`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `calificacionfk3` FOREIGN KEY (`cve_clavado`) REFERENCES `clavado` (`cve_clavado`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calificacion`
--

LOCK TABLES `calificacion` WRITE;
/*!40000 ALTER TABLE `calificacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `calificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clavadista`
--

DROP TABLE IF EXISTS `clavadista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clavadista` (
  `cve_clavadista` varchar(7) NOT NULL,
  `nombre_completo` varchar(40) DEFAULT NULL,
  `cve_genero` varchar(1) DEFAULT NULL,
  `cve_nacionalidad` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`cve_clavadista`),
  KEY `clavadistafk1` (`cve_genero`),
  KEY `clavadistafk2` (`cve_nacionalidad`),
  CONSTRAINT `clavadistafk1` FOREIGN KEY (`cve_genero`) REFERENCES `genero` (`cve_genero`),
  CONSTRAINT `clavadistafk2` FOREIGN KEY (`cve_nacionalidad`) REFERENCES `nacionalidad` (`cve_nacionalidad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clavadista`
--

LOCK TABLES `clavadista` WRITE;
/*!40000 ALTER TABLE `clavadista` DISABLE KEYS */;
INSERT INTO `clavadista` VALUES ('A000001','Juan PÃ©rez','M','A1'),('A000002','Shaine Z. Gonzales','M','A2'),('A000003','Olivia P. Torres','F','AD'),('A000004','Yetta O. Hensley','F','AD'),('A000005','Solomon N. Steele','F','AE'),('A000006','Solomon N. Steele','F','AE'),('A000007','Imani S. Goodwin','M','AF'),('A000008','Mariana Luna Bellman','F','AI'),('A000009','Fulanito','M','AU');
/*!40000 ALTER TABLE `clavadista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clavado`
--

DROP TABLE IF EXISTS `clavado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clavado` (
  `cve_clavado` varchar(7) NOT NULL,
  `dificultad` float DEFAULT NULL,
  PRIMARY KEY (`cve_clavado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clavado`
--

LOCK TABLES `clavado` WRITE;
/*!40000 ALTER TABLE `clavado` DISABLE KEYS */;
INSERT INTO `clavado` VALUES ('aaa',2),('abd',1),('bbb',3),('BDD',3),('C000001',1),('C000002',1),('C000003',1.5),('C000004',1.8),('C000005',2.2),('C000007',2.9),('C000008',5),('C000009',4),('ccc',5),('ddd',4),('eee',3),('EZE',4),('hhh',3),('qwe',2),('RRT',6),('Sfa',2),('ttt',2),('yyy',3),('ZZQ',2),('zzz',3);
/*!40000 ALTER TABLE `clavado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enviarDatos`
--

DROP TABLE IF EXISTS `enviarDatos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enviarDatos` (
  `idConversation` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(10) NOT NULL DEFAULT '',
  `cve_clavadista` varchar(7) NOT NULL DEFAULT '',
  `cve_clavado` varchar(7) NOT NULL DEFAULT '',
  PRIMARY KEY (`idConversation`,`nombre_usuario`,`cve_clavadista`,`cve_clavado`),
  KEY `convFK` (`nombre_usuario`),
  KEY `convFK2` (`cve_clavadista`),
  KEY `convFK3` (`cve_clavado`),
  CONSTRAINT `convFK` FOREIGN KEY (`nombre_usuario`) REFERENCES `usuario` (`nombre_usuario`),
  CONSTRAINT `convFK2` FOREIGN KEY (`cve_clavadista`) REFERENCES `clavadista` (`cve_clavadista`),
  CONSTRAINT `convFK3` FOREIGN KEY (`cve_clavado`) REFERENCES `clavado` (`cve_clavado`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enviarDatos`
--

LOCK TABLES `enviarDatos` WRITE;
/*!40000 ALTER TABLE `enviarDatos` DISABLE KEYS */;
INSERT INTO `enviarDatos` VALUES (3,'Jose','A000001','abd'),(9,'Jose','A000002','RRT'),(4,'Jose','A000003','BDD'),(10,'Jose','A000003','ZZQ'),(11,'Jose','A000004','Sfa'),(5,'Jose','A000007','ttt'),(7,'Jose','A000007','qwe'),(6,'Jose','A000008','hhh'),(8,'Jose','A000009','EZE');
/*!40000 ALTER TABLE `enviarDatos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enviarDatosJuez`
--

DROP TABLE IF EXISTS `enviarDatosJuez`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enviarDatosJuez` (
  `idConversation` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(255) NOT NULL,
  `cve_clavadista` varchar(7) NOT NULL,
  `cve_clavado` varchar(7) NOT NULL,
  `calificacion` float NOT NULL,
  PRIMARY KEY (`idConversation`,`nombre_usuario`,`cve_clavadista`,`cve_clavado`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enviarDatosJuez`
--

LOCK TABLES `enviarDatosJuez` WRITE;
/*!40000 ALTER TABLE `enviarDatosJuez` DISABLE KEYS */;
INSERT INTO `enviarDatosJuez` VALUES (3,'Juez2','A000004','Sfa',5),(4,'Juez3','A000004','Sfa',2);
/*!40000 ALTER TABLE `enviarDatosJuez` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genero`
--

DROP TABLE IF EXISTS `genero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `genero` (
  `cve_genero` varchar(1) NOT NULL,
  `genero` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`cve_genero`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genero`
--

LOCK TABLES `genero` WRITE;
/*!40000 ALTER TABLE `genero` DISABLE KEYS */;
INSERT INTO `genero` VALUES ('F','Femenino'),('M','Masculino');
/*!40000 ALTER TABLE `genero` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nacionalidad`
--

DROP TABLE IF EXISTS `nacionalidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nacionalidad` (
  `cve_nacionalidad` varchar(4) NOT NULL,
  `descripcion` text,
  `bandera` text,
  PRIMARY KEY (`cve_nacionalidad`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nacionalidad`
--

LOCK TABLES `nacionalidad` WRITE;
/*!40000 ALTER TABLE `nacionalidad` DISABLE KEYS */;
INSERT INTO `nacionalidad` VALUES ('A1','Anonymous Proxy','a1.png'),('A2','Satellite Provider','a2.png'),('AD','Andorra','ad.png'),('AE','United Arab Emirates','ae.png'),('AF','Afghanistan','af.png'),('AG','Antigua and Barbuda','ag.png'),('AI','Anguilla','ai.png'),('AL','Albania','al.png'),('AM','Armenia','am.png'),('AO','Angola','ao.png'),('AP','Asia/Pacific Region','ap.png'),('AQ','Antarctica','aq.png'),('AR','Argentina','ar.png'),('AS','American Samoa','as.png'),('AT','Austria','at.png'),('AU','Australia','au.png'),('AW','Aruba','aw.png'),('AX','Aland Islands','ax.png'),('AZ','Azerbaijan','az.png'),('BA','Bosnia and Herzegovina','ba.png'),('BB','Barbados','bb.png'),('BD','Bangladesh','bd.png'),('BE','Belgium','be.png'),('BF','Burkina Faso','bf.png'),('BG','Bulgaria','bg.png'),('BH','Bahrain','bh.png'),('BI','Burundi','bi.png'),('BJ','Benin','bj.png'),('BL','Saint Barthelemy','bl.png'),('BM','Bermuda','bm.png'),('BN','Brunei Darussalam','bn.png'),('BO','Bolivia','bo.png'),('BQ','Bonair','bq.png'),('BR','Brazil','br.png'),('BS','Bahamas','bs.png'),('BT','Bhutan','bt.png'),('BW','Botswana','bw.png'),('BY','Belarus','by.png'),('BZ','Belize','bz.png'),('CA','Canada','ca.png'),('CC','Cocos (Keeling) Islands','cc.png'),('CD','Cong','cd.png'),('CF','Central African Republic','cf.png'),('CG','Congo','cg.png'),('CH','Switzerland','ch.png'),('CI','Cote D\'Ivoire','ci.png'),('CK','Cook Islands','ck.png'),('CL','Chile','cl.png'),('CM','Cameroon','cm.png'),('CN','China','cn.png'),('CO','Colombia','co.png'),('CR','Costa Rica','cr.png'),('CU','Cuba','cu.png'),('CV','Cape Verde','cv.png'),('CW','Curacao','cw.png'),('CX','Christmas Island','cx.png'),('CY','Cyprus','cy.png'),('CZ','Czech Republic','cz.png'),('DE','Germany','de.png'),('DJ','Djibouti','dj.png'),('DK','Denmark','dk.png'),('DM','Dominica','dm.png'),('DO','Dominican Republic','do.png'),('DZ','Algeria','dz.png'),('EC','Ecuador','ec.png'),('EE','Estonia','ee.png'),('EG','Egypt','eg.png'),('EH','Western Sahara','eh.png'),('ER','Eritrea','er.png'),('ES','Spain','es.png'),('ET','Ethiopia','et.png'),('EU','Europe','eu.png'),('FI','Finland','fi.png'),('FJ','Fiji','fj.png'),('FK','Falkland Islands (Malvinas)','fk.png'),('FM','Micronesi','fm.png'),('FO','Faroe Islands','fo.png'),('FR','France','fr.png'),('GA','Gabon','ga.png'),('GB','United Kingdom','gb.png'),('GD','Grenada','gd.png'),('GE','Georgia','ge.png'),('GF','French Guiana','gf.png'),('GG','Guernsey','gg.png'),('GH','Ghana','gh.png'),('GI','Gibraltar','gi.png'),('GL','Greenland','gl.png'),('GM','Gambia','gm.png'),('GN','Guinea','gn.png'),('GP','Guadeloupe','gp.png'),('GQ','Equatorial Guinea','gq.png'),('GR','Greece','gr.png'),('GS','South Georgia and the South Sandwich Islands','gs.png'),('GT','Guatemala','gt.png'),('GU','Guam','gu.png'),('GW','Guinea-Bissau','gw.png'),('GY','Guyana','gy.png'),('HK','Hong Kong','hk.png'),('HN','Honduras','hn.png'),('HR','Croatia','hr.png'),('HT','Haiti','ht.png'),('HU','Hungary','hu.png'),('ID','Indonesia','id.png'),('IE','Ireland','ie.png'),('IL','Israel','il.png'),('IM','Isle of Man','im.png'),('IN','India','in.png'),('IO','British Indian Ocean Territory','io.png'),('IQ','Iraq','iq.png'),('IR','Ira','ir.png'),('IS','Iceland','is.png'),('IT','Italy','it.png'),('JE','Jersey','je.png'),('JM','Jamaica','jm.png'),('JO','Jordan','jo.png'),('JP','Japan','jp.png'),('KE','Kenya','ke.png'),('KG','Kyrgyzstan','kg.png'),('KH','Cambodia','kh.png'),('KI','Kiribati','ki.png'),('KM','Comoros','km.png'),('KN','Saint Kitts and Nevis','kn.png'),('KP','Kore','kp.png'),('KR','Kore','kr.png'),('KW','Kuwait','kw.png'),('KY','Cayman Islands','ky.png'),('KZ','Kazakhstan','kz.png'),('LA','Lao People\'s Democratic Republic','la.png'),('LB','Lebanon','lb.png'),('LC','Saint Lucia','lc.png'),('LI','Liechtenstein','li.png'),('LK','Sri Lanka','lk.png'),('LR','Liberia','lr.png'),('LS','Lesotho','ls.png'),('LT','Lithuania','lt.png'),('LU','Luxembourg','lu.png'),('LV','Latvia','lv.png'),('LY','Libya','ly.png'),('MA','Morocco','ma.png'),('MC','Monaco','mc.png'),('MD','Moldov','md.png'),('ME','Montenegro','me.png'),('MF','Saint Martin','mf.png'),('MG','Madagascar','mg.png'),('MH','Marshall Islands','mh.png'),('MK','Macedonia','mk.png'),('ML','Mali','ml.png'),('MM','Myanmar','mm.png'),('MN','Mongolia','mn.png'),('MO','Macau','mo.png'),('MP','Northern Mariana Islands','mp.png'),('MQ','Martinique','mq.png'),('MR','Mauritania','mr.png'),('MS','Montserrat','ms.png'),('MT','Malta','mt.png'),('MU','Mauritius','mu.png'),('MV','Maldives','mv.png'),('MW','Malawi','mw.png'),('MX','Mexico','mx.png'),('MY','Malaysia','my.png'),('MZ','Mozambique','mz.png'),('NA','Namibia','na.png'),('NC','New Caledonia','nc.png'),('NE','Niger','ne.png'),('NF','Norfolk Island','nf.png'),('NG','Nigeria','ng.png'),('NI','Nicaragua','ni.png'),('NL','Netherlands','nl.png'),('NO','Norway','no.png'),('NP','Nepal','np.png'),('NR','Nauru','nr.png'),('NU','Niue','nu.png'),('NZ','New Zealand','nz.png'),('OM','Oman','om.png'),('PA','Panama','pa.png'),('PE','Peru','pe.png'),('PF','French Polynesia','pf.png'),('PG','Papua New Guinea','pg.png'),('PH','Philippines','ph.png'),('PK','Pakistan','pk.png'),('PL','Poland','pl.png'),('PM','Saint Pierre and Miquelon','pm.png'),('PN','Pitcairn Islands','pn.png'),('PR','Puerto Rico','pr.png'),('PS','Palestinian Territory','ps.png'),('PT','Portugal','pt.png'),('PW','Palau','pw.png'),('PY','Paraguay','py.png'),('QA','Qatar','qa.png'),('RE','Reunion','re.png'),('RO','Romania','ro.png'),('RS','Serbia','rs.png'),('RU','Russian Federation','ru.png'),('RW','Rwanda','rw.png'),('SA','Saudi Arabia','sa.png'),('SB','Solomon Islands','sb.png'),('SC','Seychelles','sc.png'),('SD','Sudan','sd.png'),('SE','Sweden','se.png'),('SG','Singapore','sg.png'),('SH','Saint Helena','sh.png'),('SI','Slovenia','si.png'),('SJ','Svalbard and Jan Mayen','sj.png'),('SK','Slovakia','sk.png'),('SL','Sierra Leone','sl.png'),('SM','San Marino','sm.png'),('SN','Senegal','sn.png'),('SO','Somalia','so.png'),('SR','Suriname','sr.png'),('SS','South Sudan','ss.png'),('ST','Sao Tome and Principe','st.png'),('SV','El Salvador','sv.png'),('SX','Sint Maarten (Dutch part)','sx.png'),('SY','Syrian Arab Republic','sy.png'),('SZ','Swaziland','sz.png'),('TC','Turks and Caicos Islands','tc.png'),('TD','Chad','td.png'),('TF','French Southern Territories','tf.png'),('TG','Togo','tg.png'),('TH','Thailand','th.png'),('TJ','Tajikistan','tj.png'),('TK','Tokelau','tk.png'),('TL','Timor-Leste','tl.png'),('TM','Turkmenistan','tm.png'),('TN','Tunisia','tn.png'),('TO','Tonga','to.png'),('TR','Turkey','tr.png'),('TT','Trinidad and Tobago','tt.png'),('TV','Tuvalu','tv.png'),('TW','Taiwan','tw.png'),('TZ','Tanzani','tz.png'),('UA','Ukraine','ua.png'),('UG','Uganda','ug.png'),('UM','United States Minor Outlying Islands','um.png'),('US','United States','us.png'),('UY','Uruguay','uy.png'),('UZ','Uzbekistan','uz.png'),('VA','Holy See (Vatican City State)','va.png'),('VC','Saint Vincent and the Grenadines','vc.png'),('VE','Venezuela','ve.png'),('VG','Virgin Island','vg.png'),('VI','Virgin Island','vi.png'),('VN','Vietnam','vn.png'),('VU','Vanuatu','vu.png'),('WF','Wallis and Futuna','wf.png'),('WS','Samoa','ws.png'),('YE','Yemen','ye.png'),('YT','Mayotte','yt.png'),('ZA','South Africa','za.png'),('ZM','Zambia','zm.png'),('ZW','Zimbabwe','zw.png');
/*!40000 ALTER TABLE `nacionalidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rol` (
  `cve_rol` varchar(1) NOT NULL,
  `rol` varchar(13) DEFAULT NULL,
  PRIMARY KEY (`cve_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES ('A','Administrador'),('J','Juez');
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `nombre_usuario` varchar(10) NOT NULL,
  `pass` varchar(32) DEFAULT NULL,
  `nombre_real` varchar(50) DEFAULT NULL,
  `estado` int(11) DEFAULT NULL,
  `cve_rol` varchar(13) DEFAULT NULL,
  PRIMARY KEY (`nombre_usuario`),
  KEY `usuariofk1` (`cve_rol`),
  CONSTRAINT `usuariofk1` FOREIGN KEY (`cve_rol`) REFERENCES `rol` (`cve_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES ('Jose','81dc9bdb52d04dc20036dbd8313ed055','JosÃ©',0,'A'),('Juez1','81dc9bdb52d04dc20036dbd8313ed055','Es el juez nÃºmero 1',0,NULL),('Juez2','81dc9bdb52d04dc20036dbd8313ed055','Es un juez',0,'J'),('Juez3','81dc9bdb52d04dc20036dbd8313ed055','Esto es un juez',0,'J'),('Prueba','81dc9bdb52d04dc20036dbd8313ed055','Esto es una prueba',0,NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-09  9:32:09
