<?php
// back-end/services/database.php
class Database {
    private $host = 'localhost';
    private $db_name = 'app_vet';
    private $username = 'root'; // Cambia por tu usuario de MySQL
    private $password = ''; // Cambia por tu contraseña
    public $conn;

    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name, 
                $this->username, 
                $this->password
            );
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            error_log("Error de conexión: " . $exception->getMessage());
        }
        
        return $this->conn;
    }
}
?>