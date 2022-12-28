<?php 
    class Database {
        
		private $host = "localhost";
        private $database_name = "pertemuan14";
        private $username = "postgres";
        private $password = "1234";

        public $conn;

        public function getConnectionPostgreSQL(){
            $this->conn = null;
            try{
                $this->conn = new PDO("pgsql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            }catch(PDOException $exception){
                echo "Database could not be connected: " . $exception->getMessage();
            }
            return $this->conn;
        }
			

		
    }  
?>