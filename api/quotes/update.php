<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require('../../config/Database.php');
require('../../models/Quotes.php');


// Instantiate DB & connect

$database = new Database();
$db = $database->connect();

// Instantiate Quotes object
$quotes = new Quotes($db);

//Get raw posted data
$data = json_decode(file_get_contents("php://input"));

//Set ID to update

$quotes->id = $data->id;

$quotes->quote = $data->quote;
$quotes->auth_id = $data->authorId;
$quotes->cate_id = $data->categoryId;

//create quote
if($quotes->update()){
    echo json_encode(
        array('message' => 'Quote Updated')
    );
}
else{
    echo json_encode(
        array('message' => 'Quote Not Updated')
    );
}