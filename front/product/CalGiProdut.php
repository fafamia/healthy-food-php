<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../../connect_chd104g3.php");

try {
    $sql = "SELECT * FROM product p 
        JOIN product_tag pt ON p.product_tag_no = pt.product_tag_no 
        ORDER BY RAND() LIMIT 3;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    header('Content-Type: application/json');
    echo json_encode($products);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$pdo = null;
?>
