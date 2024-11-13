<?php
$servername = "localhost";
$username = "root"; // نام کاربری دیتابیس
$password = ""; // رمز عبور دیتابیس
$dbname = "anonymous";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "اتصال به دیتابیس ناموفق بود: " . $e->getMessage();
}
?>
