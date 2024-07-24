<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
include 'loginlimit.php';
session_start();
header("Content-Type: text/html;charset=utf-8");
// $Id:$ //声明变量
header("Location:login.php?err=10");
$username = isset($_POST['username']) ? $_POST['username'] : "";
$password = isset($_POST['password']) ? $_POST['password'] : "";
$remember = isset($_POST['remember']) ? $_POST['remember'] : ""; //判断用户名和密码是否为空
echo 1;
//验证码判断
include "waf.php";
if(waf($username)!=$username||waf($password)!=$password){
    header("Location:login.php?err=5");
    die();
}
$code=isset($_POST['code']) ? $_POST['code'] : "";
$real_code=$_SESSION["code"];
if($code!==$real_code){
    header("Location:login.php?err=3");
}
else if (!empty($username) && !empty($password)) { //建立连接

    $conn = mysqli_connect('localhost', 'root', 'root', 'user'); //准备SQL语句
    echo 3;
    $password=md5($password);
    $sql_select = "SELECT username,password,login_attempts FROM usertext WHERE username = '$username' AND password = '$password'"; //执行SQL语句
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret); //判断用户名或密码是否正确
    echo 4;

    if(isUserErr($username,$password))
    {
        //登录次数过多
        header("Location:login.php?err=4");
    }
    else if ($username == $row['username'] && $password == $row['password'])
    { //选中“记住我” //本来在登录界面有一个记住我的单选框，但是后来觉得太难看删掉了，但是代码里没有删，反正不会报错就行了，懒得改了
        if ($remember == "on")
        { //创建cookie
            setcookie("", $username, time() + 7 * 24 * 3600);
        } //开启session
        session_start(); //创建session
        $_SESSION['user'] = $username; //写入日志
        $login_attempts = $row['login_attempts'] + 1;

        $sql_update = "UPDATE usertext SET login_attempts=$login_attempts WHERE username='$username';"; //执行SQL语句
        $retval = mysqli_query( $conn, $sql_update );
        // 检查登录次数是否超过阈值
        $max_login_attempts = 3; // 设置阈值
        if ($login_attempts > $max_login_attempts) {
            // 重定向到修改密码页面

            header("Location:login.php?err=10");
        }else {
//        $ip = $_SERVER['REMOTE_ADDR'];
//        $date = date('Y-m-d H:m:s');
//        $info = sprintf("当前访问用户：%s,IP地址：%s,时间：%s /n", $username, $ip, $date);
//        $sql_logs = "INSERT INTO logs(username,ip,date) VALUES('$username','$ip','$date')";
//        //日志写入文件，如实现此功能，需要创建文件目录logs
//        $f = fopen('./logs/' . date('Ymd') . '.log', 'a+');
//        fwrite($f, $info);
//        fclose($f); //跳转到loginsucc.php页面
//        echo "ysxdsz";
            header("Location:index.php"); //关闭数据库,跳转至loginsucc.php
            mysqli_close($conn);
            echo 4;
        }
    }
    else
    {
        //用户名或密码错误，赋值err为1
        header("Location:login.php?err=1");
    }
} else { //用户名或密码为空，赋值err为2
    header("Location:login.php?err=2");
}