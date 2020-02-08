<?php

	class Database{
	  
	    // specify your own database credentials
	    private $host = "localhost";
	    private $db_name = "tes";
	    private $username = "root";
	    private $password = "root";
	    public $connection;
	  
	    // get the database connection
	    public function getConnection(){
	  
	        $this->connection = null;
	  
	        try{
	            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
	        }catch(PDOException $exception){
	            echo "Connection error: " . $exception->getMessage();
	        }
	  
	        return $this->connection;
	    }
	}
 ?>