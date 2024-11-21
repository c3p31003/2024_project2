<?php
// エラーレポート（デバッグ用）
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// データベース接続設定
$host = "localhost";
$username = "proC_test";
$password = "proC";
$dbname = "accident";

// フォームのデータを取得
$title = $_POST['タイトル'] ?? null;
$details = $_POST['詳細'] ?? null;

// データベース接続
$conn = new mysqli($host, $username, $password, $dbname);

// 接続エラーチェック
if ($conn->connect_error) {
    die("データベース接続エラー: " . $conn->connect_error);
}

// SQLクエリを準備
$sql = "INSERT INTO oc_accident_data (タイトル, 詳細) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

// プレースホルダーに値をバインド
$stmt->bind_param("ss", $title, $details);

// クエリ実行
if ($stmt->execute()) {
  header("Location: success.html");
  exit;
} else {
  echo "データ登録に失敗しました: " . $conn->error;
}


// 接続を閉じる
$stmt->close();
$conn->close();
?>
