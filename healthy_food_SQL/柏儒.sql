-- ---------------------柏儒-----------------------

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
