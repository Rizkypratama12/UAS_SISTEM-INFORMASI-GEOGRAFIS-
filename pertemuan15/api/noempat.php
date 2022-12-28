<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../config/database.php';
    include_once '../class/transactions.php';

    $database = new Database();
    
    $db = $database->getConnectionPostgreSQL(); // koneksi untuk mysql

    $items = new Transaction($db);

    $stmt = $items->soalno5(); // ambil data untuk postgres
    
    $itemCount = $stmt->rowCount();

    //if(!empty($stmt)){
    if($itemCount){
        
        $employeeArr = array();
        $employeeArr["body"] = array();
        $employeeArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "name_employee" => $name,
                "email_employee" => $email,
                "item_name" => $name_item,
                "price" => $price,
                "qty" => $qty,
                "datetime" => $datetime,
                "status" => $status
            );

            array_push($employeeArr["body"], $e);
        }
        echo json_encode($employeeArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No trx found.")
        );
    }
?>