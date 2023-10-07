<?php
include_once('./oops/DatabaseConnection.php');
include_once('./oops/LaravelSeederGenerator.php');

$databaseConnection = new DatabaseConnection($db_name = 'twebezli_learn_and_cure_new',$db_host = 'localhost',$db_user = 'root',$db_password = '');
$tables = ['doctors'];
$seederGenerator = new LaravelSeederGenerator();

foreach ($tables as $table_name) {
    $data = $databaseConnection->fetchTableData($table_name);
    $seederGenerator->generateSeeder($table_name, $data);
}

$databaseConnection->closeConnection();

?>
