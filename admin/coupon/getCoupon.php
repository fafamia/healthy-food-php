<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("../../connect_chd104g3.php");
    $sql = "SELECT * FROM coupons";
    $coupon = $pdo->prepare($sql);
    $coupon->execute();

    $couponData = $coupon->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($couponData);
} catch (PDOException $e) {
    $msg .= "錯誤 : " . $e->getMessage() . "<br>";
    $msg .= "行號 : " . $e->getLine() . "<br>";
}
