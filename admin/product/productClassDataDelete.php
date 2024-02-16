<?php
$host = "localhost";
$dbname = "food";
$username = "root";
$password = "";
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $productClass = json_decode(file_get_contents('php://input'), true);
    try{
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        // require_once("../connect_chd104g3.php");
    
        $sql = "DELETE FROM product_class WHERE product_class_no = :product_class_no ";
        $prodclass = $pdo->prepare($sql);
        $prodclass->bindValue(":product_class_no",$productClass["product_class_no"]);
        $prodclass->execute();
        $rowcount = $prodclass->rowCount();

        $result = ["error" => false, "msg" => "刪除{$rowcount}筆資料"];
    }catch(PDOException $e){
        $result = ["error" => true, "msg"=>$e->getMessage()];
    }
    echo json_encode($result);
?>