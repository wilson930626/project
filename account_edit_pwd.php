<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>變更密碼</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
  <h2 class="title">修改密碼</h2>
  <div class="account-section">
    <form action="account_edit_pwd_action.php" method="post">
      <div class="input-row">
        <label>舊密碼</label>
        <input type="password" name="old_password" required>
      </div>
      <div class="input-row">
        <label>新密碼</label>
        <input type="password" name="new_password" required>
      </div>
      <div class="input-row">
        <label>確認新密碼</label>
        <input type="password" name="confirm_password" required>
      </div>
      <div class="account-btn-right">
        <button type="submit" class="account-btn">完成</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
