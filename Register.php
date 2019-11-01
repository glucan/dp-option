<?php
//Manager.phpの読み込み
require_once 'Manager.php';

try {
//データベースに接続してPDOオブジェクトを生成
    $db = connect();
    $sql = 'UPDATE status
            SET songid=:id, clear=:clear, left_op=:left, right_op=:right, flip=:flip
            WHERE songid=:id';

    //プリペアドステートメントを生成
    $stt = $db->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
    //プリペアドステートメントを実行
    $stt->execute(array(':id' => $_POST['id'],
                        ':clear' => $_POST['clear'],
                        ':left' => $_POST['left'],
                        ':right' => $_POST['right'],
                        ':flip' => $_POST['flip']
                        ));
    $db = null; //切断
} catch (PDOException $e) {
    exit("エラーが発生しました。:{$e->getMessage()}");
}
header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']));