<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require('../../config/Database.php');
require('../../models/Category.php');


// Instantiate DB & connect

$database = new Database();
$db = $database->connect();

// Instantiate Category object
$category = new Category($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Set ID to update

$category->id = $data->id;

$category->category = $data->category;


//update Category
if($category->update()){
    echo json_encode(
        array('message' => 'Category Updated')
    );
}
else{
    echo json_encode(
        array('message' => 'Category Not Updated')
    );
}