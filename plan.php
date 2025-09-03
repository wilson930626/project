<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>健身菜單</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
 <?php include("navbar.php"); ?>
  <div class="container">
    <div class="title">健身菜單</div>

    <div class="grid">
      <a href="home1.php" class="card">
        <span>居家初級</span>
        <span class="subtitle">建議平常較少運動者</span>
      </a>
      <a href="#" class="card">
        <span>居家中級</span>
        <span class="subtitle">建議平常規律運動者</span>
      </a>
      <a href="#" class="card">
        <span>居家高級</span>
        <span class="subtitle">建議平常高強度運動者</span>
      </a>
    </div>

    <div class="grid" style="margin-top: 40px;">
      <a href="#" class="card">
        <span>健身房初級</span>
        <span class="subtitle">建議平常較少運動者</span>
      </a>
      <a href="#" class="card">
        <span>健身房中級</span>
        <span class="subtitle">建議平常規律運動者</span>
      </a>
      <a href="#" class="card">
        <span>健身房高級</span>
        <span class="subtitle">建議平常高強度運動者</span>
      </a>
    </div>
  </div>
</body>
</html>