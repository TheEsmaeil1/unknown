<?php
include 'db.php';

$show_success_message = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO messages (name, message) VALUES (:name, :message)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':message', $message);
    $stmt->execute();

    $show_success_message = true;
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پیام ناشناس</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazir-font/dist/font-face.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="style.css">
</head>
<body class="rtl">
<div class="container">
    <h2 class="my-4 text-center">ارسال پیام ناشناس برای اسماعیل</h2>

    <?php if ($show_success_message): ?>
        <div id="success-alert" class="alert alert-success text-center">پیام شما با موفقیت ارسال شد!</div>
    <?php endif; ?>

    <form method="post" action="index.php" class="text-right">
        <div class="form-group">
            <label for="name">نام شما (اختیاری):</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="نام خود را وارد کنید">
        </div>
        <div class="form-group">
            <label for="message">پیام:</label>
            <textarea class="form-control" id="message" name="message" rows="5" required placeholder="پیام خود را بنویسید..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-block">ارسال پیام</button>
    </form>
</div>

<script>
    <?php if ($show_success_message): ?>
    document.addEventListener("DOMContentLoaded", function() {
        const alert = document.getElementById('success-alert');
        alert.classList.add('show');
        setTimeout(() => {
            alert.classList.remove('show');
        }, 5000);
    });
    <?php endif; ?>
</script>
</body>
</html>
