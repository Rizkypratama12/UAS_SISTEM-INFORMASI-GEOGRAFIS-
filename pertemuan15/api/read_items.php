<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../config/database.php';
    include_once '../class/items.php';

    $database = new Database();
    
	$db = $database->getConnectionPostgreSQL(); // koneksi untuk postgres
	//$db = $database->getConnectionMysql(); // koneksi untuk mysql

    $items = new Items($db);

    $stmt = $items->getItemsPostgreSQL(); // ambil data untuk postgres
	//$stmt = $items->getItemsMySQL(); // ambil data untuk mysql
    $itemCount = $stmt->rowCount();

    if($itemCount > 0){
        
        $employeeArr = array();
        $employeeArr["body"] = array();
        $employeeArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "name" => $name_item,
                "price" => $price
            );

            array_push($employeeArr["body"], $e);
        }
        echo json_encode($employeeArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
?>