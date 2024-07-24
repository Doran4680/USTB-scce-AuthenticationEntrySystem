<!DOCTYPE html>
<html>
<head>
    <title>确认登录</title>
    <link rel="stylesheet" href="phone.css">
    <link rel="icon" href="/images/logo.png">
    <meta name="content-type";
          charset="UTF-8">
</head>
<body>
<div class="center">
    <a href="index.php">
        <img src="images/b.png" alt="二维码">
    </a>
    <p><?php
        session_start();
        $_SESSION["user"]="admin";
        $username='微信扫码登录';
        echo "<span style='color:darkseagreen;font-weight: bold; font-size:50px; font-family:Great Vibes,Impact;'>$username</span>";
        ?></p>
</div>
</body>
</html>

