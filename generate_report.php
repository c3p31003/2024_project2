<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "ryo";
$password = "ryo";
$dbname = "accident";

ob_start(); // 出力バッファリングを開始

$data = array(); // データを格納する配列

if (isset($_POST['selected_items'])) {
    $selected_items = $_POST['selected_items'];

    // データベース接続
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    foreach ($selected_items as $category => $ids) {
        foreach ($ids as $selected_id) {
            $stmt = $conn->prepare("SELECT `事故に至る経緯と事故の状況`, `事故の要因`, `事故発生後の対策` FROM accident_data WHERE 番号 = ?");
            $stmt->bind_param("i", $selected_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result === FALSE) {
                echo "Error: " . $conn->error;
            } else if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                switch ($category) {
                    case '経緯と状況':
                        $data['経緯と状況'][] = $row['事故に至る経緯と事故の状況'];
                        break;
                    case '要因':
                        $data['要因'][] = $row['事故の要因'];
                        break;
                    case '対策':
                        $data['対策'][] = $row['事故発生後の対策'];
                        break;
                }
            } else {
                echo "<p>選択されたデータが見つかりませんでした。</p>";
            }

            $stmt->close();
        }
    }

    $conn->close();
} 

// データをJSONファイルに保存
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
