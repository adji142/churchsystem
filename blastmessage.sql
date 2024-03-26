/*
 Navicat Premium Data Transfer

 Source Server         : AISServer
 Source Server Type    : MySQL
 Source Server Version : 100240
 Source Host           : localhost:3306
 Source Schema         : churchsystem

 Target Server Type    : MySQL
 Target Server Version : 100240
 File Encoding         : 65001

 Date: 26/03/2024 13:00:41
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for blastmessage
-- ----------------------------
DROP TABLE IF EXISTS `blastmessage`;
CREATE TABLE `blastmessage`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `BaseEntry` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Chanel` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Penerima` varchar(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Message` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `Sended` int(1) NOT NULL DEFAULT 0,
  `CreatedOn` datetime(6) NULL DEFAULT NULL,
  `SendedOn` datetime(6) NULL DEFAULT NULL,
  `ReturnMessage` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of blastmessage
-- ----------------------------
INSERT INTO `blastmessage` VALUES (22, 'JDW20240326000002', 'email', 'fredyisay@gmail.com', '\r\n					        	<h3><center><b>Tiberias System</b></center></h3><br>\r\n					            <p>\r\n					            	<b>Shalom Austina Elizabeth R.N. Situmorang</b><br>\r\n					            	Anda Mendapat Jadwal Pelayanan Pada :\r\n					            </p>\r\n					            <pre>\r\n					            	Hari 		: Minggu <br>\r\n					            	Tanggal 	: 2024-03-26<br>\r\n					            	Jam 		: 06:00:00 s/d 08:00:00<br>\r\n					            </pre>\r\n					            <p>\r\n					            Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.\r\n					            <a href=\"http://localhost:8080/echurch/pelayanan/konfirmasi/eonykLGdlcMbHOKmwp\">Klik disini</a>\r\n					            Tuhan Yesus Memberkati<br><br>\r\n					            admin\r\n					            </p>\r\n					        ', 1, '2024-03-26 11:29:47.000000', '2024-03-26 12:49:44.000000', '{\"success\":true,\"message\":\"\",\"data\":[]}');
INSERT INTO `blastmessage` VALUES (23, 'JDW20240326000002', 'whats', '6285921787877', '\r\n	Shalom *Austina Elizabeth R.N. Situmorang* \r\n	Anda Mendapat Jadwal Pelayanan Pada :\r\n\r\n	*Hari 		: Minggu*\r\n	*Tanggal 	: 2024-03-26*\r\n	*Jam 		: 06:00:00 s/d 08:00:00*\r\n\r\n	Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.\r\n	http://localhost:8080/echurch/pelayanan/konfirmasi/eonykLGdlcMbHOKmwp\r\n\r\n	Tuhan Yesus Memberkati\r\n\r\n	admin\r\n', 1, '2024-03-26 11:29:47.000000', NULL, NULL);
INSERT INTO `blastmessage` VALUES (24, 'JDW20240326000002', 'email', 'prasetyoajiw@gmail.com', '\r\n					        	<h3><center><b>Tiberias System</b></center></h3><br>\r\n					            <p>\r\n					            	<b>Shalom Ivana Leticya </b><br>\r\n					            	Anda Mendapat Jadwal Pelayanan Pada :\r\n					            </p>\r\n					            <pre>\r\n					            	Hari 		: Minggu <br>\r\n					            	Tanggal 	: 2024-03-26<br>\r\n					            	Jam 		: 06:00:00 s/d 08:00:00<br>\r\n					            </pre>\r\n					            <p>\r\n					            Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.\r\n					            <a href=\"http://localhost:8080/echurch/pelayanan/konfirmasi/uPApRhrqeLDizMmtjY\">Klik disini</a>\r\n					            Tuhan Yesus Memberkati<br><br>\r\n					            admin\r\n					            </p>\r\n					        ', 1, '2024-03-26 11:29:47.000000', '2024-03-26 12:49:48.000000', '{\"success\":true,\"message\":\"\",\"data\":[]}');
INSERT INTO `blastmessage` VALUES (25, 'JDW20240326000002', 'whats', '6285772078004', '\r\n	Shalom *Ivana Leticya * \r\n	Anda Mendapat Jadwal Pelayanan Pada :\r\n\r\n	*Hari 		: Minggu*\r\n	*Tanggal 	: 2024-03-26*\r\n	*Jam 		: 06:00:00 s/d 08:00:00*\r\n\r\n	Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.\r\n	http://localhost:8080/echurch/pelayanan/konfirmasi/uPApRhrqeLDizMmtjY\r\n\r\n	Tuhan Yesus Memberkati\r\n\r\n	admin\r\n', 1, '2024-03-26 11:29:47.000000', NULL, NULL);
INSERT INTO `blastmessage` VALUES (26, 'JDW20240326000002', 'whats', '62818124058', '\r\n	Shalom *Jullian Ricky* \r\n	Anda Mendapat Jadwal Pelayanan Pada :\r\n\r\n	*Hari 		: Minggu*\r\n	*Tanggal 	: 2024-03-26*\r\n	*Jam 		: 06:00:00 s/d 08:00:00*\r\n\r\n	Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.\r\n	http://localhost:8080/echurch/pelayanan/konfirmasi/UMWtTqdObfgnopiJhD\r\n\r\n	Tuhan Yesus Memberkati\r\n\r\n	admin\r\n', 1, '2024-03-26 11:29:47.000000', NULL, NULL);
INSERT INTO `blastmessage` VALUES (27, 'JDW20240326000002', 'whats', '62817755724', '\r\n	Shalom *Ruben Lumban Tobing* \r\n	Anda Mendapat Jadwal Pelayanan Pada :\r\n\r\n	*Hari 		: Minggu*\r\n	*Tanggal 	: 2024-03-26*\r\n	*Jam 		: 06:00:00 s/d 08:00:00*\r\n\r\n	Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.\r\n	http://localhost:8080/echurch/pelayanan/konfirmasi/nFQgySIdAzXrUVlDEK\r\n\r\n	Tuhan Yesus Memberkati\r\n\r\n	admin\r\n', 1, '2024-03-26 11:29:47.000000', NULL, NULL);
INSERT INTO `blastmessage` VALUES (28, 'JDW20240326000002', 'whats', '6281295942405', '\r\n	Shalom *Hetty Lovania* \r\n	Anda Mendapat Jadwal Pelayanan Pada :\r\n\r\n	*Hari 		: Minggu*\r\n	*Tanggal 	: 2024-03-26*\r\n	*Jam 		: 06:00:00 s/d 08:00:00*\r\n\r\n	Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.\r\n	http://localhost:8080/echurch/pelayanan/konfirmasi/ovyOkqnLGNFzwbICpa\r\n\r\n	Tuhan Yesus Memberkati\r\n\r\n	admin\r\n', 1, '2024-03-26 11:29:47.000000', NULL, NULL);
INSERT INTO `blastmessage` VALUES (29, 'JDW20240326000002', 'whats', '6285669313774', '\r\n	Shalom *Martchel Ariesta Fitriansyah* \r\n	Anda Mendapat Jadwal Pelayanan Pada :\r\n\r\n	*Hari 		: Minggu*\r\n	*Tanggal 	: 2024-03-26*\r\n	*Jam 		: 06:00:00 s/d 08:00:00*\r\n\r\n	Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.\r\n	http://localhost:8080/echurch/pelayanan/konfirmasi/GektAciKVvWrwaBsCO\r\n\r\n	Tuhan Yesus Memberkati\r\n\r\n	admin\r\n', 1, '2024-03-26 11:29:47.000000', NULL, NULL);
INSERT INTO `blastmessage` VALUES (30, 'JDW20240326000002', 'whats', '6281991915558', '\r\n	Shalom *Sean Simaela* \r\n	Anda Mendapat Jadwal Pelayanan Pada :\r\n\r\n	*Hari 		: Minggu*\r\n	*Tanggal 	: 2024-03-26*\r\n	*Jam 		: 06:00:00 s/d 08:00:00*\r\n\r\n	Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.\r\n	http://localhost:8080/echurch/pelayanan/konfirmasi/OjlGhngWwSEyUQNiHA\r\n\r\n	Tuhan Yesus Memberkati\r\n\r\n	admin\r\n', 1, '2024-03-26 11:29:47.000000', NULL, NULL);
INSERT INTO `blastmessage` VALUES (31, 'JDW20240326000002', 'whats', '6281291373248', '\r\n	Shalom *Ariko Daniel* \r\n	Anda Mendapat Jadwal Pelayanan Pada :\r\n\r\n	*Hari 		: Minggu*\r\n	*Tanggal 	: 2024-03-26*\r\n	*Jam 		: 06:00:00 s/d 08:00:00*\r\n\r\n	Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.\r\n	http://localhost:8080/echurch/pelayanan/konfirmasi/rZRQbxcoUVeXGfmODq\r\n\r\n	Tuhan Yesus Memberkati\r\n\r\n	admin\r\n', 1, '2024-03-26 11:29:47.000000', NULL, NULL);
INSERT INTO `blastmessage` VALUES (32, 'JDW20240326000002', 'whats', '6287809076282', '\r\n	Shalom *Malvin wijaya* \r\n	Anda Mendapat Jadwal Pelayanan Pada :\r\n\r\n	*Hari 		: Minggu*\r\n	*Tanggal 	: 2024-03-26*\r\n	*Jam 		: 06:00:00 s/d 08:00:00*\r\n\r\n	Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.\r\n	http://localhost:8080/echurch/pelayanan/konfirmasi/pPFzStsjKhiqGMnfuT\r\n\r\n	Tuhan Yesus Memberkati\r\n\r\n	admin\r\n', 1, '2024-03-26 11:29:47.000000', NULL, NULL);
INSERT INTO `blastmessage` VALUES (33, 'JDW20240326000002', 'whats', '6281294149996', '\r\n	Shalom *Montana Tarigan * \r\n	Anda Mendapat Jadwal Pelayanan Pada :\r\n\r\n	*Hari 		: Minggu*\r\n	*Tanggal 	: 2024-03-26*\r\n	*Jam 		: 06:00:00 s/d 08:00:00*\r\n\r\n	Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.\r\n	http://localhost:8080/echurch/pelayanan/konfirmasi/yAFwQHTbjuvptkSMaZ\r\n\r\n	Tuhan Yesus Memberkati\r\n\r\n	admin\r\n', 1, '2024-03-26 11:29:47.000000', NULL, NULL);
INSERT INTO `blastmessage` VALUES (34, 'JDW20240326000002', 'whats', '6282194147355', '\r\n	Shalom *Chrishane danielle juliene sumampouw* \r\n	Anda Mendapat Jadwal Pelayanan Pada :\r\n\r\n	*Hari 		: Minggu*\r\n	*Tanggal 	: 2024-03-26*\r\n	*Jam 		: 06:00:00 s/d 08:00:00*\r\n\r\n	Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.\r\n	http://localhost:8080/echurch/pelayanan/konfirmasi/hBYIGyqCktnTgJpAsd\r\n\r\n	Tuhan Yesus Memberkati\r\n\r\n	admin\r\n', 1, '2024-03-26 11:29:47.000000', NULL, NULL);
INSERT INTO `blastmessage` VALUES (35, 'JDW20240326000002', 'whats', '6281325058258', '\r\n	Shalom *Daniel Deri * \r\n	Anda Mendapat Jadwal Pelayanan Pada :\r\n\r\n	*Hari 		: Minggu*\r\n	*Tanggal 	: 2024-03-26*\r\n	*Jam 		: 06:00:00 s/d 08:00:00*\r\n\r\n	Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.\r\n	http://localhost:8080/echurch/pelayanan/konfirmasi/HIPWogmYrGAEXhpkRc\r\n\r\n	Tuhan Yesus Memberkati\r\n\r\n	admin\r\n', 1, '2024-03-26 11:29:47.000000', '2024-03-26 12:58:52.000000', '{\"success\":true,\"message\":\"\",\"data\":\"                                                  {\\\"status\\\":true,\\\"msg\\\":\\\"Message sent successfully!\\\"}\"}');

SET FOREIGN_KEY_CHECKS = 1;
