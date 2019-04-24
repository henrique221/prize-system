-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: preston
-- ------------------------------------------------------
-- Server version	5.7.25-1

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
-- Table structure for table `slack_user`
--

DROP TABLE IF EXISTS `slack_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slack_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slack_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `premios` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:array)',
  `data_de_nascimento` date DEFAULT NULL,
  `real_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_961B7CD663F6D2C9` (`slack_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slack_user`
--

LOCK TABLES `slack_user` WRITE;
/*!40000 ALTER TABLE `slack_user` DISABLE KEYS */;
INSERT INTO `slack_user` VALUES (1,'U7NL808A1','Renan Saggio',NULL,'1994-02-01','Renan Saggio - CTO','renan.saggio@4y2.org'),(2,'U7P8CGDBK','Cleide Andrade',NULL,NULL,'Cleide Andrade','cleide.andrade@4y2.org'),(3,'U7Q2TNQE8','rodrigo.nascimento',NULL,NULL,'Rodrigo Luís de Oliveira Nascimento','rodrigo.nascimento@4y2.org'),(4,'U7Q9H9VFY','Matheus Gomes',NULL,NULL,'Matheus Gomes','matheus.gomes@4y2.org'),(5,'U7Q9TBA8P','Gustavo Fuga',NULL,NULL,'Gustavo Fuga','gustavo.fuga@4y2.org'),(6,'U7YV3TTJP','Fabia Regina',NULL,NULL,'Fábia B2B','fabia.regina@4y2.org'),(7,'U7NNR4PPT','natascha.souza',NULL,NULL,'no full name','natascha.souza@4y2.org'),(10,'U7P70MB6D','lorena.andrade',NULL,NULL,'no full name','lorena.andrade@4y2.org'),(12,'U7PTUA4SW','guilherme.augusto',NULL,NULL,'no full name','guilherme.augusto@4y2.org'),(16,'U87SDL8F9','gabriella.augusto',NULL,NULL,'no full name','gabriella.augusto@4y2.org'),(17,'U8NRJV5UY','cristina.diniz',NULL,NULL,'no full name','cristina.diniz@4y2.org');
/*!40000 ALTER TABLE `slack_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permissoes` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'henrique','1234556','a:1:{i:0;s:10:\"ROLE_ADMIN\";}'),(2,'teste','123456','a:1:{i:0;s:10:\"ROLE_ADMIN\";}'),(3,'funcionario','123456','a:1:{i:0;s:16:\"ROLE_FUNCIONARIO\";}');
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

-- Dump completed on 2019-04-22  7:29:10
