<?php

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    // $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    require_once("connect_chd104g3.php");
    $sql = "SELECT p.product_no, pc.product_class_name, pt.product_tag_name, p.product_name, p.product_price, p.product_status FROM product p JOIN product_class pc ON p.product_class_no = pc.product_class_no LEFT JOIN product_tag pt ON p.product_tag_no = pt.product_tag_no";

    $stmt = $pdo->query($sql);
    //$stmt = $conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($products);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>