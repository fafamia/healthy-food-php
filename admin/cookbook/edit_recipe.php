<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Content-Type: application/json');
    require_once("../../connect_chd104g3.php");
    
    $fileImg = isset($_FILES["recipe_img"]) && $_FILES["recipe_img"]["error"] === 0 ? 
                $_FILES["recipe_img"]["name"] : (isset($_POST["image"]) ? $_POST["image"] : null);

    $recipeNo = isset($_POST["recipe_no"]) ? $_POST["recipe_no"] : null;
    $recipeName = isset($_POST["recipe_name"]) ? $_POST["recipe_name"] : null;
    $recipePeople = isset($_POST["recipe_people"]) ? $_POST["recipe_people"] : null;
    $recipeTime = isset($_POST["recipe_time"]) ? $_POST["recipe_time"] : null;
    $recipeIngredient = isset($_POST["recipe_ingredient"]) ? $_POST["recipe_ingredient"] : null;
    $recipeInfo = isset($_POST["recipe_info"]) ? $_POST["recipe_info"] : null;
    $recipeStatus = isset($_POST["recipe_status"]) ? $_POST["recipe_status"] : null;

    $sql = "UPDATE recipe 
            SET recipe_name = :recipe_name, 
                recipe_people = :recipe_people,
                recipe_time = :recipe_time,
                recipe_ingredient = :recipe_ingredient,
                recipe_info = :recipe_info, 
                recipe_status = :recipe_status, 
                recipe_img = :recipe_img
            WHERE recipe_no = :recipe_no";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(":recipe_img", $fileImg);
    $stmt->bindValue(":recipe_no", $recipeNo);
    $stmt->bindValue(":recipe_name", $recipeName);
    $stmt->bindValue(":recipe_people", $recipePeople);
    $stmt->bindValue(":recipe_time", $recipeTime);
    $stmt->bindValue(":recipe_ingredient", $recipeIngredient);
    $stmt->bindValue(":recipe_info", $recipeInfo);
    $stmt->bindValue(":recipe_status", $recipeStatus);
    
    $stmt->execute();
    $result = ["error" => false, "msg" => "", "recipe" => $stmt];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}
echo json_encode($result);
?>
