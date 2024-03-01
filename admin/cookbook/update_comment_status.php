
<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Content-Type: application/json');
    require_once("../../connect_chd104g3.php");

    // 获取 POST 数据
    $postData = json_decode(file_get_contents("php://input"), true);

    // 检查是否有必要的数据
    if (!isset($postData["comment_no"]) || !isset($postData["comment_status"])) {
        throw new Exception("缺少必要的参数");
    }

    // 更新评论状态
    $commentNo = $postData["comment_no"];
    $commentStatus = $postData["comment_status"];

    $sql = "UPDATE comment SET comment_status = :commentStatus WHERE comment_no = :commentNo";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":commentStatus", $commentStatus);
    $stmt->bindParam(":commentNo", $commentNo);
    $stmt->execute();

    $result = ["success" => true, "msg" => "评论状态更新成功"];
} catch (Exception $e) {
    $result = ["success" => false, "msg" => $e->getMessage()];
}

echo json_encode($result);
?>