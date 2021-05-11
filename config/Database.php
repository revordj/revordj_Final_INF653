<?php
	
	class Database {
		//DB Params

		private $dsn = 'mysql:host=localhost;dbname=quotesdb';
		private $username = 'root';
		private $db;

		public function connect() {
			$this->db = null;

			try {
				$this->db = new PDO($this->dsn, $this->username);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
				echo 'Connection Error: ' . $e->getMessage();
			}

			return $this->db;
		}
	}
?>