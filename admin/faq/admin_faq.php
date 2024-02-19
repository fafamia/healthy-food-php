<?php
// 允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// 引入資料庫連接
require_once("../../connect_chd104g3.php");

// 檢查請求方法是否為 POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 加入這行用於記錄 question_class 的值
    error_log('Received question_class in admin_faq.php: ' . $_POST['question_class']);
    
    // 檢查是否接收到了標題和圖片檔案
    if (isset($_POST['question_class']) && isset($_POST['question']) && isset($_POST['ans']) && isset($_POST['key'])) {
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
                error_log($errorMessage); // 將錯誤信息記錄到 PHP 錯誤日誌中
            }
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => '保存失败: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'POST資料缺少']);
    }
} else { // 如果不是 POST 請求，執行查詢和回傳資料
    try {
        // 準備 SQL 查詢語句，選擇所有 faq 表格中的欄位
        $sql = "SELECT faq_no, faq_class, ans, question FROM faq";
        // SQL 查詢
        $stmt = $pdo->prepare($sql);
        // 如果執行成功，execute()不會返回任何值 有錯誤發生會拋出一個 PDOException 
        $stmt->execute();
        // 檢索所有結果行，將其存儲為關聯數組    fetchAll() 是 PDO 的一個方法 返回包含所有結果行的陣列。
        // PDO::FETCH_ASSOC 是 fetchAll() 方法的一個參數，它指定返回的每一行資料都以關聯數組的形式返回。在這個參數的作用下，每一行的鍵名就是資料庫欄位的名稱，對應的值就是該欄位的值。
        $faq = $stmt->fetchAll(PDO::FETCH_ASSOC); 
        // 設置 HTTP 響應標頭為 JSON 格式       Content-Type 標頭指定了響應內容的類型。
        header('Content-Type: application/json');
        // 將 PHP 數組轉換為 JSON 並輸出到前端
        echo json_encode($faq);
        // 捕獲可能在 try 塊中拋出的 PDOException $e
    } catch (PDOException $e) {
        // 如果發生 PDOException，則捕獲異常並輸出錯誤消息
        echo "Error: " . $e->getMessage();
    }
}

// 關閉資料庫連接
$pdo = null;
?>
