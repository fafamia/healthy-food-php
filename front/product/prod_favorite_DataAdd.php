<?php
$productClass = json_decode(file_get_contents('php://input'), true);
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // 使用 $_POST 來訪問前端發送的數據
        $member_no = $_POST["member_no"];
        $PRODUCT_NO = $_POST["PRODUCT_NO"];
      
    
        // 直接執行更新操作
        $update_sql = "INSERT INTO favorite (member_no, PRODUCT_NO) VALUES (:member_no, :PRODUCT_NO)";
    
        $update_stmt = $pdo->prepare($update_sql);
        $update_stmt->bindValue(":member_no", $member_no);
        $update_stmt->bindValue(":PRODUCT_NO", $PRODUCT_NO);
        $result = [];

        if ($update_stmt->execute()) {
            $lastInsertId = $pdo->lastInsertId();
            // 返回成功訊息及新增的產品分類編號
            $result = ["error" => false, "msg" => "新增成功", "product_class_no" => $lastInsertId];
        } else {
            // 返回錯誤訊息
            $result = ["error" => true, "msg" => "新增失敗"];
        }
    }
} catch (PDOException $e) {
    // 返回錯誤訊息
    $result = ["error" => true, "msg" => $e->getMessage()];
}
// 將結果轉換為 JSON 格式並輸出
echo json_encode($result);
?>
