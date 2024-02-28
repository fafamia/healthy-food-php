<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("../../connect_chd104g3.php");

    // 首先插入题目信息（不包括图片）
    $sql = "INSERT INTO `quiz_game` (`quiz_name`, `option_a`, `option_b`, `option_c`, `option_d`, `quiz_ans`, `quiz_ans_info`, `quiz_status`) VALUES (:quiz_name, :option_a, :option_b, :option_c, :option_d, :quiz_ans, :quiz_ans_info, :quiz_status)";
    $game = $pdo->prepare($sql);

    // 绑定数据
    $game->bindValue(":quiz_name", $_POST['quiz_name']);
    $game->bindValue(":option_a", $_POST['option_a']);
    $game->bindValue(":option_b", $_POST['option_b']);
    $game->bindValue(":option_c", $_POST['option_c']);
    $game->bindValue(":option_d", $_POST['option_d']);
    $game->bindValue(":quiz_ans", $_POST['quiz_ans']);
    $game->bindValue(":quiz_ans_info", $_POST['quiz_ans_info']);
    $game->bindValue(":quiz_status", $_POST['quiz_status']);

    $game->execute();

    // 获取自增ID（quiz_no）
    $quiz_no = $pdo->lastInsertId();

    if (isset($_FILES["quiz_photo"]) && $_FILES["quiz_photo"]["error"] === 0) {
        $dir = "../../../images/game/";
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        // 文件扩展名
        $fileExt = pathinfo($_FILES["quiz_photo"]["name"], PATHINFO_EXTENSION);
        // 根据 quiz_no 构造新文件名
        $newFileName = "game_" . $quiz_no . '.' . $fileExt;
        $from = $_FILES["quiz_photo"]["tmp_name"];
        $to = $dir . $newFileName;

        if (move_uploaded_file($from, $to)) {
            // 更新数据库记录以包含图片文件名
            $sqlUpdate = "UPDATE `quiz_game` SET `quiz_photo` = :quiz_photo WHERE `quiz_no` = :quiz_no";
            $updateStmt = $pdo->prepare($sqlUpdate);
            $updateStmt->bindValue(":quiz_photo", $newFileName);
            $updateStmt->bindValue(":quiz_no", $quiz_no);
            $updateStmt->execute();
        }
    }

    $result = ["error" => false, "msg" => "新增成功", "game" => $game];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}
//輸出結果
echo json_encode($result);
