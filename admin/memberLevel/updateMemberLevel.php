<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Content-Type:application/json;charset=utf-8");

try {

    require_once("../../connect_chd104g3.php");
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $sql = "UPDATE `member_level` SET  `level_name` = :level_name, 
    `total_spend_start` = :total_spend_start, 
    `total_spend_end` = :total_spend_end, 
    `level_discount` = :level_discount
    WHERE `level_no` = :level_no";

    $level = $pdo->prepare($sql);
    $level->bindValue(":level_no", $data['level_no']);
    $level->bindValue(":level_name", $data['level_name']);
    $level->bindValue(":total_spend_start", $data['total_spend_start']);
    $level->bindValue(":total_spend_end", $data['total_spend_end']);
    $level->bindValue(":level_discount", $data['level_discount'] === null ? null : $data['level_discount']);

    $level->execute();

    $result = ["error" => false, "msg" => "更新成功"];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}
echo json_encode($result);
