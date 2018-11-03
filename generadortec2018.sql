--
-- CREATE DATABASE `generatortec2018`;
--

CREATE DATABASE IF NOT EXISTS generadortec2018;
USE generadortec2018;
-- --------------------------------------------------------

--
-- Table structure for table `Administrator`
--

CREATE TABLE `Administrator` (
  `idAdministrator` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `userName` varchar(50) NOT NULL,
  `password` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Career`
--

CREATE TABLE `Career` (
  `idCareer` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `lessonDuration` int(11) NOT NULL,
  `advanceDays` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Career`
--

INSERT INTO `Career` (`name`, `lessonDuration`, `advanceDays`) VALUES
('Ingeniería en Computación', 50, 7);

-- --------------------------------------------------------

--
-- Table structure for table `Schedule`
--

CREATE TABLE `Schedule` (
  `idSchedule` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `initialTime` time NOT NULL,
  `finishTime` time NOT NULL,
  `dayName` varchar(10) NOT NULL,
  `state` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Schedule`
--

INSERT INTO `Schedule` (`initialTime`, `finishTime`, `dayName`, `state`) VALUES
('07:30:00', '08:20:00', 'Lunes', 1),
('08:30:00', '09:20:00', 'Lunes', 1),
('09:30:00', '10:20:00', 'Lunes', 1),
('10:30:00', '11:20:00', 'Lunes', 1),
('07:30:00', '08:20:00', 'Martes', 1),
('08:30:00', '09:20:00', 'Martes', 1),
('09:30:00', '10:20:00', 'Martes', 1),
('10:30:00', '11:20:00', 'Martes', 1),
('07:30:00', '08:20:00', 'Miercoles', 1),
('08:30:00', '09:20:00', 'Miercoles', 1),
('09:30:00', '10:20:00', 'Miercoles', 1),
('10:30:00', '11:20:00', 'Miercoles', 1),
('07:30:00', '08:20:00', 'Jueves', 1),
('08:30:00', '09:20:00', 'Jueves', 1),
('09:30:00', '10:20:00', 'Jueves', 1),
('10:30:00', '11:20:00', 'Jueves', 1),
('07:30:00', '08:20:00', 'Viernes', 1),
('08:30:00', '09:20:00', 'Viernes', 1),
('09:30:00', '10:20:00', 'Viernes', 1),
('10:30:00', '11:20:00', 'Viernes', 1),
('07:30:00', '08:20:00', 'Sabado', 1),
('08:30:00', '09:20:00', 'Sabado', 1),
('09:30:00', '10:20:00', 'Sabado', 1),
('10:30:00', '11:20:00', 'Sabado', 1),
('01:00:00', '01:50:00', 'Lunes', 1),
('02:00:00', '02:50:00', 'Lunes', 1),
('03:00:00', '03:50:00', 'Lunes', 1),
('04:00:00', '04:50:00', 'Lunes', 1),
('01:00:00', '01:50:00', 'Martes', 1),
('02:00:00', '02:50:00', 'Martes', 1),
('03:00:00', '03:50:00', 'Martes', 1),
('04:00:00', '04:50:00', 'Martes', 1),
('01:00:00', '01:50:00', 'Miercoles', 1),
('02:00:00', '02:50:00', 'Miercoles', 1),
('03:00:00', '03:50:00', 'Miercoles', 1),
('04:00:00', '04:50:00', 'Miercoles', 1),
('01:00:00', '01:50:00', 'Jueves', 1),
('02:00:00', '02:50:00', 'Jueves', 1),
('03:00:00', '03:50:00', 'Jueves', 1),
('04:00:00', '04:50:00', 'Jueves', 1),
('01:00:00', '01:50:00', 'Viernes', 1),
('02:00:00', '02:50:00', 'Viernes', 1),
('03:00:00', '03:50:00', 'Viernes', 1),
('04:00:00', '04:50:00', 'Viernes', 1),
('01:00:00', '01:50:00', 'Sabado', 0),
('02:00:00', '02:50:00', 'Sabado', 0),
('03:00:00', '03:50:00', 'Sabado', 0),
('04:00:00', '04:50:00', 'Sabado', 0),
('04:50:00', '05:30:00', 'Lunes', 1),
('04:50:00', '05:30:00', 'Martes', 1),
('04:50:00', '05:30:00', 'Miercoles', 1),
('04:50:00', '05:30:00', 'Jueves', 1),
('04:50:00', '05:30:00', 'Viernes', 1),
('04:50:00', '05:30:00', 'Sabado', 0),
('05:30:00', '06:20:00', 'Lunes', 0),
('05:30:00', '06:20:00', 'Martes', 0),
('05:30:00', '06:20:00', 'Miercoles', 1),
('05:30:00', '06:20:00', 'Jueves', 0),
('05:30:00', '06:20:00', 'Viernes', 0),
('05:30:00', '06:20:00', 'Sabado', 0),
('06:20:00', '07:10:00', 'Lunes', 0),
('06:20:00', '07:10:00', 'Martes', 0),
('06:20:00', '07:10:00', 'Miercoles', 1),
('06:20:00', '07:10:00', 'Jueves', 0),
('06:20:00', '07:10:00', 'Viernes', 0),
('06:20:00', '07:10:00', 'Sabado', 0),
('07:25:00', '08:15:00', 'Lunes', 0),
('07:25:00', '08:15:00', 'Martes', 0),
('07:25:00', '08:15:00', 'Miercoles', 1),
('07:25:00', '08:15:00', 'Jueves', 0),
('07:25:00', '08:15:00', 'Viernes', 0),
('07:25:00', '08:15:00', 'Sabado', 0),
('08:15:00', '09:05:00', 'Lunes', 0),
('08:15:00', '09:05:00', 'Martes', 0),
('08:15:00', '09:05:00', 'Miercoles', 1),
('08:15:00', '09:05:00', 'Jueves', 0),
('08:15:00', '09:05:00', 'Viernes', 0),
('08:15:00', '09:05:00', 'Sabado', 0),
('09:05:00', '09:55:00', 'Lunes', 0),
('09:05:00', '09:55:00', 'Martes', 0),
('09:05:00', '09:55:00', 'Miercoles', 0),
('09:05:00', '09:55:00', 'Jueves', 0),
('09:05:00', '09:55:00', 'Viernes', 0),
('09:05:00', '09:55:00', 'Sabado', 0);

-- --------------------------------------------------------

--
-- Table structure for table `Period`
--

CREATE TABLE `Period` (
  `idPeriod` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `number` int(10) NOT NULL,
  `year` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Period`
--

INSERT INTO `Period` (`number`, `year`) VALUES
(1, 2019),
(2, 2019);

-- --------------------------------------------------------

--
-- Table structure for table `Plan`
--

CREATE TABLE `Plan` (
  `idPlan` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `state` decimal(1,0) DEFAULT '0',
  `idCareer` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idCareer`) REFERENCES `Career`(`idCareer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Plan`
--

INSERT INTO `Plan` (`name`, `state`, `idCareer`) VALUES
('410 - Ingenieria en Computación', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Professor`
--

CREATE TABLE `Professor` (
  `idProfessor` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `state` decimal(1,0) DEFAULT '0',
  `email` varchar(100) NOT NULL,
  `workLoad` int(6) DEFAULT NULL,
  `idCareer` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idCareer`) REFERENCES `Career`(`idCareer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Professor`
--

INSERT INTO `Professor` (`name`, `lastName`, `state`, `email`, `workLoad`, `idCareer`) VALUES
('ADRIANA', 'ALVAREZ FIGUEROA', '1', 'adriana.alvarezf@gmail.com', 100, 1),
('MAURICIO', 'AVILES CISNEROS', '1', 'maviles@itcr.ac.cr', 75, 1),
('CARLOS', 'ALVAREZ GONZALEZ', '1', 'calvarezgcr@gmail.com', 0, 1),
('JOSÉ', 'CASTRO MORA', '1', 'jose.r.castro@gmail.com', 0, 1),
('EDUARDO', 'CANESSA MONTERO', '1', 'edcanessa@itcr.ac.cr', 0, 1),
('LUIS CARLOS', 'LOAIZA CANET', '1', 'luisloaiza58@gmail.com', 75, 1),
('LUIS', 'MONTOYA POITEVIEN', '1', 'lmontoya@itcr.ac.cr', 0, 1),
('FRANCISCO', 'TORRES ROJAS', '1', 'torresrojas@gmail.com', 75, 1),
('ERICK', 'HERNANDEZ BONILLA', '0', '', 0, 1),
('BYRON', 'ROJAS BURGOS', '1', 'byronarb@gmail.com', 100, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ClassGroup`
--

CREATE TABLE `ClassGroup` (
  `idGroup` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `ClassGroup`
--

INSERT INTO `ClassGroup` (`number`) VALUES
(40),
(41),
(42),
(43),
(44),
(45);

-- --------------------------------------------------------

--
-- Table structure for table `Block`
--

CREATE TABLE `Block` (
  `idBlock` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `state` decimal(1,0) DEFAULT '0',
  `idPlan` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idPlan`) REFERENCES `Plan`(`idPlan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Block`
--

INSERT INTO `Block` (`idBlock`, `name`, `state`, `idPlan`) VALUES
(1, 'I Semestre', '1', 1),
(2, 'II Semestre', '1', 1),
(3, 'III Semestre', '1', 1),
(4, 'IV Semestre', '1', 1),
(5, 'V Semestre', '1', 1),
(6, 'VI Semestre', '1', 1),
(7, 'VII Semestre', '1', 1),
(8, 'VIII Semestre', '1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `Course`
--

CREATE TABLE `Course` (
  `idCourse` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `code` varchar(15) NOT NULL,
  `name` varchar(50) NOT NULL,
  `state` decimal(1,0) DEFAULT '0',
  `isCareer` decimal(1,0) DEFAULT '0',
  `lessonNumber` int(11) NOT NULL,
  `idBlock` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idBlock`) REFERENCES `Block`(`idBlock`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `Course`
--

INSERT INTO `Course` (`code`, `name`, `state`, `isCareer`, `lessonNumber`, `idBlock`) VALUES
('CI0202', 'Ingles Básico', '1', '0', 3, 1),
('MA0101', 'Matématica General', '1', '0', 4, 1),
('CI1311', 'Ingles I Para Computación', '1', '0', 3, 1),
('IC1403', 'Fundamentos De Organización De Computadoras', '1', '1', 4, 1),
('IC1802', 'Introducción A La Programación', '1', '1', 4, 1),
('IC1803', 'Taller De Programación', '1', '1', 4, 1),
('MA1403', 'Matemática Discreta', '1', '0', 4, 1),
('CI1312', 'Ingles II Para Computación', '1', '0', 3, 2),
('IC2001', 'Estructuras De Datos', '1', '1', 4, 2),
('IC2101', 'Programación Orientada A Objetos', '1', '1', 4, 2),
('IC3101', 'Arquitectura De Computadores', '1', '1', 4, 2),
('MA1404', 'Cálculo', '1', '0', 4, 2),
('CI1313', 'Inglés III Para Computación', '1', '0', 3, 3),
('CS2101', 'Ambiente Humano', '1', '0', 3, 3),
('IC3002', 'Análisis De Algoritmos', '1', '1', 4, 3),
('IC4301', 'Bases De Datos I', '1', '1', 4, 3),
('MA2405', 'Álgebra Lineal Para Computación', '1', '0', 4, 3),
('CI1314', 'Inglés IV Para Computación', '1', '0', 3, 4),
('IC4302', 'Bases De Datos II', '1', '1', 4, 4),
('IC4700', 'Lenguajes De Programación', '1', '1', 4, 4),
('IC5821', 'Requerimientos De Software', '1', '1', 4, 4),
('MA2404', 'Probabilidades', '1', '0', 4, 4),
('CS3401', 'Seminario De Estudios Filosóficos Históricos', '1', '0', 3, 5),
('IC4810', 'Administración De Proyectos', '1', '1', 4, 5),
('IC5701', 'Compiladores E Intérpretes', '1', '1', 4, 5),
('IC6821', 'Diseño De Software', '1', '1', 4, 5),
('MA3405', 'Estadística', '1', '0', 4, 5),
('CS4402', 'Seminario De Estudios Costarricenses', '1', '0', 3, 6),
('IC6400', 'Investigación De Operaciones', '1', '1', 4, 6),
('IC6600', 'Principios De Sistemas Operativos', '1', '1', 4, 6),
('IC6831', 'Aseguramiento De La Calidad Del Software', '0', '1', 4, 6),
('IC7900', 'Computación Y Sociedad', '1', '1', 4, 6),
('AE4208', 'Desarrollo De Emprendedores', '1', '0', 4, 7),
('IC6200', 'Inteligencia Artificial', '1', '1', 4, 7),
('IC7602', 'Redes', '1', '1', 4, 7),
('IC7841', 'Proyecto de Ingeniería de Software', '1', '1', 4, 7),
('IC8842', 'Práctica Profesional', '1', '1', 12, 8);

-- --------------------------------------------------------

--
-- Table structure for table `Generator`
--

CREATE TABLE `Generator` (
  `idGenerator` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `sequence` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Form`
--

CREATE TABLE `Form` (
  `idForm` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `hashcode` varchar(100) DEFAULT NULL,
  `state` decimal(1,0) DEFAULT '0',
  `dueDate` date NOT NULL,
  `idProfessor` int(10) UNSIGNED NOT NULL,
  `idPeriod` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idProfessor`) REFERENCES `Professor`(`idProfessor`),
  FOREIGN KEY (`idPeriod`) REFERENCES `Period`(`idPeriod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Activity`
--
CREATE TABLE `Activity` (
  `idActivity` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `workPorcent` int(6) NOT NULL,
  `description` varchar(300) NOT NULL,
  `idForm` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idForm`) REFERENCES `Form`(`idForm`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `AdminXCareer`
--

CREATE TABLE `AdminXCareer` (
  `idAdministrator` int(10) UNSIGNED NOT NULL,
  `idCareer` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idAdministrator`) REFERENCES `Administrator`(`idAdministrator`),
  FOREIGN KEY (`idCareer`) REFERENCES `Career`(`idCareer`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `CourseXForm`
--

CREATE TABLE `CourseXForm` (
  `idCourse` int(10) UNSIGNED NOT NULL,
  `idForm` int(10) UNSIGNED NOT NULL,
  `priority` char(1) DEFAULT NULL,
  `state` decimal(1,0) DEFAULT '0',
  FOREIGN KEY (`idCourse`) REFERENCES `Course`(`idCourse`),
  FOREIGN KEY (`idForm`) REFERENCES `Form`(`idForm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `FormXSchedule`
--

CREATE TABLE `FormXSchedule` (
  `idForm` int(10) UNSIGNED NOT NULL,
  `idSchedule` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idForm`) REFERENCES `Form`(`idForm`),
  FOREIGN KEY (`idSchedule`) REFERENCES `Schedule`(`idSchedule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GeneratorXCourse`
--

CREATE TABLE `GeneratorXCourse` (
  `idGenerator` int(10) UNSIGNED NOT NULL,
  `idCourse` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idGenerator`) REFERENCES `Generator`(`idGenerator`),
  FOREIGN KEY (`idCourse`) REFERENCES `Course`(`idCourse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GeneratorXSchedule`
--

CREATE TABLE `GeneratorXSchedule` (
  `idGenerator` int(10) UNSIGNED NOT NULL,
  `idSchedule` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idGenerator`) REFERENCES `Generator`(`idGenerator`),
  FOREIGN KEY (`idSchedule`) REFERENCES `Schedule`(`idSchedule`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `GroupXCourse`
-- 
CREATE TABLE `GroupXCourse` (
  `idGroup` int(10) UNSIGNED NOT NULL,
  `idCourse` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idGroup`) REFERENCES `ClassGroup`(`idgroup`),
  FOREIGN KEY (`idCourse`) REFERENCES `Course`(`idcourse`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ProfessorXGenerator`
--

CREATE TABLE `ProfessorXGenerator` (
  `idProfessor` int(10) UNSIGNED NOT NULL,
  `idGenerator` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idProfessor`) REFERENCES `Professor`(`idProfessor`),
  FOREIGN KEY (`idGenerator`) REFERENCES `Generator`(`idGenerator`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `CourseXBlock`
--

CREATE TABLE `CourseXBlock` (
  `idCourse` int(10) UNSIGNED NOT NULL,
  `idBlock` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idCourse`) REFERENCES `Course`(`idCourse`),
  FOREIGN KEY (`idBlock`) REFERENCES `Block`(`idBlock`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Class`
--

CREATE TABLE `Class` (
  `idPeriod` int(10) UNSIGNED NOT NULL,
  `idCourse` int(10) UNSIGNED NOT NULL,
  `idProfessor` int(10) UNSIGNED NOT NULL,
  `idGroup` int(10) UNSIGNED NOT NULL,
  `initialTime` time NOT NULL,
  FOREIGN KEY (`idCourse`) REFERENCES `Course`(`idCourse`),
  FOREIGN KEY (`idProfessor`) REFERENCES `Professor`(`idProfessor`),
  FOREIGN KEY (`idPeriod`) REFERENCES `Period`(`idPeriod`),
  FOREIGN KEY (`idGroup`) REFERENCES `ClassGroup`(`idGroup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------
-- Lo anterior debe quedar almacenado, se debe crear una tabla extra donde se tenga la referencia al 
-- periodo seleccionado, los cursos que fueron asignados, los horarios que estos cursos ya poseen y el grupo. 

CREATE TABLE `ServiceLesson` (
  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `numberSchedule` int(11) UNSIGNED NOT NULL,
  `idPeriod` int(10) UNSIGNED NOT NULL,
  `idCourse` int(10) UNSIGNED NOT NULL,
  `idGroup` int(10) UNSIGNED NOT NULL,
  FOREIGN KEY (`idPeriod`) REFERENCES `Period`(`idPeriod`),
  FOREIGN KEY (`idCourse`) REFERENCES `Course`(`idCourse`),
  FOREIGN KEY (`idGroup`) REFERENCES `ClassGroup`(`idGroup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;