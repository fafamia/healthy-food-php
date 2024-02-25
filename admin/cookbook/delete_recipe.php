<?php
try {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header('Content-Type: application/json; charset=utf-8');

    require_once("../../connect_chd104g3.php");

    // 检查是否收到了食谱编号
    if(isset($_GET['recipe_no'])) {
        $recipeNo = $_GET['recipe_no'];
        
        // 使用 prepared statement 來避免 SQL 注入攻擊
        $sql = "DELETE FROM recipe WHERE recipe_no = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $recipeNo, PDO::PARAM_INT); // 第一个参数是参数的索引（从1开始），第二个参数是参数的值，第三个参数是参数的数据类型
        $stmt->execute();

        // 检查删除操作是否成功
        if($stmt->rowCount() > 0) {
            echo json_encode(array('message' => 'Recipe deleted successfully'));
        } else {
            echo json_encode(array('error' => 'Failed to delete recipe'));
        }
    } else {
        echo json_encode(array('error' => 'Recipe ID not provided'));
    }
} catch (PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
?>
