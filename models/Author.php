<?php
    class Author {
        //DB stuff
        private $db;
		private $table = 'authors';

        //Properties
        public $id;
        public $author;

        //Constrctor with DB
		public function __construct($database){
			$this->db = $database;
		}

        //Read author
		public function read() {
			$query = 'SELECT 
				id,
                author
            FROM
                ' . $this->table . '
            ORDER BY
                id ASC';

		//Prepare Statement
		$statement = $this->db->prepare($query);
		$statement->execute();

		return $statement;
		}

        //Get Single Quote author
		public function read_single() {
			$query = 'SELECT 
				id,
                author
	 		FROM
	 			' . $this->table . '
			WHERE
				id = ?
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
		}

        //Create Author
		public function create() {
			//create query
			$query = 'INSERT INTO authors
				SET
					author = :author';
					

			//prepare statement
			$statement = $this->db->prepare($query); 

			//Clean data
			$this->author = htmlspecialchars(strip_tags($this->author));
			
			//Bind data
			$statement->bindParam(':author', $this->author);

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

		//Update Author
		public function update() {
			//create query
			$query = 'UPDATE authors
				SET
					author = :author
				WHERE
					id = :id';

			//prepare statement
			$statement = $this->db->prepare($query); 

			//Clean data
			$this->author = htmlspecialchars(strip_tags($this->author));
			$this->id = htmlspecialchars(strip_tags($this->id));

			//Bind data
			$statement->bindParam(':author', $this->author);
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

		//Delete Author
		public function delete(){
			//create query
			$query = 'DELETE FROM authors WHERE id = :id';

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