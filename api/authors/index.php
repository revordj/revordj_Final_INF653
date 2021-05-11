<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require('../../config/Database.php');
require('../../models/Author.php');


// Instantiate DB & connect

$database = new Database();
$db = $database->connect();

// Instantiate Author object
$Author_obj = new Author($db);

//Author query
$results = $Author_obj->read();

//Get row count
$num = $results->rowCount();

//Check if any Categories
if($num > 0){
	//Author array
	$auth_arr = array();
	$auth_arr['data'] = array();

	while($row  = $results->fetch(PDO::FETCH_ASSOC)){
		extract($row);

		$Author_item = array(
		'id' => $id,
		'author' => $author
		);

		// Push to "data"
		array_push($auth_arr['data'], $Author_item);
	}

	// Turn to JSON & output
	echo json_encode($auth_arr);
}
else{
	//No author present
	echo json_encode(
		array('message' => 'No Authors found.')
	);

	
}
?>