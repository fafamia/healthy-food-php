<?php

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");
    
    $sql = "SELECT * FROM product p 
            JOIN product_class pc ON p.product_class_no = pc.product_class_no 
            LEFT JOIN product_tag pt ON p.product_tag_no = pt.product_tag_no
            WHERE product_status = 0
            ORDER BY p.product_no DESC";

    $products = $pdo->query($sql);
    $prodRows = $products->fetchAll(PDO::FETCH_ASSOC);
    $result = ["error" => false, "msg"=>"", "products"=>$prodRows];
    header('Content-Type: application/json');
} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);