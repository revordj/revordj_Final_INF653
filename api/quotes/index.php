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

//Check for passed parameters
if(isset($_GET['authorId'])){
	if(isset($_GET['categoryId'])){
		$quotes->auth_id = $_GET['authorId'];
		$quotes->cate_id = $_GET['categoryId'];
		$results = $quotes->read_spec();
	}
	else{
		$quotes->auth_id = $_GET['authorId'];
		$results = $quotes->read_author();
	}
}
else if(isset($_GET['categoryId'])){
	//category is set but no author, only pull quotes attributed to the desired category
	$quotes->cate_id = $_GET['categoryId'];
	$results = $quotes->read_category();
}
else if(isset($_GET['limit'])){
	//Limited number of results desired
	$quotes->limit = $_GET['limit'];
	$results = $quotes->read_limit();
}
else{
	//Quotes query for all authors and categories
	$results = $quotes->read();
}


//Get row count
$num = $results->rowCount();

//Check if any Quotes
if($num > 0){
	//Quotes array
	$quotes_arr = array();
	$quotes_arr['data'] = array();

	while($row  = $results->fetch(PDO::FETCH_ASSOC)){
		extract($row);

		$quote_item = array(
		'id' => $id,
		'quote' => $quote,
		'category' => $category,
		'author' => $author
		);

		// Push to "data"
		array_push($quotes_arr['data'], $quote_item);
	}

	// Turn to JSON & output
	echo json_encode($quotes_arr);
}
else{
	//No quotes present
	echo json_encode(
		array('message' => 'No Quotes found.')
	);

	
}
?>