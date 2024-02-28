<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("../../connect_chd104g3.php");

    // 從POST數據中獲取數據
    $quiz_no = $_POST['quiz_no'];
    $quiz_name = $_POST['quiz_name'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $quiz_ans = $_POST['quiz_ans'];
    $quiz_ans_info = $_POST['quiz_ans_info'];
    $quiz_status = $_POST['quiz_status'];

    // 初始化$update_photo為false
    $update_photo = false;
    $quiz_photo = ""; // 初始化$quiz_photo

    if (isset($_FILES['gameImg']) && $_FILES['gameImg']['error'] == 0) {
        $target_dir = "../../../images/game/";
        // 確保目標目錄存在
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // 重新命名文件為 "game_{quiz_no}"
        $fileExtension = pathinfo($_FILES['gameImg']['name'], PATHINFO_EXTENSION);
        $newFileName = "game_" . $quiz_no . "." . $fileExtension;
        $target_file = $target_dir . $newFileName;

        if (move_uploaded_file($_FILES['gameImg']['tmp_name'], $target_file)) {
            $quiz_photo = $newFileName; // 保存新文件名到$quiz_photo
            $update_photo = true;
        } else {
            throw new Exception("檔案上傳失敗");
        }
    }

    $sql = "UPDATE `quiz_game` SET 
            `quiz_name` = :quiz_name, 
            `option_a` = :option_a, 
            `option_b` = :option_b, 
            `option_c` = :option_c, 
            `option_d` = :option_d, 
            `quiz_ans` = :quiz_ans, 
            `quiz_ans_info` = :quiz_ans_info,
            `quiz_status` = :quiz_status" .
        ($update_photo ? ", `quiz_photo` = :quiz_photo" : "") .
        " WHERE `quiz_no` = :quiz_no";

    $stmt = $pdo->prepare($sql);

    // 綁定參數
    $stmt->bindParam(':quiz_name', $quiz_name);
    $stmt->bindParam(':option_a', $option_a);
    $stmt->bindParam(':option_b', $option_b);
    $stmt->bindParam(':option_c', $option_c);
    $stmt->bindParam(':option_d', $option_d);
    $stmt->bindParam(':quiz_ans', $quiz_ans);
    $stmt->bindParam(':quiz_ans_info', $quiz_ans_info);
    $stmt->bindParam(':quiz_status', $quiz_status);
    $stmt->bindParam(':quiz_no', $quiz_no);

    if ($update_photo) {
        $stmt->bindParam(':quiz_photo', $quiz_photo);
    }

    $stmt->execute();

    $result = ["error" => false, "msg" => "更新成功"];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

echo json_encode($result);
