<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once("test_local_pdo.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["banner_id"])) {
        $bannerIdToDelete = $_POST["banner_id"];
        $banners = [];
        $indexToDelete = -1;
        foreach ($banners as $index => $banner) {
            if ($banner["id"] == $bannerIdToDelete) {
                $indexToDelete = $index;
                break;
            }
        }
        if ($indexToDelete > -1) {
            unset($banners[$indexToDelete]);
            file_put_contents("banners.json", json_encode($banners));
            echo json_encode(array("message" => "横幅成功刪除"));
            http_response_code(200);
        } else {
            echo json_encode(array("message" => "未找到要刪除的横幅"));
            http_response_code(404);
        }
    } else {
        echo json_encode(array("message" => "未提供要刪除的横幅編號"));
        http_response_code(400);
    }
} else {
    echo json_encode(array("message" => "僅支持 POST 請求"));
    http_response_code(405);
}
?>
