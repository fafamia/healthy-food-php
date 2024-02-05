<?php
// admin_banner.php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
$host = "localhost";
$dbname = "food";
$username = "root";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['title']) && isset($_FILES['image'])) {
        $title = $_POST['title'];
        $uploadDir = 'C:\Users\T14 Gen 3\Desktop\admin\src\assets\images\banner';
        // $uploadDir = 'D:\Users\user\Desktop\admin\src\assets\images\banner';
        $uploadedFile = $uploadDir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
            try {
                $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $query = $db->prepare("INSERT INTO banner_carousel (banner_title, banner_image) VALUES (:title, :image)");
                $query->bindParam(':title', $title);
                $query->bindParam(':image', $uploadedFile);
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
