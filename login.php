<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>登入系統</title>
    <link rel="stylesheet" href="style.css"> <!-- a 的外部樣式 -->
    <style>
        /* 加上 b 的左右版面結構 */
        .container {
            display: flex;
            min-height: calc(100vh - 60px); /* 扣掉 navbar 高度 */
        }

        .left-image {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
        }

        .left-image img {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
        }

        .form-panel {
            width: 460px;
            background-color: #f9f9f9;
            padding: 40px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-panel h1 {
            margin-bottom: 24px;
        }

        .form-panel form label {
            display: block;
            margin-bottom: 8px;
        }

        .form-panel form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-panel form button {
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-panel form button:hover {
            background-color: #555;
        }

        .form-links {
            margin-top: 12px;
            font-size: 14px;
            display: flex;
            justify-content: space-between;
        }

        .form-links a {
            color: #333;
            text-decoration: none;
        }

        .form-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<main class="container">
    <!-- 左邊圖片 -->
    <div class="left-image">
        <img src="project/19333425.jpg" alt="健身人物插圖">
    </div>

    <!-- 右邊表單 -->
    <div class="form-panel">
        <h1>會員登入</h1>
        <form method="post" action="process_login.php">
            <label for="account">帳號：</label>
            <input type="text" id="account" name="account" required>

            <label for="password">密碼：</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">登入</button>

            <div class="form-links">
                <a href="register.php">還沒有帳號？註冊</a>
                <a href="forgot.php">忘記密碼？</a>
            </div>
        </form>
    </div>
</main>

</body>
</html>
