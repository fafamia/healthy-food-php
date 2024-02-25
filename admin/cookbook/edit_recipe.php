<?php
// 允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../../connect_chd104g3.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 檢查是否收到 FormData
    if (count($_POST) > 0) {
        $recipe_no = $_POST["recipe_no"];
        $recipe_name = $_POST["recipe_name"];
        $recipe_people = $_POST["recipe_people"];
        $recipe_time = $_POST["recipe_time"];
        $recipe_ingredient = $_POST["recipe_ingredient"];
        $recipe_info = $_POST["recipe_info"];
        $recipe_status = $_POST["recipe_status"];
        
        $sql = "UPDATE recipe 
                SET recipe_name = :recipe_name, 
                    recipe_people = :recipe_people,
                    recipe_time = :recipe_time,
                    recipe_ingredient = :recipe_ingredient,
                    recipe_info = :recipe_info, 
                    recipe_status = :recipe_status
                WHERE recipe_no = :recipe_no";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":recipe_name", $recipe_name);
        $stmt->bindValue(":recipe_people", $recipe_people);
        $stmt->bindValue(":recipe_time", $recipe_time);
        $stmt->bindValue(":recipe_ingredient", $recipe_ingredient);
        $stmt->bindValue(":recipe_info", $recipe_info);
        $stmt->bindValue(":recipe_status", $recipe_status);
        $stmt->bindValue(":recipe_no", $recipe_no);
        
        try {
            $stmt->execute();
            echo json_encode(["error" => false, "msg" => "食譜已成功更新"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => true, "msg" => "更新食譜時出現錯誤: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => true, "msg" => "未收到 FormData"]);
    }
} else {
    echo json_encode(["error" => true, "msg" => "僅接受 POST 請求"]);
}
?>
