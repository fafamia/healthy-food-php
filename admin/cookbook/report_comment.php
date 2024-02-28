<?php
try {
    header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');
require_once("../../connect_chd104g3.php");

// 檢查請求方法是否為 POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 檢查是否接收到了檢舉相關的數據
    if (isset($_POST['user_no']) && isset($_POST['comment_no']) && isset($_POST['report_info'])){
        // 從 POST 請求中獲取檢舉相關的數據
        $commentId = $_POST['user_no'];
        $content = $_POST['comment_no'];
        $info = $_POST['report_info'];
        

        // 在這裡執行將檢舉數據保存到數據庫的代碼
        // 這裡僅為示例，您需要根據您的應用程序和數據庫結構自行實現

        // 使用 prepared statements 避免 SQL 注入攻擊
        $stmt = $pdo->prepare("INSERT INTO report (user_no, comment_no,report_info,report_time) VALUES (?, ? ,?,now())");
        $stmt->execute([$commentId, $content,$info,]);

        // 檢查是否成功插入檢舉數據
        if ($stmt->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "檢舉已成功提交"]);
        } else {
            echo json_encode(["success" => false, "message" => "提交檢舉時出錯"]);
        }
    } else {
        // 如果未收到檢舉相關的數據，返回錯誤信息
        echo json_encode(["success" => false, "message" => "未收到檢舉相關的數據"]);
    }
} else {
    // 如果請求方法不是 POST，返回錯誤信息
    echo json_encode(["success" => false, "message" => "僅接受 POST 請求"]);
}
} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}



?>
