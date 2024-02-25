<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    // 檢查所需的鍵是否已設定
    if (isset($_POST["prodgroup_details_no"]) && isset($_POST["prodgroup_no"]) && isset($_POST["product_names"]) && isset($_POST["prodgroup_name"]) && isset($_POST["prodgroup_sale_price"])) {
        // 解析以逗號分隔的商品名稱字符串為數組
        $product_names = explode(",", $_POST["product_names"]);
        
        // 使用預處理語句來防止 SQL 注入攻擊
        $sql = "INSERT INTO prodgroup_details (prodgroup_details_no,prodgroup_no, product_name, prodgroup_name, prodgroup_sale_price) VALUES (:prodgroup_details_no,:prodgroup_no, :product_name, :prodgroup_name, :prodgroup_sale_price)";
        $groupdetails = $pdo->prepare($sql);
        
        // 綁定共同的參數
        $groupdetails->bindParam(":prodgroup_details_no", $_POST["prodgroup_details_no"]);
        $groupdetails->bindParam(":prodgroup_no", $_POST["prodgroup_no"]);
        $groupdetails->bindParam(":product_name", $_POST["product_name"]);
        $groupdetails->bindParam(":prodgroup_name", $_POST["prodgroup_name"]);
        $groupdetails->bindParam(":prodgroup_sale_price", $_POST["prodgroup_sale_price"]);

        // 遍歷每個商品名稱並插入數據
        foreach ($product_names as $product_name) {
            // 綁定特定的商品名稱
            $groupdetails->bindParam(":product_name", $product_name);
            
            // 執行查詢
            $groupdetails->execute();
            
            // 檢查是否成功插入數據
            if ($groupdetails->rowCount() <= 0) {
                // 如果未成功插入數據，則設置錯誤消息
                $result = ["error" => true, "msg" => "新增失敗"];
                // 可選：您可以在此處添加任何必要的回滾邏輯，以確保數據庫完整性
            }
        }
        // 如果循環中沒有發生錯誤，則設置成功消息
        $result = ["error" => false, "msg" => "新增成功"];
    } else {
        // 如果缺少必要的參數，則設置錯誤消息
        $result = ["error" => true, "msg" => "缺少必要的參數"];
    }
} catch(PDOException $e) {
    // 如果發生 PDO 錯誤，則設置錯誤消息
    $result = ["error" => true, "msg" => $e->getMessage()];
}

// 返回 JSON 格式的響應
echo json_encode($result);
?>
