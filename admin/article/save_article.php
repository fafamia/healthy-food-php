<?php
header("Content-Type: application/x-www-form-urlencoded");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../../connect_chd104g3.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['article_title']) &&
        isset($_POST['article_class']) &&  // 確保有值
        isset($_POST['article_description']) &&
        isset($_POST['cover_photo']) &&  // 可能需要使用 $_FILES
        isset($_POST['content']) &&  // 確保有值
        isset($_POST['creation_time']) &&  // 確保有值
        isset($_POST['article_status'])
    ) {
        $article_title = $_POST['article_title'];
        $article_description = $_POST['article_description'];
        $article_status = $_POST['article_status'];

        
        if (!empty($_FILES['cover_photo']['tmp_name'])) {
            $uploadDir = "../../../images/article"; 
            $uploadFile = $uploadDir . basename($_FILES['cover_photo']['name']);

            if (move_uploaded_file($_FILES['cover_photo']['tmp_name'], $uploadFile)) {
                // 文件移動成功，可以在數據庫中保存文件路徑
                $cover_photo = $uploadFile;
            } else {
                echo json_encode(['error' => '文件上傳失敗']);
                exit();
            }
        } else {
            // 沒有上傳文件
            $cover_photo = "";
        }

        try {
            $query = $pdo->prepare("
                INSERT INTO `article_overview` (
                    `article_title`,
                    `article_description`,
                    `cover_photo`,
                    `article_status`
                ) VALUES (
                    :article_title,
                    :article_description,
                    :cover_photo,
                    :article_status
                )
            ");

            $query->bindParam(':article_title', $article_title);
            $query->bindParam(':article_description', $article_description);
            $query->bindParam(':cover_photo', $cover_photo);
            $query->bindParam(':article_status', $article_status);

            $query->execute();

            echo json_encode(['success' => true, 'message' => '新增文章成功']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => '新增文章失敗: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'POST 資料缺少']);
    }
} else {
   
}

$pdo = null;
?>
