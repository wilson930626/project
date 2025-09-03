<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>健身菜單 AI 助手</title>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+TC&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <style>
    .chat-box {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 10px;
      height: 400px;
      overflow-y: auto;
      margin-bottom: 10px;
      background: #fff;
    }
    .chat-message {
      margin: 8px 0;
      padding: 8px;
      border-radius: 6px;
      word-wrap: break-word;
    }
    .user {
      background: #d1f0ff;
      text-align: right;
    }
    .bot {
      background: #f1f1f1;
      text-align: left;
    }
    .chat-area { display: flex; gap: 8px; }
    .input-box { flex: 1; padding: 8px; border-radius: 4px; resize: none; }
    .send-btn { padding: 8px 16px; border-radius: 4px; cursor: pointer; }
  </style>
</head>
<body>
  <?php include("navbar.php"); ?>

  <div class="container">
    <div class="title">你好，請問需要什麼協助？</div>
    
    <!-- 聊天內容 -->
    <div class="chat-box" id="chatBox"></div>

    <!-- 輸入區 -->
    <div class="chat-area">
      <textarea class="input-box" id="chatInput" placeholder="詢問問題..."></textarea>
      <button class="send-btn" onclick="sendMessage()">送出</button>
    </div>
  </div>

  <script>
    const chatBox = document.getElementById("chatBox");
    const chatInput = document.getElementById("chatInput");

    function appendMessage(message, sender) {
      const msgDiv = document.createElement("div");
      msgDiv.classList.add("chat-message", sender);
      msgDiv.textContent = message;
      chatBox.appendChild(msgDiv);
      chatBox.scrollTop = chatBox.scrollHeight;
    }

    async function sendMessage() {
      const message = chatInput.value.trim();
      if (!message) return;
      
      appendMessage(message, "user");
      chatInput.value = "";

      try {
        const response = await fetch("ai_backend.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ question: message })
        });
        const data = await response.json();
        appendMessage(data.answer, "bot");
      } catch (error) {
        appendMessage("❌ 伺服器錯誤，請稍後再試", "bot");
      }
    }

    // 自動調整輸入框高度
    chatInput.addEventListener('input', () => {
      chatInput.style.height = 'auto';
      chatInput.style.height = Math.min(chatInput.scrollHeight, 200) + 'px';
    });

    // Enter 送出訊息
    chatInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
      }
    });
  </script>
</body>
</html>
