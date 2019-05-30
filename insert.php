<?php

// 1. POSTデータ取得
$title = $_POST['title'] ?? '';
$authors = $_POST['authors'] ?? '';
$publisher = $_POST['publisher'] ?? '';
$publishedDate = $_POST['publishedDate'] ?? '';

// 2. DB接続します
try {
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());
}

// 3. データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_bd_table( id, title, authors, publisher, publishedDate)VALUES( null, :title, :authors, :publisher, :publishedDate)");
$stmt->bindValue(':title', $title, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':authors', $authors, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':publisher', $publisher, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':publishedDate', $publishedDate, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

// 4. データ登録処理後
header('Content-Type: application/json; charset=utf-8');
if ($status === false) {
    // SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    echo json_encode(["QueryError" => $error[2]]);
}
else {
    // SQL実行時にエラーがない場合
    echo json_encode(["QuerySuccess" => "正常に保存されました"]);
}
