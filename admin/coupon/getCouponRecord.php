<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("../../connect_chd104g3.php");
    $member_no = $_GET['member_no'];

    $sql = "SELECT cr.*, c.* FROM coupons_record cr
            JOIN coupons c ON cr.coupon_no = c.coupon_no
            WHERE cr.member_no = :member_no
            AND cr.coupon_use_status = 1";

    $couponRecore = $pdo->prepare($sql);
    $couponRecore->bindParam(':member_no', $member_no, PDO::PARAM_INT);
    $couponRecore->execute();

    $couponData = $couponRecore->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($couponData);
} catch (PDOException $e) {
    $msg .= "錯誤 : " . $e->getMessage() . "<br>";
    $msg .= "行號 : " . $e->getLine() . "<br>";
}
