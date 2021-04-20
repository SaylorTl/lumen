ALTER TABLE `yhy_visitor`
ADD COLUMN `space_id` char(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '空间id' AFTER `visitor_extra`;