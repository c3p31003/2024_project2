<?php
session_start();
require 'db.php';

$username = ''; // ユーザー名の変数を追加
$password = '';
$err_msg = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; // ユーザー名の入力を取得
    $password = $_POST['password'];

    if (empty($username)) {
        $err_msg['username'] = 'ユーザー名を入力してください';
    }

    if (empty($err_msg)) {
        try {
            $dbh = getDbConnection();
            $stmt = $dbh->prepare('SELECT * FROM users WHERE username = ?');
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username']; // ユーザー名をセッションに保存
                header('Location: top.php'); // 成功時に遷移するPHPファイル
                exit();
            } else {
                $err_msg['login'] = 'ユーザー名またはパスワードが間違っています';
            }
        } catch (PDOException $e) {
            $err_msg['db'] = 'データベースエラー: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style-1.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン画面</title>
</head>
<body>
  <h1>ログイン画面</h1>
  <form action="" method="post">
    <div class="err_msg"><?php echo isset($err_msg['login']) ? $err_msg['login'] : ''; ?></div>
    <div class="err_msg"><?php echo isset($err_msg['db']) ? $err_msg['db'] : ''; ?></div>
    <label for=""><span>ユーザー名</span> <!-- ユーザー名の入力フィールドを追加 -->
      <input type="text" name="username" id="" required><br>
      <div class="err_msg"><?php echo isset($err_msg['username']) ? $err_msg['username'] : ''; ?></div>
    </label>
    <label for=""><span>パスワード</span>
      <input type="password" name="password" id="" required><br>
    </label>
    <input type="submit" value="ログイン">
  </form>
  <p>アカウントをお持ちでないですか？ <a href="register.php">新規登録はこちら</a></p>
</body>
</html>

