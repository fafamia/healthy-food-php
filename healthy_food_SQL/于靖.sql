-- ---------------------于靖-----------------------

-- 首頁 Banner輪播 `banner_carousel`

DROP TABLE IF EXISTS `banner_carousel`;
CREATE TABLE IF NOT EXISTS `banner_carousel` (
  `carousel_no` int NOT NULL AUTO_INCREMENT,
  `banner_title` varchar(100) NOT NULL DEFAULT '',
  `banner_image` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`carousel_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `banner_carousel` (`banner_title`, `banner_image`) VALUES
('嚴選有機食材<br>為您和家人打造營養均衡的每一餐', 'banner01.jpg');

-- 後臺管理員 `webmaster`

DROP TABLE IF EXISTS `webmaster`;
CREATE TABLE IF NOT EXISTS `webmaster` (
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
