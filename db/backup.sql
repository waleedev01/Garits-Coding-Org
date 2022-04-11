-- MariaDB dump 10.19  Distrib 10.4.21-MariaDB, for osx10.10 (x86_64)
--
-- Host: localhost    Database: Garits
-- ------------------------------------------------------
-- Server version	10.4.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `AccountHolder`
--

DROP TABLE IF EXISTS `AccountHolder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `AccountHolder` (
  `customer_id` int(10) NOT NULL,
  `discount_type` enum('fixed','variable','flexible') DEFAULT NULL,
  `percentage` tinyint(4) DEFAULT NULL,
  `pay_late` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`customer_id`),
  CONSTRAINT `accountholder_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `Customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `AccountHolder`
--

LOCK TABLES `AccountHolder` WRITE;
/*!40000 ALTER TABLE `AccountHolder` DISABLE KEYS */;
INSERT INTO `AccountHolder` VALUES (1,'fixed',10,0),(7,'variable',30,1),(8,'fixed',20,1),(10,'fixed',15,0);
/*!40000 ALTER TABLE `AccountHolder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Customer`
--

DROP TABLE IF EXISTS `Customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Customer` (
  `customer_id` int(10) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(50) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `post_code` varchar(10) NOT NULL,
  `city` varchar(50) NOT NULL,
  `mobile_telephone` varchar(20) DEFAULT NULL,
  `home_telephone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `pay_late` tinyint(1) DEFAULT NULL,
  `DiscountID` int(11) DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  KEY `DiscountID` (`DiscountID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Customer`
--

LOCK TABLES `Customer` WRITE;
/*!40000 ALTER TABLE `Customer` DISABLE KEYS */;
INSERT INTO `Customer` VALUES (1,'premi spa','Jack','Varta','Sulphur Lane, Stenchville','PR10EQ','Bucks','004479834387855','004479834387855','john.smith@outlook.com',1,1),(2,'premi spa','Mario','Smith','2 Palace Road','PR30EQ','London','004479834387333','004479834387855','mario@outlook.com',1,1),(3,'premi spa','Joanna','Brown','3 Palace Road','PR20EQ','London','004479834387555','004479834387855','JOnna.brown@outlook.com',NULL,5),(4,'premi spa','Cristiano','Ronaldo','Palace Road','PR10EQ','London','004479834387888','004479834387855','CR7@outlook.com',NULL,2),(5,'premi spa','Elizabeth','Smith','5 Palace Road','PR80EQ','London','004479834387766','004479834387855','EL@outlook.com',NULL,0),(6,'premi spa','Pablo','Escobar','6 Palace Road','PR30EQ','London','004479834365455','004479834387855','Pablito@outlook.com',NULL,NULL),(7,'premi spa','Flixbus','Ltd','Northampton Square,','EC1V 0HB','Manchester','004479834432155','004479834387855','flixbus@flixbus.com',NULL,NULL),(8,'premi spa','Premi','LTD','10 Winter Road','PA20FQ','Brighton','004479834383855','004479834387855','premi@premi.com',NULL,NULL),(9,'premi spa','Diego','Maradona','2089 Palace Road','PR30EQ','London','004479834327855','004479834387855','DMbest@outlook.com',NULL,NULL),(10,'premi spa','Steev','will','22 Palace Road','PR10EQ','London','004479834387859','004479834387855','stivi@outlook.com',NULL,NULL),(12,'premi spa','William','Gates','World Domination House, Enormous Street','NW10 4AT','Richville','0666 666 666','0207 477 3333','',NULL,NULL),(20,'premi spa','John','Doherty','Unknown Street, Whichville','MT1 2UP','Nowhereshire','07070 070 707','0101 010 0101','',NULL,NULL);
/*!40000 ALTER TABLE `Customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Discount`
--

DROP TABLE IF EXISTS `Discount`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Discount` (
  `DiscountID` int(11) NOT NULL AUTO_INCREMENT,
  `discount_type` enum('variable','fixed','flexible') NOT NULL,
  `value` int(11) DEFAULT NULL,
  PRIMARY KEY (`DiscountID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Discount`
--

LOCK TABLES `Discount` WRITE;
/*!40000 ALTER TABLE `Discount` DISABLE KEYS */;
INSERT INTO `Discount` VALUES (1,'flexible',6),(2,'fixed',100),(3,'variable',50),(4,'variable',50),(5,'fixed',10);
/*!40000 ALTER TABLE `Discount` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Invoice`
--

DROP TABLE IF EXISTS `Invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Invoice` (
  `invoice_id` int(10) NOT NULL AUTO_INCREMENT,
  `date_created` varchar(10) NOT NULL,
  `date_paid` varchar(10) DEFAULT NULL,
  `is_paid` tinyint(1) NOT NULL,
  `amount` double NOT NULL,
  `job_id` int(10) DEFAULT NULL,
  `customer_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`invoice_id`),
  KEY `job_id` (`job_id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `Job` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `invoice_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `Customer` (`customer_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Invoice`
--

LOCK TABLES `Invoice` WRITE;
/*!40000 ALTER TABLE `Invoice` DISABLE KEYS */;
INSERT INTO `Invoice` VALUES (60,'2022/04/10',NULL,0,36,1,2),(61,'2022/04/10','2022-04-10',1,36,1,2),(62,'2022/04/10','2022-04-10',1,66,13,8),(63,'2022/04/10','2022-04-10',1,66,7,8),(64,'2022/04/10',NULL,0,54,6,1),(65,'2022/04/10',NULL,0,0,14,2),(66,'2022/04/10',NULL,0,0,29,9),(67,'2022/04/10','2022-04-10',1,39,29,9),(68,'2022/04/10',NULL,0,70.2,24,2),(69,'2022/04/10','2022-04-10',1,184.08,30,4),(70,'2022/04/10',NULL,0,66,9,10),(71,'2022/04/10',NULL,0,240,2,3),(72,'2022/04/10',NULL,0,972.54,3,4),(73,'2022/04/10',NULL,0,114,5,6),(74,'2022/04/10',NULL,0,54,8,9),(75,'2022/04/10',NULL,0,0,20,2),(76,'2022/04/10',NULL,0,66,11,8),(77,'2022/04/10',NULL,0,114,10,1),(78,'2022/04/11',NULL,0,2.3400000000000003,31,2),(79,'2022/04/11','2022-04-11',1,70.2,28,2),(80,'2022/04/11',NULL,0,312,27,8),(81,'2022/04/11','2022-04-11',1,312,26,8);
/*!40000 ALTER TABLE `Invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Job`
--

DROP TABLE IF EXISTS `Job`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Job` (
  `job_id` int(10) NOT NULL AUTO_INCREMENT,
  `job_type` enum('MoT','annual service','repair','stock_order') NOT NULL,
  `status` enum('new','pending','progress','completed') NOT NULL DEFAULT 'new',
  `estimate_amount` double DEFAULT NULL,
  `book_in_date` varchar(10) DEFAULT NULL,
  `time_spent` double DEFAULT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `registration_number` varchar(10) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`job_id`),
  KEY `username` (`username`),
  KEY `customer_id` (`customer_id`),
  KEY `registration_number` (`registration_number`),
  CONSTRAINT `job_ibfk_1` FOREIGN KEY (`username`) REFERENCES `Mechanic` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `job_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `Customer` (`customer_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `job_ibfk_3` FOREIGN KEY (`registration_number`) REFERENCES `Vehicle` (`registration_number`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Job`
--

LOCK TABLES `Job` WRITE;
/*!40000 ALTER TABLE `Job` DISABLE KEYS */;
INSERT INTO `Job` VALUES (1,'repair','completed',90,'20220212',2,2,'BD31SMF','fixitbob'),(2,'repair','completed',120.5,'20220313',10,3,'BD55SMR','mechanic2'),(3,'repair','completed',19.5,'20220314',50,4,'BD53SDR','BenDoit'),(4,'repair','new',190.5,'20220312',3,5,'BD52SMR','mechanic2'),(5,'annual service','completed',90.5,'20220310',2,6,'BD51SMR','fixitbob'),(6,'repair','completed',120.5,'20220309',3,1,'BD58SMR','fixitbob'),(7,'MoT','completed',90,'20220311',3,8,'BD59SMR','mechanic2'),(8,'repair','completed',420.5,'20220312',3,9,'BD50SMR','ponton2009'),(9,'MoT','completed',90,'20220125',3,10,'BD32SMR','mechanic2'),(10,'annual service','completed',80.6,'20220305',2,1,'BD51SMR','fixitbob'),(11,'MoT','completed',90,'20220411',1,8,'BD60SMR','BenDoit'),(12,'MoT','pending',90,'20220511',2,8,'BD61SMR','BenDoit'),(13,'MoT','completed',90,'20220611',2,8,'BD62SMR','Luke2'),(14,'stock_order','completed',NULL,NULL,NULL,2,NULL,NULL),(15,'stock_order','completed',NULL,NULL,NULL,2,NULL,NULL),(16,'stock_order','completed',NULL,NULL,NULL,2,NULL,NULL),(17,'stock_order','completed',NULL,NULL,NULL,2,NULL,NULL),(18,'stock_order','completed',NULL,NULL,NULL,2,NULL,NULL),(19,'stock_order','completed',NULL,NULL,NULL,2,NULL,NULL),(20,'stock_order','completed',NULL,NULL,NULL,2,NULL,NULL),(21,'stock_order','completed',NULL,NULL,NULL,2,NULL,NULL),(22,'stock_order','completed',NULL,NULL,NULL,2,NULL,NULL),(23,'stock_order','completed',NULL,NULL,NULL,2,NULL,NULL),(24,'stock_order','completed',NULL,NULL,NULL,2,NULL,NULL),(25,'stock_order','completed',NULL,NULL,NULL,8,NULL,NULL),(26,'stock_order','completed',NULL,NULL,NULL,8,NULL,NULL),(27,'stock_order','completed',NULL,NULL,NULL,8,NULL,NULL),(28,'stock_order','completed',NULL,NULL,NULL,2,NULL,NULL),(29,'stock_order','completed',NULL,NULL,NULL,9,NULL,NULL),(30,'stock_order','completed',NULL,NULL,NULL,4,NULL,NULL),(31,'stock_order','completed',NULL,NULL,NULL,2,NULL,NULL),(32,'stock_order','completed',NULL,NULL,NULL,3,NULL,NULL),(33,'stock_order','completed',NULL,NULL,NULL,4,NULL,NULL);
/*!40000 ALTER TABLE `Job` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Mechanic`
--

DROP TABLE IF EXISTS `Mechanic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Mechanic` (
  `username` varchar(20) NOT NULL,
  `hourly_rate` double NOT NULL,
  PRIMARY KEY (`username`),
  CONSTRAINT `mechanic_ibfk_1` FOREIGN KEY (`username`) REFERENCES `Staff` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Mechanic`
--

LOCK TABLES `Mechanic` WRITE;
/*!40000 ALTER TABLE `Mechanic` DISABLE KEYS */;
INSERT INTO `Mechanic` VALUES ('BenDoit',15),('fixitbob',15),('Luke2',12),('mechanic2',20),('ponton2009',15);
/*!40000 ALTER TABLE `Mechanic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Payment`
--

DROP TABLE IF EXISTS `Payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Payment` (
  `payment_id` int(10) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(10) DEFAULT NULL,
  `payment_type` enum('cash','card') NOT NULL,
  `date_paid` date NOT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `invoice_id` (`invoice_id`),
  CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `Invoice` (`invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Payment`
--

LOCK TABLES `Payment` WRITE;
/*!40000 ALTER TABLE `Payment` DISABLE KEYS */;
INSERT INTO `Payment` VALUES (6,61,'cash','2022-04-10'),(7,62,'cash','2022-04-10'),(8,63,'cash','2022-04-10'),(9,67,'cash','2022-04-10'),(10,69,'card','2022-04-10'),(11,79,'cash','2022-04-11'),(12,81,'cash','2022-04-11');
/*!40000 ALTER TABLE `Payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Staff`
--

DROP TABLE IF EXISTS `Staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Staff` (
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(30) NOT NULL,
  `role` varchar(30) NOT NULL,
  `email` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Staff`
--

LOCK TABLES `Staff` WRITE;
/*!40000 ALTER TABLE `Staff` DISABLE KEYS */;
INSERT INTO `Staff` VALUES ('administaror','5d69dd95ac183c9643780ed7027d128a','kyle','Administrator','admin@garits.com'),('administaroraa','5d69dd95ac183c9643780ed7027d128a','sa','Mechanic','dsa@gmail.com'),('BenDoit','34cc93ece0ba9e3f6f235d4af979b16c','Ben','Mechanic','mechanic4@garits.com'),('Borygo','00cdb7bb942cf6b290ceb97d6aca64a3','Borygo','Foreperson','foreperson@garits.com'),('Borys','218dd27aebeccecae69ad8408d9a36bf','Borys','Receptionist','receptionist@garits.com'),('fixitbob','7c6a180b36896a0a8c02787eeafb0e4c','Bob','Mechanic','mechanic1@garits.com'),('Glynne','5ddaac162f03e50cc6906cd162bf342e','Glynne Lancaster','Franchisee',''),('Luke2','db0edd04aaac4506f7edab03ac855d56','Anna','Mechanic','mechanic5@garits.com'),('mechanic2','6cb75f652a9b52798eb6cf2201057c73','victor','Mechanic','mechanic2@garits.com'),('Penelope','5b14d5430b5e11ff3abf955a779c64f9','Penelope Carr','Receptionist','penelope@gmail.com'),('ponton2009','819b0643d6b89dc9b579fdfc9094f28e','przemek','Mechanic','mechanic3@garits.com'),('saadministaror','5d69dd95ac183c9643780ed7027d128a','fassfasfa','Receptionist','dsaffafdafdfad@dsa.it');
/*!40000 ALTER TABLE `Staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Stock`
--

DROP TABLE IF EXISTS `Stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Stock` (
  `item_id` int(10) NOT NULL AUTO_INCREMENT,
  `part_name` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `year` varchar(4) DEFAULT NULL,
  `price` double NOT NULL,
  `manufacturer_name` varchar(50) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `threshold_level` int(10) NOT NULL DEFAULT 10,
  `delivery` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Stock`
--

LOCK TABLES `Stock` WRITE;
/*!40000 ALTER TABLE `Stock` DISABLE KEYS */;
INSERT INTO `Stock` VALUES (1,'Tyre, heavy tread',1,'2006',45,'Ford','Fjord Transit Van',6,20),(2,'Exhaust, complete box',10,'2020',200,'Fjord Estate','any',2,10),(3,'Engine Mounts, set',4,'2019',15,'Ford','all makes',4,NULL),(4,'Spark Plugs, each',21,'2006',1.5,'Ford','all makes',20,NULL),(5,'Spark Leads, set',16,'2006',12.5,'Mercedes-benz','all makes',10,NULL),(6,'Distributor Cap',10,'2006',35,'Ford','Fjord',5,NULL),(7,'Paint',3,'2006',60,'Slap-it-on Paints','all makes ',2,NULL),(8,'Interior Bulb',1,'2006',118,'Switch-it-on','Rolls Royce',1,NULL),(9,'Motor Oil',29,'2006',25,'BMW','all makes',25,NULL),(10,'Oil Filter',16,'2006',10,'Bmw','all makes',15,NULL),(11,'Air Filter',14,'2006',15,'Bmw','all makes',10,NULL),(12,'1',9,'1',1,'1','1',1,NULL),(13,'tesco',10,'',100,'dsa','lambo',10,NULL),(14,'tesco',10,'',100,'dsa','lambo',12,NULL),(15,'tesco',10,'',100,'dsa','lambo',12,NULL),(16,'dsa',2,'',23,'dsa','sa',10,NULL),(17,'das',2,'',233,'dsa','das',10,NULL),(18,'sda',2,'',231,'sad','sad',10,NULL),(19,'wal',21,'',2,'dsa','dsa',10,NULL),(20,'das',21,'',2,'dsa','dsa',10,NULL),(21,'dsa',32,'sd',32,'da','das',10,NULL),(22,'dsa',32,'sd',32,'da','das',10,NULL),(23,'das',32,'dsa',32,'das','da',10,NULL),(24,'das',32,'dsa',32,'das','da',10,NULL);
/*!40000 ALTER TABLE `Stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Stock_ordered`
--

DROP TABLE IF EXISTS `Stock_ordered`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Stock_ordered` (
  `item_id` int(10) NOT NULL,
  `supplier_id` int(10) NOT NULL,
  `date_ordered` date NOT NULL,
  `quantity` int(10) NOT NULL,
  PRIMARY KEY (`item_id`,`supplier_id`,`date_ordered`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `stock_ordered_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `Supplier` (`supplier_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `stock_ordered_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `Stock` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Stock_ordered`
--

LOCK TABLES `Stock_ordered` WRITE;
/*!40000 ALTER TABLE `Stock_ordered` DISABLE KEYS */;
INSERT INTO `Stock_ordered` VALUES (1,1,'2022-04-09',10),(1,1,'2022-04-10',20),(1,1,'2022-04-11',30),(2,1,'2022-04-11',10);
/*!40000 ALTER TABLE `Stock_ordered` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Stock_used`
--

DROP TABLE IF EXISTS `Stock_used`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Stock_used` (
  `job_id` int(10) NOT NULL,
  `item_id` int(10) NOT NULL,
  `date_used` date NOT NULL,
  PRIMARY KEY (`job_id`,`item_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `stock_used_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `Job` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `stock_used_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `Stock` (`item_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Stock_used`
--

LOCK TABLES `Stock_used` WRITE;
/*!40000 ALTER TABLE `Stock_used` DISABLE KEYS */;
INSERT INTO `Stock_used` VALUES (3,1,'2022-04-10'),(3,4,'2022-04-10'),(3,11,'2022-04-11'),(3,12,'2022-04-11'),(21,2,'2022-04-10'),(22,2,'2022-04-10'),(23,2,'2022-04-10'),(24,1,'2022-04-10'),(25,2,'2022-04-10'),(26,2,'2022-04-10'),(27,2,'2022-04-10'),(28,1,'2022-04-10'),(29,9,'2022-04-10'),(30,8,'2022-04-10'),(31,4,'2022-04-11'),(32,3,'2022-04-11'),(33,3,'2022-04-11');
/*!40000 ALTER TABLE `Stock_used` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Supplier`
--

DROP TABLE IF EXISTS `Supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Supplier` (
  `supplier_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `post_code` varchar(10) NOT NULL,
  `city` varchar(50) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Supplier`
--

LOCK TABLES `Supplier` WRITE;
/*!40000 ALTER TABLE `Supplier` DISABLE KEYS */;
INSERT INTO `Supplier` VALUES (1,'Fjord Supplies,',' 10 Largeunits, Trade Estate',' RG10 4PT','Reading','01895 453 857',NULL),(2,'Halfords','1 Enormous Office, Trading Park','NW10 4UP','London','0208 333 5555',NULL);
/*!40000 ALTER TABLE `Supplier` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Task`
--

DROP TABLE IF EXISTS `Task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Task` (
  `task_id` int(10) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Task`
--

LOCK TABLES `Task` WRITE;
/*!40000 ALTER TABLE `Task` DISABLE KEYS */;
INSERT INTO `Task` VALUES (1,'Change the tyres'),(2,'Change the mirrors'),(3,'repair the engine'),(6,'Change the tyres'),(8,'check oil level'),(10,'Change the tyres'),(11,'change the brakes'),(12,'change the brakes'),(13,'change the brakes'),(14,'repair brake after mot falied'),(15,'Change bumber'),(16,'0'),(17,'- replacement of the exhaust system '),(18,'change tyressss'),(19,'das'),(20,'dassaas');
/*!40000 ALTER TABLE `Task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Task_performed`
--

DROP TABLE IF EXISTS `Task_performed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Task_performed` (
  `job_id` int(10) NOT NULL,
  `task_id` int(10) NOT NULL,
  `date_performed` varchar(10) NOT NULL,
  PRIMARY KEY (`job_id`,`task_id`),
  KEY `task_id` (`task_id`),
  CONSTRAINT `task_performed_ibfk_1` FOREIGN KEY (`job_id`) REFERENCES `Job` (`job_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `task_performed_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `Task` (`task_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Task_performed`
--

LOCK TABLES `Task_performed` WRITE;
/*!40000 ALTER TABLE `Task_performed` DISABLE KEYS */;
INSERT INTO `Task_performed` VALUES (3,1,'2022'),(3,3,'2022-04-10'),(3,15,'2022-04-11'),(3,16,'2022-04-11'),(5,1,'2022');
/*!40000 ALTER TABLE `Task_performed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Vehicle`
--

DROP TABLE IF EXISTS `Vehicle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Vehicle` (
  `registration_number` varchar(10) NOT NULL,
  `make` varchar(30) NOT NULL,
  `engine_serial` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `chassis_num` varchar(50) NOT NULL,
  `next_MoT_date` varchar(10) DEFAULT NULL,
  `color` varchar(20) NOT NULL,
  `next_annual_service_date` varchar(10) DEFAULT NULL,
  `customer_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`registration_number`),
  UNIQUE KEY `engine_serial` (`engine_serial`),
  UNIQUE KEY `chassis_num` (`chassis_num`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `vehicle_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `Customer` (`customer_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Vehicle`
--

LOCK TABLES `Vehicle` WRITE;
/*!40000 ALTER TABLE `Vehicle` DISABLE KEYS */;
INSERT INTO `Vehicle` VALUES ('AA69 CPG','Fjord','WXXX999599999XX','Transit Van','2HGBH41JXMN109186','2022-05-12','white','2022-04-15',1),('ax67','mercedex','wal','benz','has','2022-04-23','black','',7),('BB19 OLE','Rolls Royce','WXXX9995912999XX','Convertible','2HGAH81JXMN109186','2022-05-12','Silver Shadow','2022-04-15',12),('BD11SMR','BMW','WXXX999X99999XX','BMW X5','1HGBH41JXMN109186','20220512','red','12052022',1),('BD31SMF','Fiat','ZYXX999X99999WX','Fiat Punto','1HGBH41JXMI109186','20220315','Black','10062022',2),('BD32SMR','FOrd','XXXX199X99349XX','Focus','1HGBH41JXMN109826','20220410','Black','10042022',10),('BD50SMR','BMW','XXXX9w9X99954XX','BMW X5','1HGBH41JXMN109986','20220619','Black','19062022',9),('BD51SMR','Tesla','XXXX939X99939XX','Tesla s','1HGBH41JXMN139186','20220324','Black','24032022',1),('BD52SMR','BMW','XXXX939X99939XY','BMW X2','1HGBH41JXMN109176','20220211','Yellow','11022022',5),('BD53SDR','RangeRover','XXXX999R99999XX','RangeRover 2','1HGBH41JXMN109126','20220515','red','12052022',4),('BD55SMR','Mercedes-benz','XXWX999X99999XX','Mercedes gle coupe','1HGBH41JXMN119186','20220512','White','12052022',3),('BD58SMR','BMW','XXXX949X99923XX','BMW X5','1HGBH41JXMN109326','20220527','Blue','27052022',7),('BD59SMR','Mini','XXXXs99X99659XX','MIni','1HGBH41JXMN109194','20220515','White','15052022',8),('BD60SMR','Mini','XXXXs99X99759XX','MIni','1HGBH41JXMN109195','20220815','Black','15052022',8),('BD61SMR','Mini','XXXXs99X99859XX','MIni','1HGBH41JXMN109196','20220418','Yellow','15052022',7),('BD62SMR','Mini','XXXXs99X99959XX','MIni','1HGBH41JXMN109197','20220112','White','15052022',7),('CT70 DWR','Fjord','ZYXX999X99499WX','Transit Van','3HGB241JXMI109186','2022-04-15','white','2022-04-15',1),('dx','chevoìroe','da','aveo','sa','2022-04-21','rgay','2022-04-29',1),('FF71 GHT','Fjord','XXWX999X99299XX','Transit Van','4HGB141JXMN119186','2022-08-12','white','2022-04-15',1),('GG14 PUB ','Fjord','XXXX999R219199XX','Estate MK8','5HGB1z41JXMN109126','2022-09-15','green','2022-04-15',20),('hassan','csa','jkjkkjk','dsa','sfalòlòl','','dsa','',4),('VV71 BHN','Fjord','XXXX999R99199XX','Transit Van','5HGB341JXMN109126','2022-09-15','white','2022-04-15',1),('waleed','csa','jk','dsa','sfa','','dsa','',9);
/*!40000 ALTER TABLE `Vehicle` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-11 21:46:13
