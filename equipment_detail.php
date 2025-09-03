
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title><?php echo $display_name; ?>訓練詳情</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
  <h2 class="title"><?php echo ucfirst($part); ?></h2>
  <div class="content">
    <div class="card1">
      <h3>坐姿啞鈴肩推</h3>
      <button class="btn">動作</button>
      <p>1. 將啞鈴置於肩膀上方，手肘彎曲成90度角<br>2. 向上推舉至手臂幾乎伸直，再慢慢放下</p>
      <div style="color:red;margin-top:10px;">
        <strong>注意事項：</strong> 避免聳肩、過度後仰、控制動作
      </div>
    </div>
    <div class="card1">
      <h3>坐姿啞鈴側平舉</h3>
      <button class="btn">動作</button>
      <p>1. 手肘微彎，從身體兩側平舉至與肩同高<br>2. 緩慢放回起始位置</p>
      <div style="color:red;margin-top:10px;">
        <strong>注意事項：</strong> 避免借力擺動，保持核心穩定
      </div>
    </div>
  </div>
</div>

</body>
</html>
