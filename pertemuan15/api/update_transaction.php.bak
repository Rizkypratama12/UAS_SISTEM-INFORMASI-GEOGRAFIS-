<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    include_once '../config/database.php';
    include_once '../class/transactions.php';
    
    $database = new Database();
	
    $db = $database->getConnectionPostgreSQL(); // koneksi untuk postgres
	//$db = $database->getConnectionMysql(); // koneksi untuk mysql
    
    $item = new Transaction($db);
    
    $data = json_decode(file_get_contents("php://input"));
    
    $item->id = $data->id;
    
    // employee values
	$item->id = $data->id;
	$item->datetime = $data->datetime;
	$item->qyt = $data->qyt;
	$item->status = $data->status;
	$item->id_item = $data->id_item;
    $item->id_employee = $data->id_employee;
    
    if($item->updateTransaction()){
        echo json_encode("transactions data updated.");
    } else{
        echo json_encode("Data could not be updated");
    }
?>