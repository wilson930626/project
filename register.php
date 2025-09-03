<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>會員註冊</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            display: flex;
            min-height: calc(100vh - 60px);
        }
        .left-image {
            flex: 1;
            position: relative;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .main-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }
        .activity-chart-overlay {
            position: absolute;
            top: 50%;
            left: 13%;
            transform: translateY(-50%);
            width: 800px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background-color: rgba(255, 255, 255, 0.95);
            z-index: 10;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }
        .form-panel {
            width: 460px;
            background-color: #f9f9f9;
            padding: 40px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .form-panel h1 {
            margin-bottom: 24px;
        }
        .form-panel form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .row {
            display: flex;
            gap: 12px;
        }
        .col {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 4px;
        }
        input[type="text"],
        input[type="password"],
        select {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
            box-sizing: border-box;
        }
        .gender-group {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 5px;
        }
        button {
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<main class="container">
    <!-- 左邊圖片 -->
    <div class="left-image">
        <img src="project/19333425.jpg" alt="健身人物插圖" class="main-image" />
        <img src="project/activity_level_reference.png" alt="活動量參考圖" class="activity-chart-overlay" />
    </div>

    <!-- 右邊表單 -->
    <div class="form-panel">
        <h1>註冊新帳號</h1>
        <form method="post" action="register_action.php">
            <div class="row">
                <div class="col">
                    <label for="nickname">暱稱</label>
                    <input type="text" id="nickname" name="nickname" required />
                </div>
                <div class="col">
                    <label for="age">年齡</label>
                    <input type="text" id="age" name="age" required />
                </div>
                <div class="col">
                    <label>性別</label>
                    <div class="gender-group">
                        <label><input type="radio" name="gender" value="男" required /> 男</label>
                        <label><input type="radio" name="gender" value="女" /> 女</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="height">身高 (cm)</label>
                    <input type="text" id="height" name="height" required />
                </div>
                <div class="col">
                    <label for="weight">體重 (kg)</label>
                    <input type="text" id="weight" name="weight" required />
                </div>
                <div class="col">
                    <label for="activity">活動量</label>
                    <select id="activity" name="activity" required>
                        <option value="低活動量">低活動量</option>
                        <option value="輕微活動量">輕微活動量</option>
                        <option value="中等活動量">中等活動量</option>
                        <option value="高活動量">高活動量</option>
                        <option value="超高活動量">超高活動量</option>
                    </select>
                </div>
            </div>

            <div class="col">
                <label for="acc">帳號</label>
                <input type="text" id="acc" name="acc" required />
            </div>

            <div class="col">
                <label for="password">密碼</label>
                <input type="password" id="password" name="password" required />
            </div>

            <button type="submit">完成</button>
        </form>
    </div>
</main>

</body>
</html>
