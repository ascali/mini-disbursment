<?php
	// include database and object files
	include_once 'config/Database.php';

	class Migration
	{
	    // database connection and table name
	    private $connection;
	    
	    public function __construct($db){
	        $this->connection = $db;
	    }

		function create_table(){
			$sql = "CREATE TABLE `disburses` (
				`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				`id_disburse` VARCHAR(255) NOT NULL,
				`bank_code` VARCHAR(11) NOT NULL,
				`account_number` VARCHAR(21) NOT NULL,
				`amount` INT(11) NOT NULL,
				`fee` INT(11) NOT NULL,
				`beneficiary_name` VARCHAR(31) NOT NULL,
				`remark` VARCHAR(150) NOT NULL,
				`time_served` DATETIME NOT NULL,
				`status` VARCHAR(11) NOT NULL,
				`receipt` TEXT NULL,
				`timestamp` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
			) COLLATE='utf8_general_ci';";

			if ($this->connection->query($sql) === TRUE) {
			    $callback = "The table created successfully";
			} else {
			    $callback = "Error creating table: " . $this->connection->error;
			}

			$this->connection->close();

			return $callback;
		}
	}

	// get database connection
	$database = new Database();
	$db = $database->getConnection();

	$migration = new Migration($db);
	echo $migration->create_table();

?>