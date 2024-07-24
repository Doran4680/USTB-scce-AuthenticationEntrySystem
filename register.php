<!DOCTYPE html>
<html>
<head>
    <title>注册</title>
    <link rel="stylesheet" href="register.css">
    <meta name="content-type"; charset="UTF-8">
    <link rel="icon" href="/images/logo.png">
</head>
<body>
<div id="bigBox">
    <h1>注册页面</h1>
    <form action="message.php" method="post">
        <div class="inputBox">
            <div class="inputText">
                <input type="text" id="phone" name="phone" required="required" placeholder="Phone">
            </div>
        </div>
        <div>
            <input type="submit" id="register" name="register" value="获取验证码" class="loginButton m-left">
        </div>
    </form>
    <form action="registeraction.php" method="post">
        <div class="inputBox">

            <div class="inputText">
                <input type="text" id="id_name" name="username" required="required" placeholder="Username">
            </div>
            <div class="inputText">
                <input type="password" id="password" name="password" required="required" placeholder="Password">
            </div>
            <div class="inputText">
                <input type="password" id="re_password" name="re_password" required="required" placeholder="PasswordAgain">
            </div>
            <div class="inputText m-plc" style="color: white;opacity: 70%">
                Sex：
                <input type="radio" id="sex" name="sex" value="man" style="color: white">男
                <input type="radio" id="sex" name="sex" value="woman" style="color: white">女
            </div>
            <div class="inputText">
                <input type="email" id="email" name="email" required="required" placeholder="Email">
            </div>
            <div class="inputText">
                <input type="text" id="code" name="code" required="required" placeholder="手机验证码">
            </div>
            <br>
            <div style="color: white;font-size: 12px" >
                <!--提示信息-->
                <?php

                $err = isset($_GET["err"]) ? $_GET["err"] : "";
                switch ($err) {
                    case 1:
                        echo "用户名已存在！";
                        break;

                    case 2:
                        echo "密码重复不一致！";
                        break;

                    case 3:
                        echo "注册成功！";
                        break;

                    case 4:
                        echo "验证码错误";
                        break;
                    case 5:
                        echo "验证码发送成功";
                        break;
                    case 6:
                        echo "手机号已被注册";
                        break;
                }
                ?>
            </div>
        </div>
        <div>
            <input type="submit" id="register" name="register" value="注册" class="loginButton m-left">
        </div>

        <div>
            <a href="login.php" style="color: white">已有账号，去登录</a>

        </div>
        <div style="color: white;font-size: 12px" > 
        <?php
        if (isset($_GET['msg'])) {
            echo '<div class="error-message">';
            echo nl2br(htmlentities($_GET['msg'])); // 使用nl2br转换换行，并使用htmlentities转义HTML标签
            echo '</div>';
        }
        ?>
        </div>
    </form>
</div>
</body>
</html>
