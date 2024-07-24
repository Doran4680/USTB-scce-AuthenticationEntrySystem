<!DOCTYPE html>
<html>
<head>
    <title>找回密码</title>
    <link rel="stylesheet" href="fgtpwd.css">
    <link rel="icon" href="/images/logo.png">
    <meta name="content-type"; charset="UTF-8">
</head>
<body>
<div id="bigBox">
    <h1 style="font-weight: bold;">找回密码</h1>

    <form id="fgtpwd" action="fgtpwdaction.php" method="post">
        <div class="inputBox">

            <div class="inputText">
                <input type="text" id="phone" name="phone" placeholder="Phone" value="">
            </div>
            <div>
                <input type="submit" id="verification" name="verification" value="获得验证码" class="loginButton">
            </div>
        </div>
    </form>
    <form id="fgtpwd" action="fgtpwdaction.php" method="post">
        <div class="inputBox">
            <div class="inputText">
                <input type="code" id="code" name="code" placeholder="验证码">
            </div>
            <div class="inputText">
                <input type="text" id="new_pwd" name="new_pwd" placeholder="new_pwd" value="">
            </div>
            <div>
                <input type="submit" id="login" name="login" value="提交" class="loginButton">
            </div>

            <br >
            <div style="color: white;font-size: 12px" >
                <?php
                $err = isset($_GET["err"]) ? $_GET["err"] : "";
                switch ($err) {
                    case 1:
                        echo "验证码已发送！";
                        break;

                    case 2:
                        $user=$_GET["user"];
                        echo "密码重置成功,你的用户名字是".htmlentities($user)." !";
                        break;

                    case 3:
                        echo "电话号码不存在";
                        break;

                    case 4:
                        echo "验证码错误";
                        break;
                }
                if (isset($_GET['msg'])) {
                    echo '<div class="error-message">';
                    echo nl2br(htmlentities($_GET['msg'])); // 使用nl2br转换换行，并使用htmlentities转义HTML标签
                    echo '</div>';
                }
                ?>
            </div>
            <div >
                <a href="login.php" style="color: white">返回登陆</a>
            </div>
        </div>
</form>
</body>
</html>

