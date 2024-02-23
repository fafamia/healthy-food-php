<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); // 确保这里的域名与前端应用匹配，且没有尾随斜线
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Credentials:true");
header("Content-Type:application/json;charset=utf-8");


$member_email = $_POST["memId"];
$member_password = $_POST["memPsw"];

$errMsg = "";
try {
    require_once("../../connect_chd104g3.php");

    $sql = "SELECT `member_no`, `member_level`, `member_name`, `member_email`, `member_tel`, `member_birth`, `member_county`, `member_city`, `member_addr`, `member_total_amount`, `member_time`, `member_photo`, `member_status` from `members` where member_email=:memId and member_password=:memPsw";

    $members = $pdo->prepare($sql); //先編譯好
    $members->bindValue(":memId", $member_email); //代入資料
    $members->bindValue(":memPsw", $member_password);
    $members->execute(); //執行之

    if ($members->rowCount() == 0) { //找不到
        $errMsg .= "帳密錯誤, <router-link to='/'>重新登入</router-link><br>";
    } else {

        $memRow = $members->fetch(PDO::FETCH_ASSOC);

        //登入成功,將登入者的資料寫入cookie (cookie中寫入的資料可能會換，目前先暫時這樣)
        setcookie("member_no", $memRow["member_no"], time() + (7 * 24 * 60 * 60));
        setcookie("member_email", $memRow["member_email"], time() + (7 * 24 * 60 * 60));
        setcookie("member_name", $memRow["member_name"], time() + (7 * 24 * 60 * 60));

        // echo json_encode(["message" => "登入成功", "status" => "success"]);
        echo json_encode(["message" => "登入成功", "status" => "success", "member" => $memRow]);
    }
} catch (PDOException $e) {
    $errMsg .= "錯誤 : " . $e->getMessage() . "<br>";
    $errMsg .= "行號 : " . $e->getLine() . "<br>";
}
