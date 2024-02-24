<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Content-Type: application/json');
    require_once("../../connect_chd104g3.php");

    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        parse_str(file_get_contents("php://input"), $_PUT);
    }

    // 處理圖片上傳
    $fileImg = '';
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
        if (!move_uploaded_file($from, $to)) {
            throw new Exception("Failed to move uploaded file.");
        }
    }

    $sql = "UPDATE recipe 
            SET recipe_name = ?, recipe_people = ?, recipe_time = ?, recipe_ingredient = ?, recipe_info = ?, recipe_status = ?, recipe_img = ?
            WHERE recipe_no = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(1, $_PUT["recipe_name"] ?? '');
    $stmt->bindValue(2, $_PUT["recipe_people"] ?? '');
    $stmt->bindValue(3, $_PUT["recipe_time"] ?? '');
    $stmt->bindValue(4, $_PUT["recipe_ingredient"] ?? '');
    $stmt->bindValue(5, $_PUT["recipe_info"] ?? '');
    $stmt->bindValue(6, $_PUT["recipe_status"] ?? '');
    $stmt->bindValue(7, $fileImg);
    $stmt->bindValue(8, $_PUT["recipe_no"] ?? '');

    $stmt->execute();
    $result = ["error" => false, "msg" => "更新成功"];
} catch (Exception $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}
echo json_encode($result);
?>
