<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$username = "proC_test";
$password = "proC";
$dbname = "accident";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("データベース接続失敗: " . $conn->connect_error);
}

$conn->set_charset("utf8");

$title = htmlspecialchars($_POST['incidentTitle'] ?? null, ENT_QUOTES, 'UTF-8');
$recordDate = htmlspecialchars($_POST['recordDate'] ?? null, ENT_QUOTES, 'UTF-8');
$occurrenceDate = htmlspecialchars($_POST['occurrenceDate'] ?? null, ENT_QUOTES, 'UTF-8');
$recorderName = htmlspecialchars($_POST['recorderName'] ?? null, ENT_QUOTES, 'UTF-8');
$targetName = htmlspecialchars($_POST['targetName'] ?? null, ENT_QUOTES, 'UTF-8');
$details = htmlspecialchars($_POST['incidentDetails'] ?? null, ENT_QUOTES, 'UTF-8');

if (empty($title) || empty($recordDate) || empty($occurrenceDate) || empty($recorderName)) {
    $_SESSION['message'] = "必須フィールドが入力されていません。";
    header("Location: accident-input.php");
    exit();
}

$sql = "INSERT INTO oc_accident_data (title, record_date, occurrence_date, recorder_name, target_name, details) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $title, $recordDate, $occurrenceDate, $recorderName, $targetName, $details);

if ($stmt->execute()) {
    $_SESSION['message'] = "データが正常に登録されました。";
} else {
    error_log("SQLエラー: " . $stmt->error);
    $_SESSION['message'] = "データ登録に失敗しました。管理者にお問い合わせください。";
}

$stmt->close();
$conn->close();

header("Location: accident-input.php");
exit();
?>
