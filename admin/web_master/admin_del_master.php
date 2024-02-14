<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../../connect_chd104g3.php");
$data = json_decode(file_get_contents("php://input"), true);
$master_no = $data['masterToDelete'];

try {
    $sql = "DELETE FROM webmaster WHERE master_no = :master_no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':master_no', $master_no, PDO::PARAM_INT);
    $stmt->execute();
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>

