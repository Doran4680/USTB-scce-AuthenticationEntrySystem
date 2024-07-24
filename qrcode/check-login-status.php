<?php

session_start();

// 数据库连接
$conn = mysqli_connect('localhost', 'root', 'root', 'user');
if (!$conn) {
    die('数据库连接失败: ' . mysqli_connect_error());
}

// 检查登录状态
$sql = "SELECT * FROM login_requests WHERE status='confirmed' LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // 登录成功，设置session变量
    $_SESSION['user_logged_in'] = true;

    // 返回登录成功响应
    $response = array(
        'logged_in' => true,
        'redirect_url' => 'https://app7013.acapp.acwing.com.cn/index.php'
    );
} else {
    $response = array(
        'logged_in' => false
    );
}

mysqli_close($conn);

// 输出JSON响应
header('Content-Type: application/json');
echo json_encode($response);
?>