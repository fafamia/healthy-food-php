<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("test_local_pdo.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['title']) && isset($_FILES['image'])) {
        $title = $_POST['title'];
        // 获取上传文件的原始文件名
        $uploadedFileName = $_FILES['image']['name'];
        // 提取文件名和扩展名
        $fileName = pathinfo($uploadedFileName, PATHINFO_FILENAME);
        $extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
        // 构建保存路径
        $targetDirectory = 'C:/Users/T14 Gen 3/Desktop/admin/src/assets/images/banner/';
        $copyFile =  "banner" . $fileName . '.' . $extension;
        $uploadedFile = $targetDirectory . $copyFile;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
            try {
                // 保存文件名和扩展名到数据库
                $query = $pdo->prepare("INSERT INTO banner_carousel (banner_title, banner_image) 
                VALUES (:title, :image)");
                $query->bindParam(':title', $title);
                $query->bindParam(':image', $copyFile); // 保存文件名到数据库
                $query->execute();

                echo json_encode(['success' => true, 'message' => 'Banner保存成功']);
            } catch (PDOException $e) {
                echo json_encode(['success' => false, 'message' => '資料庫遭做失敗: ' . $e->getMessage()]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => '文件上傳失敗']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => '缺少必要的資料']);
    }
} else {
    echo json_encode(['success' => false, 'message' => '非法請求']);
}
?>
