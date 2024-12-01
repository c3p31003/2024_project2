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

// IDを取得
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// データを取得
$sql = "SELECT * FROM nearmiss_reports WHERE id='$id'";
$result = $conn->query($sql);

// データが存在するか確認
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "データが見つかりません";
    $conn->close();
    exit();
}

$conn->close();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>詳細情報</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/nearmiss.css">
    <style>
        .card-header i {
            margin-right: 10px;
        }
        .card-body p {
            margin-bottom: 10px;
        }
    </style>
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
                            <a class="my-nav-item nav-link" href="../word-cloud.html">ワードクラウド
                                <img class="nav-img" src="../icon/ワードクラウド画面.png" alt="">
                            </a>
                        </li>
                        <li class="nav-bottom">
                            <a href="#" onclick="return confirm('ログアウトしてもよろしいですか？');" style="display: inline-block; margin:20px 10px; padding: 10px 20px; background-color: #ff6347; color: white; text-decoration: none; border-radius: 5px;">
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
            <h2 class="text-center mb-4">詳細情報</h2>
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-calendar-check"></i> 記録情報
                </div>
                <div class="card-body">
                    <p><strong>記録日時:</strong> <?php echo htmlspecialchars($row['record_date'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>発生日:</strong> <?php echo htmlspecialchars($row['occurrence_date'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>記録者:</strong> <?php echo htmlspecialchars($row['recorder_name'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <p><strong>対象者:</strong> <?php echo htmlspecialchars($row['target_name'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <div class="card-header">
                    <i class="bi bi-info-circle"></i> 詳細情報
                </div>
                <div class="card-body">
                    <p><strong>カテゴリ:</strong> カテゴリ1</p>
                    <p><strong>詳細:</strong> <?php echo nl2br(htmlspecialchars($row['details'], ENT_QUOTES, 'UTF-8')); ?></p>
                </div>
                <div class="card-footer text-center">
                    <a href="Nearmisslist.php" class="btn btn-primary">戻る</a>
                </div>
            </div>
        </div>
    </main>
    <footer>
        文教大学 情報学部 情報システム学科 プロジェクト演習BC
        <p>Copyright &copy; 2024, Team F, All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
