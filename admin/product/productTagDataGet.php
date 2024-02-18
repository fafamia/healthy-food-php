<?php

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    $sql = "SELECT * FROM product_tag";

    $productTags = $pdo->query($sql);
    $productTagRows = $productTags->fetchAll(PDO::FETCH_ASSOC);
    $result = ["error" => false, "msg"=>"", "productTags"=>$productTagRows];

} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);