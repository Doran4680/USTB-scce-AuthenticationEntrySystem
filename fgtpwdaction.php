<?php
session_start();
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

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

$phone=isset($_POST['phone']) ? $_POST['phone'] : "";
$code=isset($_POST['code']) ? $_POST['code'] : "";
$new_pwd=isset($_POST['new_pwd']) ? $_POST['new_pwd'] : "";
if($phone!=""){
    $conn = mysqli_connect('localhost', 'root', 'root', 'user'); //准备SQL语句
    $sql_select = "SELECT phone from usertext where phone='$phone'"; //执行SQL语句
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret);
    if ($phone!=$row['phone']){
        header("Location:fgtpwd.php?err=3");
    }
    else {
        require "aliyun-dysms-php-sdk/api_demo/SmsDemo.php";
        $real_code = rand(111111, 999999);
        $signName = 'alei666登陆系统';
        $templateCode = 'SMS_302200405';
        $send = SmsDemo::sendSms($phone, $signName, $templateCode, $real_code);
        $_SESSION["code"] = $real_code;
        $_SESSION["user_phone"] = $phone;
        header("Location:fgtpwd.php?err=1");
    }
}
else if($code!=""){
    echo $code."---".$_SESSION["code"];
    if($code==$_SESSION["code"]){
        echo 2;
        $passwordErrors = checkPasswordComplexity($new_pwd);
        if(!empty($passwordErrors)){
            $errorMessage = '密码不符合要求:';
            foreach ($passwordErrors as $error) {
                $errorMessage .= "$error";
            }
            header("Location:fgtpwd.php?msg=$errorMessage");
        }else {
            $real_phone = $_SESSION["user_phone"];
            $new_pwd = md5($new_pwd);
            $conn = mysqli_connect('localhost', 'root', 'root', 'user'); //准备SQL语句
            $sql_select = "update usertext set password = '$new_pwd' where phone ='$real_phone';"; //执行SQL语句
            //echo $sql_select."<br>";
            $ret = mysqli_query($conn, $sql_select);

            $sql_select_user = "SELECT username from usertext where phone='$real_phone'"; //执行SQL语句
            $ret_user = mysqli_query($conn, $sql_select_user);
            $row_user = mysqli_fetch_array($ret_user);
            $user = $row_user["username"];
            $login_attempts = 0;
            $sql_update_login_attempts = "update usertext set login_attempts = $login_attempts where phone ='$real_phone';";
            mysqli_query($conn, $sql_update_login_attempts);
            header("Location:fgtpwd.php?err=2&user=$user");
        }
    }else{
        header("Location:fgtpwd.php?err=4");
    }
}

