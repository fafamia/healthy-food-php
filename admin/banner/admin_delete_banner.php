<?php
// 允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// 引入資料庫連接
require_once("../../connect_chd104g3.php");
// 從前端來的數據解析 成 PHP 數據
$data = json_decode(file_get_contents("php://input"), true);
// 從解析後的 JSON 數據中 獲取要刪除的carousel_no
$carousel_no = $data['bannerToDelete'];

try {
    // SQL 刪除 banner_carousel 表中指定 carousel_no 
    $sql = "DELETE FROM banner_carousel WHERE carousel_no = :carousel_no";
    $stmt = $pdo->prepare($sql);
    // bindParam()：這是 PDOStatement 物件的一個方法，用於將變數綁定到 SQL 查詢中的命名參數。它接受三個參數：
    // 第一個參數是要綁定的參數的名稱（在這裡是 :carousel_no）
    // 第二個參數是要綁定的值（在這裡是 $carousel_no）
    // 第三個參數是可選的，它指定綁定的值的資料型別。在這裡，PDO::PARAM_INT 指定了綁定的值應該被視為整數
    $stmt->bindParam(':carousel_no', $carousel_no, PDO::PARAM_INT);
    // 如果執行成功，execute()不會返回任何值 有錯誤發生會拋出一個 PDOException 
    $stmt->execute();
    // 返回成功的 JSON 響應
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    // 如果發生 PDOException，則捕獲異常並返回失敗的 JSON 響應，並包含錯誤信息
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>

