/*
SQLyog Ultimate v11.11 (32 bit)
MySQL - 5.1.73 : Database - infocall
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`infocall` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `infocall`;

/*Table structure for table `empresa` */

DROP TABLE IF EXISTS `empresa`;

CREATE TABLE `empresa` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ruc` varchar(11) NOT NULL,
  `razonsocial` varchar(300) DEFAULT NULL,
  `fec_cron` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `user_created_at` varchar(80) DEFAULT NULL,
  `user_updated_at` varchar(80) DEFAULT NULL,
  `user_deleted_at` varchar(80) DEFAULT NULL,
  `userid_created_at` int(11) DEFAULT NULL,
  `userid_updated_at` int(11) DEFAULT NULL,
  `userid_deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_documento` (`ruc`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Table structure for table `persona` */

DROP TABLE IF EXISTS `persona`;

CREATE TABLE `persona` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `documento` varchar(20) NOT NULL,
  `ape_paterno` varchar(100) DEFAULT NULL,
  `ape_materno` varchar(100) DEFAULT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `fec_nacimiento` date DEFAULT NULL,
  `ubigeo_nacimiento` varchar(6) DEFAULT NULL,
  `padre_nombres` varchar(100) DEFAULT NULL,
  `madre_nombres` varchar(100) DEFAULT NULL,
  `estado_civil` enum('SOLTERO','CASADO','VIUDO','DIVORCIADO') DEFAULT NULL,
  `sexo` tinyint(4) DEFAULT NULL,
  `fec_cron` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `user_created_at` varchar(80) DEFAULT NULL,
  `user_updated_at` varchar(80) DEFAULT NULL,
  `user_deleted_at` varchar(80) DEFAULT NULL,
  `userid_created_at` int(11) DEFAULT NULL,
  `userid_updated_at` int(11) DEFAULT NULL,
  `userid_deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_documento` (`documento`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Table structure for table `persona_essalud` */

DROP TABLE IF EXISTS `persona_essalud`;

CREATE TABLE `persona_essalud` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `persona_id` bigint(20) DEFAULT NULL,
  `documento` varchar(20) NOT NULL,
  `periodo` varchar(6) DEFAULT NULL,
  `empresa_id` bigint(20) DEFAULT NULL,
  `sueldo` decimal(10,2) DEFAULT '0.00',
  `situacion` varchar(2) DEFAULT NULL,
  `fec_cron` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `user_created_at` varchar(80) DEFAULT NULL,
  `user_updated_at` varchar(80) DEFAULT NULL,
  `user_deleted_at` varchar(80) DEFAULT NULL,
  `userid_created_at` int(11) DEFAULT NULL,
  `userid_updated_at` int(11) DEFAULT NULL,
  `userid_deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Table structure for table `persona_sbs` */

DROP TABLE IF EXISTS `persona_sbs`;

CREATE TABLE `persona_sbs` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `persona_id` bigint(20) DEFAULT NULL,
  `documento` varchar(20) NOT NULL,
  `cod_sbs` varchar(20) DEFAULT NULL,
  `fecha_reporte_sbs` date DEFAULT NULL,
  `ruc` varchar(11) DEFAULT NULL,
  `cant_empresas` int(11) DEFAULT NULL,
  `calificacion_normal` decimal(5,2) DEFAULT '0.00',
  `calificacion_cpp` decimal(5,2) DEFAULT '0.00',
  `calificacion_deficiente` decimal(5,2) DEFAULT '0.00',
  `calificacion_dudoso` decimal(5,2) DEFAULT '0.00',
  `calificacion_perdida` decimal(5,2) DEFAULT '0.00',
  `fec_cron` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `user_created_at` varchar(80) DEFAULT NULL,
  `user_updated_at` varchar(80) DEFAULT NULL,
  `user_deleted_at` varchar(80) DEFAULT NULL,
  `userid_created_at` int(11) DEFAULT NULL,
  `userid_updated_at` int(11) DEFAULT NULL,
  `userid_deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Table structure for table `persona_telefono` */

DROP TABLE IF EXISTS `persona_telefono`;

CREATE TABLE `persona_telefono` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `documento` varchar(20) NOT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `tipo_telefono` enum('CELULAR','FIJO') DEFAULT NULL,
  `tipo_operadora` enum('MOVISTAR','CLARO','ENTEL','BITEL') DEFAULT NULL,
  `origen_data` varchar(20) DEFAULT NULL,
  `fec_data` date DEFAULT NULL,
  `plan` varchar(100) DEFAULT NULL,
  `fec_activacion` date DEFAULT NULL,
  `modelo_celular` varchar(100) DEFAULT NULL,
  `fec_cron` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `user_created_at` varchar(80) DEFAULT NULL,
  `user_updated_at` varchar(80) DEFAULT NULL,
  `user_deleted_at` varchar(80) DEFAULT NULL,
  `userid_created_at` int(11) DEFAULT NULL,
  `userid_updated_at` int(11) DEFAULT NULL,
  `userid_deleted_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `IDX_documento` (`documento`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
