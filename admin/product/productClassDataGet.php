<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    $sql = "SELECT product_class_no, product_class_name FROM product_class";

    $prodclass = $pdo->query($sql);
    $prodclassRows = $prodclass->fetchAll(PDO::FETCH_ASSOC);
    $result = ["error" => false, "msg"=>"", "prodclass"=>$prodclassRows];
} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);
?>