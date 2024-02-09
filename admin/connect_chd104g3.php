<?php
// $dbname = "tibamefe_chd104g3";
// $user = "tibamefe_since2021";
// $password = "vwRBSb.j&K#E";
// $port = 3306;
// $dsn = "mysql:host=localhost;port={$port};dbname=$dbname;charset=utf8";
// $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_CASE => PDO::CASE_LOWER);
// $pdo = new PDO($dsn, $user, $password, $options);




$host = "localhost";
$dbname = "food";
$user = "root";
$password = "";
$port = 3306;
$dsn = "mysql:host=localhost;port={$port};dbname=$dbname;charset=utf8";

$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_CASE => PDO::CASE_LOWER);


$pdo = new PDO($dsn, $user, $password, $options);


