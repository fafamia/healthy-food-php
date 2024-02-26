<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Content-Type: application/json');
    require_once("../../connect_chd104g3.php");

    $sql = "INSERT INTO recipe_class (recipe_class_name)
            VALUES (?)";

    $stmt = $pdo->prepare($sql);
    // 用 $_POST 接收 input 的資料
    $stmt->bindValue(1, $_POST["recipe_class_name"]);
    


    $stmt->execute();
    $result = ["error" => false, "msg" => "新增成功", "recipe" => $stmt];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}
echo json_encode($result);
?>
