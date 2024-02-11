<?php
    $productTag = json_decode(file_get_contents('php://input'), true);
    try{
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        require_once("../connect_chd104g3.php");
    
        $sql = "INSERT INTO product_tag (product_tag_name) VALUES (:name)";
        $productTags = $pdo->prepare($sql);
        $productTags->bindValue(":name",$productTag["product_tag_name"]);
        $productTags->execute();
        $lastInsertId = $pdo->lastInsertId();

        $result = ["error" => false, "msg" => "新增成功","product_tag_no"=>$lastInsertId, "productTags" => $productTags];
    }catch(PDOException $e){
        $result = ["error" => true, "msg"=>$e->getMessage()];
    }
    echo json_encode($result);
?>