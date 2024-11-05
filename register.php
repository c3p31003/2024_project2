<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $dbh = getDbConnection();
        $stmt = $dbh->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
        $stmt->execute([$email, $password]);
        echo 'ユーザー登録が完了しました';
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
  <title>新規ユーザー登録</title>
</head>
<body>
  <h1>新規ユーザー登録</h1>
  <form action="" method="post">
    <label for=""><span>メールアドレス</span>
      <input type="email" name="email" id=""><br>
    </label>
    <label for=""><span>パスワード</span>
      <input type="password" name="password" id=""><br>
    </label>
    <input type="submit" value="登録">
  </form>
  <p>既にアカウントをお持ちですか？ <a href="login.php">ログインはこちら</a></p>
</body>
</html>
