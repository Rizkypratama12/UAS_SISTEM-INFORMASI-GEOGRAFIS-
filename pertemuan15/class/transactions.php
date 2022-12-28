<?php
    class Transaction{

        // Connection
        private $conn;

        // Table
        private $db_table_transaction = "transaction";
		private $db_table_items = "items";
		private $db_table_employee = "employee";
        

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL Transaction PostgreSQL
        public function getTransactionPostgreSQL(){
            $sqlQuery = "SELECT * FROM " . $this->db_table_transaction . " TR 
			INNER JOIN ".$this->db_table_items." IT ON TR.id_item = IT.id 
			INNER JOIN ".$this->db_table_employee." EM ON TR.id_employee  = EM.id";
			$data = $this->conn->query($sqlQuery);
			return $data;
        }
		
		
		// GET ALL Transaction Mysql
        public function getTransactionMysql(){
            $sqlQuery = "SELECT * FROM " . $this->db_table_transaction . " TR 
			INNER JOIN ".$this->db_table_items." IT ON TR.id_item = IT.id 
			INNER JOIN ".$this->db_table_employee." EM ON TR.id_employee  = EM.id";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }
		
		// READ single postgeSQL
        public function getSingleTransactionPostgreSQL(){
            $sqlQuery = "SELECT id, datetime, qyt, status, id_item, id_employee FROM ". $this->db_table_transaction ." WHERE id_employee =:id_employee LIMIT 1";
			
            $stmt = $this->conn->prepare($sqlQuery);
			$stmt->bindValue (':id_employee', $this->id_employee);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
			$this->id = $dataRow['id'];
            $this->datetime = $dataRow['datetime'];
            $this->qyt = $dataRow['qyt'];
			$this->status = $dataRow['status'];
			$this->id_item = $dataRow['id_item'];
			
        } 	
		
		// INSERT DATA UNTUK POSTGRESQL DAN MYSQL
        public function createTransaction(){
          
			$sqlQuery = "INSERT INTO ". $this->db_table_transaction ." (datetime, qyt, status, id_item, id_employee) VALUES(:datetime, :qyt, :status, :id_item, :id_employee)";
        		
            $stmt = $this->conn->prepare($sqlQuery);
	
            // bind data
            $stmt->bindParam(':datetime', $this->datetime);
            $stmt->bindParam(':qyt', $this->qyt);
			$stmt->bindParam(':status', $this->status);
			$stmt->bindParam(':id_item', $this->id_item);
			$stmt->bindParam(':id_employee', $this->id_employee);
        
			$hasil = $stmt->execute();
		
            if($hasil){
               return true;
            }
            return false;
        }
		
		// DELETE MYSQL DAN POSTGRESQL
        function deleteTransaction(){
            $sqlQuery = "DELETE FROM " . $this->db_table_transaction . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
      
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }
		
		// UPDATE DATA DI MYSQL DAN POSTGRESQL
        public function updateTransaction(){
            $sqlQuery = "UPDATE
                        ". $this->db_table_transaction ."
                    SET 
						datetime = :datetime,
                        qyt = :qyt,
						status = :status,
						id_item = :id_item,
						id_employee = :id_employee
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->datetime=htmlspecialchars(strip_tags($this->datetime));
            $this->qyt=htmlspecialchars(strip_tags($this->qyt));
			$this->status=htmlspecialchars(strip_tags($this->status));
			$this->id_item=htmlspecialchars(strip_tags($this->id_item));
			$this->id_employee=htmlspecialchars(strip_tags($this->id_employee));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":datetime", $this->datetime);
            $stmt->bindParam(":qyt", $this->qyt);
			$stmt->bindParam(":status", $this->status);
			$stmt->bindParam(":id_item", $this->id_item);
			$stmt->bindParam(":id_employee", $this->id_employee);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }
		// GET Most Frequency
        public function getEmployeeFrequentlyBuy(){
            $sqlQuery = "SELECT TR.id_employee, EM.name, COUNT(TR.id_employee) AS frequency FROM " .$this->db_table_transaction ." TR 
			INNER JOIN ".$this->db_table_items." IT ON TR.id_item = IT.id 
			INNER JOIN ".$this->db_table_employee." EM ON TR.id_employee  = EM.id
			GROUP BY TR.id_employee, EM.name ORDER BY frequency DESC";
			$data = $this->conn->query($sqlQuery);
			return $data;
        }
		
    }
?>