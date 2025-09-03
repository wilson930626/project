<?php
include 'connect.php';
session_start();

if (!isset($_SESSION['acc'])) {
    echo "<script>alert('請先登入'); window.location.href='login.php';</script>";
    exit();
}

$acc = $_SESSION['acc'];

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 取得使用者基本資料
    $stmt = $pdo->prepare("SELECT tdee, age, gender, weight FROM account WHERE acc = :acc LIMIT 1");
    $stmt->bindParam(':acc', $acc);
    $stmt->execute();

    if ($stmt->rowCount() === 0) {
        $error = "找不到使用者營養資料，請確認資料表有此帳號的記錄";
        $tdee = null;
        $age = $gender = $weight = null;
    } else {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $tdee = $row['tdee'] ?? null;
        $age = $row['age'] ?? null;
        $gender = $row['gender'] ?? null;
        $weight = $row['weight'] ?? null;
    }
} catch (PDOException $e) {
    die("資料庫連線失敗: " . $e->getMessage());
}

$goal = $_POST['goal'] ?? 'cut'; // 預設減脂

// 各目標的調整倍率
$goal_multiplier = [
    'cut'      => -300,
    'bulk'     => 300,
    'maintain' => 0
];

$adjusted_calories = null;
$protein_g = $carbs_g = $fat_g = null;

if (isset($tdee)) {
    // 1. 調整卡路里
    $multiplier = $goal_multiplier[$goal] ?? 1.0;
    $adjusted_calories = round($tdee + $multiplier);

    // 2. 計算蛋白質攝取係數
    function get_protein_factor($age, $gender) {
        if ($age === null || $gender === null) return 1.1; // 預設
        if ($age >= 10 && $age <= 12) return ($gender === '男' || $gender === 'm') ? 1.4 : 1.3;
        if ($age >= 13 && $age <= 15) return ($gender === '男' || $gender === 'm') ? 1.3 : 1.2;
        if ($age >= 16 && $age <= 18) return ($gender === '男' || $gender === 'm') ? 1.2 : 1.1;
        if ($age > 70) return 1.2;
        return 1.1;
    }

    $protein_factor = get_protein_factor($age, $gender);
    $protein_g = $weight ? round($weight * $protein_factor) : null;

    // 3. 碳水化合物：總熱量的 50%
    $carbs_cal = $adjusted_calories * 0.5;
    $carbs_g = round($carbs_cal / 4);

    // 4. 脂肪：總熱量的 25%
    $fat_cal = $adjusted_calories * 0.25;
    $fat_g = round($fat_cal / 9);
}

// ========= 新增紀錄處理 =========
if (isset($_POST['add_log'])) {
    $calories = $_POST['calories'];
    $protein  = $_POST['protein'];
    $carbs    = $_POST['carbs'];
    $fat      = $_POST['fat'];
    $note     = $_POST['note'] ?? '';

    $stmt = $pdo->prepare("INSERT INTO nutrition_log (acc, calories, protein, carbs, fat, note) 
                           VALUES (:acc, :calories, :protein, :carbs, :fat, :note)");
    $stmt->execute([
        ':acc' => $acc,
        ':calories' => $calories,
        ':protein' => $protein,
        ':carbs' => $carbs,
        ':fat' => $fat,
        ':note' => $note
    ]);
}

// ========= 查詢日期處理 =========
$selected_date = $_POST['selected_date'] ?? date('Y-m-d');

$stmt = $pdo->prepare("SELECT * FROM nutrition_log 
                       WHERE acc = :acc AND DATE(log_time) = :date 
                       ORDER BY log_time DESC");
$stmt->execute([':acc' => $acc, ':date' => $selected_date]);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_stmt = $pdo->prepare("SELECT 
                                SUM(calories) as total_calories,
                                SUM(protein) as total_protein,
                                SUM(carbs) as total_carbs,
                                SUM(fat) as total_fat
                             FROM nutrition_log
                             WHERE acc = :acc AND DATE(log_time) = :date");
$total_stmt->execute([':acc' => $acc, ':date' => $selected_date]);
$totals = $total_stmt->fetch(PDO::FETCH_ASSOC);

function e($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8" />
  <title>健身菜單</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include("navbar.php"); ?>

<div class="container">
  <!-- 目標選擇 -->
  <form method="post" id="goalForm">
    <label for="goal">請選擇你的目標：</label>
    <select name="goal" id="goal" onchange="document.getElementById('goalForm').submit();">
      <option value="cut" <?php if($goal === 'cut') echo 'selected'; ?>>減脂</option>
      <option value="bulk" <?php if($goal === 'bulk') echo 'selected'; ?>>增重</option>
      <option value="maintain" <?php if($goal === 'maintain') echo 'selected'; ?>>維持體態</option>
    </select>
  </form>

  <?php if (isset($error)): ?>
    <div style="color:crimson;"><?php echo e($error); ?></div>
  <?php else: ?>
    <!-- 建議攝取 -->
    <div class="summary" style="margin-top: 20px;">
      <div class="summary-box">
        <img src="project/kcal.png" alt="熱量" width="40" height="40">
        <div class="summary-content">
          建議攝取 熱量 <span class="summary-value"><?php echo e($adjusted_calories ?? ''); ?></span> 大卡
        </div>
      </div>
      <div class="summary-box">
        <img src="project/protein.png" alt="蛋白質" width="40" height="40">
        <div class="summary-content">
          建議攝取 蛋白質 <span class="summary-value"><?php echo e($protein_g ?? ''); ?></span> g
        </div>
      </div>
      <div class="summary-box">
        <img src="project/carb.png" alt="碳水化合物" width="40" height="40">
        <div class="summary-content">
          建議攝取 碳水化合物 <span class="summary-value"><?php echo e($carbs_g ?? ''); ?></span> g
        </div>
      </div>
      <div class="summary-box">
        <img src="project/fat.png" alt="脂肪" width="40" height="40">
        <div class="summary-content">
          建議攝取 脂肪 <span class="summary-value"><?php echo e($fat_g ?? ''); ?></span> g
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<!-- 新增紀錄 -->
<div class="container" style="margin-top:30px;">
  <h2>新增今日營養紀錄</h2>
  <form method="post" action="">
    <label>熱量 (kcal)：</label>
    <input type="number" name="calories" step="0.01" required><br>

    <label>蛋白質 (g)：</label>
    <input type="number" name="protein" step="0.01" required><br>

    <label>碳水化合物 (g)：</label>
    <input type="number" name="carbs" step="0.01" required><br>

    <label>脂肪 (g)：</label>
    <input type="number" name="fat" step="0.01" required><br>

    <label>備註：</label>
    <textarea name="note"></textarea><br>

    <button type="submit" name="add_log">新增紀錄</button>
  </form>
</div>

<!-- 查詢紀錄 -->
<div class="container" style="margin-top:30px;">
  <h2>紀錄查詢</h2>
  <form method="post">
    <label>選擇日期：</label>
    <input type="date" name="selected_date" value="<?php echo e($selected_date); ?>">
    <button type="submit">查詢</button>
  </form>

  <h3><?php echo e($selected_date); ?> 的總攝取</h3>
  <div class="summary" style="margin-top:20px; background:#f0f0f0; padding:10px;">
    <p>熱量：<?php echo e(number_format($totals['total_calories'] ?? 0, 2)); ?> kcal</p>
    <p>蛋白質：<?php echo e(number_format($totals['total_protein'] ?? 0, 2)); ?> g</p>
    <p>碳水：<?php echo e(number_format($totals['total_carbs'] ?? 0, 2)); ?> g</p>
    <p>脂肪：<?php echo e(number_format($totals['total_fat'] ?? 0, 2)); ?> g</p>
  </div>

  <h3>詳細紀錄</h3>
  <?php if ($logs): ?>
    <table border="1" cellpadding="8">
      <tr>
        <th>時間</th><th>熱量</th><th>蛋白質</th><th>碳水</th><th>脂肪</th><th>備註</th>
      </tr>
      <?php foreach ($logs as $log): ?>
        <tr>
          <td><?php echo e($log['log_time']); ?></td>
          <td><?php echo e($log['calories']); ?></td>
          <td><?php echo e($log['protein']); ?></td>
          <td><?php echo e($log['carbs']); ?></td>
          <td><?php echo e($log['fat']); ?></td>
          <td><?php echo e($log['note']); ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php else: ?>
    <p>該日期沒有紀錄</p>
  <?php endif; ?>
</div>

</body>
</html>
