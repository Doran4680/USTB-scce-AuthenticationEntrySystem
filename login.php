<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>login</title>
        <link rel="icon" href="/images/logo.png">
        <link rel="stylesheet" href="/node_modules/bootstrap/dist/css/bootstrap.css">
        <script src="/node_modules/bootstrap/dist/js/bootstrap.js"></script>
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <div id="bigBox">
            <h1 style="font-weight: bold;">登录页面</h1>

            <form id="loginform" action="loginaction.php" method="post">
                <div class="inputBox">
                    <div class="inputText">
                        <input type="text" id="name" name="username" placeholder="Username" value="">
                    </div>
                <div class="inputText">
                    <input type="password" id="password" name="password" placeholder="Password">
                 </div>
                    <!-- 验证码图像 -->
                    <div class="inputText">
                        <!-- 验证码图像 -->
                        <img id="captchaImage" src="drawcode.php" alt="CAPTCHA Image" onclick="refreshCaptcha();">
                        <!-- 验证码输入框 -->
                        <div>
                            <input type="text" id="captchaInput" name="code" placeholder="Enter the code ">
                        </div>

                        <!-- 用于刷新验证码的JavaScript函数 -->
                        <script>
                            function refreshCaptcha() {
                                var img = document.getElementById('captchaImage');
                                img.src = 'drawcode.php?' + Math.random(); // 加随机数防止浏览器缓存
                            }
                        </script>
                        <!--<script>
                            function rcode() {
                                var imgcode = document.getElementById('imgcode');
                                imgcode.src = "drawcode.php";
                            }
                        </script>-->
                    </div>
                    <!-- 以上是验证码图像 -->

                    <div style="color: white;font-size: 12px" >
                        <?php
                        session_start();
                        $err = isset($_GET["err"]) ? $_GET["err"] : "";
                        switch ($err) {
                            case 1:
                                echo "用户名或密码错误！";
                                break;

                            case 2:
                                echo "用户名或密码不能为空！";
                                break;
                            case 3:
                                echo "验证码错误！";
                                break;
                            case 4:
                                echo "密码错误次数过多，账号锁定五分钟";
                                break;
                            case 5:
                                echo "有非法字符";
                                break;
                            case 10:
                                echo "密码使用次数超过限制，请更改密码";
                                break;
                        } ?>
                        <br >

                    </div>
                    <div style="display: flex; justify-content: space-evenly;">
                        <button type="button" class="btn btn-outline-light btn-sm"><a href="ewm.php" class="no-style-link">扫码登陆</a></button>
                        <button type="button" class="btn btn-outline-light btn-sm"><a href="register.php" class="no-style-link">注册账号</a></button>
                        <button type="button" class="btn btn-outline-light btn-sm"><a href="fgtpwd.php" class="no-style-link">忘记密码</a></button>
                    </div>
                </div>
                    <div>
                        <input type="submit" id="login" name="login" value="登 录" class="loginButton">
                    </div>
            </form>
        </div>
    </body>
</html>

