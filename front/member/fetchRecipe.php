<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../../connect_chd104g3.php");

try {
    $fetchLocalStorageArray = json_decode(file_get_contents('php://input'), true);
    if ($fetchLocalStorageArray === null) {
        throw new Exception('Failed to parse JSON data');
    }
    $recipes = array();
    foreach($fetchLocalStorageArray as $item){
        $sql = "SELECT * FROM recipe WHERE recipe_no = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$item]);
        $recipe = $stmt->fetch(PDO::FETCH_ASSOC);
        if($recipe) {
            $recipes[] = $recipe;
        }
    }
    header('Content-Type: application/json');
    echo json_encode($recipes);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
$pdo = null;
?>
