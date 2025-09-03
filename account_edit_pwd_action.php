<?php
session_start();

if (!isset($_SESSION['acc'])) {
    echo "<script>alert('請先登入'); window.location.href='login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if ($new_password !== $confirm_password) {
        echo "<script>alert('新密碼與確認密碼不符'); history.back();</script>";
        exit;
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=fit_ai;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 取得使用者資料（純文字密碼）
        $stmt = $pdo->prepare("SELECT password FROM account WHERE acc = :acc");
        $stmt->execute(['acc' => $_SESSION['acc']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            echo "<script>alert('使用者不存在'); window.location.href='login.php';</script>";
            exit;
        }

        // 直接比對純文字密碼
        if ($old_password !== $user['password']) {
            echo "<script>alert('舊密碼錯誤'); history.back();</script>";
            exit;
        }

        // 更新密碼（純文字）
        $update = $pdo->prepare("UPDATE account SET password = :password WHERE acc = :acc");
        $update->execute(['password' => $new_password, 'acc' => $_SESSION['acc']]);

        echo "<script>alert('密碼修改成功'); window.location.href='account_view.php';</script>";
        exit;

    } catch (PDOException $e) {
        echo "資料庫錯誤: " . $e->getMessage();
        exit;
    }
} else {
    echo "<script>window.location.href='account_view.php';</script>";
    exit;
}
?>
