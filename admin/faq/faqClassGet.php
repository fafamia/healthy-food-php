<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    $sql = "SELECT question_no, question_class FROM question_class";

    $faqclass = $pdo->query($sql);
    $faqclassRows = $faqclass->fetchAll(PDO::FETCH_ASSOC);
    $result = ["error" => false, "msg" => "", "faqclass" => $faqclassRows];

} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

echo json_encode($result);
?>