<?php
session_start();
header("Content-Type: text/html;charset=utf-8");
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
// $Id:$ //声明变量
$username = isset($_POST['username']) ? $_POST['username'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";
$re_password = isset($_POST['re_password']) ? $_POST['re_password'] : "";
$sex = isset($_POST['sex']) ? $_POST['sex'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
//$phone = isset($_POST['phone']) ? $_POST['phone'] : "";
$user_input_code = isset($_POST['code']) ? $_POST['code'] : "";
$right_code=$_SESSION["code"];
$real_phone=$_SESSION["user_phone"];

function checkPasswordComplexity($password) {
    $errors = [];
    if(strlen($password) < 8) {
        $errors[] = "必须不少于8个字节长度.";
    }
    if(!preg_match('/[A-Z]/', $password)) {
        $errors[] = "必须有至少一个大写字母.";
    }
    if(!preg_match('/[a-z]/', $password)) {
        $errors[] = "必须有至少一个小写字母.";
    }
    if(!preg_match('/\d/', $password)) {
        $errors[] = "必须有至少一个数字.";
    }
    if(!preg_match('/[\W_]/', $password)) {
        $errors[] = "必须有至少一个特殊字符.";
    }
    return $errors;
}

if($user_input_code!=$right_code){
    header("Location:register.php?err=4");
}
else if (($password == $re_password) ) { //建立连接
    $passwordErrors = checkPasswordComplexity($password);
    if (empty($passwordErrors)) {
    $conn = mysqli_connect("localhost", "root", "root", "user"); //准备SQL语句,查询用户名
    mysqli_set_charset($conn,"utf8");
    $sql_check="SELECT phone FROM usertext where phone='$real_phone'";
    $sql_select = "SELECT username FROM usertext WHERE username = '$username'"; //执行SQL语句
    $ret_phone=mysqli_query($conn,$sql_check);
    $ret = mysqli_query($conn, $sql_select);
    $row_phone=mysqli_fetch_array($ret_phone);
    $row = mysqli_fetch_array($ret); //判断用户名是否已存在
    if($real_phone==$row_phone["phone"]){
        header("Location:register.php?err=6");
    }else if ($username == $row['username']) { //用户名已存在，显示提示信息
        header("Location:register.php?err=1");
    } else { //用户名不存在，插入数据 //准备SQL语句
        $password=md5($password);
        $login_count=0;
        $sql_insert = "INSERT INTO usertext(username,password,sex,email,phone,login_attempts) VALUES('$username','$password','$sex','$email','$real_phone','$login_count')"; //执行SQL语句
        mysqli_query($conn, $sql_insert);

        $sql_insert = "INSERT INTO user_errlimit(username,login_count) VALUES('$username','$login_count')"; //执行SQL语句
        mysqli_query($conn, $sql_insert);
        header("Location:register.php?err=3");
    } //关闭数据库
    mysqli_close($conn);
    } else {
        // 密码不符合复杂度要求，显示错误信息
        $errorMessage = '密码不符合要求:';
        foreach ($passwordErrors as $error) {
            $errorMessage .= "$error";
        }
         header("Location:register.php?msg=$errorMessage");
    }
} else {
    header("Location:register.php?err=2");
} ?>

