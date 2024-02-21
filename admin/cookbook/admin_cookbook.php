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
    // }else{
//     echo "連接成功";
// }

// 执行查询
$sql = "SELECT * FROM recipe";
$result = $conn->query($sql);

// 将查询结果转换为关联数组，并将其转换为 JSON 格式
$recipe = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $recipe[] = $row;
    }
}
echo json_encode($recipe);

// 关闭连接
$conn->close();
?>

