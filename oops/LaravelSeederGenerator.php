<?php
class LaravelSeederGenerator
{
    public function generateSeeder($table_name, $data)
    {
        $className = $this->generateClassName($table_name);
        $insert_array_string = "";

        foreach ($data as $row) {
            $insert_array_string .= $this->makeArrayAsString($row) . ",\n";
        }

        $seeder_file_content = "<?php
        namespace Database\Seeders;

        use Illuminate\Database\Seeder;
        use Illuminate\Support\Facades\DB;

        class $className extends Seeder
        {
            public function run()
            {
                DB::table('$table_name')->insert([\n$insert_array_string 
                ]);
            }
        }
        ";
        $filepath = "seeders/";
        $seeder_file_name = $filepath.$className . ".php";
        file_put_contents($seeder_file_name, $seeder_file_content);

        echo "Seeder file '{$seeder_file_name}' has been generated.\n";
        
    }

    private function makeArrayAsString($array)
    {
        $output = "\t\t\t\t\t[";
        foreach ($array as $key => $value) {
            if (!empty($value)) {
                $output .= "'$key' => `$value`, ";
            } else {
                $output .= "'$key' => null, ";
            }
        }
        $output .= "]";

        return $output;
    }

    private function generateClassName($value)
    {
        $parts = explode('_', $value);
        $camelCaseValue = implode('', array_map('ucfirst', $parts));

        return $camelCaseValue.'Seeder';
    }
}

// $databaseConnection = new DatabaseConnection();
// $tables = ['doctors'];
// $seederGenerator = new LaravelSeederGenerator();

// foreach ($tables as $table_name) {
//     $data = $databaseConnection->fetchTableData($table_name);
//     $seederGenerator->generateSeeder($table_name, $data);
// }

// $databaseConnection->closeConnection();
?>
