<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type:application/json;charset=utf-8");

try {

    require_once("../../connect_chd104g3.php");
    $data = json_decode(file_get_contents('php://input'), true);

    $sql = "UPDATE `members` SET member_status = :member_status  WHERE member_no = :member_no";

    $member = $pdo->prepare($sql);
    $member->bindValue(":member_no", $data['member_no']);
    $member->bindValue(":member_status", $data['member_status']);
    $member->execute();

    $result = ["error" => false, "msg" => "更新成功"];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}
echo json_encode($result);
