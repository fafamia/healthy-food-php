<?php
$host = "localhost";
$dbname = "food";
$user = "root";
$password = "";
$port = 3306;
$dsn = "mysql:host=localhost;port={$port};dbname=$dbname;charset=utf8";

$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_CASE => PDO::CASE_LOWER);

// 建立pdo物件
$pdo = new PDO($dsn, $user, $password, $options);
?>
