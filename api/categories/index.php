<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require('../../config/Database.php');
require('../../models/Category.php');


// Instantiate DB & connect

$database = new Database();
$db = $database->connect();

// Instantiate Category object
$category_obj = new Category($db);

//Category query
$results = $category_obj->read();

//Get row count
$num = $results->rowCount();

//Check if any Categories
if($num > 0){
	//Category array
	$cate_arr = array();
	$cate_arr['data'] = array();

	while($row  = $results->fetch(PDO::FETCH_ASSOC)){
		extract($row);

		$category_item = array(
		'id' => $id,
		'category' => $category
		);

		// Push to "data"
		array_push($cate_arr['data'], $category_item);
	}

	// Turn to JSON & output
	echo json_encode($cate_arr);
}
else{
	//No categories present
	echo json_encode(
		array('message' => 'No Categories found.')
	);

	
}
?>