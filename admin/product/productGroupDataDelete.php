<?php

$productGroup = json_decode(file_get_contents('php://input'), true);
try{
    
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    // 查詢並刪除相關的群組明細
    $sql_delete_details = "DELETE FROM prodgroup_details WHERE prodgroup_no = :prodgroup_no";
    $delete_details = $pdo->prepare($sql_delete_details);
    $delete_details->bindValue(":prodgroup_no", $productGroup["prodgroup_no"]);
    $delete_details->execute();

    // 刪除商品群組本身
    $sql_delete_group = "DELETE FROM prodgroup WHERE prodgroup_no = :prodgroup_no";
    $delete_group = $pdo->prepare($sql_delete_group);
    $delete_group->bindValue(":prodgroup_no", $productGroup["prodgroup_no"]);
    $delete_group->execute();
    $rowcount = $delete_group->rowCount();

    $result = ["error" => false, "msg" => "刪除{$rowcount}筆資料"];
}catch(PDOException $e){
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);
?>
