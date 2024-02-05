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

