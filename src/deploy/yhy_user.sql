/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80011
 Source Host           : localhost:3306
 Source Schema         : yhy_user

 Target Server Type    : MySQL
 Target Server Version : 80011
 File Encoding         : 65001

 Date: 08/02/2020 13:48:13
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for yhy_certificate
-- ----------------------------
DROP TABLE IF EXISTS `yhy_certificate`;
CREATE TABLE `yhy_certificate`  (
  `certificate_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '证书id',
  `employee_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '员工id',
  `certificate_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '证书名称',
  `cert_begin_time` date NOT NULL,
  `certificate_num` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '证件编号',
  `cert_end_time` date NOT NULL COMMENT '证件截至日期',
  `cert_resource_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '证书图片',
  `create_at` timestamp(0) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`certificate_id`) USING BTREE,
  INDEX `idx_employee_is`(`employee_id`) USING BTREE COMMENT '员工id'
) ENGINE = InnoDB AUTO_INCREMENT = 135 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for yhy_emergency
-- ----------------------------
DROP TABLE IF EXISTS `yhy_emergency`;
CREATE TABLE `yhy_emergency`  (
  `emergency_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '紧急联系人id',
  `employee_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '员工id',
  `emergency_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '紧急联系人',
  `relationship` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '关系',
  `emergency_phone` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '紧急联系人电话',
  `create_at` timestamp(0) NOT NULL COMMENT '创建时间',
  `update_at` timestamp(0) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`emergency_id`) USING BTREE,
  INDEX `idx_employee_id`(`employee_id`) USING BTREE COMMENT '员工id'
) ENGINE = InnoDB AUTO_INCREMENT = 96 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for yhy_employee
-- ----------------------------
DROP TABLE IF EXISTS `yhy_employee`;
CREATE TABLE `yhy_employee`  (
  `employee_id` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户自增id',
  `sex` int(11) NOT NULL COMMENT '性别',
  `full_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '全名',
  `nick_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '昵称',
  `user_name` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `mobile` varchar(13) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '手机号',
  `status` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Y' COMMENT '状态',
  `autolock` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N' COMMENT '是否锁定',
  `editor` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '修改者',
  `creator` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建者',
  `verify` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N' COMMENT '是否验证',
  `create_at` timestamp(0) NOT NULL COMMENT '创建时间',
  `update_at` timestamp(0) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`employee_id`) USING BTREE,
  UNIQUE INDEX `eu_mobile`(`mobile`) USING BTREE,
  UNIQUE INDEX `eu_username`(`user_name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for yhy_employee_ext
-- ----------------------------
DROP TABLE IF EXISTS `yhy_employee_ext`;
CREATE TABLE `yhy_employee_ext`  (
  `epy_ext_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `employee_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '用户id',
  `nation_tag_id` int(11) NOT NULL COMMENT '民族',
  `birth_day` date NOT NULL DEFAULT '1970-01-01' COMMENT '出生年月',
  `political_tag_id` int(11) NOT NULL COMMENT '政治面貌',
  `license_tag_id` int(11) NOT NULL COMMENT '证件类别',
  `license_num` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '证件号码',
  `employee_status_tag_id` int(11) NOT NULL COMMENT '员工状态',
  `education_tag_id` int(11) NOT NULL DEFAULT 0 COMMENT '学历',
  `frame_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '行政架构',
  `labor_end_time` int(11) NOT NULL DEFAULT 0 COMMENT '合同结束时间',
  `labor_begin_time` int(11) NOT NULL DEFAULT 0 COMMENT '合同开始时间',
  `job_tag_id` int(11) NOT NULL COMMENT '职位',
  `project_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '项目id',
  `labor_type_tag_id` int(11) NOT NULL COMMENT '合同类型',
  `departure_time` int(11) NOT NULL COMMENT '离职时间',
  `entry_time` int(11) NOT NULL COMMENT '入职时间',
  `remark` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '备注',
  `update_at` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  `create_at` timestamp(0) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`epy_ext_id`) USING BTREE,
  INDEX `index_employee_id`(`employee_id`) USING BTREE COMMENT '员工id'
) ENGINE = InnoDB AUTO_INCREMENT = 108 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '附加信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for yhy_member
-- ----------------------------
DROP TABLE IF EXISTS `yhy_member`;
CREATE TABLE `yhy_member`  (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '用户id',
  `type` enum('0','1','2','3','4') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '登陆类型，1为oa登陆 2位账号密码登陆,4 自动登录',
  `login_max_num` int(11) NOT NULL COMMENT '最大登录数',
  `password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `oa` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'oa账号',
  `is_lock` enum('0','1') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '是否锁定 1为锁定',
  `last_login_project_id` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '0',
  `last_login_time` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '上次登陆时间',
  `last_login_ip` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '上次登陆ip',
  `create_at` timestamp(0) NOT NULL COMMENT '创建时间',
  `update_at` timestamp(0) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`member_id`) USING BTREE,
  INDEX `user_id`(`employee_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 48 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '后台用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for yhy_tenement
-- ----------------------------
DROP TABLE IF EXISTS `yhy_tenement`;
CREATE TABLE `yhy_tenement`  (
  `tenement_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '自增id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `license_tag_id` int(11) NOT NULL COMMENT '证件类别',
  `license_num` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '证件号码',
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '邮箱',
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系电话',
  `project_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '项目id',
  `mobile` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '手机号',
  `tenement_type_tag_id` int(11) NOT NULL COMMENT '住户类型',
  `birth_day` date NOT NULL DEFAULT '1970-01-01' COMMENT '出生日期',
  `sex` int(11) NOT NULL COMMENT '性别',
  `contact_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '联系人',
  `real_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '真实姓名',
  `in_time` int(11) NOT NULL DEFAULT 0 COMMENT '入住时间',
  `out_time` int(11) NOT NULL DEFAULT 0 COMMENT '迁出时间',
  `out_reason_tag_id` int(11) NOT NULL COMMENT '迁出缘由',
  `rescue_type_tag_id` int(11) NOT NULL COMMENT '救援类型',
  `pet_type_tag_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '宠物类型',
  `face_resource_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '照片id',
  `pet_remark` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '宠物备注',
  `pet_num` int(5) NOT NULL COMMENT '宠物数量',
  `account_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '账户名称',
  `tax_number` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '纳税人识别号',
  `native_place` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '籍贯',
  `bank` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '银行',
  `back_account` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '银行账号',
  `back_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '开户行',
  `tax_address` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '纳税人地址',
  `corporation` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '工作单位',
  `creator` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '创建者',
  `editor` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '修改者',
  `customer_type_tag_id` int(11) NOT NULL COMMENT '客户类型',
  `create_at` timestamp(0) NOT NULL COMMENT '创建时间',
  `update_at` timestamp(0) NOT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  PRIMARY KEY (`tenement_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '附加信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for yhy_tenement_car
-- ----------------------------
DROP TABLE IF EXISTS `yhy_tenement_car`;
CREATE TABLE `yhy_tenement_car`  (
  `driver_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '车主自增id',
  `tenement_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '用户id',
  `space_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '车位编号',
  `plate` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '车牌号',
  `car_type_tag_id` int(11) NOT NULL COMMENT '车辆类型',
  `car_type` int(25) NOT NULL COMMENT '车辆型号',
  `car_type_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '车辆型号名称',
  `car_model` int(25) NOT NULL COMMENT '车型',
  `car_brand` int(25) NOT NULL COMMENT '车辆品牌',
  `car_brand_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '车辆品牌名称',
  `rule` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '月卡规则',
  `car_resource_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '资源id',
  `create_at` timestamp(0) NOT NULL COMMENT '创建时间',
  `update_at` timestamp(0) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`driver_id`) USING BTREE,
  UNIQUE INDEX `UK_plate_space`(`tenement_id`, `space_name`, `plate`) USING BTREE COMMENT '唯一索引'
) ENGINE = InnoDB AUTO_INCREMENT = 52 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for yhy_tenement_house
-- ----------------------------
DROP TABLE IF EXISTS `yhy_tenement_house`;
CREATE TABLE `yhy_tenement_house`  (
  `t_house_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `tenement_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '业主id',
  `cell_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT '0' COMMENT '室id',
  `house_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '房产id',
  `create_at` timestamp(0) NOT NULL COMMENT '创建时间',
  `update_at` timestamp(0) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`t_house_id`) USING BTREE,
  UNIQUE INDEX `UK_tene_house`(`tenement_id`, `house_id`, `cell_id`) USING BTREE COMMENT '唯一索引'
) ENGINE = InnoDB AUTO_INCREMENT = 97 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for yhy_tenement_label
-- ----------------------------
DROP TABLE IF EXISTS `yhy_tenement_label`;
CREATE TABLE `yhy_tenement_label`  (
  `label_id` int(11) NOT NULL AUTO_INCREMENT,
  `tenement_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '住户id',
  `tenement_tag_id` int(11) NOT NULL COMMENT '住户标签',
  `create_at` timestamp(0) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`label_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 112 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for yhy_users
-- ----------------------------
DROP TABLE IF EXISTS `yhy_users`;
CREATE TABLE `yhy_users`  (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户自增id',
  `project_id` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '项目id',
  `mobile` varchar(13) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '手机号',
  `autolock` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N' COMMENT '是否锁定',
  `verify` enum('Y','N') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'N' COMMENT '是否验证',
  `create_at` timestamp(0) NOT NULL COMMENT '创建时间',
  `update_at` timestamp(0) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 61 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for yhy_visitor
-- ----------------------------
DROP TABLE IF EXISTS `yhy_visitor`;
CREATE TABLE `yhy_visitor`  (
  `visit_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '访客id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `sfz_number` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '身份证号码',
  `real_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '真实姓名',
  `sex` int(11) NOT NULL COMMENT '性别',
  `project_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '项目id',
  `mobile` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '手机号',
  `appoint_time` int(11) NOT NULL COMMENT '预约时间',
  `is_man_face` enum('Y','N') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'N' COMMENT '是否人脸，默认\'N\'',
  `appoint_status_tag_id` int(11) NOT NULL COMMENT '预约状态',
  `face_resource_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '人脸id',
  `in_time` int(11) NOT NULL DEFAULT 0 COMMENT '进入时间',
  `out_time` int(11) NOT NULL DEFAULT 0 COMMENT '出去时间',
  `authorizer` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '授权人',
  `creator` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '创建者',
  `editor` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '修改者',
  `destination` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '目的地',
  `create_at` timestamp(0) NOT NULL COMMENT '创建时间',
  `update_at` timestamp(0) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`visit_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for yhy_visitor_car
-- ----------------------------
DROP TABLE IF EXISTS `yhy_visitor_car`;
CREATE TABLE `yhy_visitor_car`  (
  `visit_car_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '车主自增id',
  `visit_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '用户id',
  `plate` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '车牌号',
  `car_type_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '车辆型号名称',
  `car_type` int(11) NOT NULL COMMENT '车辆型号id',
  `car_brand` int(11) NOT NULL COMMENT '车辆品牌id',
  `car_brand_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '品牌名称',
  `car_model` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '车型',
  `create_at` timestamp(0) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`visit_car_id`) USING BTREE,
  UNIQUE INDEX `UK_visitor_plate`(`visit_id`, `plate`) USING BTREE COMMENT '唯一id'
) ENGINE = InnoDB AUTO_INCREMENT = 241 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for yhy_visitor_follow
-- ----------------------------
DROP TABLE IF EXISTS `yhy_visitor_follow`;
CREATE TABLE `yhy_visitor_follow`  (
  `follow_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '到访人员id',
  `visit_id` char(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '访客id',
  `follow_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '到访人员姓名',
  `follow_mobile` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT '到访人员手机号',
  `create_at` timestamp(0) NOT NULL COMMENT '到访时间',
  PRIMARY KEY (`follow_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 110 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
