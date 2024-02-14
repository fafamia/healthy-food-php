<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../../connect_chd104g3.php");

try {
    $sql = "SELECT master_no, master_name, master_account, master_email, master_password FROM webmaster";
    // SQL 查询
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $masters = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($masters);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$pdo = null;
?>
