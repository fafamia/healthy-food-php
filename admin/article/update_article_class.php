<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    // 讀取 POST 資料
    $data = json_decode(file_get_contents("php://input"));

    // 獲取分類編號和分類名稱
    $categoryNo = $data->category_no;
    $categoryName = $data->category_name;

    // 執行更新的 SQL 語句
    $sql = "UPDATE `article_class` SET `category_name` = ? WHERE `category_no` = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$categoryName, $categoryNo]);

    echo json_encode(["success" => true, "msg" => "更新分類成功"]);

} catch (PDOException $e) {
    echo json_encode(["error" => true, "msg" => $e->getMessage()]);
}
?>
