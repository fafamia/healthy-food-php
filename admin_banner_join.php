<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("connect_chd104g3.php");
// require_once("test_local_pdo.php");

try {
    $sql = "SELECT carousel_no, banner_title, banner_image FROM banner_carousel";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $banners = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($banners);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$pdo = null;
?>
