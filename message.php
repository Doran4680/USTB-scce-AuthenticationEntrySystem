<?php
session_start();
$phone = isset($_POST['phone']) ? $_POST['phone'] : "";
echo $phone;
require "aliyun-dysms-php-sdk/api_demo/SmsDemo.php";
$code = rand(111111, 999999);
$signName = 'alei666登陆系统';
$templateCode = 'SMS_302200405';
$send = SmsDemo::sendSms($phone, $signName, $templateCode, $code);
$_SESSION["code"]=$code;
$_SESSION["user_phone"]=$phone;
header("Location:register.php?err=5");