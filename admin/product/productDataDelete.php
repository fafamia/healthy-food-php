<?php
    $product = json_decode(file_get_contents('php://input'), true);
    try{
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        require_once("../../connect_chd104g3.php");
    
        $sql = "DELETE FROM product WHERE product_no = :product_no ";
        $products = $pdo->prepare($sql);
        $products->bindValue(":product_no",$product["product_no"]);
        $products->execute();
        $rowCount = $products->rowCount();

        $result = ["error" => false, "msg" => "刪除{$rowCount}筆資料"];
    }catch(PDOException $e){
        $result = ["error" => true, "msg"=>$e->getMessage()];
    }
    echo json_encode($result);
?>