<?php
// 允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../../connect_chd104g3.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["no"]) && isset($_POST["name"]) && isset($_POST["account"]) && isset($_POST["password"]) && isset($_POST["email"])) {
        $master_no = $_POST["no"];
        $master_name = $_POST["name"];
        $master_account = $_POST["account"];
        $master_password = $_POST["password"];
        $master_email = $_POST["email"];
        $sql = "UPDATE webmaster SET master_name=?, master_account=?, master_password=?, master_email=? WHERE master_no=?";
        
        // 使用預處理語句，以防止 SQL 注入攻擊
        $stmt = $pdo->prepare($sql);
        // 綁定參數
        $stmt->bindParam(1, $master_name);
        $stmt->bindParam(2, $master_account);
        $stmt->bindParam(3, $master_password);
        $stmt->bindParam(4, $master_email);
        $stmt->bindParam(5, $master_no);

        try {
            $stmt->execute();
            echo "管理員資料已成功更新";
        } catch (PDOException $e) {
            echo "更新管理員資料時出現錯誤: " . $e->getMessage();
        }
    } else {
        echo "提交的數據不完整";
    }
} else {
    echo "僅接受 POST 請求";
}
?>
