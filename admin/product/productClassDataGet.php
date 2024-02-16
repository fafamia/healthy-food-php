<?php
$host = "localhost";
$dbname = "food";
$username = "root";
$password = "";
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// require_once("connect_chd104g3.php");

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT product_class_no, product_class_name FROM product_class";

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