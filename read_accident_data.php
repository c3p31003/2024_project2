<?php
// データベース接続設定
$servername = "localhost";
$username = "proC_test";
$password = "proC";
$dbname = "accident";

// データベースに接続
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("データベース接続失敗: " . $conn->connect_error);
}
// accident_dataテーブルをリセット
$conn->query("TRUNCATE TABLE accident_data");


// CSVファイルのパス（フルパスを使用）
$csvFile = 'C:/xampp/htdocs/accident_project/001721757.csv';

// ファイルを開く
if (($handle = fopen($csvFile, "r")) !== FALSE) {
    // 最初の行（カラムヘッダー）を取得してスキップ
    $headers = fgetcsv($handle, 1000, ",");

    // CSVの行をループ処理
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        // 空のセルや行全体が空の場合はスキップ
        if (empty(array_filter($data))) {
            echo "空のセルや空の行が含まれている行がありました。スキップします。<br>";
            continue;
        }

        // CSVの各列のデータを変数に格納
        $番号 = $data[0];
        $工事分野 = $data[1];
        $工事の種類 = $data[2];
        $工種 = $data[3];
        $工法_形式名 = $data[4];
        $災害分類 = $data[5];
        $事故分類 = $data[6];
        $天候 = $data[7];
        $事故発生年_月_時間 = $data[8];
        $事故発生場所_都道府県 = $data[9];
        $事故に至る経緯と事故の状況 = $data[10];
        $事故の要因 = $data[11];
        $事故発生後の対策 = $data[12];

        // データベースにデータを挿入
        $sql = "INSERT INTO accident_data (
            `番号`, `工事分野`, `工事の種類`, `工種`, `工法・形式名`, `災害分類`, `事故分類`, `天候`, 
            `事故発生年・月・時間`, `事故発生場所（都道府県）`, `事故に至る経緯と事故の状況`, `事故の要因`, `事故発生後の対策`
        ) VALUES (
            '$番号', '$工事分野', '$工事の種類', '$工種', '$工法_形式名', '$災害分類', '$事故分類', 
            '$天候', '$事故発生年_月_時間', '$事故発生場所_都道府県', '$事故に至る経緯と事故の状況', '$事故の要因', '$事故発生後の対策'
        )";
        
        if (!$conn->query($sql)) {
            echo "エラー: " . $sql . "<br>" . $conn->error;
        } else {
            echo "データが追加されました： $番号<br>";
        }
    }
    fclose($handle);
    echo "CSVからデータベースへのインポートが完了しました。";
} else {
    echo "CSVファイルを開けませんでした。";
}

// データベース接続を閉じる
$conn->close();

