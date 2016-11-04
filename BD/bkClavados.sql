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
  `cve_tipo_clavado` varchar(7) DEFAULT NULL,
  PRIMARY KEY (`cve_clavado`),
  KEY `clavadofk1` (`cve_tipo_clavado`),
  CONSTRAINT `clavadofk1` FOREIGN KEY (`cve_tipo_clavado`) REFERENCES `tipo_clavado` (`cve_tipo_clavado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clavado`
--

LOCK TABLES `clavado` WRITE;
/*!40000 ALTER TABLE `clavado` DISABLE KEYS */;
INSERT INTO `clavado` VALUES ('C000001',1,'EQM'),('C000002',1,'EQM'),('C000003',1.5,'GRS'),('C000004',1.8,'HDA'),('C000005',2.2,'HA'),('C000007',2.9,'IN'),('C000008',5,'HDE'),('C000009',4,'HA');
/*!40000 ALTER TABLE `clavado` ENABLE KEYS */;
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
INSERT INTO `nacionalidad` VALUES ('A1','Anonymous Proxy',NULL),('A2','Satellite Provider',NULL),('AD','Andorra','ad.png'),('AE','United Arab Emirates','ae.png'),('AF','Afghanistan','af.png'),('AG','Antigua and Barbuda','ag.png'),('AI','Anguilla',NULL),('AL','Albania','al.png'),('AM','Armenia','am.png'),('AO','Angola','ao.png'),('AP','Asia/Pacific Region',NULL),('AQ','Antarctica',NULL),('AR','Argentina','ar.png'),('AS','American Samoa',NULL),('AT','Austria','at.png'),('AU','Australia',NULL),('AW','Aruba',NULL),('AX','Aland Islands',NULL),('AZ','Azerbaijan',NULL),('BA','Bosnia and Herzegovina',NULL),('BB','Barbados',NULL),('BD','Bangladesh',NULL),('BE','Belgium',NULL),('BF','Burkina Faso',NULL),('BG','Bulgaria',NULL),('BH','Bahrain',NULL),('BI','Burundi',NULL),('BJ','Benin',NULL),('BL','Saint Barthelemy',NULL),('BM','Bermuda',NULL),('BN','Brunei Darussalam',NULL),('BO','Bolivia',NULL),('BQ','Bonair',NULL),('BR','Brazil',NULL),('BS','Bahamas',NULL),('BT','Bhutan',NULL),('BW','Botswana',NULL),('BY','Belarus',NULL),('BZ','Belize',NULL),('CA','Canada',NULL),('CC','Cocos (Keeling) Islands',NULL),('CD','Cong',NULL),('CF','Central African Republic',NULL),('CG','Congo',NULL),('CH','Switzerland',NULL),('CI','Cote D\'Ivoire',NULL),('CK','Cook Islands',NULL),('CL','Chile',NULL),('CM','Cameroon',NULL),('CN','China',NULL),('CO','Colombia',NULL),('CR','Costa Rica',NULL),('CU','Cuba',NULL),('CV','Cape Verde',NULL),('CW','Curacao',NULL),('CX','Christmas Island',NULL),('CY','Cyprus',NULL),('CZ','Czech Republic',NULL),('DE','Germany',NULL),('DJ','Djibouti',NULL),('DK','Denmark',NULL),('DM','Dominica',NULL),('DO','Dominican Republic',NULL),('DZ','Algeria',NULL),('EC','Ecuador',NULL),('EE','Estonia',NULL),('EG','Egypt',NULL),('EH','Western Sahara',NULL),('ER','Eritrea',NULL),('ES','Spain',NULL),('ET','Ethiopia',NULL),('EU','Europe',NULL),('FI','Finland',NULL),('FJ','Fiji',NULL),('FK','Falkland Islands (Malvinas)',NULL),('FM','Micronesi',NULL),('FO','Faroe Islands',NULL),('FR','France',NULL),('GA','Gabon',NULL),('GB','United Kingdom',NULL),('GD','Grenada',NULL),('GE','Georgia',NULL),('GF','French Guiana',NULL),('GG','Guernsey',NULL),('GH','Ghana',NULL),('GI','Gibraltar',NULL),('GL','Greenland',NULL),('GM','Gambia',NULL),('GN','Guinea',NULL),('GP','Guadeloupe',NULL),('GQ','Equatorial Guinea',NULL),('GR','Greece',NULL),('GS','South Georgia and the South Sandwich Islands',NULL),('GT','Guatemala',NULL),('GU','Guam',NULL),('GW','Guinea-Bissau',NULL),('GY','Guyana',NULL),('HK','Hong Kong',NULL),('HN','Honduras',NULL),('HR','Croatia',NULL),('HT','Haiti',NULL),('HU','Hungary',NULL),('ID','Indonesia',NULL),('IE','Ireland',NULL),('IL','Israel',NULL),('IM','Isle of Man',NULL),('IN','India',NULL),('IO','British Indian Ocean Territory',NULL),('IQ','Iraq',NULL),('IR','Ira',NULL),('IS','Iceland',NULL),('IT','Italy',NULL),('JE','Jersey',NULL),('JM','Jamaica',NULL),('JO','Jordan',NULL),('JP','Japan',NULL),('KE','Kenya',NULL),('KG','Kyrgyzstan',NULL),('KH','Cambodia',NULL),('KI','Kiribati',NULL),('KM','Comoros',NULL),('KN','Saint Kitts and Nevis',NULL),('KP','Kore',NULL),('KR','Kore',NULL),('KW','Kuwait',NULL),('KY','Cayman Islands',NULL),('KZ','Kazakhstan',NULL),('LA','Lao People\'s Democratic Republic',NULL),('LB','Lebanon',NULL),('LC','Saint Lucia',NULL),('LI','Liechtenstein',NULL),('LK','Sri Lanka',NULL),('LR','Liberia',NULL),('LS','Lesotho',NULL),('LT','Lithuania',NULL),('LU','Luxembourg',NULL),('LV','Latvia',NULL),('LY','Libya',NULL),('MA','Morocco',NULL),('MC','Monaco',NULL),('MD','Moldov',NULL),('ME','Montenegro',NULL),('MF','Saint Martin',NULL),('MG','Madagascar',NULL),('MH','Marshall Islands',NULL),('MK','Macedonia',NULL),('ML','Mali',NULL),('MM','Myanmar',NULL),('MN','Mongolia',NULL),('MO','Macau',NULL),('MP','Northern Mariana Islands',NULL),('MQ','Martinique',NULL),('MR','Mauritania',NULL),('MS','Montserrat',NULL),('MT','Malta',NULL),('MU','Mauritius',NULL),('MV','Maldives',NULL),('MW','Malawi',NULL),('MX','Mexico',NULL),('MY','Malaysia',NULL),('MZ','Mozambique',NULL),('NA','Namibia',NULL),('NC','New Caledonia',NULL),('NE','Niger',NULL),('NF','Norfolk Island',NULL),('NG','Nigeria',NULL),('NI','Nicaragua',NULL),('NL','Netherlands',NULL),('NO','Norway',NULL),('NP','Nepal',NULL),('NR','Nauru',NULL),('NU','Niue',NULL),('NZ','New Zealand',NULL),('OM','Oman',NULL),('PA','Panama',NULL),('PE','Peru',NULL),('PF','French Polynesia',NULL),('PG','Papua New Guinea',NULL),('PH','Philippines',NULL),('PK','Pakistan',NULL),('PL','Poland',NULL),('PM','Saint Pierre and Miquelon',NULL),('PN','Pitcairn Islands',NULL),('PR','Puerto Rico',NULL),('PS','Palestinian Territory',NULL),('PT','Portugal',NULL),('PW','Palau',NULL),('PY','Paraguay',NULL),('QA','Qatar',NULL),('RE','Reunion',NULL),('RO','Romania',NULL),('RS','Serbia',NULL),('RU','Russian Federation',NULL),('RW','Rwanda',NULL),('SA','Saudi Arabia',NULL),('SB','Solomon Islands',NULL),('SC','Seychelles',NULL),('SD','Sudan',NULL),('SE','Sweden',NULL),('SG','Singapore',NULL),('SH','Saint Helena',NULL),('SI','Slovenia',NULL),('SJ','Svalbard and Jan Mayen',NULL),('SK','Slovakia',NULL),('SL','Sierra Leone',NULL),('SM','San Marino',NULL),('SN','Senegal',NULL),('SO','Somalia',NULL),('SR','Suriname',NULL),('SS','South Sudan',NULL),('ST','Sao Tome and Principe',NULL),('SV','El Salvador',NULL),('SX','Sint Maarten (Dutch part)',NULL),('SY','Syrian Arab Republic',NULL),('SZ','Swaziland',NULL),('TC','Turks and Caicos Islands',NULL),('TD','Chad',NULL),('TF','French Southern Territories',NULL),('TG','Togo',NULL),('TH','Thailand',NULL),('TJ','Tajikistan',NULL),('TK','Tokelau',NULL),('TL','Timor-Leste',NULL),('TM','Turkmenistan',NULL),('TN','Tunisia',NULL),('TO','Tonga',NULL),('TR','Turkey',NULL),('TT','Trinidad and Tobago',NULL),('TV','Tuvalu',NULL),('TW','Taiwan',NULL),('TZ','Tanzani',NULL),('UA','Ukraine',NULL),('UG','Uganda',NULL),('UM','United States Minor Outlying Islands',NULL),('US','United States',NULL),('UY','Uruguay',NULL),('UZ','Uzbekistan',NULL),('VA','Holy See (Vatican City State)',NULL),('VC','Saint Vincent and the Grenadines',NULL),('VE','Venezuela',NULL),('VG','Virgin Island',NULL),('VI','Virgin Island',NULL),('VN','Vietnam',NULL),('VU','Vanuatu',NULL),('WF','Wallis and Futuna',NULL),('WS','Samoa',NULL),('YE','Yemen',NULL),('YT','Mayotte',NULL),('ZA','South Africa',NULL),('ZM','Zambia',NULL),('ZW','Zimbabwe',NULL);
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
-- Table structure for table `tipo_clavado`
--

DROP TABLE IF EXISTS `tipo_clavado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_clavado` (
  `cve_tipo_clavado` varchar(3) NOT NULL DEFAULT '',
  `tipo_clavado` text,
  PRIMARY KEY (`cve_tipo_clavado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_clavado`
--

LOCK TABLES `tipo_clavado` WRITE;
/*!40000 ALTER TABLE `tipo_clavado` DISABLE KEYS */;
INSERT INTO `tipo_clavado` VALUES ('EQM','Desde Equilibrio de Manos'),('GRS','Con Giros'),('HA','Hacia Atras'),('HDA','Hacia Delante'),('HDE','Hacia Dentro'),('IN','Inverso');
/*!40000 ALTER TABLE `tipo_clavado` ENABLE KEYS */;
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
INSERT INTO `usuario` VALUES ('Jose','81dc9bdb52d04dc20036dbd8313ed055','JosÃ©',1,'A'),('Juez1','81dc9bdb52d04dc20036dbd8313ed055','Es el juez nÃºmero 1',0,NULL),('Juez2','81dc9bdb52d04dc20036dbd8313ed055','Es un juez',0,'J'),('Juez3','81dc9bdb52d04dc20036dbd8313ed055','Esto es un juez',0,'J'),('Prueba','81dc9bdb52d04dc20036dbd8313ed055','Esto es una prueba',0,NULL);
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

-- Dump completed on 2016-11-02 12:19:09
