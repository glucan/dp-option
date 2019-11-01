<?php
require_once 'Manager.php';
require_once 'Escape.php';
require_once 'Table.php';
?>

<!DOCTYPE html>
<html lang="jp">
<head>
    <meta name="dptable" content="dptable" charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initioal-scale=1">
    <title>DP難易度表</title>
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="./bootstrap/js/jquery-3.1.1.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
    <h1 align="center">DP☆12クリアOP管理</h1>
    <div class="content">

<?php
$table120 = new Table(12.0);
$table120->printTable();
$table120->printModal();
$table121 = new Table(12.1);
$table121->printTable();
$table121->printModal();
$table122 = new Table(12.2);
$table122->printTable();
$table122->printModal();
$table123 = new Table(12.3);
$table123->printTable();
$table123->printModal();
$table124 = new Table(12.4);
$table124->printTable();
$table124->printModal();
$table125 = new Table(12.5);
$table125->printTable();
$table125->printModal();
?>
    </div>

</body>
</html>