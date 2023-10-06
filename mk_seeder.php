<?php

// Database connection settings
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'old_learn_and_cure';

// Connect to the database (MySQL example)
$connection = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check for connection errors
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$tables = ['medical_subtopic_images','medical_subtopic_videos','medical_topics','medical_subjects','medical_subtopic_articles',
'subjects','vaccines',
'children_vaccines','excercises','excercise_images','medical_subjects','medical_subtopic_articles','medical_subtopic_images',
'bloodtests','bloodtest_details','bloodtest_names','bloodtest_records','bloodtest_units'
];
foreach ($tables as $tablekey => $tablevalue) {
    mk_seed($connection,$tablevalue);
}
// Close the database connection
$connection->close();

function mk_seed($connection,$table_name){
    // Define the table name and columns
    $table_name = $table_name;

    // Query the database to fetch data
    $query = "SELECT * FROM " . $table_name;
    $result = $connection->query($query);
    $className = toCamelCase($table_name);
    // Generate the Laravel seeder file
    $insert_array_string = "";
    $seeder_file_content = "<?php
    namespace Database\Seeders;

    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB;


    class " . ucfirst($className) . "Seeder extends Seeder
    {
        public function run()
        {
    ";

    while ($row = $result->fetch_assoc()) {
        $insert_array_string .= makeArrayAsString($row).",";
    }
    $seeder_file_content .= "        DB::table('" . $table_name . "')->insert([".$insert_array_string. "]);\n";
    $seeder_file_content .= "    }
    }
    ";



    // Write the seeder file
    $seeder_file_name = $className . "Seeder.php";
    file_put_contents($seeder_file_name, $seeder_file_content);

    echo "Seeder file '{$seeder_file_name}' has been generated.\n";
}


function makeArrayAsString($array){
    $output = '';
    if(count($array)>0)
    {
        $output .= '[';
        foreach ($array as $key => $value) {
            if(!empty($value))
            {
                $output .= "'$key' => '$value' ,";
            }
            else
            {
                $output .= "'$key' => null ,";
            }
        }
        $output .= "]";
    }
    return $output;
}

function toCamelCase($value)
{
    // Split the string by underscores
    $parts = explode('_', $value);

    // Capitalize the first letter of each part and join them
    $camelCaseValue = implode('', array_map('ucfirst', $parts));

    return $camelCaseValue;
}

