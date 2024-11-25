<?php
session_start();

// フォームデータを取得
$title = $_POST['incidentTitle'] ?? '';
$recordDate = $_POST['recordDate'] ?? '';
$occurrenceDate = $_POST['occurrenceDate'] ?? '';
$recorderName = $_POST['recorderName'] ?? '';
$targetName = $_POST['targetName'] ?? '';
$details = $_POST['incidentDetails'] ?? '';

// データベース接続
$conn = new mysqli("127.0.0.1", "proC_test", "proC", "accident");
if ($conn->connect_error) {
    die("データベース接続失敗: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// データ登録
$sql = "INSERT INTO oc_accident_data (title, record_date, occurrence_date, recorder_name, target_name, details) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $title, $recordDate, $occurrenceDate, $recorderName, $targetName, $details);

if ($stmt->execute()) {
    $_SESSION['message'] = "登録が完了しました！";
} else {
    $_SESSION['message'] = "登録に失敗しました: " . $conn->error;
}

$stmt->close();
$conn->close();

// 入力画面に戻る
header("Location: accident-input.php");
exit();
?>
