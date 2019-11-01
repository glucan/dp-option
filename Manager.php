<?php
function connect()
{
    $env = getenv('DATABASE_URL');
    echo $env;
    $dsn = 'pgsql:host='.getenv('DATABASE_HOST').'; dbname='.getenv('DATABASE_NAME').';';
    $usr = getenv('DATABASE_USER');
    $passwd = getenv('DATABASE_PASSWORD');

    try {
        $db = new PDO($dsn, $usr, $passwd);
    } catch (PDOException $e) {
        exit("データベースに接続できません。:{$e->getMessage()}");
    }
    return $db;
}
