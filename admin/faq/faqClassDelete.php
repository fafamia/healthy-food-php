<?php
$faqClass = json_decode(file_get_contents('php://input'), true);
    try{
        
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        require_once("../../connect_chd104g3.php");
    
        $sql = "DELETE FROM question_class WHERE question_no = :question_no ";
        $faqclass = $pdo->prepare($sql);
        $faqclass->bindValue(":question_no",$faqClass["question_no"]);
        $faqclass->execute();
        $rowcount = $faqclass->rowCount();

        $result = ["error" => false, "msg" => "刪除{$rowcount}筆資料"];
    }catch(PDOException $e){
        $result = ["error" => true, "msg"=>$e->getMessage()];
    }
    echo json_encode($result);
?>