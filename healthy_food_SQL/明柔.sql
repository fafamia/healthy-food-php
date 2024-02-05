SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- 資料庫: `test`
CREATE DATABASE IF NOT EXISTS `test` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `test`;

-- --------------------------------------------------------
-- 商品 `product`
CREATE TABLE IF NOT EXISTS `product`(
    `product_no` int NOT NULL AUTO_INCREMENT,
    `product_class_no` int NOT NULL,
    `product_class_name` int NOT NULL,
    `product_tag_no` int NOT NULL,
    `product_tag_name` int NOT NULL,
    `product_name` varchar(20) NOT NULL,
    `product_info` varchar(200),
    `product_loc` varchar(20),
    `product_standard` varchar(50),
    `product_content` varchar(200),
    `product_price` int,
    `product_img` varchar(30) NOT NULL,
    `product_status` tinyint DEFAULT 2,
    PRIMARY KEY (`product_no`)
    FOREIGN KEY (`product_class_no`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `product`
(`product_name`,`product_info`,`product_loc`,`product_standard`,`product_content`,`product_price`,`product_img`,`product_status`)
VALUES
('南瓜蔬食調理包','這款調理包是忙碌生活中的完美選擇，主要以新鮮南瓜為基底，搭配多種營養豐富的蔬菜。方便快捷的料理方式，不僅省時也兼顧健康，適合素食者和尋求健康飲食的消費者。','桃園','300g/包','每份量： 100 克、熱量： 120 大卡、脂肪： 2 克、膽固醇： 60 毫克、鈉： 70 毫克、碳水化合物： 0 克','160','pumpkin_cover.png','2');

-- --------------------------------------------------------
-- 商品分類 `product_class`
CREATE TABLE IF NOT EXISTS `product_class`(
    `product_class_no` int NOT NULL AUTO_INCREMENT,
    `product_class_name` varchar(20) NOT NULL,
    PRIMARY KEY (`product_class_no`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `product_class`
(`product_class_name`)
VALUES
('調理包');

-- --------------------------------------------------------
-- 商品tag `product_tag`
CREATE TABLE IF NOT EXISTS `product_tag`(
    `product_tag_no` int NOT NULL AUTO_INCREMENT,
    `product_tag_name` varchar(20) NOT NULL,
    PRIMARY KEY (`product_tag_no`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `product_tag`
(`product_tag_name`)
VALUES
('NEW');

-- --------------------------------------------------------
-- 商品群組 `prodgroup_details`
CREATE TABLE IF NOT EXISTS `prodgroup`(
    `prodgroup_no` int NOT NULL AUTO_INCREMENT,
    `prodgroup_name` varchar(20) NOT NULL,
    `prodgroup_start` date,
    `prodgroup_end` date,
    PRIMARY KEY (`prodgroup_no`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `prodgroup`
(`prodgroup_name`,`prodgroup_start`,`prodgroup_end`)
VALUES
('首頁推薦商品','2024-02-06','2024-12-31');


-- 兩個PK都是要其他表格建立起來才有，這邊要怎麼設定??
-- --------------------------------------------------------
-- 商品群組明細 `prodgroup_details`
CREATE TABLE IF NOT EXISTS `prodgroup_details`(
    `prodgroup_no` int NOT NULL,
    `product_no` int NOT NULL,
    `prodgroup_name` varchar(20) NOT NULL,
    `prodgroup_sale_price` int,
    PRIMARY KEY (`prodgroup_no`,`product_no`),
    FOREIGN KEY (`prodgroup_no`) REFERENCES `prodgroup`(`prodgroup_no`),
    FOREIGN KEY (`product_no`) REFERENCES `product`(`product_no`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
