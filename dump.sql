-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: preston
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.18.04.1

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
-- Table structure for table `reward`
--

DROP TABLE IF EXISTS `reward`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reward` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `rewards` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `slackUser` int(11) DEFAULT NULL,
  `id_who_rewarded` longtext COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `IDX_4ED17253E9C584D8` (`slackUser`),
  CONSTRAINT `FK_4ED17253E9C584D8` FOREIGN KEY (`slackUser`) REFERENCES `slack_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reward`
--

LOCK TABLES `reward` WRITE;
/*!40000 ALTER TABLE `reward` DISABLE KEYS */;
INSERT INTO `reward` VALUES (28,'2019-05-06 16:44:05','Dessa vez não é teste haha\r\nParabéns pelo seu esforço, mesmo sem as ferramentas ideais, vc conseguiu surpreender a todos e conseguiu fazer o pgto de todos os funcionários na sexta feira.','a:2:{i:0;s:7:\"deliver\";i:1;s:5:\"do it\";}',19,'15'),(29,'2019-05-07 09:19:17','Pelo desenvolvimento do Preston!!!','a:2:{i:0;s:6:\"create\";i:1;s:7:\"deliver\";}',46,'5'),(30,'2019-05-07 09:20:51','Parabens Henrique =D pelo Preston!! Porque vi você todos os dias super animado e orgulhoso ( bota animação e orgulho nisso ein ) trabalhando no Preston. Consegui ver que se dedicou muito nele, encarando desafios novos desafios.','a:2:{i:0;s:6:\"create\";i:1;s:7:\"deliver\";}',46,'34'),(31,'2019-05-07 11:12:13','Pelo comprometimento na \"Força Tarefa Capão\". Em poucos dias de Força Tarefa já vemos resultados comentados pelos colaboradores e alunos.\r\n\r\nTambém pelo trabalho em equipe com a Adriele :))','a:2:{i:0;s:5:\"do it\";i:1;s:7:\"deliver\";}',41,'37'),(32,'2019-05-07 11:12:55','Pelo comprometimento na \"Força Tarefa Capão\". Em poucos dias de Força Tarefa já vemos resultados comentados pelos colaboradores e alunos.\r\n\r\nTambém pelo trabalho em equipe com o Flamarion :))','a:2:{i:0;s:5:\"do it\";i:1;s:7:\"deliver\";}',31,'37'),(33,'2019-05-07 11:20:19','Pelo comprometimento com a empresa, com os alunos e professores.\r\nQuando entrei, ela não exitou em me passar seu conhecimento.\r\nMesmo ao mudar de branch ainda estávamos conectados, nos ajudando diariamente e agora com a nova colaboradora, Ale, ela tem a mesma entrega e colaboração.\r\nMerece mais que reconhecimento! Parabéns Babi','a:3:{i:0;s:7:\"connect\";i:1;s:5:\"do it\";i:2;s:7:\"deliver\";}',29,'35'),(34,'2019-05-07 11:21:42','For always going beyond expectations and giving his valuable time to help me. Thank you.','a:1:{i:0;s:7:\"connect\";}',24,'41'),(35,'2019-05-07 11:56:07','Pelo comprometimento e apoio aos colegas de outra regional nas últimas semanas :)','a:2:{i:0;s:7:\"connect\";i:1;s:4:\"dare\";}',27,'37'),(36,'2019-05-07 12:05:36','Manda muito !!!!Os alunos já sentiram um diferença com sua presença na escola, acompanhando suas  dificuldades e aflições perante o aprendizado de inglês, os professores se sentem mais acolhidos ao receber Feedback de suas aulas e sugestões de melhoria  e  claro uma super força  à NÓS da unidade do Capão muito obrigada é importante que saiba que seu trabalho faz muita diferença a todos. ','a:3:{i:0;s:5:\"do it\";i:1;s:6:\"create\";i:2;s:7:\"connect\";}',31,'26'),(37,'2019-05-07 13:45:25','Merecidamente por todo empenho, carinho e jogo de cintura que  enfrenta as adversidades! ;)','a:4:{i:0;s:5:\"do it\";i:1;s:7:\"connect\";i:2;s:7:\"deliver\";i:3;s:4:\"dare\";}',29,'29'),(38,'2019-05-07 13:46:53','obrigada por toda ajuda com as aulas de Portugues e as novas parcerias :)','a:4:{i:0;s:6:\"create\";i:1;s:7:\"connect\";i:2;s:5:\"do it\";i:3;s:4:\"dare\";}',31,'29'),(39,'2019-05-07 13:49:40','Grande Matheus! obrigada por toda ajuda e for always having my back! :) ','a:3:{i:0;s:7:\"connect\";i:1;s:4:\"dare\";i:2;s:6:\"create\";}',21,'29'),(40,'2019-05-07 14:29:13','Por ser prestativo e rápido quando preciso de algo!','a:1:{i:0;s:5:\"do it\";}',21,'24'),(41,'2019-05-07 14:29:13','Por ser prestativo e rápido quando preciso de algo!','a:1:{i:0;s:5:\"do it\";}',21,'24'),(42,'2019-05-07 14:29:13','Por ser prestativo e rápido quando preciso de algo!','a:1:{i:0;s:5:\"do it\";}',21,'24'),(43,'2019-05-07 14:34:06',NULL,'a:1:{i:0;N;}',21,'24'),(44,'2019-05-07 14:48:35','Pelas idéias de Campanhas de MKT para a Unidade JP','a:1:{i:0;s:6:\"create\";}',25,'17'),(45,'2019-05-07 14:50:58','Pela proatividade nos controles que inspiraram o modelo para a Ação de Inadimplência.','a:1:{i:0;s:5:\"do it\";}',28,'17'),(46,'2019-05-07 20:28:47','Parabéns Babi por todo o carinho e dedicação que vc tem pela empresa, pelos alunos, professores e funcionários. Parabéns por ter sempre um sorriso no rosto e por desenvolver seu trabalho com maestria! ','a:2:{i:0;s:5:\"do it\";i:1;s:7:\"deliver\";}',29,'16'),(47,'2019-05-07 20:32:56','Parabéns pela iniciativa de trazer a comunidade pra dentro da escola com o projeto do lançamento do livro. Foi bem planejado e executado. ','a:3:{i:0;s:7:\"connect\";i:1;s:4:\"dare\";i:2;s:6:\"create\";}',57,'16');
/*!40000 ALTER TABLE `reward` ENABLE KEYS */;
UNLOCK TABLES;

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
  `data_de_nascimento` date DEFAULT NULL,
  `real_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `has_access` tinyint(1) DEFAULT NULL,
  `userAccess` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_961B7CD663F6D2C9` (`slack_id`),
  UNIQUE KEY `UNIQ_961B7CD6693F39A6` (`userAccess`),
  CONSTRAINT `FK_961B7CD6693F39A6` FOREIGN KEY (`userAccess`) REFERENCES `usuario` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `slack_user`
--

LOCK TABLES `slack_user` WRITE;
/*!40000 ALTER TABLE `slack_user` DISABLE KEYS */;
INSERT INTO `slack_user` VALUES (18,'U7NL808A1','Renan Saggio','1995-04-06','Renan Saggio - CTO','renan.saggio@4y2.org','2017-10-19',1,33),(19,'U7P8CGDBK','Cleide Andrade','1971-08-10','Cleide Andrade','cleide.andrade@4y2.org','2017-01-11',1,17),(20,'U7Q2TNQE8','Rodrigo Nascimento','1990-05-25','Rodrigo Luís de Oliveira Nascimento','rodrigo.nascimento@4y2.org','2019-03-07',1,18),(21,'U7Q9H9VFY','Matheus Gomes','1985-09-07','Matheus Gomes','matheus.gomes@4y2.org','2017-03-03',1,5),(22,'U7Q9TBA8P','Gustavo Fuga','1992-10-26','Gustavo Fuga','gustavo.fuga@4y2.org','2012-04-18',1,19),(23,'U7YV3TTJP','Fabia Regina','1974-06-30','Fábia B2B','fabia.regina@4y2.org','2017-09-01',1,20),(24,'U81NN6V63','Rafael Marcon','1987-09-09','Rafael Marcon','rafael.marcon@4y2.org','2017-11-14',1,21),(25,'U86A1H4ET','Janaina Monteiro','1976-03-09','Janaina Monteiro','janaina.monteiro@4y2.org','2017-11-21',1,22),(26,'U874WC5AP','Mirko Van Pampus','1987-02-13','Mirko van Pampus','mirko.vanpampus@4y2.org','2017-09-11',1,23),(27,'U8ZKT8KL5','Solange Coelho','1988-11-08','Solange Coelho','solange.coelho@4y2.org','2018-01-22',1,24),(28,'U9J151CMB','Camila Lopes','1987-03-03','Camila - Hub Santana','camila.lopes@4y2.org','2018-03-01',1,25),(29,'UCCGUAMCZ','Barbara Passos','1989-03-30','Barbara Passos','barbara.passos@4y2.org','2018-08-20',1,26),(30,'UB82YPKH7','Jordana Nogueira','1985-03-09','Jordana Nogueira- B2B','jordana.nogueira@4y2.org','2018-06-11',1,27),(31,'UH47H2SRZ','Adriele Correa','1984-09-19','Adriele Correa','adriele.correa@4y2.org','2019-03-13',1,16),(32,'UHGFJMJF6','Alessandra Leanza','1980-07-25','Alessandra Achcar Leanza','alessandra.leanza@4y2.org','2019-03-25',1,28),(33,'UFZE0EFGD','Alice Paschoal','1983-08-26','Alice - International talents','alice.paschoal@4y2.org','2019-02-05',1,29),(34,'UDL13QTC5','Camilla Oliveira','1989-06-13','Camilla Oliveira','camilla.oliveira@4y2.org','2018-10-19',1,30),(37,'UFHFK798A','Eliane Cruz','1980-10-09','Eliane Cruz','eliane.cruz@4y2.org','2019-01-18',1,32),(39,'UHA7FJT41','Felipe Iwamoto','1991-12-04','Felipe T. Iwamoto','felipe.iwamoto@4y2.org','2019-04-01',1,34),(41,'UDV36AYG6','Flamarion Silva','1983-06-29','Flamarion Silva','flamarion.silva@4y2.org','2018-10-25',1,35),(42,'UD5LATE6N','Jo Caixeta','1974-04-15','Jo Caixeta','jo.caixeta@4y2.org','2018-10-01',1,36),(43,'UE2MNTMAL','Leandro Martins','1981-11-13','Leandro Martins - Head of Operation','leandro.martins@4y2.org','2018-11-13',1,37),(44,'UGZ7VP8V7','Maysa Simoes','1969-01-08','MAYSA Andreusa Godoy Simões','maysa.simoes@4y2.org','2019-03-18',1,38),(46,'UEDG5PNQ0','Henrique Borges','1992-05-11','Henrique Borges','hborges9294@gmail.com','2018-12-01',1,15),(47,'UD52W6A9X','Juliana Borges','1992-02-19','Juliana Borges','juliana.borges@4y2.org','2018-10-01',1,39),(48,'UF93R9U7P','Julie Collins','1988-09-10','Julie Collins','julie.collins@4y2.org','2018-01-22',1,40),(49,'UHBM5UTMZ','Louise Scott','1982-09-21','Louise Scott','louise.scott@4y2.org','2019-01-28',1,41),(50,'U9G1NE95F','Mariana Dias','1989-06-17','Mariana Dias - Hub Pedro Leopoldo','mariana.dias@4y2.org','2018-03-01',1,42),(51,'UER3HSR1S','Maya R Rebelo','1995-01-16','Mayara - IT Developer','maya.r.rebelo@gmail.com','2018-12-18',1,48),(52,'UH3SPC0PL','Paula Alves','1979-01-19','Paula Fabrícia Alves da Silva','paula.alves@4y2.org','2019-03-18',1,43),(53,'UFE2Y64F9','Rodrigo Abib','1967-09-23','Rodrigo - Head of Backoffice','rodrigo.abib@4y2.org','2019-01-10',1,44),(54,'UHKGPD77Y','David Santos','1997-07-11','David - IT Developer','daviddsantosd@gmail.com','2019-04-01',1,45),(56,'UJCS81KJ9','Alessandra Custodio','1994-12-07','Alessandra Custodio','alessandra.custodio@4y2.org','2019-05-02',1,46),(57,'UHCAMNS79','Ed Braz','1987-08-07','Ed Braz - Ipiranga’s Hub','ed.braz@4y2.org','2018-09-01',1,47);
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_2265B05D64B64DCC` (`userId`),
  CONSTRAINT `FK_2265B05D64B64DCC` FOREIGN KEY (`userId`) REFERENCES `slack_user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (5,'matheus','123456','a:1:{i:0;s:10:\"ROLE_ADMIN\";}','Matheus Gomes',21),(15,'henrique.silva','11051992','a:1:{i:0;s:10:\"ROLE_ADMIN\";}','Henrique Borges',46),(16,'adriele.correa','19091984','a:1:{i:0;s:9:\"ROLE_USER\";}','Adriele Correa',31),(17,'cleide.andrade','10081971','a:1:{i:0;s:9:\"ROLE_USER\";}','Cleide Andrade',19),(18,'rodrigo.nascimento','25051990','a:1:{i:0;s:9:\"ROLE_USER\";}','Rodrigo Nascimento',20),(19,'gustavo.fuga','26101992','a:1:{i:0;s:9:\"ROLE_USER\";}','Gustavo Fuga',22),(20,'fabia.regina','30061974','a:1:{i:0;s:9:\"ROLE_USER\";}','Fabia Regina',23),(21,'rafael.marcon','09091987','a:1:{i:0;s:9:\"ROLE_USER\";}','Rafael Marcon',24),(22,'janaina.monteiro','09031976','a:1:{i:0;s:9:\"ROLE_USER\";}','Janaina Monteiro',25),(23,'mirko.van.pampus','13021987','a:1:{i:0;s:9:\"ROLE_USER\";}','Mirko Van Pampus',26),(24,'solange.coelho','08111988','a:1:{i:0;s:9:\"ROLE_USER\";}','Solange Coelho',27),(25,'camila.lopes','03031987','a:1:{i:0;s:9:\"ROLE_USER\";}','Camila Lopes',28),(26,'barbara.passos','30031989','a:1:{i:0;s:9:\"ROLE_USER\";}','Barbara Passos',29),(27,'jordana.nogueira','09031985','a:1:{i:0;s:9:\"ROLE_USER\";}','Jordana Nogueira',30),(28,'alessandra.leanza','25071980','a:1:{i:0;s:9:\"ROLE_USER\";}','Alessandra Leanza',32),(29,'alice.paschoal','26081983','a:1:{i:0;s:9:\"ROLE_USER\";}','Alice Paschoal',33),(30,'camilla.oliveira','13061989','a:1:{i:0;s:9:\"ROLE_USER\";}','Camilla Oliveira',34),(32,'eliane.cruz','09101980','a:1:{i:0;s:9:\"ROLE_USER\";}','Eliane Cruz',37),(33,'renan.saggio','06041995','a:1:{i:0;s:9:\"ROLE_USER\";}','Renan Saggio',18),(34,'felipe.iwamoto','04121991','a:1:{i:0;s:9:\"ROLE_USER\";}','Felipe Iwamoto',39),(35,'flamarion.silva','29061983','a:1:{i:0;s:9:\"ROLE_USER\";}','Flamarion Silva',41),(36,'jo.caixeta','15041974','a:1:{i:0;s:9:\"ROLE_USER\";}','Jo Caixeta',42),(37,'leandro.martins','13111981','a:1:{i:0;s:9:\"ROLE_USER\";}','Leandro Martins',43),(38,'maysa.simoes','08011969','a:1:{i:0;s:9:\"ROLE_USER\";}','Maysa Simoes',44),(39,'juliana.borges','19021992','a:1:{i:0;s:9:\"ROLE_USER\";}','Juliana Borges',47),(40,'julie.collins','10091988','a:1:{i:0;s:9:\"ROLE_USER\";}','Julie Collins',48),(41,'louise.scott','21091982','a:1:{i:0;s:9:\"ROLE_USER\";}','Louise Scott',49),(42,'mariana.dias','17061989','a:1:{i:0;s:9:\"ROLE_USER\";}','Mariana Dias',50),(43,'paula.alves','19011979','a:1:{i:0;s:9:\"ROLE_USER\";}','Paula Alves',52),(44,'rodrigo.abib','23091967','a:1:{i:0;s:9:\"ROLE_USER\";}','Rodrigo Abib',53),(45,'david.santos','11071997','a:1:{i:0;s:9:\"ROLE_USER\";}','David Santos',54),(46,'alessandra.custodio','07121994','a:1:{i:0;s:9:\"ROLE_USER\";}','Alessandra Custodio',56),(47,'ed.braz','07081987','a:1:{i:0;s:9:\"ROLE_USER\";}','Ed Braz',57),(48,'maya.r.rebelo','16011995','a:1:{i:0;s:9:\"ROLE_USER\";}','Maya R Rebelo',51);
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

-- Dump completed on 2019-05-08  3:55:14
