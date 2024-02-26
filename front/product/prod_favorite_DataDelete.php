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
    
        // 準備 SQL 查詢，刪除指定會員和產品的組合
        $sql = "DELETE FROM favorite WHERE member_no = :member_no AND PRODUCT_NO = :PRODUCT_NO";
        $favorite = $pdo->prepare($sql);
        $favorite->bindValue(":member_no", $member_no);
        $favorite->bindValue(":PRODUCT_NO", $PRODUCT_NO);
        $favorite->execute();
        
        // 檢查受影響的行數
        $rowcount = $favorite->rowCount();

        // 返回成功訊息及刪除的資料筆數
        $result = ["error" => false, "msg" => "刪除{$rowcount}筆資料"];
    }
} catch(PDOException $e) {
    // 返回錯誤訊息
    $result = ["error" => true, "msg" => $e->getMessage()];
}
// 將結果轉換為 JSON 格式並輸出
echo json_encode($result);
?>
