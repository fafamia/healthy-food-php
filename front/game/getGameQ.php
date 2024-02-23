<?php
header("Access-Control-Allow-Origin: *"); // 确保这里的域名与前端应用匹配，且没有尾随斜线
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Credentials:true");
header("Content-Type:application/json;charset=utf-8");

try {
    require_once("../../connect_chd104g3.php");
    $sql = "SELECT * FROM quiz_game";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $game = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($game);
} catch (PDOException $e) {
    $msg .= "錯誤 : " . $e->getMessage() . "<br>";
    $msg .= "行號 : " . $e->getLine() . "<br>";
}
