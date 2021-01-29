<?php

$userName=;
$passWord=;
$host='localhost';
$dataBase='homework';
$conn=mysqli_connect($host,$userName,$passWord,$dataBase);
if (mysqli_connect_errno($conn))
{
    echo "连接 MySQL 失败: " . mysqli_connect_error();
}

header("Content-type:text/csv;");
header("Content-Disposition:attachment;filename=" . date('YmdHis', time()).".csv");
header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
header('Expires:0');
header('Pragma:public');

function fputcsv2($handle, array $fields, $delimiter = ",", $enclosure = '"', $escape_char = "\\") {
    foreach ($fields as $k => $v) {
        $fields[$k] = iconv("UTF-8", "GB2312//IGNORE", $v);  // 这里将UTF-8转为GB2312编码
    }
    fputcsv($handle, $fields, $delimiter, $enclosure, $escape_char);
}

$tbName = 'assignment2';
$output = fopen('php://output', 'w');  //打开输出

//先获取一行，以便生成csv的首行, 列名
$sql="select * from {$tbName} limit 1";
$res = $conn->query($sql);
if(!$res)
    return;  //错误处理
$row = $res->fetch_assoc();
fputcsv2($output, array_keys($row));  //输出csv头部

//导出表数据
$sql="select * from {$tbName}";  //导出表内容
$res = $conn->query($sql);
while ($row = $res->fetch_assoc())
    fputcsv2($output, $row);
fclose($output);
