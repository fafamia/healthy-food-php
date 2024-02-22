<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// 检查请求方法是否为 POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 解析 POST 请求中的 JSON 数据
    $data = json_decode(file_get_contents("php://input"), true);

    // 连接数据库
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "food";

    // // 创建连接
    // $conn = new mysqli($servername, $username, $password, $dbname);

    // // 检查连接是否成功
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
    $dbname = "food";
    $dsn = "mysql:host=localhost;dbname=$dbname;port=3306;charset=utf8";
    $username = "root";
    $password = "";
    

    $pdo = new PDO($dsn, $username, $password);

    // 准备 SQL 语句
    $sql = "INSERT INTO recipe (recipe_name, recipe_people, recipe_time, recipe_ingredient, recipe_info,recipe_creation_time,recipe_status)
            VALUES (?, ?, ?, ?, ?, NOW(), ?)";
    
    // 创建预处理语句
    $stmt = $pdo->prepare($sql);

    // 绑定参数
    $stmt->bindValue( 1, $data['recipe_name']);
    $stmt->bindValue( 2, $data['recipe_people']);
    $stmt->bindValue( 3, $data['recipe_time']);
    $stmt->bindValue( 4, $data['recipe_ingredient']);
    $stmt->bindValue( 5, $data['recipe_info']);
    $stmt->bindValue( 6, $data['recipe_status']);
   

    // 执行预处理语句
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Recipe saved successfully"));
    } else {
        echo json_encode(array("message" => "Error saving recipe"));
    }

    // 关闭预处理语句和数据库连接
    // $stmt->close();
    // $conn->close();
} else {
    // 如果不是 POST 请求，则返回错误信息
    echo json_encode(array("message" => "Invalid request method"));
}
?>
