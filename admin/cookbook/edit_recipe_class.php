<?php
// 允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../../connect_chd104g3.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // 檢查是否收到 FormData
    if (count($_POST) > 0) {
        $recipe_class_no = $_POST["recipe_class_no"];
        $recipe_class_name = $_POST["recipe_class_name"];
        
        $sql = "UPDATE recipe_class 
                SET recipe_class_name = :recipe_class_name
                WHERE recipe_class_no = :recipe_class_no";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":recipe_class_name", $recipe_class_name);
        $stmt->bindValue(":recipe_class_no", $recipe_class_no);
        
        try {
            $stmt->execute();
            echo json_encode(["error" => false, "msg" => "食譜分類已成功更新"]);
        } catch (PDOException $e) {
            echo json_encode(["error" => true, "msg" => "更新食譜分類時出現錯誤: " . $e->getMessage()]);
        }
    } else {
        echo json_encode(["error" => true, "msg" => "未收到 FormData"]);
    }
} else {
    echo json_encode(["error" => true, "msg" => "僅接受 POST 請求"]);
}
?>
