<?php

// Include the DatabaseConnection class or set up your database connection here
include_once('./oops/DatabaseConnection.php');

try {
    $db_host = $_POST['db_host'] ?? 'localhost';
    $db_user = $_POST['db_user'] ?? 'root';
    $db_password = $_POST['db_password'] ?? '';
    $db_name = $_POST['db_name'] ?? 'twebezli_learn_and_cure_new';

    $dbHandler = new DatabaseConnection($db_name, $db_host, $db_user, $db_password);
    $tables = $dbHandler->fetchTableNames();
    $dbHandler->closeConnection();

    // Return the table names as JSON
    header('Content-Type: application/json');
    echo json_encode($tables);
} catch (Exception $e) {
    // Handle exceptions
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => $e->getMessage()]);
}

?>
