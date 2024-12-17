<?php
class Conexion
{
    private $conn = null;
    // Conexión a la base de datos
    private $host = "localhost";
    private $user = "rootCito";
    private $password = "postgres";
    private $dbname = "adonai_store_schema";

    public function conectar()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}
