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

// データを取得
$sql = "SELECT * FROM accident_data WHERE 番号 != 0";
$result = $conn->query($sql);
?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>事故データ一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/ProC_style.css">
</head>
<body>
    <header id="header-fixed">
        <nav class="navbar navbar-expand-md navbar-dark ">
            <div class="container-lg">
                <a class="my-navbar-brand navbar-brand" href="../top.html">安全管理システム</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#Navbar" aria-controls="Navbar" aria-expanded="false" aria-label="ProA2023">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="Navbar">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="my-nav-item nav-link" aria-current="page" href="../top.html">トップページ<span class="sr-only"></span>
                            <img class="nav-img" src="../icon/家.png" alt="">
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="accident-search.html" class="my-nav-item nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">検索画面    
                                <img class="nav-img" src="../icon/検索画面icon.png" alt="">
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="accident-list.html">事故一覧</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="my-nav-item nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ヒヤリハット
                                <img class="nav-img" src="../icon/カテゴリ.png" alt="">
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../ヒヤリハット/inputNearmiss.html">ヒヤリハット入力画面</a></li>
                                <li><a class="dropdown-item" href="../ヒヤリハット/Nearmisslist.html">ヒヤリハット一覧</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="my-nav-item nav-link" href="../word-cloud.html">ワードクラウド
                                <img class="nav-img" src="../icon/ワードクラウド画面.png" alt="">
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
            <tr>
                <th>番号</th>
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
                <th>事故発生後の対策</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['番号'] . "</td>";
                    echo "<td>" . $row['工事分野'] . "</td>";
                    echo "<td>" . $row['工事の種類'] . "</td>";
                    echo "<td>" . $row['工種'] . "</td>";
                    echo "<td>" . $row['工法・形式名'] . "</td>";
                    echo "<td>" . $row['災害分類'] . "</td>";
                    echo "<td>" . $row['事故分類'] . "</td>";
                    echo "<td>" . $row['天候'] . "</td>";
                    echo "<td>" . $row['事故発生年・月・時間'] . "</td>";
                    echo "<td>" . $row['事故発生場所（都道府県）'] . "</td>";
                    echo "<td>" . $row['事故に至る経緯と事故の状況'] . "</td>";
                    echo "<td>" . $row['事故の要因'] . "</td>";
                    echo "<td>" . $row['事故発生後の対策'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='13'>データがありません</td></tr>";
            }
            ?>
        </table>
    </main>

    <footer class="text-center mt-5">
        文教大学 情報学部 情報システム学科 プロジェクト演習BC
        <p>&copy; 2024 Team F, All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

<?php
// データベース接続を閉じる
$conn->close();
?>
