-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: vwpkbpmy_shellabratewebsite
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.16.04.1

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
-- Table structure for table `backups_db`
--

DROP TABLE IF EXISTS `backups_db`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backups_db` (
  `backup_id` int(11) NOT NULL AUTO_INCREMENT,
  `backup_filename` tinytext COLLATE utf8_bin NOT NULL,
  `backup_time` tinytext COLLATE utf8_bin NOT NULL,
  `backup_date` tinytext COLLATE utf8_bin NOT NULL,
  `backup_restore_time` tinytext COLLATE utf8_bin NOT NULL,
  `backup_data1` tinytext COLLATE utf8_bin NOT NULL,
  `token` tinytext COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`backup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=489 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backups_db`
--

LOCK TABLES `backups_db` WRITE;
/*!40000 ALTER TABLE `backups_db` DISABLE KEYS */;
INSERT INTO `backups_db` VALUES (287,'ekarasac_shellabratewebsite19Jul2018-13-26-21.sql.gz','1532021181','19Jul2018-13-26-21','','','850165332'),(288,'ekarasac_shellabratewebsite19Jul2018-13-38-15.sql.gz','1532021895','19Jul2018-13-38-15','','','942691194'),(289,'ekarasac_shellabratewebsite19Jul2018-13-40-18.sql.gz','1532022018','19Jul2018-13-40-18','','','2075029083'),(290,'ekarasac_shellabratewebsite19Jul2018-13-41-06.sql.gz','1532022066','19Jul2018-13-41-06','','','773929551'),(291,'ekarasac_shellabratewebsite19Jul2018-13-44-38.sql.gz','1532022278','19Jul2018-13-44-38','','','1366129004'),(292,'vwpkbpmy_shellabratewebsite19Jul2018-14-21-57.sql.gz','1532024517','19Jul2018-14-21-57','','','718430709'),(293,'vwpkbpmy_shellabratewebsite19Jul2018-14-23-35.sql.gz','1532024615','19Jul2018-14-23-35','','','1313532898'),(294,'vwpkbpmy_shellabratewebsite19Jul2018-14-24-33.sql.gz','1532024673','19Jul2018-14-24-33','','','660128535'),(295,'vwpkbpmy_shellabratewebsite19Jul2018-14-25-11.sql.gz','1532024711','19Jul2018-14-25-11','','','1738826449'),(296,'vwpkbpmy_shellabratewebsite19Jul2018-14-44-29.sql.gz','1532025869','19Jul2018-14-44-29','','','333192397'),(297,'vwpkbpmy_shellabratewebsite19Jul2018-19-10-28.sql.gz','1532041828','19Jul2018-19-10-28','','','152685149'),(298,'vwpkbpmy_shellabratewebsite21Jul2018-14-00-29.sql.gz','1532196029','21Jul2018-14-00-29','','','27365719'),(299,'vwpkbpmy_shellabratewebsite21Jul2018-21-09-29.sql.gz','1532221769','21Jul2018-21-09-29','','','454726668'),(300,'vwpkbpmy_shellabratewebsite21Jul2018-21-13-26.sql.gz','1532222006','21Jul2018-21-13-26','','','475840461'),(301,'vwpkbpmy_shellabratewebsite23Jul2018-18-12-56.sql.gz','1532383976','23Jul2018-18-12-56','','','2006061031'),(302,'vwpkbpmy_shellabratewebsite23Jul2018-18-14-20.sql.gz','1532384060','23Jul2018-18-14-20','','','309022589'),(303,'vwpkbpmy_shellabratewebsite26Jul2018-16-18-49.sql.gz','1532636329','26Jul2018-16-18-49','','','1563228740'),(304,'vwpkbpmy_shellabratewebsite26Jul2018-16-20-15.sql.gz','1532636415','26Jul2018-16-20-15','','','712879908'),(305,'vwpkbpmy_shellabratewebsite26Jul2018-16-20-49.sql.gz','1532636449','26Jul2018-16-20-49','','','814205827'),(306,'vwpkbpmy_shellabratewebsite26Jul2018-16-21-39.sql.gz','1532636499','26Jul2018-16-21-39','','','999241851'),(307,'vwpkbpmy_shellabratewebsite29Jul2018-10-15-18.sql.gz','1532873718','29Jul2018-10-15-18','','','761460464'),(308,'vwpkbpmy_shellabratewebsite29Jul2018-18-27-34.sql.gz','1532903254','29Jul2018-18-27-34','','','1677935479'),(309,'vwpkbpmy_shellabratewebsite29Jul2018-18-57-11.sql.gz','1532905031','29Jul2018-18-57-11','','','915024618'),(310,'vwpkbpmy_shellabratewebsite29Jul2018-19-00-35.sql.gz','1532905235','29Jul2018-19-00-35','','','1608716959'),(311,'vwpkbpmy_shellabratewebsite29Jul2018-19-07-29.sql.gz','1532905649','29Jul2018-19-07-29','','','1765795652'),(312,'vwpkbpmy_shellabratewebsite29Jul2018-19-09-54.sql.gz','1532905795','29Jul2018-19-09-55','','','393019257'),(313,'vwpkbpmy_shellabratewebsite29Jul2018-19-36-23.sql.gz','1532907383','29Jul2018-19-36-23','','','1553355684'),(314,'vwpkbpmy_shellabratewebsite29Jul2018-19-37-09.sql.gz','1532907429','29Jul2018-19-37-09','','','183591192'),(315,'vwpkbpmy_shellabratewebsite30Jul2018-16-13-32.sql.gz','1532981612','30Jul2018-16-13-32','','','1026341039'),(316,'vwpkbpmy_shellabratewebsite30Jul2018-16-19-19.sql.gz','1532981959','30Jul2018-16-19-19','','','1890881564'),(317,'vwpkbpmy_shellabratewebsite30Jul2018-16-22-48.sql.gz','1532982168','30Jul2018-16-22-48','','','1803067373'),(318,'vwpkbpmy_shellabratewebsite30Jul2018-16-24-28.sql.gz','1532982268','30Jul2018-16-24-28','','','2099029601'),(319,'vwpkbpmy_shellabratewebsite30Jul2018-19-46-29.sql.gz','1532994389','30Jul2018-19-46-29','','','2011605100'),(320,'vwpkbpmy_shellabratewebsite31Jul2018-14-05-46.sql.gz','1533060346','31Jul2018-14-05-46','','','2105870049'),(321,'vwpkbpmy_shellabratewebsite31Jul2018-14-07-45.sql.gz','1533060465','31Jul2018-14-07-45','','','1485387378'),(322,'vwpkbpmy_shellabratewebsite31Jul2018-14-14-13.sql.gz','1533060853','31Jul2018-14-14-13','','','338526504'),(323,'vwpkbpmy_shellabratewebsite31Jul2018-14-22-52.sql.gz','1533061372','31Jul2018-14-22-52','','','2030944836'),(324,'vwpkbpmy_shellabratewebsite31Jul2018-15-48-45.sql.gz','1533066525','31Jul2018-15-48-45','','','861349738'),(325,'vwpkbpmy_shellabratewebsite31Jul2018-15-51-39.sql.gz','1533066699','31Jul2018-15-51-39','','','2116064786'),(326,'vwpkbpmy_shellabratewebsite31Jul2018-19-37-23.sql.gz','1533080243','31Jul2018-19-37-23','','','1391757002'),(327,'vwpkbpmy_shellabratewebsite31Jul2018-19-52-59.sql.gz','1533081179','31Jul2018-19-52-59','','','1268539725'),(328,'vwpkbpmy_shellabratewebsite31Jul2018-19-53-52.sql.gz','1533081232','31Jul2018-19-53-52','','','1914955647'),(329,'vwpkbpmy_shellabratewebsite31Jul2018-19-55-26.sql.gz','1533081326','31Jul2018-19-55-26','','','48395787'),(330,'vwpkbpmy_shellabratewebsite01Aug2018-14-59-34.sql.gz','1533149974','01Aug2018-14-59-34','','','500340214'),(331,'vwpkbpmy_shellabratewebsite01Aug2018-15-04-14.sql.gz','1533150254','01Aug2018-15-04-14','','','787550394'),(332,'vwpkbpmy_shellabratewebsite02Aug2018-16-44-42.sql.gz','1533242682','02Aug2018-16-44-42','','','1500844799'),(333,'vwpkbpmy_shellabratewebsite02Aug2018-17-08-53.sql.gz','1533244133','02Aug2018-17-08-53','','','691267124'),(334,'vwpkbpmy_shellabratewebsite02Aug2018-17-11-40.sql.gz','1533244300','02Aug2018-17-11-40','','','1784987419'),(335,'vwpkbpmy_shellabratewebsite02Aug2018-17-12-38.sql.gz','1533244358','02Aug2018-17-12-38','','','1554128887'),(336,'vwpkbpmy_shellabratewebsite02Aug2018-17-19-02.sql.gz','1533244742','02Aug2018-17-19-02','','','1130691166'),(337,'vwpkbpmy_shellabratewebsite02Aug2018-18-50-39.sql.gz','1533250239','02Aug2018-18-50-39','','','983586505'),(338,'vwpkbpmy_shellabratewebsite03Aug2018-10-15-14.sql.gz','1533305714','03Aug2018-10-15-14','','','1475669131'),(339,'vwpkbpmy_shellabratewebsite03Aug2018-10-15-46.sql.gz','1533305746','03Aug2018-10-15-46','','','1971391975'),(340,'vwpkbpmy_shellabratewebsite03Aug2018-16-00-16.sql.gz','1533326416','03Aug2018-16-00-16','','','647741324'),(341,'vwpkbpmy_shellabratewebsite03Aug2018-17-56-02.sql.gz','1533333362','03Aug2018-17-56-02','','','571132532'),(342,'vwpkbpmy_shellabratewebsite03Aug2018-17-57-32.sql.gz','1533333452','03Aug2018-17-57-32','','','1200112600'),(343,'vwpkbpmy_shellabratewebsite03Aug2018-17-58-23.sql.gz','1533333503','03Aug2018-17-58-23','','','1337693034'),(344,'vwpkbpmy_shellabratewebsite03Aug2018-18-14-03.sql.gz','1533334443','03Aug2018-18-14-03','','','1542295341'),(345,'vwpkbpmy_shellabratewebsite03Aug2018-18-20-59.sql.gz','1533334859','03Aug2018-18-20-59','','','1759324607'),(346,'vwpkbpmy_shellabratewebsite03Aug2018-19-00-38.sql.gz','1533337238','03Aug2018-19-00-38','','','955619648'),(347,'vwpkbpmy_shellabratewebsite03Aug2018-19-02-15.sql.gz','1533337335','03Aug2018-19-02-15','','','1189547842'),(348,'vwpkbpmy_shellabratewebsite03Aug2018-19-04-47.sql.gz','1533337487','03Aug2018-19-04-47','','','689494349'),(349,'vwpkbpmy_shellabratewebsite03Aug2018-19-08-09.sql.gz','1533337689','03Aug2018-19-08-09','','','1862664304'),(350,'vwpkbpmy_shellabratewebsite03Aug2018-21-10-53.sql.gz','1533345054','03Aug2018-21-10-54','','','612370794'),(351,'vwpkbpmy_shellabratewebsite03Aug2018-22-01-58.sql.gz','1533348118','03Aug2018-22-01-58','','','20306637'),(352,'vwpkbpmy_shellabratewebsite03Aug2018-22-04-18.sql.gz','1533348258','03Aug2018-22-04-18','','','333522608'),(353,'vwpkbpmy_shellabratewebsite03Aug2018-22-07-50.sql.gz','1533348470','03Aug2018-22-07-50','','','526384254'),(354,'vwpkbpmy_shellabratewebsite03Aug2018-22-11-00.sql.gz','1533348660','03Aug2018-22-11-00','','','185144772'),(355,'vwpkbpmy_shellabratewebsite04Aug2018-08-39-48.sql.gz','1533386388','04Aug2018-08-39-48','','','788421099'),(356,'vwpkbpmy_shellabratewebsite04Aug2018-08-52-29.sql.gz','1533387149','04Aug2018-08-52-29','','','258273084'),(357,'vwpkbpmy_shellabratewebsite04Aug2018-08-54-21.sql.gz','1533387261','04Aug2018-08-54-21','','','937610231'),(358,'vwpkbpmy_shellabratewebsite04Aug2018-08-54-54.sql.gz','1533387294','04Aug2018-08-54-54','','','286519744'),(359,'vwpkbpmy_shellabratewebsite04Aug2018-09-10-27.sql.gz','1533388227','04Aug2018-09-10-27','','','805251267'),(360,'vwpkbpmy_shellabratewebsite04Aug2018-09-17-42.sql.gz','1533388662','04Aug2018-09-17-42','','','483699781'),(361,'vwpkbpmy_shellabratewebsite04Aug2018-09-19-40.sql.gz','1533388780','04Aug2018-09-19-40','','','1811234236'),(362,'vwpkbpmy_shellabratewebsite04Aug2018-09-33-23.sql.gz','1533389603','04Aug2018-09-33-23','','','708393199'),(363,'vwpkbpmy_shellabratewebsite04Aug2018-11-57-09.sql.gz','1533398229','04Aug2018-11-57-09','','','1445259381'),(364,'vwpkbpmy_shellabratewebsite04Aug2018-13-36-13.sql.gz','1533404173','04Aug2018-13-36-13','','','33142332'),(365,'vwpkbpmy_shellabratewebsite04Aug2018-13-38-35.sql.gz','1533404315','04Aug2018-13-38-35','','','492944387'),(366,'vwpkbpmy_shellabratewebsite04Aug2018-13-40-20.sql.gz','1533404420','04Aug2018-13-40-20','','','83829821'),(367,'vwpkbpmy_shellabratewebsite04Aug2018-13-42-24.sql.gz','1533404544','04Aug2018-13-42-24','','','1386556843'),(368,'vwpkbpmy_shellabratewebsite04Aug2018-13-49-19.sql.gz','1533404959','04Aug2018-13-49-19','','','905547187'),(369,'vwpkbpmy_shellabratewebsite04Aug2018-13-50-50.sql.gz','1533405050','04Aug2018-13-50-50','','','1793269326'),(370,'vwpkbpmy_shellabratewebsite04Aug2018-13-53-04.sql.gz','1533405184','04Aug2018-13-53-04','','','1141943975'),(371,'vwpkbpmy_shellabratewebsite04Aug2018-15-03-07.sql.gz','1533409387','04Aug2018-15-03-07','','','1630669583'),(372,'vwpkbpmy_shellabratewebsite04Aug2018-15-04-53.sql.gz','1533409493','04Aug2018-15-04-53','','','812654538'),(373,'vwpkbpmy_shellabratewebsite04Aug2018-15-28-11.sql.gz','1533410891','04Aug2018-15-28-11','','','754450695'),(374,'vwpkbpmy_shellabratewebsite04Aug2018-15-32-56.sql.gz','1533411176','04Aug2018-15-32-56','','','1116226823'),(375,'vwpkbpmy_shellabratewebsite04Aug2018-15-52-35.sql.gz','1533412355','04Aug2018-15-52-35','','','336832106'),(376,'vwpkbpmy_shellabratewebsite04Aug2018-15-56-04.sql.gz','1533412564','04Aug2018-15-56-04','','','1483560400'),(377,'vwpkbpmy_shellabratewebsite04Aug2018-15-58-01.sql.gz','1533412681','04Aug2018-15-58-01','','','1530260303'),(378,'vwpkbpmy_shellabratewebsite04Aug2018-16-00-03.sql.gz','1533412803','04Aug2018-16-00-03','','','1317177033'),(379,'vwpkbpmy_shellabratewebsite04Aug2018-16-03-13.sql.gz','1533412993','04Aug2018-16-03-13','','','909589287'),(380,'vwpkbpmy_shellabratewebsite04Aug2018-16-09-22.sql.gz','1533413362','04Aug2018-16-09-22','','','281402435'),(381,'vwpkbpmy_shellabratewebsite04Aug2018-16-17-18.sql.gz','1533413838','04Aug2018-16-17-18','','','1128045619'),(382,'vwpkbpmy_shellabratewebsite04Aug2018-16-17-59.sql.gz','1533413879','04Aug2018-16-17-59','','','360263003'),(383,'vwpkbpmy_shellabratewebsite04Aug2018-16-18-18.sql.gz','1533413898','04Aug2018-16-18-18','','','1866136050'),(384,'vwpkbpmy_shellabratewebsite04Aug2018-16-21-11.sql.gz','1533414071','04Aug2018-16-21-11','','','1656050981'),(385,'vwpkbpmy_shellabratewebsite04Aug2018-16-21-36.sql.gz','1533414096','04Aug2018-16-21-36','','','190529294'),(386,'vwpkbpmy_shellabratewebsite04Aug2018-16-23-10.sql.gz','1533414190','04Aug2018-16-23-10','','','1105756147'),(387,'vwpkbpmy_shellabratewebsite04Aug2018-16-24-01.sql.gz','1533414241','04Aug2018-16-24-01','','','1094659966'),(388,'vwpkbpmy_shellabratewebsite04Aug2018-16-25-49.sql.gz','1533414349','04Aug2018-16-25-49','','','1705633980'),(389,'vwpkbpmy_shellabratewebsite04Aug2018-16-27-08.sql.gz','1533414428','04Aug2018-16-27-08','','','1589696831'),(390,'vwpkbpmy_shellabratewebsite04Aug2018-16-28-18.sql.gz','1533414498','04Aug2018-16-28-18','','','737941620'),(391,'vwpkbpmy_shellabratewebsite04Aug2018-19-48-39.sql.gz','1533426519','04Aug2018-19-48-39','','','1415470049'),(392,'vwpkbpmy_shellabratewebsite05Aug2018-09-47-51.sql.gz','1533476871','05Aug2018-09-47-51','','','801531146'),(393,'vwpkbpmy_shellabratewebsite05Aug2018-09-56-25.sql.gz','1533477385','05Aug2018-09-56-25','','','389947722'),(394,'vwpkbpmy_shellabratewebsite05Aug2018-10-02-41.sql.gz','1533477761','05Aug2018-10-02-41','','','1264497485'),(395,'vwpkbpmy_shellabratewebsite05Aug2018-10-09-04.sql.gz','1533478144','05Aug2018-10-09-04','','','449482318'),(396,'vwpkbpmy_shellabratewebsite05Aug2018-10-11-18.sql.gz','1533478278','05Aug2018-10-11-18','','','41690400'),(397,'vwpkbpmy_shellabratewebsite05Aug2018-10-13-07.sql.gz','1533478387','05Aug2018-10-13-07','','','1684899811'),(398,'vwpkbpmy_shellabratewebsite05Aug2018-10-21-49.sql.gz','1533478909','05Aug2018-10-21-49','','','936434596'),(399,'vwpkbpmy_shellabratewebsite05Aug2018-10-27-08.sql.gz','1533479228','05Aug2018-10-27-08','','','1979750531'),(400,'vwpkbpmy_shellabratewebsite05Aug2018-10-27-36.sql.gz','1533479256','05Aug2018-10-27-36','','','1105044248'),(401,'vwpkbpmy_shellabratewebsite05Aug2018-10-33-51.sql.gz','1533479631','05Aug2018-10-33-51','','','496466819'),(402,'vwpkbpmy_shellabratewebsite05Aug2018-10-34-31.sql.gz','1533479671','05Aug2018-10-34-31','','','1467569394'),(403,'vwpkbpmy_shellabratewebsite05Aug2018-10-36-33.sql.gz','1533479793','05Aug2018-10-36-33','','','584609615'),(404,'vwpkbpmy_shellabratewebsite05Aug2018-10-42-54.sql.gz','1533480174','05Aug2018-10-42-54','','','575025148'),(405,'vwpkbpmy_shellabratewebsite05Aug2018-14-06-59.sql.gz','1533492419','05Aug2018-14-06-59','','','854120673'),(406,'vwpkbpmy_shellabratewebsite05Aug2018-14-07-37.sql.gz','1533492457','05Aug2018-14-07-37','','','1210769665'),(407,'vwpkbpmy_shellabratewebsite05Aug2018-14-08-52.sql.gz','1533492532','05Aug2018-14-08-52','','','1105846816'),(408,'vwpkbpmy_shellabratewebsite05Aug2018-14-57-02.sql.gz','1533495422','05Aug2018-14-57-02','','','1836737514'),(409,'vwpkbpmy_shellabratewebsite05Aug2018-17-10-05.sql.gz','1533503405','05Aug2018-17-10-05','','','1808758004'),(410,'vwpkbpmy_shellabratewebsite05Aug2018-17-10-40.sql.gz','1533503440','05Aug2018-17-10-40','','','1450403850'),(411,'vwpkbpmy_shellabratewebsite05Aug2018-17-12-28.sql.gz','1533503548','05Aug2018-17-12-28','','','611837936'),(412,'vwpkbpmy_shellabratewebsite05Aug2018-17-12-50.sql.gz','1533503570','05Aug2018-17-12-50','','','1663605083'),(413,'vwpkbpmy_shellabratewebsite05Aug2018-17-13-51.sql.gz','1533503631','05Aug2018-17-13-51','','','2086487599'),(414,'vwpkbpmy_shellabratewebsite05Aug2018-17-14-26.sql.gz','1533503666','05Aug2018-17-14-26','','','344026719'),(415,'vwpkbpmy_shellabratewebsite05Aug2018-17-34-09.sql.gz','1533504850','05Aug2018-17-34-10','','','1849305684'),(416,'vwpkbpmy_shellabratewebsite05Aug2018-17-47-45.sql.gz','1533505665','05Aug2018-17-47-45','','','411306396'),(417,'vwpkbpmy_shellabratewebsite05Aug2018-18-13-23.sql.gz','1533507203','05Aug2018-18-13-23','','','1102825516'),(418,'vwpkbpmy_shellabratewebsite05Aug2018-18-13-57.sql.gz','1533507237','05Aug2018-18-13-57','','','59943915'),(419,'vwpkbpmy_shellabratewebsite05Aug2018-18-19-11.sql.gz','1533507551','05Aug2018-18-19-11','','','1883719398'),(420,'vwpkbpmy_shellabratewebsite05Aug2018-18-19-40.sql.gz','1533507580','05Aug2018-18-19-40','','','1285510060'),(421,'vwpkbpmy_shellabratewebsite06Aug2018-07-51-03.sql.gz','1533556263','06Aug2018-07-51-03','','','1263528220'),(422,'vwpkbpmy_shellabratewebsite06Aug2018-09-13-43.sql.gz','1533561223','06Aug2018-09-13-43','','','319119686'),(423,'vwpkbpmy_shellabratewebsite06Aug2018-09-14-13.sql.gz','1533561253','06Aug2018-09-14-13','','','1897837742'),(424,'vwpkbpmy_shellabratewebsite06Aug2018-09-14-46.sql.gz','1533561286','06Aug2018-09-14-46','','','1896743139'),(425,'vwpkbpmy_shellabratewebsite06Aug2018-09-16-57.sql.gz','1533561417','06Aug2018-09-16-57','','','224347621'),(426,'vwpkbpmy_shellabratewebsite06Aug2018-09-20-45.sql.gz','1533561645','06Aug2018-09-20-45','','','1403846899'),(427,'vwpkbpmy_shellabratewebsite06Aug2018-09-48-47.sql.gz','1533563327','06Aug2018-09-48-47','','','911730934'),(428,'vwpkbpmy_shellabratewebsite06Aug2018-12-25-27.sql.gz','1533572727','06Aug2018-12-25-27','','','63981325'),(429,'vwpkbpmy_shellabratewebsite06Aug2018-13-31-34.sql.gz','1533576694','06Aug2018-13-31-34','','','442699859'),(430,'vwpkbpmy_shellabratewebsite06Aug2018-13-33-41.sql.gz','1533576821','06Aug2018-13-33-41','','','2111675660'),(431,'vwpkbpmy_shellabratewebsite06Aug2018-14-03-46.sql.gz','1533578626','06Aug2018-14-03-46','','','1737764634'),(432,'vwpkbpmy_shellabratewebsite06Aug2018-14-10-09.sql.gz','1533579009','06Aug2018-14-10-09','','','1472524483'),(433,'vwpkbpmy_shellabratewebsite06Aug2018-14-11-10.sql.gz','1533579070','06Aug2018-14-11-10','','','1665831716'),(434,'vwpkbpmy_shellabratewebsite06Aug2018-14-14-31.sql.gz','1533579271','06Aug2018-14-14-31','','','1603881393'),(435,'vwpkbpmy_shellabratewebsite06Aug2018-14-16-27.sql.gz','1533579387','06Aug2018-14-16-27','','','550986621'),(436,'vwpkbpmy_shellabratewebsite06Aug2018-14-52-05.sql.gz','1533581525','06Aug2018-14-52-05','','','2044675398'),(437,'vwpkbpmy_shellabratewebsite06Aug2018-14-56-37.sql.gz','1533581797','06Aug2018-14-56-37','','','868971228'),(438,'vwpkbpmy_shellabratewebsite06Aug2018-14-58-36.sql.gz','1533581916','06Aug2018-14-58-36','','','1898390377'),(439,'vwpkbpmy_shellabratewebsite06Aug2018-15-13-07.sql.gz','1533582787','06Aug2018-15-13-07','','','326214783'),(440,'vwpkbpmy_shellabratewebsite06Aug2018-15-17-30.sql.gz','1533583050','06Aug2018-15-17-30','','','107989333'),(441,'vwpkbpmy_shellabratewebsite06Aug2018-15-21-57.sql.gz','1533583317','06Aug2018-15-21-57','','','1013419063'),(442,'vwpkbpmy_shellabratewebsite06Aug2018-15-24-41.sql.gz','1533583481','06Aug2018-15-24-41','','','1422057447'),(443,'vwpkbpmy_shellabratewebsite06Aug2018-15-28-27.sql.gz','1533583707','06Aug2018-15-28-27','','','836041345'),(444,'vwpkbpmy_shellabratewebsite06Aug2018-15-48-07.sql.gz','1533584887','06Aug2018-15-48-07','','','2114719629'),(445,'vwpkbpmy_shellabratewebsite06Aug2018-15-50-25.sql.gz','1533585025','06Aug2018-15-50-25','','','1586246840'),(446,'vwpkbpmy_shellabratewebsite06Aug2018-15-52-43.sql.gz','1533585163','06Aug2018-15-52-43','','','1980488389'),(447,'vwpkbpmy_shellabratewebsite06Aug2018-16-02-54.sql.gz','1533585774','06Aug2018-16-02-54','','','106730165'),(448,'vwpkbpmy_shellabratewebsite06Aug2018-17-21-13.sql.gz','1533590473','06Aug2018-17-21-13','','','1100383866'),(449,'vwpkbpmy_shellabratewebsite06Aug2018-17-29-10.sql.gz','1533590951','06Aug2018-17-29-11','','','1465788063'),(450,'vwpkbpmy_shellabratewebsite06Aug2018-17-32-21.sql.gz','1533591141','06Aug2018-17-32-21','','','1187174701'),(451,'vwpkbpmy_shellabratewebsite06Aug2018-17-35-33.sql.gz','1533591333','06Aug2018-17-35-33','','','1846777324'),(452,'vwpkbpmy_shellabratewebsite06Aug2018-17-37-59.sql.gz','1533591479','06Aug2018-17-37-59','','','310236893'),(453,'vwpkbpmy_shellabratewebsite06Aug2018-17-38-24.sql.gz','1533591504','06Aug2018-17-38-24','','','425119377'),(454,'vwpkbpmy_shellabratewebsite06Aug2018-17-41-39.sql.gz','1533591699','06Aug2018-17-41-39','','','1745627925'),(455,'vwpkbpmy_shellabratewebsite06Aug2018-17-41-59.sql.gz','1533591720','06Aug2018-17-42-00','','','1184268448'),(456,'vwpkbpmy_shellabratewebsite06Aug2018-17-51-01.sql.gz','1533592261','06Aug2018-17-51-01','','','1264846286'),(457,'vwpkbpmy_shellabratewebsite06Aug2018-17-51-44.sql.gz','1533592304','06Aug2018-17-51-44','','','1049552149'),(458,'vwpkbpmy_shellabratewebsite06Aug2018-17-51-55.sql.gz','1533592315','06Aug2018-17-51-55','','','527185585'),(459,'vwpkbpmy_shellabratewebsite06Aug2018-17-54-37.sql.gz','1533592477','06Aug2018-17-54-37','','','1645221365'),(460,'vwpkbpmy_shellabratewebsite07Aug2018-09-58-45.sql.gz','1533650325','07Aug2018-09-58-45','','','622483885'),(461,'vwpkbpmy_shellabratewebsite07Aug2018-10-06-26.sql.gz','1533650786','07Aug2018-10-06-26','','','323026020'),(462,'vwpkbpmy_shellabratewebsite07Aug2018-11-31-17.sql.gz','1533655877','07Aug2018-11-31-17','','','1155941189'),(463,'vwpkbpmy_shellabratewebsite07Aug2018-12-25-46.sql.gz','1533659146','07Aug2018-12-25-46','','','1789233181'),(464,'vwpkbpmy_shellabratewebsite07Aug2018-12-31-14.sql.gz','1533659474','07Aug2018-12-31-14','','','1897551065'),(465,'vwpkbpmy_shellabratewebsite07Aug2018-12-34-12.sql.gz','1533659652','07Aug2018-12-34-12','','','1422303357'),(466,'vwpkbpmy_shellabratewebsite07Aug2018-12-34-44.sql.gz','1533659684','07Aug2018-12-34-44','','','1081174130'),(467,'vwpkbpmy_shellabratewebsite07Aug2018-12-37-15.sql.gz','1533659836','07Aug2018-12-37-16','','','426430782'),(468,'vwpkbpmy_shellabratewebsite07Aug2018-12-44-05.sql.gz','1533660245','07Aug2018-12-44-05','','','57380316'),(469,'vwpkbpmy_shellabratewebsite09Aug2018-13-03-30.sql.gz','1533834210','09Aug2018-13-03-30','','','665310160'),(470,'vwpkbpmy_shellabratewebsite09Aug2018-13-07-08.sql.gz','1533834428','09Aug2018-13-07-08','','','726916837'),(471,'vwpkbpmy_shellabratewebsite09Aug2018-13-10-22.sql.gz','1533834622','09Aug2018-13-10-22','','','1421291956'),(472,'vwpkbpmy_shellabratewebsite09Aug2018-13-11-50.sql.gz','1533834710','09Aug2018-13-11-50','','','2015838168'),(473,'vwpkbpmy_shellabratewebsite09Aug2018-13-17-39.sql.gz','1533835059','09Aug2018-13-17-39','','','1850362961'),(474,'vwpkbpmy_shellabratewebsite09Aug2018-13-56-53.sql.gz','1533837413','09Aug2018-13-56-53','','','681117812'),(475,'vwpkbpmy_shellabratewebsite09Aug2018-13-57-23.sql.gz','1533837443','09Aug2018-13-57-23','','','35116016'),(476,'vwpkbpmy_shellabratewebsite09Aug2018-13-57-51.sql.gz','1533837471','09Aug2018-13-57-51','','','1673441707'),(477,'vwpkbpmy_shellabratewebsite18Oct2018-12-58-55.sql.gz','1539881935','18Oct2018-12-58-55','','','1802484708'),(478,'vwpkbpmy_shellabratewebsite18Oct2018-13-02-12.sql.gz','1539882132','18Oct2018-13-02-12','','','1934989621'),(479,'vwpkbpmy_shellabratewebsite18Oct2018-13-02-54.sql.gz','1539882174','18Oct2018-13-02-54','','','1851829953'),(480,'vwpkbpmy_shellabratewebsite18Oct2018-13-09-35.sql.gz','1539882575','18Oct2018-13-09-35','','','1580489637'),(481,'vwpkbpmy_shellabratewebsite18Oct2018-13-11-26.sql.gz','1539882686','18Oct2018-13-11-26','','','925605242'),(482,'vwpkbpmy_shellabratewebsite18Oct2018-13-17-23.sql.gz','1539883043','18Oct2018-13-17-23','','','673688337'),(483,'vwpkbpmy_shellabratewebsite18Oct2018-13-50-21.sql.gz','1539885021','18Oct2018-13-50-21','','','1836544816'),(484,'vwpkbpmy_shellabratewebsite18Oct2018-13-52-12.sql.gz','1539885132','18Oct2018-13-52-12','','','614810978'),(485,'vwpkbpmy_shellabratewebsite18Oct2018-13-53-08.sql.gz','1539885188','18Oct2018-13-53-08','','','1212896700'),(486,'vwpkbpmy_shellabratewebsite18Oct2018-13-54-13.sql.gz','1539885253','18Oct2018-13-54-13','','','1756072952'),(487,'vwpkbpmy_shellabratewebsite18Oct2018-14-00-10.sql.gz','1539885610','18Oct2018-14-00-10','','','1611818434'),(488,'vwpkbpmy_shellabratewebsite18Oct2018-14-01-40.sql.gz','1539885700','18Oct2018-14-01-40','','','1298010986');
/*!40000 ALTER TABLE `backups_db` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `columns`
--

DROP TABLE IF EXISTS `columns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `columns` (
  `col_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `col_table_base` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_table` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_num` tinyint(4) NOT NULL,
  `col_primary` tinyint(1) NOT NULL,
  `col_options` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_clone_target` tinytext NOT NULL,
  `col_status` tinytext NOT NULL,
  `col_gridspace_right` tinytext NOT NULL,
  `col_gridspace_left` tinytext NOT NULL,
  `col_grid_width` tinytext NOT NULL,
  `col_grid_clone` tinytext NOT NULL,
  `col_flex_box` tinytext NOT NULL,
  `col_style` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_temp` tinytext NOT NULL,
  `col_grp_bor_style` text NOT NULL,
  `col_comment_style` text NOT NULL,
  `col_date_style` text NOT NULL,
  `col_comment_date_style` text NOT NULL,
  `col_comment_view_style` text NOT NULL,
  `col_clone_target_base` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_hr` tinytext NOT NULL,
  `col_update` tinytext NOT NULL,
  `col_width` tinytext NOT NULL,
  `col_tcol_num` decimal(5,1) NOT NULL,
  `token` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_time` tinytext NOT NULL,
  PRIMARY KEY (`col_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `columns`
--

LOCK TABLES `columns` WRITE;
/*!40000 ALTER TABLE `columns` DISABLE KEYS */;
INSERT INTO `columns` VALUES (1,'indexpage','indexpage_col_id1',0,0,'0','0','move','0','0','0','0','','0,,,88@@%@@15,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0','0','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','04Aug2018-08-39-48','',0.0,'604384371','1533592261'),(2,'indexpage','indexpage_col_id2',0,0,',,,,,,,,,,,,,static','','move','','','','','',',40,,0,,,30,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','04Aug2018-19-48-39','79.09091',0.0,'604384371','1533592261'),(10,'mermaids','mermaids_col_id10',1,1,'0','0','0','0','0','0','0','','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0','0','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','10Jul2018-13-35-57','0',1.0,'604384371','1533592261'),(9,'indexpage','indexpage_col_id9',0,0,',,,,,,,,,,,,,static','','move','','','','','',',40,,0,,,30,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','04Aug2018-19-48-39','79.09091',0.0,'604384371','1533592261'),(8,'indexpage','indexpage_col_id8',0,0,',,,,,,,,,,,,,static','','move','','','','','',',40,,0,,,30,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','04Aug2018-19-48-39','79.09091',0.0,'604384371','1533592261'),(6,'indexpage','indexpage_col_id6',0,0,',,,,,,,,,,,,,static','','move','','','','','',',40,,0,,,30,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','04Aug2018-19-48-39','79.09091',0.0,'604384371','1533592261'),(11,'hearts','hearts_col_id11',1,1,'0','0','0','0','0','0','0','','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0','0','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','10Jul2018-16-22-27','0',1.0,'604384371','1533592261'),(12,'angels','angels_col_id12',1,1,'0','0','0','0','0','0','0','','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0','0','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','10Jul2018-19-17-43','0',1.0,'604384371','1533592261'),(14,'deep_blue_sea','deep_blue_sea_col_id14',1,1,'0','0','0','0','0','0','0','','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0','0','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','11Jul2018-15-36-53','0',1.0,'604384371','1533592261'),(16,'indexpage','indexpage_col_id16',1,1,'0','0','move','0','0','0','0','','0,,,,,,,,,,24@@@@@@1600@@300@@160,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','0','0','0,,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','09Aug2018-13-11-49','1600',1.0,'809886056','1533834709'),(21,'contact','contact_col_id21',0,0,'','','unclone','','','','','',',30,30,0@@%@@10,0@@%@@10,90,,0,0,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@oceanshellpalmcropped.jpg@@1@@no-repeat@@0@@0@@0@@cover@@50@@50@@50@@0@@0@@0@@0@@0@@0','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','07Aug2018-12-44-05','45.45455',0.0,'1839436482','1533660245'),(20,'contact','contact_col_id20',1,1,'0','16','clone','0','0','0','0','','0','','0','0','0','0','0','indexpage','0','12Jul2018-15-48-50','0',2.0,'679843244','1533592261'),(22,'contact','contact_col_id22',0,0,'','','','','','','','','','','','','','','','','','12Jul2018-19-40-43','',0.0,'604384371','1533592261'),(23,'contact','contact_col_id23',0,0,'','','','','','','','','','','','','','','','','','12Jul2018-19-41-37','',0.0,'604384371','1533592261'),(24,'indexpage','indexpage_col_id24',0,0,'','','','','','','','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','05Aug2018-10-27-08','',0.0,'604384371','1533592261');
/*!40000 ALTER TABLE `columns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT,
  `com_blog_id` int(11) NOT NULL,
  `com_text` text COLLATE utf8_bin NOT NULL,
  `com_name` tinytext COLLATE utf8_bin NOT NULL,
  `com_status` tinyint(4) NOT NULL,
  `com_update` tinytext COLLATE utf8_bin NOT NULL,
  `com_token` tinytext COLLATE utf8_bin NOT NULL,
  `com_time` tinytext COLLATE utf8_bin NOT NULL,
  `token` tinytext COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`com_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `directory`
--

DROP TABLE IF EXISTS `directory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `directory` (
  `dir_id` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `dir_menu_id` smallint(6) NOT NULL,
  `dir_menu_style` tinytext NOT NULL,
  `dir_menu_order` decimal(5,1) NOT NULL,
  `dir_sub_menu_order` decimal(5,1) NOT NULL,
  `dir_filename` tinytext NOT NULL,
  `dir_title` tinytext NOT NULL,
  `dir_ref` tinytext NOT NULL,
  `dir_gall_table` tinytext NOT NULL,
  `dir_blog_table` tinytext NOT NULL,
  `dir_menu_type` tinytext NOT NULL,
  `dir_gall_type` tinytext NOT NULL,
  `dir_menu_opts` tinytext NOT NULL,
  `dir_hide_sub_menu` tinytext NOT NULL,
  `dir_external` tinytext NOT NULL,
  `dir_internal` tinytext NOT NULL,
  `dir_temp` decimal(5,1) NOT NULL,
  `dir_temp2` decimal(5,1) NOT NULL,
  `dir_is_gall` tinyint(1) NOT NULL,
  `dir_update` tinytext NOT NULL,
  `token` tinytext NOT NULL,
  `dir_time` tinytext NOT NULL,
  PRIMARY KEY (`dir_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `directory`
--

LOCK TABLES `directory` WRITE;
/*!40000 ALTER TABLE `directory` DISABLE KEYS */;
INSERT INTO `directory` VALUES (3,1,'',1.0,0.0,'index','HOME','indexpage','','','','','','','','',0.0,1.0,0,'15Jul2018-10-54-01','1181769887','1531666441'),(4,1,'0',2.0,0.0,'contact','Contact','contact','0','0','0','0','0','0','0','0',0.0,2.0,0,'15Jul2018-10-54-01','1181769887','1531666441');
/*!40000 ALTER TABLE `directory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempting`
--

DROP TABLE IF EXISTS `login_attempting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `time` varchar(30) NOT NULL,
  `salt` char(128) NOT NULL,
  `lockout` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempting`
--

LOCK TABLES `login_attempting` WRITE;
/*!40000 ALTER TABLE `login_attempting` DISABLE KEYS */;
INSERT INTO `login_attempting` VALUES (1,1000,'1531597071','5f8709eba3d49fb069bc',''),(2,1000,'1531665485','c3afbadcaad7a17ff8ce',''),(3,1000,'1531768954','2ba1d702ff2c01187436',''),(4,1,'1534969079','dae1dcdd32b92e210a10','');
/*!40000 ALTER TABLE `login_attempting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_col_css`
--

DROP TABLE IF EXISTS `master_col_css`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_col_css` (
  `css_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `col_id` tinytext NOT NULL,
  `col_table_base` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_table` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_num` tinyint(4) NOT NULL,
  `col_primary` tinyint(1) NOT NULL,
  `col_options` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_clone_target` tinytext NOT NULL,
  `col_status` tinytext NOT NULL,
  `col_gridspace_right` tinytext NOT NULL,
  `col_gridspace_left` tinytext NOT NULL,
  `col_grid_width` tinytext NOT NULL,
  `col_grid_clone` tinytext NOT NULL,
  `col_flex_box` tinytext NOT NULL,
  `col_style` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_temp` tinytext NOT NULL,
  `col_grp_bor_style` text NOT NULL,
  `col_comment_style` text NOT NULL,
  `col_date_style` text NOT NULL,
  `col_comment_date_style` text NOT NULL,
  `col_comment_view_style` text NOT NULL,
  `col_clone_target_base` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_hr` tinytext NOT NULL,
  `col_update` tinytext NOT NULL,
  `col_width` tinytext NOT NULL,
  `col_tcol_num` decimal(5,1) NOT NULL,
  `token` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `col_time` tinytext NOT NULL,
  PRIMARY KEY (`css_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_col_css`
--

LOCK TABLES `master_col_css` WRITE;
/*!40000 ALTER TABLE `master_col_css` DISABLE KEYS */;
/*!40000 ALTER TABLE `master_col_css` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_gall`
--

DROP TABLE IF EXISTS `master_gall`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_gall` (
  `pic_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `master_gall_ref` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `master_gall_status` tinytext NOT NULL,
  `master_table_ref` tinytext NOT NULL,
  `gall_ref` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `gall_table` tinytext NOT NULL,
  `pic_order` smallint(3) unsigned NOT NULL,
  `picname` tinytext NOT NULL,
  `imagetitle` tinytext NOT NULL,
  `description` text NOT NULL,
  `subtitle` tinytext NOT NULL,
  `width` smallint(4) unsigned NOT NULL,
  `height` smallint(4) unsigned NOT NULL,
  `galleryname` tinytext NOT NULL,
  `temp_pic_order` smallint(3) unsigned NOT NULL,
  `reset_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `gall_update` tinytext NOT NULL,
  `gall_time` tinytext NOT NULL,
  `token` tinytext NOT NULL,
  PRIMARY KEY (`pic_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_gall`
--

LOCK TABLES `master_gall` WRITE;
/*!40000 ALTER TABLE `master_gall` DISABLE KEYS */;
INSERT INTO `master_gall` VALUES (1,'0','0','0','mermaids_1','mermaids',1,'seashell2_2.jpg','','','',240,180,'0',0,0,'10Jul2018-13-36-17','1531244177','1749509622'),(2,'0','0','0','mermaids_1','mermaids',2,'seashell.jpg','','','',135,180,'0',0,0,'10Jul2018-13-36-38','1531244198','1391195237'),(3,'0','0','0','mermaids_1','mermaids',3,'seashell1.jpg','','','',149,180,'0',0,0,'10Jul2018-13-36-54','1531244214','537696960'),(4,'0','0','0','mermaids_1','mermaids',4,'seashell4.jpg','','','',135,180,'0',0,0,'10Jul2018-13-37-33','1531244253','826999261'),(5,'0','0','0','mermaids_1','mermaids',5,'seashell5.jpg','','','',201,180,'0',0,0,'10Jul2018-13-37-51','1531244271','1203596921'),(6,'0','0','0','mermaids_1','mermaids',6,'seashell6.jpg','','','',135,180,'0',0,0,'10Jul2018-13-38-10','1531244290','1471216087'),(7,'0','0','0','mermaids_1','mermaids',7,'seashell7.jpg','','','',240,180,'0',0,0,'10Jul2018-13-38-27','1531244307','2097082121'),(8,'0','0','0','mermaids_1','mermaids',8,'seashell8.jpg','','','',240,180,'0',0,0,'10Jul2018-13-38-52','1531244332','848046220'),(9,'0','0','0','mermaids_1','mermaids',9,'seashell10.jpg','','','',240,180,'0',0,0,'10Jul2018-13-39-12','1531244352','16237207'),(10,'0','0','0','mermaids_1','mermaids',10,'seashell24.jpg','','','',240,180,'0',0,0,'10Jul2018-13-39-56','1531244396','829364808'),(11,'0','0','0','mermaids_1','mermaids',11,'seashell25.jpg','','','',240,180,'0',0,0,'10Jul2018-13-40-26','1531244426','1564339097'),(12,'0','0','0','mermaids_1','mermaids',12,'seashell32.jpg','','','',201,180,'0',0,0,'10Jul2018-13-41-20','1531244480','800922117'),(13,'0','0','0','mermaids_1','mermaids',13,'seashell37.jpg','','','',240,180,'0',0,0,'10Jul2018-13-48-43','1531244923','1147794916'),(14,'0','0','0','mermaids_1','mermaids',14,'seashell24_2.jpg','','','',240,180,'0',0,0,'10Jul2018-13-49-21','1531244961','1644996800'),(15,'0','0','0','mermaids_1','mermaids',15,'seashell40.jpg','','','',135,180,'0',0,0,'10Jul2018-13-51-46','1531245106','993286796'),(16,'0','0','0','mermaids_1','mermaids',16,'seashell38.jpg','','','',240,180,'0',0,0,'10Jul2018-13-52-45','1531245165','23484309'),(20,'0','0','0','angels_1','angels',2,'seashell14.jpg','','','',135,180,'0',0,0,'10Jul2018-19-20-46','1531264846','1418497106'),(19,'0','0','0','angels_1','angels',1,'seashell16_2.jpg','','','',161,180,'0',0,0,'10Jul2018-19-20-18','1531264818','243389299'),(18,'0','0','0','hearts_1','hearts',2,'seashell15.jpg','','','',135,180,'0',0,0,'10Jul2018-17-50-24','1531259547','13743214'),(17,'0','0','0','hearts_1','hearts',1,'seashell13_2.jpg','','','',240,180,'0',0,0,'10Jul2018-17-43-09','1531259547','1999201269'),(21,'0','0','0','deep_blue_sea_1','deep_blue_sea',1,'seashell41_2.jpg','','','',180,180,'0',0,0,'11Jul2018-15-37-46','1531338562','1720075421'),(22,'0','0','0','deep_blue_sea_1','deep_blue_sea',2,'seashell12.jpg','','','',135,180,'0',0,0,'11Jul2018-15-38-23','1531338562','1671556411'),(23,'0','0','0','deep_blue_sea_1','deep_blue_sea',3,'seashell17.jpg','','','',135,180,'0',0,0,'11Jul2018-15-38-55','1531338562','924181775'),(24,'0','0','0','deep_blue_sea_1','deep_blue_sea',4,'seashell19.jpg','','','',135,180,'0',0,0,'11Jul2018-15-39-23','1531338562','1385039393'),(25,'0','0','0','deep_blue_sea_1','deep_blue_sea',6,'seashell21.jpg','','','',135,180,'0',0,0,'11Jul2018-15-41-22','1531338562','1509759109'),(26,'0','0','0','deep_blue_sea_1','deep_blue_sea',7,'seashell22.jpg','','','',135,180,'0',0,0,'11Jul2018-15-41-39','1531338562','1141562581'),(27,'0','0','0','deep_blue_sea_1','deep_blue_sea',8,'seashell29.jpg','','','',240,180,'0',0,0,'11Jul2018-15-42-13','1531338562','701447756'),(28,'0','0','0','deep_blue_sea_1','deep_blue_sea',9,'seashell42.jpg','','','',240,180,'0',0,0,'11Jul2018-15-43-27','1531338562','1849670666'),(29,'0','0','0','deep_blue_sea_1','deep_blue_sea',5,'seashell20.jpg','','','',226,180,'0',0,0,'11Jul2018-15-46-14','1531338562','64069791');
/*!40000 ALTER TABLE `master_gall` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_page`
--

DROP TABLE IF EXISTS `master_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_page` (
  `page_id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `page_ref` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `page_title` tinytext NOT NULL,
  `page_filename` tinytext NOT NULL,
  `page_width` smallint(6) NOT NULL,
  `page_pic_quality` tinyint(4) NOT NULL,
  `page_style` text NOT NULL,
  `page_custom_css` tinytext NOT NULL,
  `page_head` text NOT NULL,
  `keywords` tinytext NOT NULL,
  `metadescription` tinytext NOT NULL,
  `page_data1` text NOT NULL,
  `page_data2` text NOT NULL,
  `page_update` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `page_data3` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `page_data4` text NOT NULL,
  `page_data5` text NOT NULL,
  `page_data6` text NOT NULL,
  `page_data7` text NOT NULL,
  `page_data8` text NOT NULL,
  `page_data9` text NOT NULL,
  `page_data10` text NOT NULL,
  `use_tags` tinyint(4) NOT NULL,
  `page_options` text NOT NULL,
  `page_break_points` tinytext NOT NULL,
  `page_cache` tinytext NOT NULL,
  `page_dark_editor_value` text NOT NULL,
  `page_light_editor_value` text NOT NULL,
  `page_dark_editor_order` text NOT NULL,
  `page_light_editor_order` text NOT NULL,
  `page_comment_style` text NOT NULL,
  `page_date_style` text NOT NULL,
  `page_comment_date_style` text NOT NULL,
  `page_comment_view_style` text NOT NULL,
  `page_style_day` text NOT NULL,
  `page_style_month` text NOT NULL,
  `page_grp_bor_style` text NOT NULL,
  `page_hr` tinytext NOT NULL,
  `page_h1` text NOT NULL,
  `page_h2` text NOT NULL,
  `page_h3` text NOT NULL,
  `page_h4` text NOT NULL,
  `page_h5` text NOT NULL,
  `page_h6` text NOT NULL,
  `page_myclass1` text NOT NULL,
  `page_myclass2` text NOT NULL,
  `page_myclass3` tinytext NOT NULL,
  `page_myclass4` text NOT NULL,
  `page_myclass5` text NOT NULL,
  `page_myclass6` text NOT NULL,
  `page_myclass7` text NOT NULL,
  `page_myclass8` text NOT NULL,
  `page_myclass9` text NOT NULL,
  `page_myclass10` text NOT NULL,
  `page_myclass11` text NOT NULL,
  `page_myclass12` text NOT NULL,
  `page_tiny_data1` tinytext NOT NULL,
  `page_tiny_data2` tinytext NOT NULL,
  `page_tiny_data3` tinytext NOT NULL,
  `page_tiny_data4` tinytext NOT NULL,
  `page_tiny_data5` tinytext NOT NULL,
  `page_tiny_data6` tinytext NOT NULL,
  `page_tiny_data7` tinytext NOT NULL,
  `page_tiny_data8` tinytext NOT NULL,
  `page_tiny_data9` tinytext NOT NULL,
  `page_tiny_data10` tinytext NOT NULL,
  `page_clipboard` text NOT NULL,
  `page_link` text NOT NULL,
  `page_link_hover` text NOT NULL,
  `page_time` tinytext NOT NULL,
  `token` tinytext NOT NULL,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_page`
--

LOCK TABLES `master_page` WRITE;
/*!40000 ALTER TABLE `master_page` DISABLE KEYS */;
INSERT INTO `master_page` VALUES (1,'indexpage','HOME','index',1005,0,',0,0,0,0,0,0,0,0,Chancur;,0,0,0,444,0,0,0,0,0,0,ffffff@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat,0,0,0,0@@0@@0@@0@@0@@inset,0,4@@D2E3FF@@0@@top','','',' ',' ','','','04Aug2018-13-36-13','','','','','','','','',0,'dark,7B081A,0,ffffff,000000,,,Arial=> Helvetica=> sans-serif;,,,,,,,,,4,,1600,300','950','100,200,300,400,500,700,900,1100,1300,1700,2100','64C91D,00ffff,00ff00,FFFF00,ede5e5,afeeee,ffe4b5,98fb98,0075a0,ff6600,2B1DC9,dccbcb,ff00ff,800000,816227,266a2e,a9a9a9,bdb76b,8b008b,556b2f,ff8c00,9932cc,8b0000,e9967a,8fbc8f,483d8b,2f4f4f,00ced1,9400d3,ff1493,00bfff,696969,696969,1e90ff,b22222,fffaf0,228b22,ff00ff,dcdcdc,ffdead,fdf5e6,808000,6b8e23,ff4500,c6a5a5,da70d6,eee8aa,d87093,ffefd5,ffdab9,cd853f,dda0dd,b0e0e6,bc8f8f,4169e1,8b4513,fa8072,f4a460,2e8b57,C91B45,000000,ffffff,e5d805,c82c1d','','pos,aqua,yellow,lightestmaroon,paleturquoise,moccasin,palegreen,ekblue,orange,navy,lightermaroon,magenta,maroon,brown,green,darkgrey,darkkhaki,darkmagenta,darkolivegreen,darkorange,darkorchid,darkred,darksalmon,darkseagreen,darkslateblue,darkslategray,darkturquoise,darkviolet,deeppink,deepskyblue,dimgray,dimgrey,dodgerblue,firebrick,floralwhite,forestgreen,fuchsia,gainsboro,navajowhite,oldlace,olive,olivedrab,orangered,lightmaroon,orchid,palegoldenrod,palevioletred,papayawhip,peachpuff,peru,plum,powderblue,rosybrown,royalblue,saddlebrown,salmon,sandybrown,seagreen,cherry,black,white,info,redAlert,brightgreen','',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','','','','','','','','','','','','','1533404173','572410510'),(12,'hearts','hearts','hearts',1005,0,',0,0,0,0,0,0,0,0,Chancur;,0,0,0,444,0,0,0,0,0,0,ffffff@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat,0,0,0,0@@0@@0@@0@@0@@inset,0,8@@000@@0@@top','','',' ',' ','','','14Jul2018-13-53-25','','','','','','','','',0,'dark,7B081A,0,ffffff,000000,,,Arial=> Helvetica=> sans-serif;,,,,,,,,,4','950','100,200,300,400,500,700,900,1100,1300,1700,2100','64C91D,00ffff,00ff00,FFFF00,ede5e5,afeeee,ffe4b5,98fb98,0075a0,ff6600,2B1DC9,dccbcb,ff00ff,800000,816227,266a2e,a9a9a9,bdb76b,8b008b,556b2f,ff8c00,9932cc,8b0000,e9967a,8fbc8f,483d8b,2f4f4f,00ced1,9400d3,ff1493,00bfff,696969,696969,1e90ff,b22222,fffaf0,228b22,ff00ff,dcdcdc,ffdead,fdf5e6,808000,6b8e23,ff4500,c6a5a5,da70d6,eee8aa,d87093,ffefd5,ffdab9,cd853f,dda0dd,b0e0e6,bc8f8f,4169e1,8b4513,fa8072,f4a460,2e8b57,C91B45,000000,ffffff,e5d805,c82c1d','','','',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','','','','','','','','','','','','','1531590805','657316986'),(11,'mermaids','mermaids','mermaids',1005,0,',0,0,0,0,0,0,0,0,Chancery Cursive;,0,0,0,444,0,0,0,0,0,0,ffffff@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat,0,0,0,0@@0@@0@@0@@0@@inset,0,8@@000@@0@@top','','',' ',' ','','','10Jul2018-15-06-12','','','','','','','','',0,'dark,7B081A,0,ffffff,000000,,,,,,,,,,,,4','950','100,200,300,400,500,700,900,1100,1300,1700,2100','64C91D,00ffff,00ff00,FFFF00,ede5e5,afeeee,ffe4b5,98fb98,0075a0,ff6600,2B1DC9,dccbcb,ff00ff,800000,816227,266a2e,a9a9a9,bdb76b,8b008b,556b2f,ff8c00,9932cc,8b0000,e9967a,8fbc8f,483d8b,2f4f4f,00ced1,9400d3,ff1493,00bfff,696969,696969,1e90ff,b22222,fffaf0,228b22,ff00ff,dcdcdc,ffdead,fdf5e6,808000,6b8e23,ff4500,c6a5a5,da70d6,eee8aa,d87093,ffefd5,ffdab9,cd853f,dda0dd,b0e0e6,bc8f8f,4169e1,8b4513,fa8072,f4a460,2e8b57,C91B45,000000,ffffff,e5d805,c82c1d','','','',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','','','','','','','','','','','','','1531249572','368214478'),(13,'angels','angels','angels',1005,0,',0,0,0,0,0,0,0,0,Chancur;,0,0,0,444,0,0,0,0,0,0,ffffff@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat,0,0,0,0@@0@@0@@0@@0@@inset,0,8@@000@@0@@top','','',' ',' ','','','10Jul2018-19-08-37','','','','','','','','',0,'dark,7B081A,0,ffffff,000000,,,Arial=> Helvetica=> sans-serif;,,,,,,,,,4','950','100,200,300,400,500,700,900,1100,1300,1700,2100','64C91D,00ffff,00ff00,FFFF00,ede5e5,afeeee,ffe4b5,98fb98,0075a0,ff6600,2B1DC9,dccbcb,ff00ff,800000,816227,266a2e,a9a9a9,bdb76b,8b008b,556b2f,ff8c00,9932cc,8b0000,e9967a,8fbc8f,483d8b,2f4f4f,00ced1,9400d3,ff1493,00bfff,696969,696969,1e90ff,b22222,fffaf0,228b22,ff00ff,dcdcdc,ffdead,fdf5e6,808000,6b8e23,ff4500,c6a5a5,da70d6,eee8aa,d87093,ffefd5,ffdab9,cd853f,dda0dd,b0e0e6,bc8f8f,4169e1,8b4513,fa8072,f4a460,2e8b57,C91B45,000000,ffffff,e5d805,c82c1d','','','',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','','','','','','','','','','','','','1531264117','382209088'),(14,'deep_blue_sea','deep blue sea','deep_blue_sea',1005,0,',0,0,0,0,0,0,0,0,Chancur;,0,0,0,444,0,0,0,0,0,0,ffffff@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat,0,0,0,0@@0@@0@@0@@0@@inset,0,8@@000@@0@@top','','',' ',' ','','','11Jul2018-15-23-51','','','','','','','','',0,'dark,7B081A,0,ffffff,000000,,,Arial=> Helvetica=> sans-serif;,,,,,,,,,4','950','100,200,300,400,500,700,900,1100,1300,1700,2100','64C91D,00ffff,00ff00,FFFF00,ede5e5,afeeee,ffe4b5,98fb98,0075a0,ff6600,2B1DC9,dccbcb,ff00ff,800000,816227,266a2e,a9a9a9,bdb76b,8b008b,556b2f,ff8c00,9932cc,8b0000,e9967a,8fbc8f,483d8b,2f4f4f,00ced1,9400d3,ff1493,00bfff,696969,696969,1e90ff,b22222,fffaf0,228b22,ff00ff,dcdcdc,ffdead,fdf5e6,808000,6b8e23,ff4500,c6a5a5,da70d6,eee8aa,d87093,ffefd5,ffdab9,cd853f,dda0dd,b0e0e6,bc8f8f,4169e1,8b4513,fa8072,f4a460,2e8b57,C91B45,000000,ffffff,e5d805,c82c1d','','','',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','','','','','','','','','','','','','1531337031','157431504'),(15,'contact','Contact','contact',1005,0,',0,0,0,0,0,0,0,0,Chancur;,0,0,0,444,0,0,0,0,0,0,ffffff@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat,0,0,0,0@@0@@0@@0@@0@@inset,0,4@@D2E3FF@@0@@top','','',' ',' ','','','12Jul2018-14-26-22','','','','','','','','',0,'dark,7B081A,0,ffffff,000000,,,Arial=> Helvetica=> sans-serif;,,,,,,,,,4','950','100,200,300,400,500,700,900,1100,1300,1700,2100','64C91D,00ffff,00ff00,FFFF00,ede5e5,afeeee,ffe4b5,98fb98,0075a0,ff6600,2B1DC9,dccbcb,ff00ff,800000,816227,266a2e,a9a9a9,bdb76b,8b008b,556b2f,ff8c00,9932cc,8b0000,e9967a,8fbc8f,483d8b,2f4f4f,00ced1,9400d3,ff1493,00bfff,696969,696969,1e90ff,b22222,fffaf0,228b22,ff00ff,dcdcdc,ffdead,fdf5e6,808000,6b8e23,ff4500,c6a5a5,da70d6,eee8aa,d87093,ffefd5,ffdab9,cd853f,dda0dd,b0e0e6,bc8f8f,4169e1,8b4513,fa8072,f4a460,2e8b57,C91B45,000000,ffffff,e5d805,c82c1d','','','',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','','','','','','','','','','','','','1531419982','1835368719');
/*!40000 ALTER TABLE `master_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_post`
--

DROP TABLE IF EXISTS `master_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_post` (
  `blog_id` mediumint(4) unsigned NOT NULL AUTO_INCREMENT,
  `blog_col` mediumint(11) unsigned NOT NULL,
  `blog_order` smallint(5) unsigned NOT NULL,
  `blog_type` tinytext NOT NULL,
  `blog_table` tinytext NOT NULL,
  `blog_gridspace_right` tinytext NOT NULL,
  `blog_gridspace_left` tinytext NOT NULL,
  `blog_grid_width` tinytext NOT NULL,
  `blog_data1` tinytext NOT NULL,
  `blog_data2` text NOT NULL,
  `blog_data3` text NOT NULL,
  `blog_data4` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data5` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data6` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data7` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data8` text NOT NULL,
  `blog_data9` text NOT NULL,
  `blog_data10` text NOT NULL,
  `blog_tiny_data1` tinytext NOT NULL,
  `blog_tiny_data2` tinytext NOT NULL,
  `blog_tiny_data3` tinytext NOT NULL,
  `blog_tiny_data4` tinytext NOT NULL,
  `blog_tiny_data5` tinytext NOT NULL,
  `blog_tiny_data6` tinytext NOT NULL,
  `blog_tiny_data7` tinytext NOT NULL,
  `blog_tiny_data8` tinytext NOT NULL,
  `blog_tiny_data9` tinytext NOT NULL,
  `blog_tiny_data10` tinytext NOT NULL,
  `blog_grid_clone` tinytext NOT NULL,
  `blog_style` text NOT NULL,
  `blog_table_base` tinytext NOT NULL,
  `blog_text` text NOT NULL,
  `blog_border_start` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_border_stop` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_global_style` tinytext NOT NULL,
  `blog_date` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_width` tinytext NOT NULL,
  `blog_alt_rwd` tinytext NOT NULL,
  `blog_flex_box` tinytext NOT NULL,
  `blog_status` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_unstatus` tinytext NOT NULL,
  `blog_clone_target` tinytext NOT NULL,
  `blog_target_table_base` tinytext NOT NULL,
  `blog_clone_table` tinytext NOT NULL,
  `blog_float` tinytext NOT NULL,
  `blog_unclone` tinytext NOT NULL,
  `blog_tag` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_options` text NOT NULL,
  `blog_update` tinytext NOT NULL,
  `blog_pub` tinyint(4) NOT NULL,
  `blog_temp` mediumint(5) unsigned NOT NULL,
  `blog_time` tinytext NOT NULL,
  `token` tinytext,
  PRIMARY KEY (`blog_id`)
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_post`
--

LOCK TABLES `master_post` WRITE;
/*!40000 ALTER TABLE `master_post` DISABLE KEYS */;
INSERT INTO `master_post` VALUES (34,16,50,'text','indexpage_col_id16','','','','','','','','','','','','','','','','','','','','','','','','',',50,70,,,,,,,,24@@em@@0.8,,center,a8a8a8,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','indexpage','Copyright &copy; 2018 All Rights Reserved','','','','1531415453','','','','move','','','','','center_row','','','','09Aug2018-12-55-30',1,50,'1533833730','532542471'),(2,1,10,'nested_column','indexpage_col_id1','','','','2','','','','','','','','','','','','','','','','','','','','','','indexpage','Nested Column','','','','1531084086','','','','move','','','','','center_row','','','','09Aug2018-13-03-30',1,10,'1533834210','1794954361'),(19,8,10,'image','indexpage_col_id8','','','','seashell16.jpg',',,,,,,,84,Enter Angels Gallery,nohover,mermaids.php,,5','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',15,12,,,,,,,,20.8@@rem@@2.7,,,1515AC,,,,,,,ffffff@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat@@@@0@@40,,,0.5@@0.5@@0.5@@ffffff,,,,,a:2:{i:0;a:2:{i:1;s:15:\"font-size:16px;\";i:2;s:3:\"600\";}i:1;a:2:{i:1;s:15:\"font-size:4rem;\";i:2;s:3:\"370\";}}','','','','','','','','','','','','','','','','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat,,,,,,,,a:1:{i:0;a:2:{i:1;s:16:\"min-width:50rem;\";i:2;s:3:\"370\";}},,,,,,,,,,,,,,','indexpage','image','','','','1531084151','37.55916','compress_to_percentage,50','','move','','','','','left_float','','','','06Aug2018-17-32-21',1,30,'1533591141','794561648'),(18,1,30,'nested_column','indexpage_col_id1','','','','8','','','','','','','','','','','','','','','','','','','','','','indexpage','','','','','1531242244','','','','move','','','','','center_row','','','','09Aug2018-13-03-30',1,30,'1533834210','2065844525'),(12,1,20,'nested_column','indexpage_col_id1','','','','6','','','','','','','','','','','','','','','','','','','','','','indexpage','','','','','1531239289','','','','move','','','','','center_row','','','','09Aug2018-13-03-30',1,20,'1533834210','1683282692'),(13,6,10,'image','indexpage_col_id6','','','','seashell13.jpg',',,,,,,,84,Enter Hearts Gallery,nohover,mermaids.php,,5','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',15,12,,,,,,,,20.8@@rem@@2.7,,,1515AC,,,,,,,ffffff@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat@@@@0@@40,,,0.5@@0.5@@0.5@@ffffff,,,,,a:2:{i:0;a:2:{i:1;s:15:\"font-size:16px;\";i:2;s:3:\"600\";}i:1;a:2:{i:1;s:15:\"font-size:4rem;\";i:2;s:3:\"370\";}}','','','','','','','','','','','','','','','','100@@950',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat,,,,,,,,a:1:{i:0;a:2:{i:1;s:16:\"min-width:50rem;\";i:2;s:3:\"370\";}},,,,,,,,,,,,,,','indexpage','image','','','','1531084151','37.55916','compress_to_percentage,50','','move','','','','','left_float','','','','06Aug2018-17-32-21',1,30,'1533591141','1382826220'),(22,9,10,'image','indexpage_col_id9','','','','seashell41.jpg',',,,,,,,84,Enter Deep Blue Sea Gallery,nohover,mermaids.php,,5','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',15,12,,,,,,,,20.8@@rem@@2.7,,,1515AC,,,,,,,ffffff@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat@@@@0@@40,,,0.5@@0.5@@0.5@@ffffff,,,,,a:2:{i:0;a:2:{i:1;s:15:\"font-size:16px;\";i:2;s:3:\"600\";}i:1;a:2:{i:1;s:15:\"font-size:4rem;\";i:2;s:3:\"370\";}}','','','','','','','','','','','','','','','','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat,,,,,,,,a:1:{i:0;a:2:{i:1;s:16:\"min-width:50rem;\";i:2;s:3:\"370\";}},,,,,,,,,,,,,,','indexpage','image','','','','1531084151','37.55916','compress_to_percentage,50','','move','','','','','left_float','','','','06Aug2018-17-32-21',1,30,'1533591141','86467621'),(6,2,10,'image','indexpage_col_id2','','','','seashell2.jpg',',,,,,,,84,Enter Mermaid Gallery,nohover,mermaids.php,,5','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',15,12,,,,,,,,20.8@@rem@@2.7,,,1515AC,,,,,,,ffffff@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat@@@@0@@40,,,0.5@@0.5@@0.5@@ffffff,,,,,a:2:{i:0;a:2:{i:1;s:15:\"font-size:16px;\";i:2;s:3:\"600\";}i:1;a:2:{i:1;s:15:\"font-size:4rem;\";i:2;s:3:\"370\";}}','','','','','','','','','','','','','','','','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat,,,,,,,,a:1:{i:0;a:2:{i:1;s:16:\"min-width:50rem;\";i:2;s:3:\"370\";}},,,,,,,,,,,,,,','indexpage','image','','','','1531084151','37.55916','compress_to_percentage,50','','move','','','','','left_float','','','','06Aug2018-17-29-10',1,30,'1533590950','1733617447'),(23,9,20,'text','indexpage_col_id9','','','','','','','','','','','','','','','','','','','','','','','','',',0@@%@@6,0@@%@@6,0@@%@@8.3,0@@%@@5.0,80,,,,chancur;,48@@rem@@3.1@@80@@1600@@1503@@1426@@1300@@1213@@1103@@1000@@900@@800@@700,100,left,A7A7A7,,,,,,,ffe7ab@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat,10@@10@@10@@10@@@@@@@@@@@@@@@@@@1,,,,,,,a:2:{i:0;a:2:{i:1;s:52:\"margin-top:-30px;  padding-top:44px;breakclear:both;\";i:2;s:3:\"744\";}i:1;a:2:{i:1;s:16:\"min-width:55rem;\";i:2;s:3:\"370\";}},,,,,,,,8.3,5.0','indexpage','<span style=\"font-size: 1.5em;\">The Deep Blue Sea</span><br>Ships, sea creatures and other things nautical that remind of the deep blue Sea.','','','','1531084151','47.97160','compress_to_percentage,45','','move','','','','','right_float','','',',,,,,,,,,,,,,,relative@@@@@@left@@-19.0@@none@@none@@-88.5,,,,,,,,@@-@@18','18Oct2018-13-11-26',1,20,'1539882686','1941099388'),(48,16,30,'nested_column','indexpage_col_id16','','','','24','','','','','','','','','','','','','','','','','','','','','','indexpage','Nested Column','','','','1533479015','','','','','','','','','center_row','','','','09Aug2018-12-55-30',1,30,'1533833730','1143518501'),(7,2,20,'text','indexpage_col_id2','','','','','','','','','','','','','','','','','','','','','','','','',',0@@%@@6,0@@%@@6,0@@%@@8.3,0@@%@@5.0,35,,,,chancur;,48@@rem@@3.1@@80@@1600@@1503@@1426@@1300@@1213@@1103@@1000@@900@@800@@700,100,left,A7A7A7,,,,,,,fbdcb8@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat,10@@10@@10@@10@@@@@@@@@@@@@@@@@@1,,,,,,,a:2:{i:0;a:2:{i:1;s:52:\"margin-top:-30px;  padding-top:44px;breakclear:both;\";i:2;s:3:\"744\";}i:1;a:2:{i:1;s:16:\"min-width:55rem;\";i:2;s:3:\"370\";}},,,,,,,,8.3,5.0','indexpage','<span style=\"font-size: 1.5em;\">Mermaids</span><br>Both used to attract the sea sailors and navigators with their alluring and fascinating nature.','','','','1531084151','47.97160','compress_to_percentage,45','','move','','','','','right_float','','',',,,,,,,,,,,,,,relative@@@@@@left@@-19.0@@none@@none@@-80,,,,,,,,@@-@@18','18Oct2018-13-02-54',1,20,'1539882174','162138014'),(14,6,20,'text','indexpage_col_id6','','','','','','','','','','','','','','','','','','','','','','','','100@@950',',0@@%@@6,0@@%@@6,0@@%@@8.3,0@@%@@5.0,45,,,,chancur;,48@@rem@@3.1@@80@@1600@@1503@@1426@@1300@@1213@@1103@@1000@@900@@800@@700,100,left,A7A7A7,,,,,,,f3e4e4@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat,10@@10@@10@@10@@@@@@@@@@@@@@@@@@1,,,,,,,a:2:{i:0;a:2:{i:1;s:52:\"margin-top:-30px;  padding-top:44px;breakclear:both;\";i:2;s:3:\"744\";}i:1;a:2:{i:1;s:16:\"min-width:55rem;\";i:2;s:3:\"370\";}},,,,,,,,8.3,5.0','indexpage','<span style=\"font-size: 1.5em;\">Hearts</span> <br>Hearts are to give, to have. to nourish. to give to our most beloved ones','','','','1531084151','47.97160','compress_to_percentage,45','','move','','','','','right_float','','',',,,,,,,,,,,,,,relative@@@@@@left@@-19.0@@none@@none@@-88.5,,,,,,,,@@-@@18','18Oct2018-13-09-35',1,20,'1539882575','674733435'),(20,8,20,'text','indexpage_col_id8','','','','','','','','','','','','','','','','','','','','','','','','',',0@@%@@6,0@@%@@6,0@@%@@8.3,0@@%@@5.0,60,,,,chancur;,48@@rem@@3.1@@80@@1600@@1503@@1426@@1300@@1213@@1103@@1000@@900@@800@@700,100,left,A7A7A7,,,,,,,c7eae4@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat,10@@10@@10@@10@@@@@@@@@@@@@@@@@@1,,,,,,,a:2:{i:0;a:2:{i:1;s:52:\"margin-top:-30px;  padding-top:44px;breakclear:both;\";i:2;s:3:\"744\";}i:1;a:2:{i:1;s:16:\"min-width:55rem;\";i:2;s:3:\"370\";}},,,,,,,,8.3,5.0','indexpage','<span style=\"font-size: 1.5em;\">Angels</span><br>If something good and seemingly inexplicable happens, itâ€™s often assumed to be the result of divine or angelic intervention.\"','','','','1531084151','47.97160','compress_to_percentage,45','','move','','','','','right_float','','',',,,,,,,,,,,,,,relative@@@@@@left@@-19.0@@none@@none@@-88.5,,,,,,,,@@-@@18','18Oct2018-13-11-26',1,20,'1539882686','526368817'),(21,1,40,'nested_column','indexpage_col_id1','','','','9','','','','','','','','','','','','','','','','','','','','','','indexpage','','','','','1531243254','','','','move','','','','','center_row','','','','09Aug2018-13-03-30',1,40,'1533834210','672364488'),(24,10,10,'gallery','mermaids_col_id10','','','','mermaids_1','preview_under_expand,simulate,0,0,0,0,0,0,5,180,0,0,25,30,kenburns,5,5,0,0,0,0,20,8EE3EB,,14.0,97,,,,simulate,,,,,,8EE3EB,left',',0,0,0,0,0,0,0,0,0,1.1,0,left',',0,0,0,0,0,0,0,0,0,0,0,left','',',20,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat','','','','','','','','','','','','','','','','0,0,0,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','mermaids','gallery','','','','1531244157','','','','','','','','','center row','','','','26Jul2018-16-21-39',1,0,'1532636499','804421529'),(28,11,10,'gallery','hearts_col_id11','','','','hearts_1','preview_under_expand,simulate,0,0,0,0,0,0,5,180,0,0,25,30,fade,5,5,0,0,1.0,0,20,8EE3EB,,7.0,97,,,,simulate,,,,,,8EE3EB,left',',0,0,0,0,0,0,0,0,0,1.1,0,left',',0,0,0,0,0,0,0,0,0,0,0,left','',',20,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat','','','','','','','','','','','','','','','','0,0,0,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','hearts','gallery','','','','1531255817','','','','','','','','','center row','','','','26Jul2018-16-20-49',1,10,'1532636449','1918452460'),(29,12,10,'gallery','angels_col_id12','','','','angels_1','preview_under_expand,simulate,0,0,0,0,0,0,5,180,0,0,25,30,fade,5,5,0,0,0,0,20,8EE3EB,,14.0,97,,,,simulate,,,,,,8EE3EB,left',',0,0,0,0,0,0,0,0,0,1.1,0,left',',0,0,0,0,0,0,0,0,0,0,0,left','',',20,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat','','','','','','','','','','','','','','','','0,0,0,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','angels','gallery','','','','1531264663','','','','','','','','','center row','','','','26Jul2018-16-18-49',1,0,'1532636329','2005483304'),(31,24,20,'text','indexpage_col_id24','','','','','','','','','','','','','','','','','','','','','','','','',',20,20,@@%@@10,0@@%@@10,,,,,Chancur;,32@@em@@1@@1600@@300@@100,,left,A8A8A8,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','indexpage','The word  \"angel\" comes from the Greek word \"anglos,\" which means \"messenger\" in Hebrew. Angels can take many forms, usually appearing as human or a glowing light or aura. Often,  especially in cases of averted tragedy or disaster, angels will not be seen at all, but instead their presence recognized by their actions. If something good, unexpected, and seemingly inexplicable happens itâ€™s  often assumed to be the result of divine or angelic intervention. <br><br>The angels most people are familiar with today are the Christian angels, which originated from the Hebrew Testaments. The Catholic Church devoted considerable effort to describing and developing an extensive hierarchy of angels. There were many different types of angels, archangels, seraphim, and so on, with an official census ofnearly half a million.','','','','1531324969','56.25','','','move','','','','','center_row','','','','09Aug2018-13-10-22',1,10,'1533834622','1714424526'),(63,0,10,'nested_column','uncle_contact_id48','','','','21','','','','','16','','','','','','','','','','','','','','','','','contact','','','','','1533659652','','','','','unclone','','','','center_row','48','','','09Aug2018-13-57-23',1,0,'1533837443','1017146384'),(33,14,10,'gallery','deep_blue_sea_col_id14','','','','deep_blue_sea_1','preview_under_expand,simulate,0,0,0,0,0,0,5,180,0,0,25,30,horizontal,5,5,0,0,0,0,20,8EE3EB,,14.0,97,,,,simulate,,,,,,8EE3EB,left',',0,0,0,0,0,0,0,0,0,1.1,0,left',',0,0,0,0,0,0,0,0,0,0,0,left','',',20,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@0@@no-repeat','','','','','','','','','','','','','','','','0,0,0,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','deep_blue_sea','gallery','','','','1531337813','','','','','','','','','center row','','','','26Jul2018-16-20-15',1,0,'1532636415','1422481376'),(1,16,10,'image','indexpage_col_id16','','','','oceanbeachshells.gif','','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','','','','','','','','','','','','','','','',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','indexpage','image','','','','1531083743','','','','move','','','','','center_row','','','','09Aug2018-12-55-30',1,10,'1533833730','1340013547'),(36,24,10,'nested_column','indexpage_col_id24','','','','1','','','','','','','','','','','','','','','','','','','','','','indexpage','','','','','1531422773','','','','move','','','','','center_row','','','','09Aug2018-13-03-30',1,10,'1533834210','1281329928'),(40,21,20,'contact','contact_col_id21','','','','','sdrshn@hotmail.com','','','','7262DD,ffffff,580CA7,43','','','','','','','','','','','','','','','',',10,20,10,10,,,,,,,,,5852FF,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat,@@@@@@@@@@@@@@@@8@@@@@@@@0@@@@@@1600@@400,,,@@@@2@@0@@B5EEFF','contact','contact','','','','1531424994','','','','','','','','','center_row','','','','18Oct2018-14-01-40',1,20,'1539885700','1508452230'),(44,21,10,'text','contact_col_id21','','','','','','','','','','','','','','','','','','','','','','','','',',15,,15,15,,26,,,,19.2,400,left,182991,,,,,,,ffffff@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat@@@@0@@40,,,,,,1@@580CA7@@@@top bottom left right,,a:1:{i:0;a:3:{i:0;s:4:\" img\";i:1;s:12:\"width:160px;\";i:2;s:3:\"322\";}}','contact','For Prices, <span style=\"padding-left:5px;\"> Availability</span> <span style=\"font-size: 0.8em;\">&</span> Custom Orders <br>Please Contact<br><img src=\"gailmail.gif\" alt=\"gailmail\" width=\"250\" />','','','','1531579835','81.24999','','','','','','','','center_row','','','','09Aug2018-13-57-23',1,10,'1533837443','314678456'),(47,16,20,'navigation_menu','indexpage_col_id16','','','','1',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','',',,,,,,,10,10,,48@@none@@1.1@@@@@@@@@@1600@@400,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat,,,,,,1@@F9EF28@@@@bottom',',,,,,,,,,,,,,4636DB,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat',',,,,,,,,,,,,,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','','',',,,,none,,1,,,,,,force','','','','','','','','','','',',,,,,,,,,,,,center,,,,,,,,@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@no-repeat','indexpage','new_nav','','','','1531590163','','','','','','','','','center_row','','','','18Oct2018-13-17-23',1,20,'1539883043','645965320');
/*!40000 ALTER TABLE `master_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_post_css`
--

DROP TABLE IF EXISTS `master_post_css`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_post_css` (
  `css_id` mediumint(4) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` tinytext NOT NULL,
  `blog_col` mediumint(11) unsigned NOT NULL,
  `blog_order` smallint(5) unsigned NOT NULL,
  `blog_type` tinytext NOT NULL,
  `blog_table` tinytext NOT NULL,
  `blog_gridspace_right` tinytext NOT NULL,
  `blog_gridspace_left` tinytext NOT NULL,
  `blog_grid_width` tinytext NOT NULL,
  `blog_data1` tinytext NOT NULL,
  `blog_data2` text NOT NULL,
  `blog_data3` text NOT NULL,
  `blog_data4` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data5` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data6` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data7` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data8` text NOT NULL,
  `blog_data9` text NOT NULL,
  `blog_data10` text NOT NULL,
  `blog_tiny_data1` tinytext NOT NULL,
  `blog_tiny_data2` tinytext NOT NULL,
  `blog_tiny_data3` tinytext NOT NULL,
  `blog_tiny_data4` tinytext NOT NULL,
  `blog_tiny_data5` tinytext NOT NULL,
  `blog_tiny_data6` tinytext NOT NULL,
  `blog_tiny_data7` tinytext NOT NULL,
  `blog_tiny_data8` tinytext NOT NULL,
  `blog_tiny_data9` tinytext NOT NULL,
  `blog_tiny_data10` tinytext NOT NULL,
  `blog_grid_clone` tinytext NOT NULL,
  `blog_style` text NOT NULL,
  `blog_table_base` tinytext NOT NULL,
  `blog_text` text NOT NULL,
  `blog_border_start` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_border_stop` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_global_style` tinytext NOT NULL,
  `blog_date` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_width` tinytext NOT NULL,
  `blog_alt_rwd` tinytext NOT NULL,
  `blog_flex_box` tinytext NOT NULL,
  `blog_status` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_unstatus` tinytext NOT NULL,
  `blog_clone_target` tinytext NOT NULL,
  `blog_target_table_base` tinytext NOT NULL,
  `blog_clone_table` tinytext NOT NULL,
  `blog_float` tinytext NOT NULL,
  `blog_unclone` tinytext NOT NULL,
  `blog_tag` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_options` tinytext NOT NULL,
  `blog_update` tinytext NOT NULL,
  `blog_pub` tinyint(4) NOT NULL,
  `blog_temp` mediumint(5) unsigned NOT NULL,
  `blog_time` tinytext NOT NULL,
  `token` tinytext,
  PRIMARY KEY (`css_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_post_css`
--

LOCK TABLES `master_post_css` WRITE;
/*!40000 ALTER TABLE `master_post_css` DISABLE KEYS */;
/*!40000 ALTER TABLE `master_post_css` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_post_data`
--

DROP TABLE IF EXISTS `master_post_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_post_data` (
  `data_id` mediumint(4) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` tinytext NOT NULL,
  `blog_col` mediumint(11) unsigned NOT NULL,
  `blog_order` smallint(5) unsigned NOT NULL,
  `blog_type` tinytext NOT NULL,
  `blog_table` tinytext NOT NULL,
  `blog_gridspace_right` tinytext NOT NULL,
  `blog_gridspace_left` tinytext NOT NULL,
  `blog_grid_width` tinytext NOT NULL,
  `blog_data1` tinytext NOT NULL,
  `blog_data2` text NOT NULL,
  `blog_data3` text NOT NULL,
  `blog_data4` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data5` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data6` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data7` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_data8` text NOT NULL,
  `blog_data9` text NOT NULL,
  `blog_data10` text NOT NULL,
  `blog_tiny_data1` tinytext NOT NULL,
  `blog_tiny_data2` tinytext NOT NULL,
  `blog_tiny_data3` tinytext NOT NULL,
  `blog_tiny_data4` tinytext NOT NULL,
  `blog_tiny_data5` tinytext NOT NULL,
  `blog_tiny_data6` tinytext NOT NULL,
  `blog_tiny_data7` tinytext NOT NULL,
  `blog_tiny_data8` tinytext NOT NULL,
  `blog_tiny_data9` tinytext NOT NULL,
  `blog_tiny_data10` tinytext NOT NULL,
  `blog_grid_clone` tinytext NOT NULL,
  `blog_style` text NOT NULL,
  `blog_table_base` tinytext NOT NULL,
  `blog_text` text NOT NULL,
  `blog_border_start` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_border_stop` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_global_style` tinytext NOT NULL,
  `blog_date` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_width` tinytext NOT NULL,
  `blog_alt_rwd` tinytext NOT NULL,
  `blog_flex_box` tinytext NOT NULL,
  `blog_status` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_unstatus` tinytext NOT NULL,
  `blog_clone_target` tinytext NOT NULL,
  `blog_target_table_base` tinytext NOT NULL,
  `blog_clone_table` tinytext NOT NULL,
  `blog_float` tinytext NOT NULL,
  `blog_unclone` tinytext NOT NULL,
  `blog_tag` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `blog_options` tinytext NOT NULL,
  `blog_update` tinytext NOT NULL,
  `blog_pub` tinyint(4) NOT NULL,
  `blog_temp` mediumint(5) unsigned NOT NULL,
  `blog_time` tinytext NOT NULL,
  `token` tinytext,
  PRIMARY KEY (`data_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_post_data`
--

LOCK TABLES `master_post_data` WRITE;
/*!40000 ALTER TABLE `master_post_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `master_post_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `login_type` tinytext CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `salt` char(128) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES ('ownerAdmin',1,'shellabrate','sdrshn@hotmail.com','%7CyK%C3%7C%3Eti%90%AE%C6%D0%09%10O%1Ch3.%9B%10%17P%7D%A4%9F%7Cqb%82%88b%F5%00%FB%B8%E5P%7B%BE%22%F2%CE0i%A2xB%E9y%BD%B0U%0Cj%25%97%19%99%DB%3E6%F9%16%ED%D3%23%CEU%88i%BA%3E%E6uZ%95y%8BmH0%F4E%1E9C%D8%8C%EFg%E2%CD%81%D3%1A%07H%B8%B3%DFvd%E9%06%CA%F9%12%5B%E8%0E%FE%07%97%E6%0A%F8R%A7%BDsU%28%A0%E6%B3%1DO','59e37f79e4e32440058f64f8aedc26409c371168113968c9a0cbfe5be17952b4fc085e658c07c8db5ce2dd1e74b47ee8335377d1818ef1cf8867a4c66619ed87');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-18 16:34:51
