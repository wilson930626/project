<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>健身網站登入頁</title>
  <style>
    :root {
      --primary: #3A8DFF;
      --secondary: #6ACD7D;
      --background: #F2F2F2;
      --text-dark: #333333;
      --alert: #FF6B6B;
      --highlight: #A293F8;
    }

    body {
      font-family: "Segoe UI", sans-serif;
      background-color: var(--background);
      margin: 0;
      padding: 0;
    }

    header {
      background-color: var(--primary);
      color: white;
      padding: 1rem 2rem;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header h1 {
      margin: 0;
    }

    nav a {
      color: white;
      text-decoration: none;
      margin-left: 1.5rem;
      font-weight: bold;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      padding: 2rem;
    }

    .form-section {
      background-color: #ddd;
      padding: 2rem;
      border-radius: 10px;
      flex: 1;
      max-width: 400px;
      margin: auto;
    }

    .form-section h2 {
      text-align: center;
      color: var(--text-dark);
    }

    .form-group {
      margin-bottom: 1rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      color: var(--text-dark);
    }

    input[type="text"],
    input[type="password"],
    input[type="date"] {
      width: 100%;
      padding: 0.5rem;
      border: 1px solid var(--primary);
      border-radius: 5px;
      font-size: 1rem;
    }

    .btn {
      background-color: var(--primary);
      color: white;
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      width: 100%;
      font-size: 1rem;
    }

    .btn:hover {
      background-color: #2b6ecb;
    }

    .checkbox-group {
      display: flex;
      gap: 1rem;
      align-items: center;
    }

    .alert {
      background-color: var(--alert);
      color: white;
      padding: 0.5rem;
      border-radius: 5px;
      margin-bottom: 1rem;
      text-align: center;
    }
  </style>
</head>
<body>
  <header>
    <h1>健康生活健身網</h1>
    <nav>
      <a href="#">健身器材指南</a>
      <a href="#">營養攝取建議</a>
      <a href="#">健身菜單</a>
      <a href="#">AI健身代理</a>
    </nav>
  </header>

  <div class="container">
    <!-- 登入區塊 -->
    <section class="form-section">
      <h2>登入</h2>
      <div class="form-group">
        <label for="account">帳號</label>
        <input type="text" id="account" />
      </div>
      <div class="form-group">
        <label for="password">密碼</label>
        <input type="password" id="password" />
      </div>
      <button class="btn">登入</button>
    </section>

    <!-- 註冊區塊 -->
    <section class="form-section" style="margin-top: 2rem;">
      <h2>註冊</h2>
      <div class="form-group">
        <label>姓</label>
        <input type="text" />
      </div>
      <div class="form-group">
        <label>名</label>
        <input type="text" />
      </div>
      <div class="form-group">
        <label>性別</label>
        <div class="checkbox-group">
          <label><input type="checkbox" /> 男</label>
          <label><input type="checkbox" /> 女</label>
        </div>
      </div>
      <div class="form-group">
        <label>身高</label>
        <input type="text" />
      </div>
      <div class="form-group">
        <label>體重</label>
        <input type="text" />
      </div>
      <div class="form-group">
        <label>生日</label>
        <input type="date" />
      </div>
      <div class="form-group">
        <label>帳號</label>
        <input type="text" />
      </div>
      <div class="form-group">
        <label>密碼</label>
        <input type="password" />
      </div>
      <button class="btn">完成</button>
    </section>
  </div>
</body>
</html>
8