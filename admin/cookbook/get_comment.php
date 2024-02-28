<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Content-Type: application/json; charset=utf-8');

    require_once("../../connect_chd104g3.php");

    $sql = "SELECT * FROM comment order by 1";

    $comment = $pdo->query($sql);
    $commentRows = $comment->fetchAll(PDO::FETCH_ASSOC);
    // header('Content-Type: application/json');
    $result=["error"=> false,'msg'=>'',"comment"=> $commentRows];
    // echo json_encode($commentRows);
} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);

?>