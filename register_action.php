<?php
session_start();

$dsn = "mysql:host=localhost;dbname=fit_ai;charset=utf8";
$dbUser = "root";
$dbPass = "";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("資料庫連線失敗：" . $e->getMessage());
}

// 取得 POST 資料
$name = trim($_POST['nickname'] ?? '');
$age = intval($_POST['age'] ?? 0);
$gender = $_POST['gender'] ?? '';
$height = floatval($_POST['height'] ?? 0);
$weight = floatval($_POST['weight'] ?? 0);
$activity = $_POST['activity'] ?? '';
$acc = trim($_POST['acc'] ?? '');
$password = trim($_POST['password'] ?? '');

// 簡單驗證
if ($name === '' || $age <= 0 || !in_array($gender, ['男', '女']) || $height <= 0 || $weight <= 0 || $acc === '' || $password === '') {
    echo "<script>alert('請填寫完整且正確的資料'); history.back();</script>";
    exit();
}

// 活動量字串轉活動係數
$activity_map = [
    '低活動量' => 1.2,
    '輕微活動量' => 1.375,
    '中等活動量' => 1.55,
    '高活動量' => 1.725,
    '超高活動量' => 1.9,
];
$exercise = $activity_map[$activity] ?? 1.2;

// 計算 BMR
if ($gender === '男') {
    $bmr = 66 + (13.7 * $weight) + (5 * $height) - (6.8 * $age);
} else {
    $bmr = 655 + (9.6 * $weight) + (1.8 * $height) - (4.7 * $age);
}

// 計算 TDEE
$tdee = round($bmr * $exercise);

// 檢查帳號是否存在
$stmt = $pdo->prepare("SELECT COUNT(*) FROM account WHERE acc = :acc");
$stmt->execute([':acc' => $acc]);
if ($stmt->fetchColumn() > 0) {
    echo "<script>alert('帳號已存在，請換一個'); history.back();</script>";
    exit();
}

// 寫入資料庫
$sql = "INSERT INTO account (name, age, gender, height, weight, exercise, tdee, acc, password) 
        VALUES (:name, :age, :gender, :height, :weight, :exercise, :tdee, :acc, :password)";

$stmt = $pdo->prepare($sql);
$result = $stmt->execute([
    ':name' => $name,
    ':age' => $age,
    ':gender' => $gender,
    ':height' => $height,
    ':weight' => $weight,
    ':exercise' => $exercise,
    ':tdee' => $tdee,
    ':acc' => $acc,
    ':password' => $password
]);

if ($result) {
    echo "<script>alert('註冊成功，請登入'); window.location.href='login.php';</script>";
} else {
    echo "<script>alert('註冊失敗，請稍後再試'); history.back();</script>";
}
