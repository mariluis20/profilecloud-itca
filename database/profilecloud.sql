/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19-11.8.6-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: profilecloud
-- ------------------------------------------------------
-- Server version	11.8.6-MariaDB-0+deb13u1 from Debian

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(40) NOT NULL,
  `detail` varchar(255) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  KEY `activity_logs_action_index` (`action`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_11_02_000001_add_role_to_users_table',1),
(5,'2026_11_02_000002_create_profiles_table',1),
(6,'2026_11_02_000003_create_skills_table',1),
(7,'2026_11_02_000004_create_projects_table',1),
(8,'2026_11_02_000005_create_activity_logs_table',1),
(9,'2026_11_02_000006_add_name_parts_to_users_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `profiles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `slug` varchar(140) NOT NULL,
  `headline` varchar(150) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `carrera` varchar(120) DEFAULT NULL,
  `sede` varchar(60) DEFAULT NULL,
  `ciclo` tinyint(3) unsigned DEFAULT NULL,
  `github_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `is_public` tinyint(1) NOT NULL DEFAULT 1,
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `profiles_user_id_unique` (`user_id`),
  UNIQUE KEY `profiles_slug_unique` (`slug`),
  KEY `profiles_carrera_index` (`carrera`),
  KEY `profiles_is_public_index` (`is_public`),
  CONSTRAINT `profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES
(1,2,'andrea-valeria-hernandez-lopez','Desarrolladora web full stack en formación','Me apasiona construir aplicaciones web accesibles y rápidas. Actualmente profundizo en Laravel y en buenas prácticas de despliegue sobre Linux.','Ingeniería en Desarrollo de Software','Santa Tecla',6,'https://github.com/','https://www.linkedin.com/',NULL,NULL,1,1,'2026-11-03 06:09:16','2026-11-03 06:09:16'),
(2,3,'carlos-ernesto-martinez-ramos','Administración de redes y servidores Linux','Técnico enfocado en infraestructura: configuración de switches, VLAN, servidores Debian y monitoreo de servicios.','Técnico en Ingeniería de Redes Informáticas','San Miguel',4,NULL,'https://www.linkedin.com/',NULL,NULL,1,1,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(3,4,'gabriela-sofia-rivas-aguilar','Diseño UI y experiencia de usuario','Diseño interfaces limpias y centradas en las personas. Me interesa que la tecnología se vea bien y se entienda mejor.','Técnico en Diseño Gráfico','Santa Ana',5,NULL,NULL,NULL,NULL,1,0,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(4,5,'jose-alberto-flores-mejia','Desarrollo móvil con Flutter','Construyo apps móviles multiplataforma conectadas a APIs REST. Busco pasantía en equipos de desarrollo ágil.','Técnico en Ingeniería de Sistemas Informáticos','Santa Tecla',5,'https://github.com/',NULL,NULL,NULL,1,1,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(5,6,'maria-jose-castillo-perez','Automatización y sistemas mecatrónicos','Integro sensores, PLC y programación para automatizar procesos industriales de forma segura y eficiente.','Técnico en Ingeniería Mecatrónica','Zacatecoluca',4,NULL,NULL,NULL,NULL,1,1,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(6,7,'diego-alejandro-portillo-cruz','Backend y bases de datos','Me gusta modelar datos y construir APIs robustas. Practico seguridad web y optimización de consultas SQL.','Ingeniería en Desarrollo de Software','La Unión',3,'https://github.com/',NULL,NULL,NULL,1,1,'2026-11-03 06:09:18','2026-11-03 06:09:18');
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `profile_id` bigint(20) unsigned NOT NULL,
  `title` varchar(120) NOT NULL,
  `description` text NOT NULL,
  `technologies` varchar(255) DEFAULT NULL,
  `repo_url` varchar(255) DEFAULT NULL,
  `demo_url` varchar(255) DEFAULT NULL,
  `year` smallint(5) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `projects_profile_id_foreign` (`profile_id`),
  CONSTRAINT `projects_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES
(1,1,'Sistema de reservas de laboratorio','Aplicación web para reservar laboratorios de cómputo con calendario, roles y notificaciones por correo.','Laravel, MariaDB, Bootstrap',NULL,NULL,2026,'2026-11-03 06:09:16','2026-11-03 06:09:16'),
(2,1,'Portal de becas estudiantiles','Formulario de solicitud de becas con carga de documentos y panel de revisión para el comité.','PHP, MySQL, JavaScript',NULL,NULL,2025,'2026-11-03 06:09:16','2026-11-03 06:09:16'),
(3,2,'Red segmentada para PYME','Diseño e implementación de una red con VLAN, DHCP y políticas de acceso para una empresa de 40 equipos.','Cisco, Packet Tracer, VLAN',NULL,NULL,2026,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(4,3,'Rediseño de app de transporte','Propuesta de rediseño de una app de rutas de buses con pruebas de usabilidad con 12 usuarios.','Figma, Prototipado',NULL,NULL,2026,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(5,3,'Identidad visual para cafetería','Logotipo, paleta de colores y piezas para redes sociales de un emprendimiento local.','Illustrator, Photoshop',NULL,NULL,2025,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(6,4,'App de control de gastos','Aplicación móvil para registrar gastos personales con gráficos mensuales y respaldo en la nube.','Flutter, Firebase',NULL,NULL,2026,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(7,5,'Banda clasificadora por color','Prototipo de banda transportadora que clasifica piezas por color usando sensores y un PLC.','PLC, Sensores, Arduino',NULL,NULL,2025,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(8,6,'API de inventario','API REST con autenticación por tokens para el control de inventario de una ferretería.','Laravel, MariaDB, Postman',NULL,NULL,2026,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(9,6,'Dashboard de ventas','Panel con indicadores de ventas diarias y reportes exportables a CSV.','PHP, Chart.js, MySQL',NULL,NULL,2025,'2026-11-03 06:09:18','2026-11-03 06:09:18');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `skills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `profile_id` bigint(20) unsigned NOT NULL,
  `name` varchar(50) NOT NULL,
  `level` tinyint(3) unsigned NOT NULL DEFAULT 3,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `skills_profile_id_name_unique` (`profile_id`,`name`),
  KEY `skills_name_index` (`name`),
  CONSTRAINT `skills_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
INSERT INTO `skills` VALUES
(1,1,'Laravel',4,'2026-11-03 06:09:16','2026-11-03 06:09:16'),
(2,1,'PHP',4,'2026-11-03 06:09:16','2026-11-03 06:09:16'),
(3,1,'MySQL / MariaDB',4,'2026-11-03 06:09:16','2026-11-03 06:09:16'),
(4,1,'JavaScript',3,'2026-11-03 06:09:16','2026-11-03 06:09:16'),
(5,1,'Git',4,'2026-11-03 06:09:16','2026-11-03 06:09:16'),
(6,1,'Bootstrap',5,'2026-11-03 06:09:16','2026-11-03 06:09:16'),
(7,2,'Linux',5,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(8,2,'Cisco IOS',4,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(9,2,'Apache',4,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(10,2,'Bash',3,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(11,2,'Firewall UFW',4,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(12,3,'Figma',5,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(13,3,'Illustrator',4,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(14,3,'UX Research',3,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(15,3,'HTML y CSS',3,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(16,4,'Flutter',4,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(17,4,'Dart',4,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(18,4,'Firebase',3,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(19,4,'API REST',4,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(20,4,'Java',3,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(21,5,'PLC Siemens',4,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(22,5,'Arduino',5,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(23,5,'AutoCAD',3,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(24,5,'Python',3,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(25,6,'SQL',4,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(26,6,'Node.js',3,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(27,6,'Laravel',3,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(28,6,'Docker',2,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(29,6,'Git',4,'2026-11-03 06:09:18','2026-11-03 06:09:18');
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `first_name` varchar(60) DEFAULT NULL,
  `middle_name` varchar(60) DEFAULT NULL,
  `last_name` varchar(60) DEFAULT NULL,
  `second_last_name` varchar(60) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'estudiante',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_index` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Administrador ProfileCloud','Administrador',NULL,'ProfileCloud',NULL,'admin@profilecloud.local','admin',1,NULL,'$2y$12$L2u863O.bE155K7GLa9BEetidsXvTgEC/ZOhSGBFWvz7F/1CelWv6',NULL,'2026-11-03 06:09:16','2026-11-03 06:09:16'),
(2,'Andrea Valeria Hernández López','Andrea','Valeria','Hernández','López','andrea.hernandez@profilecloud.local','estudiante',1,NULL,'$2y$12$TF4U7CSQdzp2UD9WAg.ag./52D/A4KpRUm7NSR6y4yM69h0RaYst2',NULL,'2026-11-03 06:09:16','2026-11-03 06:09:16'),
(3,'Carlos Ernesto Martínez Ramos','Carlos','Ernesto','Martínez','Ramos','carlos.martinez@profilecloud.local','estudiante',1,NULL,'$2y$12$rpCQ3cVN6cr7AU9gdxn6EutlzrHfqo1CTylXNbakNMTCRAoQhKoyu',NULL,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(4,'Gabriela Sofía Rivas Aguilar','Gabriela','Sofía','Rivas','Aguilar','gabriela.rivas@profilecloud.local','estudiante',1,NULL,'$2y$12$kS1bwURjocS5JlV4t0A2R.rPB0lYp3DUsMMjCqOuSLHmbUeCn9a0m',NULL,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(5,'José Alberto Flores Mejía','José','Alberto','Flores','Mejía','jose.flores@profilecloud.local','estudiante',1,NULL,'$2y$12$VEqWPbHfBXJys067LIQ/k.p9a/g7qz5A.3O64gK/PIJ/W4v04XiLS',NULL,'2026-11-03 06:09:17','2026-11-03 06:09:17'),
(6,'María José Castillo Pérez','María','José','Castillo','Pérez','maria.castillo@profilecloud.local','estudiante',1,NULL,'$2y$12$WJW.vXcU3DBO41JnUTlBQusVfx5aBoCpyqHLdB5H1tHprJ36BdKMO',NULL,'2026-11-03 06:09:18','2026-11-03 06:09:18'),
(7,'Diego Alejandro Portillo Cruz','Diego','Alejandro','Portillo','Cruz','diego.portillo@profilecloud.local','estudiante',1,NULL,'$2y$12$mBuRb9xE3ADBpe0y5nVH0eyF4zXPAHp2yyasQYWfiM8qDQPpkQena',NULL,'2026-11-03 06:09:18','2026-11-03 06:09:18');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

-- Dump completed on 2026-11-03  0:13:27
