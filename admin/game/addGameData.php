<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("../../connect_chd104g3.php");
    $sql = "INSERT INTO `quiz_game` (`quiz_name`, `option_a`, `option_b`, `option_c`, `option_d`, `quiz_ans`, `quiz_ans_info`, `quiz_photo`, `quiz_status`) VALUES (:quiz_name, :option_a, :option_b, :option_c, :option_d, :quiz_ans, :quiz_ans_info, :quiz_photo, :quiz_status)";

    $game = $pdo->prepare($sql);
    // 綁定數據
    $game->bindValue(":quiz_name", $_POST['quiz_name']);
    $game->bindValue(":option_a", $_POST['option_a']);
    $game->bindValue(":option_b", $_POST['option_b']);
    $game->bindValue(":option_c", $_POST['option_c']);
    $game->bindValue(":option_d", $_POST['option_d']);
    $game->bindValue(":quiz_ans", $_POST['quiz_ans']);
    $game->bindValue(":quiz_ans_info", $_POST['quiz_ans_info']);
    $game->bindValue(":quiz_status", $_POST['quiz_status']);

    if (isset($_FILES["quiz_photo"]) && $_FILES["quiz_photo"]["error"] === 0) {
        $dir = "../../../images/game/"; // 指定存儲上傳圖片的目錄
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true); // 如果目錄不存在，則創建資料夾
        }
        //取得檔案名（不含副檔名）
        $fileName = pathinfo($_FILES["quiz_photo"]["name"], PATHINFO_FILENAME);
        //取得副檔名
        $fileExt = pathinfo($_FILES["quiz_photo"]["name"], PATHINFO_EXTENSION);
        //組合新的檔案名
        $newFileName = $fileName . '.' . $fileExt;
        $from = $_FILES["quiz_photo"]["tmp_name"]; // 暫存檔案名稱
        $to = $dir . $newFileName; // 目標檔案名稱

        if (move_uploaded_file($from, $to)) { // 移動檔案到指定目錄
            // 使用move_uploaded_file而不是copy，因為它在移動上傳的檔案時更安全

            $game->bindValue(":quiz_photo", $newFileName); // 如果上傳成功，將新檔案名指派給變量，以便後續存儲到數據庫
        } else {
            $game->bindValue(":quiz_photo", ''); // 如果上傳失敗，將檔案名設置為空字串
        }
    } else {
        $game->bindValue(":quiz_photo", ''); // 如果沒有檔案被上傳或檔案上傳出錯，也設置為空字串
    }

    $game->execute(); //執行

    $result = ["error" => false, "msg" => "新增成功", "game" => $game];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}
//輸出結果
echo json_encode($result);
