-- ---------------------柏儒-----------------------

-- 常見問題分類
CREATE TABLE IF NOT EXISTS `question_class` (
  `question_no` INT NOT NULL AUTO_INCREMENT,
  `question_class` varchar(100),
  PRIMARY KEY (`question_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `question_class` ADD INDEX (`question_class`);
INSERT INTO `question_class` (`question_class`) VALUES ('付款問題');

-- 常見問題
CREATE TABLE IF NOT EXISTS `faq` (
  `faq_no` INT NOT NULL AUTO_INCREMENT,
  `faq_class` varchar(100) NOT NULL,
  `ans` varchar(500),
  `question` varchar(200),
  `key` varchar(100),
  PRIMARY KEY (`faq_no`),
  FOREIGN KEY (`faq_class`) REFERENCES `question_class` (`question_class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `faq` (`question`, `faq_class`, `ans`, `key`) VALUES
('如何付款?', '付款問題', '1.信用卡即時線上一次刷卡付款<br>2.ATM付款<br>3.LINE Pay', 
'付款'
);
INSERT INTO `faq` (`question`, `faq_class`, `ans`, `key`) VALUES
('運費怎麼計算？可以合併運費嗎？', '付款問題', '運費的計算方式取決於購物車中的商品總重量、運送地址、所選擇的運送方式等因素。我們的網站提供了標準運費，同時在特定條件下，購物滿額可能享有免運費優惠。您可以在結帳頁面查看確切的運費金額。
合併運費方面，我們很抱歉目前無法提供此服務。每筆訂單的運費是根據購物車中商品的總重量計算的。', 
'運費'
);

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
