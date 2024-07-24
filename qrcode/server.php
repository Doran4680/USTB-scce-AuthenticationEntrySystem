<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);
session_start();
// 生成随机请求ID
$requestId = bin2hex(random_bytes(16));
// 数据库连接
$conn = mysqli_connect('localhost', 'root', 'root', 'user');
if (!$conn) {
    die('数据库连接失败: ' . mysqli_connect_error());
}
// 保存请求ID到数据库
$sql = "INSERT INTO login_requests (request_id) VALUES (?)";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $requestId);
    $stmt->execute();
    $stmt->close();
}
// 生成二维码
require_once 'vendor/autoload.php';
use Endroid\QrCode\QrCode;
$qrCodeUrl = "https://app7013.acapp.acwing.com.cn/verify-login.php?request_id=$requestId";
// 创建二维码对象
$qrCode = new QrCode($qrCodeUrl);
// 设置输出类型为PNG
header('Content-Type: '.$qrCode->getContentType());
// 输出二维码
echo $qrCode->writeString();
$conn->close();

?>