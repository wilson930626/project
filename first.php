<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>健身指南首頁</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="stylesheet" href="style.css">

</head>
<body>

 <?php include("navbar.php"); ?>

  <!-- Swiper 幻燈片 -->
  <div class="swiper">
    <div class="swiper-wrapper">
      <div class="swiper-slide"><img src="project/slide1.jpg" alt="圖片1"></div>
      <div class="swiper-slide"><img src="project/slide2.jpg" alt="圖片2"></div>
    </div>
    <!-- 加入左右箭頭 -->
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <!-- 加入底部指示點 -->
    <div class="swiper-pagination"></div>
  </div>

  <!-- 主內容 -->
  <main class="content">
    <a href="plan.php" class="block sky">
      <img src="project/report.png" alt="訓練菜單圖示">
      <p>健身菜單：提供建議的訓練計畫，減少使用者自行規劃的時間，提高健身效率。</p>
    </a>

    <a href="nutrition.php" class="block peach">
      <img src="project/diet.png" alt="營養攝取圖示">
      <p>營養攝取建議：根據使用者的運動量、體重及目標，調整營養攝取建議，幫助使用者優化飲食。</p>
    </a>

    <a href="equipment.php" class="block mint">
      <img src="project/weights.png" alt="健身器材圖示">
      <p>健身器材使用指南：介紹健身房常見器材的運作方式、訓練肌群及操作細節，幫助初學者正確使用。</p>
    </a>

    <a href="ai.php" class="block lavender">
      <img src="project/chatbot.png" alt="AI助理圖示">
      <p>AI健身代理：提供使用者可直接進行諮詢所有健身或營養的相關問題，讓AI助理提供諮詢和協助，或是直接導引使用者到功能的導向。</p>
    </a>
  </main>

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    const swiper = new Swiper('.swiper', {
      loop: true,
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev'
      }
    });
  </script>
</body>
</html>