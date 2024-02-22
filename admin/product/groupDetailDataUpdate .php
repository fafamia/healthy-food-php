<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

$groupDetail = json_decode(file_get_contents('php://input'), true);

try {
    require_once("../../connect_chd104g3.php");

    $sql = "UPDATE prodgroup_details SET product_no = :product_no, prodgroup_name = :prodgroup_name, prodgroup_sale_price = :prodgroup_sale_price WHERE prodgroup_no = :prodgroup_no";
    $groupdetails = $pdo->prepare($sql);

    // 確保從前端收到的資料正確地綁定到 PDO 查詢中
    $groupdetails->bindValue(":prodgroup_no", $_POST["prodgroup_no"]);
    $groupdetails->bindValue(":product_no", $_POST["product_no"]);
    $groupdetails->bindValue(":prodgroup_name", $_POST["prodgroup_name"]);
    $groupdetails->bindValue(":prodgroup_sale_price", $_POST["prodgroup_sale_price"]);

    $groupdetails->execute();

    // 檢查是否成功更新了記錄
    $rowCount = $groupdetails->rowCount();
    
    if ($rowCount > 0) {
        $result = ["error" => false, "msg" => "成功更新了 {$rowCount} 筆資料"];
    } else {
        $result = ["error" => true, "msg" => "未能更新資料"];
    }

} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

echo json_encode($result);
?>
