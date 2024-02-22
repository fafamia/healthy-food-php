<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

header('Content-Type: application/json; charset=utf-8');

$servername = "localhost"; 
$username = "root";    
$password = "";    
$dbname = "food";        

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接是否成功
if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 检查是否收到了食谱编号
if(isset($_GET['recipe_no'])) {
    $recipeNo = $_GET['recipe_no'];
    
    // 使用 prepared statement 來避免 SQL 注入攻擊
    $sql = "DELETE FROM recipe WHERE recipe_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recipeNo); // "i" 表示參數是一個整數
    $stmt->execute();

    // 检查删除操作是否成功
    if($stmt->affected_rows > 0) {
        echo json_encode(array('message' => 'Recipe deleted successfully'));
    } else {
        echo json_encode(array('error' => 'Failed to delete recipe'));
    }
    $stmt->close(); // 關閉 prepared statement
} else {
    echo json_encode(array('error' => 'Recipe ID not provided'));
}

// 关闭连接
$conn->close();
?>
