<?php
$actionName = isset($_GET['action']) ? $_GET['action'] : '未指定動作';
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($actionName); ?> - 動作詳情</title>
<link rel="stylesheet" href="style.css">
<style>
/* 額外針對細節頁的樣式 */
.detail-section {
  background: #fff;
  border-radius: 12px;
  padding: 20px 30px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.08);
  margin-bottom: 20px;
}

.detail-section h2 {
  font-size: 22px;
  color: #7e87dd;
  margin-bottom: 15px;
}

.detail-section p {
  font-size: 16px;
  color: #333;
  line-height: 1.8;
}

.btn {
  display: inline-block;
  background-color: #7e87dd;
  color: white;
  padding: 10px 18px;
  border: none;
  border-radius: 8px;
  font-size: 16px;
  margin-top: 20px;
  cursor: pointer;
  text-decoration: none;
}

.btn:hover {
  background-color: #5f66b8;
}
</style>
</head>
<body>

<!-- 導覽列 -->
<nav class="navbar">
  <ul class="nav-links">
    <li onclick="location.href='first.php'">首頁</li>
    <li onclick="location.href='plan.php'">健身菜單</li>
    <li onclick="location.href='nutrition.php'">營養攝取建議</li>
    <li onclick="location.href='equipment.php'">健身器材使用指南</li>
    <li onclick="location.href='ai.php'">AI健身代理</li>
  </ul>
  <div class="navbar-icons">
    <a href="account_view.php"><img src="project/setting.png" alt="設定"></a>
  </div>
</nav>

<!-- 內容區 -->
<div class="container">
  <h1 class="title"><?php echo htmlspecialchars($actionName); ?></h1>

  <!-- 動作細節 -->
  <div class="detail-section">
    <h2>動作說明</h2>
    <p>
      1. 調整椅背至約 65°~85°，提供適當支撐，避免過度後仰<br>
      2. 保護頸椎頭部，膝蓋約呈 90°，保持身體穩定<br>
      3. 握距平肩，肘心朝前<br>
      4. 緩慢向上推，手肘略低於肩膀 (約75~90°)<br>
      5. 核心收緊，背部略微拱起避免前傾<br>
      6. ……可以自行補充更多說明……
    </p>
  </div>

  <!-- 注意事項 -->
  <div class="detail-section">
    <h2>注意事項・風險</h2>
    <p>
      ⚠️ 過度擠肩發力：斜方肌緊繃、肩夾症候群<br>
      ⚠️ 下放速度過快：肩關節、旋轉肌群拉傷
    </p>
  </div>

  <!-- 返回按鈕 -->
  <a href="javascript:history.back()" class="btn">返回上一頁</a>
</div>

</body>
</html>
