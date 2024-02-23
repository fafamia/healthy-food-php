<?php
$articleClassData = json_decode(file_get_contents('php://input'), true);

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    $sql = "INSERT INTO `article_class` (`category_name`) VALUES (:category_name)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":category_name", $articleClassData["className"]);
    $stmt->execute();

    $result = ["error" => false, "msg" => "專欄分類新增成功"];

} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

echo json_encode($result);
?>
