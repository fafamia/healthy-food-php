<?php
// 允許跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// 引入 PhpSpreadsheet 库的自动加载器
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// 读取 Excel 文件
$spreadsheet = IOFactory::load('C:\Users\T14 Gen 3\Desktop\team\src\assets\food_cal_2022.xlsx');

// 获取第一个工作表
$sheet = $spreadsheet->getActiveSheet();

// 获取工作表中的数据
$data = [];
foreach ($sheet->getRowIterator() as $row) {
    $rowData = [];
    foreach ($row->getCellIterator() as $cell) {
        $rowData[] = $cell->getValue();
    }
    $data[] = $rowData;
}

// 转换数据为 JSON 格式
$jsonData = json_encode($data, JSON_PRETTY_PRINT);

// 将 JSON 数据写入文件
file_put_contents('C:\Users\T14 Gen 3\Desktop\team\src\assets\food_cal_2022.json', $jsonData);

echo 'Excel 文件已成功转换为 JSON 文件。';
?>
