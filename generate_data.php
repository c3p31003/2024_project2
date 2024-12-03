<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "ryo";
$password = "ryo";
$dbname = "accident";

echo '<!doctype html>';
echo '<html lang="ja">';
echo '<head>';
echo '    <meta charset="utf-8">';
echo '    <meta name="viewport" content="width=device-width, initial-scale=1">';
echo '    <title>検索結果ページ</title>';
echo '    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '    <style>';
echo '        body {';
echo '            font-family: Arial, sans-serif;';
echo '            background-color: #d3f9d8;';
echo '        }';
echo '        main {';
echo '            background-color: #fff;';
echo '            padding: 20px;';
echo '            border-radius: 8px;';
echo '            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);';
echo '        }';
echo '        h2 {';
echo '            margin-bottom: 20px;';
echo '        }';
echo '        .search-results {';
echo '            margin-top: 20px;';
echo '        }';
echo '        .search-results p {';
echo '            margin-bottom: 10px;';
echo '        }';
echo '        .search-results form {';
echo '            margin-top: 20px;';
echo '        }';
echo '        .search-results input[type="checkbox"] {';
echo '            margin-right: 10px;';
echo '        }';
echo '        .search-results input[type="submit"], .search-results button {';
echo '            background-color: #007bff;';
echo '            color: #fff;';
echo '            border: none;';
echo '            padding: 10px 20px;';
echo '            border-radius: 4px;';
echo '            cursor: pointer;';
echo '            margin-right: 10px;';
echo '        }';
echo '        .search-results input[type="submit"]:hover, .search-results button:hover {';
echo '            background-color: #0056b3;';
echo '        }';
echo '        footer {';
echo '            background-color: #343a40;';
echo '            color: #fff;';
echo '            padding: 10px 0;';
echo '            text-align: center;';
echo '        }';
echo '        footer p {';
echo '            margin: 0;';
echo '        }';
echo '    </style>';
echo '</head>';
echo '<body>';
echo '    <main class="container my-5">';
echo '        <h2 class="text-center mb-4">検索結果</h2>';
echo '        <div class="search-results">';

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    echo "<h3>検索キーワード: $keyword</h3>";

    // データベース接続
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // 全角スペースを半角スペースに変換
    $keyword = preg_replace('/\s+/u', ' ', $keyword);

    // キーワードをスペースで分割
    $keywords = explode(' ', $keyword);
    $whereClauses = array();
    $wordcloud_data = []; // ワードクラウド用データ

    foreach ($keywords as $word) {
        $word = $conn->real_escape_string($word);
        $whereClauses[] = "( `事故に至る経緯と事故の状況` LIKE '%$word%' OR `事故の要因` LIKE '%$word%' OR `事故発生後の対策` LIKE '%$word%' )";
    }
    $sql = "SELECT 番号, `事故に至る経緯と事故の状況`, `事故の要因`, `事故発生後の対策` FROM accident_data WHERE " . implode(' AND ', $whereClauses);

    $result = $conn->query($sql);

    if ($result === FALSE) {
        echo "Error: " . $conn->error;
    } else {
        echo "<p>検索結果数: " . $result->num_rows . "</p>";
        echo "<form method='POST' action='generate_report.php'>";
        echo "<h2>報告書に使用したい項目を選択してください</h2>";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['番号']; // 各データに一意のIDが必要
                echo "<h3>事故 ID: {$id}</h3>";
                echo "<label><input type='checkbox' name='selected_items[経緯と状況][]' value='{$id}'> 事故に至る経緯と事故の状況: {$row['事故に至る経緯と事故の状況']}</label><br>";
                echo "<label><input type='checkbox' name='selected_items[要因][]' value='{$id}'> 事故の要因: {$row['事故の要因']}</label><br>";
                echo "<label><input type='checkbox' name='selected_items[対策][]' value='{$id}'> 事故発生後の対策: {$row['事故発生後の対策']}</label><br><br>";
                
                // ワードクラウド用データに追加
                $wordcloud_data[] = $row['事故に至る経緯と事故の状況'];
                $wordcloud_data[] = $row['事故の要因'];
                $wordcloud_data[] = $row['事故発生後の対策'];
            }

            // ワードクラウド用データを保存
            file_put_contents('wordcloud_data.txt', implode(' ', $wordcloud_data));
        } else {
            echo "<p>検索結果が見つかりませんでした。</p>";
        }
        echo "<div class='text-center'>";
        echo "<input type='submit' value='生成' class='btn btn-primary'>";
        echo "<button type='button' onclick='history.back()' class='btn btn-secondary'>戻る</button>";
        echo "</form>"; // 報告書生成用のフォームを閉じる
        echo "</div>";
    }

    $conn->close();
} else {
    echo "<p>キーワードを入力してください。</p>";
}

echo '        </div>';
echo '    </main>';
echo '    <footer class="text-center py-4">';
echo '        <p>文教大学 情報学部 情報システム学科 プロジェクト演習BC</p>';
echo '        <p>Copyright &copy; 2024, Team F, All rights reserved。</p>';
echo '    </footer>';
echo '    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>';
echo '</body>';
echo '</html>';
?>
