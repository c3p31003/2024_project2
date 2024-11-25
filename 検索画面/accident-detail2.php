<?php
// データベース接続情報
$host = "localhost";
$username = "proC_test";
$password = "proC";
$dbname = "accident";

// データベース接続
$conn = new mysqli($host, $username, $password, $dbname);

// 接続確認
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

// データ取得
$sql = "SELECT id, record_date, occurrence_date, recorder_name, target_name, details FROM oc_accident_data ORDER BY record_date DESC";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>事故詳細一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header id="header-fixed">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container-lg">
                <a class="navbar-brand" href="top.php">安全管理システム</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#Navbar" aria-controls="Navbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="Navbar">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <!-- ナビゲーションリンクをここに記載 -->
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container my-5">
        <h2 class="text-center mb-4">事故詳細一覧</h2>
        <p class="text-center">登録された事故の一覧を表示します。</p>

        <table class="table table-bordered table-striped text-center">
            <thead class="table-light">
                <tr>
                    <th>記録日時</th>
                    <th>発生日</th>
                    <th>記録者</th>
                    <th>対象者</th>
                    <th>詳細</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["record_date"], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row["occurrence_date"], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row["recorder_name"], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row["target_name"], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td><a href='detail.php?id=" . htmlspecialchars($row["id"], ENT_QUOTES, 'UTF-8') . "' class='btn btn-info btn-sm'>詳細</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>データがありません</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <footer class="text-center py-3">
        <p>文教大学 情報学部 情報システム学科 プロジェクト演習BC</p>
        <p>&copy; 2024 Team F, All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
