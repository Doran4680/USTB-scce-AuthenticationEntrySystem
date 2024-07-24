<?php

// verify-login.php

if (isset($_GET['request_id'])) {
    $requestId = $_GET['request_id'];
    // 数据库连接
    $conn = mysqli_connect('localhost', 'root', 'root', 'user');
    if (!$conn) {
        die('数据库连接失败: ' . mysqli_connect_error());
    }
    // 更新登录状态
    $sql = "UPDATE login_requests SET status='confirmed' WHERE request_id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $requestId);
        $stmt->execute();
        $stmt->close();
    }
    // 登录成功后，设置session变量
    session_start();
    $_SESSION['user_logged_in'] = true;
    $_SESSION["user"]="phone_user";
    // 重定向到登录成功页面
    header('Location: https://app7013.acapp.acwing.com.cn/index.php');
    exit;
}
