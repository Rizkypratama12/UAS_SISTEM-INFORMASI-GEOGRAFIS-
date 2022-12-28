<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../class/items.php';

    $database = new Database();
	
	$db = $database->getConnectionPostgreSQL(); // koneksi untuk postgres
	//$db = $database->getConnectionMysql(); // koneksi untuk mysql

    $item = new Items($db);

    $data = json_decode(file_get_contents("php://input"));

    $item->name_item = $data->name_item;
    $item->price = $data->price;
    
	
	
    if($item->createItems()){
        echo 'insert success.';
    } else{
        echo 'insert failed.';
    }

?>