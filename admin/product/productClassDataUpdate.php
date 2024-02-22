<?php
    $productClass = json_decode(file_get_contents('php://input'), true);
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    $sql = "UPDATE product_class SET product_class_name = :product_class_name  WHERE product_class_no = :product_class_no";
    $prodclass = $pdo->prepare($sql);

    $prodclass->bindValue(":product_class_no",$productClass["product_class_no"]);
    $prodclass->bindValue(":product_class_name",$productClass["product_class_name"]);
    $prodclass->execute();
    $result = ["error" => false, "msg"=>"", "prodclass"=>$prodclass];

} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);