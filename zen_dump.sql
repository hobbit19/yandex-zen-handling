-- MySQL dump --
-- ---------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
-- ---------------------------------------------------------


-- CREATE DATABASE "zen" ----------------------------------
CREATE DATABASE IF NOT EXISTS `zen` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `zen`;
-- ---------------------------------------------------------


-- CREATE TABLE "zen_data" ---------------------------------
-- DROP TABLE "zen_data" ---------------------------------------
DROP TABLE IF EXISTS `zen_data` CASCADE;
-- -------------------------------------------------------------


-- CREATE TABLE "zen_data" -------------------------------------
CREATE TABLE `zen_data` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`channel_id` Int( 11 ) NULL,
	`pub_id` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
	`type` VarChar( 10 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
	`title` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
	`created_at` Int( 11 ) NULL,
	`updated_at` Int( 11 ) NULL,
	`has_published` TinyInt( 1 ) NULL DEFAULT '0',
	`tags` VarChar( 1024 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1;
-- -------------------------------------------------------------
-- ---------------------------------------------------------


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- ---------------------------------------------------------


-- CREATE TABLE "zen_periods" ------------------------------
-- DROP TABLE "zen_periods" ------------------------------------
DROP TABLE IF EXISTS `zen_periods` CASCADE;
-- -------------------------------------------------------------


-- CREATE TABLE "zen_periods" ----------------------------------
CREATE TABLE `zen_periods` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`data_id` Int( 11 ) NOT NULL,
	`updated_at` Int( 11 ) NULL,
	`feed_shows` Int( 11 ) NULL,
	`shows` Int( 11 ) NULL,
	`likes` Int( 11 ) NULL,
	`views` Int( 11 ) NULL,
	`views_till_end` Int( 11 ) NULL,
	`sum_view_time_sec` Int( 11 ) NULL,
	`login` VarChar( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1;
-- -------------------------------------------------------------
-- ---------------------------------------------------------


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- ---------------------------------------------------------


-- CREATE TABLE "zen_channels" -----------------------------
-- DROP TABLE "zen_channels" -----------------------------------
DROP TABLE IF EXISTS `zen_channels` CASCADE;
-- -------------------------------------------------------------


-- CREATE TABLE "zen_channels" ---------------------------------
CREATE TABLE `zen_channels` ( 
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`channelId` VarChar( 50 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
	`login` VarChar( 50 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
	`name` VarChar( 255 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1;

-- CREATE TABLE "zen_commands" ---------------------------------
CREATE TABLE `zen_commands` (
	`id` Int( 11 ) AUTO_INCREMENT NOT NULL,
	`messageId` Int( 11 ) NOT NULL,
	`date` VarChar( 24 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
	`text` VarChar( 50 ) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
	PRIMARY KEY ( `id` ) )
CHARACTER SET = utf8
COLLATE = utf8_general_ci
ENGINE = InnoDB
AUTO_INCREMENT = 1;

-- -------------------------------------------------------------
-- ---------------------------------------------------------


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- ---------------------------------------------------------


