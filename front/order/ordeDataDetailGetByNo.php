<?php

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Content-Type: application/json');
    require_once("../../connect_chd104g3.php");
    
    $ord_no = isset($_GET['ord_no']) ? $_GET['ord_no'] : null;
    if($ord_no){
        $sql = "SELECT * FROM order_details WHERE ord_no = :ord_no ORDER BY product_no";
        $orderDetails = $pdo->prepare($sql);
        $orderDetails->bindParam(':ord_no',$ord_no,PDO::PARAM_INT);
        $orderDetails->execute();
        $orderDetailsRows = $orderDetails->fetchAll(PDO::FETCH_ASSOC);
        $result = [
            "error" => false, 
            "msg"=>"", 
            "orderDetailsRows"=>$orderDetailsRows,
        ];
    }else{
        $result = [
            "error" => true, 
            "msg" => "訂單編號不存在"
        ];
    }
} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);