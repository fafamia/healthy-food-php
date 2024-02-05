-- ---------------------佳容-----------------------
-- 熱門食譜
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+08:00";

CREATE DATABASE IF NOT EXISTS `food` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `food`;

-- 熱門食譜

DROP TABLE IF EXISTS `recipe`;
CREATE TABLE `recipe`(
	`recipe_no` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `recipe_class_no` INT NOT NULL,
    `project_no` INT,
    `recipe_name` VARCHAR(20),
    `recipe_recommend` VARCHAR(20),
    `recipe_people` VARCHAR(10),
    `recipe_time` VARCHAR(10),
    `recipe_ingredient` VARCHAR(300),
    `recipe_info` VARCHAR(500),
    `recipe_img` VARCHAR(20),
    `recipe_creation_time` DATETIME,
    `recipe_posting_time` DATETIME,
    `recipe_status` TINYINT,
    `recipe_like` INT,
    `comment_num` INT,
    
    FOREIGN KEY (recipe_class_no) REFERENCES recipe_class(recipe_class_no),
    FOREIGN KEY (project_no) REFERENCES project(project_no)
);

INSERT INTO `recipe` (`recipe_name`,`recipe_recommend`,`recipe_people`,`recipe_time`,`recipe_ingredient`,`recipe_info`,`recipe_img`)VALUES
('素食彩虹沙拉',
'萵苣',
'四人份',
'20分鐘',
'生菜葉（任選擇的種類），洗淨切碎
紅椒、黃椒、橙椒，切絲
黃瓜，切薄片
紫甘藍，切碎
胡蘿蔔，切絲或用刨絲器刨成薄片
紅洋蔥, 切絲
紅蘿蔔，刨成絲
玉米粒，瀝乾
青豆，瀝乾
義大利香草醬（或橄欖油和新鮮檸檬汁混合）
鹽和黑胡椒調味',
'1.在大碗中，將生菜葉鋪成一層底座。
2.依序在生菜葉上放置紅、橙、黃椒絲，形成彩虹的紅橙黃顏色。
3.在椒類的一側加入黃瓜薄片，再在另一側加入切碎的紫甘藍。
4.在沙拉的一端，加入胡蘿蔔絲，繼續排列。
5.在另一端加入紅洋蔥絲和紅蘿蔔絲，形成沙拉的彩虹結構。
6.將玉米粒和青豆均勻撒在整個沙拉上。
7.淋上義大利香草醬，或者使用橄欖油和檸檬汁混合調味。
8.輕輕拌勻，確保每一個蔬菜都均勻裹上醬汁。
9.依照口味加入適量的鹽和黑胡椒調味。
10.即可享用美味的素食彩虹沙拉！',
'cookbook01.jpg');

-- 食譜分類

DROP TABLE IF EXISTS `recipe_class`;
CREATE TABLE `recipe_class`(
	`recipe_class_no` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `recipe_class_name` VARCHAR(20)
);

INSERT INTO `recipe_class`(`recipe_class_name`) VALUES
('素食');

-- 我的收藏

DROP TABLE IF EXISTS `recipe_bookmark`;
CREATE TABLE `recipe_bookmark`(
	`recipe_bookmark_no` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_no` INT NOT NULL,
    `recipe_no` INT NOT NULL,
    
    FOREIGN KEY (user_no) REFERENCES users(user_no),
    FOREIGN KEY (recipe_no) REFERENCES recipe(recipe_no)
);

-- 食譜留言

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment`(
	`comment_no` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_no` INT NOT NULL,
    `recipe_no` INT NOT NULL,
    `comment_info` VARCHAR(500),
    `comment_time` DATETIME,
    `comment_like` INT,
    `comment_status` TINYINT,
    
    FOREIGN KEY (user_no) REFERENCES users(user_no),
    FOREIGN KEY (recipe_no) REFERENCES recipe(recipe_no)
);

-- 檢舉留言

DROP TABLE IF EXISTS `report`;
CREATE TABLE `report`(
	`report_no` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_no` INT NOT NULL,
    `comment_no` INT NOT NULL,
    `report_info` VARCHAR(200),
    `report_time` DATETIME,
    `report_status` TINYINT,
    
    FOREIGN KEY (user_no) REFERENCES users(user_no),
    FOREIGN KEY (comment_no) REFERENCES comment(comment_no)
);