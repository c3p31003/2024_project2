<?php
session_start();

// データベース接続情報
$servername = "localhost";
$username = "proc"; // MySQLユーザー名
$password = "proc"; // MySQLパスワード
$dbname = "accidents_db";

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続確認
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// フォームデータの取得
$record_date = $_POST['recordDate'];
$occurrence_date = $_POST['occurrenceDate'];
$recorder_name = $_POST['recorderName'];
$target_name = $_POST['targetName'];
$details = $_POST['incidentDetails'];

// SQLクエリの作成
$sql = "INSERT INTO nearmiss_reports (record_date, occurrence_date, recorder_name, target_name, details)
        VALUES ('$record_date', '$occurrence_date', '$recorder_name', '$target_name', '$details')";

// クエリ実行と結果確認
if ($conn->query($sql) === TRUE) {
    $_SESSION['message'] = "ヒヤリハット一覧に登録しました";
} else {
    $_SESSION['message'] = "エラー: " . $conn->error;
}

// データベース接続終了
$conn->close();

// 元のページにリダイレクト
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
