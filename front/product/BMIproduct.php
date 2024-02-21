<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// 連接數據庫
require_once("../../connect_chd104g3.php");

// 準備 SQL 查詢
$sql = "SELECT * FROM product WHERE product_no IN (SELECT product_no FROM prodgroup_details WHERE prodgroup_no = :prodgroup_no)";

// 準備查詢
$stmt = $pdo->prepare($sql);

// 綁定參數
$stmt->bindValue(":prodgroup_no", 6); // 假設您從 URL 中獲取 prodgroup_no

// 執行查詢
$stmt->execute();

// 獲取查詢結果
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    $products = ["error" => true, "msg" => $e->getMessage()];
}

// 返回 JSON 格式的數據
echo json_encode($products);
?>
