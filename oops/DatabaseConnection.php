<?php

class DatabaseConnection
{
    private $db_host = 'localhost';
    private $db_user = 'root';
    private $db_password = '';
    private $db_name = 'twebezli_learn_and_cure_new';
    private $connection;

    public function __construct($db_name = 'twebezli_learn_and_cure_new',$db_host = 'localhost',$db_user = 'root',$db_password = '')
    {
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_password = $db_password;
        $this->db_name = $db_name;
        $this->connection = new mysqli($this->db_host, $this->db_user, $this->db_password, $this->db_name);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function closeConnection()
    {
        $this->connection->close();
    }

    public function fetchTableData($table_name)
    {
        $query = "SELECT * FROM " . $table_name;
        $result = $this->connection->query($query);
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }
}

?>