<?php
    $productTag = json_decode(file_get_contents('php://input'), true);
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../connect_chd104g3.php");

    $sql = "UPDATE product_tag SET product_tag_name = :product_tag_name  WHERE product_tag_no = :product_tag_no";
    $productTags = $pdo->prepare($sql);

    $productTags->bindValue(":product_tag_no",$productTag["product_tag_no"]);
    $productTags->bindValue(":product_tag_name",$productTag["product_tag_name"]);
    $productTags->execute();
    $result = ["error" => false, "msg"=>"", "productTags"=>$productTags];

} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);