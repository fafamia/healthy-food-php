<?php

$productClass = json_decode(file_get_contents('php://input'), true);
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    // 準備 SQL 語句並綁定參數
    $sql = "INSERT INTO product_class (product_class_name) VALUES (:name)";
    $prodclass = $pdo->prepare($sql);
    $prodclass->bindValue(":name", $productClass["product_class_name"]);
    $prodclass->execute();
    $lastInsertId = $pdo->lastInsertId();

    // 返回成功訊息及新增的產品分類編號
    $result = ["error" => false, "msg" => "新增成功", "product_class_no" => $lastInsertId, "prodclass" => $prodclass];
} catch (PDOException $e) {
    // 返回錯誤訊息
    $result = ["error" => true, "msg" => $e->getMessage()];
}
// 將結果轉換為 JSON 格式並輸出
echo json_encode($result);
?>
