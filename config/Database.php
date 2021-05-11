<?php
	
	class Database {
		//DB Params

		private $dsn = 'mysql:host=y5svr1t2r5xudqeq.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=ebgthxuzb8tnkfwr';
		private $username = 'ydvbdiox0kk7kzdm';
		private $password = 'x72oldqt3rvcj2yb';
		private $db;

		public function connect() {
			$this->db = null;

			try {
				$this->db = new PDO($this->dsn, $this->username, $this->password);
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $e){
				echo 'Connection Error: ' . $e->getMessage();
			}

			return $this->db;
		}
	}
?>
