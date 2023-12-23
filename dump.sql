/*
 Navicat Premium Data Transfer

 Source Server         : BV LOCAL
 Source Server Type    : MySQL
 Source Server Version : 100421
 Source Host           : localhost:3306
 Source Schema         : poketeam

 Target Server Type    : MySQL
 Target Server Version : 100421
 File Encoding         : 65001

 Date: 11/12/2023 14:42:22
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for entrenadores
-- ----------------------------
DROP TABLE IF EXISTS `entrenadores`;
CREATE TABLE `entrenadores`  (
  `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for equipos
-- ----------------------------
DROP TABLE IF EXISTS `equipos`;
CREATE TABLE `equipos`  (
  `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_entrenadores` bigint(10) UNSIGNED NULL DEFAULT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `equipos_entrenadores_id_fk`(`id_entrenadores`) USING BTREE,
  CONSTRAINT `equipos_entrenadores_id_fk` FOREIGN KEY (`id_entrenadores`) REFERENCES `entrenadores` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for pokemones
-- ----------------------------
DROP TABLE IF EXISTS `pokemones`;
CREATE TABLE `pokemones`  (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `tipo` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;


-- ----------------------------
-- Table structure for equipos_pokemones
-- ----------------------------
DROP TABLE IF EXISTS `equipos_pokemones`;
CREATE TABLE `equipos_pokemones`  (
  `id_equipos` bigint(10) UNSIGNED NULL DEFAULT NULL,
  `id_pokemones` bigint(10) UNSIGNED NULL DEFAULT NULL,
  `orden` tinyint(1) UNSIGNED NULL DEFAULT NULL,
  INDEX `equipos_pokemones_pokemones_id_fk`(`id_pokemones`) USING BTREE,
  INDEX `equipos_pokemones_equipos_id_fk`(`id_equipos`) USING BTREE,
  CONSTRAINT `equipos_pokemones_equipos_id_fk` FOREIGN KEY (`id_equipos`) REFERENCES `equipos` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `equipos_pokemones_pokemones_id_fk` FOREIGN KEY (`id_pokemones`) REFERENCES `pokemones` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;