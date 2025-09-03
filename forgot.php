<?php
session_start();
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>忘記密碼</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<main class="container">
    <h1>忘記密碼</h1>
    <form method="post" action="reset_password.php" class="form-box">
        <label for="account">帳號：</label>
        <input type="text" id="account" name="account" required>

        <label for="email">註冊時的電子郵件：</label>
        <input type="email" id="email" name="email" required>

        <button type="submit">寄送重設密碼連結</button>
    </form>
</main>

</body>
</html>
