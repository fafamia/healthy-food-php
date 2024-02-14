<?php
// 允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// 引入資料庫連接
require_once("../connect_chd104g3.php");

try {
    // 準備 SQL 查詢語句，選擇所有 banner_carousel 表格中的欄位
    $sql = "SELECT carousel_no, banner_title, banner_image FROM banner_carousel";
    // SQL 查詢
    $stmt = $pdo->prepare($sql);
    // 如果執行成功，execute()不會返回任何值 有錯誤發生會拋出一個 PDOException 
    $stmt->execute();
    // 檢索所有結果行，將其存儲為關聯數組    fetchAll() 是 PDO 的一個方法 返回包含所有結果行的陣列。
    // PDO::FETCH_ASSOC 是 fetchAll() 方法的一個參數，它指定返回的每一行資料都以關聯數組的形式返回。在這個參數的作用下，每一行的鍵名就是資料庫欄位的名稱，對應的值就是該欄位的值。
    $banners = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    // 設置 HTTP 響應標頭為 JSON 格式       Content-Type 標頭指定了響應內容的類型。
    header('Content-Type: application/json');
    // 將 PHP 數組轉換為 JSON 並輸出到前端
    echo json_encode($banners);
    // 捕獲可能在 try 塊中拋出的 PDOException $e
} catch (PDOException $e) {
    // 如果發生 PDOException，則捕獲異常並輸出錯誤消息
    echo "Error: " . $e->getMessage();
}
// 關閉資料庫連接
$pdo = null;
?>
