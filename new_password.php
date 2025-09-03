<?php
include 'connect.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // 查詢 token 是否存在且未過期
    $stmt = $pdo->prepare("SELECT * FROM account WHERE reset_token = :token AND reset_expire > NOW()");
    $stmt->execute([':token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $new_pass = $_POST['password']; // 直接使用明文密碼

            // 更新密碼，並清空 token
            $update = $pdo->prepare("UPDATE account 
                                     SET password = :password, reset_token = NULL, reset_expire = NULL 
                                     WHERE acc = :acc");
            $update->execute([
                ':password' => $new_pass,
                ':acc' => $user['acc']
            ]);

            // 密碼重設成功訊息 + 倒數 3 秒跳轉 login.php
            echo '✅ 密碼已重設成功！<br><span id="countdown">3</span> 秒後將自動回到登入頁面...';
            echo '<script>
                    let seconds = 3;
                    const countdown = document.getElementById("countdown");
                    const interval = setInterval(function() {
                        seconds--;
                        countdown.textContent = seconds;
                        if (seconds <= 0) {
                            clearInterval(interval);
                            window.location.href = "login.php";
                        }
                    }, 1000);
                  </script>';
            exit;
        }
        ?>
        <form method="post">
            <label for="password">輸入新密碼：</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">更新密碼</button>
        </form>
        <?php
    } else {
        echo "❌ 連結無效或已過期！";
    }
} else {
    echo "❌ 缺少 token！";
}
?>
