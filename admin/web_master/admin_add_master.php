<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("../../connect_chd104g3.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['account']) && isset($_POST['password'])) { 
        $name = $_POST['name'];
        $email = $_POST['email'];
        $account = $_POST['account'];
        $password = $_POST['password'];
        
        // 检查是否存在相同的帐号、密码和电子邮件
        $sql_check = "SELECT * FROM webmaster WHERE master_email = :email OR master_account = :account OR master_password = :password";
        $stmt_check = $pdo->prepare($sql_check);
        $stmt_check->bindParam(':email', $email);
        $stmt_check->bindParam(':account', $account);
        $stmt_check->bindParam(':password', $password);
        $stmt_check->execute();
        $existing_user = $stmt_check->fetch(PDO::FETCH_ASSOC);
        
        if ($existing_user) {
            $error_message = '';
            if ($existing_user['master_email'] === $email) {
                $error_message .= 'EMAIL重複 ';
            }
            if ($existing_user['master_account'] === $account) {
                $error_message .= '帳號重複 ';
            }
            if ($existing_user['master_password'] === $password) {
                $error_message .= '密碼重複 ';
            }
            echo json_encode(["message" => $error_message], JSON_UNESCAPED_UNICODE);
        } else {
            try {
                $sql = "INSERT INTO webmaster (master_name, master_email, master_account, master_password) VALUES (:name, :email, :account, :password)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':account', $account);
                $stmt->bindParam(':password', $password);
                $stmt->execute();
                echo json_encode(['success' => true]);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Missing data']);
    }
}
?>
