<?php
session_start();
require 'db.php';

$email = '';
$password = '';
$err_msg = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $dbh = getDbConnection();
        $stmt = $dbh->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            echo 'ログイン成功';
        } else {
            $err_msg['login'] = 'メールアドレスまたはパスワードが間違っています';
        }
    } catch (PDOException $e) {
        echo 'データベースエラー: ' . $e->getMessage();
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
    <label for=""><span>メールアドレス</span>
      <input type="email" name="email" id=""><br>
    </label>
    <div class="err_msg"><?php echo isset($err_msg['password']) ? $err_msg['password'] : ''; ?></div>
    <label for=""><span>パスワード</span>
      <input type="password" name="password" id=""><br>
    </label>
    <input type="submit" value="ログイン">
  </form>
  <p>アカウントをお持ちでないですか？ <a href="register.php">新規登録はこちら</a></p>
</body>
</html>
