<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Content-Type: application/json');
    require_once("../../connect_chd104g3.php");

    $sql = "INSERT INTO recipe (recipe_name, recipe_recommend, recipe_people, recipe_time, recipe_ingredient, recipe_info, recipe_creation_time, recipe_status, recipe_img)
            VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?)";

    $stmt = $pdo->prepare($sql);
    // 用 $_POST 接收 input 的資料
    $stmt->bindValue(1, $_POST["recipe_name"]);
    $stmt->bindValue(2, $_POST["recipe_recommend"]);
    $stmt->bindValue(3, $_POST["recipe_people"]);
    $stmt->bindValue(4, $_POST["recipe_time"]);
    $stmt->bindValue(5, $_POST["recipe_ingredient"]);
    $stmt->bindValue(6, $_POST["recipe_info"]);
    $stmt->bindValue(7, $_POST["recipe_status"]);

    // 圖片上傳檔案位置
    if (isset($_FILES["recipe_img"]) && $_FILES["recipe_img"]["error"] === 0) {
        $dir = "../../../image/cookbook/";
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        // 取得圖片檔名
        $fileName = pathinfo($_FILES["recipe_img"]["name"], PATHINFO_FILENAME);
        // 取得圖片副檔名
        $fileExt = pathinfo($_FILES["recipe_img"]["name"], PATHINFO_EXTENSION);
        $fileImg = $fileName . '.' . $fileExt;
        $from = $_FILES["recipe_img"]["tmp_name"];// 暫存檔名稱
        $to = $dir . $fileImg;// 檔案名稱
        copy($from, $to);
        $stmt->bindValue(8, $fileImg);
    } else {
        $stmt->bindValue(8, '');
    }

    $stmt->execute();
    $result = ["error" => false, "msg" => "新增成功", "recipe" => $stmt];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}
echo json_encode($result);
?>
