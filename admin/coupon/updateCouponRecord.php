<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type:application/json;charset=utf-8");

try {

    require_once("../../connect_chd104g3.php");
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if($data === null){
        echo json_encode(["error" => true, "msg" => "No data received or JSON decoding failed"]);
        exit;
    }else{

        $sql = "UPDATE `coupons_record` 
                SET  `coupon_use_status` = 2
                WHERE `member_no` = :member_no 
                AND `record_no` = :record_no";
    
        $coupon = $pdo->prepare($sql);
    
        $coupon->bindValue(':member_no', $data['member_no']);
        $coupon->bindValue(':record_no', $data['record_no']);
    
        $coupon->execute();
    
        $result = ["error" => false, "msg" => "更新成功"];
    }
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}
echo json_encode($result);
