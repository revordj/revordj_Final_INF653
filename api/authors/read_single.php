<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require('../../config/Database.php');
require('../../models/Author.php');


// Instantiate DB & connect

$database = new Database();
$db = $database->connect();

// Instantiate Author object
$author = new Author($db);

//Get ID
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

//Get quote

$author->read_single();

//Create array
$author_arr = array(
    'id' => $author->id,
	'author' => $author->author
);

//Make JSON
print_r(json_encode($author_arr));
?>