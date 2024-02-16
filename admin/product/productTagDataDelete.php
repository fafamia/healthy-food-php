<?php
    $productTag = json_decode(file_get_contents('php://input'), true);
    try{
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        require_once("../../connect_chd104g3.php");
    
        $sql = "DELETE FROM product_tag WHERE product_tag_no = :product_tag_no ";
        $productTags = $pdo->prepare($sql);
        $productTags->bindValue(":product_tag_no",$productTag["product_tag_no"]);
        $productTags->execute();
        $rowcount = $productTags->rowCount();

        $result = ["error" => false, "msg" => "刪除{$rowcount}筆資料"];
    }catch(PDOException $e){
        $result = ["error" => true, "msg"=>$e->getMessage()];
    }
    echo json_encode($result);
?>