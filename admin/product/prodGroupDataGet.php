<?php

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    $sql = "SELECT prodgroup_no,prodgroup_name,prodgroup_start,prodgroup_end FROM prodgroup";

    $prodgroups = $pdo->query($sql);
    $productGroupRows = $prodgroups->fetchAll(PDO::FETCH_ASSOC);
    $result = ["error" => false, "msg"=>"", "prodgroups"=>$productGroupRows];
} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);
?>