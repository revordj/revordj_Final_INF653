<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require('../../config/Database.php');
require('../../models/Quotes.php');


// Instantiate DB & connect

$database = new Database();
$db = $database->connect();

// Instantiate Quotes object
$quotes = new Quotes($db);

//Get ID
$quotes->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get quote

$quotes->read_single();

//Create array
$quote_arr = array(
    'id' => $quotes->id,
	'quote' => $quotes->quote,
	'category' => $quotes->category,
	'author' => $quotes->author
);

//Make JSON
print_r(json_encode($quote_arr));
?>