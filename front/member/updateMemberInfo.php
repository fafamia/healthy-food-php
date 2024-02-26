<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type:application/json;charset=utf-8");

try {

    require_once("../../connect_chd104g3.php");
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $sql = "UPDATE `members` SET  
    `member_name` = :member_name, 
    `member_email` = :member_email, 
    `member_tel` = :member_tel, 
    `member_county` = :member_county,
    `member_city` = :member_city,
    `member_addr` = :member_addr,
    `member_birth` = :member_birth
    WHERE `member_no` = :member_no";

    $member = $pdo->prepare($sql);

    $member->bindValue(':member_name', $data['member_name']);
    $member->bindValue(':member_email', $data['member_email']);
    $member->bindValue(':member_tel', $data['member_tel']);
    $member->bindValue(':member_county', $data['member_county']);
    $member->bindValue(':member_city', $data['member_city']);
    $member->bindValue(':member_addr', $data['member_addr']);
    $member->bindValue(':member_birth', $data['member_birth']);
    $member->bindValue(':member_no', $data['member_no']);

    $member->execute();

    $result = ["error" => false, "msg" => "更新成功"];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}
echo json_encode($result);
