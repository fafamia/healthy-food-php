<?php
// 設定 CORS 標頭，允許從任何來源進行跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// 检查请求方法是否为 POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 检查是否接收到了各项数据
    if (isset($_POST['recipe_name']) && isset($_POST['recipe_people']) && isset($_POST['recipe_time']) && isset($_POST['recipe_ingredient']) && isset($_POST['recipe_info']) && isset($_POST['recipe_status']) && isset($_FILES['recipe_img'])) {
        // 生成唯一的文件名
        $fileName = uniqid() . '_' . $_FILES['recipe_img']['name'];
        // 指定文件上传目录
        $targetDir = "admin-healthy-food/src/assets/images/cookbook/";
        

        // 将文件移动到上传目录
        $filePath = $targetDir . $fileName;
        if (move_uploaded_file($_FILES['recipe_img']['tmp_name'], $filePath)) {
            // 连接数据库
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "food";

            try {
                $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                // 设置 PDO 错误模式为异常
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // 准备 SQL 语句
                $sql = "INSERT INTO recipe (recipe_name, recipe_people, recipe_time, recipe_ingredient, recipe_info, recipe_creation_time, recipe_status, recipe_img)
                        VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)";
                
                // 创建预处理语句
                $stmt = $conn->prepare($sql);

                // 绑定参数
                $stmt->bindParam(1, $_POST['recipe_name']);
                $stmt->bindParam(2, $_POST['recipe_people']);
                $stmt->bindParam(3, $_POST['recipe_time']);
                $stmt->bindParam(4, $_POST['recipe_ingredient']);
                $stmt->bindParam(5, $_POST['recipe_info']);
                $stmt->bindParam(6, $_POST['recipe_status']);
                $stmt->bindParam(7, $filePath);

                // 执行预处理语句
                $stmt->execute();

                echo json_encode(array("message" => "Recipe saved successfully"));
            } catch(PDOException $e) {
                echo json_encode(array("message" => "Error: " . $e->getMessage()));
            }

            // 关闭数据库连接
            $conn = null;
        } else {
            echo json_encode(array("message" => "Failed to move uploaded file"));
        }
    } else {
        // 如果缺少必要的数据，返回错误信息
        echo json_encode(array("message" => "Missing required data"));
    }
} else {
    // 如果不是 POST 请求，则返回错误信息
    echo json_encode(array("message" => "Invalid request method"));
}
?>
