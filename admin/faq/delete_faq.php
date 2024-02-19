<?php
// 允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// 引入資料庫連接
require_once("../../connect_chd104g3.php");

// 解析前端發送的 JSON 數據
$data = json_decode(file_get_contents("php://input"), true);

// 輸出解析的數據，以便進行調試
var_dump($data);

try {
    // 從解析後的 JSON 數據中獲取要刪除的 faq_no
    $faq_no = $data['faqToDelete'];

    // SQL 刪除 faq 表中指定 faq_no 的數據
    $sql = "DELETE FROM faq WHERE faq_no = :faq_no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':faq_no', $faq_no, PDO::PARAM_INT);
    $stmt->execute();

    // 返回成功的 JSON 響應
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    // 如果發生 PDOException，則捕獲異常並返回失敗的 JSON 響應，並包含錯誤信息
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
