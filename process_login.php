<?php
include 'connect.php';
session_start();

// 檢查帳號與密碼是否存在於 POST 請求中
if (!isset($_POST['account']) || !isset($_POST['password'])) {
    echo "<script>alert('請輸入帳號與密碼'); window.location.href='login.php';</script>";
    exit();
}

$acc = $_POST['account'];
$password = $_POST['password'];

try {
    // 連接資料庫
    $pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 查詢帳號密碼是否正確
    $query = "SELECT * FROM account WHERE acc = :acc AND password = :password";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':acc', $acc);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    // 若有找到使用者
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 設定 session
        $_SESSION['acc'] = $user['acc'];
        $_SESSION['password'] = $user['password'];

        // 導向登入後頁面
        header("Location: first.php");
        exit();
    } else {
        // 登入失敗
        echo "<script>alert('登入失敗，帳號或密碼錯誤'); window.location.href='login.php';</script>";
        exit();
    }
} catch (PDOException $e) {
    echo "資料庫連接失敗：" . $e->getMessage();
    exit();
}
?>
