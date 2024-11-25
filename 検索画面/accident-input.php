<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>事故入力画面</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                            <a href="検索画面/accident-search.html" class="my-nav-item nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">検索画面    
                                <img class="nav-img" src="../icon/検索画面icon.png" alt="">
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="accident-list.html">他社事故一覧</li>
                                <li><a class="dropdown-item" href="accident-input.php">事故入力画面
                                </a></li>
                                <li><a class="dropdown-item" href="accident-detail2.php">自社事故一覧</li>
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
                        <li class="nav-bottom">
                            <a href="" onclick="return confirm('ログアウトしてもよろしいですか？');" style="display: inline-block; margin:20px 10px ; padding: 10px 20px; background-color: #ff6347; color: white; text-decoration: none; border-radius: 5px;">
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
        <h2 class="text-center mb-4">事故入力画面</h2>
        <?php
        session_start();
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-info" role="alert">' . htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8') . '</div>';
            unset($_SESSION['message']);
        }

        // CSRFトークン生成
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        ?>

        <form action="insert_incident.php" method="post" class="input-form">
            <!-- CSRFトークンを含める -->
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') ?>">

            <div class="mb-3">
                <label for="incidentTitle" class="form-label">タイトル <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="incidentTitle" name="incidentTitle" placeholder="例: 工事現場での転倒" required>
            </div>
            <div class="mb-3">
                <label for="recordDate" class="form-label">記録日 <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="recordDate" name="recordDate" required>
            </div>
            <div class="mb-3">
                <label for="occurrenceDate" class="form-label">発生日 <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="occurrenceDate" name="occurrenceDate" required>
            </div>
            <div class="mb-3">
                <label for="recorderName" class="form-label">記録者名 <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="recorderName" name="recorderName" placeholder="記録者の名前を入力" required>
            </div>
            <div class="mb-3">
                <label for="targetName" class="form-label">対象者名</label>
                <input type="text" class="form-control" id="targetName" name="targetName" placeholder="対象者の名前を入力">
            </div>
            <div class="mb-3">
                <label for="incidentDetails" class="form-label">詳細</label>
                <textarea class="form-control" id="incidentDetails" name="incidentDetails" rows="5" placeholder="ヒヤリハットの詳細を入力してください"></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">登録</button>
            </div>
        </form>
    </div>
</main>

<footer>
    <p>文教大学 情報学部 情報システム学科 プロジェクト演習BC</p>
    <p>Copyright &copy; 2024, Team F, All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
