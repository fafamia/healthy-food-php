<?php
    $productTag = json_decode(file_get_contents('php://input'), true);
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    $sql = "UPDATE product SET product_name = :product_tag_name  WHERE product_tag_no = :product_tag_no";
    $products = $pdo->prepare($sql);

    $products->bindValue(":product_no",$_POST["product_no"]);
    $products->bindValue(":product_class_no",$_POST["product_class_no"]);
    $products->bindValue(":product_tag_no",$_POST["product_tag_no"]);
    $products->bindValue(":product_name",$_POST["product_name"]);
    $products->bindValue(":product_info",$_POST["product_info"]);
    $products->bindValue(":product_loc",$_POST["product_loc"]);
    $products->bindValue(":product_standard",$_POST["product_standard"]);
    $products->bindValue(":product_content",$_POST["product_content"]);
    $products->bindValue(":product_price",$_POST["product_price"]);
    $products->bindValue(":product_status",$_POST["product_status"]);
    $productTags->execute();
    $result = ["error" => false, "msg"=>"", "productTags"=>$productTags];

} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);