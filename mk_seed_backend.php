<?php
// Include the necessary classes
include_once('./oops/DatabaseConnection.php');
include_once('./oops/LaravelSeederGenerator.php');

try {
    // Retrieve input data from POST
    $db_name = isset($_POST['db_name']) ? $_POST['db_name'] : "";
    $db_host = isset($_POST['db_host']) ? $_POST['db_host'] : 'localhost';
    $db_user = isset($_POST['db_user']) ?$_POST['db_user'] : 'root';
    $db_password = isset($_POST['db_password']) ?$_POST['db_password']: '';

    // Ensure that 'tables' is an array, or set it to an empty array if not provided
    $tables = $_POST['tables'] ?? [];

    // Initialize the database connection
    $databaseConnection = new DatabaseConnection($db_name, $db_host, $db_user, $db_password);

    // Initialize the SeederGenerator
    $seederGenerator = new LaravelSeederGenerator();

    // Loop through each table and generate seeders
    foreach ($tables as $table_name) {
        $data = $databaseConnection->fetchTableData($table_name);
        $success_message = $seederGenerator->generateSeeder($table_name, $data);
    }

    // Close the database connection
    $databaseConnection->closeConnection();
    // Get the referring URL
    $referrer = 'mk_seed_frontend.php'; // Default to 'mk_seed_frontend.php' if no referrer

    // Redirect back with the success message
    header("Location: $referrer?success_message=" . urlencode($success_message));
    exit; // Ensure the script exits after the redirection
} catch (Exception $e) {
    // Handle exceptions here, such as displaying an error message or logging the error
    echo "Error: " . $e->getMessage();

    // Get the referring URL
    $referrer = 'mk_seed_frontend.php'; // Default to 'mk_seed_frontend.php' if no referrer

    // Redirect back with the error message
    header("Location: $referrer?error_message=" . urlencode($error_message));
    exit; // Ensure the script exits after the redirection
}
?>
