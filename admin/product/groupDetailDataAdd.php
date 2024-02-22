<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once("../../connect_chd104g3.php");

    // 檢查所需的鍵是否已設定
    if (isset($_POST["prodgroup_no"]) && isset($_POST["product_no"]) && isset($_POST["prodgroup_name"]) && isset($_POST["prodgroup_sale_price"])) {
        // 解析以逗號分隔的商品編號字符串
        $product_nos = explode(",", $_POST["product_nos"]);
        foreach ($product_nos as $product_no) {
        // 使用預處理語句來防止 SQL 注入攻擊
        $sql = "INSERT INTO prodgroup_details (prodgroup_no, product_no, prodgroup_name, prodgroup_sale_price) VALUES (:prodgroup_no, :product_no, :prodgroup_name, :prodgroup_sale_price)";
        $groupdetails = $pdo->prepare($sql);
        
        // 綁定參數
        $groupdetails->bindParam(":prodgroup_no", $_POST["prodgroup_no"]);
        $groupdetails->bindParam(":product_no", $_POST["product_no"]);
        $groupdetails->bindParam(":prodgroup_name", $_POST["prodgroup_name"]);
        $groupdetails->bindParam(":prodgroup_sale_price", $_POST["prodgroup_sale_price"]);

        // 執行查詢
        $groupdetails->execute();
}
        // 檢查是否成功插入資料
        if ($groupdetails->rowCount() > 0) {
            $result = ["error" => false, "msg" => "新增成功"];
        } else {
            $result = ["error" => true, "msg" => "新增失敗"];
        }
    } else {
        $result = ["error" => true, "msg" => "缺少必要的參數"];
    }
} catch(PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

// 返回 JSON 格式的響應
echo json_encode($result);
?>
