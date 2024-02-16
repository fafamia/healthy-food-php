<?php
    try{
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        require_once("../../connect_chd104g3.php");

        $sql = "INSERT INTO product VALUES (:product_no,:product_class_name,:product_tag_name,:product_name,:product_info,:product_loc,:product_standard,:product_content,:product_price,:product_image,:product_status)";
        $products = $pdo->prepare($sql);
        //用$_POST接收input的資料
        $products->bindValue(":product_no",$_POST["product_no"]);
        $products->bindValue(":product_class_name",$_POST["product_class_name"]);
        $products->bindValue(":product_tag_name",$_POST["product_tag_name"]);
        $products->bindValue(":product_name",$_POST["product_name"]);
        $products->bindValue(":product_info",$_POST["product_info"]);
        $products->bindValue(":product_loc",$_POST["product_loc"]);
        $products->bindValue(":product_standard",$_POST["product_standard"]);
        $products->bindValue(":product_content",$_POST["product_content"]);
        $products->bindValue(":product_price",$_POST["product_price"]);
        $products->bindValue(":product_status",$_POST["product_status"]);
        //圖片上傳檔案位置
        
        if(isset($_FILES["prodImgUpload"]) && $_FILES["prodImgUpload"]["error"] === 0){
            $dir = "../../../images/product/";
            if(!file_exists($dir)){
                mkdir($dir,0755,true);
            }
            //取得圖片檔名
            $fileName = pathinfo($_FILES["prodImgUpload"]["name"], PATHINFO_FILENAME);
            //取得圖片副檔名
            $fileExt = pathinfo($_FILES["prodImgUpload"]["name"], PATHINFO_EXTENSION);
            $fileImg = $fileName.'.'.$fileExt;
            $from = $_FILES["prodImgUpload"]["tmp_name"];//暫存檔名稱
            $to = $dir.$fileImg;//檔案名稱
            copy($from,$to);
            $products->bindValue(":product_image",$fileImg);
        }else{
            $products->bindValue(":product_image",'');
        }
    
        $products->execute();
        $result = ["error" => false, "msg" => "新增成功", "products" => $products];
    }catch(PDOException $e){
        $result = ["error" => true, "msg"=>$e->getMessage()];
    }
    echo json_encode($result);
?>