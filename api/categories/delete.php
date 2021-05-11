<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require('../../config/Database.php');
require('../../models/Category.php');


// Instantiate DB & connect

$database = new Database();
$db = $database->connect();

// Instantiate category object
$category = new Category($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Set ID to update

$category->id = $data->id;


//creates quote
if($category->delete()){
    echo json_encode(
        array('message' => 'category Deleted')
    );
}
else{
    echo json_encode(
        array('message' => 'category Not Deleted')
    );
}