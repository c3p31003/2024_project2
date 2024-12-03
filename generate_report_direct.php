<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "ryo";
$password = "ryo";
$dbname = "accident";

ob_start(); // 出力バッファリングを開始

$data = array(); // データを格納する配列

// JSONファイルを作成（空のデータでも）
$jsonFilePath = __DIR__ . "/data.json";
file_put_contents($jsonFilePath, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo "JSONファイルに保存成功<br>";

if (file_exists($jsonFilePath)) {
    // JSONファイルの内容を表示（デバッグ用）
    echo "JSONファイルの内容: ";
    $json_content = file_get_contents($jsonFilePath);
    echo $json_content;

    // JSONファイルからWord文書を生成
    $python_executable = "C:/Users/ryo-s/AppData/Local/Programs/Python/Python311/python.exe";  // Pythonのフルパスを指定
    $python_script = __DIR__ . "/generate_word.py";  // フルパスを指定
    exec("$python_executable $python_script", $output, $return_var);
    echo "Pythonスクリプト実行: " . implode("\n", $output) . "<br>";
    echo "エラーコード: " . $return_var . "<br>";

    // Word文書へのパス
    $docPath = "/ryo3/houkokusyo.docx";
    $docFullPath = "C:/xampp2/htdocs" . $docPath;

    // 生成されたWord文書が存在するか確認
    if (file_exists($docFullPath)) {
        // 生成されたWord文書にリダイレクトしてブラウザで表示
        header("Location: http://localhost{$docPath}");
        ob_end_flush(); // バッファリングを終了して出力
        exit();
    } else {
        echo "<p>Word文書の生成に失敗しました。</p>";
    }
} else {
    echo "<p>data.json の生成に失敗しました。</p>";
}

ob_end_flush(); // バッファリングを終了して出力
?>
