<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // ログインページにリダイレクト
    exit();
}
$username = $_SESSION['username']; // ログインユーザー名を取得
$last_login = isset($_SESSION['last_login']) ? $_SESSION['last_login'] : '初回ログインです'; // 前回のログイン日時を取得
$previous_login_user = isset($_SESSION['previous_login_user']) ? $_SESSION['previous_login_user'] : '不明なユーザー'; // 前回のログインユーザー名を取得
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>トップページ - 安全管理システム</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="css/ProC_style.css">
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
                                <img class="nav-img" src="icon/家.png" alt="">
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="検索画面/accident-search.html" class="my-nav-item nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">検索画面
                                <img class="nav-img" src="icon/検索画面icon.png" alt="">
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="検索画面/accident-list.html">事故一覧</a></li>
                                <li><a class="dropdown-item" href="検索画面/accident-input.html">事故入力画面</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#" class="my-nav-item nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">ヒヤリハット
                                <img class="nav-img" src="icon/カテゴリ.png" alt="">
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="inputNearmiss.php">ヒヤリハット入力画面</a></li>
                                <li><a class="dropdown-item" href="Nearmisslist.php">ヒヤリハット一覧</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="my-nav-item nav-link" href="word-cloud.html">ワードクラウド
                                <img class="nav-img" src="icon/ワードクラウド画面.png" alt="">
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a href="logout.php" onclick="return confirm('ログアウトしてもよろしいですか？');" style="display: inline-block; margin: 0 10px; padding: 10px 20px; background-color: #ff6347; color: white; text-decoration: none; border-radius: 5px;">
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
            <h1 class="text-center">安全管理システム</h1>
            <p class="text-center">このシステムは、過去の事故やヒヤリハットの事例を視覚的にわかりやすく表示するための管理ツールです。<br>本システムを通じて、安全対策を強化し、事故の発生を最小限に抑えることを目標としています。</p>
            <p class="text-center">以下は各メニューバー説明です：</p>
            <ul>
                <li>トップページ・・・トップページに戻ります。</li>
                <li>検索画面・・・事故一覧画面および事故入力画面に移動します。事故の詳細を確認したり、新しい事故を入力することができます。</li>
                <li>ヒヤリハット・・・ヒヤリハット一覧画面およびヒヤリハット入力画面に移動します。ヒヤリハット事例を確認したり、新しい事例を入力することができます。</li>
                <li>報告書支援・・・報告書支援入力画面に移動します。ここで、報告書の作成や編集を行うことができます。</li>
                <li>ログアウト・・・ログアウトし、ログイン画面に移動します。再度ログインする際に使用します。</li>
            </ul>
            <p class="text-center">ログインユーザー: <strong><?php echo htmlspecialchars($previous_login_user, ENT_QUOTES, 'UTF-8'); ?></strong></p>
            <p class="text-center">前回のログイン日時: <strong><?php echo htmlspecialchars($last_login, ENT_QUOTES, 'UTF-8'); ?></strong></p>
        </div>
    </main>
    <footer class="text-center">
        文教大学 情報学部 情報システム学科 プロジェクト演習BC
        <p>Copyright &copy; 2024, Team F, All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
