<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../../connect_chd104g3.php");

try {
    $fetchLocalStorageArray = json_decode(file_get_contents('php://input'), true);
    foreach($fetchLocalStorageArray as $item){
        $sql = "SELECT * FROM recipe WHERE recipe_no IN ($placeholders)";
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
    header('Content-Type: application/json');
    echo json_encode($recipes);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$pdo = null;
?>
