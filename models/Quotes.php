<?php

	class Quotes{
		private $db;
		private $table = 'quotes';

		// Quotes propertites
		public $id;
		public $quote;
		public $auth_id;
		public $author;
		public $cate_id;
		public $category;
		public $limit;

		//Constrctor with DB
		public function __construct($database){
			$this->db = $database;
		}

		//Read All Quotes
		public function read() {
			$query = 'SELECT 
				q.id as id, 
				q.quote as quote, 
	 			q.authorID as author_id,
	 			q.categoryID as category_id,
	 			c.category as category,
	 			a.author as author
	 		FROM
	 			quotes q
	 		LEFT JOIN
	 			categories c ON q.categoryID = c.id
	 		LEFT JOIN
	 			authors a ON q.authorID = a.id
			ORDER BY
				q.id ASC';

		//Prepare Statement
		$statement = $this->db->prepare($query);
		$statement->execute();

		return $statement;
		}

		//Read Quotes by author
		public function read_author() {
			$query = 'SELECT 
				q.id as id, 
				q.quote as quote, 
	 			q.authorID as author_id,
	 			q.categoryID as category_id,
	 			c.category as category,
	 			a.author as author
	 		FROM
	 			quotes q
	 		LEFT JOIN
	 			categories c ON q.categoryID = c.id
	 		LEFT JOIN
	 			authors a ON q.authorID = a.id
			WHERE
				q.authorID = ?
			ORDER BY
				q.id ASC';

		//Prepare Statement
		$statement = $this->db->prepare($query);

		//Bind category ID
		$statement->bindParam(1, $this->auth_id);

		$statement->execute();

		return $statement;
		}

		//Read Quotes by category
		public function read_category() {
			$query = 'SELECT 
				q.id as id, 
				q.quote as quote, 
	 			q.authorID as author_id,
	 			q.categoryID as category_id,
	 			c.category as category,
	 			a.author as author
	 		FROM
	 			quotes q
	 		LEFT JOIN
	 			categories c ON q.categoryID = c.id
	 		LEFT JOIN
	 			authors a ON q.authorID = a.id
			WHERE
				q.categoryID = ?
			ORDER BY
				q.id ASC';

		//Prepare Statement
		$statement = $this->db->prepare($query);

		//Bind category ID
		$statement->bindParam(1, $this->cate_id);

		$statement->execute();

		return $statement;
		}

		//Read Quotes by author and category
		public function read_spec() {
			$query = 'SELECT 
				q.id as id, 
				q.quote as quote, 
	 			q.authorID as author_id,
	 			q.categoryID as category_id,
	 			c.category as category,
	 			a.author as author
	 		FROM
	 			quotes q
	 		LEFT JOIN
	 			categories c ON q.categoryID = c.id
	 		LEFT JOIN
	 			authors a ON q.authorID = a.id
			WHERE
				q.categoryID = :categoryID
			AND
				q.authorID = :authorID
			ORDER BY
				q.id ASC';

		//Prepare Statement
		$statement = $this->db->prepare($query);

		//Bind values
		$statement->bindParam(':authorID', $this->auth_id);
		$statement->bindParam(':categoryID', $this->cate_id);

		$statement->execute();

		return $statement;
		}

		//Read Limited Number of Quotes
		public function read_limit() {
			$query = 'SELECT 
				q.id as id, 
				q.quote as quote, 
	 			q.authorID as author_id,
	 			q.categoryID as category_id,
	 			c.category as category,
	 			a.author as author
	 		FROM
	 			quotes q
	 		LEFT JOIN
	 			categories c ON q.categoryID = c.id
	 		LEFT JOIN
	 			authors a ON q.authorID = a.id
			ORDER BY
				q.id ASC
			LIMIT ';

		//Issues using Limit with a dynamic parameter. Work around of concat the amount to the end of the query string.
			$query = $query . $this->limit;

		//Prepare Statement
		$statement = $this->db->prepare($query);

		//Execute statement
		$statement->execute();

		return $statement;
		}

		//Get Single Quote
		public function read_single() {
			$query = 'SELECT 
				q.id as id, 
				q.quote as quote, 
	 			q.authorID as author_id,
	 			q.categoryID as category_id,
	 			c.category as category,
	 			a.author as author
	 		FROM
	 			quotes q
	 		LEFT JOIN
	 			categories c ON q.categoryID = c.id
	 		LEFT JOIN
	 			authors a ON q.authorID = a.id
			WHERE
				q.id = ?
			LIMIT
				0,1';

		//Prepare Statement
		$statement = $this->db->prepare($query);

		//Bind ID
		$statement->bindParam(1, $this->id);

		//Execute Query
		$statement->execute();

		$row = $statement->fetch(PDO::FETCH_ASSOC);

		//Set Properties
		$this->id = $row['id'];
		$this->author = $row['author'];
		$this->category = $row['category'];
		$this->quote = $row['quote'];
		}

		//Create Quote
		public function create() {
			//create query
			$query = 'INSERT INTO quotes
				SET
					quote = :quote,
					authorID = :authid,
					categoryID = :cateid';

			//prepare statement
			$statement = $this->db->prepare($query); 

			//Clean data
			$this->quote = htmlspecialchars(strip_tags($this->quote));
			$this->auth_id = htmlspecialchars(strip_tags($this->auth_id));
			$this->cate_id = htmlspecialchars(strip_tags($this->cate_id));

			//Bind data
			$statement->bindParam(':quote', $this->quote);
			$statement->bindParam(':authid', $this->auth_id);
			$statement->bindParam(':cateid', $this->cate_id);

			//Execute Query
			if($statement->execute()){
				return true;
			}
			else{
				//Print error if something goes wrong
				printf("Error: %s.\n $statement->error");

				return false;
			}
		}

		//Update Quote
		public function update() {
			//create query
			$query = 'UPDATE quotes
				SET
					quote = :quote,
					authorID = :authid,
					categoryID = :cateid
				WHERE
					id = :id';

			//prepare statement
			$statement = $this->db->prepare($query); 

			//Clean data
			$this->quote = htmlspecialchars(strip_tags($this->quote));
			$this->auth_id = htmlspecialchars(strip_tags($this->auth_id));
			$this->cate_id = htmlspecialchars(strip_tags($this->cate_id));
			$this->id = htmlspecialchars(strip_tags($this->id));

			//Bind data
			$statement->bindParam(':quote', $this->quote);
			$statement->bindParam(':authid', $this->auth_id);
			$statement->bindParam(':cateid', $this->cate_id);
			$statement->bindParam(':id', $this->id);

			//Execute Query
			if($statement->execute()){
				return true;
			}
			else{
				//Print error if something goes wrong
				printf("Error: %s.\n $statement->error");

				return false;
			}
		}

		//Delete Quote
		public function delete(){
			//create query
			$query = 'DELETE FROM quotes WHERE id = :id';

			//prepare statement
			$statement = $this->db->prepare($query); 

			//Clean ID input
			$this->id = htmlspecialchars(strip_tags($this->id));

			//Bind parameteres
			$statement->bindParam(':id', $this->id);
			

			//Execute Query
			if($statement->execute()){
				return true;
			}
			else{
				//Print error if something goes wrong
				printf("Error: %s.\n $statement->error");

				return false;
			}
		}
	}
?>