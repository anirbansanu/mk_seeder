# Laravel Seeder Generator Script

# Database Seeder Script

The PHP script `seeder.php` is designed to automate the process of generating Laravel seeder files for database tables using the `DatabaseConnection` and `LaravelSeederGenerator` classes. It facilitates the population of database tables with initial data in a Laravel application.

## Table of Contents

- [Usage](#usage)
- [Included Classes](#included-classes)
- [Example Usage](#example-usage)
- [Script Execution](#script-execution)

## Usage

To use the `seeder.php` script, follow these steps:

1. Include the necessary classes, `DatabaseConnection.php` and `LaravelSeederGenerator.php`, in the same directory as the script or provide the correct paths.
2. Configure the database connection parameters by setting the `$db_name`, `$db_host`, `$db_user`, and `$db_password` variables in the script.
3. Define an array of database tables (`$tables`) for which you want to generate seeder files.
4. Create an instance of the `DatabaseConnection` class and the `LaravelSeederGenerator` class.
5. Iterate through the list of tables and generate seeder files using the `generateSeeder` method.
6. Close the database connection using the `closeConnection` method.

## Included Classes

### DatabaseConnection Class

The `DatabaseConnection` class encapsulates database connection functionality. It allows you to connect to a MySQL database and fetch data from specified tables.

### LaravelSeederGenerator Class

The `LaravelSeederGenerator` class simplifies the generation of Laravel seeder files based on data retrieved from database tables. It generates seeder files following Laravel's naming conventions and includes data for insertion.

## Example Usage

```php
// Include the necessary classes
include_once('./oops/DatabaseConnection.php');
include_once('./oops/LaravelSeederGenerator.php');

// Configure database connection parameters
$db_name = 'twebezli_learn_and_cure_new';
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';

// Create instances of DatabaseConnection and LaravelSeederGenerator
$databaseConnection = new DatabaseConnection($db_name, $db_host, $db_user, $db_password);
$seederGenerator = new LaravelSeederGenerator();

// Define the list of database tables to generate seeders for
$tables = ['doctors'];

// Generate seeders for each table
foreach ($tables as $table_name) {
    $data = $databaseConnection->fetchTableData($table_name);
    $seederGenerator->generateSeeder($table_name, $data);
}

// Close the database connection
$databaseConnection->closeConnection();
