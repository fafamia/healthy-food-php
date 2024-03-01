<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$article = json_decode(file_get_contents('php://input'), true);

try {
    require_once("../../connect_chd104g3.php");

    // 準備 SQL 語句並綁定參數
    $sql = "INSERT INTO `article_class` (`category_name`) VALUES (:category_name)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":category_name", $article["category_name"]);
    $stmt->execute();

    $lastInsertId = $pdo->lastInsertId();

    $result = ["error" => false, "msg" => "新增成功", "category_no" => $lastInsertId];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

// 將結果轉換為 JSON 格式並輸出
echo json_encode($result);
?>
