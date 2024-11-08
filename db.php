<?php

class DB
{
    private $host = "localhost";
    private $user = "root";
    private $password = "root";
    private $database = "bypass";
    private $conn;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql)
    {
        $result = $this->conn->query($sql);

        if (!$result) {
            die("<h2 style='background-color: yellow'>Query SQL: " . $sql . "</h2><br />Query failed: " . $this->conn->error);
        }

        return $result;
    }

    public function fetch_array($result)
    {
        return $result->fetch_array(MYSQLI_ASSOC);
    }

    public function fetch_all($result)
    {
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Close the connection
    public function close()
    {
        $this->conn->close();
    }
}