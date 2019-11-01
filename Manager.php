<?php
function connect()
{
    $env = getenv('DATABASE_URL');
    echo $env;
    $dsn = 'pgsql:host=; dbname=; sslmode=;';
    $usr = '';
    $passwd = '';

    try {
        $db = new PDO($dsn, $usr, $passwd);
    } catch (PDOException $e) {
        exit("データベースに接続できません。:{$e->getMessage()}");
    }
    return $db;
}
