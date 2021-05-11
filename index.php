<?php

    //Models
    require('models/Quotes.php');
    require('models/Author.php');
    require('models/Category.php');
    require('config/Database.php');

    //check for filters
    if(isset($_GET['category_id']))
    {
        $search_cat = $_GET['category_id'];
    }
    else
    {
        $search_cat = '0';
    }
    if(isset($_GET['author_id']))
    {
        $search_auth = $_GET['author_id'];
    }
    else
    {
        $search_auth = '0';
    }


    //db stuff
    $database = new Database();
    $db = $database->connect();

    //Get quotes from model
    $quotes = new Quotes($db);

    $authors = new Author($db);

    $category = new Category($db);
    
    if($search_cat == '0' && $search_auth == '0'){
        $results = $quotes->read();
    }
    else if($search_cat != '0' && $search_auth == '0'){
        $quotes->cate_id = $search_cat;
        $results = $quotes->read_category();
    }
    else if($search_cat == '0' && $search_auth != '0'){
        $quotes->auth_id = $search_auth;
        $results = $quotes->read_author();
    }
    else{
        $quotes->cate_id = $search_cat;
        $quotes->auth_id = $search_auth;
        $results = $quotes->read_spec();
    }
    
    $auth_results = $authors->read();
    $cate_results = $category->read();

    $num = $results->rowCount();
    $auth_num = $auth_results->rowCount();
    $cate_num = $cate_results->rowCount();

    //Check if any Quotes
    if($num > 0){
	//Quotes array
	$quotes_arr = array();

        while($row  = $results->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'category' => $category,
            'author' => $author
            );

            array_push($quotes_arr, $quote_item);
        }
    }
    else{
        //No quotes present
        echo("No Quotes with this matching Category \n");
    }

    //Check if any Authors
    if($auth_num > 0){
        //Author array
        $author_arr = array();
        
            while($row  = $auth_results->fetch(PDO::FETCH_ASSOC)){
             extract($row);
    
             $Author_item = array(
             'id' => $id,
             'author' => $author
               );
            
            // Push to "data"
            array_push($author_arr, $Author_item);
        }
    }
    else{
         //No Authors present
         echo("No Quotes with this matching Author \n");
    }

    //Check if any Categories
    if($cate_num > 0){
	//Category array
	    $cate_arr = array();

	    while($row  = $cate_results->fetch(PDO::FETCH_ASSOC)){
		    extract($row);

		    $category_item = array(
		    'id' => $id,
		    'category' => $category
		    );

		
		    array_push($cate_arr, $category_item);
	    }
    }
    else{
	//No categories present
         array_push($cate_arr, "No Categories Found");
    }
    include('view/quote_list.php');
?>

