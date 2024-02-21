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

    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 检查连接是否成功
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 准备 SQL 语句
    $sql = "UPDATE recipe 
            SET recipe_name = ?, 
                recipe_people = ?, 
                recipe_time = ?, 
                recipe_ingredient = ?, 
                recipe_info = ? 
            WHERE recipe_no = ?";

    // 创建预处理语句
    $stmt = $conn->prepare($sql);

    // 绑定参数
    $stmt->bind_param("sssssi", $data['recipe_name'], $data['recipe_people'], $data['recipe_time'], $data['recipe_ingredient'], $data['recipe_info'], $data['recipe_no']);

    // 执行预处理语句
    if ($stmt->execute()) {
        echo json_encode(array("message" => "Recipe edited successfully"));
    } else {
        echo json_encode(array("message" => "Error editing recipe"));
    }

    // 关闭预处理语句和数据库连接
    $stmt->close();
    $conn->close();
} else {
    // 如果不是 POST 请求，则返回错误信息
    echo json_encode(array("message" => "Invalid request method"));
}
?>
