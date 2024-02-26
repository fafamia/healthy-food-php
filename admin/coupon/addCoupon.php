<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("../../connect_chd104g3.php");

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $sql = "INSERT INTO `coupons` (`ans_num`, `coupon_value`, `coupon_valid_days`, `coupon_status`, `coupon_content`) VALUES (:ans_num, :coupon_value, :coupon_valid_days, :coupon_status, :coupon_content)";

    $coupon = $pdo->prepare($sql);
    // 綁定數據
    $coupon->bindValue(':ans_num', $data['ans_num']);
    $coupon->bindValue(':coupon_value', $data['coupon_value']);
    $coupon->bindValue(':coupon_valid_days', $data['coupon_valid_days']);
    $coupon->bindValue(':coupon_status', $data['coupon_status']);
    $coupon->bindValue(':coupon_content', $data['coupon_content']);

    $coupon->execute(); //執行

    $result = ["error" => false, "msg" => "新增成功", "coupon" => $coupon];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}
//輸出結果
echo json_encode($result);
