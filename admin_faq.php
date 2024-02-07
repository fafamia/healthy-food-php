<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$host = "localhost";
$username = "root";
$password = "";
$dbname = "food";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 查詢資料庫中的數據
$sql = "SELECT faq_no, faq_class, ans, question FROM faq";
$result = $conn->query($sql);
// 檢查结果
if ($result->num_rows > 0) {
    // 將數據存入
    $faqData = array();
    while($row = $result->fetch_assoc()) {
        $faqData[] = $row;
    }
} else {
    $faqData = array();  // 初始化為一個空數組
    echo "No FAQ found.";
}

$conn->close();

// 给前端
echo json_encode($faqData);
?>
