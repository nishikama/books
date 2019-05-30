<?php

// 1. POSTデータ取得
$bookname = $_POST["bookname"];
$bookurl = $_POST["bookurl"];
$bookcomment = $_POST["bookcomment"];

// 2. DB接続します
try {
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('データベースに接続できませんでした。' . $e->getMessage());
}

// 3. データ登録SQL作成
$stmt = $pdo->prepare("INSERT INTO gs_bm_table( id, bookname, bookurl, bookcomment, indate)VALUES( null, :bookname, :bookurl, :bookcomment, sysdate())");
$stmt->bindValue(':bookname', $bookname, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':bookurl', $bookurl, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':bookcomment', $bookcomment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if ($status == false) {
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("QueryError:" . $error[2]);
} else {
    //５．index.phpへリダイレクト　この処理がないと画面が切り替わらない
    header("Location: index.php");
    exit;
}
