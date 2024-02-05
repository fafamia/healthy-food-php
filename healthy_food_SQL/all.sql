SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+08:00";

CREATE DATABASE IF NOT EXISTS `food` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `food`;

---------------------于靖-----------------------

-- 首頁 Banner輪播 `banner_carousel`

CREATE TABLE IF NOT EXISTS `banner_carousel` (
  `carousel_no` int NOT NULL AUTO_INCREMENT,
  `banner_title` varchar(100) NOT NULL DEFAULT '',
  `banner_image` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`carousel_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `banner_carousel` (`banner_title`, `banner_image`) VALUES
('嚴選有機食材<br>為您和家人打造營養均衡的每一餐', 'banner01.jpg');

-- 後臺管理員 `webmaster`

CREATE TABLE `webmaster` (
  `master_no` int NOT NULL AUTO_INCREMENT,
  `master_name` varchar(50) NOT NULL,
  `master_account` varchar(10) NOT NULL,
  `master_password` varchar(16) NOT NULL,
  `master_email` varchar(50) NOT NULL,
  PRIMARY KEY (`master_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `webmaster` 
(`master_name`, `master_account`, `master_password`, `master_email`) VALUES
('于靖', 'bill6217', 'pmes6217', 'dis90503dis@gmail.com');


---------------------培英-----------------------
-- 會員等級 
CREATE TABLE IF NOT EXISTS `member_level` ( 
`level_no` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`level_name` VARCHAR(10) NOT NULL,
`total_spend_start` INT NOT NULL,
`total_spend_end` INT NOT NULL,
`level_discount` DECIMAL(3,2)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- 新增會員等級資料
INSERT INTO  `member_level`(`level_name`, `total_spend_start`, `total_spend_end`,`level_discount`)
VALUES ('一般會員' , 0 , 2999 , NULL),
       ('黃金會員',3000,4999,NULL),
	   ('白金會員',5000,7999,0.95),
	   ('鑽石會員',8000,99999999,0.88);

-- 會員 
CREATE TABLE IF NOT EXISTS `members` (
`member_no` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`member_level` INT NOT NULL,
`member_password` VARCHAR(12) NOT NULL,
`member_name` VARCHAR(30) NOT NULL,
`member_email` VARCHAR(50) NOT NULL,
`member_tel` VARCHAR(10) NOT NULL,
`member_birth` DATE,
`member_county` VARCHAR(10) NOT NULL,
`member_city` VARCHAR(10) NOT NULL,
`member_addr` VARCHAR(100) NOT NULL,
`member_total_amount` INT,
`member_time` DATETIME NOT NULL,
`member_photo` VARCHAR(20) DEFAULT 'member_1',
`member_status` TINYINT,
CONSTRAINT fk_members_member_level FOREIGN KEY(member_level) REFERENCES member_level(level_no)
)ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- 新增會員資料 
INSERT INTO `members` (`member_level`, `member_password`, `member_name`, `member_email`, `member_tel`, `member_birth`, `member_county`, `member_city`, `member_addr`, `member_total_amount`, `member_time`, `member_photo`, `member_status`)
VALUES
(1, 'chd104g3', '王小明', 'aa@example.com', '0912345678', '1990-01-01', '台北市', '中正區', '忠孝西路100號', 2000, NOW(), 'member_1.jpg', 1),
(2, 'chd104g3', '李小美', 'bb@example.com', '0912345679', '1992-02-02', '新北市', '板橋區', '文化路一段1號', 3500, NOW(), 'member_2.jpg', 1),
(3, 'chd104g3', '張小芳', 'cc@example.com', '0912345670', '1988-03-03', '桃園市', '中壢區', '中大路1號', 6000, NOW(), 'member_3.jpg', 1),
(4, 'chd104g3', '劉小星', 'dd@example.com', '0912345671', '1995-04-04', '台中市', '西區', '台灣大道二段2號', 10000, NOW(), 'member_1.jpg', 1);

-- 折價券
CREATE TABLE IF NOT EXISTS `coupons`(
`coupon_no` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`ans_num` INT NOT NULL,
`coupon_value` INT NOT NULL,
`coupon_valid_days` INT NOT NULL,
`coupon_status` TINYINT,
`coupon_content` VARCHAR(100)
)ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- 新增折價券資料 
INSERT INTO `coupons` (`ans_num`, `coupon_value`, `coupon_valid_days`, `coupon_status`, `coupon_content`)
VALUES
(3, 10, 60, 1, '健康知識大挑戰答對3題，享折扣10元優惠'),
(4, 20, 60, 1, '健康知識大挑戰答對4題，享折扣20元優惠'),
(5, 30, 60, 1, '健康知識大挑戰答對5題，享折扣30元優惠');

-- 折價券發放紀錄
CREATE TABLE IF NOT EXISTS `coupons_record`(
    `record_no` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `member_no` INT NOT NULL,
    `coupon_no` INT NOT NULL,
    `coupon_use_date` DATE NOT NULL,
    `coupon_use_status` TINYINT,
    CONSTRAINT fk_coupons_record_member_no FOREIGN KEY(member_no) REFERENCES members(member_no),
    CONSTRAINT fk_coupons_record_coupon_no FOREIGN KEY(coupon_no) REFERENCES coupons(coupon_no) 
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- 新增發放紀錄資料
INSERT INTO `coupons_record` (`member_no`, `coupon_no`, `coupon_use_date`, `coupon_use_status`)
VALUES
(1, 1, CURDATE(), 0),
(2, 2, CURDATE(), 0);

-- 小遊戲題庫 
CREATE TABLE IF NOT EXISTS `quiz_game`(
`quiz_no` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
`quiz_name` VARCHAR(100) NOT NULL,
`option_a` VARCHAR(50) NOT NULL,
`option_b` VARCHAR(50) NOT NULL,
`option_c` VARCHAR(50) NOT NULL,
`option_d` VARCHAR(50) NOT NULL,
`quiz_ans` VARCHAR(10) NOT NULL,
`quiz_ans_info` VARCHAR(200) NOT NULL,
`quiz_photo` VARCHAR(20) NOT NULL,
`quiz_status` TINYINT
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

-- 新增小遊戲題庫資料 
INSERT INTO quiz_game (quiz_name, option_a, option_b, option_c, option_d, quiz_ans, quiz_ans_info, quiz_photo, quiz_status) VALUES 
('當您想要攝取更多的鈣質，以下哪種食物是不錯的選擇？', '鳳梨', '西瓜', '蘋果', '豆腐', '豆腐', '豆腐是優質植物蛋白來源，含豐富礦物質如鈣、鐵，低飽和脂肪，有益心血管健康。富含維生素B群和植物雌激素，是低熱量、營養均衡的食品，對腸道和骨骼健康有益。', 'game_1.jpg', 1),
('什麼是BMI的全稱？', '體重多重指數', '肌肉質量指數', '人體質量指數', '營養狀態指數', '人體質量指數', 'BMI是人體質量指數的縮寫，用於評估一個人的體重是否在健康範圍內。', 'game_2.jpg', 1),
('哪種維生素有助於增強免疫系統？', '維生素A', '維生素B6', '維生素C', '維生素D', '維生素C', '維生素C有助於增強免疫系統，有助於抵抗感染。', 'game_3.jpg', 1),
('什麼食物富含omega-3脂肪酸，對心臟健康有益？', '牛肉', '魚類', '豬肉', '雞肉', '魚類', '魚類是富含omega-3脂肪酸的食物，對心臟健康有益。', 'game_4.jpg', 1),
('什麼是維生素D的主要來源？', '陽光', '蘋果', '牛奶', '西瓜', '陽光', '維生素D的主要來源之一是陽光，皮膚暴露於陽光下可以合成維生素D。', 'game_5.jpg', 1),
('哪種食物含有大量的纖維，有助於促進消化健康？', '巧克力', '白麵包', '燕麥', '薯條', '燕麥', '燕麥含有大量的纖維，有助於促進消化健康。', 'game_6.jpg', 1),
('哪種飲食模式強調攝取大量蔬菜、水果和全穀物？', '生魚片飲食', '紅肉飲食', '地中海飲食', '快餐飲食', '地中海飲食', '地中海飲食模式強調攝取大量蔬菜、水果和全穀物，有益健康。', 'game_7.jpg', 1),
('什麼食物是富含抗氧化劑的良好來源，有助於對抗自由基？', '高糖食品', '高脂肪食品', '油炸食品', '水果和蔬菜', '水果和蔬菜', '水果和蔬菜是富含抗氧化劑的良好來源，有助於對抗自由基損害。', 'game_8.jpg', 1),
('哪種營養素在水果和蔬菜中豐富，有助於預防氧化損傷？', '鈣質', '抗氧化劑', '纖維', '脂肪', '抗氧化劑', '抗氧化劑在水果和蔬菜中豐富，有助於預防氧化損傷，保護細胞免受自由基損害。', 'game_9.jpg', 1),
('哪種食物是優質蛋白質的良好來源，有助於肌肉修復和生長？', '巧克力', '高糖食品', '紅肉', '雞胸肉', '雞胸肉', '雞胸肉是優質蛋白質的良好來源，有助於肌肉修復和生長。', 'game_10.jpg', 1);



---------------------佳容-----------------------
-- 熱門食譜

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

CREATE TABLE `recipe_class`(
	`recipe_class_no` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `recipe_class_name` VARCHAR(20)
);

INSERT INTO `recipe_class`(`recipe_class_name`) VALUES
('素食');

-- 我的收藏

CREATE TABLE `recipe_bookmark`(
	`recipe_bookmark_no` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `user_no` INT NOT NULL,
    `recipe_no` INT NOT NULL,
    
    FOREIGN KEY (user_no) REFERENCES users(user_no),
    FOREIGN KEY (recipe_no) REFERENCES recipe(recipe_no)
);

-- 食譜留言

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


---------------------明柔-----------------------

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


---------------------柏儒-----------------------

-- 常見問題分類
CREATE TABLE IF NOT EXISTS `question_class` (
  `question_no` INT NOT NULL AUTO_INCREMENT,
  `question_name` varchar(100),
  PRIMARY KEY (`question_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 常見問題
CREATE TABLE IF NOT EXISTS `faq` (
  `faq_no` INT NOT NULL AUTO_INCREMENT,
  `faq_class` INT NOT NULL,
  `ans` varchar(500),
  `question` varchar(200),
  `key` varchar(100),
  PRIMARY KEY (`faq_no`),
  FOREIGN KEY (`faq_class`) REFERENCES `question_class` (`question_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 專欄分類
CREATE TABLE IF NOT EXISTS `article_class` (
  `category_no` INT NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50),
  PRIMARY KEY (`category_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `article_class` (`category_name`) VALUES ('飲食');
-- 專欄總覽
CREATE TABLE IF NOT EXISTS `article_overview` (
  `article_no` INT NOT NULL AUTO_INCREMENT,
  `article_class` INT NOT NULL,
  `article_title` varchar(50),
  `article_description` varchar(200),
  `cover_photo` varchar(30),
  `content` datetime,
  `creation_time` datetime,
  PRIMARY KEY (`article_no`),
  FOREIGN KEY (`article_class`) REFERENCES `article_class` (`category_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `article_overview` (`article_class`, `article_title`, `cover_photo`) VALUES
(1, '飲食健康：探索均衡飲食的奧秘', 'article1.jpg');

-- 推薦專欄
CREATE TABLE IF NOT EXISTS `featured_columns` (
  `featured_no` INT NOT NULL AUTO_INCREMENT,
  `article_no` INT NOT NULL,
  PRIMARY KEY (`featured_no`),
  FOREIGN KEY (`article_no`) REFERENCES `article_overview` (`article_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


---------------------莘慈-----------------------

CREATE TABLE `ORDERS`(
`ORD_NO` int NOT NULL,
`USER_NO` int NOT NULL,
`ORD_TIME` datetime NOT NULL,
`ORD_NAME` varchar(20) NOT NULL DEFAULT '',
`TAKE_NAME` varchar(20) NOT NULL DEFAULT '',
`TAKE_MAIL` varchar(20) NOT NULL DEFAULT '',
`TAKE_TEL` varchar(10) NOT NULL DEFAULT '',
`TAKE_ADDRESS` varchar(100) NOT NULL DEFAULT '',
`ORD_SHIPPING` tinyint NOT NULL DEFAULT '1',
`PAYMENT_STATUS` tinyint NOT NULL DEFAULT '1',
`ORD_STATUS` tinyint NOT NULL DEFAULT '1',
`DELIVERY_FEE` int,
`ORD_AMOUNT` int NOT NULL,
`SALES_AMOUNT` int,
`ORD_PAYMENT` int NOT NULL,
`USER_SALES` DECIMAL (3,2),
PRIMARY KEY (`ORD_NO`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ORDERS`(`ORD_NO`,`USER_NO`,`ORD_TIME`,`ORD_NAME`,`TAKE_NAME`,`TAKE_MAIL`,`TAKE_TEL`,`TAKE_ADDRESS`,
`ORD_SHIPPING`,`PAYMENT_STATUS`,`ORD_STATUS`,`DELIVERY_FEE`,`ORD_AMOUNT`,`SALES_AMOUNT`,`ORD_PAYMENT`,`USER_SALES`)VALUES
(231231182410,1,'2023-12-31 18:24:10','王小名','王小名','aabbcc@test.com',0988123456,'桃園市中壢區成功路88號',1,1,1,60,3000,
10,2745,0.9);

CREATE TABLE `ORDER_DETAILS`(
`ORD_DETAILS_NO` int NOT NULL,
`ORD_NO` int NOT NULL,
`PRODUCT_NO` int NOT NULL,
`PRODUCT_NAME` varchar(20) NOT NULL DEFAULT '',
`PURCHASE_COUNT` int NOT NULL,
`PURCHASE_PRICE` int NOT NULL,
PRIMARY KEY (`ORD_DETAILS_NO`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ORDER_DETAILS`(
`ORD_DETAILS_NO`,`ORD_NO`,`PRODUCT_NO`,`PRODUCT_NAME`,`PURCHASE_COUNT`,`PURCHASE_PRICE`)VALUES
(1,231231182410,1001,'南瓜蔬食調理包',1,330);

create table `FAVORITE`(
`FAVORITE_NO`int NOT NULL,
`USER_NO`int NOT NULL,
`PRODUCT_NO`int NOT NULL,
`PRODUCT_NAME`varchar(20) NOT NULL DEFAULT '',
PRIMARY KEY (`FAVORITE_NO`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

insert into `FAVORITE`(
`FAVORITE_NO`,`USER_NO`,`PRODUCT_NO`,`PRODUCT_NAME`)VALUES
(1,1,1001,'南瓜蔬食調理包');

create table `FEATURED_PRODUCT`(
`FEATURED_PRODUCT_NO`int NOT NULL,
`PRODUCT_NO`int NOT NULL,
PRIMARY KEY (`FEATURED_PRODUCT_NO`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

insert into `FEATURED_PRODUCT`(
`FEATURED_PRODUCT_NO`,`PRODUCT_NO`)VALUES
(1,1001);


COMMIT;
