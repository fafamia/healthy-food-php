<?php
    $groupDetail = json_decode(file_get_contents('php://input'), true);
    try{
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        require_once("../../connect_chd104g3.php");
    
        $sql = "DELETE FROM prodgroup_details WHERE prodgroup_details_no = :prodgroup_details_no";
        $groupdetails = $pdo->prepare($sql);
        $groupdetails->bindValue(":prodgroup_details_no",$groupDetail["prodgroup_details_no"]);
        $groupdetails->execute();
        $rowCount = $groupdetails->rowCount();

        $result = ["error" => false, "msg" => "刪除{$rowCount}筆資料"];
    }catch(PDOException $e){
        $result = ["error" => true, "msg"=>$e->getMessage()];
    }
    echo json_encode($result);
    
?>
