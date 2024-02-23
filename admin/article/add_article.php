<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$article = json_decode(file_get_contents('php://input'), true);

try {
    require_once("../../connect_chd104g3.php");

    // Check if the "article_class" key is set in the JSON data
    if (!isset($article["article_class"])) {
        throw new PDOException("Column 'article_class' cannot be null");
    }

    // 準備 SQL 語句並綁定參數
    $sql = "INSERT INTO article_overview (article_class, article_title, content, creation_time, article_status) 
            VALUES (:article_class, :article_title, :content, NOW(), :article_status)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":article_class", $article["article_class"]);
    $stmt->bindValue(":article_title", $article["article_title"]);
    $stmt->bindValue(":content", $article["content"]);
    $stmt->bindValue(":article_status", $article["article_status"]);
    $stmt->execute();

    $lastInsertId = $pdo->lastInsertId();

    $result = ["error" => false, "msg" => "新增成功", "article_no" => $lastInsertId];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

// 將結果轉換為 JSON 格式並輸出
echo json_encode($result);
?>
