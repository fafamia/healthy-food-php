<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Credentials:true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type:application/json;charset=utf-8");

$data = json_decode(file_get_contents("php://input"), true);
$token = $data["storageToken"]; // 從解碼後的數據中獲取token

try {
    require_once("../../connect_chd104g3.php");

    $sql = "SELECT `member_no`, `member_level`, `member_name`, `member_email`, `member_tel`, `member_birth`, `member_county`, `member_city`, `member_addr`, `member_total_amount`, `member_time`, `member_photo`, `member_status` FROM members WHERE member_no = :token";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':token', $token);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // token有效
        $memberData = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(["message" => "登入成功", "status" => "success", "member" => $memberData]);
    } else {
        // token無效
        echo json_encode(["message" => "登入失敗", "status" => "error"]);
    }
} catch (PDOException $e) {
    echo json_encode([
        "message" => "數據庫錯誤: " . $e->getMessage(),
        "status" => "error",
        "line" => $e->getLine()
    ]);
}
