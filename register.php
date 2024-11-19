<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style-1.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規ユーザー登録</title>
</head>
<body>
  <?php
  require 'db.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = $_POST['username'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

      try {
          $dbh = getDbConnection();

          // ユーザー名の重複をチェック
          $stmt = $dbh->prepare('SELECT COUNT(*) FROM users WHERE username = ?');
          $stmt->execute([$username]);
          $count = $stmt->fetchColumn();

          if ($count > 0) {
              echo '<div class="error">このユーザー名は既に使用されています。</div>';
          } else {
              // ユーザー名が重複していない場合に登録
              $stmt = $dbh->prepare('INSERT INTO users (username, password) VALUES (?, ?)');
              $stmt->execute([$username, $password]);
              echo '<div class="success">ユーザー登録が成功しました！</div>';
          }
      } catch (PDOException $e) {
          echo '<div class="error">データベースエラーが発生しました: ' . $e->getMessage() . '</div>';
      }
  }
  ?>
  <h1>新規ユーザー登録</h1>
  <form action="" method="post">
    <label for=""><span>ユーザー名</span>
      <input type="text" name="username" id="" required><br>
    </label>
    <label for=""><span>パスワード</span>
      <input type="password" name="password" id="" required><br>
    </label>
    <input type="submit" value="登録">
  </form>
  <p>既にアカウントをお持ちですか？ <a href="login.php">ログインはこちら</a></p>
</body>
</html>
