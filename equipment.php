
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <title>健身器材指南</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container">
  <h2 class="title">健身器材使用指南</h2>
  <div class="grid">
    <a class="card" href="equipment_detail.php?part=shoulder">
      <img src="project/shoulder.png"><span>肩膀</span>
    </a>
    <a class="card" href="equipment_detail.php?part=arm">
      <img src="project/muscle.png"><span>手臂</span>
    </a>
    <a class="card" href="equipment_detail.php?part=back">
      <img src="project/body-part.png"><span>背部</span>
    </a>
    <a class="card" href="equipment_detail.php?part=chest">
      <img src="project/chest.png"><span>胸部</span>
    </a>
    <a class="card" href="equipment_detail.php?part=core">
      <img src="project/six-pack.png"><span>核心</span>
    </a>
    <a class="card" href="equipment_detail.php?part=leg">
      <img src="project/leg.png"><span>腿部</span>
    </a>
  </div>
</div>


</body>
</html>
