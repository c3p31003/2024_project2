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
$sql = "SELECT id, record_date, occurrence_date, recorder_name, target_name, details 
        FROM oc_accident_data 
        ORDER BY record_date DESC";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>事故詳細一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/ProC_style.css">
</head>
<body>
<header id="header-fixed">
    <nav class="navbar navbar-expand-md ">
        <div class="container-lg">
            <a class="my-navbar-brand navbar-brand" href="top.php">安全管理システム</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#Navbar" aria-controls="Navbar" aria-expanded="false" aria-label="ProA2023">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="Navbar">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="my-nav-item nav-link" aria-current="page" href="top.php">トップページ<span class="sr-only"></span>
                        <img class="nav-img" src="../icon/家.png" alt="">
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="検索画面/accident-search.html" class="my-nav-item nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">検索画面
                            <img class="nav-img" src="../icon/検索画面icon.png" alt="">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="accident-list.html">他社事故一覧</a></li>
                            <li><a class="dropdown-item" href="accident-input.php">事故入力画面</a></li>
                            <li><a class="dropdown-item" href="accident-detail2.php">自社事故一覧</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="my-nav-item nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ヒヤリハット
                            <img class="nav-img" src="../icon/カテゴリ.png" alt="">
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="inputNearmiss.php">ヒヤリハット入力画面</a></li>
                            <li><a class="dropdown-item" href="Nearmisslist.php">ヒヤリハット一覧</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="my-nav-item nav-link" href="../word-cloud.html">安全報告書
                            <img class="nav-img" src="../icon/ワードクラウド画面.png" alt="">
                        </a>
                    </li>
                    <li class="nav-bottom">
                        <a href="logout.php" onclick="return confirm('ログアウトしてもよろしいですか？');" style="display: inline-block; margin:20px 30px; padding: 10px 20px; background-color: #ff6347; color: white; text-decoration: none; border-radius: 5px;">
                            ログアウト
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>



    <main class="container my-5">
        <h2 class="text-center mb-4">事故詳細一覧</h2>

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
                        echo "<td><button class='btn btn-info btn-sm' data-bs-toggle='modal' data-bs-target='#detailModal' data-details='" . htmlspecialchars($row["details"], ENT_QUOTES, 'UTF-8') . "'>詳細</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>データがありません</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>

    <!-- モーダルウィンドウ -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">詳細情報</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-body">
                    <p id="modal-details">詳細情報がここに表示されます。</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-3">
        <p>文教大学 情報学部 情報システム学科 プロジェクト演習BC</p>
        <p>&copy; 2024 Team F, All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // モーダルに詳細情報を動的に挿入
        const detailModal = document.getElementById('detailModal');
        detailModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // モーダルをトリガーしたボタン
            const details = button.getAttribute('data-details'); // ボタンに設定された詳細データ
            const modalDetails = detailModal.querySelector('#modal-details');
            modalDetails.textContent = details; // 詳細情報をモーダルに設定
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
