<?php
// ai_backend.php
header('Content-Type: application/json');
session_start();

// 取得前端送來的 JSON
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['question'])) {
    echo json_encode(["answer" => "❌ 未提供問題"]);
    exit;
}

$question = $input['question'];
$uuid = $_GET['session_id'] ?? $_SESSION['session_id'] ?? session_id(); 
// 用 session_id 當 uuid，不同使用者自動區分
// 如果你有自己的 session_id（MySQL 那張表），可以傳進來取代這裡

// FastAPI URL
$api_url = "http://127.0.0.1:8000/API/POST_ask";

// 建立要送的資料
$data = [
    "question" => $question,
    "uuid" => $uuid
];
$data_json = json_encode($data);

// cURL 初始化
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);

// 執行 API 呼叫
$response = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

// 回傳結果
if ($err) {
    echo json_encode(["answer" => "❌ API 呼叫失敗: $err"]);
} else {
    echo $response;
}
?>
