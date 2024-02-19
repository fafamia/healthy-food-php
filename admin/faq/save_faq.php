<?php
// 設定 Content-Type 為 application/x-www-form-urlencoded
header("Content-Type: application/x-www-form-urlencoded");
// 設定 CORS 標頭，允許從任何來源進行跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// 引入數據庫連接文件
require_once("../../connect_chd104g3.php");

// 檢查請求方法是否為 POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 檢查是否接收到了標題和圖片檔案
    if (isset($_POST['question_class']) && isset($_POST['question']) && isset($_POST['ans']) && isset($_POST['key'])) {
        error_log('Received question_class: ' . $_POST['question_class']);
        // 獲取標題
        $question_class = $_POST['question_class'];
        $question = $_POST['question'];
        $ans = $_POST['ans'];
        $key = $_POST['key'];

        try {
            // 在插入之前，通過 question_class 獲取 faq_class
            $checkQuery = $pdo->prepare("SELECT * FROM question_class WHERE question_class = :question_class");
            $checkQuery->bindParam(':question_class', $question_class);
            $checkQuery->execute();

            if ($checkQuery->rowCount() > 0) {
                // question_class 已存在，可以插入 faq 資料
                $result = $checkQuery->fetch(PDO::FETCH_ASSOC);
                $faq_class = $result['question_no']; // 使用 question_no，這是 question_class 的主鍵

                $query = $pdo->prepare("INSERT INTO `faq` (`faq_class`, `question`, `ans`, `key`) VALUES (:faq_class, :question, :ans, :key)");
                $query->bindParam(':faq_class', $faq_class);
                $query->bindParam(':question', $question);
                $query->bindParam(':ans', $ans);
                $query->bindParam(':key', $key);
                $query->execute();
                echo json_encode(['success' => true, 'message' => '保存成功']);
            } else {
                $errorMessage = '保存失败: question_class 不存在';
                echo json_encode(['success' => false, 'message' => $errorMessage]);
                error_log($errorMessage); // 将错误信息记录到 PHP 错误日志中
            }
        } catch (PDOException $e) {
            $errorMessage = '保存失敗: ' . $e->getMessage();
            echo json_encode(['success' => false, 'message' => $errorMessage]);
            error_log($errorMessage);
        }
    } else {
        echo json_encode(['error' => 'POST資料缺少']);
    }
}
?>
