<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("connect_chd104g3.php");

$carousel_no = $_POST['banner_index'];
$sql = "DELETE FROM banner_carousel WHERE carousel_no = $carousel_no";
if ($conn->query($sql) > 0) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => $conn->error]);
}
?>
