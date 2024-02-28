<?php
$orderInfo = json_decode(file_get_contents('php://input'), true);
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Content-Type: application/json');
    require_once("../../connect_chd104g3.php");
    
    $sql = "UPDATE orders 
            SET ord_name = :ord_name, 
                take_mail = :take_mail,
                take_tel = :take_tel,
                take_address = :take_address,
                shipping_status = :shipping_status, 
                payment_status = :payment_status, 
                ord_status = :ord_status 
            WHERE ord_index = :ord_index";
    $orderDatas = $pdo->prepare($sql);
    $orderDatas->bindParam(':ord_index', $orderInfo['ord_index']);
    $orderDatas->bindParam(':ord_name',$orderInfo['ord_name']);
    $orderDatas->bindParam(':take_mail',$orderInfo['take_mail']);
    $orderDatas->bindParam(':take_tel',$orderInfo['take_tel']);
    $orderDatas->bindParam(':take_address',$orderInfo['take_address']);
    // $orderDatas->bindParam(':delivery_fee',$orderInfo['delivery_fee']);
    $orderDatas->bindParam(':shipping_status',$orderInfo['shipping_status']);
    $orderDatas->bindParam(':payment_status',$orderInfo['payment_status']);
    $orderDatas->bindParam(':ord_status',$orderInfo['ord_status']);
    
    $orderDatas->execute();
    $result = ["error" => false, "msg"=>"", "orderDatas"=>$orderDatas];
} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);