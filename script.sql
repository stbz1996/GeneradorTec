CREATE TABLE `Administrator` (
  `idAdministrator` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userName` varchar(50) NOT NULL,
  `password` blob NOT NULL,
  PRIMARY KEY (`idAdministrator`)
);

CREATE TABLE `Career` (
  `idCareer` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `advanceDays` int(11) DEFAULT NULL,
  PRIMARY KEY (`idCareer`)
);

CREATE TABLE `AdminXCareer` (
  `idAdministrator` int(10) unsigned NOT NULL,
  `idCareer` int(10) unsigned NOT NULL,
  KEY `idAdministrator` (`idAdministrator`),
  KEY `idCareer` (`idCareer`),
  CONSTRAINT `adminxCareer_ibfk_1` FOREIGN KEY (`idAdministrator`) REFERENCES `Administrator` (`idadministrator`),
  CONSTRAINT `adminxCareer_ibfk_2` FOREIGN KEY (`idCareer`) REFERENCES `Career` (`idCareer`)
);

CREATE TABLE `Plan` (
  `idPlan` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `state` decimal(1,0) DEFAULT '0',
  `idCareer` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idPlan`),
  KEY `idCareer` (`idCareer`),
  CONSTRAINT `Plan_ibfk_1` FOREIGN KEY (`idCareer`) REFERENCES `Career` (`idCareer`)
);

CREATE TABLE `Period` (
  `idPeriod` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(10) NOT NULL,
  `year` int(6) NOT NULL,
  PRIMARY KEY (`idPeriod`)
);

CREATE TABLE `Block` (
  `idBlock` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `state` decimal(1,0) DEFAULT '0',
  `idPlan` int(10) unsigned NOT NULL,
  `number` int(11) DEFAULT NULL,
  PRIMARY KEY (`idBlock`),
  KEY `idPlan` (`idPlan`),
  CONSTRAINT `Block_ibfk_1` FOREIGN KEY (`idPlan`) REFERENCES `Plan` (`idPlan`)
);

CREATE TABLE `Course` (
  `idCourse` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `state` decimal(1,0) DEFAULT '0',
  `isCareer` decimal(1,0) DEFAULT '0',
  `lessonNumber` int(11) NOT NULL,
  `idBlock` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idCourse`),
  KEY `idBlock` (`idBlock`),
  CONSTRAINT `Course_ibfk_1` FOREIGN KEY (`idBlock`) REFERENCES `Block` (`idBlock`)
);

CREATE TABLE `ClassGroup` (
  `idGroup` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` int(10) NOT NULL,
  PRIMARY KEY (`idGroup`)
);

CREATE TABLE `CourseXBlock` (
  `idCourse` int(10) unsigned NOT NULL,
  `idBlock` int(10) unsigned NOT NULL,
  KEY `idCourse` (`idCourse`),
  KEY `idBlock` (`idBlock`),
  CONSTRAINT `CoursexBlock_ibfk_1` FOREIGN KEY (`idCourse`) REFERENCES `Course` (`idCourse`),
  CONSTRAINT `CoursexBlock_ibfk_2` FOREIGN KEY (`idBlock`) REFERENCES `Block` (`idBlock`)
);

CREATE TABLE `Professor` (
  `idProfessor` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `state` decimal(1,0) DEFAULT '0',
  `email` varchar(100) NOT NULL,
  `workLoad` int(6) DEFAULT NULL,
  `idCareer` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idProfessor`),
  KEY `idCareer` (`idCareer`),
  CONSTRAINT `Professor_ibfk_1` FOREIGN KEY (`idCareer`) REFERENCES `Career` (`idCareer`)
);

CREATE TABLE `Schedule` (
  `idSchedule` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `state` int(1) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `numberSchedule` int(11) DEFAULT NULL,
  PRIMARY KEY (`idSchedule`)
);

CREATE TABLE `Form` (
  `idForm` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hashcode` varchar(100) DEFAULT NULL,
  `state` decimal(1,0) DEFAULT '0',
  `dueDate` date NOT NULL,
  `idProfessor` int(10) unsigned NOT NULL,
  `idPeriod` int(10) unsigned NOT NULL,
  `extension` decimal(1,0) DEFAULT NULL,
  PRIMARY KEY (`idForm`),
  KEY `idProfessor` (`idProfessor`),
  KEY `idPeriod` (`idPeriod`),
  CONSTRAINT `Form_ibfk_1` FOREIGN KEY (`idProfessor`) REFERENCES `Professor` (`idProfessor`),
  CONSTRAINT `Form_ibfk_2` FOREIGN KEY (`idPeriod`) REFERENCES `Period` (`idPeriod`)
);

CREATE TABLE `Activity` (
  `idActivity` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `workPorcent` int(6) NOT NULL,
  `description` varchar(300) NOT NULL,
  `idForm` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idActivity`),
  KEY `idForm` (`idForm`),
  CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`idForm`) REFERENCES `Form` (`idForm`)
);

CREATE TABLE `CourseXForm` (
  `idCourse` int(10) unsigned NOT NULL,
  `idForm` int(10) unsigned NOT NULL,
  `priority` char(1) DEFAULT NULL,
  `state` decimal(1,0) DEFAULT '0',
  KEY `idCourse` (`idCourse`),
  KEY `idForm` (`idForm`),
  CONSTRAINT `CoursexForm_ibfk_1` FOREIGN KEY (`idCourse`) REFERENCES `Course` (`idCourse`),
  CONSTRAINT `CoursexForm_ibfk_2` FOREIGN KEY (`idForm`) REFERENCES `Form` (`idForm`)
) ;


CREATE TABLE `FormXSchedule` (
  `idForm` int(10) unsigned NOT NULL,
  `idSchedule` int(10) unsigned NOT NULL,
  KEY `idForm` (`idForm`),
  KEY `idSchedule` (`idSchedule`),
  CONSTRAINT `FormxSchedule_ibfk_1` FOREIGN KEY (`idForm`) REFERENCES `Form` (`idForm`),
  CONSTRAINT `FormxSchedule_ibfk_2` FOREIGN KEY (`idSchedule`) REFERENCES `Schedule` (`idSchedule`)
);

CREATE TABLE `ServiceLesson` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numberSchedule` int(11) DEFAULT NULL,
  `idPeriod` int(10) unsigned NOT NULL,
  `idCourse` int(10) unsigned NOT NULL,
  `idGroup` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idPeriod_idx` (`idPeriod`),
  KEY `idCourse_idx` (`idCourse`),
  KEY `idGroup_idx` (`idGroup`),
  KEY `numberSchedule_idx` (`numberSchedule`),
  CONSTRAINT `idCourse` FOREIGN KEY (`idCourse`) REFERENCES `Course` (`idCourse`),
  CONSTRAINT `idGroup` FOREIGN KEY (`idGroup`) REFERENCES `ClassGroup` (`idGroup`),
  CONSTRAINT `idPeriod` FOREIGN KEY (`idPeriod`) REFERENCES `Period` (`idPeriod`)
);

INSERT INTO `Career`(`name`, `advanceDays`) VALUES ('Ingeniería en Computación','5');
INSERT INTO `Administrator`(`userName`, `password`) VALUES ('stbz1996', 'stbz1996');
INSERT INTO `AdminXCareer`(`idAdministrator`, `idCareer`) VALUES (1,1);
INSERT INTO `Plan`(`name`, `state`, `idCareer`) VALUES ('410 - Ingenieria en Computación','1','1');

INSERT INTO `Block`(`name`, `state`, `idPlan`, `number`) VALUES ('I Semestre', 1, 1, 1);
INSERT INTO `Block`(`name`, `state`, `idPlan`, `number`) VALUES ('II Semestre', 1, 1, 2);
INSERT INTO `Block`(`name`, `state`, `idPlan`, `number`) VALUES ('III Semestre', 1, 1, 3);
INSERT INTO `Block`(`name`, `state`, `idPlan`, `number`) VALUES ('IV Semestre', 1, 1, 4);
INSERT INTO `Block`(`name`, `state`, `idPlan`, `number`) VALUES ('V Semestre', 1, 1, 5);
INSERT INTO `Block`(`name`, `state`, `idPlan`, `number`) VALUES ('VI Semestre', 1, 1, 6);
INSERT INTO `Block`(`name`, `state`, `idPlan`, `number`) VALUES ('VII Semestre', 1, 1, 7);
INSERT INTO `Block`(`name`, `state`, `idPlan`, `number`) VALUES ('VIII Semestre', 1, 1, 8);

INSERT INTO `ClassGroup`(`number`) VALUES (40);
INSERT INTO `ClassGroup`(`number`) VALUES (41);
INSERT INTO `ClassGroup`(`number`) VALUES (42);
INSERT INTO `ClassGroup`(`number`) VALUES (43);
INSERT INTO `ClassGroup`(`number`) VALUES (44);
INSERT INTO `ClassGroup`(`number`) VALUES (45);







INSERT INTO `Course` VALUES 
(1,'CI0202','Ingles Básico',1,0,4,1),
(2,'MA0101','Matématica General',1,0,4,1),
(3,'CI1311','Ingles I Para Computación',1,0,4,1),
(4,'IC1403','Fundamentos De Organización De Computadoras',1,1,4,1),
(5,'IC1802','Introducción A La Programación',1,1,4,1),
(6,'IC1803','Taller De Programación',1,1,4,1),
(7,'MA1403','Matemática Discreta',1,0,4,1),
(8,'CI1312','Ingles II Para Computación',1,0,3,2),
(9,'IC2001','Estructuras De Datos',1,1,4,2),
(10,'IC2101','Programación Orientada A Objetos',1,1,4,2),
(11,'IC3101','Arquitectura De Computadores',1,1,4,2),
(12,'MA1404','Cálculo',1,0,4,2),
(13,'CI1313','Inglés III Para Computación',1,0,3,3),
(14,'CS2101','Ambiente Humano',1,0,3,3),
(15,'IC3002','Análisis De Algoritmos',1,1,4,3),
(16,'IC4301','Bases De Datos I',1,1,4,3),
(17,'MA2405','Álgebra Lineal Para Computación',1,0,4,3),
(18,'CI1314','Inglés IV Para Computación',1,0,3,4),
(19,'IC4302','Bases De Datos II',1,1,4,4),
(20,'IC4700','Lenguajes De Programación',1,1,4,4),
(21,'IC5821','Requerimientos De Software',1,1,4,4),
(22,'MA2404','Probabilidades',1,0,4,4),
(23,'CS3401','Seminario De Estudios Filosóficos Históricos',1,0,3,5),
(24,'IC4810','Administración De Proyectos',1,1,4,5),
(25,'IC5701','Compiladores E Intérpretes',1,1,4,5),
(26,'IC6821','Diseño De Software',1,1,4,5),
(27,'MA3405','Estadística',1,0,4,5),
(28,'CS4402','Seminario De Estudios Costarricenses',1,0,3,6),
(29,'IC6400','Investigación De Operaciones',1,1,4,6),
(30,'IC6600','Principios De Sistemas Operativos',1,1,4,6),
(31,'IC6831','Aseguramiento De La Calidad Del Software',1,1,4,6),
(32,'IC7900','Computación Y Sociedad',1,1,4,6),
(33,'AE4208','Desarrollo De Emprendedores',0,0,4,1),
(34,'IC6200','Inteligencia Artificial',1,1,4,7),
(35,'IC7602','Redes',1,1,4,7),
(36,'IC7841','Proyecto de Ingeniería de Software',1,1,4,7),
(37,'IC8842','Práctica Profesional',1,1,12,8);

INSERT INTO `CourseXBlock` VALUES 
(1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,2),(9,2),(10,2),
(11,2),(12,2),(14,3),(15,3),(16,3),(17,3),(18,4),(19,4),(20,4),
(21,4),(22,4),(23,5),(24,5),(25,5),(26,5),(27,5),(28,6),(29,6),(30,6),
(31,6),(32,6),(33,7),(34,7),(35,7),(36,7),(37,8);

INSERT INTO `Professor` VALUES 
(1,'ADRIANA','ALVAREZ FIGUEROA',1,'stbz1996@gmail.com',100,1),
(2,'MAURICIO','AVILES CISNEROS',1,'stbz1996@gmail.com',100,1),
(3,'CARLOS','ALVAREZ GONZALEZ',1,'stbz1996@gmail.com',100,1),
(4,'JOSÉ','CASTRO MORA',1,'stbz1996@gmail.com',100,1),
(5,'EDUARDO','CANESSA MONTERO',1,'stbz1996@gmail.com',100,1),
(6,'LUIS CARLOS','LOAIZA CANET',1,'stbz1996@gmail.com',100,1),
(7,'LUIS','MONTOYA POITEVIEN',1,'stbz1996@gmail.com',100,1),
(8,'FRANCISCO','TORRES ROJAS',1,'stbz1996@gmail.com',100,1),
(9,'ERICK','HERNANDEZ BONILLA',1,'stbz1996@gmail.com',100,1),
(10,'BYRON','ROJAS BURGOS',1,'stbz1996@gmail.com',100,1);

INSERT INTO `Schedule` VALUES (85,0,'7:30am-8:20am',1),(86,1,'7:30am-8:20am',2),
(87,1,'7:30am-8:20am',3),(88,1,'7:30am - 8:20am',4),(89,1,'7:30am - 8:20am',5),
(90,0,'7:30am - 8:20am',6),(91,0,'8:30am - 9:20am',7),(92,1,'8:30am - 9:20am',8),
(93,1,'8:30am - 9:20am',9),(94,1,'8:30am - 9:20am',10),(95,1,'8:30am - 9:20am',11),
(96,0,'8:30am - 9:20am',12),(97,0,'9:30am - 10:20am',13),(98,1,'9:30am - 10:20am',14),
(99,1,'9:30am - 10:20am',15),(100,1,'9:30am - 10:20am',16),(101,1,'9:30am - 10:20am',17),
(102,0,'9:30am - 10:20am',18),(103,0,'10:30am-11:20am',19),(104,1,'10:30am-11:20am',20),
(105,1,'10:30am-11:20am',21),(106,1,'10:30am-11:20am',22),(107,1,'10:30am-11:20am',23),
(108,0,'10:30am-11:20am',24),(109,0,'11:30am-12:20pm',25),(110,0,'11:30am-12:20pm',26),
(111,0,'11:30am-12:20pm',27),(112,0,'11:30am-12:20pm',28),(113,0,'11:30am-12:20pm',29),
(114,0,'11:30am-12:20pm',30),(115,0,'1:00pm - 1:50pm',31),(116,1,'1:00pm - 1:50pm',32),
(117,1,'1:00pm - 1:50pm',33),(118,1,'1:00pm - 1:50pm',34),(119,1,'1:00pm - 1:50pm',35),
(120,0,'1:00pm - 1:50pm',36),(121,0,'2:00pm - 2:50pm',37),(122,1,'2:00pm - 2:50pm',38),
(123,1,'2:00pm - 2:50pm',39),(124,1,'2:00pm - 2:50pm',40),(125,1,'2:00pm - 2:50pm',41),
(126,0,'2:00pm - 2:50pm',42),(127,0,'3:00pm - 3:50pm',43),(128,1,'3:00pm - 3:50pm',44),
(129,1,'3:00pm - 3:50pm',45),(130,1,'3:00pm - 3:50pm',46),(131,1,'3:00pm - 3:50pm',47),
(132,0,'3:00pm - 3:50pm',48),(133,0,'4:00pm - 4:50pm',49),(134,1,'4:00pm - 4:50pm',50),
(135,1,'4:00pm - 4:50pm',51),(136,1,'4:00pm - 4:50pm',52),(137,1,'4:00pm - 4:50pm',53),
(138,0,'4:00pm - 4:50pm',54),(139,0,'4:50pm - 5:30pm',55),(140,0,'4:50pm - 5:30pm',56),
(141,0,'4:50pm - 5:30pm',57),(142,0,'4:50pm - 5:30pm',58),(143,0,'4:50pm - 5:30pm',59),
(144,0,'4:50pm - 5:30pm',60),(145,0,'5:30pm - 6:20pm',61),(146,1,'5:30pm - 6:20pm',62),
(147,1,'5:30pm - 6:20pm',63),(148,1,'5:30pm - 6:20pm',64),(149,1,'5:30pm - 6:20pm',65),
(150,0,'5:30pm - 6:20pm',66),(151,0,'6:20pm - 7:10pm',67),(152,1,'6:20pm - 7:10pm',68),
(153,1,'6:20pm - 7:10pm',69),(154,1,'6:20pm - 7:10pm',70),(155,1,'6:20pm - 7:10pm',71),
(156,0,'6:20pm - 7:10pm',72),(157,0,'7:25pm - 8:15pm',73),(158,1,'7:25pm - 8:15pm',74),
(159,1,'7:25pm - 8:15pm',75),(160,1,'7:25pm - 8:15pm',76),(161,1,'7:25pm - 8:15pm',77),
(162,0,'7:25pm - 8:15pm',78),(163,0,'8:15pm - 9:05pm',79),(164,1,'8:15pm - 9:05pm',80),
(165,1,'8:15pm - 9:05pm',81),(166,1,'8:15pm - 9:05pm',82),(167,1,'8:15pm - 9:05pm',83),
(168,0,'8:15pm - 9:05pm',84);
