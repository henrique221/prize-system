-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: preston
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.10.2

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
-- Table structure for table `trello_user`
--

DROP TABLE IF EXISTS `trello_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trello_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trello_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `premios` longtext COLLATE utf8mb4_unicode_ci COMMENT '(DC2Type:array)',
  `data_de_nascimento` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_E5507E76A50CDDC2` (`trello_id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trello_user`
--

LOCK TABLES `trello_user` WRITE;
/*!40000 ALTER TABLE `trello_user` DISABLE KEYS */;
INSERT INTO `trello_user` VALUES (1,'USLACKBOT','slackbot','N;',NULL),(2,'U7NL808A1','renan.saggio','N;',NULL),(3,'U7NNR4PPT','natascha.souza','N;',NULL),(4,'U7NP0SP7B','yuri.ongaro','N;',NULL),(5,'U7P5W4JG3','luana.koucher','N;',NULL),(6,'U7P70MB6D','lorena.andrade','N;',NULL),(7,'U7P8CGDBK','cleide.andrade','N;',NULL),(8,'U7PAA9H0T','brunorodriguesr4','N;',NULL),(9,'U7PNELUKE','julia.rocha','N;',NULL),(10,'U7PTUA4SW','guilherme.augusto','N;',NULL),(11,'U7Q1PL4D7','rafael91batista','N;',NULL),(12,'U7Q2TNQE8','rodrigo.nascimento','N;',NULL),(13,'U7Q9H9VFY','matheus.gomes','N;',NULL),(14,'U7Q9TBA8P','gustavo.fuga','N;',NULL),(15,'U7QBG2XC7','sylvia.rodrigues','N;',NULL),(16,'U7QQRA4PQ','andrechavesg','N;',NULL),(17,'U7SKUAFFU','luiza.lauro','N;',NULL),(18,'U7WCLLCQ2','googledrive','N;',NULL),(19,'U7YV3TTJP','fabia.regina','N;',NULL),(20,'U7ZF1JF36','rafael','N;',NULL),(21,'U81CNF26L','camila.lacerda','N;',NULL),(22,'U81NN6V63','rafael.marcon','N;',NULL),(23,'U83SAJ1SR','fernanda.santos','N;',NULL),(24,'U857CCS9W','paula.oliveira','N;',NULL),(25,'U85RSEY82','sambravo','N;',NULL),(26,'U85SMEZ6X','carlos.teixeira','N;',NULL),(27,'U866X1GNR','patrick.b','N;',NULL),(28,'U86A1H4ET','janaina.monteiro','N;',NULL),(29,'U874WC5AP','mirko.vanpampus','N;',NULL),(30,'U8753A3P1','vinicius.lima','N;',NULL),(31,'U87G10YJJ','tamiris.braga','N;',NULL),(32,'U87SDL8F9','gabriella.augusto','N;',NULL),(33,'U8NRJV5UY','cristina.diniz','N;',NULL),(34,'U8PG7QBDJ','francisco.cabrera','N;',NULL),(35,'U8W4D7EAD','adrian.homrich','N;',NULL),(36,'U8YNY15K7','raquel.franco','N;',NULL),(37,'U8ZKT8KL5','solange.coelho','N;',NULL),(38,'U9G1NE95F','mariana.dias','N;',NULL),(39,'U9J151CMB','camila.lopes','N;',NULL),(40,'U9LBC3Y49','trello','N;',NULL),(41,'U9X4BBXS5','joyce.pimenta','N;',NULL),(42,'UA0LPUWQP','vivian.valentim','N;',NULL),(43,'UAMNR3K9P','heytaco','N;',NULL),(44,'UAN4L30PR','giselle.farias','N;',NULL),(45,'UAN82A6N6','greetbot','N;',NULL),(46,'UANATPR45','birthdaybot','N;',NULL),(47,'UAP4YNSBG','timebot','N;',NULL),(48,'UAP9K0Z1V','aloha','N;',NULL),(49,'UB82YPKH7','jordana.nogueira','N;',NULL),(50,'UB9P9MG07','gabriela.torres','N;',NULL),(51,'UBKS22LQL','felipe.batista','N;',NULL),(52,'UBX2CU7B9','georgia.lima','N;',NULL),(53,'UCCGUAMCZ','barbara.passos','N;',NULL),(54,'UCEUDFVRQ','standuply','N;',NULL),(55,'UCLEU3KAR','eder.braz','N;',NULL),(56,'UD52W6A9X','juliana.borges','N;',NULL),(57,'UD5LATE6N','jo.caixeta','N;',NULL),(58,'UDL13QTC5','camilla.oliveira','N;',NULL),(59,'UDV36AYG6','flamarion.silva','N;',NULL),(60,'UDX1SSPAR','jorge.pedroso','N;',NULL),(61,'UE2MNTMAL','leandro.martins','N;',NULL),(62,'UEDG5PNQ0','hborges9294','N;',NULL),(63,'UEPQQMD0S','auditoria','N;',NULL),(64,'UER3HSR1S','maya.r.rebelo','N;',NULL),(65,'UF93R9U7P','julie.collins','N;',NULL),(66,'UFE2Y64F9','rodrigo.abib','N;',NULL),(67,'UFHFK798A','eliane.cruz','N;',NULL),(68,'UFZE0EFGD','alice.paschoal','N;',NULL),(69,'UGZ7VP8V7','maysa.simoes','N;',NULL),(70,'UGZVANB37','fernando.mazzarolo','N;',NULL),(71,'UH3SPC0PL','paula.alves','N;',NULL),(72,'UH47H2SRZ','adriele.correa','N;',NULL),(73,'UH5Q7F683','disco','N;',NULL),(74,'UH9C4P00Z','felipe.t.iwamoto','N;',NULL),(75,'UH9QSTGT0','severino','N;',NULL),(76,'UHA7FJT41','felipe.iwamoto','N;',NULL),(77,'UHBM5UTMZ','louise.scott','N;',NULL),(78,'UHCAMNS79','ed.braz','N;',NULL),(79,'UHDPTCVHA','preston','N;',NULL),(80,'UHG442L9W','hborgesdasilva','N;',NULL),(81,'UHGFJMJF6','alessandra.leanza','N;',NULL),(82,'UHKGPD77Y','daviddsantosd','N;',NULL),(83,'UHN768CAK','github','N;',NULL);
/*!40000 ALTER TABLE `trello_user` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'henrique','1234556','a:1:{i:0;s:10:\"ROLE_ADMIN\";}'),(2,'teste','123456','a:1:{i:0;s:10:\"ROLE_ADMIN\";}');
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

-- Dump completed on 2019-04-16  0:08:44
