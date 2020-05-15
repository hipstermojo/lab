<?php
    define('DB_SERVER','localhost');
    define('DB_USER', 'mysql');
    define('DB_PASS', 'password');
    define('DB_NAME', 'btc3205');

    class DBConnector{
        public $conn;
        function __construct(){
            $this->conn = new mysqli(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
            if ($this->conn->connect_errno) {
                
                die("Error:" . $this->conn->connect_error);
            }
            
        }

        public function closeDatabase()
        {
            mysqli_close($this->conn);
        }
    }
    
?>