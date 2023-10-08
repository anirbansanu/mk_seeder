<?php
include_once('./oops/DatabaseConnection.php');
include_once('./oops/LaravelSeederGenerator.php');

$db_name = $_POST['db_name'];
$db_host = $_POST['db_host'] ?? 'localhost';
$db_user = $_POST['db_user'] ?? 'root';
$db_password = $_POST['db_password'] ?? '';

$tables = $_POST['tables'] ?? [];  // $_POST['tables'] should contain array to tables names

$databaseConnection = new DatabaseConnection($db_name , $db_host , $db_user , $db_password);


$seederGenerator = new LaravelSeederGenerator();

foreach ($tables as $table_name) {
    $data = $databaseConnection->fetchTableData($table_name);
    $seederGenerator->generateSeeder($table_name, $data);
}

$databaseConnection->closeConnection();

?>
