<?php

	class Database{
	  
	    private $servername = "localhost";
	    private $dbname = "tes";
	    private $username = "root";
	    private $password = "root";
	    
	    public $connection;
	  
	    public function getConnection(){
			$this->connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
			
			if ($this->connection->connect_error) {
			    die("Connection failed: " . $this->connection->connect_error);
			}

	        return $this->connection;	  
	    }
	}
 ?>