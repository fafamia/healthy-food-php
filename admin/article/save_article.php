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
    // 檢查是否接收到了文章相關資訊
    if (
        isset($_POST['article_title']) &&
        isset($_POST['article_class']) &&
        isset($_POST['article_description']) &&
        isset($_POST['cover_photo']) &&
        isset($_POST['content']) &&
        isset($_POST['creation_time']) &&
        isset($_POST['article_status'])
    ) {
        // 獲取文章相關資訊
        $article_title = $_POST['article_title'];
        $article_class = $_POST['article_class'];
        $article_description = $_POST['article_description'];
        $cover_photo = $_POST['cover_photo'];
        $content = $_POST['content'];
        $creation_time = $_POST['creation_time'];
        $article_status = $_POST['article_status'];

        try {
            // 插入文章資訊
            $query = $pdo->prepare("
                INSERT INTO `article_overview` (
                    `article_class`,
                    `article_title`,
                    `article_description`,
                    `cover_photo`,
                    `content`,
                    `creation_time`,
                    `article_status`
                ) VALUES (
                    :article_class,
                    :article_title,
                    :article_description,
                    :cover_photo,
                    :content,
                    :creation_time,
                    :article_status
                )
            ");

            $query->bindParam(':article_class', $article_class);
            $query->bindParam(':article_title', $article_title);
            $query->bindParam(':article_description', $article_description);
            $query->bindParam(':cover_photo', $cover_photo);
            $query->bindParam(':content', $content);
            $query->bindParam(':creation_time', $creation_time);
            $query->bindParam(':article_status', $article_status);

            $query->execute();

            echo json_encode(['success' => true, 'message' => '新增文章成功']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => '新增文章失敗: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'POST 資料缺少']);
    }
} else { // 如果不是 POST 請求，執行查詢和回傳資料
    try {
        // 準備 SQL 查詢語句，選擇所有 article_overview 表格中的欄位
        $sql = "SELECT * FROM article_overview";
        // SQL 查詢
        $stmt = $pdo->prepare($sql);
        // 如果執行成功，execute() 不會返回任何值，有錯誤發生會拋出一個 PDOException 
        $stmt->execute();
        // 檢索所有結果行，將其存儲為關聯數組
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // 設置 HTTP 響應標頭為 JSON 格式
        header('Content-Type: application/json');
        // 將 PHP 數組轉換為 JSON 並輸出到前端
        echo json_encode($articles);
    } catch (PDOException $e) {
        // 如果發生 PDOException，則捕獲異常並輸出錯誤消息
        echo json_encode(['error' => '取得文章列表失敗: ' . $e->getMessage()]);
    }
}

// 關閉資料庫連接
$pdo = null;
?>
