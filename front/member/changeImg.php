<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("../../connect_chd104g3.php");
    $member_no = $_POST['member_no'];
    // 初始化$update_photo為false
    $update_photo = false;
    $member_photo = ""; // 初始化$member_photo

    if (isset($_FILES['memberImg']) && $_FILES['memberImg']['error'] == 0) {
        $target_dir = "../../../images/member/";
        // 確保目標目錄存在
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // 重新命名文件為 "member_{member_no}"
        $fileExtension = pathinfo($_FILES['memberImg']['name'], PATHINFO_EXTENSION);
        $newFileName = "member_" . $member_no . "." . $fileExtension;
        $target_file = $target_dir . $newFileName;

        if (move_uploaded_file($_FILES['memberImg']['tmp_name'], $target_file)) {
            $member_photo = $newFileName; // 保存新文件名到$member_photo
            $update_photo = true;
        } else {
            throw new Exception("檔案上傳失敗");
        }
    }
    // 修正SQL語句組合
    $sql = "UPDATE `members` SET " . ($update_photo ? "`member_photo` = :member_photo" : "") . " WHERE `member_no` = :member_no";

    $stmt = $pdo->prepare($sql);

    // 條件綁定member_photo參數
    if ($update_photo) {
        $stmt->bindParam(':member_photo', $member_photo);
    }
    // 總是綁定member_no參數
    $stmt->bindParam(':member_no', $member_no);

    $stmt->execute();

    $result = ["error" => false, "msg" => "更新成功"];
} catch (Exception $e) { // 更廣泛地捕獲異常
    $result = ["error" => true, "msg" => $e->getMessage()];
}

echo json_encode($result);
