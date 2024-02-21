<?php
    $groupDetail = json_decode(file_get_contents('php://input'), true);
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    $sql = "UPDATE prodgroup_details SET product_no = :product_no, prodgroup_name = :prodgroup_name, prodgroup_sale_price = :prodgroup_sale_price WHERE prodgroup_no = :prodgroup_no";
    $groupdetails = $pdo->prepare($sql);

    $groupdetails->bindValue(":prodgroup_no",$_POST["prodgroup_no"]);
    $groupdetails->bindValue(":product_no",$_POST["product_no"]);
    $groupdetails->bindValue(":prodgroup_name",$_POST["prodgroup_name"]);
    $groupdetails->bindValue(":prodgroup_sale_price",$_POST["prodgroup_sale_price"]);
    $groupdetails->execute();
    $result = ["error" => false, "msg"=>"", "groupdetails"=>$groupdetails];

} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);