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
        $recipe_text = $_POST["recipe_text"];
        $recipe_recommend = $_POST["recipe_recommend"];
        $recipe_people = $_POST["recipe_people"];
        $recipe_time = $_POST["recipe_time"];
        $recipe_ingredient = $_POST["recipe_ingredient"];
        $recipe_info = $_POST["recipe_info"];
        $recipe_status = $_POST["recipe_status"];
        
        // 檢查是否有上傳圖片
        if (isset($_FILES["recipe_img"]) && $_FILES["recipe_img"]["error"] === 0) {
            $dir = "../../../images/cookbook/";
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            
            // 取得圖片副檔名
            $fileExt = pathinfo($_FILES["recipe_img"]["name"], PATHINFO_EXTENSION);
            // 產生新的圖片檔名
            $fileImg = uniqid() . '.' . $fileExt;
            $to = realpath($dir) . DIRECTORY_SEPARATOR . $fileImg; // 新檔案名稱的絕對路徑
            move_uploaded_file($_FILES["recipe_img"]["tmp_name"], $to);
        } else {
            // 使用原本的圖片
            $fileImg = isset($_POST["image"]) ? $_POST["image"] : null;

        }
        
        $sql = "UPDATE recipe 
                SET recipe_name = :recipe_name, 
                    recipe_text = :recipe_text,
                    recipe_recommend = :recipe_recommend,
                    recipe_people = :recipe_people,
                    recipe_time = :recipe_time,
                    recipe_ingredient = :recipe_ingredient,
                    recipe_info = :recipe_info, 
                    recipe_status = :recipe_status,
                    recipe_img = :recipe_img
                WHERE recipe_no = :recipe_no";
        
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":recipe_name", $recipe_name);
        $stmt->bindValue(":recipe_text", $recipe_text);
        $stmt->bindValue("recipe_recommend",$recipe_recommend);
        $stmt->bindValue(":recipe_people", $recipe_people);
        $stmt->bindValue(":recipe_time", $recipe_time);
        $stmt->bindValue(":recipe_ingredient", $recipe_ingredient);
        $stmt->bindValue(":recipe_info", $recipe_info);
        $stmt->bindValue(":recipe_status", $recipe_status);
        $stmt->bindValue(":recipe_img", $fileImg);
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
