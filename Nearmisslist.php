<?php
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

// データを取得
$sql = "SELECT id, record_date, occurrence_date, recorder_name, target_name, details FROM nearmiss_reports";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ヒヤリハット一覧</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/nearmiss.css">
</head>
<body>
    <header id="header-fixed">
        <nav class="navbar navbar-expand-md navbar-dark">
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
                            <a class="my-nav-item nav-link" href="../word-cloud.html">安全報告書
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
    <main>
        <div class="container my-5">
            <h2 class="text-center mb-4">ヒヤリハット一覧</h2>
            <p class="text-center">ヒヤリハットの一覧を表示します</p>
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th>記録日時</th>
                        <th>発生日</th>
                        <th>記録者</th>
                        <th>対象者</th>
                        <th>カテゴリ</th>
                        <th>詳細</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        // データ出力
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["record_date"] . "</td>";
                            echo "<td>" . $row["occurrence_date"] . "</td>";
                            echo "<td>" . $row["recorder_name"] . "</td>";
                            echo "<td>" . $row["target_name"] . "</td>";
                            echo "<td>カテゴリ1</td>";
                            echo "<td><a href='detail.php?id=" . $row["id"] . "' class='btn btn-info btn-sm'>詳細</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>データがありません</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="text-center">
                <button class="btn btn-secondary">もっと見る</button>
            </div>
        </div>
    </main>
    <footer>
        文教大学 情報学部 情報システム学科 プロジェクト演習BC
        <p>Copyright &copy; 2024, Team F, All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

<?php
$conn->close();
?>
