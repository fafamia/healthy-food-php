<?php
header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

try {
    require_once("../../connect_chd104g3.php");

    // 解析 JSON 數據
    $data = json_decode(file_get_contents('php://input'), true);

    $sql = "DELETE FROM `quiz_game` WHERE quiz_no = :quiz_no";
    $game = $pdo->prepare($sql);

    // 確保從解析的數據中獲取 quiz_no
    $game->bindValue(":quiz_no", $data["quiz_no"]);

    $game->execute();
    $rowCount = $game->rowCount();

    $result = ["error" => false, "msg" => "刪除{$rowCount}筆資料"];
} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

// 輸出結果
echo json_encode($result);
