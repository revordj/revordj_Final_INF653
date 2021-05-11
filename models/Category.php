<?php
    class Category {
        //DB stuff
        private $db;
		private $table = 'categories';

        //Properties
        public $id;
        public $category;

        //Constrctor with DB
		public function __construct($database){
			$this->db = $database;
		}

        //Read Categories
		public function read() {
			$query = 'SELECT 
				id,
                category
            FROM
                ' . $this->table . '
            ORDER BY
                id ASC';

		//Prepare Statement
		$statement = $this->db->prepare($query);
		$statement->execute();

		return $statement;
		}

        //Get Single Category
		public function read_single() {
			$query = 'SELECT 
				id,
                category
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
		$this->category = $row['category'];
		}

        //Create Category
		public function create() {
			//create query
			$query = 'INSERT INTO categories
				SET
					category = :category';
					

			//prepare statement
			$statement = $this->db->prepare($query); 

			//Clean data
			$this->category = htmlspecialchars(strip_tags($this->category));
			
			//Bind data
			$statement->bindParam(':category', $this->category);

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

        //Update Category
		public function update() {
			//create query
			$query = 'UPDATE categories
				SET
					category = :category
				WHERE
					id = :id';

			//prepare statement
			$statement = $this->db->prepare($query); 

			//Clean data
			$this->category = htmlspecialchars(strip_tags($this->category));
			$this->id = htmlspecialchars(strip_tags($this->id));

			//Bind data
			$statement->bindParam(':category', $this->category);
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

		//Delete Category
		public function delete(){
			//create query
			$query = 'DELETE FROM categories WHERE id = :id';

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