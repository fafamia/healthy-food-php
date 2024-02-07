<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("connect_chd104g3.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['title']) && isset($_FILES['image'])) {
        $title = $_POST['title'];
        $uploadedFileName = $_FILES['image']['name'];
        $fileName = pathinfo($uploadedFileName, PATHINFO_FILENAME);
        $extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
        $targetDirectory = 'C:/Users/T14 Gen 3/Desktop/admin/src/assets/images/banner/';
        $copyFile =  "banner" . $fileName . '.' . $extension;
        $uploadedFile = $targetDirectory . $copyFile;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
            try {
                $query = $pdo->prepare("INSERT INTO banner_carousel (banner_title, banner_image) VALUES (:title, :image)");
                $query->bindParam(':title', $title);
                $query->bindParam(':image', $copyFile);
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
