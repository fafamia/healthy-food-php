<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    $sql = "SELECT * FROM product INNER JOIN FAVORITE ON product.PRODUCT_NO = favorite.PRODUCT_NO INNER JOIN members ON members.member_no = favorite.member_no";

    $favorite = $pdo->query($sql);
    $favoriteRows = $favorite->fetchAll(PDO::FETCH_ASSOC);
    $result = ["error" => false, "msg"=>"", "favorite"=>$favoriteRows];
} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);
?>