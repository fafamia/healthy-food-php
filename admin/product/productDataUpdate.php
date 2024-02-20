<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Content-Type: application/json');
    require_once("../../connect_chd104g3.php");

    $sql = "UPDATE product 
            SET product_class_no = :product_class_no, 
                product_tag_no = :product_tag_no,
                product_name = :product_name,
                product_info = :product_info,
                product_loc = :product_loc, 
                product_standard = :product_standard, 
                product_content = :product_content, 
                product_price = :product_price, 
                product_status = :product_status,
                product_img = :product_img
            WHERE product_no = :product_no";
    $products = $pdo->prepare($sql);

    $products->bindValue(":product_no",$_POST["product_no"]);
    $products->bindValue(":product_class_no",$_POST["product_class_no"]);
    $products->bindValue(":product_tag_no",$_POST["product_tag_no"]);
    $products->bindValue(":product_name",$_POST["product_name"]);
    $products->bindValue(":product_info",$_POST["product_info"]);
    $products->bindValue(":product_loc",$_POST["product_loc"]);
    $products->bindValue(":product_standard",$_POST["product_standard"]);
    $products->bindValue(":product_content",$_POST["product_content"]);
    $products->bindValue(":product_price",$_POST["product_price"]);
    $products->bindValue(":product_status",$_POST["product_status"]);
    //$products->bindValue(":product_img",$_POST["product_img"]);

    if(isset($_FILES["product_img"]) && $_FILES["product_img"]["error"] === 0){
        $dir = "../../../images/product/";
        if(!file_exists($dir)){
            mkdir($dir,0755,true);
        }
        //取得圖片檔名
        $fileName = pathinfo($_FILES["product_img"]["name"], PATHINFO_FILENAME);
        //取得圖片副檔名
        $fileExt = pathinfo($_FILES["product_img"]["name"], PATHINFO_EXTENSION);
        $fileImg = $fileName.'.'.$fileExt;
        $from = $_FILES["product_img"]["tmp_name"];//暫存檔名稱
        $to = $dir.$fileImg;//檔案名稱
        copy($from,$to);
        $products->bindValue(":product_img",$fileImg);
    }else{
        $products->bindValue(":product_img",'');
    }

    $products->execute();
    $result = ["error" => false, "msg"=>"", "products"=>$products];

} catch (PDOException $e) {
    $result = ["error" => true, "msg"=>$e->getMessage()];
}
echo json_encode($result);