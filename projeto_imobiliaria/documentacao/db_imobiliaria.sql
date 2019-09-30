-- MySQL dump 10.16  Distrib 10.1.29-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: db_imobiliaria
-- ------------------------------------------------------
-- Server version	10.1.29-MariaDB

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
-- Table structure for table `tbl_cliente`
--

DROP TABLE IF EXISTS `tbl_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(100) NOT NULL,
  `cpf_cliente` varchar(30) NOT NULL,
  `idade` varchar(10) NOT NULL,
  `telefone_cliente` varchar(20) NOT NULL,
  `data_cadastro_cliente` date NOT NULL,
  `data_exclusao_cliente` date DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cliente`
--

LOCK TABLES `tbl_cliente` WRITE;
/*!40000 ALTER TABLE `tbl_cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_endereco`
--

DROP TABLE IF EXISTS `tbl_endereco`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_endereco` (
  `id_endereco` int(11) NOT NULL AUTO_INCREMENT,
  `logradouro` varchar(200) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `cep` varchar(15) NOT NULL,
  PRIMARY KEY (`id_endereco`),
  KEY `fk_id_estado_tblestado` (`id_estado`),
  CONSTRAINT `fk_id_estado_tblestado` FOREIGN KEY (`id_estado`) REFERENCES `tbl_estado` (`id_estado`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_endereco`
--

LOCK TABLES `tbl_endereco` WRITE;
/*!40000 ALTER TABLE `tbl_endereco` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_endereco` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_estado`
--

DROP TABLE IF EXISTS `tbl_estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_estado` (
  `id_estado` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `sigla` char(2) NOT NULL,
  `capital` varchar(100) NOT NULL,
  `pais` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_estado`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_estado`
--

LOCK TABLES `tbl_estado` WRITE;
/*!40000 ALTER TABLE `tbl_estado` DISABLE KEYS */;
INSERT INTO `tbl_estado` VALUES (1,'São Paulo','SP','São Paulo','Brasil'),(2,'Minas Gerais','MG','Belo Horizonte','Brasil'),(3,'Bahia','BH','Salvador','Brasil');
/*!40000 ALTER TABLE `tbl_estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_imovel`
--

DROP TABLE IF EXISTS `tbl_imovel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_imovel` (
  `id_imovel` int(11) NOT NULL AUTO_INCREMENT,
  `matricula` int(11) NOT NULL,
  `id_endereco_imovel` int(11) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `id_proprietario` int(11) NOT NULL,
  `data_cadastro_imovel` date NOT NULL,
  `data_exclusao_imovel` date DEFAULT NULL,
  PRIMARY KEY (`id_imovel`),
  UNIQUE KEY `matricula` (`matricula`),
  KEY `fk_id_endereco_tblimovel` (`id_endereco_imovel`),
  KEY `fk_id_proprietario_tblimovel` (`id_proprietario`),
  CONSTRAINT `fk_id_endereco_tblimovel` FOREIGN KEY (`id_endereco_imovel`) REFERENCES `tbl_endereco` (`id_endereco`),
  CONSTRAINT `fk_id_proprietario_tblimovel` FOREIGN KEY (`id_proprietario`) REFERENCES `tbl_proprietario` (`id_proprietario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_imovel`
--

LOCK TABLES `tbl_imovel` WRITE;
/*!40000 ALTER TABLE `tbl_imovel` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_imovel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_imovel_cliente`
--

DROP TABLE IF EXISTS `tbl_imovel_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_imovel_cliente` (
  `id_cliente` int(11) NOT NULL,
  `id_imovel` int(11) NOT NULL,
  `cod_contrato` int(11) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_final` date DEFAULT NULL,
  KEY `fk_id_cliente_tblimovelcliente` (`id_cliente`),
  KEY `fk_id_imovel_tblimovelcliente` (`id_imovel`),
  CONSTRAINT `fk_id_cliente_tblimovelcliente` FOREIGN KEY (`id_cliente`) REFERENCES `tbl_cliente` (`id_cliente`),
  CONSTRAINT `fk_id_imovel_tblimovelcliente` FOREIGN KEY (`id_imovel`) REFERENCES `tbl_imovel` (`id_imovel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_imovel_cliente`
--

LOCK TABLES `tbl_imovel_cliente` WRITE;
/*!40000 ALTER TABLE `tbl_imovel_cliente` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_imovel_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_proprietario`
--

DROP TABLE IF EXISTS `tbl_proprietario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_proprietario` (
  `id_proprietario` int(11) NOT NULL AUTO_INCREMENT,
  `nome_proprietario` varchar(100) NOT NULL,
  `cpf_proprietario` varchar(30) NOT NULL,
  `telefone_proprietario` varchar(20) NOT NULL,
  `data_nascimento` date NOT NULL,
  `id_endereco` int(11) NOT NULL,
  `data_cadastro_proprietario` date NOT NULL,
  `data_exclusao_proprietario` date DEFAULT NULL,
  PRIMARY KEY (`id_proprietario`),
  KEY `fk_id_endereco_tblproprietario` (`id_endereco`),
  CONSTRAINT `fk_id_endereco_tblproprietario` FOREIGN KEY (`id_endereco`) REFERENCES `tbl_endereco` (`id_endereco`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_proprietario`
--

LOCK TABLES `tbl_proprietario` WRITE;
/*!40000 ALTER TABLE `tbl_proprietario` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_proprietario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-30 19:06:34
