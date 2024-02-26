<?php

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Content-Type: application/json');
    require_once("../../connect_chd104g3.php");
    
    $sql = "SELECT * FROM orders";

    $orders = $pdo->query($sql);
    $orderRows = $orders->fetchAll(PDO::FETCH_ASSOC);
    $result = [
        "error" => false, 
        "msg"=>"", 
        "orderRows"=>$orderRows,
    ];
} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);