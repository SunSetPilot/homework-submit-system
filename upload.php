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

$id=$_POST['id'];
$name=$_POST['name'];
$ip = $_SERVER['REMOTE_ADDR'];
$result=$conn->query("select IsSubmit from `assignment2` where ID='$id' AND Name='$name';");
if (mysqli_num_rows($result) > 0) {
if ($result->fetch_object()->IsSubmit == '否'){
    $file0 = $_FILES["myfile0"];
    $filePath0 = $file0["tmp_name"];
    move_uploaded_file($filePath0, '/home/wwwroot/default/upload2/'.$id.'_'.$name.'_软件安全实验报告.zip');
    echo "<script>alert('提交成功！');location='index.html'</script>";
    mysqli_query($conn,"insert into SubmitRecord(ID,Name,Time,Result,IP) values('$id','$name',now(),'该用户提交成功！','$ip');");
    mysqli_query($conn,"update `assignment2` set IsSubmit='是' where ID='$id';");
} else {
    echo "<script>alert('提交失败！您已提交过该作业！');location='index.html'</script>";
    mysqli_query($conn, "insert into SubmitRecord(ID,Name,Time,Result,IP) values('$id','$name',now(),'该用户已经提交过，提交失败！','$ip');");
  }
}else echo "<script>alert('用户不存在！');location='index.html'</script>";
?>