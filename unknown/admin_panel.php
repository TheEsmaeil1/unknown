<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = MD5(:password)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['logged_in'] = true;
    } else {
        $error = "نام کاربری یا رمز عبور اشتباه است.";
    }
}

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    $stmt = $conn->prepare("SELECT * FROM messages ORDER BY created_at DESC");
    $stmt->execute();
    $messages = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font/dist/font-face.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="style.css">
</head>
<body class="rtl">
<div class="container">
    <h2 class="my-4 text-center">پنل مدیریت</h2>

    <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="post" action="admin_panel.php" class="text-right">
            <div class="form-group">
                <label for="username">نام کاربری:</label>
                <input type="text" class="form-control" id="username" name="username" required placeholder="نام کاربری را وارد کنید">
            </div>
            <div class="form-group">
                <label for="password">رمز عبور:</label>
                <input type="password" class="form-control" id="password" name="password" required placeholder="رمز عبور را وارد کنید">
            </div>
            <button type="submit" class="btn btn-primary btn-block">ورود</button>
        </form>
    <?php else: ?>
        <a href="logout.php" class="btn btn-danger mb-3">خروج</a>
        <div class="list-group">
            <?php foreach ($messages as $message): ?>
                <div class="list-group-item">
                    <h5 class="mb-1">از: <?= htmlspecialchars($message['name']) ?: 'ناشناس' ?></h5>
                    <p class="mb-1"><?= htmlspecialchars($message['message']) ?></p>
                    <small class="text-muted">ارسال شده در: <?= $message['created_at'] ?></small>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
