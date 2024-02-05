SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `food` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `food`;

-- -------------------莘慈-----------------------
-- 訂單 `orders`
CREATE TABLE `orders`(
`ord_no` int,
`user_no` int NOT NULL,
`ord_time` datetime NOT NULL,
`ord_name` varchar(20) NOT NULL DEFAULT '',
`take_name` varchar(20) NOT NULL DEFAULT '',
`take_mail` varchar(20) NOT NULL DEFAULT '',
`take_tel` varchar(10) NOT NULL DEFAULT '',
`take_address` varchar(100) NOT NULL DEFAULT '',
`ord_shipping` tinyint NOT NULL DEFAULT '1',
`payment_status` tinyint NOT NULL DEFAULT '1',
`ord_status` tinyint NOT NULL DEFAULT '1',
`delivery_fee` int,
`ord_amount` int NOT NULL,
`sales_amount` int,
`ord_payment` int NOT NULL,
`user_sales` DECIMAL (3,2),
PRIMARY KEY (`ord_no`),
foreign key(`user_no`)references members(`member_no`),
unique key(`ord_no`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `orders`(`ord_no`,`user_no`,`ord_time`,`ord_name`,`take_name`,`take_mail`,`take_tel`,`take_address`,
`ord_shipping`,`payment_status`,`ord_status`,`delivery_fee`,`ord_amount`,`sales_amount`,`ord_payment`,`user_sales`)VALUES
(CONVERT(UNIX_TIMESTAMP(NOW(6)), SIGNED),1,NOW(),'王小名','王小名','aabbcc@test.com',0988123456,'桃園市中壢區成功路88號',1,1,1,60,3000,
10,2745,0.9);

-- 訂單明細 `order_details`
CREATE TABLE `order_details`(
`ord_details_no` int AUTO_INCREMENT NOT NULL,
`ord_no` int NOT NULL,
`product_no` int NOT NULL,
`product_name` varchar(20) NOT NULL DEFAULT '',
`purchase_count` int NOT NULL,
`purchase_price` int NOT NULL,
PRIMARY KEY (`ord_details_no`),
FOREIGN KEY (`ord_no`) REFERENCES `orders`(`ord_no`),
FOREIGN KEY (`product_no`) REFERENCES `product`(`product_no`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `order_details`(
`ord_no`,`product_no`,`product_name`,`purchase_count`,`purchase_price`)VALUES
(231231182410,1001,'南瓜蔬食調理包',1,330);

-- 商品我的最愛 `favorite`
CREATE TABLE `favorite`(
`favorite_no` int AUTO_INCREMENT NOT NULL,
`user_no` int NOT NULL,
`product_no` int NOT NULL,
`product_name` varchar(20) NOT NULL DEFAULT '',
PRIMARY KEY (`favorite_no`),
foreign key(`user_no`)references members(`member_no`),
FOREIGN KEY (`product_no`) REFERENCES `product`(`product_no`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `favorite`(
`user_no`,`product_no`,`product_name`)VALUES
(1,1001,'南瓜蔬食調理包');

-- 首頁推薦商品 `featured_product`
CREATE TABLE `featured_product`(
`featured_product_no` int AUTO_INCREMENT NOT NULL,
`product_no` int NOT NULL,
PRIMARY KEY (`featured_product_no`),
FOREIGN KEY (`product_no`) REFERENCES `product`(`product_no`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `featured_product`(
`product_no`)VALUES
(1001);
