<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type:application/json;charset=utf-8");

try {

    require_once("../../connect_chd104g3.php");
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $sql = "UPDATE `coupons` SET  `ans_num` = :ans_num, 
    `coupon_value` = :coupon_value, 
    `coupon_valid_days` = :coupon_valid_days, 
    `coupon_status` = :coupon_status,
    `coupon_content` = :coupon_content
    WHERE `coupon_no` = :coupon_no";

    $coupon = $pdo->prepare($sql);

    $coupon->bindParam(':ans_num', $data['ans_num']);
    $coupon->bindParam(':coupon_value', $data['coupon_value']);
    $coupon->bindParam(':coupon_valid_days', $data['coupon_valid_days']);
    $coupon->bindParam(':coupon_status', $data['coupon_status']);
    $coupon->bindParam(':coupon_content', $data['coupon_content']);
    $coupon->bindParam(':coupon_no', $data['coupon_no']);

    $coupon->execute();

    $result = ["error" => false, "msg" => "更新成功"];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}
echo json_encode($result);
