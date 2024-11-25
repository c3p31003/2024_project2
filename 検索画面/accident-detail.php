<?php
// データベース接続設定
$servername = "127.0.0.1";
$username = "proC_test";
$password = "proC";
$dbname = "accident";

// データベースに接続
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("データベース接続失敗: " . $conn->connect_error);
}
$conn->set_charset("utf8");

// URLパラメータを取得（サニタイズ）
$category1 = isset($_GET['category1']) ? $conn->real_escape_string($_GET['category1']) : '';
$category2 = isset($_GET['category2']) ? $conn->real_escape_string($_GET['category2']) : '';
$category3 = isset($_GET['category3']) ? $conn->real_escape_string($_GET['category3']) : '';
$category4 = isset($_GET['category4']) ? $conn->real_escape_string($_GET['category4']) : '';

// SQLクエリを作成
$sql = "SELECT * FROM accident_data WHERE 番号 != 0";

// 条件を動的に追加
if (!empty($category1)) {
    $sql .= " AND 工事分野 = '$category1'";
}
if (!empty($category2)) {
    $sql .= " AND 工事の種類 = '$category2'";
}
if (!empty($category3)) {
    $sql .= " AND 災害分類 = '$category3'";
}
if (!empty($category4)) {
    $sql .= " AND 事故分類 = '$category4'";
}

$result = $conn->query($sql);
?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>事故詳細一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/ProC_style.css">
    <style>
        /* テーブル列の幅を均等にする */
        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        /* 詳細ボタンの列を狭くする */
        .btn-detail {
            width: 80px;
        }
    </style>
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
                            <li><a class="dropdown-item" href="../検索画面/accident-list.html">他社事故一覧</a></li>
                            <li><a class="dropdown-item" href="../検索画面/accident-input.html">事故入力画面</a></li>
                            <li><a class="dropdown-item" href="../検索画面/accident-detail2.php">自社事故一覧</a></li>
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
                        <a class="my-nav-item nav-link" href="../word-cloud.html">ワードクラウド
                            <img class="nav-img" src="../icon/ワードクラウド画面.png" alt="">
                        </a>
                    </li>
                    <li class="nav-bottom">
                        <a href="logout.php" onclick="return confirm('ログアウトしてもよろしいですか？');" style="display: inline-block; margin:20px 10px; padding: 10px 20px; background-color: #ff6347; color: white; text-decoration: none; border-radius: 5px;">
                            ログアウト
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>


    <main class="container mt-5">
        <h1>事故データ一覧</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <!-- <th>番号</th> -->
                    <th>工事分野</th>
                    <th>工事の種類</th>
                    <th>工種</th>
                    <th>工法・形式名</th>
                    <th>災害分類</th>
                    <th>事故分類</th>
                    <th>天候</th>
                    <th>事故発生年・月・時間</th>
                    <th>事故発生場所（都道府県）</th>
                    <th>事故に至る経緯と事故の状況</th>
                    <th>事故の要因</th>
                    <th>対策</th> <!-- 詳細ボタン用 -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        // echo "<td>" . htmlspecialchars($row['番号'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row['工事分野'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row['工事の種類'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row['工種'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row['工法・形式名'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row['災害分類'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row['事故分類'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row['天候'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row['事故発生年・月・時間'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row['事故発生場所（都道府県）'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row['事故に至る経緯と事故の状況'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>" . htmlspecialchars($row['事故の要因'], ENT_QUOTES, 'UTF-8') . "</td>";
                        echo "<td>
                                <button class='btn btn-info btn-sm btn-detail' data-bs-toggle='modal' 
                                        data-bs-target='#detailModal' 
                                        data-measures='" . htmlspecialchars($row['事故発生後の対策'], ENT_QUOTES, 'UTF-8') . "'>
                                    詳細
                                </button> </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>データがありません</td></tr>";
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
                    <h5 class="modal-title" id="detailModalLabel">事故発生後の対策</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                </div>
                <div class="modal-body">
                    <p id="modal-measures">詳細情報がここに表示されます。</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                </div>
            </div>
        </div>
    </div>

    <!-- <footer class="text-center mt-5">
        文教大学 情報学部 情報システム学科 プロジェクト演習BC
        <p>&copy; 2024 Team F, All rights reserved.</p>
    </footer> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // モーダルに「事故発生後の対策」を動的に挿入
        const detailModal = document.getElementById('detailModal');
        detailModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // モーダルをトリガーしたボタン
            const measures = button.getAttribute('data-measures'); // ボタンに設定された対策データ
            const modalMeasures = detailModal.querySelector('#modal-measures');
            modalMeasures.textContent = measures; // モーダルに対策情報を設定
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
