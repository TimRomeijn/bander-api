<?php

	class APIDB
	{
		
		public $conn;

		function __construct() {
			// Create database connection
			$this->conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
			// Check connection
			if ($this->conn->connect_error) {
				die("Connection failed: " . $conn->connect_error);
			} 
		}

		// Run a query
		function query($sql) {
			$result = $this->conn->query($sql);
			return $result;
		}
	}
?>