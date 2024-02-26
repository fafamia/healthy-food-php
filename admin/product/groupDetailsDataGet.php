<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once("../../connect_chd104g3.php");

    // 取得 prodgroup 表格中的 prodgroup_no 和 prodgroup_name
    $prodgroup_sql = "SELECT prodgroup_no, prodgroup_name FROM prodgroup";
    $prodgroup_stmt = $pdo->query($prodgroup_sql);
    $prodgroup_rows = $prodgroup_stmt->fetchAll(PDO::FETCH_ASSOC);

    // 取得 product 表格中的 product_no 和 product_name
    $product_sql = "SELECT product_no, product_name FROM product WHERE product_status = 0";
    $product_stmt = $pdo->query($product_sql);
    $product_rows = $product_stmt->fetchAll(PDO::FETCH_ASSOC);

    // 取得 prodgroup_details 表格中的所有欄位資訊
    $groupdetails_sql = "SELECT * FROM prodgroup_details"; 
    $groupdetails_stmt = $pdo->query($groupdetails_sql);
    $groupdetails_rows = $groupdetails_stmt->fetchAll(PDO::FETCH_ASSOC);

    // 將取得的資料整合成一個統一的數據結構
    $result = [
        "error" => false,
        "msg" => "",
        "prodgroup_options" => $prodgroup_rows,
        "product_options" => $product_rows,
        "prodgroup_details" => $groupdetails_rows
    ];

} catch(PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

// 返回 JSON 格式的響應
echo json_encode($result);
?>
