<?php
    try{
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
        header('Content-Type: application/json');
        require_once("../../connect_chd104g3.php");
        //先寫進主訂單
        $pdo->beginTransaction();
        // JSON paload
        $orderData = json_decode(file_get_contents('php://input'), true);
        $sqlOrder = "INSERT INTO orders (
            ord_no,ord_time, member_no, member_name, ord_name, take_mail, take_tal, take_address, ord_shipping, payment_status, delivery_fee, odr_amount, sales_amount, ord_payment) 
        VALUES (
            :ord_no,now(),:member_no,:member_name,:ord_name,:take_mail,:take_tal,:take_address,:ord_shipping,:payment_status,:delivery_fee,:odr_amount,:sales_amount,:ord_payment)";
        $orderDatas = $pdo->prepare($sqlOrder);
        $orderInfo = $orderData['orderInfo'];
        $userData = $orderData['userData'];
        $ord_no = time();
        $orderDatas->bindParam(':ord_no',$ord_no);
        $orderDatas->bindParam(':member_no',$userData['member_no']);
        $orderDatas->bindParam(':member_name',$userData['member_name']);
        $orderDatas->bindParam(':ord_name',$orderInfo['ord_name']);
        $orderDatas->bindParam(':take_mail',$orderInfo['take_mail']);
        $orderDatas->bindParam(':take_tal',$orderInfo['take_tal']);
        $orderDatas->bindParam(':take_address',$orderInfo['take_address']);
        $orderDatas->bindParam(':ord_shipping',$orderInfo['ord_shipping']);
        $orderDatas->bindParam(':payment_status',$orderInfo['payment_status']);
        $orderDatas->bindParam(':delivery_fee',$orderInfo['delivery_fee']);
        $orderDatas->bindParam(':odr_amount',$orderInfo['odr_amount']);
        $orderDatas->bindParam(':sales_amount',$orderInfo['sales_amount']);
        $orderDatas->bindParam(':ord_payment',$orderInfo['ord_payment']);
        if (!$orderDatas->execute()) {
            print_r($orderDatas->errorInfo());
        }
        //商品資料和主訂單的PK寫進訂單明細
        $carList = $orderData['carList'];
        $ord_index = $pdo->lastInsertId();
        foreach($carList as $product){
            $sqlOrderDetail = "INSERT INTO order_details 
                    (ord_index,ord_no, product_no, product_name, product_price, product_quantity) 
                    VALUES 
                    (:ord_index,:ord_no, :product_no, :product_name, :product_price, :product_quantity)";
            $detailStmt = $pdo->prepare($sqlOrderDetail);
            $detailStmt->bindParam(':ord_index',$ord_index);
            $detailStmt->bindParam(':ord_no',$ord_no);
            $detailStmt->bindParam(':product_no',$product['product_no']);
            $detailStmt->bindParam(':product_name',$product['product_name']);
            $detailStmt->bindParam(':product_price',$product['product_price']);
            $detailStmt->bindParam(':product_quantity',$product['product_quantity']);
            if (!$detailStmt->execute()) {
                print_r($detailStmt->errorInfo());
            }
        }
        $pdo->commit();
        $result = ["error" => false, "msg" => "新增成功"];
    }catch(PDOException $e){
        $result = ["error" => true, "msg"=>$e->getMessage()];
    }
    echo json_encode($result);
?>