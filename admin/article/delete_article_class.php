<?php
$articleClassData = json_decode(file_get_contents('php://input'), true);

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    $sql = "DELETE FROM `article_class` WHERE `category_no` = :category_no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":category_no", $articleClassData["categoryNoToDelete"]);
    $stmt->execute();

    $result = ["error" => false, "msg" => "專欄分類刪除成功"];

} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

echo json_encode($result);
?>
