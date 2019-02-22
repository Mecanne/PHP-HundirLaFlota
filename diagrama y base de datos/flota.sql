-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         5.7.24 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             9.5.0.5332
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para flota
CREATE DATABASE IF NOT EXISTS `flota` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `flota`;

-- Volcando estructura para tabla flota.casillas
CREATE TABLE IF NOT EXISTS `casillas` (
  `IDCasilla` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Letra` char(1) NOT NULL,
  `Numero` int(1) unsigned NOT NULL,
  `IDTablero` int(7) unsigned NOT NULL,
  `IDEstadoCasilla` int(1) unsigned NOT NULL,
  `NombreBarco` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`IDCasilla`),
  KEY `FK_casillas_tableros` (`IDTablero`),
  KEY `FK_casillas_estadoscasilla` (`IDEstadoCasilla`),
  CONSTRAINT `FK_casillas_estadoscasilla` FOREIGN KEY (`IDEstadoCasilla`) REFERENCES `estadoscasilla` (`IDEstadoCasilla`) ON UPDATE CASCADE,
  CONSTRAINT `FK_casillas_tableros` FOREIGN KEY (`IDTablero`) REFERENCES `tableros` (`IDTablero`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1089 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla flota.casillas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `casillas` DISABLE KEYS */;
/*!40000 ALTER TABLE `casillas` ENABLE KEYS */;

-- Volcando estructura para tabla flota.estadoscasilla
CREATE TABLE IF NOT EXISTS `estadoscasilla` (
  `IDEstadoCasilla` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(20) NOT NULL,
  PRIMARY KEY (`IDEstadoCasilla`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla flota.estadoscasilla: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `estadoscasilla` DISABLE KEYS */;
INSERT INTO `estadoscasilla` (`IDEstadoCasilla`, `Descripcion`) VALUES
	(1, 'Agua'),
	(2, 'Barco'),
	(3, 'Agua con torpedo'),
	(4, 'Barco con torpedo');
/*!40000 ALTER TABLE `estadoscasilla` ENABLE KEYS */;

-- Volcando estructura para tabla flota.estadospartida
CREATE TABLE IF NOT EXISTS `estadospartida` (
  `IDEstadoPartida` int(1) unsigned NOT NULL AUTO_INCREMENT,
  `Descripcion` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`IDEstadoPartida`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla flota.estadospartida: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `estadospartida` DISABLE KEYS */;
INSERT INTO `estadospartida` (`IDEstadoPartida`, `Descripcion`) VALUES
	(1, 'Creada'),
	(2, 'Host con barcos preparados'),
	(3, 'Contrincante con barcos preparados'),
	(4, 'Empezada - Turno Host'),
	(5, 'Empezada - Turno Contrincante'),
	(6, 'Finalizada');
/*!40000 ALTER TABLE `estadospartida` ENABLE KEYS */;

-- Volcando estructura para tabla flota.jugadores
CREATE TABLE IF NOT EXISTS `jugadores` (
  `IDJugador` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `Usuario` varchar(50) DEFAULT NULL COMMENT 'email del usuario',
  `Password` varchar(50) DEFAULT NULL COMMENT 'ContraseÃ±a',
  PRIMARY KEY (`IDJugador`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla flota.jugadores: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `jugadores` DISABLE KEYS */;
/*!40000 ALTER TABLE `jugadores` ENABLE KEYS */;

-- Volcando estructura para tabla flota.partidas
CREATE TABLE IF NOT EXISTS `partidas` (
  `IDPartida` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `IDHost` int(3) unsigned NOT NULL COMMENT 'ID del jugador Host',
  `IDContrincante` int(3) unsigned DEFAULT NULL COMMENT 'ID del jugador Contrincante',
  `IDEstadoPartida` int(1) unsigned DEFAULT '1',
  PRIMARY KEY (`IDPartida`),
  KEY `FK_partidas_jugadores` (`IDHost`),
  KEY `FK_partidas_jugadores_2` (`IDContrincante`),
  KEY `FK_partidas_estadospartida` (`IDEstadoPartida`),
  CONSTRAINT `FK_partidas_estadospartida` FOREIGN KEY (`IDEstadoPartida`) REFERENCES `estadospartida` (`IDEstadoPartida`) ON UPDATE CASCADE,
  CONSTRAINT `FK_partidas_jugadores` FOREIGN KEY (`IDHost`) REFERENCES `jugadores` (`IDJugador`),
  CONSTRAINT `FK_partidas_jugadores_2` FOREIGN KEY (`IDContrincante`) REFERENCES `jugadores` (`IDJugador`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla flota.partidas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `partidas` DISABLE KEYS */;
/*!40000 ALTER TABLE `partidas` ENABLE KEYS */;

-- Volcando estructura para tabla flota.tableros
CREATE TABLE IF NOT EXISTS `tableros` (
  `IDTablero` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `IDJugador` int(3) unsigned NOT NULL,
  `IDPartida` int(6) unsigned NOT NULL,
  PRIMARY KEY (`IDTablero`),
  KEY `FK_tableros_jugadores` (`IDJugador`),
  KEY `FK_tableros_partidas` (`IDPartida`),
  CONSTRAINT `FK_tableros_jugadores` FOREIGN KEY (`IDJugador`) REFERENCES `jugadores` (`IDJugador`),
  CONSTRAINT `FK_tableros_partidas` FOREIGN KEY (`IDPartida`) REFERENCES `partidas` (`IDPartida`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla flota.tableros: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `tableros` DISABLE KEYS */;
/*!40000 ALTER TABLE `tableros` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
