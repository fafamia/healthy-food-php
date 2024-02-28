<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("../../connect_chd104g3.php");

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $member_no = $data['member_no'];
    $ans_num = $data['ans_num'];

    // 根據答對題數查詢對應的折價券編號及其有效天數
    $sql = "SELECT `coupon_no`, `coupon_valid_days` FROM `coupons` WHERE `ans_num` = :ans_num LIMIT 1";
    $coupon = $pdo->prepare($sql);
    $coupon->bindParam(':ans_num', $ans_num);
    $coupon->execute();

    if ($coupon->rowCount() > 0) {
        $row = $coupon->fetch(PDO::FETCH_ASSOC);
        $coupon_no = $row['coupon_no'];

        // 檢查該會員是否已經擁有該種折價券
        $sqlCheck = "SELECT * FROM `coupons_record` WHERE `member_no` = :member_no AND `coupon_no` = :coupon_no";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->bindParam(':member_no', $member_no);
        $stmtCheck->bindParam(':coupon_no', $coupon_no);
        $stmtCheck->execute();

        if ($stmtCheck->rowCount() == 0) {
            // 該會員尚未擁有該種折價券，可以進行添加
            $valid_days = $row['coupon_valid_days'];
            $coupon_use_date = date('Y-m-d', strtotime("+$valid_days days"));

            $sqlInsert = "INSERT INTO `coupons_record` (`member_no`, `coupon_no`, `coupon_use_date`, `coupon_use_status`) VALUES (:member_no, :coupon_no, :coupon_use_date, 1)";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->bindParam(':member_no', $member_no);
            $stmtInsert->bindParam(':coupon_no', $coupon_no);
            $stmtInsert->bindParam(':coupon_use_date', $coupon_use_date);
            $stmtInsert->execute();

            if ($stmtInsert->rowCount() > 0) {
                $result = ["success" => true, "msg" => "新增成功"];
            } else {
                $result = ["error" => true, "msg" => "新增失敗"];
            }
        } else {
            // 該會員已擁有該種折價券
            $result = ["error" => true, "msg" => "每種折價券每位會員只能擁有一張"];
        }
    } else {
        $result = ["error" => true, "msg" => "沒有折價券"];
    }
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

// 輸出結果
echo json_encode($result);
