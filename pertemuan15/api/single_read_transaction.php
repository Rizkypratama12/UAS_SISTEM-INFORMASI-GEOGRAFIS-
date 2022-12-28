<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/transactions.php';

    $database = new Database();
    $db = $database->getConnectionPostgreSQL(); // untuk postgresSQL
	//$db = $database->getConnectionMysql(); // untuk mysql

    $item = new Transaction($db);
    $item->id_employee = isset($_GET['id_employee']) ? $_GET['id_employee'] : die();
    
	$item->getSingleTransactionPostgreSQL(); // untuk postgresSQL
	//$item->getSingleEmployeeMySql(); // untuk mysql
	

    if($item->id_employee != null){
        
		// create array
        $emp_arr = array(
            "datetime" => $item->datetime,
            "qyt" => $item->qyt,
            "status" => $item->status,
            "id_item" => $item->id_item,
            "id_employee" => $item->id_employee
        );
      
        http_response_code(200);
        echo json_encode($emp_arr);
    }
      
    else{
        http_response_code(404);
        echo json_encode("Transaction not found.");
    }
?>