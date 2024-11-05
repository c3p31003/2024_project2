<?php
function getDbConnection() {
    $dsn = 'mysql:host=localhost;dbname=proC;charset=utf8';
    $user = 'test';
    $password_db = 'test3105';
    try {
        return new PDO($dsn, $user, $password_db);
    } catch (PDOException $e) {
        echo 'データベース接続失敗: ' . $e->getMessage();
        exit;
    }
}
?>
