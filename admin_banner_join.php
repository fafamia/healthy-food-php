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

    $sql = "SELECT carousel_no, banner_title, banner_image FROM banner_carousel";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $banners = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($banners);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>