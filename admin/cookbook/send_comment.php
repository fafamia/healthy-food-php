<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Content-Type: application/json');
    require_once("../../connect_chd104g3.php");

    $sql = "INSERT INTO comment (user_no, recipe_no, comment_info, comment_time, comment_status, comment_img)
            VALUES (?, ?, ?, NOW(), ?, ?)";

    $stmt = $pdo->prepare($sql);

    // 用 $_POST 接收 input 的資料
    $stmt->bindValue(1, $_POST["user_no"]);
    $stmt->bindValue(2, $_POST["recipe_no"]);
    $stmt->bindValue(3, $_POST["comment_info"]);
    $stmt->bindValue(4, $_POST["comment_status"]); 
   
    // 圖片上傳檔案位置
    if (isset($_FILES["comment_img"]) && $_FILES["comment_img"]["error"] === 0) {
        $dir = "../../../image/cookbook/";
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }
        // 取得圖片檔名
        $fileName = pathinfo($_FILES["comment_img"]["name"], PATHINFO_FILENAME);
        // 取得圖片副檔名
        $fileExt = pathinfo($_FILES["comment_img"]["name"], PATHINFO_EXTENSION);
        $fileImg = $fileName . '.' . $fileExt;
        $from = $_FILES["comment_img"]["tmp_name"];// 暫存檔名稱
        $to = $dir . $fileImg;// 檔案名稱
        copy($from, $to);
        $stmt->bindValue(5, $fileImg);
    } else {
        $stmt->bindValue(5, '');
    }

    $stmt->execute();
    $result = ["error" => false, "msg" => "發送成功", "comment" => $stmt];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}
echo json_encode($result);
?>
