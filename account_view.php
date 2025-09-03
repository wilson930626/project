<?php
include 'connect.php';
session_start();
if (!isset($_SESSION['acc'])) {
    header("Location: login.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("SELECT name, age, height, weight, gender, exercise FROM account WHERE acc = :acc");
    $stmt->execute([':acc' => $_SESSION['acc']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "找不到使用者資料";
        exit();
    }
} catch (PDOException $e) {
    die("資料庫錯誤：" . $e->getMessage());
}

// 活動量轉文字映射（反向）
$activity_map = [
    '1.2' => '低活動量',
    '1.375' => '輕微活動量',
    '1.55' => '中等活動量',
    '1.725' => '高活動量',
    '1.9' => '超高活動量',
];
$exercise_value = trim($user['exercise']); // 確保沒有多餘空白
$activity_text = $activity_map[$exercise_value] ?? '未知';
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8" />
  <title>帳戶設定</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">
  <h2 class="title">帳戶設定</h2>

  <div class="account-section">
    <div class="account-subtitle">基本資訊</div>
    <p><strong>暱稱：</strong> <?=htmlspecialchars($user['name'])?></p>
    <p><strong>年紀：</strong> <?=htmlspecialchars($user['age'])?></p>
    <p><strong>身高：</strong> <?=htmlspecialchars($user['height'])?> cm</p>
    <p><strong>體重：</strong> <?=htmlspecialchars($user['weight'])?> kg</p>
    <p><strong>性別：</strong> <?=htmlspecialchars($user['gender'])?></p>
    <p><strong>活動量：</strong> <?=$activity_text?></p>
    <div class="account-btn-right">
      <button type="button" class="account-btn" onclick="window.location.href='account_edit_basic.php'">更改</button>
    </div>
  </div>

  <div class="account-section">
    <div class="account-subtitle">帳戶資訊</div>
    <p><strong>密碼：</strong> *********</p>
    <div class="account-btn-right">
      <button type="button" class="account-btn" onclick="window.location.href='account_edit_pwd.php'">更改</button>
    </div>
  </div>
  <!-- 登出按鈕 -->
  <div class="account-section" style="text-align: center; margin-top: 10px;">
    <button type="button" 
            style="background-color: red; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px;"
            onmouseover="this.style.backgroundColor='darkred';" 
            onmouseout="this.style.backgroundColor='red';"
            onclick="window.location.href='logout.php'">
      登出
    </button>
  </div>
</div>
</body>
</html>
