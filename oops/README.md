# DatabaseConnection Class

The `DatabaseConnection` class is a PHP class that simplifies database operations by encapsulating database connection, data retrieval, and connection closing processes. It is designed to be used with MySQL databases in PHP applications.

## Table of Contents

- [Installation](#installation)
- [Usage](#usage)
- [Constructor](#constructor)
- [Methods](#methods)
  - [closeConnection()](#closeconnection)
  - [fetchTableData($table_name)](#fetchtabledatatablename)
- [Example Usage](#example-usage)

## Installation

Clone or download the `DatabaseConnection.php` file and include it in your PHP project to utilize the `DatabaseConnection` class.

## Usage

To use the `DatabaseConnection` class in your PHP application, follow these steps:

1. Include the class in your PHP script.
2. Create a new instance of `DatabaseConnection` by calling the constructor with appropriate database connection parameters.
3. Use the class methods to interact with the database.
4. Close the database connection when you're done.

## Constructor

### `__construct($db_name = 'twebezli_learn_and_cure_new', $db_host = 'localhost', $db_user = 'root', $db_password = '')`

- **Parameters:**
  - `$db_name` (optional): The name of the database to connect to. Default is `'twebezli_learn_and_cure_new'`.
  - `$db_host` (optional): The database host server. Default is `'localhost'`.
  - `$db_user` (optional): The database username. Default is `'root'`.
  - `$db_password` (optional): The database password. Default is an empty string (`''`).

- **Description:** The constructor initializes a new instance of the `DatabaseConnection` class and establishes a connection to the MySQL database using the provided database connection parameters. If the connection fails, it will terminate the script with an error message.

## Methods

### `closeConnection()`

- **Description:** This method closes the established database connection, freeing up resources and ensuring that the connection is properly terminated.

### `fetchTableData($table_name)`

- **Parameters:**
  - `$table_name`: The name of the database table from which data should be fetched.

- **Return Value:** An array containing the fetched data from the specified database table.

- **Description:** This method executes an SQL query to fetch all the data from the specified database table. It retrieves the data row by row and stores it in an array, which is then returned as the result.

## Example Usage

```php
// Create a new DatabaseConnection instance
$databaseConnection = new DatabaseConnection('my_database', 'localhost', 'my_user', 'my_password');

// Fetch data from a specific table
$tableData = $databaseConnection->fetchTableData('my_table');

// Close the database connection
$databaseConnection->closeConnection();
```



# LaravelSeederGenerator Class

The `LaravelSeederGenerator` class is a PHP class designed to simplify the generation of Laravel seeder files from data retrieved from a database table. It is especially useful for populating database tables with initial data in a Laravel application.

## Table of Contents

- [Usage](#usage)
- [Methods](#methods)
  - [generateSeeder($table_name, $data)](#generateseedertable_name-data)
  - [makeArrayAsString($array)](#makearrayasstringarray)
  - [generateClassName($value)](#generateclassnamevalue)

## Usage

To use the `LaravelSeederGenerator` class in your PHP application, follow these steps:

1. Include the class in your PHP script.
2. Create an instance of `LaravelSeederGenerator`.
3. Call the `generateSeeder` method with the table name and data as parameters to generate a Laravel seeder file.

## Methods

### `generateSeeder($table_name, $data)`

- **Parameters:**
  - `$table_name`: The name of the database table for which you want to generate a seeder file.
  - `$data`: An array containing the data to be seeded into the database table.

- **Description:** This method generates a Laravel seeder file for the specified database table with the provided data. The generated seeder file includes an array of data that will be inserted into the table.

### `makeArrayAsString($array)`

- **Parameters:**
  - `$array`: An associative array representing a row of data from the database table.

- **Return Value:** A formatted string representation of the array suitable for inclusion in a Laravel seeder file.

- **Description:** This method converts an associative array representing a row of data into a formatted string that can be used as part of the data insertion statement in the Laravel seeder file.

### `generateClassName($value)`

- **Parameters:**
  - `$value`: A string representing the name of the database table.

- **Return Value:** A formatted string representing the class name for the Laravel seeder file based on the table name.

- **Description:** This method generates a class name for the Laravel seeder file based on the table name. It converts the table name to camelCase and appends "Seeder" to it, following Laravel's naming convention for seeders.

## Example Usage

```php
$seederGenerator = new LaravelSeederGenerator();

// Sample data retrieved from the database table
$data = [
    ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
    ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
];

// Generate a seeder file for the 'users' table
$seederGenerator->generateSeeder('users', $data);
