<?php

$faqClass = json_decode(file_get_contents('php://input'), true);
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    // 準備 SQL 語句並綁定參數
    $sql = "INSERT INTO question_class (question_class) VALUES (:name)";
    $faqclass = $pdo->prepare($sql);
    $faqclass->bindValue(":name", $faqClass["question_class"]);
    $faqclass->execute();
    $lastInsertId = $pdo->lastInsertId();

    
    $result = ["error" => false, "msg" => "新增成功", "question_no" => $lastInsertId, "faqclass" => $faqclass];
} catch (PDOException $e) {
    
    $result = ["error" => true, "msg" => $e->getMessage()];
}
// 將結果轉換為 JSON 格式並輸出
echo json_encode($result);
?>
