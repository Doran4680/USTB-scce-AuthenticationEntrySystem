<?php
function isUserErr($username,$password){
$UserErr = false;
    $conn = mysqli_connect('localhost', 'root', 'root', 'user'); //准备SQL语句
    $sql_select = "SELECT username,login_count FROM user_errlimit WHERE username = '$username' AND login_count>=0"; //执行SQL语句
    $ret = mysqli_query($conn, $sql_select);
    $row = mysqli_fetch_array($ret);
    mysqli_query($conn , "set names utf8");
    $sql_select2 = "SELECT login_time FROM `user_errlimit` WHERE username = ? AND TIMESTAMPDIFF(MINUTE, login_time, NOW()) <= 4";
    $stmt = $conn->prepare($sql_select2);
    $stmt->bind_param('s', $username); // 's' 表示字符串参数
    $stmt->execute();
    $result = $stmt->get_result();
    $row2 = $result->fetch_assoc();
    $stmt->close(); // 不要忘记关闭预处理语句
    if(!empty($row2['login_time'])){
        $loginTime = new DateTime($row2['login_time']);
        // 创建一个 DateTime 对象来表示当前时间
        $nowtime = new DateTime();
        // 计算时间差
        $interval = $nowtime->diff($loginTime);
        // 检查时间差是否小于5分钟
        if ($interval->s < 300) {
            if($row['login_count']>4)
            {
                $sql_updatetime = "UPDATE user_errlimit SET login_time=now() WHERE username='$username';"; //执行SQL语句
                $retval = mysqli_query( $conn, $sql_updatetime );
                mysqli_close($conn);
                return true;
            }
        }
        else
        {
            if($row['login_count']>4)
            {
                $sql_update = "UPDATE user_errlimit SET login_count=1 WHERE username='$username';"; //执行SQL语句
                $retval = mysqli_query( $conn, $sql_update );
                $sql_updatetime = "UPDATE user_errlimit SET login_time=now() WHERE username='$username';"; //执行SQL语句
                $retval = mysqli_query( $conn, $sql_updatetime );
                mysqli_close($conn);
                return false;
            }
        }
    }
    if($row){
        $sql_updatetime = "UPDATE user_errlimit SET login_time=now() WHERE username='$username';"; //执行SQL语句
        $retval = mysqli_query( $conn, $sql_updatetime );
        $sql_select3 = "SELECT username,password FROM usertext WHERE username = '$username' AND password = '$password'"; //执行SQL语句
        $ret3 = mysqli_query($conn, $sql_select3);
        $row3 = mysqli_fetch_array($ret3); //判断用户名或密码是否正确
        if($username == $row3['username'] && $password == $row3['password']){
            $sql_update = "UPDATE user_errlimit SET login_count=0 WHERE username='$username';"; //执行SQL语句
            $retval = mysqli_query( $conn, $sql_update );
            return false;
        }
        if($row['login_count']>4)
        {
            $sql_update = "UPDATE user_errlimit SET login_count=1 WHERE username='$username';"; //执行SQL语句
            $retval = mysqli_query( $conn, $sql_update );
            $UserErr = false;
        }
        else
        {
            $new_count=$row['login_count']+1;
            $sql_update = "UPDATE user_errlimit SET login_count='$new_count' WHERE username='$username';"; //执行SQL语句
            $retval = mysqli_query( $conn, $sql_update );
        }
    }
    mysqli_close($conn);
    return $UserErr;
}


//timestampdiff(MINUTE,$row['login_time'],now())<5

