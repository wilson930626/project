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

    // 先取得現有資料
    $stmt = $pdo->prepare("SELECT name, age, height, weight, gender, exercise FROM account WHERE acc = :acc");
    $stmt->execute([':acc' => $_SESSION['acc']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "找不到使用者資料";
        exit();
    }

    // 活動量文字對應數值
    $activity_map = [
        '低活動量' => 1.2,
        '輕微活動量' => 1.375,
        '中等活動量' => 1.55,
        '高活動量' => 1.725,
        '超高活動量' => 1.9,
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 取得POST資料並簡單驗證
        $name = trim($_POST['name'] ?? '');
        $age = intval($_POST['age'] ?? 0);
        $height = floatval($_POST['height'] ?? 0);
        $weight = floatval($_POST['weight'] ?? 0);
        $gender = $_POST['gender'] ?? '';
        $activity_text = $_POST['activity'] ?? '';

        if ($name === '' || $age <= 0 || $height <= 0 || $weight <= 0 || !in_array($gender, ['男', '女']) || !isset($activity_map[$activity_text])) {
            $error = "請填寫完整且正確的資料";
        } else {
            $exercise = $activity_map[$activity_text];

            // 更新 tdee 也一起算
            if ($gender === '男') {
                $bmr = 66 + (13.7 * $weight) + (5 * $height) - (6.8 * $age);
            } else {
                $bmr = 655 + (9.6 * $weight) + (1.8 * $height) - (4.7 * $age);
            }
            $tdee = round($bmr * $exercise);

            $update_sql = "UPDATE account SET name=:name, age=:age, height=:height, weight=:weight, gender=:gender, exercise=:exercise, tdee=:tdee WHERE acc=:acc";
            $stmt = $pdo->prepare($update_sql);
            $stmt->execute([
                ':name' => $name,
                ':age' => $age,
                ':height' => $height,
                ':weight' => $weight,
                ':gender' => $gender,
                ':exercise' => $exercise,
                ':tdee' => $tdee,
                ':acc' => $_SESSION['acc'],
            ]);

            header("Location: account_view.php");
            exit();
        }
    }

} catch (PDOException $e) {
    die("資料庫錯誤：" . $e->getMessage());
}

// 預設值顯示
$current_activity_text = '';
foreach ($activity_map as $k => $v) {
    if ($v == $user['exercise']) {
        $current_activity_text = $k;
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8" />
  <title>編輯基本資料</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .input-row {
      margin-bottom: 15px;
    }
    label {
      display: inline-block;
      width: 70px;
      font-weight: bold;
    }
    input[type="text"], input[type="number"], select {
      padding: 6px;
      width: 200px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .unit {
      margin-left: 4px;
    }
    .account-btn-right {
      margin-top: 20px;
    }
    .account-btn {
      padding: 10px 20px;
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .account-btn:hover {
      background-color: #555;
    }
    .error {
      color: red;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
  <h2 class="title">帳戶設定</h2>
  <?php if (!empty($error)) : ?>
    <div class="error"><?=htmlspecialchars($error)?></div>
  <?php endif; ?>
  <div class="account-section">
    <div class="account-subtitle">基本資訊</div>
    <form method="post" action="">
      <div class="input-row">
        <label for="name">暱稱</label>
        <input type="text" id="name" name="name" value="<?=htmlspecialchars($user['name'])?>" required>
      </div>
      <div class="input-row">
        <label for="age">年紀</label>
        <input type="number" id="age" name="age" value="<?=htmlspecialchars($user['age'])?>" required>
      </div>
      <div class="input-row">
        <label for="height">身高</label>
        <input type="number" id="height" name="height" value="<?=htmlspecialchars($user['height'])?>" step="0.1" required>
        <span class="unit">cm</span>
      </div>
      <div class="input-row">
        <label for="weight">體重</label>
        <input type="number" id="weight" name="weight" value="<?=htmlspecialchars($user['weight'])?>" step="0.1" required>
        <span class="unit">kg</span>
      </div>
      <div class="input-row">
        <label>性別</label>
        <select id="gender" name="gender" required>
          <option value="男" <?=($user['gender']=='男')?'selected':''?>>男</option>
          <option value="女" <?=($user['gender']=='女')?'selected':''?>>女</option>
        </select>
      </div>
      <div class="input-row">
        <label for="activity">活動量</label>
        <select id="activity" name="activity" required>
          <option value="低活動量" <?=($current_activity_text=='低活動量')?'selected':''?>>低活動量</option>
          <option value="輕微活動量" <?=($current_activity_text=='輕微活動量')?'selected':''?>>輕微活動量</option>
          <option value="中等活動量" <?=($current_activity_text=='中等活動量')?'selected':''?>>中等活動量</option>
          <option value="高活動量" <?=($current_activity_text=='高活動量')?'selected':''?>>高活動量</option>
          <option value="超高活動量" <?=($current_activity_text=='超高活動量')?'selected':''?>>超高活動量</option>
        </select>
      </div>
      <div class="account-btn-right">
        <button type="submit" class="account-btn">完成</button>
        <button type="button" class="account-btn" onclick="window.location.href='account_view.php'">取消</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
