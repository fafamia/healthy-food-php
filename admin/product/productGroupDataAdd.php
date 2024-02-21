<?php
    $productGroup = json_decode(file_get_contents('php://input'), true);
    try{
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        require_once("../../connect_chd104g3.php");
    
        $sql = "INSERT INTO prodgroup (prodgroup_name,prodgroup_start,prodgroup_end) VALUES (:name,:start,:end)";
        $prodgroups = $pdo->prepare($sql);
        $prodgroups->bindValue(":name", $productGroup["prodgroup_name"], PDO::PARAM_STR);
        $prodgroups->bindValue(":start", $productGroup["prodgroup_start"], PDO::PARAM_STR);
        $prodgroups->bindValue(":end", $productGroup["prodgroup_end"], PDO::PARAM_STR);
        $prodgroups->execute();
        $lastInsertId = $pdo->lastInsertId();

        $result = ["error" => false, "msg" => "新增成功","prodgroup_no"=>$lastInsertId, "prodgroups" => $prodgroups];
    }catch(PDOException $e){
        $result = ["error" => true, "msg"=>$e->getMessage()];
    }
    echo json_encode($result);
?>