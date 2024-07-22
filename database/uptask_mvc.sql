-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: uptask_mvc
-- ------------------------------------------------------
-- Server version	8.0.37

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proyectos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `proyecto` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `url` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `propietarioId` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proyectos_ibfk_1` (`propietarioId`),
  CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`propietarioId`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectos`
--

LOCK TABLES `proyectos` WRITE;
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` VALUES (1,'Tienda Virtual','ad461585d784d2b4688c31c8fb6f8cbd',2),(2,'Creacion de una API JSON','8b5bb48f41eef38a284852a7402b12ef',2),(3,'Aprender JS Moderno','82211b47dc00ab895e73e99d67155401',2),(4,' Aprender Django y Flask','ba22fedb10490146e06d127f474b39d1',1),(5,' Aprender Django','88d5fd1393d76080e1e770ef967346b3',2),(7,' Gestión de una Biblioteca Virtual','c3ace6c03119b9883df02633c9ba4dee',2),(8,' Aprender Expresiones Regulares','cedd786e1593fee712c7db07d023c0c1',2),(9,'Imperial Coffe','998d7c7433c4284ccd3cf3f1c373946c',11),(10,'Imperial Coffe','9f2637491ec9ca30227e7d0acdb8ab0f',12),(11,'Bienes Raices','728d1f89d40bdc2262a26da1438b2edc',12),(12,'App Salon','aeb20a745114e37ab54867ce174e00f5',12),(13,'Crear Asistente Personal','dcdba9b3fea3e575dd26aeecba216175',12),(14,'CRUD en Django','069943bc26fd97a01fbe606abe03219f',12),(15,'Gestionar mis Claves','fb0ecd1dbea4d73a329c46c957eef808',12),(16,'Proyecto con React','939cdf810e3f567fe838c1fd147ed104',12),(17,'Proyecto con Django y React','88d73ba75d3104548212944dcd0d13f4',12);
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tareas`
--

DROP TABLE IF EXISTS `tareas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tareas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` tinyint(1) DEFAULT NULL,
  `proyectoId` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tareas_ibfk_1` (`proyectoId`),
  CONSTRAINT `tareas_ibfk_1` FOREIGN KEY (`proyectoId`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tareas`
--

LOCK TABLES `tareas` WRITE;
/*!40000 ALTER TABLE `tareas` DISABLE KEYS */;
INSERT INTO `tareas` VALUES (1,'Configurar Entorno',1,3),(2,'Fundamentos de JS',1,3),(3,'Estructura de Control',0,3),(4,' Funciones',0,3),(5,' Objetos Y arrays',0,3),(6,'DOM',0,3),(7,' Asyncronia en JS',0,3),(8,'Manejo de Errores',0,3),(9,' Apis y Fetchs',0,3),(10,' Progamacion Orientada a Objetos',0,3),(11,' Modularizacion',0,3),(12,' Herramientas y Frameworks',0,3),(13,' Configuracion del Entorno',1,5),(14,' Conceptos Basicos de Django',0,5),(19,'Proyectos Practicos',0,3),(20,' Versionado de Código (git)',0,3),(21,' Revisar y Mejorar mi codigo',0,3),(22,' Crear una aplicacion',0,5),(23,' Aprender a usar modelos',0,5),(24,' Aprender a usar las vistas',0,5),(25,' Configurar las urls',0,5),(26,' Crear y usar templates',0,5),(27,' Crear formularios usando forms.py',0,5),(28,' Implementar registro, inicio de sesión y cierre de sesión.',0,5),(29,' Manejo de Archivos Estáticos y Multimedia',0,5),(30,' Desarrollo de APIs',0,5),(31,'Usar pytest o el framework de pruebas de Django.',0,5),(32,' Crear aplicaciones simples',0,5),(33,' Optimización y Mejores Prácticas',0,5),(34,'Crear un catalogo de productos',1,1),(35,'Implementar un sistema de carrito de compras',0,1),(36,' Añadir un panel de administración para gestionar productos.',0,1),(38,' Diseño del modelo de datos',0,7),(39,' Implementación de la base de datos',0,7),(40,' Desarrollo del backend',0,7),(41,' Desarrollo del frontend',0,7),(42,' Implementación de funciones adicionales',0,7),(43,' Seguridad y validaciones',0,7),(44,' Pruebas y depuración',0,7),(45,' Documentación',0,7),(46,' Implementación y despliegue',0,7),(47,'Buscar prooveedores fiables',0,1),(48,'Crear un Login',1,9),(49,'Crear Pagina de Registro',1,10),(50,'Crear Pagina de Login',0,10),(51,'Crear Pagina de olvide mi Pass',0,10),(52,'Enviar Gmail Para Verificar Cuenta',0,10),(53,'Validar Autenticacion',0,10),(54,'Pagina de Inicio',0,10),(55,'Pagina para agregar productos',0,10),(56,'Mostrar todos los productos',0,10);
/*!40000 ALTER TABLE `tareas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(60) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `token` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,' Andonys','andonys24@gmail.com','$2y$10$Kz9NHuz.6uVlY4NfokLTi.hOibpkjMTHXEqC0uvBBnWw2T0zwseIO','',1),(2,' Cristal Pineda','cristal78@gmail.com','$2y$10$Tki83GoDpMU0BM0PfxTNg.ksGf0IIq4xNXIjiBnvy6rSvqA8i1aDK','',1),(3,'Ana García','ana.garcia123@gmail.com','$2y$10$Sh9mx2y1aRwxmJA21U2wxeA5MEV.hcy2ZaaC2AT8HKlLk7d4zvHjG','',1),(4,'Carlos Martínez','carlos.martinez456@yahoo.com','$2y$10$lNea2W3dAgmJdCALGh2tcec9.xk029iGw3vfPYIlZSK.w83skLscy','',1),(5,'Laura Pérez','laura.perez789@hotmail.com','$2y$10$MsXt1MGUeYaurzS8IhAgO.xCr35byT.KLCheI8QjwTLr0sGw6m9i.','',1),(6,'María Rodríguez','maria.rodriguez567@icloud.com','$2y$10$GARXKmb57sSYi1UeqVVFjOEgrwrH8UcyYVNsPVFn974pWnvAtoScu','',1),(7,'Juan Sánchez','juan.sanchez234@outlook.com','$2y$10$RivDaJuq6xcTukKDqDbwNOmc8eMI8xcK143BJ1bg/nh2e4W0NfdGe','',1),(8,' Julia Martinez','julia.martinez@example.com','$2y$10$AvIUrtQLiJjHK2qNqFZCQOH5F477m/MEV4C78YXFA/oUCcku65aM6','',1),(9,'Cristian','cristian@gmail.com','$2y$10$Y7nmTGQqoghrEvX5XSCWZuAXMZ5ePjzitroPDu7xH9qZUtEs2t1Eq','',1),(10,'Emely','emelyposada12@example.com','$2y$10$It9lfeVZFqiaR0o76OAZ7OUu5EmWEKFdh3QpmDvo8YTnv2jPIcpHq','',1),(11,'Andoni','andonys12@gmail.com','$2y$10$/7V1o86rGZ0dyUAZ3n.5WeeKAJfxYZJMAWMn1oRWJd4DFCRlqgIrK','',1),(12,'Andonys Jr','mjr521250@gmail.com','$2y$10$RSBeqUj4yqtRTr3mYL2jLOmgoNfR8JfxKkAGBAv9kTUUldu5eLKHi','',1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'uptask_mvc'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-22  3:33:38
