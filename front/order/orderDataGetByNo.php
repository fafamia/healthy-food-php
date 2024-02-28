<?php

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Content-Type: application/json');
    require_once("../../connect_chd104g3.php");
    
    $member_no = isset($_GET['member_no']) ? $_GET['member_no'] : null;
    if($member_no){
        $sql = "SELECT * FROM orders WHERE member_no = :member_no ORDER BY ord_time DESC";
        $orders = $pdo->prepare($sql);
        $orders->bindParam(':member_no',$member_no,PDO::PARAM_INT);
        $orders->execute();
        $orderRows = $orders->fetchAll(PDO::FETCH_ASSOC);
        $result = [
            "error" => false, 
            "msg"=>"", 
            "orderRows"=>$orderRows,
        ];
    }else{
        $result = [
            "error" => true, 
            "msg" => "會員編號不存在"
        ];
    }
} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);