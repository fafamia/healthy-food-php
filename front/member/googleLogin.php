<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); // 确保这里的域名与前端应用匹配，且没有尾随斜线
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header("Content-Type:application/json;charset=utf-8");


$member_email = $_POST["member_email"];
$member_name = $_POST["member_name"];

$errMsg = "";
try {
    require_once("../../connect_chd104g3.php");

    // 檢查用戶是否已存在
    $sql = "SELECT * FROM `members` WHERE member_email=:member_email";
    $member = $pdo->prepare($sql);
    $member->bindValue(":member_email", $member_email);
    $member->execute();

    if ($member->rowCount() == 0) { // 用戶不存在，創建新用戶
        // 插入新用戶數據，包括默認密碼 'aa0000'
        $sqlInsert = "INSERT INTO `members` (
            `member_level`, `member_name`, `member_email`, `member_password`, `member_tel`, 
            `member_county`, `member_city`, `member_addr`, `member_time`, `member_status`
        ) VALUES (
            1, :member_name, :member_email, 'aa0000', '09xxxxxxxx', 
            '臺北市', '大安區', '請填入地址', NOW(), 1
        )";
        $memInsert = $pdo->prepare($sqlInsert);
        $memInsert->bindValue(":member_name", $member_name);
        $memInsert->bindValue(":member_email", $member_email);
        $memInsert->execute();

        $newMemberId = $pdo->lastInsertId();

        // 獲取並返回新創建的用戶信息（不包括密碼）
        $sqlNewMember = "SELECT `member_no`, `member_level`, `member_name`, `member_email`, `member_tel`, `member_birth`, `member_county`, `member_city`, `member_addr`, `member_total_amount`, `member_time`, `member_photo`, `member_status` FROM `members` WHERE member_no = :newMemberId";
        $stmtNewMember = $pdo->prepare($sqlNewMember);
        $stmtNewMember->bindValue(":newMemberId", $newMemberId);
        $stmtNewMember->execute();
        $newMemberInfo = $stmtNewMember->fetch(PDO::FETCH_ASSOC);

        echo json_encode(["message" => "新用戶創建成功，登入成功", "status" => "success", "member" => $newMemberInfo]);
    } else {
        // 用戶已存在，獲取並返回用戶信息（不包括密碼）
        $existingMemberInfo = $member->fetch(PDO::FETCH_ASSOC);
        unset($existingMemberInfo['member_password']); // 移除密碼字段
        echo json_encode(["message" => "用戶已存在，登入成功", "status" => "success", "member" => $existingMemberInfo]);
    }
} catch (PDOException $e) {
    $errMsg = "錯誤 : " . $e->getMessage() . "<br>";
    $errMsg .= "行號 : " . $e->getLine() . "<br>";
    echo json_encode(["message" => $errMsg, "status" => "error"]);
}
