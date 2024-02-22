<?php
    $productGroup = json_decode(file_get_contents('php://input'), true);
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    $sql = "UPDATE prodgroup SET prodgroup_name = :prodgroup_name, prodgroup_start = :prodgroup_start, prodgroup_end = :prodgroup_end WHERE prodgroup_no = :prodgroup_no";
    $prodgroups = $pdo->prepare($sql);

    $prodgroups->bindValue(":prodgroup_no",$productGroup["prodgroup_no"]);
    $prodgroups->bindValue(":prodgroup_name",$productGroup["prodgroup_name"]);
    $prodgroups->bindValue(":prodgroup_start",$productGroup["prodgroup_start"]);
    $prodgroups->bindValue(":prodgroup_end",$productGroup["prodgroup_end"]);
    $prodgroups->execute();
    $result = ["error" => false, "msg"=>"", "prodgroups"=>$prodgroups];

} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);