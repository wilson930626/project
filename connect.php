<?php
$hostname = "localhost";  // MySQL的主機名稱
$username = "root";       // MySQL的使用者名稱
$password = "";           // MySQL的使用者密碼
$database = "fit_ai";     // 資料庫名稱

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8mb4", $username, $password);
    // 設定 PDO 錯誤模式為 Exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("資料庫連線失敗: " . $e->getMessage());
}
?>
