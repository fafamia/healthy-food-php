<?php
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

header("Access-Control-Allow-Headers: Content-Type");

header("Access-Control-Allow-Credentials: true");
// 引入數據庫連接文件
require_once("../../connect_chd104g3.php");

// 從前端取得關鍵字
$key = isset($_GET['key']) ? $_GET['key'] : '';

// 使用預備語句來防止 SQL 注入攻擊
$query = $pdo->prepare("SELECT ans FROM faq WHERE `key` LIKE :key OR question LIKE :key OR ans LIKE :key");
$query->bindParam(':key', $key, PDO::PARAM_STR);
$query->execute();

// 取得結果
$result = $query->fetch(PDO::FETCH_ASSOC);

// 檢查是否有找到相應的答案
if ($result) {
    $response = array('ans' => $result['ans']);
} else {
    $response = array('ans' => '抱歉，找不到相關答案。');
}

// 將結果轉為 JSON 格式返回給前端
header('Content-Type: application/json');
echo json_encode($response);
?>
