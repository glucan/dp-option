<?php
function es($str, $charset = 'UTF-8') {
    //文字列をエスケープ処理して出力する
    print htmlspecialchars($str, ENT_QUOTES, $charset);
}
