<?php
    class Employee{

        // Connection
        private $conn;

        // Table
        private $db_table = "employee";
        private $db_tableemploye = "employee";
        private $db_tabletransaction = "transaction";
        // Columns
        public $id;
        public $name;
        public $email;
        public $age;
        public $designation;
        public $created;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL PostgreSQL
        public function getEmployeesPostgreSQL(){
            $sqlQuery = "SELECT id, name, email, age, designation, created FROM " . $this->db_table . "";
			$data = $this->conn->query($sqlQuery);
			return $data;
        }
		
		// GET ALL Mysql
        public function getEmployeesMySQL(){
            $sqlQuery = "SELECT id, name, email, age, designation, created FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // READ single
        public function getSingleEmployeeMySql(){
            $sqlQuery = "SELECT id, name, email, age, designation, created FROM ". $this->db_table ." WHERE id = ? LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name'];
            $this->email = $dataRow['email'];
            $this->age = $dataRow['age'];
            $this->designation = $dataRow['designation'];
            $this->created = $dataRow['created'];
        }  

		// READ single postgeSQL
        public function getSingleEmployeePostgreSQL(){
            $sqlQuery = "SELECT id, name, email, age, designation, created FROM ". $this->db_table ." WHERE id =:id LIMIT 1";
			
            $stmt = $this->conn->prepare($sqlQuery);
			$stmt->bindValue (':id', $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name'];
            $this->email = $dataRow['email'];
            $this->age = $dataRow['age'];
            $this->designation = $dataRow['designation'];
            $this->created = $dataRow['created'];
        } 		
		
		
		
		// NO 4
        public function getnoempatPostgreSQL(){
            $sqlQuery = "SELECT id, name, email, age, designation, created FROM ". $this->db_table ." WHERE id =:id LIMIT 1";
			$sqlQuery = "SELECT EM.name FROM". $this->db_tabletransaction . "TR INNER JOIN". $this->db_tableemploye. "EM ON TR.id_employee = EM.id WHERE TR.id_employee = 1";
			
			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			return $stmt;
        } 		
		
		
		// INSERT DATA UNTUK POSTGRESQL DAN MYSQL
        public function createEmployee(){
          
			$sqlQuery = "INSERT INTO ". $this->db_table ." (name, email, age, designation, created) VALUES(:name, :email, :age, :designation, :created)";
        		
            $stmt = $this->conn->prepare($sqlQuery);
	
            // bind data
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':age', $this->age);
            $stmt->bindParam(':designation', $this->designation);
            $stmt->bindParam(':created', $this->created);
        
			$hasil = $stmt->execute();
		
            if($hasil){
               return true;
            }
            return false;
        }
		
		// DELETE MYSQL DAN POSTGRESQL
        function deleteEmployee(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
      
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }
		
		// UPDATE DATA DI MYSQL DAN POSTGRESQL
        public function updateEmployee(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        email = :email, 
                        age = :age, 
                        designation = :designation, 
                        created = :created
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->age=htmlspecialchars(strip_tags($this->age));
            $this->designation=htmlspecialchars(strip_tags($this->designation));
            $this->created=htmlspecialchars(strip_tags($this->created));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":age", $this->age);
            $stmt->bindParam(":designation", $this->designation);
            $stmt->bindParam(":created", $this->created);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        

    }
?>