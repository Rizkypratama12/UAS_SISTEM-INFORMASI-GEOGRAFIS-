<?php
    class Items{

        // Connection
        private $conn;

        // Table
        private $db_table = "items";
        // Columns
        public $id;
        public $name_item;
        public $price;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL PostgreSQL
        public function getItemsPostgreSQL(){
            $sqlQuery = "SELECT id, name_item, price FROM " . $this->db_table . "";
			$data = $this->conn->query($sqlQuery);
			return $data;
        }
		
		// GET ALL Mysql
        public function getItemsMySQL(){
            $sqlQuery = "SELECT id, name_item, price FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // READ single
        public function getSingleItemsMySql(){
            $sqlQuery = "SELECT id, name_item, price FROM ". $this->db_table ." WHERE id = ? LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->bindParam(1, $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name_item'];
            $this->price = $dataRow['price'];
        }  

		// READ single postgeSQL
        public function getSingleItemsPostgreSQL(){
            $sqlQuery = "SELECT id, name_item, price FROM ". $this->db_table ." WHERE id =:id LIMIT 1";
			
            $stmt = $this->conn->prepare($sqlQuery);
			$stmt->bindValue (':id', $this->id);
            $stmt->execute();
            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name_item'];
            $this->price = $dataRow['price'];
        } 		
		
		
		// INSERT DATA UNTUK POSTGRESQL DAN MYSQL
        public function createItems(){
          
			$sqlQuery = "INSERT INTO ". $this->db_table ." (name_item, price) VALUES(:name_item, :price)";
        		
            $stmt = $this->conn->prepare($sqlQuery);
	
            // bind data
            $stmt->bindParam(':name_item', $this->name_item);
            $stmt->bindParam(':price', $this->price);
        
			$hasil = $stmt->execute();
		
            if($hasil){
               return true;
            }
            return false;
        }
		
		// DELETE MYSQL DAN POSTGRESQL
        function deleteItems(){
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
        public function updateItems(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name_item = :name_item, 
                        price = :price
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->name_item=htmlspecialchars(strip_tags($this->name_item));
            $this->price=htmlspecialchars(strip_tags($this->price));
        
            // bind data
            $stmt->bindParam(":name_item", $this->name_item);
            $stmt->bindParam(":price", $this->price);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        

    }
?>