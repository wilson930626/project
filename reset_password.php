<?php
include 'connect.php';
include 'mailer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $account = $_POST['account'];
    $email = $_POST['email'];

    // 查詢帳號+email
    $stmt = $pdo->prepare("SELECT * FROM account WHERE acc = :acc AND emal = :email");
    $stmt->execute([':acc' => $account, ':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // 產生 token 與過期時間
        $token = bin2hex(random_bytes(16));
        $expires = date("Y-m-d H:i:s", strtotime("+7 hour"));

        // 更新到 account 表
        $update = $pdo->prepare("UPDATE account SET reset_token = :token, reset_expire = :expire WHERE acc = :acc");
        $update->execute([
            ':token' => $token,
            ':expire' => $expires,
            ':acc' => $account
        ]);

        // 寄送連結
        $reset_link = "http://localhost/0804/new_password.php?token=$token";

        // 設定 email 標題與內容
        $subject = "help_you_fit_SA"; // 改成你想要的標題
        $body = "請點擊以下連結來重設密碼（1 小時內有效）：<br><a href='$reset_link'>$reset_link</a>";

        if (sendResetMail($email, $subject, $body)) {
            // 寄信成功後，跳轉到提示頁
            header("Location: forgot_sent.php");
            exit;
        } else {
            echo "❌ 寄信失敗，請稍後再試。";
        }
    } else {
        echo "❌ 帳號或 Email 不正確。";
    }
}
?>
