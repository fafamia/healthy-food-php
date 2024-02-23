<?php
$faqData = json_decode(file_get_contents('php://input'), true);

try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    require_once("../../connect_chd104g3.php");

    $sql = "UPDATE faq SET faq_class = :faq_class, question = :question, ans = :ans, `key` = :key WHERE faq_no = :faq_no";
    $faqUpdate = $pdo->prepare($sql);

    $faqUpdate->bindValue(":faq_class", $faqData["faq_class"]);
    $faqUpdate->bindValue(":question", $faqData["question"]);
    $faqUpdate->bindValue(":ans", $faqData["ans"]);
    $faqUpdate->bindValue(":key", $faqData["key"]);
    $faqUpdate->bindValue(":faq_no", $faqData["faq_no"]);
    $faqUpdate->execute();

    $result = ["error" => false, "msg" => "FAQ 更新成功"];

} catch (PDOException $e) {
    $result = ["error" => true, "msg" => $e->getMessage()];
}

echo json_encode($result);
?>
