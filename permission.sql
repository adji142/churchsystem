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

 Date: 07/03/2024 16:26:50
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permissionname` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `link` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `ico` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `menusubmenu` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `multilevel` bit(1) NULL DEFAULT NULL,
  `separator` bit(1) NULL DEFAULT NULL,
  `order` int(255) NULL DEFAULT NULL,
  `status` bit(1) NULL DEFAULT NULL,
  `CabangID` int(11) NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES (1, 'Master', '', 'fa-archive', '0', b'1', b'0', 1, b'1', 0);
INSERT INTO `permission` VALUES (2, 'Wilayah', '', '', '1', b'0', b'0', 2, b'1', 0);
INSERT INTO `permission` VALUES (3, 'Cabang', 'cabang', '', '1', b'0', b'0', 3, b'1', 0);
INSERT INTO `permission` VALUES (4, 'Divisi Pelayanan', 'divisi', ' ', '1', b'0', b'0', 4, b'1', 0);
INSERT INTO `permission` VALUES (5, 'Jabatan Pelayanan', '', '', '1', b'0', b'0', 5, b'0', 0);
INSERT INTO `permission` VALUES (6, 'Anggota Gereja', 'personel', '', '1', b'0', b'0', 7, b'1', 0);
INSERT INTO `permission` VALUES (7, 'User Area', '', '', '1', b'0', b'1', 11, b'1', 0);
INSERT INTO `permission` VALUES (8, 'Hak Akses', 'role', '', '1', b'0', b'0', 12, b'1', 0);
INSERT INTO `permission` VALUES (9, 'User', 'user', '', '1', b'0', b'0', 13, b'1', 0);
INSERT INTO `permission` VALUES (10, 'Jenis Ibadah', '', '', '1', b'0', b'0', 8, b'1', 0);
INSERT INTO `permission` VALUES (11, 'Rate PK', 'ratepk', '', '1', b'0', b'0', 6, b'1', 0);
INSERT INTO `permission` VALUES (12, 'Jadwal Ibadah', '', '', '1', b'0', b'0', 10, b'1', 0);
INSERT INTO `permission` VALUES (13, 'Jenis Event', '', '', '1', b'0', b'0', 9, b'1', 0);
INSERT INTO `permission` VALUES (14, 'Finance', '', 'fa-dollar', '0', b'1', b'0', 13, b'1', 0);
INSERT INTO `permission` VALUES (15, 'Kelompok Akun Kas', '', '', '14', b'0', b'0', 14, b'1', 0);
INSERT INTO `permission` VALUES (16, 'Bank', '', ' ', '14', b'0', b'0', 16, b'1', 0);
INSERT INTO `permission` VALUES (17, 'Denominasi', '', '', '14', b'0', b'0', 17, b'1', 0);
INSERT INTO `permission` VALUES (18, 'Transaksi', '', '', '14', b'0', b'1', 18, b'1', 0);
INSERT INTO `permission` VALUES (19, 'Transaksi KAS', '', '', '14', b'0', b'0', 19, b'1', 0);
INSERT INTO `permission` VALUES (20, 'Setor Tunai', '', '', '14', b'0', b'0', 20, b'1', 0);
INSERT INTO `permission` VALUES (21, 'Tarik Tunai', '', '', '14', b'0', b'0', 21, b'1', 0);
INSERT INTO `permission` VALUES (22, 'Penerimaan Uang', '', '', '14', b'0', b'0', 22, b'1', 0);
INSERT INTO `permission` VALUES (23, 'Kelompok Penerimaan Uang', '', ' ', '14', b'0', b'0', 15, b'1', 0);
INSERT INTO `permission` VALUES (24, 'Cash Opname', '', '', '14', b'0', b'0', 23, b'1', 0);
INSERT INTO `permission` VALUES (25, 'Event', '', '', '0', b'0', b'0', 24, b'1', 0);
INSERT INTO `permission` VALUES (26, 'Pelayanan', '', '', '0', b'1', b'0', 25, b'1', 0);
INSERT INTO `permission` VALUES (27, 'Jadwal Pelayanan Rutin', '', '', '26', b'0', b'0', 26, b'1', 0);
INSERT INTO `permission` VALUES (28, 'Penugasan Pelayanan', '', '', '26', b'0', b'0', 27, b'1', 0);
INSERT INTO `permission` VALUES (29, 'Absensi Pelayanan', '', '', '26', b'0', b'0', 28, b'1', 0);
INSERT INTO `permission` VALUES (30, 'Laporan', '', '', '0', b'1', b'0', 29, b'1', 0);
INSERT INTO `permission` VALUES (31, 'Laporan Jadwal Pelayanan', '', '', '30', b'0', b'0', 30, b'1', 0);
INSERT INTO `permission` VALUES (32, 'Laporan Arus Kas', '', '', '30', b'0', b'0', 31, b'1', 0);
INSERT INTO `permission` VALUES (33, 'Laporan Absensi', '', '', '30', b'0', b'0', 32, b'1', 0);

SET FOREIGN_KEY_CHECKS = 1;
