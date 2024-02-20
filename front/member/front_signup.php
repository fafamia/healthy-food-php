<?php
header("Access-Control-Allow-Origin: http://localhost:5173"); // 确保这里的域名与前端应用匹配，且没有尾随斜线
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Credentials:true");
header("Content-Type:application/json;charset=utf-8");

//前台抓到的資料
$member_name = $_POST['name'];
$member_tel = $_POST['tel'];
$member_email = $_POST['email'];
$member_password = $_POST['au4a83'];
$member_level = 1;
$member_total_amount = 0;
$member_status = 1;
$member_county = $_POST['county'];
$member_city = $_POST['city'];
$member_addr = $_POST['addr'];
$member_time = date('Y-m-d H:i:s');
//返回的message
$msg = "";
try {
    require_once("../../connect_chd104g3.php");

    //檢查email是否重複
    $checkEmailSql = "SELECT member_email FROM members WHERE member_email = :member_email";
    $stmt = $pdo->prepare($checkEmailSql);
    $stmt->bindParam(':member_email', $member_email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // 如果email已存在，返回錯誤消息
        $msg = "此email已被使用，請重新輸入";
    } else {

        //新增用戶資料至資料庫
        $sql = "INSERT INTO `food`.`members` (`member_level`, `member_password`, `member_name`, `member_email`, `member_tel`, `member_county`, `member_city`, `member_addr`, `member_total_amount`, `member_time`, `member_status`) VALUES (:member_level, :member_password, :member_name, :member_email, :member_tel, :member_county, :member_city, :member_addr, :member_total_amount, :member_time, :member_status)";

        $members = $pdo->prepare($sql); //先編譯好
        // 代入資料
        $members->bindValue(':member_level', $member_level);
        $members->bindValue(':member_password', $member_password);
        $members->bindValue(':member_name', $member_name);
        $members->bindValue(':member_email', $member_email);
        $members->bindValue(':member_tel', $member_tel);
        $members->bindValue(':member_county', $member_county);
        $members->bindValue(':member_city', $member_city);
        $members->bindValue(':member_addr', $member_addr);
        $members->bindValue(':member_total_amount', $member_total_amount);
        $members->bindValue(':member_time', $member_time);
        $members->bindValue(':member_status', $member_status);
        $members->execute(); // 執行

        $msg = "註冊成功";
    }
} catch (PDOException $e) {
    $msg .= "錯誤 : " . $e->getMessage() . "<br>";
    $msg .= "行號 : " . $e->getLine() . "<br>";
}
//輸出結果
$result = ["msg" => $msg];
echo json_encode($result);
