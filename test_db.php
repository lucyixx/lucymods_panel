<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$hostname = 'zygame.click';
$username = 'zygamezi_xyz';
$password = 'EMR+8Nl0Ff^21jd+'; // thay đúng mật khẩu
$database = 'zygamezi_panel';
$port     = 3306;

$conn = new mysqli($hostname, $username, $password, $database, $port);

if ($conn->connect_error) {
    die("❌ Kết nối thất bại: " . $conn->connect_error);
}

echo "✅ Kết nối thành công!";
$conn->close();
?>
