<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: text/html; charset=utf-8');

require_once("../../connect_chd104g3.php");

$account = isset($_POST['account']) ? $_POST['account'] : null;
$password = isset($_POST['psw']) ? $_POST['psw'] : null;

if (!$account || !$password) {
    echo json_encode(["message" => "請輸入帳號密碼"], JSON_UNESCAPED_UNICODE);
    exit;
}

$sql = "SELECT * FROM webmaster WHERE master_account = :account and master_password = :password";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':account', $account);
$stmt->bindParam(':password', $password);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode(["message" => "登錄成功"], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["message" => "帳號或密碼錯誤"], JSON_UNESCAPED_UNICODE);
}
$pdo = null;
?>
