import pymysql  # Assuming you're using MySQL. You can change this library based on your SQL database.

# Database connection settings
db_host = 'localhost'
db_user = 'root'
db_password = ''
db_name = 'old_learn_and_cure'

# Connect to the database
connection = pymysql.connect(host=db_host, user=db_user, password=db_password, database=db_name)

# Define the table name and columns
table_name = 'vaccines'
columns = ['column1', 'column2', 'column3']  # Replace with the actual column names

# Query the database to fetch data
cursor = connection.cursor()
query = f"SELECT * FROM {table_name}"
cursor.execute(query)
data = cursor.fetchall()

# Close the database connection
connection.close()

# Generate the Laravel seeder file
seeder_file_content = """<?php

use Illuminate\Database\Seeder;
use App\Models\YourModel;  // Replace with your actual model

class YourTableSeeder extends Seeder
{
    public function run()
    {
"""

for row in data:
    seeder_file_content += f"        YourModel::create({str(row)});\n"  # Replace with your actual model

seeder_file_content += """    }
}
"""

# Write the seeder file
seeder_file_name = f"{table_name}_seeder.php"
with open(seeder_file_name, 'w') as seeder_file:
    seeder_file.write(seeder_file_content)

print(f"Seeder file '{seeder_file_name}' has been generated.")
