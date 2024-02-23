<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    $sql = "SELECT * FROM `article_class`";
    $stmt = $pdo->query($sql);
    $articleClasses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($articleClasses);

} catch (PDOException $e) {
    echo json_encode(["error" => true, "msg" => $e->getMessage()]);
}
?>
