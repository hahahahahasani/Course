-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for course
CREATE DATABASE IF NOT EXISTS `course` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `course`;

-- Dumping structure for table course.kelas
CREATE TABLE IF NOT EXISTS `kelas` (
  `id_kelas` int NOT NULL AUTO_INCREMENT,
  `id_daftar` int DEFAULT NULL,
  `nama_kelas` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  PRIMARY KEY (`id_kelas`),
  KEY `id_daftar` (`id_daftar`),
  CONSTRAINT `FK_daftar` FOREIGN KEY (`id_daftar`) REFERENCES `pendaftaran` (`id_daftar`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table course.kelas: ~0 rows (approximately)
DELETE FROM `kelas`;

-- Dumping structure for table course.materi
CREATE TABLE IF NOT EXISTS `materi` (
  `id_materi` int NOT NULL AUTO_INCREMENT,
  `id_kelas` int DEFAULT NULL,
  `nama_materi` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `materi` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `deskripsi` text CHARACTER SET armscii8 COLLATE armscii8_bin,
  PRIMARY KEY (`id_materi`),
  KEY `id_kelas` (`id_kelas`),
  CONSTRAINT `FK_kelas_materi` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table course.materi: ~0 rows (approximately)
DELETE FROM `materi`;

-- Dumping structure for table course.pendaftaran
CREATE TABLE IF NOT EXISTS `pendaftaran` (
  `id_daftar` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `id_kelas` int DEFAULT NULL,
  `tanggal_daftar` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  PRIMARY KEY (`id_daftar`),
  KEY `email` (`email`),
  KEY `id_kelas` (`id_kelas`),
  CONSTRAINT `FK_email` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table course.pendaftaran: ~0 rows (approximately)
DELETE FROM `pendaftaran`;

-- Dumping structure for table course.penilaian
CREATE TABLE IF NOT EXISTS `penilaian` (
  `email` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `id_kelas` int DEFAULT NULL,
  `keuletan` int DEFAULT NULL,
  `kreativitas` int DEFAULT NULL,
  `pengetahuan` int DEFAULT NULL,
  KEY `email` (`email`),
  KEY `id_kelas` (`id_kelas`),
  CONSTRAINT `FK_email_nilai` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_kelas_nilai` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table course.penilaian: ~0 rows (approximately)
DELETE FROM `penilaian`;

-- Dumping structure for table course.submit_tugas
CREATE TABLE IF NOT EXISTS `submit_tugas` (
  `id_submit` int NOT NULL AUTO_INCREMENT,
  `id_tugas` int DEFAULT NULL,
  `email` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `file` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `tanggal_submit` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  PRIMARY KEY (`id_submit`),
  KEY `id_tugas` (`id_tugas`),
  KEY `email` (`email`),
  CONSTRAINT `FK_email_tugas` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_tugas` FOREIGN KEY (`id_tugas`) REFERENCES `tugas` (`id_tugas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table course.submit_tugas: ~0 rows (approximately)
DELETE FROM `submit_tugas`;

-- Dumping structure for table course.tugas
CREATE TABLE IF NOT EXISTS `tugas` (
  `id_tugas` int NOT NULL AUTO_INCREMENT,
  `id_kelas` int DEFAULT NULL,
  `nama_tugas` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `desk_tugas` text CHARACTER SET armscii8 COLLATE armscii8_bin,
  `jenis_tugas` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  PRIMARY KEY (`id_tugas`),
  KEY `id_kelas` (`id_kelas`),
  CONSTRAINT `FK_kelas_tugas` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table course.tugas: ~0 rows (approximately)
DELETE FROM `tugas`;

-- Dumping structure for table course.user
CREATE TABLE IF NOT EXISTS `user` (
  `email` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin NOT NULL DEFAULT '',
  `nama` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `password` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `alamat` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `role` varchar(255) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table course.user: ~0 rows (approximately)
DELETE FROM `user`;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
