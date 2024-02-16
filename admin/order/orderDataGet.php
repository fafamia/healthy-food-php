<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$host = "localhost";
$dbname = "food";
$username = "root";
$password = "";
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT ORD_INDEX,ORD_NO,USER_NO,ORD_TIME,ORD_NAME,TAKE_NAME,TAKE_MAIL,TAKE_TEL,TAKE_ADDRESS,
    ORD_SHIPPING,PAYMENT_STATUS,ORD_STATUS,DELIVERY_FEE,ORD_AMOUNT,SALES_AMOUNT,ORD_PAYMENT,USER_SALES FROM ORDERS";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $productClass = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($productClass);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>