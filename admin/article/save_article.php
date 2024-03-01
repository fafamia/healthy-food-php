<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("../../connect_chd104g3.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST['article_title']) &&
        isset($_POST['article_class']) &&
        isset($_POST['article_description']) &&
        isset($_POST['article_status'])
    ) {
        // 驗證 article_class 是否存在於 article_class 表格中
        $articleClassExists = false;
        $checkArticleClassQuery = $pdo->prepare("SELECT * FROM `article_class` WHERE `category_no` = :article_class");
        $checkArticleClassQuery->bindParam(':article_class', $_POST['article_class']);
        $checkArticleClassQuery->execute();
        if ($checkArticleClassQuery->rowCount() > 0) {
            $articleClassExists = true;
        }

        if (!$articleClassExists) {
            echo json_encode(['success' => false, 'message' => '新增文章失敗: 專欄分類不存在']);
            exit();
        }

        $article_title = $_POST['article_title'];
        $article_class = $_POST['article_class'];
        $article_description = $_POST['article_description'];
        $article_status = $_POST['article_status'];

        // 定義上傳目錄
        $uploadDir = "../../../images/article"; //部屬
        // $uploadDir = "C:/Users/T14 Gen 3/Desktop/團專後台/src/assets/images/article/"; //本地端

        // 如果有上傳封面圖片
        if (!empty($_FILES['cover_photo']['tmp_name'])) {
            $uploadFile = $uploadDir . '/' . basename($_FILES['cover_photo']['name']);

            if (move_uploaded_file($_FILES['cover_photo']['tmp_name'], $uploadFile)) {
                // 文件移動成功，保存文件路徑
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
                    `article_class`,
                    `article_description`,
                    `cover_photo`,
                    `content`,  
                    `creation_time`, 
                    `article_status`
                ) VALUES (
                    :article_title,
                    :article_class,
                    :article_description,
                    :cover_photo,
                    :content,  
                    :creation_time,  
                    :article_status
                )
            ");

            $query->bindParam(':article_title', $article_title);
            $query->bindParam(':article_class', $article_class);
            $query->bindParam(':article_description', $article_description);
            $query->bindParam(':cover_photo', $cover_photo);
            $query->bindParam(':content', $_POST['content']);  
            $query->bindParam(':creation_time', $_POST['creation_time']);
            $query->bindParam(':article_status', $article_status);

            // 執行查詢
            $query->execute();

            echo json_encode(['success' => true, 'message' => '新增文章成功']);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => '新增文章失敗: ' . $e->getMessage()]);
        }

    } else {
        echo json_encode(['error' => 'POST 資料缺少']);
    }
}

$pdo = null;
?>


