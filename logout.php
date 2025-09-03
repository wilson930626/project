<?php
session_start();
session_unset(); // 清除所有 session 變數
session_destroy(); // 銷毀 session
header("Location: login.php"); // 回到登入頁
exit();
