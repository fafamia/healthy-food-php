<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("../../connect_chd104g3.php");
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // 從請求中獲取會員編號和密碼
    $member_no = $data['member_no'];
    $oldPassword = $data['oldPassword'];
    $newPassword = $data['newPassword'];

    // 查詢舊密碼
    $sql = "SELECT `member_password` FROM `members` WHERE `member_no` = :member_no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':member_no', $member_no);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $hashed_password = $row['member_password'];

        // 驗證舊密碼
        if ($oldPassword == $hashed_password) {
            // 更新密碼
            $updateSql = "UPDATE `members` SET `member_password` = :newPassword WHERE `member_no` = :member_no";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->bindValue(':newPassword', $newPassword);
            $updateStmt->bindValue(':member_no', $member_no);

            if ($updateStmt->execute()) {
                $result = ["error" => false, "msg" => "密碼更新成功"];
            } else {
                $result = ["error" => true, "msg" => "密碼更新失敗"];
            }
        } else {
            $result = ["error" => true, "msg" => "舊密碼不正確"];
        }
    } else {
        $result = ["error" => true, "msg" => "找不到該會員"];
    }
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

echo json_encode($result);
